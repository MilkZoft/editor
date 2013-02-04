<?php
require_once('config.php');


		
$allok=false;
$uploadedfileurl='';


function sendResponse($response){
// 	if ($response[0]===true){
// 		echo "<script type=\"text/javascript\">window.parent.CKEDITOR.tools.callFunction(2, '".$response[1]."', '');</script>";
// 	} else {
// 		echo "<script type=\"text/javascript\">window.parent.CKEDITOR.tools.callFunction(2,'' , '".$response[1]."');</script>";
// 	}
	$CKEditorFuncNum = (empty($_GET['CKEditorFuncNum'])?-1:$_GET['CKEditorFuncNum']);
	if ($CKEditorFuncNum==-1) echo  "<script type=\"text/javascript\">console.log('something went totally wrong')</script>";
	elseif ($response[0]===true && $CKEditorFuncNum !=-1){
		echo "<script type=\"text/javascript\">window.parent.CKEDITOR.tools.callFunction(".$CKEditorFuncNum.", '".$response[1]."', '');</script>";
	} else {
		echo "<script type=\"text/javascript\">window.parent.CKEDITOR.tools.callFunction(".$CKEditorFuncNum.",'' , '".$response[1]."');</script>";
	}
}


function upload() {
	global $config;
	
	if (!empty($_GET) && isset($_GET['type']) && array_key_exists($_GET['type'],$config['ResourceType']))
		$rType=$config['ResourceType'][$_GET['type']];
	else 
		return array(false,'wrong request');
	
	if (!empty($_FILES) && $_FILES['upload']['size']>0 && ($_FILES['upload']['size'] < $rType['maxSize'] || $rType['maxSize']==0)) {
		$tmp=explode('.',$_FILES['upload']['name']);
		$type=$tmp[count($tmp)-1];
		if (!in_array(strtolower($type), array_map('strtolower', explode(',',$rType['allowedExtensions']))))
			return array(false,'wrong type');
	} else 
		return array(false,'wrong size');
	if ($_FILES["upload"]["error"] > 0)
		return array(false,'upload error');
	
	$tmpname=$_FILES['upload']['name'];
	$i=1;
	while (is_file($rType['directory'].'/'.$tmpname)) {
		$sourceFileArr=explode('.',$_FILES['upload']['name']);
		$sourceFileArr[count($sourceFileArr)-2].='('.$i.')';
		$tmpname=implode('.',$sourceFileArr);
		$i++;
	}
	
	$filepath=$rType['directory'].'/'.$tmpname;
	$fileurl=$rType['url'].'/'.$tmpname;
    move_uploaded_file($_FILES['upload']['tmp_name'], $filepath);
    
    if ($_GET['type']=='Images' && isset($_GET['resize'])) {
    	if (!resizeImg($filepath, $config['ResizedImages']['maxWidth'], $config['ResizedImages']['maxHeight'], $config['ResizedImages']['quality'], true, isset($_GET['resizeOnLess'])))
    		return array(false,'cannot resize');
    }
    
	if ($_GET['type']=='Images' && isset($_GET['makeThumb'])) {		
		if (!resizeImg($filepath, $config['Thumbnails']['maxWidth'], $config['Thumbnails']['maxHeight'], $config['Thumbnails']['quality'], false, true))
			return array(false,'cannot make thumb');
	}
	return array(true,$fileurl);
}


function resizeImg($sourceFile, $width = 200, $height = 140, $quality = 90, $resizeself=false, $resizeOnLess=true)
    {
        $sourceImageAttr = @getimagesize($sourceFile);
        if ($sourceImageAttr === false) {
            return false;
        }

        switch ($sourceImageAttr['mime'])
        {
            case 'image/gif':
                {
                    if (@imagetypes() & IMG_GIF) {
                        $oImage = @imagecreatefromgif($sourceFile);
                    } else {
                        $ermsg = 'GIF images are not supported';
                    }
                }
                break;
            case 'image/jpeg':
                {
                    if (@imagetypes() & IMG_JPG) {
                        $oImage = @imagecreatefromjpeg($sourceFile) ;
                    } else {
                        $ermsg = 'JPEG images are not supported';
                    }
                }
                break;
            case 'image/png':
                {
                    if (@imagetypes() & IMG_PNG) {
                        $oImage = @imagecreatefrompng($sourceFile) ;
                    } else {
                        $ermsg = 'PNG images are not supported';
                    }
                }
                break;
            case 'image/wbmp':
                {
                    if (@imagetypes() & IMG_WBMP) {
                        $oImage = @imagecreatefromwbmp($sourceFile);
                    } else {
                        $ermsg = 'WBMP images are not supported';
                    }
                }
                break;
            default:
                $ermsg = $sourceImageAttr['mime'].' images are not supported';
                break;
        }

        if (isset($ermsg) || false === $oImage) {
            return false;
        }

		
		$xscale=imagesx($oImage)/$width;
		$yscale=imagesy($oImage)/$height;
		
		if (!$resizeOnLess && $xscale<1 &&  $yscale<1) return true;
		
		if ($yscale>$xscale){
			$new_width = round(imagesx($oImage) * (1/$yscale));
			$new_height = round(imagesy($oImage) * (1/$yscale));
		}
		else {
			$new_width = round(imagesx($oImage) * (1/$xscale));
			$new_height = round(imagesy($oImage) * (1/$xscale));
		}
		$new_image = imagecreatetruecolor($new_width, $new_height);
		imagecopyresampled($new_image, $oImage, 0, 0, 0, 0, $new_width, $new_height, imagesx($oImage), imagesy($oImage));
		$oImage = $new_image;
		
		if (!$resizeself) {
			$sourceFileArr=explode('.',$sourceFile);
			$sourceFileArr[count($sourceFileArr)-2].='_small';
			$sourceFile=implode('.',$sourceFileArr);
		} else {
			unlink( $sourceFile);
		}

        switch ($sourceImageAttr['mime'])
        {
            case 'image/gif':
                imagegif($oImage, $sourceFile);
                break;
            case 'image/jpeg':
                imagejpeg($oImage, $sourceFile, $quality);
                break;
            case 'image/png':
                imagepng($oImage, $sourceFile);
                break;
            case 'image/wbmp':
                imagewbmp($oImage, $sourceFile);
                break;
        }

        @imageDestroy($oImage);
        @imageDestroy($new_image);
		return true;
    }

sendResponse(upload());
		
//	print_r($_FILES);



?>