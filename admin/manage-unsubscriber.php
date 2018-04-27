<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
include('get-user.php'); /* Geting logged in user details*/

if($userType==2 && !isset($m_subscription)) /* This page only for admin - if normal user redirect to index page */
{
	header('location: index.php');
}

if(isset($_POST["delete"]))
{
	$deleteId	= mysqli_real_escape_string($con,$_POST["delete"]);
	mysqli_query($con,"delete from tbl_subscription where subscriptionId='$deleteId'");
}

if(isset($_POST["subscribe"]))
{
	$subscribeId	= mysqli_real_escape_string($con,$_POST["subscribe"]);
	mysqli_query($con,"update tbl_subscription set activeStatus=1 where subscriptionId='$subscribeId'");
}

if(isset($_POST["submit"]))
{
	$subId=$_POST["submit"];
	$subscriber=mysqli_real_escape_string($con,$_POST["subscriber".$subId]);
	$emailGroup=mysqli_real_escape_string($con,$_POST["emailGroup".$subId]);
	mysqli_query($con,"update tbl_subscription set subscriptionEmail='$subscriber',emailGroup='$emailGroup' where subscriptionId='$subId'") or die(mysqli_error($con));							
	echo "<script>alert('Subscription Updated Successfully');</script>";
	echo "<script>location.href = 'manage-subscriber.php';</script>";
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
      <h5 class="widget-name"><i class="icon-envelope-alt"></i>Manage Unsubscribes
	   <a href="manage-mail-groups.php" style="float:right;color:#555 !important;"> <i style="padding:3px;" class="icon-th"></i>Mail Groups</a>
	  <a href="manage-subscriber.php" style="float:right;color:#555 !important;margin-right:10px"> <i style="padding:3px;" class="icon-th"></i>Manage Subscriber</a>
	  </h5>
      <div class="table-overflow">
        <form action="" method="post">
          <table class="table table-striped table-bordered table-checks media-table">
            <thead>
              <tr>
                <th class="width5">Sr.No.</th>
                <th>Subscriber</th>
                <th class="align-center">Mail Group</th>
                <th class="align-center width15">Update</th>
                <th class="actions-column">Actions</th>
              </tr>
            </thead>
            <tbody>
              
              <!-- Display All Subscribers -->
              <?php
								$rslt=mysqli_query($con,"select * from tbl_subscription where activeStatus=0");
								if(isset($_GET["id"]))
								{
									$rslt=mysqli_query($con,"select * from tbl_subscription where emailGroup='".$_GET["id"]."'");
								}
								$i=0;
								while($row=mysqli_fetch_array($rslt))
								{
									$i++;
							?>
              <tr>
                <td><?php echo $i;?></td>
                <td><input type="text" value="<?php echo $row['subscriptionEmail']; ?>" class="validate[required] input-xlarge" name="<?php echo "subscriber".$row['subscriptionId'];?>" /></td>
                <td class="align-center"><select name="emailGroup<?php echo $row['subscriptionId'];?>" id="emailGroup<?php echo $row['subscriptionId'];?>">
                    <option value="">Choose Group...</option>
                    <?php
											$rslt1=mysqli_query($con,"select * from tbl_mail_groups");
											while($row1=mysqli_fetch_array($rslt1))
											{
											?>
                    <option value="<?php echo $row1["id"];?>" <?php if($row["emailGroup"]==$row1["id"]) echo "selected";?>><?php echo $row1["groupName"];?></option>
                    <?php } ?>
                  </select></td>
                <td class="align-center"><button type="submit" value="<?php echo $row['subscriptionId'];?>" class="btn btn-info updt-btn" name="submit">Update</button>
                  <button type="reset" class="btn btn btn-info updt-btn bbq">Reset</button></td>
                <td><ul class="navbar-icons">
                    <li>
                      <button type="submit" title="Add to Subscription list" style="float:left;" value="<?php echo $row['subscriptionId'];?>" class="remove-button-icon" name="subscribe"><i class="icon-plus idesign"></i></button>
                    </li>
                    <li>
                      <button type="submit" title="Remove" onClick="return clickMe()" value="<?php echo $row['subscriptionId'];?>" class="remove-button-icon" name="delete"><i class="icon-remove idesign2"></i></button>
                    </li>
                  </ul></td>
              </tr>
              <?php } ?>
              <!-- /Display All Subscribers -->
              
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

<!-- Footer -->
<?php include_once('footer.php'); ?>
<!-- /footer -->

</body>
</html>
