<?php
include("session.php"); /*Check for session is set or not if not redirect to login page */
include_once("config.php"); /* Connection String*/
include('get-user.php'); /* Geting logged in user details*/
//no. of customers
?>
<?php
if(isset($_POST["delete"]))
{
	$id			= mysqli_real_escape_string($con,$_POST["delete"]);
	mysqli_query($con,"delete from tbl_subscribers where id='".$id."'") ;
	$_SESSION["response"]="Deleted Subscriber";
/*		echo "<script>location.href = 'manage-banner.php'</script>";
*/}
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
.datatable-footer,.datatable-header{
	display:none;
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
			     <div class="page-header">
<!--					<div class="page-title">
					  <h5>Welcome <?php echo $title;?></h5>
					</div>-->
				</div>
				<br clear="all"/>
				
				<h5 class="widget-name"><i class="icon-user"></i>Manage Subscribers
<!--					<a href="user-log.php" style="float:right;color:#555 !important;"><i style="padding:4px;" class="icon-arrow-right"></i>View All</a>-->
				</h5>
                                <form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">
				<div class="table-overflow">
                        <table class="table table-striped table-bordered table-checks media-table">
                            <thead>
                                <tr>
                                    <th>Sr.No.</th>
                                    <th>Subscribers</th>
                                    <th style='text-align:center'>IP</th>
                                    <th>Subscribed On</th>
                                    <th style='text-align:center'>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <!-- Select and display user log-->
                            <?php
								$rslt=mysqli_query($con,"select * from tbl_subscribers order by id DESC");
								$i=0;
								while($row=mysqli_fetch_array($rslt))
								{
									$i++;
								?>
                                <tr>
			                        <td><?php echo $i;?></td>
			                        <td><?php echo $row['Email']; ?></td>
			                        <td style='text-align:center'><?php echo $row['Ip']; ?></td>
			                        <td><?php echo $row['updatedOn']; ?></td>
                                                <td>
                                                <ul class="navbar-icons">											
						<li><button type="submit" title="Remove" onClick="return clickMe()" value="<?php echo $row["id"];?>" class="remove-button-icon" name="delete"><i class="icon-remove"></i></button></li>											
						</ul>
                                                </td>
                                </tr>
                                <?php } ?>
                            <!-- /Select and display user log-->
                                
                            </tbody>
                        </table>
                    </div>
                                    </form>
		    
				<br clear="all"/>

                </div></div>



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
