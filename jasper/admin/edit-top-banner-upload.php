<?php 
	$bannerText1		= mysqli_real_escape_string($con,$_POST["bannerText1"]);
	$bannerText2	= mysqli_real_escape_string($con,$_POST["bannerText2"]);
	$bannerAlt	= mysqli_real_escape_string($con,$_POST["bannerAlt"]);
	if(isset($_FILES['topBanner']) && !empty($_FILES['topBanner']['name'])) 
	{     
		$path_to_image_directory = '../images/';
		if(preg_match('/[.](jpg)|(JPG)|(jpeg)|(JPEG)|(gif)|(GIF)|(png)|(PNG)$/', $_FILES['topBanner']['name'])) 
		{ 
			$image_info = getimagesize($_FILES["topBanner"]["tmp_name"]);
			$image_width = $image_info[0];
			$image_height = $image_info[1];
			if(1)
			{
				$path = $_FILES["topBanner"]['name'];
				$ext = pathinfo($path, PATHINFO_EXTENSION);		
				$source = $_FILES["topBanner"]['tmp_name'];
				if(empty($topBanner))
				{  
				$topBanner = "top-banner-"; //Image name
				// Make sure the fileName is unique
				$count = 1;
				while (file_exists($path_to_image_directory.$topBanner.$count.".".$ext))
				{
					$count++;	
				}
				$topBanner = $topBanner . $count.".".$ext;
				}
				$target = $path_to_image_directory . $topBanner;
				if(!file_exists($path_to_image_directory)) 
				{
					if(!mkdir($path_to_image_directory, 0777, true)) 
					{
						die("There was a problem. Please try again!");
					}
				}        
				move_uploaded_file($source, $target);
			}
			else
			{
				echo "<script>alert('Dimension not matching. Image will not be uploaded');</script>";
			}
		}
	}
?>