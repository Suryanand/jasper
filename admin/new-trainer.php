<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
include('get-user.php'); /* Geting logged in user details*/
include('functions.php');
error_reporting(0);
$id=$_GET['id'];
if($userType != 1) /* This page only for admin - if normal user redirect to index page */
{
	header('location: index.php');
}
if(isset($_POST["submit"]))
{
$language = implode(',', $_POST['language']); 
$specialized = implode(',', $_POST['specialized']); 
$plid = implode(',', $_POST['plid']); 
$nationality = mysqli_real_escape_string($con,$_POST["nationality"]);
$hierarchy = mysqli_real_escape_string($con,$_POST["hierarchy"]);
//	$country = mysqli_real_escape_string($con,$_POST["country"]);
	$address = mysqli_real_escape_string($con,$_POST["address"]);
	$area = mysqli_real_escape_string($con,$_POST["area"]);
//	$specialized = mysqli_real_escape_string($con,$_POST["specialized"]);
	$qualification = mysqli_real_escape_string($con,$_POST["qualification"]);
	$location=mysqli_real_escape_string($con,$_POST["location"]);
	$fullName	=mysqli_real_escape_string($con,$_POST["fullName"]);
	$profile	=mysqli_real_escape_string($con,$_POST["profile"]);
	$email	=mysqli_real_escape_string($con,$_POST["email"]);
	$contactNo	=mysqli_real_escape_string($con,$_POST["contactNo"]);
	//$fax	=mysqli_real_escape_string($con,$_POST["fax"]);
	$googleMap	=mysqli_real_escape_string($con,$_POST["googleMap"]);
	$activeStatus=mysqli_real_escape_string($con,$_POST["activeStatus"]);
        $gender = mysqli_real_escape_string($con,$_POST["gender"]);
        $age = mysqli_real_escape_string($con,$_POST["age"]);
        $experience = mysqli_real_escape_string($con,$_POST["experience"]);
        $awards = mysqli_real_escape_string($con,$_POST["awards"]);
        $specialist= mysqli_real_escape_string($con,$_POST["specialist"]);
	$doctorImage="";
	$image = new UploadImage\Image($_FILES);
	$image->setLocation("../uploads/images/trainers");
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

	
	mysqli_query($con,"insert into tbl_trainers(userId,location,fullName,address,contactNo,googleMap,activeStatus,titleTag,metaDescription,metaKeywords,urlName,area,specialized,qualification,image,email,profile,gender,age,language,hierarchy,nationality,practice,updatedOn,type,experience,awards,specialist)values('0','".$location."','$fullName','$address','$contactNo','$googleMap','$activeStatus','".$titleTag."','$metaDescription','$metaKeywords','$urlName','$area','$specialized','$qualification','$doctorImage','$email','$profile','$gender','$age','$language','$hierarchy','$nationality','$plid',NOW(),'$id','$experience','$awards','$specialist')") or die(mysqli_error($con));
	$_SESSION["response"]='Details Saved';
	echo "<script>location.href = 'manage-trainer.php?id=$id'</script>";exit();
	
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
				<h5 class="widget-name"><i class="icon-sitemap"></i>New <?php if($id=='0'){ echo 'Trainer';} elseif($id=='1') { echo 'Nutritionist';} elseif($id=='2') { echo 'Club Manager';} else { echo 'Doctor';}?> <a href="manage-trainer.php?id=<?php echo $id;?>" style="float:right;color:#555 !important;"><i style="padding:4px;" class="icon-arrow-left"></i>Back</a></h5>
	                <ul class="nav nav-tabs">    
<li><a href="#tab1" data-toggle="tab">General</a></li>
<li><a href="#tab2" data-toggle="tab">Practice Location</a></li>
<li><a href="#tab3" data-toggle="tab">Specialized</a></li>
<li><a href="#tab4" data-toggle="tab">Language</a></li>
<li><a href="#tab5" data-toggle="tab">Education</a></li>
<li><a href="#tab6" data-toggle="tab">Work Experience</a></li>
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
											 <input type="text" style="width:100%" value="" class="validate[required] input-xlarge"  name="fullName" id="fullName"/>
										 </div>
									</div>
									
                                                            <div class="control-group">
										 <label class="control-label">Nationality: <span class="text-error">*</span> </label>
										 <div class="controls">
											<select style="width:100%" name="nationality" class="validate[required] styled">
											<?php $rslt=mysqli_query($con,"select * from tbl_nationality order by Name asc");
											while($row=mysqli_fetch_assoc($rslt))
											{												
											?>
												<option value="<?php echo $row["Name"];?>" ><?php echo $row["Name"];?></option>
											<?php 
											}?>
											</select>
										 </div>
									</div>
                                                            
                                                            <div class="control-group">
										 <label class="control-label">Hierarchy: <span class="text-error">*</span> </label>
										 <div class="controls">
										<label class="radio inline">
												<input class="styled" type="radio" checked name="hierarchy"  value="1" data-prompt-position="topLeft:-1,-5"/>
												Specialist
											</label>
											<label class="radio inline">
												<input class="styled" type="radio"  name="hierarchy"  value="0" data-prompt-position="topLeft:-1,-5"/>
												Consultant
											</label>
										 </div>
									</div>
                                                            <div class="control-group">
										 <label class="control-label">Specialist: </label>
										 <div class="controls">
										<select style="width:100%" name="specialist" class="styled">
                                                                                    <option value="">Choose One</option>
											<?php 
                                                                                        if($id==3){
                                                                                        $rslt=mysqli_query($con,"select * from tbl_specialist where type=1 order by Name asc");
                                                                                        }
                                                                                        else {
                                                                                        $rslt=mysqli_query($con,"select * from tbl_specialist where type=2 order by Name asc");    
                                                                                        }
											while($row=mysqli_fetch_assoc($rslt))
											{												
											?>
												<option value="<?php echo $row["Name"];?>" ><?php echo $row["Name"];?></option>
											<?php 
											}?>
											</select>
										 </div>
									</div>
									<div class="control-group hide">
										 <label class="control-label">Education Details: <span class="text-error">*</span> </label>
										 <div class="controls">
											 <textarea style="width:100%" rows="5" cols="5" name="qualification" class="input-xlarge"></textarea>
										 </div>
									</div>
                                                          
									<div class="control-group">
										<label class="control-label">Profile: <span class="text-error">*</span></label>
										<div class="controls">
											<textarea style="width:100%" rows="5" cols="5" name="profile" class="validate[] input-xlarge"></textarea>
										</div>
									</div>
									<div class="control-group hide">
										 <label class="control-label">Country: <span class="text-error">*</span> </label>
										 <div class="controls">
											<select style="width:100%" name="country" class="validate[required] styled">
											<?php $rslt=mysqli_query($con,"select * from tbl_countries order by countryName asc");
											while($row=mysqli_fetch_assoc($rslt))
											{												
											?>
												<option value="<?php echo $row["countryName"];?>" ><?php echo $row["countryName"];?></option>
											<?php 
											}?>
											</select>
										 </div>
									</div>
									<div class="control-group">
										 <label class="control-label">Location:<span class="text-error">*</span></label>
										 <div class="controls">
										<select style="width:100%" name="location" class="validate[required] styled">
											<?php $rslt=mysqli_query($con,"select * from tbl_locations order by region asc");
											while($row=mysqli_fetch_assoc($rslt))
											{												
											?>
												<option value="<?php echo $row["region"];?>"><?php echo $row["region"];?></option>
											<?php 
											}?>
											</select>
										 </div>
									</div>
									<div class="control-group">
										 <label class="control-label">Area:<span class="text-error">*</span></label>
										 <div class="controls">
											<select style="width:100%" name="area" class="validate[required] styled">
											<?php $rslt=mysqli_query($con,"select * from tbl_area order by area asc");
											while($row=mysqli_fetch_assoc($rslt))
											{												
											?>
												<option value="<?php echo $row["area"];?>"><?php echo $row["area"];?></option>
											<?php 
											}?>
											</select>
										 </div>
									</div>
									<div class="control-group">
										<label class="control-label">Address:</label>
										<div class="controls">
											<textarea rows="5" style="width:100%" cols="5" name="address" class="input-xlarge"></textarea>
										</div>
									</div>
                                                            	 <div class="control-group">
										 <label class="control-label">Email: </label>
										 <div class="controls">
											 <input type="text" style="width:100%" value="" class="input-xlarge"  name="email" id="email"/>
										 </div>
									 </div>									 
									<div class="control-group">
										<label class="control-label">Gender: <span class="text-error">*</span></label>
										<div class="controls">
											<label class="radio inline">
												<input class="styled" type="radio" checked name="gender"  value="1" data-prompt-position="topLeft:-1,-5"/>
												Male
											</label>
											<label class="radio inline">
												<input class="styled" type="radio"  name="gender"  value="0" data-prompt-position="topLeft:-1,-5"/>
												Female
											</label>
											
										</div>
									</div>
									 <div class="control-group">
										 <label class="control-label">Years of Experience: </label>
										 <div class="controls">
											 <input type="text" style="width:100%"  class="input-xlarge"  name="age" id="age"/>
										 </div>
									 </div>                                     
									<div class="control-group">
										<label class="control-label">Google Map Iframe: </label>
										<div class="controls">
											<textarea rows="7" style="width:100%" cols="5" name="googleMap" class="validate[] span12"></textarea>
										</div>
									</div>
									 
									
								
								</div>
	                        <div class="span6 well">
                                     <div class="control-group">
										 <label class="control-label">Image: </label>
										 <div class="controls">
											 <input type="file" value="" class=""  name="doctorImage" id="doctorImage"/>
										 </div>
									 </div>
	<div class="control-group">
										 <label class="control-label">Contact Number: <span class="text-error">*</span> </label>
										 <div class="controls">
											 <input type="text" style="width:100%" value="" class="validate[required] input-xlarge"  name="contactNo" id="contactNo"/>
										 </div>
									 </div>
                                      <div class="control-group hide">
										 <label class="control-label">Work Experience: <span class="text-error">*</span> </label>
										 <div class="controls">
											 <textarea style="width:100%" rows="5" cols="5" name="experience" class="input-xlarge"></textarea>
										 </div>
									</div>
                                                            <div class="control-group">
										 <label class="control-label">Awards & Recognition: <span class="text-error">*</span> </label>
										 <div class="controls">
											 <textarea style="width:100%" rows="5" cols="5" name="awards" class="validate[] input-xlarge"></textarea>
										 </div>
									</div>
									 									
								
									 
									<div class="control-group">
										<label class="control-label">Active / Inactive: <span class="text-error">*</span></label>
										<div class="controls">
											<label class="radio inline">
												<input class="styled" type="radio" checked name="activeStatus" id="publish" value="1" data-prompt-position="topLeft:-1,-5"/>
												Active
											</label>
											<label class="radio inline">
												<input class="styled" type="radio"  name="activeStatus" id="draft" value="0" data-prompt-position="topLeft:-1,-5"/>
												Inactive
											</label>
											
										</div>
									</div>
									
									<div class="control-group">
	                                <label class="control-label">URL Name: <br>(only lowercase letters and hyphen)</label>
	                                <div class="controls">
	                                    <input type="text" style="width:100%"  maxlength="65" class="validate[] input-xlarge " name="urlName" id="urlName"/>
	                                </div>
	                            </div>
                                <div class="control-group">
	                                <label class="control-label">Title Tag: <br>(Max 65 Characters)</label>
	                                <div class="controls">
	                                    <input type="text" style="width:100%" value="" maxlength="65" class="validate[] input-xlarge " name="titleTag" id="titleTag"/>
	                                </div>
	                            </div>
                                <div class="control-group">
	                                <label class="control-label">Meta Description: <br>(Max 170 Characters)</label>
	                                <div class="controls">
	                                    <textarea rows="5" cols="5" style="width:100%" id="metaDescription" maxlength="250" name="metaDescription" class="validate[]  span12"></textarea>
	                                </div>
	                            </div>
                                <div class="control-group">
	                                <label class="control-label">Meta Keywords: <br>(Max 250 Characters)</label>
	                                <div class="controls">
	                                    <textarea rows="5" cols="5" style="width:100%" id="metaKeywords" maxlength="250" name="metaKeywords" class="validate[] span12"></textarea>
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
<b>Hospitals</b><br>
<table border="0" style="width:100%">
<tr>    
<?php 
$sl=1;
$rslt=mysqli_query($con,"select * from tbl_firm where companyType='1' and activeStatus='1' order by companyName asc");
while($row=mysqli_fetch_assoc($rslt))
{ $sl++;
?>    
<td title="<?php echo $row['companyName'];?>"><input type="checkbox" name="plid[]" value="<?php echo $row['id'];?>"> <?php echo $row['companyName'];?></td> 
<?php if ($sl%2==1){ echo "<tr>";}?>
<?php } ?>
</tr>
</table> <br>
<b>Clinics</b><br>
<table border="0" style="width:100%">
<tr>    
<?php 
$sl=1;
$rslt=mysqli_query($con,"select * from tbl_firm where companyType='2' and activeStatus='1' order by companyName asc");
while($row=mysqli_fetch_assoc($rslt))
{ $sl++;
?>    
<td title="<?php echo $row['companyName'];?>"><input type="checkbox" name="plid[]" value="<?php echo $row['id'];?>"> <?php echo $row['companyName'];?></td> 
<?php if ($sl%2==1){ echo "<tr>";}?>
<?php } ?>
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
<label class="control-label">Specialized In: <span class="text-error">*</span> </label>
<div class="controls">
<table border="0" style="width:100%">
<tr>    
<?php 
$sl=1;
if($id==3){
$rslt=mysqli_query($con,"select * from tbl_specialty order by Name asc");
} else {
$rslt=mysqli_query($con,"select * from tbl_fitness_specialty");
}
while($row=mysqli_fetch_assoc($rslt))
{ $sl++;
?>    
<td title="<?php echo $row['Name'];?>"><input type="checkbox" name="specialized[]" value="<?php echo $row['id'];?>"> <?php echo $row['Name'];?></td> 
<?php if ($sl%2==1){ echo "<tr>";}?>
<?php } ?>
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
<div class="control-group">
<label class="control-label">Language Known: <span class="text-error">*</span> </label>
<div class="controls">
<table border="0" style="width:100%">
<tr>    
<?php 
$sl=1;
$rslt=mysqli_query($con,"select * from tbl_language order by Name asc");
while($row=mysqli_fetch_assoc($rslt))
{ $sl++;
?>    
<td title="<?php echo $row['Name'];?>"><input type="checkbox" name="language[]" value="<?php echo $row['id'];?>"> <?php echo $row['Name'];?></td> 
<?php if ($sl%2==1){ echo "<tr>";}?>
<?php } ?>
</tr>
</table>                                                                                    
</div>
</div>
</div>
</div>
</div> 
<div class="tab-pane" id="tab5">
<div class="well row-fluid">
<div class="span12 well">
<div class="control-group">
<label class="control-label">Save the content to add Educational Details </label>
</div>
</div>
</div>
</div>  
<div class="tab-pane" id="tab6">
<div class="well row-fluid">
<div class="span12 well">
<div class="control-group">
<label class="control-label">Save the content to add Work Experience </label>
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
<script type="text/javascript">	
CKEDITOR.replace('qualification');      
CKEDITOR.replace('profile'); 
CKEDITOR.replace('awards');  
CKEDITOR.replace('experience');  
</script> 
<script>
$( "select[name='location']" ).change(function () {
    var stateID = $(this).val();

    if(stateID) {

        $.ajax({
            url: "ajax-pro.php",
            dataType: 'Json',
            data: {'id':stateID},
            success: function(data) {
                $('select[name="area"]').empty();
                $.each(data, function(key, value) {
                    $('select[name="area"]').append('<option value="'+ key +'">'+ value +'</option>');
                });
            }
        });

    }else{
        $('select[name="area"]').empty();
    }
});
</script>
</body>
</html>
