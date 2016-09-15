/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

// CKEDITOR.editorConfig = function( config ) {
// 	// Define changes to default configuration here.
// 	// For complete reference see:
// 	// http://docs.ckeditor.com/#!/api/CKEDITOR.config
// // Use the classes 'AlignLeft', 'AlignCenter', 'AlignRight', 'AlignJustify'
// 	config.justifyClasses = [ 'AlignLeft', 'AlignCenter', 'AlignRight', 'AlignJustify' ];
//
// 	// The toolbar groups arrangement, optimized for two toolbar rows.
// 	// config.toolbarGroups = [
// 	// 	{ name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
// 	// 	{ name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
// 	// 	{ name: 'links' },
// 	// 	{ name: 'insert' },
// 	// 	{ name: 'forms' },
// 	// 	{ name: 'tools' },
// 	// 	{ name: 'document',	   groups: [ 'mode', 'document', 'doctools' ] },
// 	// 	{ name: 'others' },
// 	// 	'/',
// 	// 	{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
// 	// 	{ name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
// 	// 	{ name: 'styles' },
// 	// 	{ name: 'colors' },
// 	// 	{ name: 'about' }
// 	// ];
//
// 	config.toolbar = [
// 		{ name: 'document', items: [ 'Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates' ] },
// 		{ name: 'clipboard', items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
// 		{ name: 'editing', items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
// 		{ name: 'forms', items: [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
// 		'/',
// 		{ name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat' ] },
// 		{ name: 'paragraph', items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ] },
// 		{ name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
// 		{ name: 'insert', items: [ 'Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe' ] },
// 		'/',
// 		{ name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
// 		{ name: 'colors', items: [ 'TextColor', 'BGColor' ] },
// 		{ name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] },
// 		{ name: 'about', items: [ 'About' ] }
// 	];
//
//
// 	// Remove some buttons provided by the standard plugins, which are
// 	// not needed in the Standard(s) toolbar.
// 	config.removeButtons = 'Underline,Subscript,Superscript';
//
// 	// Set the most common block elements.
// 	config.format_tags = 'p;h1;h2;h3;pre';
//
// 	// Simplify the dialog windows.
// 	config.removeDialogTabs = 'image:advanced;link:advanced';
//
// 	config.skin = 'moono';
// };

CKEDITOR.editorConfig = function( config ) {
	config.toolbarGroups = [
		{ name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
		{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
		{ name: 'forms', groups: [ 'forms' ] },
		'/',
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
		{ name: 'links', groups: [ 'links' ] },
		{ name: 'insert', groups: [ 'insert' ] },
		'/',
		{ name: 'styles', groups: [ 'styles' ] },
		{ name: 'colors', groups: [ 'colors' ] },
		{ name: 'tools', groups: [ 'tools' ] },
		{ name: 'others', groups: [ 'others' ] },
		{ name: 'about', groups: [ 'about' ] }
	];

	config.removeButtons = 'BidiLtr,Link,Flash,Table,HorizontalRule,Smiley,SpecialChar,Iframe,PageBreak,Anchor,Unlink,Blockquote,CreateDiv,Outdent,Indent,Styles,TextColor,Maximize,About,ShowBlocks,BGColor,Format,Font,FontSize,Bold,RemoveFormat,Italic,Underline,Strike,Subscript,Superscript,NumberedList,BulletedList,Form,Scayt,SelectAll,Find,Undo,Cut,Templates,Save,Source,NewPage,Preview,Print,Copy,Redo,Replace,Paste,PasteText,PasteFromWord,Radio,Checkbox,TextField,Textarea,Select,Button,ImageButton,HiddenField,BidiRtl,Language';
};