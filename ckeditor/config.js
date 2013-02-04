/**
 * @license Copyright (c) 2003-2012, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function(config) {
	config.extraPlugins = 'codemirror,insertpre';
	CKEDITOR.config.insertpre_class = 'prettyprint';
	CKEDITOR.config.insertpre_style = 'background-color:#F8F8F8;border:1px solid #DDD;padding:10px;';
	config.tabSpaces = 8;
};