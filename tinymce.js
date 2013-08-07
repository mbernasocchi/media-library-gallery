(function()
{
	tinymce.create("tinymce.plugins.mediaLibraryGallery",
	{
		init: function(ed, url)
		{
			ed.addCommand("mediaLibraryGallery", function()
			{
				ed.windowManager.open(
				{
					url: url + "/tinymce.php",
					width: 280,
					height: 290,
					inline: 3
				});
			});
			
			ed.addButton("mediaLibraryGallery",
			{
				title: "Media Library Gallery",
				image: url + "/image.gif",
				cmd: "mediaLibraryGallery"
			});
		}
	});
	
	tinymce.PluginManager.add("mediaLibraryGallery", tinymce.plugins.mediaLibraryGallery);
})();
