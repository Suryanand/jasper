<?php 

include("session.php"); /*Check for session is set or not if not redirect to login page */

include("config.php"); /* Connection String*/

if($userType==2) /* This page only for admin - if normal user redirect to index page */

{

	header('location: index.php');

}

include('get-user.php'); /* Geting logged in user details*/

$editId=$_GET["id"];



// get franchise details

$rslt=mysqli_query($con,"select * from tbl_franchise where franchiseId='$editId'");

$row=mysqli_fetch_array($rslt);

$franchiseImage=$row['franchiseImage'];

$franchiseName=$row['franchiseName'];

$franchiseContact=$row['franchiseContact'];

// edit form submit

if(isset($_POST["submit"]))

{

	$franchiseName=$_POST["franchiseName"];						

	$franchiseContact=mysqli_real_escape_string($con,$_POST["contactDetails"]);

	//Image Upload Start 

	$path_to_image_directory = '../images/franchise/';

	$filename=$franchiseImage;

	if(isset($_FILES['franchiseImage']) && !empty( $_FILES["franchiseImage"]["name"] )) 

	{

		if(preg_match('/[.](jpg)|(gif)|(png)$/', $_FILES['franchiseImage']['name'])) 

		{    

			$path = $_FILES['franchiseImage']['name'];

			$ext = pathinfo($path, PATHINFO_EXTENSION);	

			$ext2 = pathinfo($filename, PATHINFO_EXTENSION); 

			if(empty($filename) || $ext != $ext2)

			{

				$filename = "franchise-img-";							

				// Make sure the fileName is unique 

				$count = 1;

				while (file_exists($path_to_image_directory.$filename.$count.".".$ext))

				{

					$count++;	

				}

				$filename = $filename . $count.".".$ext; 

			}

			$source = $_FILES['franchiseImage']['tmp_name'];  

			$target = $path_to_image_directory . $filename;

			if(!file_exists($path_to_image_directory)) 

			{

				if(!mkdir($path_to_image_directory, 0777, true)) 

				{

					die("There was a problem. Please try again!");

				}

			}

			$franchiseImage=$filename;    

			move_uploaded_file($source, $target);

		}

	}

	/* Image upload Ends */							

	

	//insert user details to product table and login table*/

	mysqli_query($con,"update tbl_franchise set franchiseName='$franchiseName',franchiseContact='$franchiseContact',franchiseImage='$franchiseImage' where franchiseId='$editId'") or die(mysqli_error($con));

	$_SESSION["response"]='Franchise Updated Successfully';

	echo "<script>location.href = 'manage-franchise.php'</script>;";

}

?>

<!DOCTYPE html>

<html lang="en">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />

<title><?php echo $title; ?></title>

<link href="css/main.css" rel="stylesheet" type="text/css" />

<!--[if IE 8]><link href="css/ie8.css" rel="stylesheet" type="text/css" /><![endif]-->

<link href='css/gfonts.css' rel='stylesheet' type='text/css'>

<?php include_once('js-scripts.php'); ?>

<script type="text/javascript" src="ckeditor/ckeditor.js"></script>

</head>



<body>



	<!-- Fixed top -->

	<?php include_once('top-bar.php'); ?>

	<!-- /fixed top -->





	<!-- Content container -->

	<div id="container">



		<!-- Sidebar -->

		<?php include_once('side-bar.php'); ?>

		<!-- /sidebar -->





		<!-- Content -->

		<div id="content">



		    <!-- Content wrapper -->

		    <div class="wrapper">



			    <!-- Breadcrumbs line -->

			    <?php include_once('bread-crumbs.php'); ?>

			    <!-- /breadcrumbs line -->



			    <!-- Page header -->

			    <div class="page-header">

			    	<div class="page-title">

				    	<h5>Dashboard</h5>

				    	

			    	</div>

			    </div>

			    <!-- /page header -->





				<form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">

	                <fieldset>



	                    <!-- Form validation -->

	                    <div class="widget">

	                        <div class="navbar"><div class="navbar-inner"><h6>Edit Store</h6></div></div>

	                    	<div class="well row-fluid">

								<div class="control-group">

	                                <label class="control-label">Store Name: <span class="text-error">*</span></label>

	                                <div class="controls">

	                                    <input type="text" value="<?php echo $franchiseName; ?>" class="validate[required] input-xlarge" name="franchiseName" id="franchiseName"/>

	                                </div>

	                            </div>

                                <div class="control-group">

	                                <label class="control-label">Contact Details: <span class="text-error">*</span></label>

	                                <div class="controls">

	                                    <textarea rows="5" cols="5" id="contactDetails" name="contactDetails" class="validate[required] span12"><?php echo $franchiseContact; ?></textarea>

	                                </div>

	                            </div>	                            

                                <div class="control-group">

	                                        <label class="control-label">Upload Image: <span class="text-error">*</span> <br> w:240px &nbsp;&nbsp; h:110px</label>

	                                        <div class="controls">

	                                            <img src="../images/franchise/<?php echo $franchiseImage; ?>" width="196" height="90" />

												<input type="file" name="franchiseImage" id="franchiseImage" class="validate[custom[images]]">

	                                        </div>

	                                    </div>

	                            <div class="form-actions align-right">

	                                <button type="submit" class="btn btn-info" name="submit">Submit</button>

	                                <button type="reset" class="btn">Reset</button>

	                            </div>



	                        </div>



	                    </div>

	                    <!-- /form validation -->



	                </fieldset>

				</form>

				<!-- /form validation -->

		    </div>

		    <!-- /content wrapper -->



		</div>

		<!-- /content -->



	</div>

	<!-- /content container -->





	<!-- Footer -->

	<?php include_once('footer.php'); ?>

	<!-- /footer -->

	<script type="text/javascript">	

//	CKEDITOR.replace('contactDetails');

	</script>

	

</body>

</html>

