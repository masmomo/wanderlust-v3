/*
Copyright (c) 2003-2011, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/
var pathArray = window.location.pathname.split( '/admin' );
var path = pathArray[0];

if(path == "") { path = "/admin"; } else { path = path+'/admin' ;}


CKEDITOR.editorConfig = function(config) {

   config.filebrowserBrowseUrl      = path+'/xfinder/browse.php?type=files';
   config.filebrowserImageBrowseUrl = path+'/xfinder/browse.php?type=images';
   //config.filebrowserFlashBrowseUrl = path+'/xfinder/browse.php?type=flash';
   config.filebrowserUploadUrl      = path+'/xfinder/upload.php?type=files';
   config.filebrowserImageUploadUrl = path+'/xfinder/upload.php?type=images';
   //config.filebrowserFlashUploadUrl = path+'/xfinder/upload.php?type=flash';
   
config.toolbar = 'Full';
 
config.toolbar_Full =
[
	//{ name: 'document', items : [ 'Source','-','Save','NewPage','DocProps','Preview','Print','-','Templates' ] },
	{ name: 'document', items : [ 'Source'] },
	//{ name: 'clipboard', items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo' ] },
	{ name: 'insert', items : [ 'Image','Table']},//,'Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak','Iframe' ] },
	'/',
	
	//{ name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },
	{ name: 'basicstyles', items : [ 'Bold'] },
	
	//{ name: 'paragraph', items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CreateDiv','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl' ] },
	{ name: 'paragraph', items : [ 'JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'] },
	//{ name: 'links', items : [ 'Link','Unlink','Anchor' ] },
	//{ name: 'editing', items : [ 'Find','Replace','-','SelectAll','-','SpellChecker', 'Scayt' ] },
	//{ name: 'forms', items : [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
	//{ name: 'colors', items : [ 'TextColor','BGColor' ] },
	//{ name: 'tools', items : [ 'Maximize', 'ShowBlocks','-','About' ] },
	'/',
	
	//{ name: 'styles', items : [ 'Styles','Format','Font','FontSize' ] }
	{ name: 'styles', items : [ 'Format'] }

];


};
