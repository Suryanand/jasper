<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
include('category-functions.php'); /* Geting logged in user details*/
if($userType != 1) /* This page only for admin - if normal user redirect to index page */
{
	header('location: index.php');
}
include('get-user.php'); /* Geting logged in user details*/

// delete category
if(isset($_POST["delete"]))
{
	mysqli_query($con,"delete from tbl_nutritionist_comments where id='".$_POST["delete"]."'");
	echo "<script>location.href = 'nutritionist-comment.php';</script>";exit();
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

			    <br clear="all"/>

		    	<h5 class="widget-name"><i class="icon-th"></i>Nutritionist Comments
                </h5>
                
				<div class="table-overflow">
                <form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">
                        <table class="table table-striped table-bordered table-checks media-table">
                            <thead>
                                <tr>
                                    <th>Sr. No.</th>
									<th>Name</th>
									<th>Nutritionist</th>
									<th>Date</th>
									<th>Message</th>
                                                                        <th>IP Address</th>
									<th>Status</th>
                                    <th class="actions-column">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            
                            <!-- Display All User Details -->
                            <?php
								$rslt=mysqli_query($con,"select * from tbl_nutritionist_comments order by id desc");
								$i=0;
								while($row=mysqli_fetch_array($rslt))
								{
                                                                    $userId=$row['userId'];
                                                                    $octorId=$row['doctorId'];
									
									$i++;
							?>
                                <tr>
			                                                <td><?php echo $i;?></td>
                                                                        <?php
                                                                        $rslt2=mysqli_query($con,"select * from tbl_users where userId=$userId");
								        $row2=mysqli_fetch_array($rslt2);
                                                                        ?>
									<td><?php echo $row2["userFirstName"];?> <?php echo $row2["userLastName"];?></td>
                                                                         <?php
                                                                        $rslt3=mysqli_query($con,"select * from tbl_trainers where id=$octorId and type=1");
								        $row3=mysqli_fetch_array($rslt3);
                                                                        ?>
									<td><?php echo $row3["fullName"];?></td>
									<td><?php echo $row["updatedOn"];?></td>
									<td><?php echo $row["Message"];?></td>
									<td><?php echo $row["Ip"];?></td>
                                                                        <td><?php if($row["activeStatus"]==1){ ?>
                                                                        <a href="nutritionist-disapprove.php?id=<?php echo $row['id'];?>" style="color:green"> Approved </a>
                                                                        <?php } else{ ?>
                                                                        <a href="nutritionist-approve.php?id=<?php echo $row['id'];?>" style="color:red"> Not Approved </a>
                                                                        <?php } ?>
                                                                        </td>
			                        <td>
		                                <ul class="navbar-icons">
		                                    <li><button type="submit" title="Remove" onClick="return clickMe()" value="<?php echo $row['id'];?>" class="remove-button-icon" name="delete"><i class="icon-remove"></i></button></li>
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
