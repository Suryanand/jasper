<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
include('get-user.php'); /* Geting logged in user details*/

if($userType==2 && !isset($m_career)) /* This page only for admin - if normal user redirect to index page */
{
	header('location: index.php');
}

if(isset($_POST["delete"]))
{
	mysqli_query($con,"delete from tbl_career where careerId='".$_POST["delete"]."'");
	$_SESSION["response"]="Post is removed";
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
/* confirm to delete job */
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
		<?php include_once('side-bar.php');?>
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
		    	<h5 class="widget-name"><i class="icon-user-md"></i>Manage Post
                <a href="career.php" style="float:right;color:#555 !important;"><i style="padding:4px;" class="icon-plus"></i>Add New</a>
                </h5>
				<form action="" method="post">
				<div class="table-overflow">
                        <table class="table table-striped table-bordered table-checks media-table">
                            <thead>
                                <tr>
                                    <th>Sr.No.</th>
                                    <th>Title</th>
                                    <!--<th>Category</th>-->
                                    <th class="align-center width20">Show on Site Till</th>
                                    <th class="align-center width15">Last Update</th>
                                    <th class="actions-column width10">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            
                            <!-- Display All News and Events -->
                            <?php
								$rslt=mysqli_query($con,"select * from tbl_career t1 left join tbl_career_categories t2 on t1.postCategory=t2.id");
								$i=0;
								while($row=mysqli_fetch_array($rslt))
								{
									$date=date('d M Y',strtotime($row['postDate']));
									$i++;
									if($row["postExpire"]==1)
									{
										if (strtotime($row['postDate']) < time()) {
										  $date="<span style='color:red;'>Expired</span>";
										} 
									}
									
									
							?>
                                <tr>
			                        <td><?php echo $i;?></td>
			                        <td><?php echo $row['postTitle']; ?></td>
			                        <!--<td><?php echo $row['category']; ?></td>-->
			                        <td class="align-center"><?php echo $date; ?></td>
			                        <td class="align-center"><?php echo $row["updatedOn"]; ?></td>
			                        <td>
		                                <ul class="navbar-icons">
		                                    <li><a href="edit-career.php?id=<?php echo $row['careerId'];?>" class="tip" title="Edit"><i class="icon-pencil"></i></a></li>
											<li><button type="submit" title="Remove" onClick="return clickMe()" value="<?php echo $row['careerId'];?>" class="remove-button-icon" name="delete"><i class="icon-remove"></i></button></li>
		                                    
		                                </ul>
			                        </td>
                                </tr>
                          <?php } ?>
                            <!-- /Display All News and Events -->
                                
                            </tbody>
                        </table>
                    </div>
				</form>
		    </div>
		    <!-- /content wrapper -->
		</div>
		<!-- /content -->
	</div>
	<!-- /content container -->
	<?php 
    // echo response 
    if(isset($_SESSION["response"]))
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