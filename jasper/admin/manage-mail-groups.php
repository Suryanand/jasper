<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
include('get-user.php'); /* Geting logged in user details*/

if($userType==2 && !isset($m_subscription)) /* This page only for admin - if normal user redirect to index page */
{
	header('location: index.php');
}

if(isset($_POST["submit"]))
{
	$groupName=mysqli_real_escape_string($con,$_POST["title"]);

	// insert into table
	mysqli_query($con,"insert into tbl_mail_groups (groupName,dateCreated)values('$groupName',NOW())") or die(mysqli_error($con));						
	
	// set response alert
	$_SESSION["response"]="Group Name Saved";
	echo "<script>location.href = 'manage-mail-groups.php'</script>";exit();
}

if(isset($_POST["update"]))
{
	$groupName=mysqli_real_escape_string($con,$_POST["title"]);

	// insert into table
	mysqli_query($con,"update tbl_mail_groups set groupName='$groupName' where id='".$_POST["update"]."'") or die(mysqli_error($con));						
	
	// set response alert
	$_SESSION["response"]="Group Name updated";
	echo "<script>location.href = 'manage-mail-groups.php'</script>;";	exit();																	
}
if(isset($_GET["id"]))
{
	$rslt=mysqli_query($con,"select * from tbl_mail_groups where id='".$_GET["id"]."'");
	$row=mysqli_fetch_assoc($rslt);
	$groupName=$row["groupName"];
}
if(isset($_POST["delete"]))
{
	mysqli_query($con,"delete from tbl_mail_groups where id='".$_POST["delete"]."'");
	echo "<script>location.href = 'manage-mail-groups.php';</script>";exit();																	
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
			 <!--   <br>-->
			    <!-- /page header -->
				<br clear="all"/>
		    	<h5 class="widget-name"><i class="icon-envelope-alt"></i>Email Groups
				<a href="manage-subscriber.php" style="float:right;color:#555 !important;"> <i style="padding:3px;" class="icon-th"></i>Subscribers</a>
				</h5>
				
				<form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">
	                <fieldset>

	                    <!-- Form validation -->
	                    <div class="widget">
	                    	<div class="well row-fluid">								
								<div class="control-group">
	                                <label class="control-label">Group Name: <span class="text-error">*</span></label>
	                                <div class="controls">
	                                    <input type="text" value="<?php if(isset($_GET["id"])) echo $groupName;?>" class="validate[required] input-large" name="title" id="title"/>
										<button type="submit" value="<?php if(isset($_GET["id"])) echo $_GET["id"];?>" class="btn btn-info updt-btn" name="<?php if(isset($_GET["id"])) echo "update"; else echo "submit";?>"><?php if(isset($_GET["id"])) echo "Update"; else echo "Save";?></button>
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
                                    <th class="align-center">Subscribers</th>
									<th class="align-center">Date</th>
                                    <th class="actions-column ">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            
                            <!-- Display All News and Events -->
<?php
							$rslt=mysqli_query($con,"select * from tbl_mail_groups");
							$i=0;
							while($row=mysqli_fetch_array($rslt))
							{
								$rslt2=mysqli_query($con,"select * from tbl_subscription where emailGroup='".$row["id"]."'");
								$subscribers=mysqli_num_rows($rslt2);
								$i++;
?>
                                <tr>
			                        <td class="align-center"><?php echo $i;?></td>
			                        <td><a href="manage-subscriber.php?id=<?php echo $row['id'];?>#settings"><?php echo $row['groupName'];?></a></td>
			                        <td class="align-center"><?php echo $subscribers; ?></td>
			                        <td class="align-center"><?php echo date('d M Y',strtotime($row['dateCreated'])); ?></td>
									<td>
		                                <ul class="navbar-icons">
										
		                                    <li><a href="manage-mail-groups.php?id=<?php echo $row['id'];?>#settings" class="tip" title="Edit"><i class="icon-pencil idesign"></i></a></li>
										    <li><button type="submit" title="Remove" onClick="return clickMe()" value="<?php echo $row['id'];?>" class="remove-button-icon" name="delete"><i class="icon-remove idesign2"></i></button></li>
											
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
