<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
if($userType!=1) /* This page only for admin - if normal user redirect to index page */
{
	header('location: index.php');
}
include('get-user.php'); /* Geting logged in user details*/
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
$(document).ready(function(){
    $("#validate").validationEngine('attach');
});

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

			    <!-- Page header -->
			    <br>
			    <!-- /page header -->

		    	<h5 class="widget-name"><i class="icon-th"></i>Manage User
                <a href="new-user.php" style="float:right;color:#555 !important;"><i style="padding:4px;" class="icon-plus"></i>Add New</a>
                </h5>

				<div class="table-overflow">
                        <table class="table table-striped table-bordered table-checks media-table">
                            <thead>
                                <tr>
                                    <th>SR.NO.</th>
                                    <th>E-MAIL</th>
                                    <th>TYPE</th>
                                    <th>STATUS</th>
                                    <th>ACTIVE</th>
                                    <th class="actions-column">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            
                            <!-- Display All User Details -->
                            <?php
								$rslt=mysqli_query($con,"select * from tbl_users,tbl_login where tbl_users.userEmail=tbl_login.loginUsername");
								$i=0;
								while($row=mysqli_fetch_array($rslt))
								{
									$i++;
							?>
                                <tr>
			                        <td><?php echo $i;?></td>
			                        <td><?php echo $row['userEmail']; ?></td>
			                        <td><?php if($row['loginType']==1) {echo "Admin";} else {echo "Staff";} ?></td>
			                        <td><?php if($row['loginApprove']==1) {echo "Approved";} else {?>
                              		<a href="approve-activate.php?app=<?php echo $row['loginId']; ?>" id="approve" class="tip btn btn-info" title="Approve">Approve</a>										
										<?php } ?></td>
			                        <td><?php if($row['loginActive']==1) {
											echo '<span style="color:#389ebc;margin-right:20px;">Active</span>';
										} else {
											echo '<span style="color:#c05343;margin-right:10px;">Inactive</span>';
								 } ?></td>
			                        <td>
		                                <ul class="navbar-icons">
		                                    <li><a href="user-profile.php?id=<?php echo $row['loginId'];?>" class="tip" title="Edit"><i class="icon-pencil"></i></a></li>
                                            <?php if($CurrentUserId!=$row['userId'])
											{ ?>
		                                    <li><a href="remove-user.php?id=<?php echo $row['userId'];?>" onClick="return clickMe()" class="tip" title="Delete"><i class="icon-remove"></i></a></li>  <?php } ?>
		                                </ul>
			                        </td>
                                </tr>
                                <?php } ?>
                            <!-- /Display All User Details -->
                                
                            </tbody>
                        </table>
                        <?php if(isset($_SESSION["response"]))
						{
							echo "<script>alert('".$_SESSION["response"]."');</script>";
							unset($_SESSION["response"]);
						}
                        ?>
                    </div>
		    </div>
		    <!-- /content wrapper -->

		</div>
		<!-- /content -->

	</div>
	<!-- /content container -->


	<!-- Footer -->
	<?php include_once('footer.php'); ?>
	<!-- /footer -->

</body>
</html>
