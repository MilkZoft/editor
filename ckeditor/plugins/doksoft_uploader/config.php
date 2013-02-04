<?php

$baseUrl = 'ckeditor/plugins/doksoft_uploader/userfiles/'; // final userfiles relative URL path. Like in "www.example.com/ckeditor/doksoft_uploader/userfiles/"
$baseDir = dirname(__FILE__).'/userfiles/'; // final userfiles (absolute or relative) Dir path. Like in "/var/www/ckeditor/doksoft_uploader/userfiles/"

$config['Images'] = Array(
		'maxWidth' => 1600,
		'maxHeight' => 1200,
		'quality' => 80);

$config['ResizedImages'] = Array(
		'maxWidth' => 640,
		'maxHeight' => 480,
		'quality' => 80);

$config['Thumbnails'] = Array(
		'maxWidth' => 200,
		'maxHeight' => 140,
		'quality' => 80);
		

$config['ResourceType']['Files'] = Array(
		'url' => $baseUrl . 'files',
		'directory' => $baseDir . 'files',
		'maxSize' => 0, // maxSize in bytes, 0 for any
		'allowedExtensions' => '7z,aiff,asf,avi,bmp,csv,doc,docx,fla,flv,gif,gz,gzip,jpeg,jpg,mid,mov,mp3,mp4,mpc,mpeg,mpg,ods,odt,pdf,png,ppt,pptx,pxd,qt,ram,rar,rm,rmi,rmvb,rtf,sdc,sitd,swf,sxc,sxw,tar,tgz,tif,tiff,txt,vsd,wav,wma,wmv,xls,xlsx,zip');

$config['ResourceType']['Images'] = Array(
		'url' => $baseUrl . 'images',
		'directory' => $baseDir . 'images',
		'maxSize' => 16*1024*1024, // maxSize in bytes, 0 for any
		'allowedExtensions' => 'bmp,gif,jpeg,jpg,png');
		
?>