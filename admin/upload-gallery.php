<?php
session_start();
include('config.php');
/**
 * upload.php
 *
 * Copyright 2009, Moxiecode Systems AB
 * Released under GPL License.
 *
 * License: http://www.plupload.com/license
 * Contributing: http://www.plupload.com/contributing
 */

// HTTP headers for no cache etc
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

$gTitleId=$_SESSION["gTitleId"];
//unset($_SESSION["gTitleId"]);
// Settings
//$targetDir = ini_get("upload_tmp_dir") . DIRECTORY_SEPARATOR . "plupload";
$targetDir = '../uploads/images/gallery/'.$gTitleId.'/';

//$cleanupTargetDir = false; // Remove old files
//$maxFileAge = 60 * 60; // Temp file age in seconds

// 5 minutes execution time
@set_time_limit(5 * 60);

// Uncomment this one to fake upload time
// usleep(5000);

// Get parameters
$chunk = isset($_REQUEST["chunk"]) ? $_REQUEST["chunk"] : 0;
$chunks = isset($_REQUEST["chunks"]) ? $_REQUEST["chunks"] : 0;
$fileName = isset($_REQUEST["name"]) ? $_REQUEST["name"] : '';

// Clean the fileName for security reasons
$fileName = preg_replace('/[^\w\._]+/', '', $fileName);

// Make sure the fileName is unique but only if chunking is disabled
if ($chunks < 2 && file_exists($targetDir . DIRECTORY_SEPARATOR . $fileName)) {
	$ext = strrpos($fileName, '.');
	$fileName_a = substr($fileName, 0, $ext);
	$fileName_b = substr($fileName, $ext);

	$count = 1;
	while (file_exists($targetDir . DIRECTORY_SEPARATOR . $fileName_a . '_' . $count . $fileName_b))
		$count++;

	$fileName = $fileName_a . '_' . $count . $fileName_b;
}

// Create target dir
if (!file_exists($targetDir))
	@mkdir($targetDir, 0777, true);

// Remove old temp files
/* this doesn't really work by now
	
if (is_dir($targetDir) && ($dir = opendir($targetDir))) {
	while (($file = readdir($dir)) !== false) {
		$filePath = $targetDir . DIRECTORY_SEPARATOR . $file;

		// Remove temp files if they are older than the max age
		if (preg_match('/\\.tmp$/', $file) && (filemtime($filePath) < time() - $maxFileAge))
			@unlink($filePath);
	}

	closedir($dir);
} else
	die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');
*/

// Look for the content type header
if (isset($_SERVER["HTTP_CONTENT_TYPE"]))
	$contentType = $_SERVER["HTTP_CONTENT_TYPE"];

if (isset($_SERVER["CONTENT_TYPE"]))
	$contentType = $_SERVER["CONTENT_TYPE"];

// Handle non multipart gallery older WebKit versions didn't support multipart in HTML5
if (strpos($contentType, "multipart") !== false) {
	$names=$_FILES['file']['tmp_name'];
	if (1) {
		// Open temp file
		$out = fopen($targetDir . DIRECTORY_SEPARATOR . $fileName, $chunk == 0 ? "wb" : "ab");
		if ($out) {
			// Read binary input stream and append it to temp file
			$in = fopen($_FILES['file']['tmp_name'], "rb");

			if ($in) {
				while ($buff = fread($in, 4096))
					fwrite($out, $buff);
			} else
				die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
			fclose($in);
			fclose($out);
			@unlink($_FILES['file']['tmp_name']);
		} else
			die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
	} else
		die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
} else {
	// Open temp file
	$out = fopen($targetDir . DIRECTORY_SEPARATOR . $fileName, $chunk == 0 ? "wb" : "ab");
	if ($out) {
		// Read binary input stream and append it to temp file
		$in = fopen("php://input", "rb");

		if ($in) {
			while ($buff = fread($in, 4096))
				fwrite($out, $buff);
		} else
			die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');

		fclose($in);
		fclose($out);		
		
	} else
		die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
}


		/*     now create Thumbnail    */
//get image size
$rslt			= mysql_query("select width,height from image_size where imageName='Image Gallery Thumb'");
$row			= mysql_fetch_assoc($rslt);
$final_width_of_image=$row["width"];
$final_height_of_image=$row["height"];
$path_to_thumbs_directory='../images/gallery/'.$gTitleId.'/thumbnail/';
    if(preg_match('/[.](jpg)$/', $fileName)) {
        $im = imagecreatefromjpeg($targetDir.$fileName);
    } else if (preg_match('/[.](gif)$/', $fileName)) {
        $im = imagecreatefromgif($targetDir.$fileName);
    } else if (preg_match('/[.](png)$/', $fileName)) {
        $im = imagecreatefrompng($targetDir.$fileName);
    }
    $ox = imagesx($im);
    $oy = imagesy($im);
     
    $nx = $final_width_of_image;
    $ny = $final_height_of_image;
     
    $nm = imagecreatetruecolor($nx, $ny);
     
    imagecopyresized($nm, $im, 0,0,0,0,$nx,$ny,$ox,$oy);
     
    if(!file_exists($path_to_thumbs_directory)) {
      if(!mkdir($path_to_thumbs_directory, 0777, true)) {
           die("There was a problem. Please try again!");
      }
       }
    imagejpeg($nm, $path_to_thumbs_directory . $fileName,100);

mysqli_query($con,"insert into tbl_gallery (galleryImage,gTitleId) values('$fileName','$gTitleId')") or die(mysqli_error($con));
// Return JSON-RPC response
die('{"jsonrpc" : "2.0", "result" : null, "id" : "id"}');

?>