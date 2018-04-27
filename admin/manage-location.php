<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
if($userType != 1) /* This page only for admin - if normal user redirect to index page */
{
	header('location: index.php');
}
include('get-user.php'); /* Geting logged in user details*/
$catId="";
$category="";
if(isset($_GET["id"]))
{
	$rslt=mysqli_query($con,"select * from tbl_area where id='".$_GET["id"]."'");
	$row=mysqli_fetch_assoc($rslt);
	$emirate=$row["emirate"];
        $area=$row["area"];
}

if(isset($_POST["submit"]))
{
	$emirate=mysqli_real_escape_string($con,$_POST["emirate"]);
        $area=mysqli_real_escape_string($con,$_POST["area"]);
	if(isset($_GET["id"]))
	{
		mysqli_query($con,"update tbl_area set emirate='".$emirate."',area='".$area."' where id='".$_GET["id"]."'");
	}
	else
	{
		mysqli_query($con,"insert into tbl_area(emirate,area) values('".$emirate."','".$area."')");		
	}
	echo "<script>location.href = 'manage-location.php';</script>";exit();
}
if(isset($_POST["delete"]))
{
	$id	= mysqli_real_escape_string($con,$_POST["delete"]);
	mysqli_query($con,"delete from tbl_area where id='".$id."'") or die(mysqli_error($con));
	echo "<script>location.href = 'manage-location.php'</script>";exit();
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
      <br>
      <!-- /page header -->
      <h5 class="widget-name"><i class="icon-th"></i>Manage Location</h5>
	  
	  <form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">
	                <fieldset>

	                    <!-- Form validation -->
	                    <div class="widget">
	                    	<div class="well row-fluid">								
								<div class="control-group">
	                               
	                                <div class="controls">
                                            
	                                    <input type="text" value="<?php if(isset($_GET["id"])) echo $area;?>" class="validate[required] input-xlarge" name="area" placeholder='Location' id="category"/>
                                            <select name="emirate" required>
                                            <option value="">Choose One Emirate</option> 
                                            <?php
                $rslt2=mysqli_query($con,"SELECT * FROM tbl_locations order by region asc");
                while($row2=mysqli_fetch_array($rslt2))
                {
                ?>
                <option <?php if(isset($_GET["id"]) && $row2['region']==$emirate) { echo "selected"; }?> value="<?php echo $row2['region'];?>"><?php echo $row2['region'];?></option>
                <?php } ?>
                </select>
<!--                                            <input type="text" value="<?php if(isset($_GET["id"])) echo $icon;?>" class="validate[required] input-xlarge" name="icon" placeholder='Icon' id="category"/>-->
										<button type="submit" value="<?php if(isset($_GET["id"])) echo $_GET["id"];?>" class="btn btn-info updt-btn" name="submit"><?php if(isset($_GET["id"])) echo "Update"; else echo "Save";?></button>
	                                </div>
	                            </div>								
	                        </div>
	                    </div>
	                    <!-- /form validation -->
	                </fieldset>
				</form>
	  
      <div class="table-overflow">
        <form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">
          <table class="table table-striped table-bordered table-checks media-table">
            <thead>
              <tr>
                <th>Sr.No.</th>
                <th>Emirate</th>
                <th>Location</th>
                <th class="actions-column">Action</th>
              </tr>
            </thead>
            <tbody>
              <!-- Display All User Details -->
              <?php
                $rslt=mysqli_query($con,"SELECT * FROM tbl_area order by emirate asc");
                $i=0;
                while($row=mysqli_fetch_array($rslt))
                {
                $i++;
                ?>
              <tr>
                <td><?php echo $i;?></td>
                <td><?php echo $row["emirate"];?></td>
                <td><?php echo $row["area"];?></td>
                <td><ul class="navbar-icons">
                    <li><a href="manage-location.php?id=<?php echo $row['id'];?>" class="tip" title="Edit"><i class="icon-pencil"></i></a></li>
                    <li>
                      <button type="submit" title="Remove" onClick="return clickMe()" value="<?php echo $row["id"];?>" class="remove-button-icon" name="delete"> <i class="icon-remove"></i></button>
                    </li>
                  </ul></td>
              </tr>
              <?php } ?>
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
