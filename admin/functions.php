<?php
require_once  "uploadimage.php";
    /*
     * Function to Encrypt sensitive data for storing in the database
     *
     * @param string	$value		The text to be encrypted
	 * @param 			$encodeKey	The Key to use in the encryption
     * @return						The encrypted text
     */
	function encryptIt($value) {
		// The encodeKey MUST match the decodeKey
		$encodeKey = 'XQ9b1q6V1q8bnwY0T6l66G';
		$encoded = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($encodeKey), $value, MCRYPT_MODE_CBC, md5(md5($encodeKey))));
		return($encoded);
	}

    /*
     * Function to decrypt sensitive data from the database for displaying
     *
     * @param string	$value		The text to be decrypted
	 * @param 			$decodeKey	The Key to use for decryption
     * @return						The decrypted text
     */
	function decryptIt($value) {
		// The decodeKey MUST match the encodeKey
		$decodeKey = 'XQ9b1q6V1q8bnwY0T6l66G';
		$decoded = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($decodeKey), base64_decode($value), MCRYPT_MODE_CBC, md5(md5($decodeKey))), "\0");
		return($decoded);
	}
	
	function set_url_name($seoName)
	{
		$seoName = strtolower(str_replace(" ", "-", $seoName));	// Replaces all spaces with hyphens.
		return preg_replace('/[^A-Za-z0-9\-]/', '', $seoName); // Removes special chars.	
	}
	
	function upload_image($path_to_image_directory,$image_name,$temp_name){
			$categoryImage = $image_name;
			$ext = pathinfo($categoryImage, PATHINFO_EXTENSION);		
			$source = $temp_name;
			// Make sure the fileName is unique
			$count = 1;
			while (file_exists($path_to_image_directory.$categoryImage))
			{
				$count++;
				$categoryImage=$count."-".$categoryImage;
			}
			$target = $path_to_image_directory . $categoryImage;
			if(!file_exists($path_to_image_directory)) 
			{
				if(!mkdir($path_to_image_directory, 0777, true)) 
				{
					die("There was a problem. Please try again!");
				}
			}
			move_uploaded_file($source, $target);
			return $categoryImage;
	}
	
	function generate_password()
	{
		$alpha = "abcdefghijklmnopqrstuvwxyz";
		$alpha_upper = strtoupper($alpha);
		$numeric = "0123456789";
		$special = ".-+=_,!@$#*%<>[]{}";
		$chars = $alpha.$alpha_upper.$numeric.$special;
		$length = 8;
		$len = strlen($chars);
		$pw = '';
		for ($i=0;$i<$length;$i++)
			$pw .= substr($chars, rand(0, $len-1), 1);
		// the finished password
		$pw = str_shuffle($pw);
		return $pw;
	}
	if(isset($_POST["pwd"]))
	{
		echo generate_password();
	}

	//get image size	
	function image_size($imageName)
	{
		global $con;
		$rslt			= mysqli_query($con,"select width,height from image_size where imageName='$imageName'");
		$row			= mysqli_fetch_assoc($rslt);
		$imageHeight	= $row["height"];
		$imageWidth		= $row["width"];
		$imageSize='w:'.$row["width"].'px &nbsp;&nbsp; h:'.$row["height"].'px';
		return $imageSize;
	}
?>