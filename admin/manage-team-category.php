<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
include('get-user.php'); /* Geting logged in user details*/
if($userType==2 && !isset($m_teamMembers)) /* This page only for admin - if normal user redirect to index page */
{
	header('location: index.php');
}

if(isset($_POST["submit"]))
{
	$category=mysqli_real_escape_string($con,$_POST["title"]);

	// insert into table
	mysqli_query($con,"insert into tbl_team_category_master (category)values('$category')") or die(mysql_error());						
	
	// set response alert
	$_SESSION["response"]="category Saved";
	echo "<script>location.href = 'manage-team-category.php'</script>;";																		
}

if(isset($_POST["update"]))
{
	$category=mysqli_real_escape_string($con,$_POST["title"]);

	// insert into table
	mysqli_query($con,"update tbl_team_category_master set category='$category' where id='".$_POST["update"]."'") or die(mysql_error());						
	
	// set response alert
	$_SESSION["response"]="category updated";
	echo "<script>location.href = 'manage-team-category.php'</script>;";																		
}
if(isset($_GET["id"]))
{
	$rslt=mysqli_query($con,"select * from tbl_team_category_master where id='".$_GET["id"]."'");
	$row=mysqli_fetch_assoc($rslt);
	$category=$row["category"];
}
if(isset($_POST["delete"]))
{
	mysqli_query($con,"delete from tbl_team_category_master where id='".$_POST["delete"]."'");
	echo "<script>location.href = 'manage-team-category.php'</script>;";																		
}
//update service order
if(isset($_POST["order"]))
{
	$id				= mysqli_real_escape_string($con,$_POST["order"]);
	$sortOrder 	= mysqli_real_escape_string($con,$_POST["sortOrder".$id]);

		mysqli_query($con,"update tbl_team_category_master set sortOrder='".$sortOrder."' where id='".$id."'") or die(mysql_error());
		echo "<script>location.href = 'manage-team-category.php'</script>";
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
/* confirm to delete user */
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
</script>
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

		    	<h5 class="widget-name"><i class="icon-th"></i>Team Category Master
				</h5>
				
				<form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">
	                <fieldset>

	                    <!-- Form validation -->
	                    <div class="widget">
	                    	<div class="well row-fluid">								
								<div class="control-group">
	                                <label class="control-label">Category Name: <span class="text-error">*</span></label>
	                                <div class="controls">
	                                    <input type="text" value="<?php if(isset($_GET["id"])) echo $category;?>" class="validate[required] input-large" name="title" id="title"/>
										<button type="submit" value="<?php if(isset($_GET["id"])) echo $_GET["id"];?>" class="btn btn-info" name="<?php if(isset($_GET["id"])) echo "update"; else echo "submit";?>"><?php if(isset($_GET["id"])) echo "Update"; else echo "Save";?></button>
	                                </div>
	                            </div>
	                            
	                        </div>
	                    </div>
	                    <!-- /form validation -->
	                </fieldset>
				</form>
				
				<div class="table-overflow">
					<form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">
                        <table class="table table-striped table-bordered table-checks ">
                            <thead>
                                <tr>
                                    <th>Sr.No.</th>
                                    <th>Title</th>
                                    <th class="width20">Sort Order</th>
                                    <th class="actions-column width10">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            
                            <!-- Display All News and Events -->
							<?php
							$rslt=mysqli_query($con,"select * from tbl_team_category_master");
							$i=0;
							while($row=mysqli_fetch_array($rslt))
							{
								$i++;									
?>
                                <tr>
			                        <td><?php echo $i;?></td>
			                        <td><?php echo $row['category'] ?></td>
									<td>
										<input type="text" value="<?php echo $row["sortOrder"];?>"  maxlength="65" class="validate[] input-small" name="sortOrder<?php echo $row["id"];?>"/>
                                        <button type="submit" value="<?php echo $row["id"];?>" class="btn btn-info" name="order">Update</button>
                                    </td>
			                        <td>
		                                <ul class="navbar-icons">
										
		                                    <li><a href="manage-team-category.php?id=<?php echo $row['id'];?>" class="tip" title="Edit"><i class="icon-pencil"></i></a></li>
										    <li><button type="submit" title="Remove" onClick="return clickMe()" value="<?php echo $row['id'];?>" class="remove-button-icon" name="delete"><i class="icon-remove"></i></button></li>
											
		                                </ul>
			                        </td>
                                </tr>
<?php 
							}
?>
                            <!-- /Display All News and Events -->
                                
                            </tbody>
                        </table>
						</form>
                    </div>
		    </div>
		    <!-- /content wrapper -->

		</div>
		<!-- /content -->

	</div>
	<!-- /content container -->
<?php if(isset($_SESSION["response"]))
{
	echo "<script>alert('".$_SESSION["response"]."');</script>";
	unset($_SESSION["response"]);
}
?>

	<!-- Footer -->
	<?php include_once('footer.php'); ?>
	<!-- /footer -->

</body>
</html>
