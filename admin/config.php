<?php
//set time zone
date_default_timezone_set('Asia/Dubai');
//connection string
$db_host="localhost";
$db_user="root";
$db_password="root";
$db_name="jasper";
$con=mysqli_connect($db_host,$db_user,$db_password,$db_name)or die("Unable to connect to database");          

// absolute path
$rslt = mysqli_query($con,"SELECT absolutePath FROM tbl_settings");
$row = mysqli_fetch_assoc($rslt);
$absolutePath = $row["absolutePath"];

// get page name
$page=ucfirst(pathinfo(basename($_SERVER['PHP_SELF']), PATHINFO_FILENAME));
$pageName=strtolower($page);

//select admin panel page title
$rslt=mysqli_query($con,"select * from admin_title");
$row=mysqli_fetch_assoc($rslt);
$title=$row['title'];
$adminLogo=$row['adminLogo'];
?>