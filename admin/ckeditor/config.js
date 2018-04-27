/**
 * @license Copyright (c) 2003-2017, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	config.extraPlugins = 'autogrow';
	config.allowedContent = true;
	//config.contentsCss = [ '<?php echo $absolutePath;?>css/bootstrap.min.css', '<?php echo $absolutePath;?>css/main.css','<?php echo $absolutePath;?>css/animations.css','<?php echo $absolutePath;?>css/fonts.css' ];
	//config.extraAllowedContent = '*(*);*{*}';
	
	config.toolbar = 'MyToolbar';
	 //config.height = 100; 
	config.toolbar_MyToolbar =
	[
		{ name: 'styles', items : [ '-','Cut','Copy','Paste','-','Font','FontSize','Format','TextColor','Bold','Italic','Underline','-','NumberedList','BulletedList','-','Table','Image','Iframe','Link','-','Source'] }
	];
	
	config.filebrowserBrowseUrl = 'kcfinder/browse.php?opener=ckeditor&type=files';
   config.filebrowserImageBrowseUrl = 'kcfinder/browse.php?opener=ckeditor&type=images';
   config.filebrowserFlashBrowseUrl = 'kcfinder/browse.php?opener=ckeditor&type=flash';
   config.filebrowserUploadUrl = 'kcfinder/upload.php?opener=ckeditor&type=files';
   config.filebrowserImageUploadUrl = 'kcfinder/upload.php?opener=ckeditor&type=images';
   config.filebrowserFlashUploadUrl = 'kcfinder/upload.php?opener=ckeditor&type=flash';
};
