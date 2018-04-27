<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
if($userType==2) /* This page only for admin - if normal user redirect to index page */
{
	header('location: index.php');
}
$id=$_GET["id"];
$rslt=mysqli_query($con,"select * from tbl_faq where id='".$id."'");
$row=mysqli_fetch_assoc($rslt);
$question=$row["question"];
$answer=$row["answer"];
include('get-user.php'); /* Geting logged in user details*/

//submit form
if(isset($_POST["submit"]))
{
	$question=$_POST["question"];						
	$answer=mysqli_real_escape_string($con,$_POST["answer"]);
							
	/* insert user details to product table and login table*/
	mysqli_query($con,"update tbl_faq set question='$question',answer='$answer' where id='".$id."'") or die(mysqli_error($con));
	$_SESSION["response"]='Question updated Successfully';
	echo "<script>location.href = 'manage-faq.php'</script>;";
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
			    <br>
			    <!-- /page header -->


				<form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">
	                <fieldset>

	                    <!-- Form validation -->
	                    <div class="widget">
	                        <div class="navbar"><div class="navbar-inner"><h6>New Question</h6></div></div>
	                    	<div class="well row-fluid">


								<div class="control-group">
	                                <label class="control-label">Question: <span class="text-error">*</span></label>
	                                <div class="controls">
	                                    <input type="text" value="<?php echo $question; ?>" class="validate[required] span12" name="question" id="question"/>
	                                </div>
	                            </div>
                                <div class="control-group">
	                                <label class="control-label">Answer: <span class="text-error">*</span></label>
	                                <div class="controls">
	                                    <textarea rows="5" cols="5" id="answer" name="answer" class="validate[required] span12"><?php echo $answer; ?></textarea>
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
	CKEDITOR.replace('answer');
	</script>
	
</body>
</html>
