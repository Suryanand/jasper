<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
include('get-user.php'); /* Geting logged in user details*/

if($userType!=1) /* This page only for admin - if normal user redirect to index page */
{
	header('location: index.php');
}

$rslt=mysqli_query($con,"select * from tbl_settings");
if(mysqli_num_rows($rslt)>0)
{
	while($row=mysqli_fetch_array($rslt))
	{
		$flag=1; /* Links are there in Table */
		$contactEmail=$row['subscriptionEmail']; 		$subscriptionEmail2=$row['subscriptionEmail2']; 
		$smtpServer=$row['smtpServer'];
		$smtpPort=$row['smtpPort'];
		$smtpUser=$row['smtpUser'];
		$smtpPassword=$row['smtpPassword'];
		$mailType=$row["mailType"];
		$smtpSSL=$row["smtpSSL"];
	}
}
else
{
$flag=0; /* Links not in table */
}


if(isset($_POST["submit"]))
{
	$contactEmail=$_POST["contactEmail"];	$subscriptionEmail2=$_POST["subscriptionEmail2"];
	if($flag==0)
	{ /* inser into table first time*/
		mysqli_query($con,"insert into tbl_settings (subscriptionEmail,subscriptionEmail2)values('$contactEmail','$subscriptionEmail')") ;
		$_SESSION['response'] ='Email Settings Saved';
	}
	else
	{ /* update links in table*/
		mysqli_query($con,"update tbl_settings set subscriptionEmail='$contactEmail',subscriptionEmail2='$subscriptionEmail2'") or die(mysqli_error($con));
		$_SESSION['response'] ='Email Settings Updated';
	}
	echo "<script>location.href = 'mail-settings.php'</script>";exit();																		
}
// save settings
if(isset($_POST['submit-settings']))
{	
	$smtpServer=$_POST['smtpServer'];
	$smtpPort=$_POST['smtpPort'];
	$smtpUser=$_POST['smtpUser'];
	$smtpPassword=$_POST['smtpPassword'];
	$mailType=$_POST["mailType"];
	$smtpSSL=0;
	if(isset($_POST["smtpSSL"]))
		$smtpSSL=1;
	mysqli_query($con,"update tbl_settings set smtpServer='$smtpServer',smtpPort='$smtpPort',smtpUser='$smtpUser',smtpPassword='$smtpPassword',mailType='$mailType',smtpSSL='$smtpSSL'");
	$_SESSION["tab"]="settings";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<title><?php echo $title;?></title>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<!--[if IE 8]><link href="css/ie8.css" rel="stylesheet" type="text/css" /><![endif]-->
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700' rel='stylesheet' type='text/css'>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDY0kkJiTPVd2U7aTOAwhc9ySH6oHxOIYM&amp;sensor=false"></script>

<script type="text/javascript" src="js/plugins/charts/excanvas.min.js"></script>
<script type="text/javascript" src="js/plugins/charts/jquery.flot.js"></script>
<script type="text/javascript" src="js/plugins/charts/jquery.flot.resize.js"></script>
<script type="text/javascript" src="js/plugins/charts/jquery.sparkline.min.js"></script>

<script type="text/javascript" src="js/plugins/ui/jquery.easytabs.min.js"></script>
<script type="text/javascript" src="js/plugins/ui/jquery.collapsible.min.js"></script>
<script type="text/javascript" src="js/plugins/ui/jquery.mousewheel.js"></script>
<script type="text/javascript" src="js/plugins/ui/prettify.js"></script>
<script type="text/javascript" src="js/plugins/ui/jquery.bootbox.min.js"></script>
<script type="text/javascript" src="js/plugins/ui/jquery.colorpicker.js"></script>
<script type="text/javascript" src="js/plugins/ui/jquery.timepicker.min.js"></script>
<script type="text/javascript" src="js/plugins/ui/jquery.jgrowl.js"></script>
<script type="text/javascript" src="js/plugins/ui/jquery.fancybox.js"></script>
<script type="text/javascript" src="js/plugins/ui/jquery.fullcalendar.min.js"></script>
<script type="text/javascript" src="js/plugins/ui/jquery.elfinder.js"></script>

<script type="text/javascript" src="js/plugins/uploader/plupload.js"></script>
<script type="text/javascript" src="js/plugins/uploader/plupload.html4.js"></script>
<script type="text/javascript" src="js/plugins/uploader/plupload.html5.js"></script>
<script type="text/javascript" src="js/plugins/uploader/jquery.plupload.queue.js"></script>

<script type="text/javascript" src="js/plugins/forms/jquery.uniform.min.js"></script>
<script type="text/javascript" src="js/plugins/forms/jquery.autosize.js"></script>
<script type="text/javascript" src="js/plugins/forms/jquery.inputlimiter.min.js"></script>
<script type="text/javascript" src="js/plugins/forms/jquery.tagsinput.min.js"></script>
<script type="text/javascript" src="js/plugins/forms/jquery.inputmask.js"></script>
<script type="text/javascript" src="js/plugins/forms/jquery.select2.min.js"></script>
<script type="text/javascript" src="js/plugins/forms/jquery.listbox.js"></script>
<script type="text/javascript" src="js/plugins/forms/jquery.validation.js"></script>
<script type="text/javascript" src="js/plugins/forms/jquery.validationEngine-en.js"></script>
<script type="text/javascript" src="js/plugins/forms/jquery.form.wizard.js"></script>
<script type="text/javascript" src="js/plugins/forms/jquery.form.js"></script>

<script type="text/javascript" src="js/plugins/tables/jquery.dataTables.min.js"></script>

<script type="text/javascript" src="js/files/bootstrap.min.js"></script>

<script type="text/javascript" src="js/files/functions.js"></script>

<script type="text/javascript" src="js/charts/graph.js"></script>
<script type="text/javascript" src="js/charts/chart1.js"></script>
<script type="text/javascript" src="js/charts/chart2.js"></script>
<script type="text/javascript" src="js/charts/chart3.js"></script>
<script>
function smtpSettings(i)
	{
		if(i==2)
		{
		$(".smtp").show();
		}
		else{
			$(".smtp").hide();
		}
	}
</script>
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

			    <!-- Page header --><br><!-- /Page header -->
				<h5 class="widget-name"><i class="icon-picture"></i>Mail Settings</h5>
				<form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">
	                <fieldset>

	                    <!-- Form validation -->
	                    <div class="tabbable">
							<ul class="nav nav-tabs">
	                            <li <?php if(!isset($_SESSION["tab"]) || $_SESSION["tab"]=="mailAction") {?>class="active"<?php } ?>><a href="#tab1"  data-toggle="tab">Mail Action</a></li>
	                            <li <?php if(isset($_SESSION["tab"]) && $_SESSION["tab"]=="settings") {?>class="active"<?php } ?>><a href="#tab4" data-toggle="tab" >Settings</a></li>
							</ul>
                            <div class="tab-content">
							<!-- Tab 1-->
							<div class="tab-pane <?php if(!isset($_SESSION["tab"]) || $_SESSION["tab"]=="mailAction") {echo "active";} ?>" id="tab1">
							<div class="control-group">
	                                <label class="control-label">Admin Contact Email 1:</label>
	                                <div class="controls">
	                                    <input type="text" value="<?php if($flag==1) echo $contactEmail; ?>" class="validate[custom[email]] input-large" name="contactEmail" id="contactEmail"/>
	                                </div>
	                            </div>								<div class="control-group">
	                                <label class="control-label">Admin Contact Email 2:</label>
	                                <div class="controls">
	                                    <input type="text" value="<?php if($flag==1) echo $subscriptionEmail2; ?>" class="validate[custom[email]] input-large" name="subscriptionEmail2" id="subscriptionEmail2"/>
	                                </div>
	                            </div>
                               
	                            <div class="form-actions align-right">
	                                <button type="submit" class="btn btn-info" name="submit">Submit</button>
	                                <button type="reset" class="btn">Reset</button>
	                            </div>
							</div>
							<!-- Tab 2-->
                            
                            <!-- Tab 4-->							
                            <div class="tab-pane <?php if(isset($_SESSION["tab"]) && $_SESSION["tab"]=="settings") {echo "active";} ?>" id="tab4">
                           <div class="well row-fluid">
								<div class="control-group">
	                                <label class="control-label">Mail Type:</label>
	                                <div class="controls">
										<label class="radio inline">
											<input class="styled" type="radio" onClick="smtpSettings(1)" <?php if($mailType==1) echo "checked";?> name="mailType"  value="1" data-prompt-position="topLeft:-1,-5"/>
											PHP Mail
										</label>
										<label class="radio inline">
											<input class="styled" type="radio" onClick="smtpSettings(2)" <?php if($mailType==2) echo "checked";?> name="mailType" value="2" data-prompt-position="topLeft:-1,-5"/>
											SMTP
										</label>
	                                </div>
	                            </div>
								<div class="smtp" <?php if($mailType==1) {?>style="display:none"<?php }?>>
								<div class="control-group">
	                                <label class="control-label">SMTP Server:</label>
	                                <div class="controls">
	                                    <input type="text" value="<?php if($flag==1) echo $smtpServer; ?>" class="span6" name="smtpServer" id="smtpServer"/>
	                                </div>
	                            </div>
								<div class="control-group">
	                                <label class="control-label">SSL:</label>
	                                <div class="controls">
										<label class="checkbox">
											<input class="styled" type="checkbox" <?php if($flag==1 && $smtpSSL==1) echo "checked";?> name="smtpSSL" id="smtpSSL" value="1" data-prompt-position="topLeft:-1,-5"/>
										</label>
	                                </div>
	                            </div>
								<div class="control-group">
	                                <label class="control-label">SMTP Port:</label>
	                                <div class="controls">
	                                    <input type="text" value="<?php if($flag==1) echo $smtpPort; ?>" class="span6" name="smtpPort" id="smtpPort"/>
	                                </div>
	                            </div>
								<div class="control-group">
	                                <label class="control-label">SMTP User:</label>
	                                <div class="controls">
	                                    <input type="text" value="<?php if($flag==1) echo $smtpUser; ?>" class="span6" name="smtpUser" id="smtpUser"/>
	                                </div>
	                            </div>
								<div class="control-group">
	                                <label class="control-label">SMTP Password:</label>
	                                <div class="controls">
	                                    <input type="password" value="<?php if($flag==1) echo $smtpPassword; ?>" class="span6" name="smtpPassword" id="smtpPassword"/>
	                                </div>
	                            </div>
								
								</div>
								<div class="form-actions align-right">
                                    <button type="submit"  class="btn btn-info" id="submit-settings" value="submit" name="submit-settings">Save</button>
                                    <button type="reset" class="btn btn-danger" id="reset" name="reset">Reset</button>
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
<?php if(isset($_SESSION["response"]))
{
	echo "<script>alert('".$_SESSION["response"]."');</script>";
	unset($_SESSION["response"]);
}
?>

	<!-- Footer -->
	<?php include_once('footer.php'); ?>
	<!-- /footer -->

</body>
</html>
