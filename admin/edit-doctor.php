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
$rslt=mysqli_query($con,"select * from tbl_doctors where id='".$id."'");
$row=mysqli_fetch_assoc($rslt);
	$address = $row["address"];
	$area = $row["area"];
	$specialized = $row["specialized"];
	$qualification = $row["qualification"];
	$location=$row["location"];
	$fullName	=$row["fullName"];
	$profile	=$row["profile"];
	$email	=$row["email"];
	$contactNo	=$row["contactNo"];
	//$fax	=$row["fax"];
	$googleMap	=$row["googleMap"];
	$activeStatus=$row["activeStatus"];
	$doctorImage=$row["image"];
	$titleTag=$row["titleTag"];
	$metaDescription=$row["metaDescription"];
	$metaKeywords=$row["metaKeywords"];
	$urlName=$row["urlName"];
	$gender = $row["gender"];
        $age = $row["age"];
        $hierarchy = $row["hierarchy"];
        $nationality = $row["nationality"];
        $language = $row["language"];
        $practice = $row["practice"];
if(isset($_POST["submit"]))
{
$language = implode(',', $_POST['language']); 
$plid = implode(',', $_POST['plid']);
$specialized = implode(',', $_POST['specialized']);
$hierarchy = mysqli_real_escape_string($con,$_POST["hierarchy"]);
$nationality = mysqli_real_escape_string($con,$_POST["nationality"]);
//	$country = mysqli_real_escape_string($con,$_POST["country"]);
	$address = mysqli_real_escape_string($con,$_POST["address"]);
	$area = mysqli_real_escape_string($con,$_POST["area"]);
	//$specialized = mysqli_real_escape_string($con,$_POST["specialized"]);
	$qualification = mysqli_real_escape_string($con,$_POST["qualification"]);
	$location=mysqli_real_escape_string($con,$_POST["location"]);
	$fullName	=mysqli_real_escape_string($con,$_POST["fullName"]);
	$profile	=mysqli_real_escape_string($con,$_POST["profile"]);
	$email	=mysqli_real_escape_string($con,$_POST["email"]);
	$contactNo	=mysqli_real_escape_string($con,$_POST["contactNo"]);
        $gender = mysqli_real_escape_string($con,$_POST["gender"]);
        $age = mysqli_real_escape_string($con,$_POST["age"]);
	//$fax	=mysqli_real_escape_string($con,$_POST["fax"]);
	$googleMap	=mysqli_real_escape_string($con,$_POST["googleMap"]);
	$activeStatus=mysqli_real_escape_string($con,$_POST["activeStatus"]);
	$image = new UploadImage\Image($_FILES);
	$image->setLocation("../uploads/images/doctors");
	if($image["doctorImage"]){
		$upload = $image->upload(); 
		if($upload){
			$doctorImage=$image->getName().".".$image->getMime();
		}else{
			echo $image["error"]; 
		}
	}
	
	$titleTag=mysqli_real_escape_string($con,$_POST["titleTag"]);
	$metaDescription=mysqli_real_escape_string($con,$_POST["metaDescription"]);
	$metaKeywords=mysqli_real_escape_string($con,$_POST["metaKeywords"]);
	$urlName=mysqli_real_escape_string($con,$_POST["urlName"]);
	if(empty($urlName))
		$urlName=$fullName;
	$urlName = set_url_name($urlName);

	
	mysqli_query($con,"update  tbl_doctors set location='".$location."',fullName='$fullName',address='$address',contactNo='$contactNo',googleMap='$googleMap',activeStatus='$activeStatus',titleTag='".$titleTag."',metaDescription='$metaDescription',metaKeywords='$metaKeywords',urlName='$urlName',area='$area',specialized='$specialized',qualification='$qualification',image='$doctorImage',email='$email',profile='$profile',gender='$gender',age='$age',language='$language',hierarchy='$hierarchy',nationality='$nationality',practice='$plid' where id='$id'") or die(mysqli_error($con));
	$_SESSION["response"]='Doctor Details Saved';
	echo "<script>location.href = 'manage-doctors.php'</script>";exit();
	
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
<form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">
				<h5 class="widget-name"><i class="icon-sitemap"></i>Edit Doctor <a href="manage-doctors.php" style="float:right;color:#555 !important;"><i style="padding:4px;" class="icon-arrow-left"></i>Back</a></h5>
<ul class="nav nav-tabs">    
<li><a href="#tab1" data-toggle="tab">General</a></li>
<li><a href="#tab2" data-toggle="tab">Practice Location</a></li>
<div class="form-actions align-right">
<button type="submit" class="btn btn-info" name="submit" value="save">Save</button>
</div> 
</ul>	                
                                <fieldset>

	                    <!-- Form validation -->
	                    <div class="widget">
							<div class="tabbable"><!-- default tabs -->
                            <div class="tab-content">

                            <div class="tab-pane active" id="tab1">
	                    	<div class="well row-fluid">
							
								
							<div class="span6 well">
									
									
									<div class="control-group">
										 <label class="control-label">Name: <span class="text-error">*</span> </label>
										 <div class="controls">
											 <input type="text" value="<?php echo $fullName;?>" class="validate[required] input-xlarge"  name="fullName" id="fullName"/>
										 </div>
									</div>
									                   <div class="control-group">
	                                <label class="control-label">Specialized: <span class="text-error">*</span></label>
	                                <div class="controls">
                <?php
										$catArray=explode(',',$specialized);
										$rslt=mysqli_query($con,"select * from tbl_specialty");
										while($row=mysqli_fetch_array($rslt))
										{											
										?>
											<label class="radio inline">
											<input class="styled validate[minCheckbox[1]]" <?php if(in_array($row["id"],$catArray)) echo "checked";?> type="checkbox" name="specialized[]" id="" value="<?php echo $row["id"];?>" data-prompt-position="topLeft:-1,-5"/>
											<?php echo $row["Name"];?>
										</label>
                                        <?php } ?>   
	                                </div>
	                            </div>
									<div class="control-group">
										 <label class="control-label">Education Degrees: <span class="text-error">*</span> </label>
										 <div class="controls">
											 <input type="text" value="<?php echo $qualification;?>" class="validate[required] input-xlarge"  name="qualification" id="qualification"/>
										 </div>
									</div>
                                                            						                   <div class="control-group">
	                                <label class="control-label">Language Known: <span class="text-error">*</span></label>
	                                <div class="controls">
                <?php
										$catArray=explode(',',$language);
										$rslt=mysqli_query($con,"select * from tbl_language");
										while($row=mysqli_fetch_array($rslt))
										{											
										?>
											<label class="radio inline">
											<input class="styled validate[minCheckbox[1]]" <?php if(in_array($row["id"],$catArray)) echo "checked";?> type="checkbox" name="language[]" id="" value="<?php echo $row["id"];?>" data-prompt-position="topLeft:-1,-5"/>
											<?php echo $row["Name"];?>
										</label>
                                        <?php } ?>   
	                                </div>
	                            </div>
                                                            <div class="control-group">
										 <label class="control-label">Nationality: <span class="text-error">*</span> </label>
										 <div class="controls">
											 <input type="text" value="<?php echo $nationality;?>" class="validate[required] input-xlarge"  name="nationality" id="qualification"/>
										 </div>
									</div>
                                                            <div class="control-group">
										<label class="control-label">Hierarchy: <span class="text-error">*</span></label>
										<div class="controls">
											<label class="radio inline">
												<input class="styled" type="radio" <?php if($hierarchy==1) echo "checked";?> name="hierarchy" id="publish" value="1" data-prompt-position="topLeft:-1,-5"/>
												Specialist
											</label>
											<label class="radio inline">
												<input class="styled" type="radio" <?php if($hierarchy==0) echo "checked"?> name="hierarchy" id="draft" value="0" data-prompt-position="topLeft:-1,-5"/>
												Consultant
											</label>
											
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Profile: <span class="text-error">*</span></label>
										<div class="controls">
											<textarea rows="5" cols="5" name="profile" class="validate[] input-xlarge"><?php echo $profile;?></textarea>
										</div>
									</div>
									<div class="control-group hide">
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
										 <label class="control-label">Location: <span class="text-error">*</span></label>
										 <div class="controls">
											 <input type="text" required value="<?php echo $location;?>" class="validate[] input-xlarge"  name="location" id="location"/>
										 </div>
									</div>
									<div class="control-group">
										 <label class="control-label">Area: <span class="text-error">*</span></label>
										 <div class="controls">
											 <input type="text" required value="<?php echo $area;?>" class="validate[] input-xlarge"  name="area" id="area"/>
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
										 <label class="control-label">Email: <span class="text-error">*</span> </label>
										 <div class="controls">
											 <input type="text" value="<?php echo $email;?>" class="validate[custom[email]] input-xlarge"  name="email" id="email"/>
										 </div>
									 </div>									 
									<div class="control-group">
										<label class="control-label">Gender: <span class="text-error">*</span></label>
										<div class="controls">
											<label class="radio inline">
                                                                                                <input class="styled" type="radio" <?php if($gender=='1'){ echo'checked';}?> name="gender"  value="1" data-prompt-position="topLeft:-1,-5"/>
												Male
											</label>
											<label class="radio inline">
												<input class="styled" type="radio" <?php if($gender=='0'){ echo'checked';}?>  name="gender"  value="0" data-prompt-position="topLeft:-1,-5"/>
												Female
											</label>
											
										</div>
									</div>
									 <div class="control-group">
										 <label class="control-label">Age: </label>
										 <div class="controls">
											 <input type="number" value='<?php echo $age;?>'  class="input-xlarge"  name="age" id="age"/>
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
                                                                                     <img src="../uploads/images/doctors/<?php echo $doctorImage;?>" style='width:80px;height:80px;'>
											 <input type="file" value="" class=""  name="doctorImage" id="doctorImage"/>
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
<!--										<button type="submit" class="btn btn-info" name="submit" value="save">Save</button>-->
									</div>
								</div>
									
	                        
							</div>
							
							</div>
<div class="tab-pane" id="tab2">
<div class="well row-fluid">
<div class="span12 well">
<div class="control-group">
<label class="control-label">Practice Location: <span class="text-error">*</span></label>
<div class="controls">
<table border="0" style="width:100%">
<tr>    
<?php 
$sl=1;

										$catArray=explode(',',$practice);
										$rslt=mysqli_query($con,"select * from tbl_firm where activeStatus='1' and companyType='1'");
										while($row=mysqli_fetch_array($rslt))
										{											
$sl++;
?>    
<td title="<?php echo $row['companyName'];?>"><input <?php if(in_array($row["id"],$catArray)) echo "checked";?> type="checkbox" name="plid[]" value="<?php echo $row["id"];?>"> <?php echo substr($row['companyName'],0,10);?>...</td> 
<?php if ($sl=='6'){ echo "<tr>";}?>
<?php } ?>
</tr>
</table>    
</div>
</div>
</div>
</div>
</div>	
</form>                                
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
	$(".generate_password").click(function(){
		$.ajax({
			 type: "POST",
			 url: "functions.php",
			 data: {pwd:'1'},
			 success: function(data) {
				 $("#pwd").val(data);	 
			}
		});
	});
	$("#copied").change(function(){
		if($(this).is(":checked"))
			$("#use_password").attr("disabled",false);
		else
			$("#use_password").attr("disabled",true);
	});
	$("#use_password").click(function(){
		var pwd=$("#pwd").val();
		$("#password").val(pwd);
		$("#password1").val(pwd);
		$("#myModal").modal('hide');
	});
	</script>
</body>
</html>
