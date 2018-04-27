<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
include('get-user.php'); /* Geting logged in user details*/
if($permission["Product Attribute"] == 0)
{
	header('location: index.php');
}

// new user submit
if(isset($_POST["submit"]))
{
	$service = mysqli_real_escape_string($con,$_POST["service"]);
						
	// Check whether the email already registered 
	$rslt=mysqli_query($con,"select * from tbl_services where serviceName='$service'");
	if(mysqli_num_rows($rslt)>0) 
	{/* email already registered */
		$_SESSION["err"]="Service already created";
	}
	else
	{						
		mysqli_query($con,"insert into tbl_services (serviceName)values('$service')") or die(mysqli_error($con));
		$_SESSION["response"]="Service Created";
		echo "<script>location.href = 'manage-service.php'</script>";
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
	                        <div class="navbar"><div class="navbar-inner"><h6>Attributes</h6></div></div>
	                    	<div class="well row-fluid" id="specification">                            	                                
                                <div class="control-group">
	                                <label class="control-label">Category: <span class="text-error">*</span></label>
	                                <div class="controls">
	                                    <select name="category" onChange="catSpec(this.value)" id="category" class="validate[required] options" data-prompt-position="topLeft:-1,-5">
                                              <option value="">Select Category</option>
											<?php 
												$rslt=mysqli_query($con,"SELECT t1.categoryId AS catId,
TRIM(LEADING '-> ' FROM CONCAT(IFNULL(t4.categoryName, ''), '-> ', IFNULL(t3.categoryName, ''), '-> ', IFNULL(t2.categoryName, ''), '-> ', IFNULL(t1.categoryName, ''))) AS parentCategory 
FROM tbl_category t1 
LEFT JOIN tbl_category t2 ON t1.parentId=t2.categoryId 
LEFT JOIN tbl_category t3 ON t2.parentId=t3.categoryId 
LEFT JOIN tbl_category t4 ON t3.parentId=t4.categoryId
WHERE t1.activeStatus=1
ORDER BY parentCategory
");
												while($row=mysqli_fetch_array($rslt))
												{
											?>			                                            
                                            <option value="<?php echo $row["catId"];?>"><?php echo $row["parentCategory"];?></option>
                                            <?php } ?>
	                                    </select>
	                                </div>
	                            </div>
                                
                                <!--<div class="control-group">
	                                <label class="control-label">Attribute Name: <span class="text-error">*</span></label>
	                                <div class="controls">
	                                    <input type="text" value="" class="validate[required] input-large" name="spec" id="spec"/>					
										<button type="button" onClick="saveSpec()" class="btn btn-info" name="submit">Add</button>
										<?php if(isset($_SESSION["err"])) /* if email already registered */
										{
										?>
											<span class="help-block" style="color:#F00;">Attribute already created</span>
										<?php
										unset($_SESSION["err"]);
										}
										?>
	                                </div>
	                            </div>	-->				
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
