<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
include('get-user.php'); /* Geting logged in user details*/
include("functions.php");

if($userType!=1) /* This page only for admin - if normal user redirect to index page */
{
	header('location: index.php');
}

$id=$_GET["id"];
$rslt=mysqli_query($con,"select * from tbl_schedule where id='".$id."'");
$row=mysqli_fetch_assoc($rslt);
$course=$row["course"];
$dateFrom=$row["dateFrom"];
$dateTo=$row["dateTo"];
$lastDate=$row["lastDate"];
$activeStatus=$row["activeStatus"];
$courseType=$row["courseType"];
// News & Events Form Submit
if(isset($_POST["submit"]))
{
	$courseType=mysqli_real_escape_string($con,$_POST["courseType"]);
	if($courseType==1)
		$course=mysqli_real_escape_string($con,$_POST["course"]);
	else
		$course=mysqli_real_escape_string($con,$_POST["workshop"]);
	$course=mysqli_real_escape_string($con,$_POST["course"]);
	$dateFrom=date("Y-m-d", strtotime($_POST["dateFrom"]));
	$dateTo=date("Y-m-d", strtotime($_POST["dateTo"]));
	$lastDate=date("Y-m-d", strtotime($_POST["lastDate"]));
	$activeStatus=mysqli_real_escape_string($con,$_POST["activeStatus"]);
	
	// insert into table
	mysqli_query($con,"update tbl_schedule set course='$course', dateFrom='$dateFrom', dateTo='$dateTo', lastDate='$lastDate', activeStatus='$activeStatus', updatedOn= NOW() where id='".$id."'");


	// set response alert
	$_SESSION["response"]="Conference Saved";
	if($_POST["submit"]=="submit-close")
		echo "<script>location.href = 'manage-schedule.php';</script>";
	else
		echo "<script>location.href = 'edit-schedule.php?id=".$id."';</script>";
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

			    <!-- Page header -->
			    <br>
			    <!-- /page header -->

				<h5 class="widget-name"><i class="icon-tasks"></i>Schedule<a href="manage-schedule.php" style="float:right;color:#555 !important;"><i style="padding:4px;" class="icon-arrow-left"></i>Back</a></h5>
				<form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">
	                <fieldset>

	                    <!-- Form validation -->
	                    <div class="widget">
	                    	<div class="tabbable"><!-- default tabs -->
	    	                <ul class="nav nav-tabs">
	                        	<li class="active"><a href="#tab1" data-toggle="tab">General</a></li>
	                            <!--<li><a href="#tab2" data-toggle="tab">Gallery Images</a></li>-->
								<div class="form-actions align-right">
                                    <button type="submit" class="btn btn-info" value="submit" name="submit">Save and Continue</button>
                                    <button type="submit" class="btn btn-info" value="submit-close" name="submit">Save</button>
								</div>
							</ul>
                            <div class="tab-content">

                            <div class="tab-pane active" id="tab1">
							<div class="well row-fluid">								
								<div class="control-group">
	                                <label class="control-label">Course / Workshop: <span class="text-error">*</span></label>
	                                <div class="controls">
										<label class="radio inline">
											<input class="styled courseType" type="radio" <?php if($courseType==1) echo "checked";?> name="courseType"  value="1" data-prompt-position="topLeft:-1,-5"/>
											Course
										</label>
										<label class="radio inline">
											<input class="styled courseType" type="radio" <?php if($courseType==2) echo "checked";?> name="courseType"  value="2" data-prompt-position="topLeft:-1,-5"/>
											Workshop
										</label>
	                                </div>
	                            </div>
								<div class="control-group course <?php if($courseType==2) echo "hide";?>">
	                                <label class="control-label">Course: <span class="text-error">*</span></label>
	                                <div class="controls">
									<select name="course" id="course" class="styled">
	                                    <?php $rslt=mysqli_query($con,"select * from tbl_course where activeStatus=1");
										while($row=mysqli_fetch_assoc($rslt))
										{
											?>
											<option value="<?php echo $row["id"];?>" <?php if($row["id"]==$course) echo "selected";?>><?php echo $row["courseName"];?></option>
										<?php }
										?>
										</select>
	                                </div>
	                            </div>
								<div class="control-group workshop <?php if($courseType==1) echo "hide";?>">
	                                <label class="control-label">Workshop: <span class="text-error">*</span></label>
	                                <div class="controls">
									<select name="workshop" id="workshop" class="styled validate[required]">
										<option value="">Choose Workshop</option>
	                                    <?php $rslt=mysqli_query($con,"select * from tbl_workshops where activeStatus=1");
										while($row=mysqli_fetch_assoc($rslt))
										{
											?>
											<option value="<?php echo $row["id"];?>" <?php if($row["id"]==$course) echo "selected";?>><?php echo $row["workshop"];?></option>
										<?php }
										?>
										</select>
	                                </div>
	                            </div>
                                                            
                                <div class="control-group">
		                            <label class="control-label">From Date: <span class="text-error">*</span> </label>
		                            <div class="controls">
		                                <input type="text" value="<?php echo $dateFrom;?>" class="datepicker validate[required] input-xlarge"  name="dateFrom" id="dateFrom"/>
		                            </div>
		                        </div>
								 <div class="control-group">
		                            <label class="control-label">To Date: <span class="text-error">*</span> </label>
		                            <div class="controls">
		                                <input type="text" value="<?php echo $dateTo;?>" class="datepicker validate[required] input-xlarge"  name="dateTo" id="dateTo"/>
		                            </div>
		                        </div>
								 <div class="control-group">
		                            <label class="control-label">Last Date for Reg.: <span class="text-error">*</span> </label>
		                            <div class="controls">
		                                <input type="text" value="<?php echo $lastDate;?>" class="datepicker validate[required] input-xlarge"  name="lastDate" id="lastDate"/>
		                            </div>
		                        </div>
																
								<div class="control-group">
	                                <label class="control-label">Draft / Publish: <span class="text-error">*</span></label>
	                                <div class="controls">
										<label class="radio inline">
											<input class="styled" type="radio" <?php if($activeStatus==0) echo "checked";?> name="activeStatus" id="activeStatus" value="0" data-prompt-position="topLeft:-1,-5"/>
											Draft
										</label>
										<label class="radio inline">
											<input class="styled" type="radio"  <?php if($activeStatus==1) echo "checked";?> name="activeStatus" id="activeStatus" value="1" data-prompt-position="topLeft:-1,-5"/>
											Publish
										</label>
	                                </div>
	                            </div>
                                <!-- seo fields -->
								
                                <!-- /seo fields -->
	                            <div class="form-actions align-right">
	                                <button type="submit" class="btn btn-info" value="submit" name="submit">Save and Continue</button>
                                    <button type="submit" class="btn btn-info" value="submit-close" name="submit">Save</button>
	                            </div>

	                        </div>
							</div>
							
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

</body>
</html>
