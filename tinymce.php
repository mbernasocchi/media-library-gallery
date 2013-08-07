<?php
	require_once('../../../wp-load.php');
	header('Content-Type: text/html; charset=' . get_bloginfo('charset'));
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Media Library Gallery</title>
	<script type="text/javascript" src="<?php print get_option('siteurl'); ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
	<script type="text/javascript">

	var MediaLibraryGallery = 
	{
		fields: ["exclude", "nb", "cols", "tag", "category", "orderby", "order"],

		submit: function()
		{
			var fields = MediaLibraryGallery.fields;
			var tag = "[media-library-gallery";

			for(var field in fields)
			{
				var value = document.getElementById(fields[field]).value.toString().replace(/^\s+/, "").replace(/\s+$/, "");

				if(value != "")
				{
					tag += " " + fields[field] + "=\"" + value + "\"";
				}
			}

			tag += "]";

			tinyMCEPopup.execCommand("mceInsertContent", 0, tag);

			tinyMCEPopup.close();

			return false;
		}
	};

	</script>
</head>

<body>

<form name="params" onsubmit="return MediaLibraryGallery.submit();" onreset="return tinyMCEPopup.close();" action="#">

	<div class="title">Media Library Gallery</div>
	<div>Every fields are optional</div>
	<br/>
	<table align="center">
		<tr>
			<td><label for="exclude">Exclude Posts</label>:</td>
			<td><input id="exclude" name="exclude" type="text" /></td>
		</tr>
		<tr>
			<td><label for="nb">Images by Page</label>:</td>
			<td><input id="nb" name="nb" type="text" /></td>
		</tr>
		<tr>
			<td><label for="cols">Images by Row</label>:</td>
			<td><input id="cols" name="cols" type="text" /></td>
		</tr>
		<tr>
			<td><label for="tag">Tag</label>:</td>
			<td>
				<select id="tag" name="tag">
					<option value=""></option>
					<?php
						$tags = get_tags();
						
						foreach($tags as $tag)
						{
							print "<option value=\"{$tag->slug}\">{$tag->name}</option>";
						}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td><label for="category">Category</label>:</td>
			<td>
				<select id="category" name="category">
					<option value=""></option>
					<?php
						$categories = get_categories();
						
						foreach($categories as $category)
						{
							print "<option value=\"{$category->slug}\">{$category->name}</option>";
						}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td><label for="orderby">Order By</label>:</td>
			<td>
				<select id="orderby" name="orderby">
					<option value=""></option>
					<option value="date">date</option>
					<option value="author">author</option>
					<option value="title">title</option>
					<option value="modified">modified</option>
					<option value="menu_order">menu_order</option>
					<option value="parent">parent</option>
					<option value="ID">ID</option>
					<option value="rand">rand</option>
				</select>
			</td>
		</tr>
		<tr>
			<td><label for="order">Order</label>:</td>
			<td>
				<select id="order" name="order">
					<option value=""></option>
					<option value="ASC">ASC</option>
					<option value="DESC">DESC</option>
				</select>
			</td>
		</tr>
		<tr>
			<td colspan="2" align="center">
				<br/>
				<input type="submit" value="Insert" />
				<input type="reset" value="Cancel" />
			</td>
		</tr>
	</table>
</form>
</body>
</html>
