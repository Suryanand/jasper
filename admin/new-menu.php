<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
include('functions.php');
include('get-user.php'); /* Geting logged in user details*/
if($userType != 1)
{
	header('location: manage-menu.php');
}

// new user submit
if(isset($_POST["submit"]))
{
	$category 	= mysqli_real_escape_string($con,$_POST["category"]);
	$menuTitle	= mysqli_real_escape_string($con,$_POST["menuTitle"]);
	$description	= mysqli_real_escape_string($con,$_POST["description"]);
	$activeStatus	= mysqli_real_escape_string($con,$_POST["active"]);
			
	$serviceImage="";
	$image = new UploadImage\Image($_FILES);
	$image->setLocation("../uploads/images/services");
	if($image["serviceImage"]){
		$upload = $image->upload(); 
		if($upload){
			$serviceImage=$image->getName().".".$image->getMime();			
		}else{
			echo $image["error"]; 
		}
	}

	
	mysqli_query($con,"insert into tbl_jr_menu (menuTitle,category,shortDescription,description,image,activeStatus,updatedOn)values('".$menuTitle."','".$category."','".$shortDescription."','".$description."','".$serviceImage."','".$activeStatus."',NOW())") or die(mysqli_error($con));
		
	//fetch current product id
	$rslt			= mysqli_query($con,"select id from tbl_jr_menu order by id desc limit 1");
	$row			= mysqli_fetch_assoc($rslt);
	$id		= $row["id"];
	
	

		if($_POST["submit"]=="submit-close")
		{
		$_SESSION["response"]="Menu Saved";
		echo "<script>location.href = 'manage-menu.php'</script>";
		}
		else
		{
			echo "<script>location.href = 'edit-menu.php?id=$id'</script>";
		}
	
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


				<form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">
	                <fieldset>

	                    <!-- Form validation -->
	                    <div class="widget">
	                        <div class="navbar"><div class="navbar-inner"><h6>New Menu</h6></div></div>
						<div class="tabbable">
                            <ul class="nav nav-tabs">
	                                <li><a href="#tab1" data-toggle="tab">General</a></li>
                                    <div class="form-actions align-right">
                            <button type="submit" class="btn btn-info" value="submit" name="submit">Save and Continue</button>
                            <button type="submit" class="btn btn-info" value="submit-close" name="submit">Save</button>
                        </div>
	                            </ul>
                           <div class="tab-content">
                           <div class="tab-pane active" id="tab1">
                           <div class="well row-fluid">                            	                                
                                <div class="control-group">
	                                <label class="control-label">Menu Title: <span class="text-error">*</span></label>
	                                <div class="controls">
	                                    <input type="text" value="" class="validate[required] input-xlarge" name="menuTitle" id="menuTitle"/>
	                                </div>
	                            </div>
                                <div class="control-group">
	                                <label class="control-label">Category: <span class="text-error">*</span></label>
	                                <div class="controls">
	                                    <select name="category" class="validate[] styled" data-prompt-position="topLeft:-1,-5">
                                              <option value="">Select Category</option>
											<?php 
												$rslt=mysqli_query($con,"SELECT categoryName,id FROM tbl_menu_category");
												while($row=mysqli_fetch_array($rslt))
												{
											?>			                                            
                                            <option value="<?php echo $row["id"];?>"><?php echo $row["categoryName"];?></option>
                                            <?php } ?>                                           
	                                    </select>
	                                </div>
	                            </div>
                                
								<div class="control-group">
	                                <label class="control-label">Description</label>
	                                <div class="controls">
	                                    <textarea rows="5" cols="5" name="description" class="validate[] span12"></textarea>
	                                </div>
	                            </div>
                                <div class="control-group">
	                                <label class="control-label">Upload Image:<br>360px X 200px</label>
	                                <div class="controls">
										<input type="file" name="serviceImage2" id="serviceImage2" class="validate[custom[images]]">									
	                                </div>
	                            </div>
								
                                <div class="control-group">
	                                <label class="control-label">Status: <i class="ico-question-sign popover-test left"  data-trigger="hover" title="Status" data-content="Show in store front or not"></i></label>
	                                <div class="controls">

										<label class="radio inline">
											<input class="styled" type="radio" checked name="active"  value="1" data-prompt-position="topLeft:-1,-5"/>
											Active
										</label>
										<label class="radio inline">
											<input class="styled" type="radio" name="active" value="0" data-prompt-position="topLeft:-1,-5"/>
											Inactive
										</label>
	                                </div>
	                            </div>
								
	                        </div>
                            
                            </div>
                            <!--Tab 2-->
                            
                            <!--Tab 3-->
                            
                            </div>
                            </div>

	                    </div>
	                    <!-- /form validation -->

	                </fieldset>
				</form>
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
<script>
	CKEDITOR.replace('description', {height: '130px'});
	CKEDITOR.replace('shortDescription', {height: '130px'});
</script>
</body>
</html>
