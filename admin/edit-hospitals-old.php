<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
include('get-user.php'); /* Geting logged in user details*/
include('functions.php');

if($userType != 1) /* This page only for admin - if normal user redirect to index page */
{
	header('location: index.php');
}
error_reporting(0);
$id=$_GET["id"];
$rslt=mysqli_query($con,"select * from tbl_firm where id='$id'");
$row=mysqli_fetch_assoc($rslt);
$service = $row["service"];
$insurance = $row["insurance"];
$specialty = $row["specialty"];
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
	$website=$row["website"];
	//$password=encryptIt($row["password"]);
	
	$titleTag=$row["titleTag"];
	$metaDescription=$row["metaDescription"];
	$metaKeywords=$row["metaKeywords"];
	$urlName=$row["urlName"];
$doctor=$row["doctor"];
$work_hours=$row["work_hours"];
if(isset($_POST["submit"]))
{
    $service = implode(',', $_POST['service']);
    $specialty = implode(',', $_POST['specialty']);
    $insurance = implode(',', $_POST['insurance']);
    $doctor = implode(',', $_POST['doctor']);
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
	$website=mysqli_real_escape_string($con,$_POST["website"]);
        $work_hours=mysqli_real_escape_string($con,$_POST["work_hours"]);
$sat_hour=mysqli_real_escape_string($con,$_POST["sat_hour"]);
$sat_min=mysqli_real_escape_string($con,$_POST["sat_min"]);
$sat_hour2=mysqli_real_escape_string($con,$_POST["sat_hour2"]);
$sat_min2=mysqli_real_escape_string($con,$_POST["sat_min2"]);
$sun_hour=mysqli_real_escape_string($con,$_POST["sun_hour"]);
$sun_min=mysqli_real_escape_string($con,$_POST["sun_min"]);
$sun_hour2=mysqli_real_escape_string($con,$_POST["sun_hour2"]);
$sun_min2=mysqli_real_escape_string($con,$_POST["sun_min2"]);
$mon_hour=mysqli_real_escape_string($con,$_POST["mon_hour"]);
$mon_min=mysqli_real_escape_string($con,$_POST["mon_min"]);
$mon_hour2=mysqli_real_escape_string($con,$_POST["mon_hour2"]);
$mon_min2=mysqli_real_escape_string($con,$_POST["mon_min2"]);
$tue_hour=mysqli_real_escape_string($con,$_POST["tue_hour"]);
$tue_min=mysqli_real_escape_string($con,$_POST["tue_min"]);
$tue_hour2=mysqli_real_escape_string($con,$_POST["tue_hour2"]);
$tue_min2=mysqli_real_escape_string($con,$_POST["tue_min2"]);
$wed_hour=mysqli_real_escape_string($con,$_POST["wed_hour"]);
$wed_min=mysqli_real_escape_string($con,$_POST["wed_min"]);
$wed_hour2=mysqli_real_escape_string($con,$_POST["wed_hour2"]);
$wed_min2=mysqli_real_escape_string($con,$_POST["wed_min2"]);
$thu_hour=mysqli_real_escape_string($con,$_POST["thu_hour"]);
$thu_min=mysqli_real_escape_string($con,$_POST["thu_min"]);
$thu_hour2=mysqli_real_escape_string($con,$_POST["thu_hour2"]);
$thu_min2=mysqli_real_escape_string($con,$_POST["thu_min2"]);
$fri_hour=mysqli_real_escape_string($con,$_POST["fri_hour"]);
$fri_min=mysqli_real_escape_string($con,$_POST["fri_min"]);
$fri_hour2=mysqli_real_escape_string($con,$_POST["fri_hour2"]);
$fri_min2=mysqli_real_escape_string($con,$_POST["fri_min2"]);
$sat_text1=mysqli_real_escape_string($con,$_POST["sat_text1"]);
$sun_text1=mysqli_real_escape_string($con,$_POST["sun_text1"]);
$mon_text1=mysqli_real_escape_string($con,$_POST["mon_text1"]);
$tue_text1=mysqli_real_escape_string($con,$_POST["tue_text1"]);
$wed_text1=mysqli_real_escape_string($con,$_POST["wed_text1"]);
$thu_text1=mysqli_real_escape_string($con,$_POST["thu_text1"]);
$fri_text1=mysqli_real_escape_string($con,$_POST["fri_text1"]);
$sat_text2=mysqli_real_escape_string($con,$_POST["sat_text2"]);
$sun_text2=mysqli_real_escape_string($con,$_POST["sun_text2"]);
$mon_text2=mysqli_real_escape_string($con,$_POST["mon_text2"]);
$tue_text2=mysqli_real_escape_string($con,$_POST["tue_text2"]);
$wed_text2=mysqli_real_escape_string($con,$_POST["wed_text2"]);
$thu_text2=mysqli_real_escape_string($con,$_POST["thu_text2"]);
$fri_text2=mysqli_real_escape_string($con,$_POST["fri_text2"]);
$sat_alt=mysqli_real_escape_string($con,$_POST["sat_alt"]);
$sun_alt=mysqli_real_escape_string($con,$_POST["sun_alt"]);
$mon_alt=mysqli_real_escape_string($con,$_POST["mon_alt"]);
$tue_alt=mysqli_real_escape_string($con,$_POST["tue_alt"]);
$wed_alt=mysqli_real_escape_string($con,$_POST["wed_alt"]);
$thu_alt=mysqli_real_escape_string($con,$_POST["thu_alt"]);
$fri_alt=mysqli_real_escape_string($con,$_POST["fri_alt"]);

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

	mysqli_query($con,"update  tbl_firm set location='".$location."',profile='".$profile."',email='$email',country='$country',companyName='$companyName',address='$address',contactNo='$contactNo',fax='$fax',googleMap='$googleMap',activeStatus='$activeStatus',titleTag='".$titleTag."',metaDescription='$metaDescription',metaKeywords='$metaKeywords',urlName='$urlName',companyType='$companyType',area='$area',network1='$network1',network2='$network2',image='$firmImage',branchId='$branchId',website='$website',service='$service',specialty='$specialty',insurance='$insurance',doctor='$doctor',work_hours='$work_hours' where id='$id'") or die(mysqli_error($con));
$rslt5=mysqli_query($con,"select * from tbl_firm_timing where hosid='$id'");
$num5=mysqli_num_rows($rslt5);
if($num5!='0'){
mysqli_query($con,"update  tbl_firm_timing set sat_hour='".$sat_hour."',sat_min='".$sat_min."',sun_hour='$sun_hour',sun_min='$sun_min',mon_hour='$mon_hour',mon_min='$mon_min',tue_hour='$tue_hour',tue_min='$tue_min',wed_hour='$wed_hour',wed_min='$wed_min',thu_hour='".$thu_hour."',thu_min='$thu_min',fri_hour='$fri_hour',fri_min='$fri_min',sat_text='$sat_text1',sun_text='$sun_text1',mon_text='$mon_text1',tue_text='$tue_text1',wed_text='$wed_text1',thu_text='$thu_text1',fri_text='$fri_text1',sat_hour2='".$sat_hour2."',sat_min2='".$sat_min2."',sun_hour2='$sun_hour2',sun_min2='$sun_min2',mon_hour2='$mon_hour2',mon_min2='$mon_min2',tue_hour2='$tue_hour2',tue_min2='$tue_min2',wed_hour2='$wed_hour2',wed_min2='$wed_min2',thu_hour2='".$thu_hour2."',thu_min2='$thu_min2',fri_hour2='$fri_hour2',fri_min2='$fri_min2',sat_text2='$sat_text2',sun_text2='$sun_text2',mon_text2='$mon_text2',tue_text2='$tue_text2',wed_text2='$wed_text2',thu_text2='$thu_text2',fri_text2='$fri_text2',sat_alt='$sat_alt',sun_alt='$sun_alt',mon_alt='$mon_alt',tue_alt='$tue_alt',wed_alt='$wed_alt',thu_alt='$thu_alt',fri_alt='$fri_alt' where hosid='$id'") or die(mysqli_error($con));    
}
else {
mysqli_query($con,"insert into tbl_firm_timing(sat_hour,sat_min,sun_hour,sun_min,mon_hour,mon_min,tue_hour,tue_min,wed_hour,wed_min,thu_hour,thu_min,fri_hour,fri_min,sat_text,sun_text,mon_text,tue_text,wed_text,thu_text,fri_text,sat_hour2,sat_min2,sun_hour2,sun_min2,mon_hour2,mon_min2,tue_hour2,tue_min2,wed_hour2,wed_min2,thu_hour2,thu_min2,fri_hour2,fri_min2,sat_text2,sun_text2,mon_text2,tue_text2,wed_text2,thu_text2,fri_text2,sat_alt,sun_alt,mon_alt,tue_alt,wed_alt,thu_alt,fri_alt,hosid)values('".$sat_hour."','".$sat_min."','$sun_hour','$sun_min','$mon_hour','$mon_min','$tue_hour','$tue_min','".$wed_hour."','$wed_min','$thu_hour','$thu_min','$fri_hour','$fri_min','$sat_text1','$sun_text1','$mon_text1','$tue_text1','$wed_text1','$thu_text1','$fri_text1','".$sat_hour2."','".$sat_min2."','$sun_hour2','$sun_min2','$mon_hour2','$mon_min2','$tue_hour2','$tue_min2','".$wed_hour2."','$wed_min2','$thu_hour2','$thu_min2','$fri_hour2','$fri_min2','$sat_text2','$sun_text2','$mon_text2','$tue_text2','$wed_text2','$thu_text2','$fri_text2','$sat_alt','$sun_alt','$mon_alt','$tue_alt','$wed_alt','$thu_alt','$fri_alt','$id')") or die(mysqli_error($con));    
}
        $_SESSION["response"]='Hospital Saved';
	echo "<script>location.href = 'manage-firm.php?id=$companyType'</script>";exit();
	
}
if(isset($_POST["savegallery"]))
{
$galleryimage = $row["image"];    
$image = new UploadImage\Image($_FILES);
$image->setLocation("../uploads/images/gallery");
if($image["galleryimage"]){
$upload = $image->upload(); 
if($upload){
$galleryimage=$image->getName().".".$image->getMime();
}else{
echo $image["error"]; 
}
}
mysqli_query($con,"insert into tbl_firm_gallery(image,firm_id,updatedOn)values('".$galleryimage."','".$id."',NOW())") or die(mysqli_error($con));    
}
if(isset($_POST["delete"]))
{
$deleteId	= mysqli_real_escape_string($con,$_POST["delete"]);
$rslt = mysqli_query($con,"select image from tbl_firm_gallery where id='$deleteId'");
$row  = mysqli_fetch_assoc($rslt);
if(!empty($row["galleryimage"]))
{
unlink("../uploads/images/gallery/".$row["gallerymage"]);
}
mysqli_query($con,"delete from tbl_firm_gallery where id='$deleteId'");
$_SESSION['response'] = 'Gallery Deleted';
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
				<h5 class="widget-name"><i class="icon-sitemap"></i>Edit Hospital <a href="manage-firm.php?id=<?php echo $companyType;?>" style="float:right;color:#555 !important;"><i style="padding:4px;" class="icon-arrow-left"></i>Back</a></h5>
<ul class="nav nav-tabs">    
<li><a href="#tab1" data-toggle="tab">General</a></li>
<!--<li><a href="#tab2" data-toggle="tab">Working Hours</a></li>-->
<li><a href="#tab3" data-toggle="tab">Specialty</a></li>
<li><a href="#tab4" data-toggle="tab">Insurance</a></li>
<li><a href="#tab5" data-toggle="tab">Services</a></li>
<?php if($id!=3){?><li><a href="#tab6" data-toggle="tab">Doctors</a></li><?php } ?>
<li><a href="#tab7" data-toggle="tab">Gallery</a></li>
<div class="form-actions align-right">
<button type="submit" class="btn btn-info" name="submit" value="save">Save</button>
<!--<button type="submit" class="btn btn-info" name="submit" value="submit">Save and Continue</button>-->
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
									
									<div class="control-group hide">
										<label class="control-label">Type: <span class="text-error">*</span></label>
										<div class="controls">											
											<select style="width:100%" name="companyType" class="validate[] styled">
											<option value="">None</option>
											<?php $rslt=mysqli_query($con,"select * from tbl_category where activeStatus=1 order by categoryName asc");
											while($row=mysqli_fetch_assoc($rslt))
											{?>
											<option value="<?php echo $row["id"];?>" <?php if($row["id"]==$companyType) echo "selected";?>><?php echo $row["categoryName"];?></option>
											<?php }?>
											</select>
										</div>
									</div>
									<div class="control-group">
										 <label class="control-label">Branch Of: <span class="text-error">*</span> </label>
										 <div class="controls">
											<select style="width:100%" name="branchId" class="validate[] styled">
											<option value="0">None</option>
											<?php $rslt=mysqli_query($con,"select * from tbl_firm where userId='".$userId."' order by companyName asc");
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
											 <input style="width:100%" type="text" value="<?php echo $companyName;?>" class="validate[required] input-xlarge"  name="companyName" id="companyName"/>
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
											<select style="width:100%" name="country" class="validate[required] styled">
											<?php $rslt=mysqli_query($con,"select * from tbl_countries order by countryName asc");
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
											<select style="width:100%" name="location" class="validate[required] styled">
											<?php $rslt=mysqli_query($con,"select * from tbl_locations order by region asc");
											while($row=mysqli_fetch_assoc($rslt))
											{												
											?>
												<option value="<?php echo $row["region"];?>" <?php if($row["region"]==$location) echo "selected";?>><?php echo $row["region"];?></option>
											<?php 
											}?>
											</select>
										 </div>
									</div>
									<div class="control-group">
										 <label class="control-label">Area:</label>
										 <div class="controls">
										<select style="width:100%" name="area" class="validate[required] styled">
											<?php $rslt=mysqli_query($con,"select * from tbl_area order by area asc");
											while($row=mysqli_fetch_assoc($rslt))
											{												
											?>
												<option value="<?php echo $row["area"];?>" <?php if($row["area"]==$area) echo "selected";?>><?php echo $row["area"];?></option>
											<?php 
											}?>
											</select>
										 </div>
									</div>
									<div class="control-group">
										<label class="control-label">Address: <span class="text-error">*</span></label>
										<div class="controls">
											<textarea style="width:100%" rows="5" cols="5" name="address" class="validate[required] input-xlarge"><?php echo $address;?></textarea>
										</div>
									</div>
									<div class="control-group">
										 <label class="control-label">Contact Number: <span class="text-error">*</span> </label>
										 <div class="controls">
											 <input type="text" style="width:100%" value="<?php echo $contactNo;?>" class="validate[required] input-xlarge"  name="contactNo" id="contactNo"/>
										 </div>
									 </div>
									 
									 <div class="control-group">
										 <label class="control-label">Fax: </label>
										 <div class="controls">
											 <input type="text" style="width:100%" value="<?php echo $fax;?>" class="validate[] input-xlarge"  name="fax" id="fax"/>
										 </div>
									 </div>
									 <div class="control-group">
										 <label class="control-label">Email: <span class="text-error">*</span> </label>
										 <div class="controls">
											 <input type="text" style="width:100%" value="<?php echo $email;?>" class="validate[custom[email]] input-xlarge"  name="email" id="email"/>
										 </div>
									 </div>
									
									
									 
								</div>
	                        <div class="span6 well">
 <div class="control-group">
										 <label class="control-label">Website: <span class="text-error">*</span> </label>
										 <div class="controls">
											 <input type="text" style="width:100%" value="<?php echo $website;?>" class="validate[] input-xlarge"  name="website" id="website"/>
										 </div>
									 </div>
									 <div class="control-group">
										 <label class="control-label">Network 1:</label>
										 <div class="controls">
											 <input type="text" style="width:100%" value="<?php echo $network1;?>" class="validate[] input-xlarge"  name="network1" id="network2"/>
										 </div>
									</div>
									<div class="control-group">
										 <label class="control-label">Network 2:</label>
										 <div class="controls">
											 <input type="text" style="width:100%" value="<?php echo $network2;?>" class="validate[] input-xlarge"  name="network2" id="network2"/>
										 </div>
									</div>                                    
<div class="control-group">
<label class="control-label">Woking Hours:</label>
<div class="controls">
<input type="text" style="width:100%" value="<?php echo $work_hours;?>" class="validate[] input-xlarge"  name="work_hours" id="work_hours"/>
</div>
</div>                                    
									<div class="control-group">
										<label class="control-label">Google Map Iframe: </label>
										<div class="controls">
											<textarea rows="7" style="width:100%" cols="5" name="googleMap" class="validate[] span12"><?php echo $googleMap;?></textarea>
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
	                                    <input type="text" style="width:100%" value="<?php echo $urlName;?>" maxlength="65" class="validate[] input-xlarge " name="urlName" id="urlName"/>
	                                </div>
	                            </div>
                                <div class="control-group">
	                                <label class="control-label">Title Tag: <br>(Max 65 Characters)</label>
	                                <div class="controls">
	                                    <input type="text" style="width:100%" value="<?php echo $titleTag;?>" maxlength="65" class="validate[] input-xlarge " name="titleTag" id="titleTag"/>
	                                </div>
	                            </div>
                                <div class="control-group">
	                                <label class="control-label">Meta Description: <br>(Max 170 Characters)</label>
	                                <div class="controls">
	                                    <textarea rows="5" style="width:100%" cols="5" id="metaDescription" maxlength="250" name="metaDescription" class="validate[]  span12"><?php echo $metaDescription;?></textarea>
	                                </div>
	                            </div>
                                <div class="control-group">
	                                <label class="control-label">Meta Keywords: <br>(Max 250 Characters)</label>
	                                <div class="controls">
	                                    <textarea rows="5" style="width:100%" cols="5" id="metaKeywords" maxlength="250" name="metaKeywords" class="validate[]  span12"><?php echo $metaKeywords;?></textarea>
	                                </div>
	                            </div>
                 
<!--									<div class="form-actions align-right">
										<button type="submit" class="btn btn-info" name="submit" value="save">Save</button>
									</div>-->
								</div>
<!--									</form>-->
	                        
							</div>
							
							</div>
<div class="tab-pane" id="tab2">
<div class="well row-fluid">
<div class="span12 well">
<div class="control-group">
<div class="controls">	
<?php
$rslt6=mysqli_query($con,"select * from tbl_firm_timing where hosid='$id'");
$row6=mysqli_fetch_assoc($rslt6);
?>    
<table border="0" style="width:100%">
<tr><th>Day</th><th>Opening Time</th><th>Closing Time</th><th></th><th>Alternative Text</th></tr>
<tr>
<td>Saturday</td> 
<td>
<select name="sat_hour">
<option value="">H</option>
<?php
$rslt=mysqli_query($con,"select * from tbl_hour limit 12");
while($row=mysqli_fetch_array($rslt))
{
?>
<option <?php if($row6['sat_hour']==$row['name']){ echo'selected';}?> value="<?php echo $row['name'];?>"><?php echo $row['name'];?></option>
<?php } ?>
</select> 
<select name="sat_min">
<option value="">M</option>  
<?php
$rslt=mysqli_query($con,"select * from tbl_minutes");
while($row=mysqli_fetch_array($rslt))
{
?>
<option <?php if($row6['sat_min']==$row['name']){ echo'selected';}?> value="<?php echo $row['name'];?>"><?php echo $row['name'];?></option>
<?php } ?>
</select> 
<input type="text" name="sat_text1" value="<?php echo $row6['sat_text'];?>" style="width: 78px;" placeholder="am/pm">    
<!--<select name="sat_text1">
<option value="">am/pm</option>  
<option value="am">am</option>
<option value="pm">pm</option>
</select>     -->
</td>
<td>
<select name="sat_hour2">
<option value="">H</option>
<?php
$rslt=mysqli_query($con,"select * from tbl_hour limit 12");
while($row=mysqli_fetch_array($rslt))
{
?>
<option <?php if($row6['sat_hour2']==$row['name']){ echo'selected';}?> value="<?php echo $row['name'];?>"><?php echo $row['name'];?></option>
<?php } ?>
</select>  
<select name="sat_min2">
<option value="">M</option>  
<?php
$rslt=mysqli_query($con,"select * from tbl_minutes");
while($row=mysqli_fetch_array($rslt))
{
?>
<option <?php if($row6['sat_min2']==$row['name']){ echo'selected';}?> value="<?php echo $row['name'];?>"><?php echo $row['name'];?></option>
<?php } ?>
</select> 
<input type="text" name="sat_text2" value="<?php echo $row6['sat_text2'];?>" style="width: 78px;" placeholder="am/pm">
<!--<select name="sat_text2">
<option value="">am/pm</option>  
<option value="am">am</option>
<option value="pm">pm</option>
</select>     -->
</td>
<td><input type="checkbox" id="sat_check"></td>
<td><input type="text" value="<?php echo $row6['sat_alt'];?>" placeholder="Alternate Text" <?php if($row6['sat_alt']==''){ echo'disabled'; }?> id="sat_alt" name="sat_alt"></td>
</tr> 
<tr>
<td>Sunday</td> 
<td>
<select name="sun_hour">
<option value="">H</option>
<?php
$rslt=mysqli_query($con,"select * from tbl_hour limit 12");
while($row=mysqli_fetch_array($rslt))
{
?>
<option <?php if($row6['sun_hour']==$row['name']){ echo'selected';}?> value="<?php echo $row['name'];?>"><?php echo $row['name'];?></option>
<?php } ?>
</select> 
<select name="sun_min">
<option value="">M</option>  
<?php
$rslt=mysqli_query($con,"select * from tbl_minutes");
while($row=mysqli_fetch_array($rslt))
{
?>
<option <?php if($row6['sun_min']==$row['name']){ echo'selected';}?> value="<?php echo $row['name'];?>"><?php echo $row['name'];?></option>
<?php } ?>
</select> 
<input type="text" name="sun_text1" value="<?php echo $row6['sun_text'];?>" style="width: 78px;" placeholder="am/pm">    
<!--<select name="sun_text1">
<option value="">am/pm</option>  
<option value="am">am</option>
<option value="pm">pm</option>
</select>     -->
</td>
<td>
<select name="sun_hour2">
<option value="">H</option>
<?php
$rslt=mysqli_query($con,"select * from tbl_hour limit 12");
while($row=mysqli_fetch_array($rslt))
{
?>
<option <?php if($row6['sun_hour2']==$row['name']){ echo'selected';}?> value="<?php echo $row['name'];?>"><?php echo $row['name'];?></option>
<?php } ?>
</select>  
<select name="sun_min2">
<option value="">M</option>  
<?php
$rslt=mysqli_query($con,"select * from tbl_minutes");
while($row=mysqli_fetch_array($rslt))
{
?>
<option <?php if($row6['sun_min2']==$row['name']){ echo'selected';}?> value="<?php echo $row['name'];?>"><?php echo $row['name'];?></option>
<?php } ?>
</select> 
<input type="text" name="sun_text2" value="<?php echo $row6['sun_text2'];?>" style="width: 78px;" placeholder="am/pm">    
<!--<select name="sun_text2">
<option value="">am/pm</option>  
<option value="am">am</option>
<option value="pm">pm</option>
</select>     -->
</td>
<td><input type="checkbox" id="sun_check"></td>
<td><input type="text" value="<?php echo $row6['sun_alt'];?>" placeholder="Alternate Text" <?php if($row6['sun_alt']==''){ echo'disabled'; }?> id="sun_alt" name="sun_alt"></td>
</tr> 
<tr>
<td>Monday</td> 
<td>
<select name="mon_hour">
<option value="">H</option>
<?php
$rslt=mysqli_query($con,"select * from tbl_hour limit 12");
while($row=mysqli_fetch_array($rslt))
{
?>
<option <?php if($row6['mon_hour']==$row['name']){ echo'selected';}?> value="<?php echo $row['name'];?>"><?php echo $row['name'];?></option>
<?php } ?>
</select> 
<select name="mon_min">
<option value="">M</option>  
<?php
$rslt=mysqli_query($con,"select * from tbl_minutes");
while($row=mysqli_fetch_array($rslt))
{
?>
<option <?php if($row6['mon_min']==$row['name']){ echo'selected';}?> value="<?php echo $row['name'];?>"><?php echo $row['name'];?></option>
<?php } ?>
</select> 
<input type="text" name="mon_text1" value="<?php echo $row6['mon_text'];?>" style="width: 78px;" placeholder="am/pm">    
<!--<select name="sun_text1">
<option value="">am/pm</option>  
<option value="am">am</option>
<option value="pm">pm</option>
</select>     -->
</td>
<td>
<select name="mon_hour2">
<option value="">H</option>
<?php
$rslt=mysqli_query($con,"select * from tbl_hour limit 12");
while($row=mysqli_fetch_array($rslt))
{
?>
<option <?php if($row6['mon_hour2']==$row['name']){ echo'selected';}?> value="<?php echo $row['name'];?>"><?php echo $row['name'];?></option>
<?php } ?>
</select>  
<select name="mon_min2">
<option value="">M</option>  
<?php
$rslt=mysqli_query($con,"select * from tbl_minutes");
while($row=mysqli_fetch_array($rslt))
{
?>
<option <?php if($row6['mon_min2']==$row['name']){ echo'selected';}?> value="<?php echo $row['name'];?>"><?php echo $row['name'];?></option>
<?php } ?>
</select> 
<input type="text" name="mon_text2" value="<?php echo $row6['mon_text2'];?>" style="width: 78px;" placeholder="am/pm">    
<!--<select name="sun_text2">
<option value="">am/pm</option>  
<option value="am">am</option>
<option value="pm">pm</option>
</select>     -->
</td>
<td><input type="checkbox" id="mon_check"></td>
<td><input type="text" value="<?php echo $row6['mon_alt'];?>" placeholder="Alternate Text" <?php if($row6['mon_alt']==''){ echo'disabled'; }?> id="mon_alt" name="mon_alt"></td>
</tr> 
<tr>
<td>Tuesday</td> 
<td>
<select name="tue_hour">
<option value="">H</option>
<?php
$rslt=mysqli_query($con,"select * from tbl_hour limit 12");
while($row=mysqli_fetch_array($rslt))
{
?>
<option <?php if($row6['tue_hour']==$row['name']){ echo'selected';}?> value="<?php echo $row['name'];?>"><?php echo $row['name'];?></option>
<?php } ?>
</select> 
<select name="tue_min">
<option value="">M</option>  
<?php
$rslt=mysqli_query($con,"select * from tbl_minutes");
while($row=mysqli_fetch_array($rslt))
{
?>
<option <?php if($row6['tue_min']==$row['name']){ echo'selected';}?> value="<?php echo $row['name'];?>"><?php echo $row['name'];?></option>
<?php } ?>
</select> 
<input type="text" name="tue_text1" value="<?php echo $row6['tue_text'];?>" style="width: 78px;" placeholder="am/pm">    
<!--<select name="sun_text1">
<option value="">am/pm</option>  
<option value="am">am</option>
<option value="pm">pm</option>
</select>     -->
</td>
<td>
<select name="tue_hour2">
<option value="">H</option>
<?php
$rslt=mysqli_query($con,"select * from tbl_hour limit 12");
while($row=mysqli_fetch_array($rslt))
{
?>
<option <?php if($row6['tue_hour2']==$row['name']){ echo'selected';}?> value="<?php echo $row['name'];?>"><?php echo $row['name'];?></option>
<?php } ?>
</select>  
<select name="tue_min2">
<option value="">M</option>  
<?php
$rslt=mysqli_query($con,"select * from tbl_minutes");
while($row=mysqli_fetch_array($rslt))
{
?>
<option <?php if($row6['tue_min2']==$row['name']){ echo'selected';}?> value="<?php echo $row['name'];?>"><?php echo $row['name'];?></option>
<?php } ?>
</select> 
<input type="text" name="tue_text2" value="<?php echo $row6['tue_text2'];?>" style="width: 78px;" placeholder="am/pm">    
<!--<select name="sun_text2">
<option value="">am/pm</option>  
<option value="am">am</option>
<option value="pm">pm</option>
</select>     -->
</td>
<td><input type="checkbox" id="tue_check"></td>
<td><input type="text" value="<?php echo $row6['tue_alt'];?>" placeholder="Alternate Text" <?php if($row6['tue_alt']==''){ echo'disabled'; }?> id="tue_alt" name="tue_alt"></td>
</tr> 
<tr>
<td>Wednesday</td> 
<td>
<select name="wed_hour">
<option value="">H</option>
<?php
$rslt=mysqli_query($con,"select * from tbl_hour limit 12");
while($row=mysqli_fetch_array($rslt))
{
?>
<option <?php if($row6['wed_hour']==$row['name']){ echo'selected';}?> value="<?php echo $row['name'];?>"><?php echo $row['name'];?></option>
<?php } ?>
</select> 
<select name="wed_min">
<option value="">M</option>  
<?php
$rslt=mysqli_query($con,"select * from tbl_minutes");
while($row=mysqli_fetch_array($rslt))
{
?>
<option <?php if($row6['wed_min']==$row['name']){ echo'selected';}?> value="<?php echo $row['name'];?>"><?php echo $row['name'];?></option>
<?php } ?>
</select> 
<input type="text" name="wed_text1" value="<?php echo $row6['wed_text'];?>" style="width: 78px;" placeholder="am/pm">    
<!--<select name="sun_text1">
<option value="">am/pm</option>  
<option value="am">am</option>
<option value="pm">pm</option>
</select>     -->
</td>
<td>
<select name="wed_hour2">
<option value="">H</option>
<?php
$rslt=mysqli_query($con,"select * from tbl_hour limit 12");
while($row=mysqli_fetch_array($rslt))
{
?>
<option <?php if($row6['wed_hour2']==$row['name']){ echo'selected';}?> value="<?php echo $row['name'];?>"><?php echo $row['name'];?></option>
<?php } ?>
</select>  
<select name="wed_min2">
<option value="">M</option>  
<?php
$rslt=mysqli_query($con,"select * from tbl_minutes");
while($row=mysqli_fetch_array($rslt))
{
?>
<option <?php if($row6['wed_min2']==$row['name']){ echo'selected';}?> value="<?php echo $row['name'];?>"><?php echo $row['name'];?></option>
<?php } ?>
</select> 
<input type="text" name="wed_text2" value="<?php echo $row6['wed_text2'];?>" style="width: 78px;" placeholder="am/pm">    
<!--<select name="sun_text2">
<option value="">am/pm</option>  
<option value="am">am</option>
<option value="pm">pm</option>
</select>     -->
</td>
<td><input type="checkbox" id="wed_check"></td>
<td><input type="text" value="<?php echo $row6['wed_alt'];?>" placeholder="Alternate Text" <?php if($row6['wed_alt']==''){ echo'disabled'; }?> id="wed_alt" name="wed_alt"></td>
</tr> 
<tr>
<td>Thursday</td> 
<td>
<select name="thu_hour">
<option value="">H</option>
<?php
$rslt=mysqli_query($con,"select * from tbl_hour limit 12");
while($row=mysqli_fetch_array($rslt))
{
?>
<option <?php if($row6['thu_hour']==$row['name']){ echo'selected';}?> value="<?php echo $row['name'];?>"><?php echo $row['name'];?></option>
<?php } ?>
</select> 
<select name="thu_min">
<option value="">M</option>  
<?php
$rslt=mysqli_query($con,"select * from tbl_minutes");
while($row=mysqli_fetch_array($rslt))
{
?>
<option <?php if($row6['thu_min']==$row['name']){ echo'selected';}?> value="<?php echo $row['name'];?>"><?php echo $row['name'];?></option>
<?php } ?>
</select> 
<input type="text" name="thu_text1" value="<?php echo $row6['thu_text'];?>" style="width: 78px;" placeholder="am/pm">    
<!--<select name="sun_text1">
<option value="">am/pm</option>  
<option value="am">am</option>
<option value="pm">pm</option>
</select>     -->
</td>
<td>
<select name="thu_hour2">
<option value="">H</option>
<?php
$rslt=mysqli_query($con,"select * from tbl_hour limit 12");
while($row=mysqli_fetch_array($rslt))
{
?>
<option <?php if($row6['thu_hour2']==$row['name']){ echo'selected';}?> value="<?php echo $row['name'];?>"><?php echo $row['name'];?></option>
<?php } ?>
</select>  
<select name="thu_min2">
<option value="">M</option>  
<?php
$rslt=mysqli_query($con,"select * from tbl_minutes");
while($row=mysqli_fetch_array($rslt))
{
?>
<option <?php if($row6['thu_min2']==$row['name']){ echo'selected';}?> value="<?php echo $row['name'];?>"><?php echo $row['name'];?></option>
<?php } ?>
</select> 
<input type="text" name="thu_text2" value="<?php echo $row6['thu_text2'];?>" style="width: 78px;" placeholder="am/pm">    
<!--<select name="sun_text2">
<option value="">am/pm</option>  
<option value="am">am</option>
<option value="pm">pm</option>
</select>     -->
</td>
<td><input type="checkbox" id="thu_check"></td>
<td><input type="text" value="<?php echo $row6['thu_alt'];?>" placeholder="Alternate Text" <?php if($row6['thu_alt']==''){ echo'disabled'; }?> id="thu_alt" name="thu_alt"></td>
</tr> 
<tr>
<td>Friday</td> 
<td>
<select name="fri_hour">
<option value="">H</option>
<?php
$rslt=mysqli_query($con,"select * from tbl_hour limit 12");
while($row=mysqli_fetch_array($rslt))
{
?>
<option <?php if($row6['fri_hour']==$row['name']){ echo'selected';}?> value="<?php echo $row['name'];?>"><?php echo $row['name'];?></option>
<?php } ?>
</select> 
<select name="fri_min">
<option value="">M</option>  
<?php
$rslt=mysqli_query($con,"select * from tbl_minutes");
while($row=mysqli_fetch_array($rslt))
{
?>
<option <?php if($row6['fri_min']==$row['name']){ echo'selected';}?> value="<?php echo $row['name'];?>"><?php echo $row['name'];?></option>
<?php } ?>
</select> 
<input type="text" name="fri_text1" value="<?php echo $row6['fri_text'];?>" style="width: 78px;" placeholder="am/pm">    
<!--<select name="sun_text1">
<option value="">am/pm</option>  
<option value="am">am</option>
<option value="pm">pm</option>
</select>     -->
</td>
<td>
<select name="fri_hour2">
<option value="">H</option>
<?php
$rslt=mysqli_query($con,"select * from tbl_hour limit 12");
while($row=mysqli_fetch_array($rslt))
{
?>
<option <?php if($row6['fri_hour2']==$row['name']){ echo'selected';}?> value="<?php echo $row['name'];?>"><?php echo $row['name'];?></option>
<?php } ?>
</select>  
<select name="fri_min2">
<option value="">M</option>  
<?php
$rslt=mysqli_query($con,"select * from tbl_minutes");
while($row=mysqli_fetch_array($rslt))
{
?>
<option <?php if($row6['fri_min2']==$row['name']){ echo'selected';}?> value="<?php echo $row['name'];?>"><?php echo $row['name'];?></option>
<?php } ?>
</select> 
<input type="text" name="fri_text2" value="<?php echo $row6['fri_text2'];?>" style="width: 78px;" placeholder="am/pm">    
<!--<select name="sun_text2">
<option value="">am/pm</option>  
<option value="am">am</option>
<option value="pm">pm</option>
</select>     -->
</td>
<td><input type="checkbox" id="fri_check"></td>
<td><input type="text" value="<?php echo $row6['fri_alt'];?>" placeholder="Alternate Text" <?php if($row6['fri_alt']==''){ echo'disabled'; }?> id="fri_alt" name="fri_alt"></td>
</tr> 
</table>
</div>
</div>
</div>
</div>
</div>
<div class="tab-pane" id="tab3">
<div class="well row-fluid">
<div class="span12 well">
<div class="control-group">
<label class="control-label">Specialty: <span class="text-error">*</span></label>
<div class="controls">
<table border="0" style="width:100%">
<tr>    



<?php
$sl=1;
										$catArray=explode(',',$specialty);
										$rslt=mysqli_query($con,"select * from tbl_specialty order by Name asc");
										while($row=mysqli_fetch_array($rslt))
										{ $sl++;											
										?>
<td><input <?php if(in_array($row["id"],$catArray)) echo "checked";?> type="checkbox" name="specialty[]" value="<?php echo $row['id'];?>"> <?php echo $row['Name'];?></td> 
<?php if ($sl%2==1){ echo "<tr>";}?>
<?php }?>
</tr>
</table>    
</div>
</div>
</div>
</div>
</div>                                
<div class="tab-pane" id="tab4">
<div class="well row-fluid">
<div class="span12 well">
<label class="control-label">Insurance: <span class="text-error">*</span></label>
<div class="controls">
<table border="0" style="width:100%">    
<tr>
<?php
$sl=1;
$catArray=explode(',',$insurance);
$rslt=mysqli_query($con,"select * from tbl_insurance order by insurance asc");
while($row=mysqli_fetch_array($rslt))
{ $sl++;											
?>   
<td title="<?php echo $row['insurance'];?>"><input <?php if(in_array($row["id"],$catArray)) echo "checked";?> type="checkbox" name="insurance[]" value="<?php echo $row['id'];?>"> <?php echo $row['insurance'];?></td>
<?php if($sl%2==1){ echo"<tr>";}?>
<?php } ?> 
</tr>
</table>
</div>
</div>
</div>
</div>
<div class="tab-pane" id="tab5">
<div class="well row-fluid">
<div class="span12 well">
<div class="control-group">
<label class="control-label">Services: <span class="text-error">*</span></label>
<div class="controls">
<table border="0" style="width:100%">
<tr>    



<?php
$sl=1;
										$catArray=explode(',',$service);
										$rslt=mysqli_query($con,"select * from tbl_services order by name asc");
										while($row=mysqli_fetch_array($rslt))
										{ $sl++;											
										?>
<td><input <?php if(in_array($row["id"],$catArray)) echo "checked";?> type="checkbox" name="service[]" value="<?php echo $row['id'];?>"> <?php echo $row['name'];?></td> 
<?php if ($sl%2==1){ echo "<tr>";}?>
<?php }?>
</tr>
</table>    
</div>
</div>
</div>
</div>
</div> 
<div class="tab-pane" id="tab6">
<div class="well row-fluid">
<div class="span12 well">
<label class="control-label">Doctors: <span class="text-error">*</span></label>
<div class="controls">   
<table border="0" style="width:100%">
<tr>    



<?php
$sl=1;
										$catArray=explode(',',$doctor);
										$rslt=mysqli_query($con,"select * from tbl_trainers where activeStatus=1 and type=3 order by fullName asc");
										while($row=mysqli_fetch_array($rslt))
										{ $sl++;											
										?>
<td><input <?php if(in_array($row["id"],$catArray)) echo "checked";?> type="checkbox" name="doctor[]" value="<?php echo $row['id'];?>"> <?php echo $row['fullName'];?></td> 
<?php if ($sl%2==1){ echo "<tr>";}?>
<?php }?>
</tr>
</table>    
</div>
</div>
</div>
</div>
<div class="tab-pane" id="tab7">
<div class="well row-fluid">
<div class="span12 well">
<label class="control-label">Gallery Images: <span class="text-error">*</span><br> w:960px ; h:640px</label>
<div class="controls">
<input type="file" name="galleryimage">
<input type="submit" class="btn btn-info" name="savegallery" value="Upload">
<br clear="all"><br clear="all">
<table class="table table-striped table-bordered table-checks">
<thead>
<tr>
<th>Sr.No.</th>
<th>Image</th>
<th>Added On</th>
<th class="actions-column">Actions</th>
</tr>
</thead>
<tbody>
<?php
$rslt=mysqli_query($con,"SELECT * from tbl_firm_gallery where firm_id=$id");
$i=0;
while($row=mysqli_fetch_array($rslt))
{
$i++;
?>
<tr>
<td><?php echo $i;?></td>
<td><img src="../uploads/images/gallery/<?php echo $row["image"]; ?>" style="width:100px;height:100px"></td>
<td><?php echo $row['updatedOn'];?></td>
<td>
<ul class="navbar-icons">
<li><button type="submit" title="Remove" onClick="return clickMe()" value="<?php echo $row['id'];?>" class="remove-button-icon" name="delete"><i class="icon-remove"></i></button></li>
</ul>
</td>
</tr>
<?php } ?>
</table>
</div>
</div>
</div>
</div>                                
</div>							
</form>                         
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
<script>
document.getElementById('sat_check').onchange = function() {
    document.getElementById('sat_alt').disabled = !this.checked;
};
document.getElementById('sun_check').onchange = function() {
    document.getElementById('sun_alt').disabled = !this.checked;
};
document.getElementById('mon_check').onchange = function() {
    document.getElementById('mon_alt').disabled = !this.checked;
};
document.getElementById('tue_check').onchange = function() {
    document.getElementById('tue_alt').disabled = !this.checked;
};
document.getElementById('wed_check').onchange = function() {
    document.getElementById('wed_alt').disabled = !this.checked;
};
document.getElementById('thu_check').onchange = function() {
    document.getElementById('thu_alt').disabled = !this.checked;
};
document.getElementById('fri_check').onchange = function() {
    document.getElementById('fri_alt').disabled = !this.checked;
};
</script>
<script type="text/javascript">	
CKEDITOR.replace('profile');        
</script>
</body>
</html>
