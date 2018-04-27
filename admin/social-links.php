<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
include('get-user.php'); /* Geting logged in user details*/

//select social links
$flag=0;
$rslt=mysqli_query($con,"select * from tbl_social_media");
if(mysqli_num_rows($rslt)>0)
{
$row=mysqli_fetch_array($rslt);
$flag=1; /* Links are there in Table */
$fb=$row['fb']; 
$tw=$row['tw'];
$gp=$row['gp'];
$li=$row['li'];
$yt=$row['yt'];
$rss=$row['rss'];
$pi=$row['pi'];
$ig=$row['ig'];
}

// form submit
if(isset($_POST["submit"]))
{
	$fb=$_POST["fb"];
	$tw=$_POST["tw"];
	$li=$_POST["li"];
	$gp=$_POST["gp"];
	$pi=$_POST["pi"];
	$ig=$_POST["ig"];
	$rss=$_POST["rss"];
	$yt=$_POST["yt"];
	if($flag==0)
	{ /* inser into table first time*/
		mysqli_query($con,"insert into tbl_social_media (fb,tw,li,gp,yt,pi,ig,rss) values ('$fb','$tw','$li','$gp','$yt','$pi','$ig','$rss')") or die(mysqli_error($con));
		$_SESSION["response"]='Social Links Saved';
	}
	else
	{ /* update links in table*/
		mysqli_query($con,"update tbl_social_media set fb='$fb',tw='$tw',gp='$gp',li='$li',yt='$yt',pi='$pi',ig='$ig',rss='$rss'");	
		$_SESSION["response"]='Social Links Updated';
	}
	echo "<script>location.href = 'social-links.php'</script>;";
	exit();																		
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
				<h5 class="widget-name"><i class="icon-picture"></i>Social Media Links</h5>
				<form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">
	                <fieldset>

	                    <!-- Form validation -->
	                    <div class="widget">
	                    	<div class="well row-fluid">                                
								<div class="control-group">
	                                <label class="control-label">Facebook:</label>
	                                <div class="controls">
	                                    <input type="text" value="<?php if($flag==1) echo $fb; ?>" class="validate[custom[url]] span8" name="fb" id="fb"/>
	                                </div>
	                            </div>
                                <div class="control-group">
	                                <label class="control-label">Twitter:</label>
	                                <div class="controls">
	                                    <input type="text" value="<?php if($flag==1) echo $tw; ?>" class="validate[custom[url]]] span8" name="tw" id="tw"/>
	                                </div>
	                            </div>	                            
                                <div class="control-group">
	                                <label class="control-label">Youtube:</label>
	                                <div class="controls">
	                                    <input type="text" value="<?php if($flag==1) echo $yt; ?>" class="validate[custom[url]]] span8" name="yt" id="yt"/>
	                                </div>
	                            </div>
                                <div class="control-group">
	                                <label class="control-label">LinkedIn:</label>
	                                <div class="controls">
	                                    <input type="text" value="<?php if($flag==1) echo $li; ?>" class="validate[custom[url]]] span8" name="li" id="li"/>					
	                                </div>
	                            </div>
                                <div class="control-group">
	                                <label class="control-label">Google Plus:</label>
	                                <div class="controls">
	                                    <input type="text" value="<?php if($flag==1) echo $gp; ?>" class="validate[custom[url]]] span8" name="gp" id="gp"/>					
	                                </div>
	                            </div>
                                <div class="control-group">
	                                <label class="control-label">Pinterest:</label>
	                                <div class="controls">
	                                    <input type="text" value="<?php if($flag==1) echo $pi; ?>" class="validate[custom[url]]] span8" name="pi" id="pi"/>					
	                                </div>
	                            </div>
                                <div class="control-group">
	                                <label class="control-label">Instagram:</label>
	                                <div class="controls">
	                                    <input type="text" value="<?php if($flag==1) echo $ig; ?>" class="validate[custom[url]]] span8" name="ig" id="ig"/>					
	                                </div>
	                            </div>                                
                                <div class="control-group">
	                                <label class="control-label">RSS:</label>
	                                <div class="controls">
	                                    <input type="text" value="<?php if($flag==1) echo $rss; ?>" class="validate[custom[url]]] span8" name="rss" id="rss"/>					
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
