<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
include('get-user.php'); /* Getting logged in user details*/


if(isset($_GET["id"]))
{
	$rslt=mysqli_query($con,"select * from tbl_blog_category where id='".$_GET["id"]."'");
	$row=mysqli_fetch_assoc($rslt);
	$category=$row["category"];
	$image=$row["image"];
	$altTag=$row["altTag"];
	$caption1=$row["caption1"];
	$caption2=$row["caption2"];
	$buttonCaption=$row["buttonCaption"];
	$buttonLink=$row["buttonLink"];
}

// new user submit
if(isset($_POST["submit"]))
{
	$Category = mysqli_real_escape_string($con,$_POST["Category"]);
	$caption1 = mysqli_real_escape_string($con,$_POST["caption1"]);
	$caption2 = mysqli_real_escape_string($con,$_POST["caption2"]);
	$buttonCaption = mysqli_real_escape_string($con,$_POST["buttonCaption"]);
	$buttonLink = mysqli_real_escape_string($con,$_POST["buttonLink"]);
						
	// Check whether the email already registered 
	$rslt=mysqli_query($con,"select * from tbl_blog_category where category='$Category'");
	if(mysqli_num_rows($rslt)>0) 
	{/* email already registered */
		$_SESSION["err"]="Category already created";
	}
	else
	{	
		
		//Image Upload Start here
		$path_to_image_directory = '../images/blogs/';
		$filename = "blogs-";
		if(isset($_FILES['image']) && !empty($_FILES['image']['name'])) 
		{
			if(preg_match('/[.](jpg)|(gif)|(png)$/', $_FILES['image']['name'])) 
			{     
				$path = $_FILES['image']['name'];
				$ext = pathinfo($path, PATHINFO_EXTENSION);
				$source = $_FILES['image']['tmp_name'];  
				// Make sure the fileName is unique 
				$filename=$path;
				$count = 1;
				while (file_exists($path_to_image_directory.$filename))
				{
					$count++;
					$filename=$count.$filename;
				}
				
				$target = $path_to_image_directory . $filename;
				if(!file_exists($path_to_image_directory)) 
				{
				if(!mkdir($path_to_image_directory, 0777, true)) 
					{
						die("There was a problem. Please try again!");
					}
				}        
				move_uploaded_file($source, $target);
			}
		}
		else
		{
			$filename="";
		}
		
		
		mysqli_query($con,"insert into tbl_blog_category (category,image,caption1,caption2,buttonCaption,buttonLink)values('$Category','$filename','$caption1','$caption2','$buttonCaption','$buttonLink')") or die(mysqli_error($con));
		$_SESSION["response"]="Category Created";
		echo "<script>location.href = 'manage-blog-category.php'</script>";
	}
}

if(isset($_POST["update"]))
{
		$category=mysqli_real_escape_string($con,$_POST["Category"]);
		$caption1 = mysqli_real_escape_string($con,$_POST["caption1"]);
		$caption2 = mysqli_real_escape_string($con,$_POST["caption2"]);
		$buttonCaption = mysqli_real_escape_string($con,$_POST["buttonCaption"]);
		$buttonLink = mysqli_real_escape_string($con,$_POST["buttonLink"]);
		$categoryId=$_POST["update"];
		
		//Image Upload Start here
		$path_to_image_directory = '../images/blogs/';
		$filename = $image;
		if(isset($_FILES['image']) && !empty($_FILES['image']['name'])) 
		{
			if(preg_match('/[.](jpg)|(gif)|(png)$/', $_FILES['image']['name'])) 
			{     
				$path = $_FILES['image']['name'];
				$ext = pathinfo($path, PATHINFO_EXTENSION);
				$source = $_FILES['image']['tmp_name'];  
				// Make sure the fileName is unique 
				$filename=$path;
				$count = 1;
				while (file_exists($path_to_image_directory.$filename))
				{
					$count++;
					$filename=$count.$filename;
				}
				
				$target = $path_to_image_directory . $filename;
				if(!file_exists($path_to_image_directory)) 
				{
				if(!mkdir($path_to_image_directory, 0777, true)) 
					{
						die("There was a problem. Please try again!");
					}
				}        
				move_uploaded_file($source, $target);
			}
		}		
		
		
		mysqli_query($con,"update tbl_blog_category set category='$category',image='$filename',caption1='$caption1',caption2='$caption2',buttonCaption='$buttonCaption',buttonLink='$buttonLink' where id='$categoryId'") or die(mysqli_error($con));							
	
	echo "<script>location.href = 'manage-blog-category.php'</script>;";
}
if(isset($_POST["delete"]))
{
$id=mysqli_real_escape_string($con,$_POST["delete"]);

$rslt=mysqli_query($con,"select * from tbl_blog where find_in_set('$id',catId)");
if(mysqli_num_rows($rslt)>0)
{
	$_SESSION['response'] = 'Category in use. Cannot be deleted';	
}
else
{
	mysqli_query($con,"delete from tbl_blog_category where id='$id'");
	$_SESSION['response'] = 'Category Deleted';
}
}

if(isset($_POST["update-order"]))
{
	$id=mysqli_real_escape_string($con,$_POST["update-order"]);
	$sortOrder=mysqli_real_escape_string($con,$_POST["sortOrder".$id]);
	mysqli_query($con,"update tbl_blog_category set sortOrder='".$sortOrder."' where id='".$id."'");
}

if(isset($_POST["update-all-order"]))
{
	$rslt=mysqli_query($con,"select * from tbl_blog_category order by category asc");
	while($row=mysqli_fetch_array($rslt))
	{
		$id=$row["id"];
		$sortOrder=mysqli_real_escape_string($con,$_POST["sortOrder".$id]);
		mysqli_query($con,"update tbl_blog_category set sortOrder='".$sortOrder."' where id='".$id."'");
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
<?php include_once('js-scripts.php'); ?>

<style>
.ui-datepicker-append{display:none;}
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
			<!--    <div class="page-header">
			    	<div class="page-title">
				    	<h5>Dashboard</h5>				    	
			    	</div>
			    </div>-->
				
				<h5 class="widget-name"><i class="icon-globe"></i>Blog Category</h5>
			    <!-- /page header -->
				<form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">
	                <fieldset>
	                    <!-- Form validation -->
	                    <div class="widget">
	                    	<div class="well row-fluid">
								<div class="control-group">
	                                <label class="control-label">Category Name: <span class="text-error">*</span></label>
	                                <div class="controls">
	                                    <input type="text" value="<?php if(isset($_GET["id"])) echo $category;?>" class="validate[required] input-xlarge" name="Category" id="Category"/>					
										<?php if(isset($_SESSION["err"])) /* if email already registered */
										{
										?>
											<span class="help-block" style="color:#F00;">Category already created</span>
										<?php
										unset($_SESSION["err"]);
										}
										?>
                                        
	                                </div>
								
	                            </div>	
								<div class="control-group">
	                                <label class="control-label">Image: <br><?php echo "w:1657px "." h:571px";?></label>
	                                <div class="controls">
										<?php if(isset($_GET["id"])){if(!empty($image)) {?><img src="../images/blogs/<?php echo $image;?>" width="150" /><?php }}?>
										<input type="file" name="image" id="image" class="validate[custom[images]] "/>
										
	                                </div>	
									
	                            </div>
								<div class="control-group">
	                                <label class="control-label">Caption 1: </label>
	                                <div class="controls">
	                                    <input type="text" value="<?php if(isset($_GET["id"])) echo $caption1;?>" class="validate[] input-xlarge" name="caption1" id="caption1"/>                                        
	                                </div>								
	                            </div>
								<div class="control-group">
	                                <label class="control-label">Caption 2: </label>
	                                <div class="controls">
	                                    <input type="text" value="<?php if(isset($_GET["id"])) echo $caption2;?>" class="validate[] input-xlarge" name="caption2" id="caption2"/>                                        
	                                </div>								
	                            </div>
								<div class="control-group ">
	                                <label class="control-label">Button Text: </label>
	                                <div class="controls">
	                                    <input type="text" value="<?php if(isset($_GET["id"])) echo $buttonCaption;?>" class="validate[] input-xlarge" name="buttonCaption" id="buttonText"/>                                        
	                                </div>								
	                            </div>
								<div class="control-group ">
	                                <label class="control-label">Button Link URL: </label>
	                                <div class="controls">
	                                    <input type="text" readonly value="<?php echo $absolutePath;?>" class="validate[] input-large" name="" id=""/>
										<input type="text" value="<?php if(isset($_GET["id"])) echo $buttonLink;?>" class="validate[] input-xlarge" name="buttonLink" id="buttonLink"/> 
										<br clear="all"/>
	                                </div>								
	                            </div>
	                                <div class="controls">
									<button type="submit" style="margin-left: 10px;" value="<?php if(isset($_GET["id"])) echo $_GET["id"];?>" class="btn btn-info bbq updt-btn" name="<?php if(isset($_GET["id"])) echo "update"; else echo "submit";?>"><?php if(isset($_GET["id"])) echo "Update"; else echo "Save";?></button>
	                                </div>								
	                        </div>
	                    </div>
	                    <!-- /form validation -->
	                </fieldset>
				</form>
				
				<div class="table-overflow">
							<form action="" method="post">
                        <table class="table table-striped table-bordered table-checks media-table">
                            <thead>
                                <tr>
                                    <th>Sr.No.</th>
                                    <th>Category</th>
                                    <th>Image</th>
                                    <th>Caption 1</th>
                                    <th>Caption 2</th>
                                    <th class="align-center width15">Sort Order</th>
                                    <th class="actions-column">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            
                            <!-- Display All User Details -->
                            <?php
								$rslt=mysqli_query($con,"select * from tbl_blog_category order by category asc");
								$i=0;
								while($row=mysqli_fetch_array($rslt))
								{
									$i++;
							?>
                                <tr>
			                        <td><?php echo $i;?></td>
			                        <td><?php echo $row['category']; ?></td>
			                        <td><?php if(!empty($row["image"])) {?><img src="../images/blogs/<?php echo $row["image"];?>" width="150" /><?php }?></td>
			                        <td><?php echo $row['caption1']; ?></td>
			                        <td><?php echo $row['caption2']; ?></td>
			                        <td><input type="text" value="<?php echo $row["sortOrder"];?>" class="validate[] input-mini bdr-rds" name="sortOrder<?php echo $row["id"];?>" id="sortOrder					<?php echo $row["id"];?>"/>
									<button type="submit" class="btn btn-info" name="update-order" value="<?php echo $row["id"];?>"><i class="ico-ok"></i></button>
									</td>
			                        <td>
		                                <ul class="navbar-icons">
											<li><a href="manage-blog-category.php?id=<?php echo $row['id'];?>" class="tip" title="Edit"><i class="icon-pencil idesign"></i></a></li>
		                                    <li>
									<button type="submit" title="Remove" onClick="return clickMe()" value="<?php echo $row['id'];?>" class="remove-button-icon" name="delete">
									<i class="icon-remove idesign2"></i></button>
											</li> 
		                                </ul>
			                        </td>
                                </tr>
                                <?php } ?>
                            <!-- /Display All User Details -->
                            </tbody>
							<tfoot>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td>
                            <button type="submit" class="btn btn-info updt-btn" name="update-all-order" value=" <?php echo $row["id"];?>">Update All</button>
                            </td>
							<td></td>
							</tfoot>
                        </table>
                      </form>
                    </div>
				<!-- /form validation -->
		    </div>
		    <!-- /content wrapper -->
		</div>
		<!-- /content -->
	</div>
	<!-- /content container -->
	<!-- Footer -->
	<?php include_once('footer.php'); ?>
	<?php if(isset($_SESSION["response"]))
    {echo "<script>alert('".$_SESSION["response"]."');</script>";
       unset($_SESSION["response"]);}?>
	<!-- /footer -->
	<script>
$(document).ready(function(){
    $("#validate").validationEngine('attach');
});

function clickMe()
{
var r=confirm("Are you sure, You want to delete?");
if(r==true)
  { return true;
  }
else
{
return false;
}
}
function editService(i)
	{
		if ( $('#categoryName'+i).is('[readonly]') )
		{
		$("#categoryName"+i).prop('readonly', false);
		}
		else{
		$("#categoryName"+i).prop('readonly', true);			
		}
	}
</script>
</body>
</html>
