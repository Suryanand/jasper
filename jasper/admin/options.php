<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
if($userType == 3) /* This page only for admin - if normal user redirect to index page */
{
	header('location: index.php');
}
include('get-user.php'); /* Geting logged in user details*/

// new user submit
if(isset($_POST["submit"]))
{
	$optionName = mysqli_real_escape_string($con,$_POST["optionName"]);
	$optionNameAr = mysqli_real_escape_string($con,$_POST["optionNameAr"]);
	
		mysqli_query($con,"insert into tbl_options (optionName,optionNameAr)values('$optionName','$optionNameAr')") or die(mysqli_error($con));
		$rslt=mysqli_query($con,"select * from tbl_options order by id desc limit 1");
		$row=mysqli_fetch_assoc($rslt);
		$optionId=$row["id"];
			if(!empty($_POST['option']))
				mysqli_query($con,"insert into tbl_option_values (fkOptionId,optionValue,optionValueAr)values('$optionId','".$_POST['option']."','".$_POST['optionAr']."')") or die(mysqli_error($con));			
		$_SESSION["response"]="Option Added";
		echo "<script>location.href = 'manage-options.php'</script>";
	
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
<script>
function catSpec(catId)
{
	$("#overlay").show();
		 $.ajax({
			 type: "POST",
			 url: "ajx-scripts.php",
			 data: {catId:catId},
			 success: function(data) {
				setTimeout(function() {
					 $('#overlay').hide();
				 $("#specification").html(data);
				}, 500);
			}
		});
}

function saveSpec()
{
	var spec=$("#spec").val();
	if(spec!="")
	{
	$("#overlay").show();
	var catId=$("#category").val();
	if(catId=="")
	{
		return false;
	}
		 $.ajax({
			 type: "POST",
			 url: "ajx-scripts.php",
			 data: {category:catId,specification:spec},
			 success: function(data) {
				setTimeout(function() {
					 $('#overlay').hide();
				 $("#specification").html(data);
				}, 500);
			}
		});
	}
	else
		alert("Attribute Name cannot be null");
}
function updateSpec(specId){
	$("#overlay").show();
	var specs="#spec"+specId.value;
	var spec=$(specs).val();
		 $.ajax({
			 type: "POST",
			 url: "ajx-scripts.php",
			 data: {specId:specId.value,specification:spec},
			 success: function(data) {
				setTimeout(function() {
					 $('#overlay').hide();
				 $("#specification").html(data);
				}, 500);
			}
		});
}

function deleteSpec(specId){
	$("#overlay").show();
		 $.ajax({
			 type: "POST",
			 url: "ajx-scripts.php",
			 data: {delSpecId:specId.value},
			 success: function(data) {
				setTimeout(function() {
					 $('#overlay').hide();
				 $("#specification").html(data);
				}, 500);
			}
		});
}

function addField() {
            var $template = $('#addOption'),
                $clone    = $template
                                .clone()
                                .removeClass('hide')
                                .removeAttr('id')
                                .insertAfter($template),
                $option   = $clone.find('[name="option[]"]');

            // Add new field
            $('#addOption').formValidation('addField', $option);
        }

        // Remove button click handler
function removeField(str) {
            var $row    = $(str).parents('.controls'),
                $option = $row.find('[name="option[]"]');

            // Remove element containing the option
            $row.remove();

            // Remove field
            $('#addOption').formValidation('removeField', $option);
        }
</script>
</head>

<body>

	<!-- Fixed top -->
	<?php include_once('top-bar.php'); ?>
	<!-- /fixed top -->
	<div id="overlay">
            <img alt="" id="loading" src="img/elements/loaders/1.gif">
	</div>

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
	                        <div class="navbar"><div class="navbar-inner"><h6>Options</h6></div></div>
	                    	<div class="well row-fluid" id="specification">                            	                                
                                <div class="control-group">
	                                <label class="control-label">Option Name: <span class="text-error">*</span></label>
	                                <div class="controls">
                                         <input type="text" value="" class="validate[required] input-large" name="optionName" id="optionName"/>     
	                                </div>
	                            </div>
								<div style="display:none;" class="control-group">
	                                <label class="control-label">Option Name Arabic: <span class="text-error">*</span></label>
	                                <div class="controls">
                                         <input type="text" style="direction:rtl;" value="" class="validate[] input-large" name="optionNameAr" id="optionNameAr"/>     
	                                </div>
	                            </div>
                                <div class="control-group">
	                                <label class="control-label">Option Value Name:</label>
	                                <div class="controls">
	                                    <input type="text" value="" class="validate[] input-large" name="option"/>
	                                </div>
	                            </div>
								<div style="display:none;" class="control-group">
	                                <label class="control-label">Option Value Name Arabic:</label>
	                                <div class="controls">
										<input type="text" value="" style="direction:rtl;" class="validate[] input-large" name="optionAr"/>
	                                </div>
	                                <div class="controls">
										<button type="submit" name="submit" class="btn btn-info"  style="margin-top:4px;">Add</button>
	                                </div>
								</div>
								<div class="control-group">
	                                <label class="control-label"></label>
	                                
	                                <div class="controls">
										<button type="submit" name="submit" class="btn btn-info"  style="margin-top:4px;">Add</button>
	                                </div>
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

</body>
</html>
