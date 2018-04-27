<?php
include("session.php"); /*Check for session is set or not if not redirect to login page */
include_once("config.php"); /* Connection String*/
include('get-user.php'); /* Geting logged in user details*/
//no. of customers


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
					<div class="page-title">
					  <h5>Welcome <?php echo $title;?></h5>
					</div>
				</div>
				<br clear="all"/>
				
				<h5 class="widget-name"><i class="icon-th"></i>Last 5 Successfull Login
					<a href="user-log.php" style="float:right;color:#555 !important;"><i style="padding:4px;" class="icon-arrow-right"></i>View All</a>
				</h5>

				<div class="table-overflow">
                        <table class="table table-striped table-bordered table-checks media-table">
                            <thead>
                                <tr>
                                    <th>Sr.No.</th>
                                    <th>User Name / E-Mail</th>
                                    <th>Login Time</th>
                                    <th>Login Ip</th>
                                </tr>
                            </thead>
                            <tbody>
                            <!-- Select and display user log-->
                            <?php
								$rslt=mysqli_query($con,"select * from tbl_user_log where loginStatus='Success' order by logTime desc limit 5");
								$i=0;
								while($row=mysqli_fetch_array($rslt))
								{
									$i++;
								?>
                                <tr>
			                        <td><?php echo $i;?></td>
			                        <td><?php echo $row['logUsername']; ?></td>
			                        <td><?php echo $row['logTime']; ?></td>
			                        <td><?php echo $row['logIp']; ?></td>
                                </tr>
                                <?php } ?>
                            <!-- /Select and display user log-->
                                
                            </tbody>
                        </table>
                    </div>
		    
				<br clear="all"/>
				<div class="row-fluid hide">
					<div class="span12">
						<h5 class="widget-name"><i class="icon-tasks"></i>Manage News &amp; Events
				<a href="manage-news-events.php" style="float:right;color:#555 !important;"><i style="padding:4px;" class="icon-plus"></i>View All</a>
				</h5>

				<div class="table-overflow">
					<form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">
                        <table class="table table-striped table-bordered table-checks media-table">
                            <thead>
                                <tr>
                                    <th>Sr.No.</th>
                                    <th>Title</th>
                                    <th class="align-center width10">Date</th>
                                    <th class="align-center width10">Status</th>
                                    <th class="align-center width15">Last Update</th>
                                </tr>
                            </thead>
                            <tbody>
                            
                            <!-- Display All News and Events -->
<?php
							$rslt=mysqli_query($con,"select * from tbl_news_events order by eventId desc limit 10");
							$i=0;
							while($row=mysqli_fetch_array($rslt))
							{
								$i++;									
?>
                                <tr>
			                        <td><?php echo $i;?></td>
			                        <td><a href="edit-news-events.php?id=<?php echo $row['eventId'];?>" class="tip" title="Edit"><?php echo $row['eventTitle'] ?></a></td>
			                        <td class="align-center"><?php echo date('d-m-Y',strtotime($row['eventDate'])); ?></td>
			                        <td class="align-center"><?php if($row["activeStatus"]==1) echo '<span style="color:green">Published</span>'; else echo '<span style="color:red">Draft</span>'?></td>
			                        <td class="align-center"><?php echo $row["updatedOn"]; ?></td>
			                        
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
					<?php /*<div class="span6">
						<h5 class="widget-name"><i class="icon-user-md"></i>List of Applicants </h5>
      <div class="table-overflow">
        <form action="" method="post">
          <table class="table table-striped table-bordered table-checks media-table">
            <thead>
              <tr>
                <th>Sr.No.</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Resume</th>
              </tr>
            </thead>
            <tbody>
              <!-- Display All News and Events -->
              <?php								
			  $rslt=mysqli_query($con,"select * from tbl_candidates order by id desc limit 10");
			  $i=0;								
			  while($row=mysqli_fetch_array($rslt))								
			  {									
				$i++;
				?>
              <tr>
                <td><?php echo $i;?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['phone']; ?></td>
                <td style="text-align:center;"><a href="../resume/<?php echo $row['resume']; ?>" style="text-align:center;" download class="tip" title="Download"><i class="icon-download"></i></a></td>
                
              </tr>
              <?php } ?>
              <!-- /Display All News and Events -->
            </tbody>
          </table>
        </form>
      </div>
    
					</div>
				*/?>
				</div>
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
