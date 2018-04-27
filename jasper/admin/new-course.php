<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include_once("config.php"); /* Connection String*/
include('get-user.php'); /* Geting logged in user details*/
include('functions.php');

// save product details
if(isset($_POST['submit']))
{
	$courseName	= mysqli_real_escape_string($con,$_POST["courseName"]);
	$category		= mysqli_real_escape_string($con,$_POST["category"]);
	$description		= mysqli_real_escape_string($con,$_POST["description"]);
	//$price			= mysqli_real_escape_string($con,$_POST["price"]);
	$discount		= 0;
	$discountType	= mysqli_real_escape_string($con,$_POST["discountType"]);
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
	
	$courseImage="";
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
	
	//seo details
	$titleTag		= mysqli_real_escape_string($con,$_POST["titleTag"]);						
	$metaDescription= mysqli_real_escape_string($con,$_POST["metaDescription"]);
	$metaKeywords	= mysqli_real_escape_string($con,$_POST["metaKeywords"]);
	$urlName		= mysqli_real_escape_string($con,$_POST["urlName"]);
	if(empty($urlName))
	{
		$urlName=$courseName;
	}
	$urlName = set_url_name($urlName);
	
	//insert to tbl_course
	mysqli_query($con,"insert into tbl_course (courseName,fkCategoryId,description,price,discount,discountType,image,altTag,updatedOn,activeStatus,urlName,titleTag,metaDescription,metaKeywords) values('".$courseName."','".$category."','".$description."','".$price_json."','".$discount."','".$discountType."','".$courseImage."','".$altTag."',NOW(),'".$activeStatus."','".$urlName."','".$titleTag."','".$metaDescription."','".$metaKeywords."')") or die(mysqli_error($con));
	
	//fetch current product id
	$rslt	= mysqli_query($con,"select id from tbl_course order by id desc limit 1");
	$row	= mysqli_fetch_assoc($rslt);
	$id		= $row["id"];

	if($_POST["submit"]=="submit-close")
	{
		echo "<script>location.href = 'manage-courses.php'</script>";
	}
	else
	{
		echo "<script>location.href = 'edit-course.php?id=$id'</script>";
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
<!--[if IE 8]><link href="css/ie8.css" rel="stylesheet" type="text/css"/><![endif]-->
<link href='css/gfonts.css' rel='stylesheet' type='text/css'>

<?php include_once('js-scripts.php'); ?>

<style>
ul.options li:before{
	content: "\f00d";
	font-family:"FontAwesome";
	cursor:pointer;
}
.form-actions{
	padding:4px 16px 0px;
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
				<h5 class="widget-name"><i class="icon-barcode"></i>Course Details <a href="manage-courses.php" style="float:right;color:#555 !important;"><i style="padding:4px;" class="icon-arrow-left"></i>Back</a></h5>
	                <form id="validate" class="form-horizontal" id="file-form" action="" enctype="multipart/form-data" method="post">
						<div class="widget">
	                        <div class="tabbable"><!-- default tabs -->
	                            <ul class="nav nav-tabs">
	                                <li><a href="#tab1"  data-toggle="tab">General</a></li>
	                                <li><a href="#tab3" data-toggle="tab">Tabs</a></li>
	                                
	                                <li><a href="#tab2" data-toggle="tab">SEO</a></li>
	                                <!--<li><a href="#tab10" data-toggle="tab">Arabic</a></li>-->
                                    <div class="form-actions align-right">
										<button type="submit" class="btn btn-info" value="submit" name="submit">Save and Continue</button>
										<button type="submit" class="btn btn-info" value="submit-close" name="submit">Save</button>
									</div>
	                            </ul>
                                <div class="tab-content">                                
                                    <!-- Tab 1 starts here -->
	                                <div class="tab-pane <?php if(!isset($_SESSION["tab"]) || $_SESSION["tab"]=="Contact") echo "active";?>" id="tab1">                                    
									<fieldset>
									<!-- Form validation -->
									<div class="row-fluid">
										<div class="span12">
										<div class="widget well">
											<div class="control-group">
												<label class="control-label">Course Name: <span class="text-error">*</span></label>
												<div class="controls">
													<input type="text" value="" class="validate[required] input-xlarge" name="courseName" id="courseName"/>
												</div>
											</div>
											<div class="control-group">
												<label class="control-label">Category: <span class="text-error">*</span></label>
												<div class="controls">
													<ul class="options">
													</ul>
													<select name="category" id="category" data-placeholder="Choose Category..." class="validate[required] select" data-prompt-position="topLeft:-1,-5">
													<option value=""></option>
												<?php 
												$rslt=mysqli_query($con,"SELECT t1.id AS catId,
	TRIM(LEADING '-> ' FROM CONCAT(IFNULL(t4.categoryName, ''), '-> ', IFNULL(t3.categoryName, ''), '-> ', IFNULL(t2.categoryName, ''), '-> ', IFNULL(t1.categoryName, ''))) AS parentCategory 
	FROM tbl_category t1 
	LEFT JOIN tbl_category t2 ON t1.parentId=t2.id 
	LEFT JOIN tbl_category t3 ON t2.parentId=t3.id 
	LEFT JOIN tbl_category t4 ON t3.parentId=t4.id
	WHERE t1.activeStatus=1
	ORDER BY parentCategory");
												while($row=mysqli_fetch_array($rslt))
												{
												?>			                                            
														<option value="<?php echo $row["catId"];?>"><?php echo $row["parentCategory"];?></option>
												<?php } ?>
													</select>
												</div>
											</div>
											<!--<div class="control-group">
												<label class="control-label">Sub Category: <span class="text-error">*</span></label>
												<div class="controls">
													<ul class="options">
													</ul>
													<select name="category" id="category" onChange="selectSpec(this);" class="validate[required] styled options" data-prompt-position="topLeft:-1,-5">
														<option value="">Select Sub Category</option>
													</select>
												</div>
											</div>-->
											<div class="control-group pricetag">
												<div class="controls" style="float:left;">
												<label class="">Price Tag:</label>
													<input type="text" value=""  class="validate[] input-xlarge" name="price[]" />
												</div>
												<div class="controls" style="float:left;margin-left:10px !important;">
												<label class="">Price USD:</label>
													<input type="text" value=""  class="validate[required] input-medium" name="priceUSD[]" />
												</div>
												<div class="controls" style="float:left;margin-left:10px !important;">
												<label class="">Price AED:</label>
													<input type="text" value=""  class="validate[required] input-medium" name="priceAED[]" />
												</div>
												<div class="controls" style="float:left;">
													<label class="">&nbsp;</label>
													<input type="button" value="+" style="padding:2px 5px;margin-left:20px;" class="addfield"/>
												</div>
												<br clear="all"/>
											</div>
											<div class="control-group">
												<label class="control-label">Upload Image:<br> <?php echo image_size('team_member');?></label>
												<div class="controls">
													<input type="file" name="image" id="image" class="validate[custom[images]]">
													<br><br><label>Alt Tag : <input type="text" value="" class="validate[] input-xlarge" name="altTag" id="altTag"/></label>
												</div>
											</div>
											
											<div class="control-group">
												<label class="control-label">Description:</label>
												<div class="controls">
													<textarea rows="5" cols="5" name="description" class="validate[] span12"></textarea></div>
											</div>
											<div class="control-group">
												<label class="control-label">Status: <i class="ico-question-sign popover-test left"  data-trigger="hover" title="Status" data-content="Show in store front or not"></i></label>
												<div class="controls">
													<label class="radio inline">
														<input class="styled" type="radio" checked name="activeStatus"  value="1" data-prompt-position="topLeft:-1,-5"/>
														Active
													</label>
													<label class="radio inline">
														<input class="styled" type="radio" name="activeStatus" value="0" data-prompt-position="topLeft:-1,-5"/>
														Inactive
													</label>
												</div>
											</div>
																						
										</div>
										</div>
										
									</div>
									<!-- /form validation -->
									</fieldset>
                                    </div>  

                                    <!-- Tab 2 starts here -->
	                                <div class="tab-pane" id="tab2">
                                        <div class="row-fluid well">
											<div class="control-group">
												<label class="control-label">Course URL:<i class="ico-question-sign popover-test left"  data-trigger="hover" title="SEO Name" data-content="Do not use spaces, instead replace spaces with - and make sure the keyword is globally unique."></i></label>
												<div class="controls">
													<input type="text" value=""  maxlength="65" class="validate[] input-xxlarge" name="urlName" id="urlName"/>
												</div>
											</div>
											<div class="control-group">
												<label class="control-label">Title Tag: <span class="text-error">*</span><br>(Max 65 Characters)</label>
												<div class="controls">
													<input type="text" value=""  maxlength="65" class="validate[] input-xxlarge" name="titleTag" id="titleTag"/>
												</div>
											</div>
											<div class="control-group">
												<label class="control-label">Meta Description: <span class="text-error">*</span><br>(Max 170 Characters)</label>
												<div class="controls">
													<textarea rows="5" cols="5" id="metaDescription" maxlength="250"  name="metaDescription" class="validate[] span12"></textarea>
												</div>
											</div>
											<div class="control-group">
												<label class="control-label">Meta Keywords: <span class="text-error">*</span><br>(Max 250 Characters)</label>
												<div class="controls">
													<textarea rows="5" cols="5" id="metaKeywords" maxlength="250" name="metaKeywords" class="validate[] span12"></textarea>
												</div>
											</div>                                        
                                        </div>
                                    </div>
                                    
                                    <!-- Tab 3 starts here -->                                    
	                                <div class="tab-pane <?php if(isset($_SESSION["tab"]) && $_SESSION["tab"]=="Bill") echo "active";?>" id="tab3">
                                    	<div class="well row-fluid">
                                        	
                                            You Need to save Course for adding Tabs.
            
                                        </div>
                                    </div>
																
	                            </div>
	                        </div> <?php unset($_SESSION["tab"]);?>
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
	
	 var max_fields      = 10; //maximum input boxes allowed
    var wrapper         = $(".pricetag"); //Fields wrapper
    var add_button      = $(".addfield"); //Add button ID
    
    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper).append('<div class="pricediv"><div class="controls" style="float:left;"><label class="">Price Tag:</label><input type="text"  class="validate[] input-xlarge" name="price[]" /></div><div class="controls" style="float:left;margin-left:10px !important;"><label class="">Price USD:</label><input type="text" class="validate[] input-medium" name="priceUSD[]" /></div><div class="controls" style="float:left;margin-left:10px !important;"><label class="">Price AED:</label><input type="text" class="validate[] input-medium" name="priceAED[]"/></div><a href="#" class="remove_field">Remove</a></div><br clear="all"/>'); //add input box
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
