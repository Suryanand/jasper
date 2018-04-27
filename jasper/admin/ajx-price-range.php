<?php
include_once('config.php');
include_once('session.php');
echo "here";
// select tags for category
if(isset($_POST["category"]) && isset($_POST["range"])){
	$print="";
	$category=$_POST["category"];
	$range=$_POST["range"];
	$ranges=explode(',',$rang);
	$minPrice=$ranges[0];
	$maxPrice=$ranges[1];
	echo $minPrice;
	echo $maxPrice;
	//require UC_ROOT.'/parts/section/category-grid.php';
}
?>
