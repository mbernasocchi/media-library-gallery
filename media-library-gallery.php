<?php
/*
Plugin Name: Media Library Gallery
Plugin URI: http://www.cybwarrior.com/media-library-gallery/
Description: Automatically creates a gallery with every images posts have in attachment. Support thickbox. To include the gallery in a page, simply write in the post: [media-library-gallery] and customize! Or much better: use the new toolbox in the tinyMCE editor!
Version: 1.0.2
Author: Raphael Verchere
Author URI: http://www.cybwarrior.com
*/

/*  Copyright 2008  Raphael Verchere  (email : r dott verchere [ aatt ] ixme doot net)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

$GLOBALS["MEDIA_LIBRARY_GALLERY_BASEPATH"] = get_option('siteurl') . "/wp-content/plugins/" . dirname(plugin_basename(__FILE__));

function media_library_gallery_initialize()
{
	add_thickbox();

	add_action("wp_head", "media_library_gallery_head");
	add_shortcode("media-library-gallery", "media_library_gallery_library");

	media_library_gallery_tinymce();
}

function media_library_gallery_tinymce()
{
	if(!current_user_can('edit_posts') && !current_user_can('edit_pages'))
		return;

	if(get_user_option('rich_editing') == 'true')
	{
		add_filter("mce_external_plugins", "media_library_gallery_mce_plugins");
		add_filter('mce_buttons', 'media_library_gallery_mce_buttons');
	}
}

function media_library_gallery_mce_plugins($plugin_array)
{
	$plugin_array['mediaLibraryGallery'] = $GLOBALS["MEDIA_LIBRARY_GALLERY_BASEPATH"] . '/tinymce.js';
	return $plugin_array;
}

function media_library_gallery_mce_buttons($buttons)
{
	array_push($buttons, "separator", "mediaLibraryGallery");
	return $buttons;
}

function media_library_gallery_head()
{
	print '<link rel="stylesheet" href="' . $GLOBALS["MEDIA_LIBRARY_GALLERY_BASEPATH"] . '/media-library-gallery.css" type="text/css" media="screen" />';
}

function media_library_gallery_library($args = array())
{
	global $wpdb;
	static $id = 1;

	$html = "";
	
	$get_posts_args = array(
		"showposts"=>-1,
		"what_to_show"=>"posts",
		"post_status"=>"inherit",
		"post_type"=>"attachment",
		"orderby"=>"date",
		"order"=>"DESC",
		"post_mime_type"=>"image/jpeg,image/jpg,image/gif,image/png");

	$items_by_page = abs((int)$args["nb"]);
	$items_by_row = abs((int)$args["cols"]);
	$use_permalink = (get_option('permalink_structure') != '');
	
	if($items_by_page < 1)
	{
		$items_by_page = 20;
	}
	
	if(!empty($args["orderby"]))
	{
		$get_posts_args["orderby"] = $args["orderby"];
	}
	
	if(!empty($args["order"]))
	{
		$get_posts_args["order"] = $args["order"];
	}
	
	if(!empty($args["exclude"]))
	{
		$get_posts_args["exclude"] = $args["exclude"];
	}

	$posts = get_posts($get_posts_args);


	if($nb_items = count($posts))
	{
		$max_page = ceil($nb_items / $items_by_page);

		$page = (int)get_query_var("page");

		if($page < 1 || $page > $max_page)
		{
			$page = 1;
		}

		$begin = ($page - 1) * $items_by_page;
		$end = $begin + $items_by_page;
		
		
		if(!empty($args["tag"]))
		{
			$tags = explode(" ", trim($args["tag"]));
			
			foreach($tags as $u=>$tag)
			{
				if(trim($tag) == "")
				{
					unset($tag);
				}
				else
				{
					$tags[$u] = explode(",", $tag);
				}
			}
		}
		else
		{
			$tags = array();
		}
		
		
		if(!empty($args["category"]))
		{
			$categories = explode(" ", trim($args["category"]));
			
			foreach($categories as $u=>$category)
			{
				if(trim($category) == "")
				{
					unset($category);
				}
				else
				{
					$categories[$u] = explode(",", $category);
				}
			}
		}
		else
		{
			$categories = array();
		}

		


		$html_nav_bar = "<div class='mlg-navbar'><strong>" . __("Pages") . "</strong> : ";

		if($page > 1)
		{
			$html_nav_bar .= " <a href='" . get_permalink() . ($page - 1) . "/'>&laquo;</a> ";
		}

		for($i = 1; $i <= $max_page; $i++)
		{
			if($i == $page)
			{
				$html_nav_bar .= " <strong>$i</strong> ";
			}
			else
			{
				if($use_permalink)
				{
					if(preg_match("/.*?\/$/", get_permalink()))
					{
						$url = get_permalink() . "$i/";
					}
					else
					{
						$url = get_permalink() . "/$i/";
					}
				}
				else
				{
					$url = get_permalink() . "&amp;page=$i";
				}
			
				$html_nav_bar .= " <a href='$url'>$i</a> ";
			}
		}

		if($page < $max_page)
		{
			$html_nav_bar .= " <a href='" . get_permalink() . ($page + 1) . "/'>&raquo;</a> ";
		}

		$html_nav_bar .= "</div>";


		$html_row = "";
		$html .= "<div class='media-library-gallery'>";
		$html .= $html_nav_bar;

		for($i = $begin; $i < $end; $i++)
		{
			$post = $posts[$i];
			$parent = get_post($post->post_parent);
			
			$tag_ok = true;
			$category_ok = true;
		
			foreach($tags as $u=>$tag)
			{
				if(!has_tag($tag, $parent))
				{
					$tag_ok = false;
				}
			}
			
			foreach($categories as $u=>$category)
			{
				if(!in_category($category, $parent))
				{
					$category_ok = false;
				}
			}


			if(($src = wp_get_attachment_thumb_url($post->ID)) 
				&& $parent->post_status == "publish"
				&& !preg_match("/\W(" . $parent->ID . ")\W/", " {$args["exclude"]} ")
				&& $tag_ok
				&& $category_ok)
			{
				$html_row .= "<div class='mlg-preview'>";
					$html_row .= "<div class='mlg-title'><a class='thickbox' rel='media_library_gallery_$id' href='" . wp_get_attachment_url($post->ID) . "' title='" . get_the_title($post->ID) . "'><strong>" . get_the_title($post->ID) . "&nbsp;[+]</strong></a></div>";
					$html_row .= "<div class='mlg-img'><a href='" . get_attachment_link($post->ID) . "' title='" . get_the_title($post->ID) . "'><img src='$src' alt='" . get_the_title($post->ID) . "' /></a></div>";
					$html_row .= "<div class='mlg-actions'>";
						$html_row .= "&ldquo;<a href='" . get_permalink($post->post_parent) . "'>" . get_the_title($post->post_parent) . "</a>&rdquo;<br/>";
					$html_row .= "</div>";
				$html_row .= "</div>";

				$j++;
			}
			
			
			if($items_by_row)
			{
				if($j >= $items_by_row)
				{
					$html .= "<div class='mlg-row'>$html_row</div>";
					$html_row = "";
					$j = 0;
				}
				else
				{
				}
			}
			else
			{
				$html .= $html_row;
				$html_row = "";
			}
		}

		$html .= $html_nav_bar;
		$html .= "</div>";
	}

	$id++;

	return $html;
}

add_action("init", "media_library_gallery_initialize");
