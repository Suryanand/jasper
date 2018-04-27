<?php 

include("session.php"); /*Check for session is set or not if not redirect to login page */

include("config.php"); /* Connection String*/

if($userType==2) /* This page only for admin - if normal user redirect to index page */

{

	header('location: index.php');

}

include('get-user.php'); /* Geting logged in user details*/



// submit order

if(isset($_POST['submit']))

{

	$i=$_POST['iValue'];

	for($j=1;$j<=$i;$j++)

	{

		$fId="delId".$j;

		$franchiseId=$_POST[$fId];

		$order="order".$j;

		$franchiseOrder=$_POST[$order];

		mysqli_query($con,"update tbl_franchise set franchiseOrder='$franchiseOrder' where franchiseId='$franchiseId'") or die(mysqli_error($con));							

	}

	$_SESSION["response"]='Order Changed Successfully';

	echo "<script>location.href = 'manage-franchise.php'</script>;";						

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

				    	<h5>Dashboard</h5>

				    	

			    	</div>

			    </div>

			    <!-- /page header -->



		    	<h5 class="widget-name"><i class="icon-th"></i>Manage Store

                <a href="our-franchise.php" style="float:right;color:#555 !important;"><i style="padding:4px;" class="icon-plus"></i>Add New</a>

                </h5>

                

				<div class="table-overflow">

							<form action="" method="post">                            

                        <table class="table table-striped table-bordered table-checks media-table">

                            <thead>

                                <tr>

                                    <th>Sr.No.</th>

                                    <th>Store Name</th>

                                    <th>Contact</th>

                                    <th>Image</th>

                                    <th>Order</th>

                                    <th class="actions-column">Actions</th>

                                </tr>

                            </thead>

                            

                            <!-- Display All User Details -->

                            <tbody>

                            <?php

								$rslt=mysqli_query($con,"select * from tbl_franchise order by franchiseOrder asc");

								$i=0;

								while($row=mysqli_fetch_array($rslt))

								{

									$i++;

							?>

                                <tr>

			                        <td><?php echo $i;?></td>

			                        <td><?php echo $row['franchiseName']; ?></td>

			                        <td><?php echo nl2br($row['franchiseContact']); ?></td>

			                        <td><img src="../images/franchise/<?php echo $row['franchiseImage']; ?>" width="109" height="50" /></td>

			                        <td>

                                    <input type="hidden" value="<?php echo $row['franchiseId']; ?>" name="<?php echo "delId".$i;?>"/>

                                    <input type="text" value="<?php echo $row['franchiseOrder']; ?>" class="validate[] input-mini" name="<?php echo "order".$i;?>" />

                                    <input type="hidden" value="<?php echo $i; ?>" name="iValue"/>

                                    <input type="submit" class="btn btn-info" style="width:60px;" name="submit" value="Change" />

	                                </td>

                                    <td>

		                                <ul class="navbar-icons">

		                                    <li><a href="edit-franchise.php?id=<?php echo $row['franchiseId'];?>" class="tip" title="Edit"><i class="icon-pencil"></i></a></li>



		                                    <li><a href="remove-franchise.php?id=<?php echo $row['franchiseId'];?>" onClick="return clickMe()" class="tip" title="Delete"><i class="icon-remove"></i></a></li> 

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

