<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
include('get-user.php'); /* Geting logged in user details*/
include('functions.php');

if($userType != 1) /* This page only for admin - if normal user redirect to index page */
{
	header('location: index.php');
}
$id=$_GET["id"];
$rslt=mysqli_query($con,"select * from tbl_firm where id='$id'");
$row=mysqli_fetch_assoc($rslt);
$address = $row["address"];
	$userId = $row["userId"];
	$firmImage = $row["image"];
	$companyType = $row["companyType"];
	$email  = $row["email"];
	$country = $row["country"];
	$area = $row["area"];
	$network1 = $row["network1"];
	$network2 = $row["network2"];
	$location=$row["location"];
	$companyName	=$row["companyName"];
	$profile	=$row["profile"];
	//$email	=$row["email"];
	$contactNo	=$row["contactNo"];
	$fax	=$row["fax"];
	$googleMap	=$row["googleMap"];
	$activeStatus=$row["activeStatus"];
	$branchId=$row["branchId"];
	//$password=encryptIt($row["password"]);
	
	$titleTag=$row["titleTag"];
	$metaDescription=$row["metaDescription"];
	$metaKeywords=$row["metaKeywords"];
	$urlName=$row["urlName"];

if(isset($_POST["submit"]))
{
	$companyType = mysqli_real_escape_string($con,$_POST["companyType"]);
	$country = mysqli_real_escape_string($con,$_POST["country"]);
	$email  = mysqli_real_escape_string($con,$_POST["email"]);
	$address = mysqli_real_escape_string($con,$_POST["address"]);
	$area = mysqli_real_escape_string($con,$_POST["area"]);
	$network1 = mysqli_real_escape_string($con,$_POST["network1"]);
	$network2 = mysqli_real_escape_string($con,$_POST["network2"]);
	$location=mysqli_real_escape_string($con,$_POST["location"]);
	$companyName	=mysqli_real_escape_string($con,$_POST["companyName"]);
	$profile	=mysqli_real_escape_string($con,$_POST["profile"]);
	$contactNo	=mysqli_real_escape_string($con,$_POST["contactNo"]);
	$fax	=mysqli_real_escape_string($con,$_POST["fax"]);
	$googleMap	=mysqli_real_escape_string($con,$_POST["googleMap"]);
	$activeStatus=mysqli_real_escape_string($con,$_POST["activeStatus"]);
	$branchId=mysqli_real_escape_string($con,$_POST["branchId"]);
	
	$image = new UploadImage\Image($_FILES);
	$image->setLocation("../uploads/images/firms");
	if($image["firmImage"]){
		$upload = $image->upload(); 
		if($upload){
			$firmImage=$image->getName().".".$image->getMime();
		}else{
			echo $image["error"]; 
		}
	}
	
	$titleTag=mysqli_real_escape_string($con,$_POST["titleTag"]);
	$metaDescription=mysqli_real_escape_string($con,$_POST["metaDescription"]);
	$metaKeywords=mysqli_real_escape_string($con,$_POST["metaKeywords"]);
	$urlName=mysqli_real_escape_string($con,$_POST["urlName"]);
	if(empty($urlName))
		$urlName=$companyName;
	$urlName = set_url_name($urlName);

	mysqli_query($con,"update  tbl_firm set location='".$location."',email='$email',country='$country',companyName='$companyName',address='$address',contactNo='$contactNo',fax='$fax',googleMap='$googleMap',activeStatus='$activeStatus',titleTag='".$titleTag."',metaDescription='$metaDescription',metaKeywords='$metaKeywords',urlName='$urlName',companyType='$companyType',area='$area',network1='$network1',network2='$network2',image='$firmImage',branchId='$branchId' where id='$id'") or die(mysqli_error($con));
	$_SESSION["response"]='Hospital Saved';
	echo "<script>location.href = 'manage-hospital.php'</script>";exit();
	
}

?>
<!doctype html>
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

				<h5 class="widget-name"><i class="icon-sitemap"></i>Edit Hospital <a href="manage-hospital.php" style="float:right;color:#555 !important;"><i style="padding:4px;" class="icon-arrow-left"></i>Back</a></h5>
	                <fieldset>

	                    <!-- Form validation -->
	                    <div class="widget">
							<div class="tabbable"><!-- default tabs -->
                            <div class="tab-content">

                            <div class="tab-pane active" id="tab1">
	                    	<div class="well row-fluid">
							
								<form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">
							<div class="span6 well">
									
									<div class="control-group hide">
										<label class="control-label">Type: <span class="text-error">*</span></label>
										<div class="controls">
											<label class="radio inline">
												<input class="styled" type="radio" <?php if($companyType==2) echo "checked";?> name="companyType" id="publish" value="2" data-prompt-position="topLeft:-1,-5"/>
												Hospital
											</label>
											<label class="radio inline">
												<input class="styled" type="radio" <?php if($companyType==1) echo "checked"?> name="companyType" id="draft" value="1" data-prompt-position="topLeft:-1,-5"/>
												Clinic
											</label>
											<label class="radio inline">
												<input class="styled" type="radio" <?php if($companyType==3) echo "checked"?> name="companyType" id="draft" value="3" data-prompt-position="topLeft:-1,-5"/>
												Pharmacy
											</label>
											
										</div>
									</div>
									<div class="control-group">
										 <label class="control-label">Branch Of: <span class="text-error">*</span> </label>
										 <div class="controls">
											<select name="branchId" class="validate[] styled">
											<option value="0">None</option>
											<?php $rslt=mysqli_query($con,"select * from tbl_firm where userId='".$userId."'");
											while($row=mysqli_fetch_assoc($rslt))
											{?>
											<option value="<?php echo $row["id"];?>" <?php if($row["id"]==$branchId) echo "selected";?> class="firms firm<?php echo $row["companyType"];?>"><?php echo $row["companyName"];?></option>
											<?php }?>
											</select>
										 </div>
									</div>
									<div class="control-group">
										 <label class="control-label">Name: <span class="text-error">*</span> </label>
										 <div class="controls">
											 <input type="text" value="<?php echo $companyName;?>" class="validate[required] input-xlarge"  name="companyName" id="companyName"/>
										 </div>
									</div>									
									<div class="control-group">
										<label class="control-label">Profile: <span class="text-error">*</span></label>
										<div class="controls">
											<textarea rows="5" cols="5" name="profile" class="validate[] input-xlarge"><?php echo $profile;?></textarea>
										</div>
									</div>
									<div class="control-group">
										 <label class="control-label">Country: <span class="text-error">*</span> </label>
										 <div class="controls">
											<select name="country" class="validate[required] styled">
											<?php $rslt=mysqli_query($con,"select * from tbl_countries");
											while($row=mysqli_fetch_assoc($rslt))
											{												
											?>
												<option value="<?php echo $row["countryName"];?>" <?php if($row["countryName"]==$country) echo "selected";?>><?php echo $row["countryName"];?></option>
											<?php 
											}?>
											</select>
										 </div>
									</div>
									<div class="control-group">
										 <label class="control-label">Location:</label>
										 <div class="controls">
											 <input type="text" value="<?php echo $location;?>" class="validate[] input-xlarge"  name="location" id="location"/>
										 </div>
									</div>
									<div class="control-group">
										 <label class="control-label">Area:</label>
										 <div class="controls">
											 <input type="text" value="<?php echo $area;?>" class="validate[] input-xlarge"  name="area" id="area"/>
										 </div>
									</div>
									<div class="control-group">
										<label class="control-label">Address: <span class="text-error">*</span></label>
										<div class="controls">
											<textarea rows="5" cols="5" name="address" class="validate[required] input-xlarge"><?php echo $address;?></textarea>
										</div>
									</div>
									<div class="control-group">
										 <label class="control-label">Contact Number: <span class="text-error">*</span> </label>
										 <div class="controls">
											 <input type="text" value="<?php echo $contactNo;?>" class="validate[required] input-xlarge"  name="contactNo" id="contactNo"/>
										 </div>
									 </div>
									 
									 <div class="control-group">
										 <label class="control-label">Fax: </label>
										 <div class="controls">
											 <input type="text" value="<?php echo $fax;?>" class="validate[] input-xlarge"  name="fax" id="fax"/>
										 </div>
									 </div>
									 <div class="control-group">
										 <label class="control-label">Email: <span class="text-error">*</span> </label>
										 <div class="controls">
											 <input type="text" value="" class="validate[custom[email]] input-xlarge"  name="email" id="email"/>
										 </div>
									 </div>
									 <div class="control-group">
										 <label class="control-label">Network 1:</label>
										 <div class="controls">
											 <input type="text" value="<?php echo $network1;?>" class="validate[] input-xlarge"  name="network1" id="network2"/>
										 </div>
									</div>
									<div class="control-group">
										 <label class="control-label">Network 2:</label>
										 <div class="controls">
											 <input type="text" value="<?php echo $network2;?>" class="validate[] input-xlarge"  name="network2" id="network2"/>
										 </div>
									</div>
									
									 
								</div>
	                        <div class="span6 well">
									<div class="control-group">
										<label class="control-label">Google Map Iframe: </label>
										<div class="controls">
											<textarea rows="7" cols="5" name="googleMap" class="validate[] span12"><?php echo $googleMap;?></textarea>
										</div>
									</div>
									 
									 <div class="control-group">
										 <label class="control-label">Image: </label>
										 <div class="controls">
											 <input type="file" value="" class=""  name="firmImage" id="firmImage"/>
										 </div>
									 </div>
									 
									<div class="control-group">
										<label class="control-label">Active / Inactive: <span class="text-error">*</span></label>
										<div class="controls">
											<label class="radio inline">
												<input class="styled" type="radio" <?php if($activeStatus==1) echo "checked";?> name="activeStatus" id="publish" value="1" data-prompt-position="topLeft:-1,-5"/>
												Active
											</label>
											<label class="radio inline">
												<input class="styled" type="radio" <?php if($activeStatus==0) echo "checked"?> name="activeStatus" id="draft" value="0" data-prompt-position="topLeft:-1,-5"/>
												Inactive
											</label>
											
										</div>
									</div>
									
									<div class="control-group">
	                                <label class="control-label">URL Name: <br>(only lowercase letters and hyphen)</label>
	                                <div class="controls">
	                                    <input type="text" value="<?php echo $urlName;?>" maxlength="65" class="validate[] input-xlarge " name="urlName" id="urlName"/>
	                                </div>
	                            </div>
                                <div class="control-group">
	                                <label class="control-label">Title Tag: <br>(Max 65 Characters)</label>
	                                <div class="controls">
	                                    <input type="text" value="<?php echo $titleTag;?>" maxlength="65" class="validate[] input-xlarge " name="titleTag" id="titleTag"/>
	                                </div>
	                            </div>
                                <div class="control-group">
	                                <label class="control-label">Meta Description: <br>(Max 170 Characters)</label>
	                                <div class="controls">
	                                    <textarea rows="5" cols="5" id="metaDescription" maxlength="250" name="metaDescription" class="validate[]  span12"><?php echo $metaDescription;?></textarea>
	                                </div>
	                            </div>
                                <div class="control-group">
	                                <label class="control-label">Meta Keywords: <br>(Max 250 Characters)</label>
	                                <div class="controls">
	                                    <textarea rows="5" cols="5" id="metaKeywords" maxlength="250" name="metaKeywords" class="validate[]  span12"><?php echo $metaKeywords;?></textarea>
	                                </div>
	                            </div>
									<div class="form-actions align-right">
										<button type="submit" class="btn btn-info" name="submit" value="save">Save</button>
									</div>
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
                
                <!-- form submition -->  
                    <?php if(isset($_SESSION["response"]))
                     {
                     	echo "<script>alert('".$_SESSION["response"]."');</script>";
                        unset($_SESSION["response"]);
                      }
                     ?>
                
                <!-- /form submition -->             
		    </div>
		    <!-- /content wrapper -->

		</div>
		<!-- /content -->

	</div>
	<!-- /content container -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Password Generator</h4>
      </div>
      <div class="modal-body" style="text-align: center;">
        
		<div class="form-group">
			<input type="text" style="font-size:16px;text-align:center;" onClick="this.select();" value="<?php echo generate_password();?>" class="validate[] input-medium" name="pwd" id="pwd"/>
			<button type="button" name="generate_password"  class="generate_password btn btn-info updt-btn bbq">Generate Password</button>
        </div>
		<div class="form-group">
            <label class="radio inline">
                <input class=" styled" id="copied" type="checkbox" name="copied" data-prompt-position="topLeft:-1,-5"/>
             I have copied this password to a secure location.</label>
        </div>
      </div>		
        <div class="modal-footer" style="text-align: center;">
            <button type="button" class="btn updt-btn bbq3" data-dismiss="modal">Close</button>
			<button type="button" id="use_password" disabled class="btn btn-info updt-btn">Use Password</button>
        </div>
    </div>

  </div>
</div>


	<!-- Footer -->
	<?php include_once('footer.php'); ?>
	<!-- /footer -->
	<script>
		$(".ctype").click(function(){
			$(".firms").hide();
			var id=$(this).val();
			$(".firm"+id).show();
		});
		</script>
</body>
</html>
