<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
include('get-user.php'); /* Geting logged in user details*/

if($userType!=1) /* This page only for admin - if normal user redirect to index page */
{
	header('location: index.php');
}


// remove client
if(isset($_POST["delete"]))
{
	$deleteId	= mysqli_real_escape_string($con,$_POST["delete"]);
		$rslt = mysqli_query($con,"select clientImage from tbl_clients where id='$deleteId'");
		$row  = mysqli_fetch_assoc($rslt);
		if(!empty($row["clientImage"]))
		{
			unlink("../images/brands/".$row["clientImage"]);
		}
		$seoFor ="client-".$deleteId;		
		mysqli_query($con,"delete from tbl_seo where seoFor='".$seoFor."'");
		mysqli_query($con,"delete from tbl_clients where id='$deleteId'");
		$_SESSION['response'] = 'client Deleted';
/*		echo "<script>location.href = 'manage-banner.php'</script>";
*/}
if(isset($_POST['submitOrder']))
{
		$bId=$_POST['submitOrder'];
		$order="order".$bId;
		$bOrder=$_POST[$order];
		mysqli_query($con,"update tbl_clients set clientOrder='$bOrder' where id='$bId'") or die(mysqli_error($con));							
	$_SESSION["response"]='Order Changed Successfully';
	//echo "<script>location.href = 'manage-category.php';</script>";												
}

if(isset($_POST["down"]))
{
	$id	= mysqli_real_escape_string($con,$_POST["down"]);
	$i = mysqli_real_escape_string($con,$_POST["nextId".$id]);
	
	$rslt=mysqli_query($con,"select * from tbl_clients where activeStatus=1 order by clientOrder asc");
	$j=0;
	while($row=mysqli_fetch_assoc($rslt))
	{
		$j++;
		if($i==$j)
		{
			$nextOrder=$row["clientOrder"];
			if(empty($nextOrder))
				$nextOrder=0;
			break;
		}
	}
	if(isset($nextOrder))
	{
	$clientOrder=$nextOrder+1;
	mysqli_query($con,"update tbl_clients set clientOrder='$clientOrder' where id='$id'");
	}
}

if(isset($_POST["up"]))
{
	$id	= mysqli_real_escape_string($con,$_POST["up"]);
	$i = mysqli_real_escape_string($con,$_POST["prevId".$id]);
	$rslt=mysqli_query($con,"select * from tbl_clients where activeStatus=1 order by clientOrder asc");
	$j=0;
	while($row=mysqli_fetch_assoc($rslt))
	{
		$j++;
		if($i==$j)
		{
			$prevOrder=$row["clientOrder"];
			if(empty($prevOrder))
				$prevOrder=0;
			break;
		}
	}
	$clientOrder=$prevOrder-1;
	mysqli_query($con,"update tbl_clients set clientOrder='$clientOrder' where id='$id'");
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
<style>
.dataTable td:nth-last-child(2) { text-align: center; margin-right:0px;}
.dataTable th:nth-last-child(2) { text-align: center; }
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

			    <br>
			    <!-- /page header -->

		    	<h5 class="widget-name"><i class="icon-th"></i>Manage Client
                <a href="new-client.php" style="float:right;color:#555 !important;"><i style="padding:4px;" class="icon-plus"></i>Add New</a>
                </h5>
                
				<div class="table-overflow">
                <form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">
                        <table class="table table-striped table-bordered table-checks media-table">
                            <thead>
                                <tr>
                                    <th>Sr.No.</th>
                                    <th>Name</th>
                                    <th>URL</th>
                                    <th class="width10">Image</th>
                                    <th class="align-center width10">Status</th>
                                    <th class="align-center width15">Last Update</th>
									<th class="align-center width10">Order</th>
                                    <th class="actions-column width10">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            
                            <!-- Display All User Details -->
                            <?php
								$rslt=mysqli_query($con,"SELECT * from tbl_clients order by clientOrder asc");
								$i=0;
								$num=mysqli_num_rows($rslt);
								while($row=mysqli_fetch_assoc($rslt))
								{
									$i++;
							?>
                                <tr>
			                        <td><?php echo $i;?></td>
			                        <td><?php echo $row["client"]; ?></td>
			                        <td><?php echo $row["url"]; ?></td>
			                        <td><img src="../uploads/images/brands/<?php echo $row["clientImage"]; ?>" width="75"/></td>
			                        <td class="align-center"><?php if($row["activeStatus"]==1) echo '<span style="color:green">Published</span>'; else echo '<span style="color:red">Draft</span>'?></td>
			                        <td class="align-center"><?php echo $row["updatedOn"]; ?></td>
									<td>
                                    <!--<input type="text" value="<?php echo $row['clientOrder']; ?>" class="validate[] input-mini" name="order<?php echo $row['id']; ?>" />
                                    <button type="submit" class="btn btn-info" value="<?php echo $row['id']; ?>" name="submitOrder">Change</button>-->
										<ul class="navbar-icons">
										<?php if($i!=$num){?>
											<li><button type="submit" title="Down" style="float:left;" value="<?php echo $row['id'];?>" class="remove-button-icon" name="down"><i class="ico-arrow-down"></i></button>
												<input type="hidden" name="nextId<?php echo $row['id'];?>" value="<?php echo $i+1;?>"/>
											</li>
											<?php }?>
											<?php if($i!=1){?>
											<li><button type="submit" title="Up" style="float:left;" value="<?php echo $row['id'];?>" class="remove-button-icon" name="up"><i class="ico-arrow-up"></i></button>
												<input type="hidden" name="prevId<?php echo $row['id'];?>" value="<?php echo $i-1;?>"/>
											</li>
											<?php }?>
										</ul>
	                                </td>
			                        <td>
		                                <ul class="navbar-icons">
		                                    <li><a href="edit-client.php?id=<?php echo $row['id'];?>" class="tip" title="Edit"><i class="icon-pencil"></i></a></li>
		                                    <li><button type="submit" title="Remove" onClick="return clickMe()" value="<?php echo $row['id'];?>" class="remove-button-icon" name="delete">
<i class="icon-remove"></i></button></li>
		                                </ul>
			                        </td>
                                </tr>
                                <?php } ?>
                            <!-- /Display All User Details -->
                                
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
