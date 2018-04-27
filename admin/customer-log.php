<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
if($userType==3) /* This page only for admin - if normal user redirect to index page */
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

		    	<h5 class="widget-name"><i class="icon-th"></i>Customer Log</h5>
				<form action="" method="post">					
					<div class="row-fluid">
					<div class="control-group span3">	
						<label class="control-label">Not Login in :</label>
						<div class="controls">
							<input type="number" min="1" value="<?php if(isset($_POST["days"])){echo $_POST["days"];}?>" class="validate[required] input-medium" name="days" placeholder="Days" id="days"/>
						</div>
					</div>					
					<div class="control-group span3">	
						<div class="controls">
						<button type="submit" value="submit" class="btn btn-info" name="filter" style=" margin-top: 25px;padding: 7px;width: 50%;">Filter</button>
						</div>
					</div>
					</div>
				</form>
				<div class="table-overflow">
                        <table class="table table-striped table-bordered table-checks media-table">
                            <thead>
                                <tr>
                                    <th>Sr.No.</th>
                                    <th>Customer</th>
                                    <th>E-Mail</th>
                                    <th>Last Login</th>
                                    <!--<th>Login Ip</th>-->
                                    <th>Total Visit</th>
                                </tr>
                            </thead>
                            <tbody>
                            <!-- Select and display user log-->
                            <?php
								/* $rslt=mysqli_query($con,"SELECT t1.logUsername,t1.logTime,t1.logIp,t2.firstName FROM tbl_user_log t1,tbl_customers t2 
WHERE t1.logUsername=t2.email AND logTime=(SELECT logTime FROM tbl_user_log WHERE logUsername=t1.logUsername ORDER BY logTime DESC LIMIT 1)");
								$i=0;
								while($row=mysqli_fetch_array($rslt))
								{ */
								$rslt=mysqli_query($con,"SELECT t1.logUsername,t2.firstName,COUNT(t1.logUsername) AS counts FROM tbl_user_log t1,tbl_customers t2 WHERE t1.logUsername=t2.email GROUP BY t1.logUsername");
								$i=0;
								while($row=mysqli_fetch_array($rslt))
								{
									$rslt2=mysqli_query($con,"SELECT logTime,logIp FROM tbl_user_log WHERE logUsername='".$row["logUsername"]."' ORDER BY logTime DESC LIMIT 1");
									$row2=mysqli_fetch_assoc($rslt2);							
									$i++;
									if(isset($_POST["filter"]))
									{
										$logTime=$row2["logTime"];
										$start = new DateTime($logTime);
										$days=$_POST["days"];
										$today=date('Y-m-d H:i:s');
										$interval = $start->diff(new DateTime($today));
										if($interval->days < $days)
											continue;
									}
							?>
                                <tr>
			                        <td><?php echo $i;?></td>
			                        <td><?php echo $row['firstName']; ?></td>
			                        <td><?php echo $row['logUsername']; ?></td>
			                        <td><?php echo $row2['logTime']; ?></td>
			                        <!--<td><?php echo $row2['logIp']; ?></td>-->
			                        <td><?php echo $row['counts']; ?></td>
                                </tr>
                                <?php } ?>
                            <!-- /Select and display user log-->
                                
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
