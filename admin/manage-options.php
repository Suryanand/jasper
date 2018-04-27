<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
if($userType != 1) /* This page only for admin - if normal user redirect to index page */
{
	header('location: index.php');
}
include('get-user.php'); /* Geting logged in user details*/
$option_name="";
$option_values="";
if(isset($_GET["id"]))
{
	$rslt=mysqli_query($con,"select * from tbl_options where id='".$_GET["id"]."'");
	$row=mysqli_fetch_assoc($rslt);
	$option_name=$row["option_name"];
	$option_values=$row["option_values"];
}

if(isset($_POST["submit"]))
{
	$option_name=mysqli_real_escape_string($con,$_POST["option_name"]);
	$option_values=mysqli_real_escape_string($con,$_POST["option_values"]);
	if(isset($_GET["id"]))
	{
		mysqli_query($con,"update tbl_options set option_name='".$option_name."',option_values='".$option_values."' where id='".$_GET["id"]."'");
	}
	else
	{
		mysqli_query($con,"insert into tbl_options(option_name,option_values) values('".$option_name."','".$option_values."')");		
	}
	echo "<script>location.href = 'manage-options.php';</script>";exit();
}
if(isset($_POST["delete"]))
{
	$id	= mysqli_real_escape_string($con,$_POST["delete"]);
	mysqli_query($con,"delete from tbl_options where id='".$id."'") or die(mysqli_error($con));
	echo "<script>location.href = 'manage-options.php'</script>";exit();
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
      <div class="page-header">
        <div class="page-title"> <a href="index.php">
          <h5>Dashboard</h5>
          </a> </div>
      </div>
      <!-- /page header -->
      <h5 class="widget-name"><i class="icon-th"></i>Manage Options</h5>
	  
	  <form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">
	                <fieldset>

	                    <!-- Form validation -->
	                    <div class="widget">
	                    	<div class="well row-fluid">								
								<div class="control-group">
	                                <label class="control-label">Option Name: <span class="text-error">*</span></label>
	                                <div class="controls">
	                                    <input type="text" value="<?php if(isset($_GET["id"])) echo $option_name;?>" class="validate[required] input-xlarge" name="option_name" id="option_name"/>
	                                </div>
	                            </div>								
								<div class="control-group">
	                                <label class="control-label">Option Values: <span class="text-error">*</span></label>
	                                <div class="controls">
										<input type="text" id="tags2" name="option_values" class="tags input-xxlarge" value="<?php if(isset($_GET["id"])) echo $option_values;?>" placeholder="add filters seperate by comma" />
										<br clear="all"/>
										<button type="submit" value="<?php if(isset($_GET["id"])) echo $_GET["id"];?>" class="btn btn-info updt-btn" name="submit"><?php if(isset($_GET["id"])) echo "Update"; else echo "Save";?></button>
										<?php if(isset($_GET["id"])){?>
										<?php }?>
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
                <th>Option Name</th>
                <th>Option Values</th>
                <th class="actions-column">Action</th>
              </tr>
            </thead>
            <tbody>
              <!-- Display All User Details -->
              <?php
                $rslt=mysqli_query($con,"SELECT * FROM tbl_options");
                $i=0;
                while($row=mysqli_fetch_array($rslt))
                {
                $i++;
                ?>
              <tr>
                <td><?php echo $i;?></td>
                <td><?php echo $row["option_name"];?></td>
                <td><?php foreach(explode(',',$row["option_values"]) as $value) echo $value."<br>";?></td>                
                <td><ul class="navbar-icons">
                    <li><a href="manage-options.php?id=<?php echo $row['id'];?>" class="tip" title="Edit"><i class="icon-pencil"></i></a></li>
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
