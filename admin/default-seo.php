<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
if($userType!=1) /* This page only for admin - if normal user redirect to index page */
{
	header('location: index.php');
}
include('get-user.php'); /* Geting logged in user details*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<title><?php echo $title; ?></title>
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
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<script>
$(document).ready(function(){
    $("#validate").validationEngine('attach');

});
      function countChar1(val) {
        var len = val.value.length;
          $('#remaining1').text(" Remaining Characters : "+(65 - len));
      }
      function countChar2(val) {
        var len = val.value.length;
          $('#remaining2').text(" Remaining Characters : "+(250 - len));
      }
      function countChar3(val) {
        var len = val.value.length;
          $('#remaining3').text(" Remaining Characters : "+(250 - len));
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

			    <!-- Page header -->
			    <br>
			    <!-- /page header -->


				<form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">
	                <fieldset>

	                    <!-- Form validation -->
	                    <div class="widget">
	                        <div class="navbar"><div class="navbar-inner"><h6>Default Search Engine Listings</h6></div></div>
	                    	<div class="well row-fluid">
								<?php 
                                $rslt=mysqli_query($con,"select * from tbl_seo where seoFor='default'");
                                if(mysqli_num_rows($rslt)>0)
                                {
									$flag=1;
                                while($row=mysqli_fetch_array($rslt))
                                {
                                     /* Default details are there in Table */
                                    $titleTag=$row['titleTag']; 
                                    $metaDescription=$row['metaDescription'];
                                    $metaKeywords=$row['metaKeywords'];
                                }
                                }
                                else
                                {
                                    $flag=0; /* Default details not in table */
                                }
                                ?>

								<div class="control-group">
	                                <label class="control-label">Title Tag: <span class="text-error">*</span><br>(Max 65 Characters)</label>
	                                <div class="controls">
	                                    <input type="text" value="<?php if($flag==1) echo $titleTag; ?>" onKeyUp="countChar1(this)" maxlength="65" class="validate[] input-xxlarge" name="titleTag" id="titleTag"/><span id='remaining1'></span>
	                                </div>
	                            </div>
                                <div class="control-group">
	                                <label class="control-label">Meta Description: <span class="text-error">*</span><br>(Max 170 Characters)</label>
	                                <div class="controls">
	                                    <textarea rows="5" cols="5" id="metaDescription" maxlength="250" onKeyUp="countChar2(this)" name="metaDescription" class="validate[] span12"><?php if($flag==1) echo $metaDescription; ?></textarea><span id='remaining2'></span>
	                                </div>
	                            </div>
                                <div class="control-group">
	                                <label class="control-label">Meta Keywords: <span class="text-error">*</span><br>(Max 250 Characters)</label>
	                                <div class="controls">
	                                    <textarea rows="5" cols="5" id="metaKeywords" maxlength="250" name="metaKeywords" onKeyUp="countChar3(this)" class="validate[] span12"><?php if($flag==1) echo $metaKeywords; ?></textarea><span id='remaining3'></span>
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

				<!-- form submition - add new product-->                
				<?php
					if(isset($_POST["submit"]))
					{
						$titleTag=mysqli_real_escape_string($con,$_POST["titleTag"]);						
						$metaDescription=mysqli_real_escape_string($con,$_POST["metaDescription"]);
						$metaKeywords=mysqli_real_escape_string($con,$_POST["metaKeywords"]);

						if($flag==0)
						{
						/* insert seo details to table*/
						mysqli_query($con,"insert into tbl_seo (titleTag,metaDescription,metaKeywords,seoFor) values('$titleTag','$metaDescription','$metaKeywords','default')") or die(mysqli_error($con));
						echo "<script>alert('Default SEO Details Saved Successfully');</script>;";
						}
						else
						{
						mysqli_query($con,"update tbl_seo set titleTag='$titleTag',metaDescription='$metaDescription',metaKeywords='$metaKeywords' where seoFor='default'") or die(mysqli_error($con));							
						echo "<script>alert('Default SEO Details Updated Successfully');</script>;";
						}
						echo "<script>location.href = 'default-seo.php'</script>;";
					}
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
	<script type="text/javascript">	
	CKEDITOR.replace('productDetails');
	CKEDITOR.replace('productDetails2');
	</script>
	
</body>
</html>
