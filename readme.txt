=== Media Library Gallery ===
Contributors: ixmenhancement
Donate link: http://www.amazon.fr/gp/registry/wishlist/3K72A89EBXOA4/
Tags: Media, Library, Gallery, Images, Photos, Attachment, Upload, Posts, Pages
Requires at least: 2.3
Tested up to: 2.8.6
Stable tag: 1.0.2

Automatically creates a gallery with every images posts have in attachment.

== Description ==

**Media Library Gallery** automatically creates a gallery with every images posts have in attachment. Support thickbox. To include the gallery in a page, simply write in the post: `[media-library-gallery]`. You can also customize: see the documentation for more information!

You always tried to easily make a page or a post to display the content of your Media Library but you never found a way to make it?

**Media Library Gallery** is the plugin you dreamed for! You just have to install it on your own WordPress installation, to select pages and/or posts where you want to include your gallery, and you’re done! More, the plugin is thickbox ready!

[**Morbleu !**](http://www.morbleu.com/) already uses it! Just have a look to their [Galerie des Glaces](http://www.morbleu.com/galerie-des-glaces/)...

== Installation ==

1. Upload the directory `media-library-gallery` into your `/wp-content/plugins/` directory.
1. Activate the plugin through the 'Plugins' menu in WordPress.
1. Now select the page and/or the post where you want to include your gallery. When you find a room in your page just write something like: `[media-library-gallery]`.
1. Or use the assistant which should be in the toolbar of you editor!
1. Then, you can customize:

* `exclude` to exclude some attachment posts of the gallery. It works both with posts'id and attachments' pages' id!
* `nb` determines how many pictures you want for a gallery page. Default is 20.
* `cols` determines how many pictures you want for a row. Default is everything on the same row. Depending of your theme, images should be automatically displayed on a new row when there is no more room on the width.
* `tag` allows to filter posts by tags. `tag="hello,world"` will give attachments from posts tagged with `hello` or `world` ; `tag="hello world"` will give attachments from posts tagged with `hello`and `world`.
* `category` makes exactly the same, but for categories. Take care! If you use in the same time the `tag` and the `category` option it makes an logical AND between the two.
* `orderby` should be one of the following: `date`, `author`, `title`, `modified`, `menu_order`, `parent`, `ID`, `rand`. See the [WordPress](http://www.wordpress.org/) [get_posts](http://codex.wordpress.org/Function_Reference/get_posts) documentation for more information.
* `order` should be `ASC` or `DESC`.
* So... `[media-library-gallery exclude="12,13,14" nb=20 cols=4 tag="photos" category="holiday" orderby="date" order="DESC"]` should display images from posts tagged with `photos` from the `holiday` category, with `20` images a page, `4` images a row. Most recent images should be displayed first. And it won't display images related to IDS 12, 13, 14.

You can also call directly the plugin in your template code. Call the `media_library_gallery_library()` function and give it the options you want as an array. For instance `media_library_gallery_library(array("nb"=>2, "cols"=>1));`. Could be useful to display it in a sidebar!

== Frequently Asked Questions ==

= I get some PHP parse errors! Why? =

Probably because you're using PHP4. You should upgrade to PHP5. You know what? We will dealing soon with PHP6, so don't be late!

You can also upgrade your `[media-library-gallery]` to the latest version because it should be now compatible with PHP4.

= OMG! Your plugin is probably the best one I ever used! But... I need more! Could you add this feature? =

Why not? Just ask and we'll try!

== Screenshots ==

1. Just add a `[media-library-gallery]` tag in a page or a post.
2. You can also use the wizard! Click on this button!
3. Customize how you want the plugin to be displayed.
4. Check this wonderful tag the wizard built automatically for you!
5. Now your page should display like that! Awesome!
6. *Thickbox* ready! \o/

== Changelog ==

= 1.0.2 =
* Now compatible with PHP4. Enjoy!
* Use the builtin `shortcode` API to detect the `[media-library-gallery]` tag.
* Doesn't display attachments from draft posts anymore.
* You can now set up a number of columns (i.e.: the number of images you would like for a row) with the `cols` param.
* You can filter by tag the attachment's posts with the `tag` param.
* The same for categories with the `category` param.
* You can order the images with the `orderby` param.
* You can sort them with the `order` param.
* A button and a special dialog have been added in the `tinyMCE` editor.
* Fix multiple pages issue.
* Display titles only on one row.

= 0.0.1 =
* First release.
== Upgrade Notice ==

= 1.0.2 =
Fix several minor issues (CSS, multiple pages), add a toolbar icon, add multiple configuration params.


