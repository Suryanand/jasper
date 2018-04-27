<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
include('get-user.php'); /* Geting logged in user details*/
if($permission["Shipment"] == 0) 
{
	header('location: index.php');
}

// new user submit
if(isset($_POST["submit"]))
{
	$location 	= mysqli_real_escape_string($con,$_POST["province"]);
	$parentId	= 0;
	$level		= 0;
	
	// Check whether the province already registered 
	$rslt=mysqli_query($con,"select * from tbl_locations where location='$location'");
	if(mysqli_num_rows($rslt)>0) 
	{/* email already registered */
		$_SESSION["response"]="State already created";
	}
	else
	{		
		mysqli_query($con,"insert into tbl_locations (`location`,`parentId`,level)values('".$location."','".$parentId."','".$level."')") or die(mysqli_error($con));
		//echo "<script>location.href = 'locations.php'</script>";
	}
	$_SESSION["tab"]="state";
}
//new area
if(isset($_POST["submit-area"]))
{
	$parentId 	= mysqli_real_escape_string($con,$_POST["province"]);
	$area 	= mysqli_real_escape_string($con,$_POST["area"]);
	mysqli_query($con,"insert into tbl_locations (`location`,`parentId`,level)values('".$area."','".$parentId."','1')") or die(mysqli_error($con));
	$_SESSION["tab"]="area";
}
//new location
if(isset($_POST["submit-location"]))
{
	$parentId 	= mysqli_real_escape_string($con,$_POST["area"]);
	$location 	= mysqli_real_escape_string($con,$_POST["location"]);
	mysqli_query($con,"insert into tbl_locations (`location`,`parentId`,level)values('".$location."','".$parentId."','2')") or die(mysqli_error($con));
	$_SESSION["tab"]="location";
}
//update
if(isset($_POST["update"]))
{
	$id=$_POST["update"];
	$restriction=0;
	if(isset($_POST["restriction".$id]))
		$restriction=1;
	mysqli_query($con,"update tbl_locations set restriction='".$restriction."' where id='".$id."'");
}

//delete province
if(isset($_POST["delete1"]))
{
	mysqli_query($con,"delete from tbl_locations where id='".$_POST["delete1"]."'");
	$_SESSION["tab"]="state";
}
if(isset($_POST["delete2"]))
{
	mysqli_query($con,"delete from tbl_locations where id='".$_POST["delete2"]."'");
	$_SESSION["tab"]="area";
}
if(isset($_POST["delete3"]))
{
	mysqli_query($con,"delete from tbl_locations where id='".$_POST["delete3"]."'");
	$_SESSION["tab"]="location";
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
function getArea(province)
{
	$("#overlay").show();
		 $.ajax({
			 type: "POST",
			 url: "ajx-location.php",
			 data: {province:province},
			 success: function(data) {
				 $("#area").html(data);
				setTimeout(function() {
					 $('#overlay').hide();
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


	                <fieldset>

	                    <!-- Form validation -->
	                    <div class="widget">
	                        <div class="navbar"><div class="navbar-inner"><h6>Shipping Locations</h6></div></div>
						<div class="tabbable">
                            <ul class="nav nav-tabs">
	                                <li <?php if(!isset($_SESSION["tab"]) || $_SESSION["tab"]=="state") echo 'class="active"'?>><a href="#tab1" data-toggle="tab">State</a></li>
	                                <li <?php if(isset($_SESSION["tab"]) && $_SESSION["tab"]=="area") echo 'class="active"'?>><a href="#tab2" data-toggle="tab">Area</a></li>
	                                <li <?php if(isset($_SESSION["tab"]) && $_SESSION["tab"]=="location") echo 'class="active"'?>><a href="#tab3" data-toggle="tab">Location</a></li>                                    
	                            </ul>
                           <div class="tab-content">
						   <!-- Tab 1-->
                           <div class="tab-pane <?php if(!isset($_SESSION["tab"]) || $_SESSION["tab"]=="state") echo 'active';?>" id="tab1">
                           <div class="well row-fluid">
						   <?php 
						   if($permission["Shipment"] > 1)
						   {
						   ?>
							<form id="validate" class="form-horizontal" action="" method="post">
                                <div class="control-group">
	                                <label class="control-label">State / Province: <span class="text-error">*</span></label>
	                                <div class="controls">
	                                    <input type="text" value="" class="validate[required] input-xlarge" name="province" id="province"/>					
										<?php if(isset($_SESSION["response"])) /* if province already registered */
										{
										?>
											<span class="help-block" style="color:#F00;"><?php echo $_SESSION["response"]; ?></span>
										<?php
										unset($_SESSION["response"]);
										}
										?>
									<button type="submit" class="btn btn-info" value="submit-close" name="submit">Save</button>
	                                </div>
	                            </div>
							</form>
							<?php }?>
							<form id="validate" class="form-horizontal" action="" method="post">
								<div class="table-overflow">
									<table class="table table-striped">
										<thead>
											<tr>
												<th>#</th>
												<th>State / Province</th>
												<th>Restriction</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
										<?php 
											$i=0;
											$rslt=mysqli_query($con,"select * from tbl_locations where level=0");
											while($row=mysqli_fetch_assoc($rslt))
											{
												$i++;
											?>
											<tr>
												<td><?php echo $i;?></td>
												<td><?php echo $row["location"];?></td>
												<td><input type="checkbox" class="styled" <?php if($row["restriction"]) echo "checked";?> name="restriction<?php echo $row["id"];?>"/>
												<?php if($permission["Shipment"] > 2){?>
												<button type="submit" title="Update" value="<?php echo $row["id"]; ?>" class="remove-button-icon" name="update"><i class="fam-tick"></i></button>
												<?php }?>
												</td>
												<td>
												<?php if($permission["Shipment"] == 4){?>
												<button type="submit" title="remove" value="<?php echo $row["id"]; ?>" class="remove-button-icon" name="delete1"><i class="fam-cross"></i></button>
												<?php }?>
												</td>
											</tr>
											<?php }?>
										</tbody>
									</table>
								</div>
							</form>	
	                        </div>                            
                            </div>
                            <!--Tab 2-->
                            <div class="tab-pane  <?php if(isset($_SESSION["tab"]) && $_SESSION["tab"]=="area") echo "active";?>" id="tab2">
                                <div class="row-fluid well">
								<?php 
							   if($permission["Shipment"] > 1)
							   {
							   ?>
								<form id="validate" class="form-horizontal" action="" method="post">
                                	<div class="control-group">
	                                <label class="control-label">State / Province: <span class="text-error">*</span></label>
	                                <div class="controls">
	                                    <select name="province" class="validate[] styled" data-prompt-position="topLeft:-1,-5">
                                              <option value="">Select Province</option>
											<?php 
												$rslt=mysqli_query($con,"SELECT id,location FROM tbl_locations WHERE level=0");
												while($row=mysqli_fetch_array($rslt))
												{
											?>			                                            
                                            <option value="<?php echo $row["id"];?>"><?php echo $row["location"];?></option>
                                            <?php } ?>                                           
	                                    </select>
	                                </div><br>
									<label class="control-label">Area: <span class="text-error">*</span></label>
	                                <div class="controls">
	                                    <input type="text" value="" class="validate[required] input-xlarge" name="area" />
										<button type="submit" class="btn btn-info" value="" name="submit-area">Save</button>
	                                </div>
	                            </div>								
								</form>
							   <?php }?>
								<form id="validate" class="form-horizontal" action="" method="post">
									<div class="table-overflow">
										<table class="table table-striped">
											<thead>
												<tr>
													<th>#</th>
													<th>Area</th>
													<th>State / Province</th>
													<th>Restriction</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
											<?php 
												$i=0;
												$rslt=mysqli_query($con,"select t1.*,t2.location as province from tbl_locations t1 left join tbl_locations t2 on t1.parentId=t2.id where t1.level=1");
												while($row=mysqli_fetch_assoc($rslt))
												{
													$i++;
												?>
												<tr>
													<td><?php echo $i;?></td>
													<td><?php echo $row["location"];?></td>
													<td><?php echo $row["province"];?></td>
													<td><input type="checkbox" class="styled" <?php if($row["restriction"]) echo "checked";?> name="restriction<?php echo $row["id"];?>"/>
														<?php if($permission["Shipment"] > 2){?>
														<button type="submit" title="Update" value="<?php echo $row["id"]; ?>" class="remove-button-icon" name="update"><i class="fam-tick"></i></button><?php }?>
													</td>
													<td>
													<?php if($permission["Shipment"] == 4){?>
													<button type="submit" title="remove" value="<?php echo $row["id"]; ?>" class="remove-button-icon" name="delete2"><i class="fam-cross"></i></button>
													<?php }?>
													</td>
												</tr>
												<?php }?>
											</tbody>
										</table>
									</div>
								</form>
								</div>
                            </div>
                            <!--Tab 3-->
                            <div class="tab-pane  <?php if(isset($_SESSION["tab"]) && $_SESSION["tab"]=="location") echo 'active';?>" id="tab3">
                                <div class="row-fluid well">
								<?php if($permission["Shipment"] > 1){?>
								<form id="validate" class="form-horizontal" action="" method="post">
                                	<div class="control-group">
	                                <label class="control-label">State / Province: <span class="text-error">*</span></label>
	                                <div class="controls">
	                                    <select name="province" onChange="getArea(this.value)" class="validate[] styled" data-prompt-position="topLeft:-1,-5">
                                              <option value="">Select Province</option>
											<?php 
												$rslt=mysqli_query($con,"SELECT id,location FROM tbl_locations WHERE level=0");
												while($row=mysqli_fetch_array($rslt))
												{
											?>			                                            
                                            <option value="<?php echo $row["id"];?>"><?php echo $row["location"];?></option>
                                            <?php } ?>                                           
	                                    </select>
	                                </div><br>
									<label class="control-label">Area: <span class="text-error">*</span></label>
	                                <div class="controls">
	                                    <select name="area" id="area" class="validate[] styled" data-prompt-position="topLeft:-1,-5">
                                              <option value="">Select Area</option>
	                                    </select>
	                                </div><br>
									<label class="control-label">Location: <span class="text-error">*</span></label>
	                                <div class="controls">
	                                    <input type="text" value="" class="validate[required] input-xlarge" name="location" id="location"/>
										<button type="submit" class="btn btn-info" value="" name="submit-location">Save</button>
	                                </div>
	                            </div>								
								</form>
								<?php }?>
								<form id="validate" class="form-horizontal" action="" method="post">
									<div class="table-overflow">
										<table class="table table-striped">
											<thead>
												<tr>
													<th>#</th>
													<th>Location</th>
													<th>Area</th>
													<th>State / Province</th>
													<th>Restriction</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
											<?php 
												$i=0;
												$rslt=mysqli_query($con,"select t1.*,t2.location as area,t3.location as province from tbl_locations t1 left join tbl_locations t2 on t1.parentId=t2.id left join tbl_locations t3 on t2.parentId=t3.id where t1.level=2");
												while($row=mysqli_fetch_assoc($rslt))
												{
													$i++;
												?>
												<tr>
													<td><?php echo $i;?></td>
													<td><?php echo $row["location"];?></td>
													<td><?php echo $row["area"];?></td>
													<td><?php echo $row["province"];?></td>
													<td><input type="checkbox" class="styled" <?php if($row["restriction"]) echo "checked";?> name="restriction<?php echo $row["id"];?>"/>
														<?php if($permission["Shipment"] > 2){?>
														<button type="submit" title="Update" value="<?php echo $row["id"]; ?>" class="remove-button-icon" name="update"><i class="fam-tick"></i></button>
														<?php }?>
													</td>
													<td>
													<?php if($permission["Shipment"] == 4){?>
													<button type="submit" title="remove" value="<?php echo $row["id"]; ?>" class="remove-button-icon" name="delete3"><i class="fam-cross"></i></button>
													<?php }?>
													</td>
												</tr>
												<?php }?>
											</tbody>
										</table>
									</div>
								</form>
								</div>
                            </div>
                            </div>
                            </div>
	                    </div>
	                    <!-- /form validation -->

	                </fieldset>
				<!-- /form validation -->

				<!-- form submition - add new user-->                

				<!-- /form submition -->                              
		    </div>
		    <!-- /content wrapper -->

		</div>
		<!-- /content -->

	</div>
	<!-- /content container -->
<?php if(isset($_SESSION["tab"]))
{
	unset($_SESSION["tab"]);
}
?>

	<!-- Footer -->
	<?php include_once('footer.php'); ?>
	<!-- /footer -->

</body>
</html>
