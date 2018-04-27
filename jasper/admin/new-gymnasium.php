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
//$companyType=$_GET['id'];
if(isset($_POST["submit"]))
{
    //$service = 1;
    $companyId=1;
    $companyType = 1;
    $specialty = implode(',', $_POST['specialty']);
    $insurance = implode(',', $_POST['insurance']);
    $clubmanager = implode(',', $_POST['clubmanager']);
    $trainer = implode(',', $_POST['trainer']);
    $service = implode(',', $_POST['service']);
	$country = mysqli_real_escape_string($con,$_POST["country"]);
	$address = mysqli_real_escape_string($con,$_POST["address"]);
	$area = mysqli_real_escape_string($con,$_POST["area"]);
	$network1 = mysqli_real_escape_string($con,$_POST["network1"]);
	$network2 = mysqli_real_escape_string($con,$_POST["network2"]);
	$location=mysqli_real_escape_string($con,$_POST["location"]);
	$companyName	=mysqli_real_escape_string($con,$_POST["companyName"]);
	$profile	=mysqli_real_escape_string($con,$_POST["profile"]);
	$email	=mysqli_real_escape_string($con,$_POST["email"]);
	$contactNo	=mysqli_real_escape_string($con,$_POST["contactNo"]);
	$fax	=mysqli_real_escape_string($con,$_POST["fax"]);
	$googleMap	=mysqli_real_escape_string($con,$_POST["googleMap"]);
	$activeStatus=mysqli_real_escape_string($con,$_POST["activeStatus"]);
	$branchId=mysqli_real_escape_string($con,$_POST["branchId"]);
	$website=mysqli_real_escape_string($con,$_POST["website"]);
        $work_hours=mysqli_real_escape_string($con,$_POST["work_hours"]);
	$firmImage="";
	$image = new UploadImage\Image($_FILES);
	$image->setLocation("../uploads/images/gymnasium");
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
        

	
	mysqli_query($con,"insert into tbl_gymnasium(userId,location,companyName,address,contactNo,fax,googleMap,activeStatus,titleTag,metaDescription,metaKeywords,urlName,companyType,country,area,network1,network2,image,branchId,website,companyId,service,insurance,specialty,profile,clubmanager,trainer,work_hours)values('0','".$location."','$companyName','$address','$contactNo','$fax','$googleMap','$activeStatus','".$titleTag."','$metaDescription','$metaKeywords','$urlName','$companyType','$country','$area','$network1','$network2','$firmImage','$branchId','$website','$companyId','$service','$insurance','$specialty','$profile','$clubmanager','$trainer','$work_hours')") or die(mysqli_error($con));
	$_SESSION["response"]='Gymnasium Saved';
//	echo "<script>location.href = 'manage-firm.php?id=$companyType'</script>";exit();
$rslt			= mysqli_query($con,"select id from tbl_gymnasium order by id desc limit 1");
	$row			= mysqli_fetch_assoc($rslt);
	$id		= $row["id"];

	if($_POST["submit"]=="submit-close")
	{
		echo "<script>location.href = 'manage-gymnasium.php</script>";
	}
	else
	{
		echo "<script>location.href = 'edit-gymnasium.php?id=$id'</script>";
	}	
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

				<h5 class="widget-name"><i class="icon-sitemap"></i>New Gymnasium <a href="manage-gymnasium.php" style="float:right;color:#555 !important;"><i style="padding:4px;" class="icon-arrow-left"></i>Back</a></h5>
<form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">
<ul class="nav nav-tabs">    
<li><a href="#tab1" data-toggle="tab">General</a></li>
<!--<li><a href="#tab2" data-toggle="tab">Working Hours</a></li>-->
<li><a href="#tab3" data-toggle="tab">Specialty</a></li>
<li><a href="#tab4" data-toggle="tab">Insurance</a></li>
<li><a href="#tab5" data-toggle="tab">Services</a></li>
<li><a href="#tab6" data-toggle="tab">Fitness Trainers</a></li>
<li><a href="#tab7" data-toggle="tab">Club Manager</a></li>
<li><a href="#tab8" data-toggle="tab">Gallery</a></li>
<div class="form-actions align-right">
<button type="submit" class="btn btn-info" name="submit" value="submit-close">Save</button>
<button type="submit" class="btn btn-info" name="submit" value="submit">Save and Continue</button>
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
											<?php $rslt=mysqli_query($con,"select * from tbl_category where activeStatus=1");
											while($row=mysqli_fetch_assoc($rslt))
											{?>
											<option value="<?php echo $row["id"];?>" <?php if($row["id"]==$companyType) echo "selected";?>><?php echo $row["categoryName"];?></option>
											<?php }?>
											</select>
										</div>
									</div>
									<div class="control-group hide">
										 <label class="control-label">Branch Of: <span class="text-error">*</span> </label>
										 <div class="controls">
											<select style="width:100%" name="branchId" class="validate[] styled">
											<option value="0">None</option>
											<?php $rslt=mysqli_query($con,"select * from tbl_firm");
											while($row=mysqli_fetch_assoc($rslt))
											{?>
											<option value="<?php echo $row["id"];?>" class="firms firm<?php echo $row["companyType"];?>"><?php echo $row["companyName"];?></option>
											<?php }?>
											</select>
										 </div>
									</div>
									<div class="control-group">
										 <label class="control-label">Name: <span class="text-error">*</span> </label>
										 <div class="controls">
											 <input style="width:100%" type="text" value="" class="validate[required] input-xlarge"  name="companyName" id="companyName"/>
										 </div>
									</div>									
									<div class="control-group">
										<label class="control-label">Profile: <span class="text-error">*</span></label>
										<div class="controls">
											<textarea style="width:100%" rows="5" cols="5" name="profile" class="validate[] input-xlarge"></textarea>
										</div>
									</div>
                                                                        <div class="control-group">
										 <label class="control-label">Working Hours: <span class="text-error">*</span> </label>
										 <div class="controls">
											 <input style="width:100%" type="text" value="" class="validate[required] input-xlarge"  name="work_hours" id="companyName"/>
										 </div>
									</div>
									<div class="control-group">
										 <label class="control-label">Country: <span class="text-error">*</span> </label>
										 <div class="controls">
											<select style="width:100%" name="country" class="validate[required] styled">
											<?php $rslt=mysqli_query($con,"select * from tbl_countries");
											while($row=mysqli_fetch_assoc($rslt))
											{												
											?>
												<option value="<?php echo $row["countryName"];?>"><?php echo $row["countryName"];?></option>
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
												<option value="<?php echo $row["region"];?>"><?php echo $row["region"];?></option>
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
												<option value="<?php echo $row["area"];?>"><?php echo $row["area"];?></option>
											<?php 
											}?>
											</select>
										 </div>
									</div>
									<div class="control-group">
										<label class="control-label">Address: <span class="text-error">*</span></label>
										<div class="controls">
											<textarea style="width:100%" rows="5" cols="5" name="address" class="validate[required] input-xlarge"></textarea>
										</div>
									</div>
									<div class="control-group">
										 <label class="control-label">Contact Number: <span class="text-error">*</span> </label>
										 <div class="controls">
											 <input type="text" style="width:100%" value="" class="validate[required] input-xlarge"  name="contactNo" id="contactNo"/>
										 </div>
									 </div>
									 
									 <div class="control-group">
										 <label class="control-label">Fax: </label>
										 <div class="controls">
											 <input type="text" style="width:100%" value="" class="validate[] input-xlarge"  name="fax" id="fax"/>
										 </div>
									 </div>
									
									 
									
									 
								</div>
	                        <div class="span6 well">
                                     <div class="control-group">
										 <label class="control-label">Email: <span class="text-error">*</span> </label>
										 <div class="controls">
											 <input type="text" style="width:100%" value="" class="validate[custom[email]] input-xlarge"  name="email" id="email"/>
										 </div>
									 </div>
                                    <div class="control-group">
										 <label class="control-label">Website: <span class="text-error">*</span> </label>
										 <div class="controls">
											 <input type="text" style="width:100%" value="" class=" input-xlarge"  name="website" id="website"/>
										 </div>
									 </div>
									 <div class="control-group">
										 <label class="control-label">Network 1:</label>
										 <div class="controls">
											 <input type="text" style="width:100%" value="" class="validate[] input-xlarge"  name="network1" id="network2"/>
										 </div>
									</div>
									<div class="control-group">
										 <label class="control-label">Network 2:</label>
										 <div class="controls">
											 <input type="text" style="width:100%" value="" class="validate[] input-xlarge"  name="network2" id="network2"/>
										 </div>
									</div>
									<div class="control-group">
										<label class="control-label">Google Map Iframe: </label>
										<div class="controls">
											<textarea rows="7" style="width:100%" cols="5" name="googleMap" class="validate[] span12"></textarea>
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
	                                    <input type="text" style="width:100%" value="" maxlength="65" class="validate[] input-xlarge " name="urlName" id="urlName"/>
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
	                                    <textarea rows="5" style="width:100%" cols="5" id="metaDescription" maxlength="250" name="metaDescription" class="validate[]  span12"></textarea>
	                                </div>
	                            </div>
                                <div class="control-group">
	                                <label class="control-label">Meta Keywords: <br>(Max 250 Characters)</label>
	                                <div class="controls">
	                                    <textarea rows="5" style="width:100%" cols="5" id="metaKeywords" maxlength="250" name="metaKeywords" class="validate[]  span12"></textarea>
	                                </div>
	                            </div>
        
									
								</div>
									
	                         
							</div>
							
							</div>
                               
<div class="tab-pane" id="tab2">
<div class="well row-fluid">
<div class="span12 well">
<div class="control-group">
<label class="control-label"></label>
<div class="controls">	
You Need to save the firm for adding working Hours.    
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
$rslt=mysqli_query($con,"select * from tbl_fitness_specialty order by Name asc");
while($row=mysqli_fetch_assoc($rslt))
{ $sl++;
?>    
<td><input type="checkbox" name="specialty[]" value="<?php echo $row['id'];?>"> <?php echo $row['Name'];?></td> 
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
<label class="control-label">Insurance: <span class="text-error">*</span></label>
<div class="controls"> 
<table border="0" style="width:100%">
<tr>    
<?php 
$sl=1;
$rslt=mysqli_query($con,"select * from tbl_insurance where activeStatus='1' order by insurance asc");
while($row=mysqli_fetch_assoc($rslt))
{
?>    
<td title="<?php echo $row['insurance'];?>"><input type="checkbox" name="insurance[]" value="<?php echo $row['id'];?>"> <?php echo substr($row['insurance'],0,20);?>...</td>
<?php if($sl%2==0){ echo "<tr>";}?>
<?php $sl++; } ?> 
</tr></table>
</div>
</div>
</div>
</div>
<div class="tab-pane" id="tab5">
<div class="well row-fluid">
<div class="span12 well">
<div class="control-group">
<label class="control-label">Services</label>
<div class="controls">
<table border="0" style="width:100%">
<tr>     
<?php
$rslt=mysqli_query($con,"SELECT * FROM tbl_services order by name asc");
while($row=mysqli_fetch_array($rslt))
{
?>
<td><input type="checkbox" name="service[]" value="<?php echo $row['id'];?>"><?php echo $row['name'];?></td>
<?php if($sl%2==1){ echo "<tr>";}?>
<?php $sl++; } ?> 
</tr></table>   
</div>
</div>
</div>
</div>
</div> 
<div class="tab-pane" id="tab6">
<div class="well row-fluid">
<div class="span12 well">
<div class="control-group">
<label class="control-label">Fitness Trainers</label>
<div class="controls">
<table border="0" style="width:100%">
<tr>     
<?php
$rslt=mysqli_query($con,"SELECT * FROM tbl_trainers where type=0 order by fullName asc");
while($row=mysqli_fetch_array($rslt))
{
?>
<td><input type="checkbox" name="trainer[]" value="<?php echo $row['id'];?>"><?php echo $row['fullName'];?></td>
<?php if($sl%2==1){ echo "<tr>";}?>
<?php $sl++; } ?> 
</tr></table>   
</div>
</div>
</div>
</div>
</div>  
<div class="tab-pane" id="tab7">
<div class="well row-fluid">
<div class="span12 well">
<div class="control-group">
<label class="control-label">Club Managers</label>
<div class="controls">
<table border="0" style="width:100%">
<tr>     
<?php
$rslt=mysqli_query($con,"SELECT * FROM tbl_trainers where type=2 order by fullName asc");
while($row=mysqli_fetch_array($rslt))
{
?>
<td><input type="checkbox" name="clubmanager[]" value="<?php echo $row['id'];?>"><?php echo $row['fullName'];?></td>
<?php if($sl%2==1){ echo "<tr>";}?>
<?php $sl++; } ?> 
</tr></table>   
</div>
</div>
</div>
</div>
</div> 
<div class="tab-pane" id="tab8">
<div class="well row-fluid">
<div class="span12 well">
<div class="control-group">
<label class="control-label"></label>
<div class="controls">	
You Need to save the gymnasium for adding gallery images.    
</div>
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
<script type="text/javascript">	
CKEDITOR.replace('profile');        
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
