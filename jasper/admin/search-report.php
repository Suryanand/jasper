<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
if($userType==3) /* This page only for admin - if normal user redirect to index page */
{
	header('location: index.php');
}
include('get-user.php'); /* Geting logged in user details*/

// delete category
if(isset($_POST["delete"]))
{
	$deleteId	= mysqli_real_escape_string($con,$_POST["delete"]);	
	mysqli_query($con,"delete from tbl_search_keywords where id='".$deleteId."'");
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

		    	<h5 class="widget-name"><i class="icon-th"></i>Top 10 Searched Words</h5>
							<?php $rslt=mysqli_query($con,"SELECT SUM(counts) AS total FROM tbl_search_keywords");
								$row=mysqli_fetch_assoc($rslt);
								$total=$row["total"];
							?>
							<div class="table-overflow">
								<table class="table table-striped table-bordered table-checks media-table">
									<thead>
										<tr>
											<th>Rank</th>
											<th>Serched Word</th>
											<th>Searches</th>
											<th>% (<?php echo $total;?>)</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
									
									<!-- Display All User Details -->
									<?php								
								$rslt=mysqli_query($con,"SELECT * FROM tbl_search_keywords ORDER BY counts DESC limit 10");
								$i=0;
								while($row=mysqli_fetch_array($rslt))
								{
									$i++;
							?>
                                <tr>
			                        <td><?php echo $i;?></td>
			                        <td><?php echo $row["keyword"]; ?></td>
			                        <td><?php echo $row["counts"]; ?></td>
			                        <td><?php echo number_format((float)($row["counts"]*100/$total),2)."%"; ?></td>			                        
			                        <td class="align-center">
										<ul class="navbar-icons">
											<li><button type="submit" title="Remove" onClick="return clickMe()" value="<?php echo $row['id'];?>" class="remove-button-icon" name="delete"><i class="icon-remove"></i></button></li>
										</ul>
									</td>			                        
                                </tr>
                                <?php } ?>
									<!-- /Display All User Details -->
										
									</tbody>
								</table>
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
