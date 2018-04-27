<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include_once("config.php"); /* Connection String*/
include('get-user.php'); /* Geting logged in user details*/
include('functions.php');

if(!isset($_GET["id"]))
{
	header('location: manage-workshop.php');
}
$id		= $_GET["id"];
$tabDescription="";
$tabName="";
if(isset($_GET["tab"]))
{
	$rslt=mysqli_query($con,"select * from tbl_workshop_tabs where id='".$_GET["tab"]."'");
	$row=mysqli_fetch_assoc($rslt);
	$tabName=$row["tabName"];
	$tabDescription=$row["tabDescription"];
}

/*get product image size starts*/
$rslt			= mysqli_query($con,"select width,height,imageName from image_size");
while($row = mysqli_fetch_assoc($rslt))
{
	if($row["imageName"] == "Workshop Detail")
	{
		$imageHeight	= $row["height"];
		$imageWidth		= $row["width"];
	}
	if($row["imageName"] == "Workshop Home")
	{
		$imageHeight1	= $row["height"];
		$imageWidth1	= $row["width"];
	}
	if($row["imageName"] == "Gallery Thumbnail")
	{
		$imageHeight2	= $row["height"];
		$imageWidth2	= $row["width"];
	}
	if($row["imageName"] == "Workshop Sidebar")
	{
		$imageHeight3	= $row["height"];
		$imageWidth3	= $row["width"];
	}
	if($row["imageName"] == "Workshop Promotion")
	{
		$imageHeight4	= $row["height"];
		$imageWidth4	= $row["width"];
	}
}
/*get product image size ends*/

/* select product details starts */
$rslt			= mysqli_query($con,"SELECT t1.*
FROM tbl_workshops t1 
WHERE t1.id='".$id."'");
$row			= mysqli_fetch_assoc($rslt);
$workshop	= $row["workshop"];
$description	= $row["description"];
$price			= json_decode($row["price"],true);
$discount		= $row["discount"];
$activeStatus	= $row["activeStatus"];
$titleTag		= $row["titleTag"];
$metaDescription= $row["metaDescription"];
$metaKeywords	= $row["metaKeywords"];
$urlName		= $row["urlName"];
$altTag			= $row["altTag"];
$courseImage		= $row["image"];

/* form submit starts*/
if(isset($_POST['submit']))
{
	$workshop	= mysqli_real_escape_string($con,$_POST["workshop"]);
	$description		= mysqli_real_escape_string($con,$_POST["description"]);
	//$price			= mysqli_real_escape_string($con,$_POST["price"]);
	$discount		= 0;
	$discountType	= "percentage";
	$activeStatus	= mysqli_real_escape_string($con,$_POST["activeStatus"]);
	$altTag	= mysqli_real_escape_string($con,$_POST["altTag"]);
	
	$price=array();
	foreach($_POST["price"] as $key=>$value)
	{
		$price[$key]["tag"]=$value;		
		$price[$key]["usd"]=$_POST["priceUSD"][$key];		
		$price[$key]["aed"]=$_POST["priceAED"][$key];		
	}
	
	$price_json=json_encode($price,true);	
	
	$path_to_image_directory="../catalogs/";
	if(isset($_FILES['pdf']) && !empty($_FILES['pdf']['name'])) 
	{     		
		if(preg_match('/[.](pdf)|(PDF)|(doc)|(docx)$/', $_FILES['pdf']['name'])) 
		{ 
			$pdf=upload_image($path_to_image_directory,$_FILES['pdf']['name'],$_FILES['pdf']['tmp_name']);	
		}
	}
	
	$image = new UploadImage\Image($_FILES);
	$image->setLocation("../uploads/images/course");
	if($image["image"]){
		$upload = $image->upload(); 
		if($upload){
			$courseImage=$image->getName().".".$image->getMime();			
		}else{
			echo $image["error"]; 
		}
	}
	
	if(!empty($_POST["tabName"]) && !isset($_GET["tab"])){
		$tabName=mysqli_real_escape_string($con,$_POST["tabName"]);
		$tabDescription		= mysqli_real_escape_string($con,$_POST["tabDescription"]);
		mysqli_query($con,"insert into tbl_workshop_tabs(workshop,tabName,tabDescription) values('".$id."','".$tabName."','".$tabDescription."')");
	}
	if(isset($_GET["tab"]))
	{
		$tabName=mysqli_real_escape_string($con,$_POST["tabName"]);
		$tabDescription		= mysqli_real_escape_string($con,$_POST["tabDescription"]);
		mysqli_query($con,"update tbl_workshop_tabs set tabName='".$tabName."',tabDescription='".$tabDescription."' where id='".$_GET["tab"]."'");
	}

	//seo details
	$titleTag		= mysqli_real_escape_string($con,$_POST["titleTag"]);						
	$metaDescription= mysqli_real_escape_string($con,$_POST["metaDescription"]);
	$metaKeywords	= mysqli_real_escape_string($con,$_POST["metaKeywords"]);
	$urlName		= mysqli_real_escape_string($con,$_POST["urlName"]);
	if(empty($urlName))
	{
		$urlName=$workshop;
	}
	$urlName = set_url_name($urlName);
	
	//insert to tbl_workshops
	mysqli_query($con,"update tbl_workshops set workshop='".$workshop."',description='".$description."',price='".$price_json."',discount='".$discount."',discountType='".$discountType."',updatedOn=NOW(),activeStatus='".$activeStatus."',urlName='".$urlName."',titleTag='".$titleTag."',metaDescription='".$metaDescription."',metaKeywords='".$metaKeywords."',image='".$courseImage."',altTag='".$altTag."' where id='".$id."'") or die(mysqli_error($con));	
		
	//save and close
	if($_POST["submit"]=="submit-close")
	{
		echo "<script>location.href = 'manage-workshop.php'</script>";exit();
	}
	//save and continue
	else
	{
		echo "<script>location.href = 'edit-workshop.php?id=$id'</script>";exit();
	}
}

// options save
if(isset($_POST["save-option"]))
{	
	$_SESSION["tab"] = "option";
	$opt_values="";
	$option_stock=$_POST["option_stock"];
	$option_price=$_POST["option_price"];
	$option_text=$_POST["option_text"];
	foreach($_POST["enableOption"] as $optionId) //all checked checkboxes
	{
		$opt_values.=$_POST["optionValue".$optionId].","; //make all selected option values as comma seperated value
	}
	$opt_values=rtrim($opt_values,',');
	if(!empty($option_values))
		$key=max(array_keys($option_values))+1;
	else
		$key=0;
	$options=implode(',',$_POST["enableOption"]);
	$option_values[$key]["option_values"]=$opt_values;
	$option_values[$key]["option_stock"]=$option_stock;
	$option_values[$key]["option_price"]=$option_price;
	$option_values[$key]["option_text"]=$option_text;
	$options_json=json_encode($option_values);
	mysqli_query($con,"update tbl_workshops set options='".$options."',option_values='".$options_json."' where id='".$id."'");
	echo "<script>location.href = 'edit-workshop.php?id=$id'</script>";exit();
}
//update option
if(isset($_POST["update-option"]))
{
	$_SESSION["tab"] = "option";
	$key=$_POST["update-option"];

	$option_stock=$_POST["option_stock".$key];
	$option_price=$_POST["option_price".$key];
	$option_text=$_POST["option_text".$key];
	$opt_values=implode(',',$_POST["optionValuesEdit".$key]);
	
	$option_values[$key]["option_values"]=$opt_values;
	$option_values[$key]["option_stock"]=$option_stock;
	$option_values[$key]["option_price"]=$option_price;
	$option_values[$key]["option_text"]=$option_text;
	
	$options_json=json_encode($option_values);
	mysqli_query($con,"update tbl_workshops set option_values='".$options_json."' where id='".$id."'");
	echo "<script>location.href = 'edit-workshop.php?id=$id'</script>";exit();
}
//remove option 
if(isset($_POST["remove-option"]))
{
	$_SESSION["tab"] = "option";
	$key=$_POST["remove-option"];
	unset($option_values[$key]);
	$options_json=json_encode($option_values);
	mysqli_query($con,"update tbl_workshops set option_values='".$options_json."' where id='".$id."'");
	echo "<script>location.href = 'edit-workshop.php?id=$id'</script>";exit();
}

$path_to_image_directory="../images/products/";
$path_to_thumbs_directory="../images/products/thumbnail/";
// upload main image
if(isset($_POST["image"]))
{
	$_SESSION["tab"] = "Image";	
	
	
	$main_image="";
	$image = new UploadImage\Image($_FILES);
	$image->setLocation("../uploads/images/products");
	if($image["main_image"]){
		$upload = $image->upload(); 
		if($upload){
			$main_image=$image->getName().".".$image->getMime();			
		}else{
			echo $image["error"]; 
		}
	}
	mysqli_query($con,"update tbl_workshops set main_image='".$main_image."' where id='".$id."'") or die(mysqli_error($con));
		
	echo "<script>location.href = 'edit-workshop.php?id=$id'</script>";exit();
}

//upload gallery image
if(isset($_POST["galleryImage"]))
{
	$_SESSION["tab"] = "Image";	
	
	$image = new UploadImage\Image($_FILES);
	$image->setLocation("../uploads/images/products");
	if($image["gallery_image"]){
		$upload = $image->upload(); 
		if($upload){
			$gallery_image=$image->getName().".".$image->getMime();	
			array_push($gallery_images,$gallery_image);
			
			mysqli_query($con,"update tbl_workshops set gallery_images='".ltrim(implode(',',$gallery_images),',')."' where id='".$id."'") or die(mysqli_error($con));
		}else{
			echo $image["error"]; 
		}
	}
	
	echo "<script>location.href = 'edit-workshop.php?id=$id'</script>";exit();
}

// Gallery Image order change
if(isset($_POST["order"]))
{
	$_SESSION["tab"] = "Image";	
	$iValue			= mysqli_real_escape_string($con,$_POST["order"]);
	$id		 		= mysqli_real_escape_string($con,$_POST["id".$iValue]);
	$imageOrder 	= mysqli_real_escape_string($con,$_POST["imageOrder".$iValue]);
	$imageColor='NULL';
				if(isset($_POST["imageColor".$iValue]))
					$imageColor="'".$_POST["imageColor".$iValue]."'";
	mysqli_query($con,"update tbl_product_images set imageOrder='".$imageOrder."',optionValueId=$imageColor where imageId='".$id."'") or die(mysqli_error($con));
/*	echo "<script>location.href = 'manage-occasion.php'</script>";
*/
}

//delete tab
if(isset($_POST["deletetab"]))
{
	$tabid	= mysqli_real_escape_string($con,$_POST["deletetab"]);
	
	mysqli_query($con,"delete from tbl_workshop_tabs where id='".$tabid."'") or die(mysqli_error($con));
	echo "<script>location.href = 'edit-course.php?id=$id'</script>";exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<title><?php echo $title; ?></title>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<!--[if IE 8]><link href="css/ie8.css" rel="stylesheet" type="text/css"/><![endif]-->
<link href='css/gfonts.css' rel='stylesheet' type='text/css'>

<?php include_once('js-scripts.php'); ?>
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<script>
   function selectSpec(select)
   {
	 var catId= $(select).val();
	  $.ajax({
			 type: "POST",
			 url: "ajx-products.php",
			 data: {catId:catId},
			 dataType: 'json',
			 success: function(data) {
				 $("#specifications").html(data['spec']);	 
				 $("#similarProducts").html(data['similarProducts']);	 
			}
		});
   }
   
   function subCategory(select)
   {
	 var catId= $(select).val();
	  $.ajax({
			 type: "POST",
			 url: "ajx-products.php",
			 data: {category:catId},
			 dataType: 'json',
			 success: function(data) {
				 $("#category").html(data['category']);	 
			}
		});
   }   
function clickMe()
{
var r=confirm("Are you sure to delete?");
if(r==true)
  { return true;
  }
else
{
return false;
}
}
  
function checkLimit()
{
var s=$('#galleryTotal').val();
s = s-1;
//var r=document.getElementById("galleryTotal").value;
if(s>=5)
  { 
  	alert("Your Limit Exceeded!")
  	return false;
  }
else
{
return true;
}
}
</script>
<style>
ul.options li:before{
	content: "\f00d";
	font-family:"FontAwesome";
	cursor:pointer;
}
.form-actions{
	padding:4px 16px 0px;
}
.datatable-header, .datatable-footer{
	display:none;
}
#tab1 .control-label{
	float:none !important;
}
#tab1 .controls{
	margin-left:0px !important;
}
</style>
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
				<h5 class="widget-name"><i class="icon-barcode"></i>Workshop Details  <a href="manage-workshop.php" style="float:right;color:#555 !important;"><i style="padding:4px;" class="icon-arrow-left"></i>Back</a></h5>
	            <form id="validate" class="form-horizontal" id="file-form" action="" enctype="multipart/form-data" method="post">
					<div class="widget">
		                <div class="tabbable"><!-- default tabs -->
	    	                <ul class="nav nav-tabs">
	                        	<li><a href="#tab1" data-toggle="tab">General</a></li>
	                            <li <?php if(isset($_GET["tab"])) {?>class="active"<?php } ?>><a href="#tab3" data-toggle="tab">Tabs</a></li>
	                             <!--<li><a href="#tab4" data-toggle="tab">Filters & Tags</a></li>
	                           <li <?php if(isset($_SESSION["tab"]) && $_SESSION["tab"]=="option") {?>class="active"<?php } ?>><a href="#tab9" data-toggle="tab">Options</a></li>-->
	                            <li><a href="#tab2" data-toggle="tab">SEO</a></li>
                                <div class="form-actions align-right">
                                    <button type="submit" class="btn btn-info" value="submit" name="submit">Save and Continue</button>
                                    <button type="submit" class="btn btn-info" value="submit-close" name="submit">Save</button>
								</div>
							</ul>
                            <div class="tab-content">
                            <!-- Tab 1 starts here -->
                            <div class="tab-pane <?php if(!isset($_GET["tab"])) echo "active";?>" id="tab1">
				            <fieldset>
                            <div class="row-fluid">
	                           	<div class="span12">
                                   	<div class="widget well">
                                        <div class="control-group">
                                            <label class="control-label">Workshop Name: <span class="text-error">*</span></label>
                                            <div class="controls">
												<input type="text" value="<?php echo $workshop; ?>" class="validate[required] input-xlarge" name="workshop" id="workshop"/>
                                            </div>
                                        </div>
                                	<div class="control-group pricetag">
												<div class="controls" style="float:left;">
												<label class="">Price Tag:</label>
													<input type="text" value="<?php echo $price[0]["tag"]; ?>"  class="validate[] input-xlarge" name="price[]"/>
												</div>
												<div class="controls" style="float:left;">
												<label class="">Price USD:</label>
													<input type="text" value="<?php echo $price[0]["usd"]; ?>"  class="validate[] input-medium" name="priceUSD[]"/>
												</div>
												<div class="controls" style="float:left;">
												<label class="">Price AED:</label>
													<input type="text" value="<?php echo $price[0]["aed"]; ?>"  class="validate[] input-medium" name="priceAED[]"/>
												</div>
												<div class="controls" style="float:left;">
													<label class="">&nbsp;</label>
													<input type="button" value="+" style="padding:2px 5px;margin-left:20px;" class="addfield"/>
												</div>
												<br clear="all"/>
												<?php foreach($price as $key=>$value){
													if($key==0)
														continue;
													?>
													<div class="pricediv">
														<div class="controls" style="float:left;">
															<label class="">Price Tag:</label><input type="text" value="<?php echo $value["tag"];?>" class="validate[] input-xlarge" name="price[]" />
														</div>
														<div class="controls" style="float:left;">
															<label class="">Price USD:</label><input type="text" value="<?php echo $value["usd"];?>" class="validate[] input-medium" name="priceUSD[]" />
														</div>
														<div class="controls" style="float:left;">
															<label class="">Price AED:</label><input type="text" value="<?php echo $value["aed"];?>" class="validate[] input-medium" name="priceAED[]"/>
														</div>
														<a href="#" class="remove_field">Remove</a>
													</div><br clear="all"/>
												<?php }?>
											</div>
									<div class="control-group">
										<label class="control-label">Upload Image:<br> <?php echo image_size('team_member');?></label>
										<div class="controls">
										<?php if(!empty($courseImage))
										{?>
											<img src="../uploads/images/course/<?php echo $courseImage; ?>" width="75" height="100" />
											<button type="submit" name="deleteImage" style="background:transparent;border:none;"><i class="icon-remove"></i></button>
										<?php } 										
										?>
											<input type="file" name="image" id="image" class="validate[custom[images]]">
											<br><br><label>Alt Tag : <input type="text" value="" class="validate[] input-xlarge" name="altTag" id="altTag"/></label>
										</div>
									</div>
									<div class="control-group">
											<label class="control-label">Description:</label>
											<div class="controls">
												<textarea rows="5" cols="5" name="description" class="validate[] span12"><?php echo $description; ?></textarea>
											</div>
										</div>
									<div class="control-group">
												<label class="control-label">Draft / Publish: <span class="text-error">*</span></label>
												<div class="controls">
													<label class="radio inline">
														<input class="styled" type="radio" name="activeStatus" id="activeStatus" value="0" data-prompt-position="topLeft:-1,-5"/>
														Draft
													</label>
													<label class="radio inline">
														<input class="styled" type="radio" checked name="activeStatus" id="activeStatus" value="1" data-prompt-position="topLeft:-1,-5"/>
														Publish
													</label>
												</div>
											</div>
										
									</div>
								</div>

								<!--Right Column-->                            
								
								<div class="form-actions align-right">
                                    <button type="submit" class="btn btn-info" value="submit" name="submit">Save and Continue</button>
                                    <button type="submit" class="btn btn-info" value="submit-close" name="submit">Save</button>
								</div>
								</div>
							</fieldset>
							</div>
							
                            <!-- Tab 2 starts here -->
	                        <div class="tab-pane" id="tab2">
                            	<div class="row-fluid well">
                                	<div class="control-group">
                                        <label class="control-label">Workshop URL:<i class="ico-question-sign popover-test left"  data-trigger="hover" title="SEO Name" data-content="Do not use spaces, instead replace spaces with - and make sure the keyword is globally unique."></i></label>
                                        <div class="controls">
                                            <input type="text" value="<?php echo $urlName; ?>"  maxlength="65" class="validate[] input-xxlarge" name="urlName" id="urlName"/>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Title Tag: <br>(Max 65 Characters)</label>
                                        <div class="controls">
                                            <input type="text" value="<?php echo $titleTag; ?>"  maxlength="65" class="validate[] input-xxlarge" name="titleTag" id="titleTag"/>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Meta Description:<br>(Max 170 Characters)</label>
                                        <div class="controls">
                                            <textarea rows="5" cols="5" id="metaDescription" maxlength="250"  name="metaDescription" class="validate[] span12"><?php echo $metaDescription; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Meta Keywords:<br>(Max 250 Characters)</label>
                                        <div class="controls">
                                            <textarea rows="5" cols="5" id="metaKeywords" maxlength="250" name="metaKeywords" class="validate[] span12"><?php echo $metaKeywords; ?></textarea>
                                        </div>
                                    </div>                                        
								</div>
							</div>
                                
                            <!-- Tab 3 starts here -->    
	                        <div class="tab-pane <?php if(isset($_GET["tab"])) echo "active";?>" id="tab3">
                                <div class="well row-fluid">
								
                                    <br clear="all"/>
                                    <div class="control-group">
										<label class="control-label">Tab Name:</label>
											<div class="controls">
                                            <input type="text" value="<?php echo $tabName;?>"  maxlength="65" class="validate[] input-xxlarge" name="tabName" id="tabName"/>
                                        </div>
                                    </div>
									<div class="control-group">
										<label class="control-label">Details:</label>
											<div class="controls">
											<textarea rows="5" cols="5" name="tabDescription" class="validate[] span12"><?php echo $tabDescription;?></textarea>
                                        </div>
                                    </div>
									<div class="table-overflow">
                                        <table class="table table-striped table-bordered table-checks media-table">
                                            <thead>
												<tr>
                                                    <th>Sr.No.</th>
                                                    <th>Tab Name</th>
                                                    <th>Order</th>
                                                    <!--<th>Category</th>
                                                    <th>Color</th>-->
                                                    <th class="align-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <!-- Display All User Details -->
                                            <?php
                                            $i=0;
                                            $rslt=mysqli_query($con,"select * from tbl_workshop_tabs where workshop='".$id."'");
											while($row=mysqli_fetch_assoc($rslt))
                                            {
												$i++;
                                            ?>
												<tr>
													<td><?php echo $i;?></td>
													<td><?php echo $row["tabName"];?></td>
													<td>
														<input type="text" value="<?php echo $row["sortOrder"];?>"  maxlength="65" class="validate[] input-small" name="imageOrder<?php echo $i;?>"/>
														<button type="submit" value="<?php echo $row["id"];?>" class="btn btn-info" name="order">Update</button>
													</td>													
													<td class="align-center">
														<ul class="navbar-icons">
															<li><a href="edit-workshop.php?id=<?php echo $id;?>&tab=<?php echo $row["id"]?>" title="Edit" class="tip"><i class="icon-pencil"></i></a></li>
															<li><button type="submit" title="Remove" onClick="return clickMe()" value="<?php echo $row["id"];?>" style="border:none;background:transparent;" class="tip" name="deletetab"><i class="icon-remove"></i></button></li>
														</ul>
													</td>
												</tr>
                                      <?php } ?>                                                        
											</tbody>
                                        </table>
                                        <input type="hidden" value="<?php echo $i;?>"  maxlength="65" class="validate[] input-small" name="galleryTotal" id="galleryTotal"/>
                                    </div>            
                                </div>
                            </div>
							
							
	                        </div>
	                    </div> <?php if(isset($_SESSION["tab"])) unset($_SESSION["tab"]);?>
	                </div>
				</form>
            </div><!-- /content wrapper -->
        </div><!-- /content -->
	</div><!-- /content container -->
	
	<!-- Footer -->
	<?php include_once('footer.php'); ?>
	<!-- /footer -->
	<script type="text/javascript">
	CKEDITOR.replace('description', {height: '130px'});
	CKEDITOR.replace('tabDescription', {height: '130px'});
	
	
    var max_fields      = 10; //maximum input boxes allowed
    var wrapper         = $(".pricetag"); //Fields wrapper
    var add_button      = $(".addfield"); //Add button ID
    
    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper).append('<div class="pricediv"><div class="controls" style="float:left;"><label class="">Price Tag:</label><input type="text"  class="validate[] input-xlarge" name="price[]" /></div><div class="controls" style="float:left;"><label class="">Price USD:</label><input type="text" class="validate[] input-medium" name="priceUSD[]" /></div><div class="controls" style="float:left;"><label class="">Price AED:</label><input type="text" class="validate[] input-medium" name="priceAED[]"/></div><a href="#" class="remove_field">Remove</a></div><br clear="all"/>'); //add input box
			$(".priceCount").val(x);
        }
    });
    
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
		$(".priceCount").val(x);
    });

</script>
</body>
</html>