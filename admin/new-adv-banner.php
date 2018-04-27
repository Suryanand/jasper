<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
include("functions.php"); /* Connection String*/
if($userType != 1) /* This page only for admin - if normal user redirect to index page */
{
	header('location: index.php');
}
include('get-user.php'); /* Geting logged in user details*/


// new user submit
if(isset($_POST["submit"]))
{
	$type			= $_POST["submit"];
	$title			= mysqli_real_escape_string($con,$_POST["title"]);
	$link			= mysqli_real_escape_string($con,$_POST["link"]);
	/*if($type == "Sidebar")
	{
	$displayFrom	= date("Y-m-d", strtotime($_POST["displayFrom4"]));
	$displayTill	= date("Y-m-d", strtotime($_POST["displayTill4"]));	
	}
	else
	{
	$displayFrom	= date("Y-m-d", strtotime($_POST["displayFrom"]));
	$displayTill	= date("Y-m-d", strtotime($_POST["displayTill"]));	
	}*/
	
	$activeStatus	= mysqli_real_escape_string($con,$_POST["active"]);
	// Check whether the email already registered 
	
	$advBanner="";
	$image = new UploadImage\Image($_FILES);
	$image->setLocation("../uploads");
	if($image["advBanner"]){
		$upload = $image->upload(); 
		if($upload){
			$advBanner=$image->getName().".".$image->getMime();
		}else{
			echo $image["error"]; 
		}
	}
		//mysqli_query($con,"insert into tbl_adv_banner (`imageName`,`type`,`displayFrom`,`displayTill`,`activeStatus`,`createdOn`,`createdBy`,`updatedOn`,`updatedBy`)values('".$advBanner."','".$type."','".$displayFrom."','".$displayTill."','".$activeStatus."',NOW(),'".$CurrentUserId."',NOW(),'".$CurrentUserId."')") or die(mysqli_error($con));
		mysqli_query($con,"insert into tbl_adv_banner (`imageName`,`type`,`title`,link,`activeStatus`,`createdOn`,`createdBy`,`updatedOn`,`updatedBy`)values('".$advBanner."','".$type."','".$title."','".$link."','".$activeStatus."',NOW(),'".$CurrentUserId."',NOW(),'".$CurrentUserId."')") or die(mysqli_error($con));
		
		$_SESSION["response"]="Banner Uploaded";
		echo "<script>location.href = 'new-adv-banner.php';</script>";exit();
}

// delete category
if(isset($_POST["delete"]))
{
	$deleteId	= mysqli_real_escape_string($con,$_POST["delete"]);
		$rslt = mysqli_query($con,"select imageName from tbl_adv_banner where id='".$deleteId."'");
		$row  = mysqli_fetch_assoc($rslt);
		if(!empty($row["image"]))
		{
			unlink("../images/banners/adv/".$row["imageName"]);
		}
		mysqli_query($con,"delete from tbl_adv_banner where id='".$deleteId."'");
		//$_SESSION['response'] = 'Banner Deleted';
}
if(isset($_POST["order"]))
{
	$id=$_POST["order"];
	$order=$_POST["imageOrder".$id];
	mysqli_query($con,"update tbl_adv_banner set sortOrder='".$order."' where id='".$id."'");
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
<style>
.datatable-footer, .datatable-header{
	display:none;
}
</style>

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

			    <br clear="all"/>


	                    <!-- Form validation -->
	                    <div class="widget">
	                        <div class="navbar"><div class="navbar-inner"><h6>New Advertisement Banner</h6></div></div>
						<div class="tabbable">
                            <ul class="nav nav-tabs">
	                                <li><a href="#tab1" data-toggle="tab">Small</a></li>
	                                <li><a href="#tab3" data-toggle="tab">Medium</a></li>
									<li><a href="#tab4" data-toggle="tab">Large</a></li>
                                    <div class="form-actions align-right">
                        </div>
	                            </ul>
                           <div class="tab-content">
                           <div class="tab-pane active" id="tab1">                           
                           <form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">
                           <?php $type="Small";require('form-parts-adv.php');?>	                        
								<div class="form-actions align-right">
                                <button type="submit" class="btn btn-info" value="Small" name="submit">Save</button>
                                </div>
                            </form>
                                <?php require('table-parts-adv.php');?>	                        
	                        </div>
                            
							<!--Tab 3-->
							<div class="tab-pane" id="tab3">                           
                           <form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">
                           <?php $type="Medium";require('form-parts-adv.php');?>	                        
								<div class="form-actions align-right">
                                <button type="submit" class="btn btn-info" value="Medium" name="submit">Save</button>
                                </div>
                            </form>
                                <?php require('table-parts-adv.php');?>	                        
	                        </div>
                            <!--Tab 3-->
                            
                            <!--Tab 4-->
                            <div class="tab-pane" id="tab4">
                            <form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">
                                <?php $type="Large";require('form-parts-adv.php');?>	                        
								<div class="form-actions align-right">
                                <button type="submit" class="btn btn-info" value="Large" name="submit">Save</button>
                                </div>
	                        </form>
                                <?php require('table-parts-adv.php');?>	                        
                            </div>
                            </div>
                            </div>

	                    </div>
	                    <!-- /form validation -->

				<!-- /form validation -->

				<!-- form submition - add new user-->                
				<?php
				?>  
				<!-- /form submition -->                              
		    </div>
		    <!-- /content wrapper -->

		</div>
		<!-- /content -->

	</div>
	<!-- /content container -->


	<!-- Footer -->
	<?php include_once('footer.php'); ?>
	<!-- /footer -->

</body>
</html>
