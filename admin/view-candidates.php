<?php include("session.php"); /*Check for session is set or not if not redirect to login page */include("config.php"); /* Connection String*/if($userType==2) /* This page only for admin - if normal user redirect to index page */{	header('location: index.php');}include('get-user.php'); /* Geting logged in user details*/if(isset($_POST["delete"])){	$rslt=mysqli_query($con,"select resume from tbl_candidates where id='".$_POST["delete"]."'");	$row=mysqli_fetch_assoc($rslt);	unlink("../resume/".$row["resume"]);	mysqli_query($con,"delete from tbl_candidates where id='".$_POST["delete"]."'");}?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<title><?php echo $title; ?></title>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<!--[if IE 8]><link href="css/ie8.css" rel="stylesheet" type="text/css" /><![endif]-->
<link href='css/gfonts.css' rel='stylesheet' type='text/css'>

<?php include_once('js-scripts.php'); ?><script>$(document).ready(function(){    $("#validate").validationEngine('attach');});/* confirm to delete job */function clickMe(){var r=confirm("Are you sure to delete?");if(r==true)  { return true;  }else{return false;}}</script>
</head>
<body>
<!-- Fixed top -->
<?php include_once('top-bar.php'); ?>
<!-- /fixed top --> <!-- Content container -->
<div id="container"> <!-- Sidebar -->
  <?php include_once('side-bar.php');?>
  <!-- /sidebar --> <!-- Content -->
  <div id="content"> <!-- Content wrapper -->
    <div class="wrapper"> <!-- Breadcrumbs line -->
      <?php include_once('bread-crumbs.php'); ?>
      <!-- /breadcrumbs line --> <!-- Page header -->
      <br>
      <!-- /page header -->
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
                <th>Qualification</th>
                <th>Experience</th>
                <th>Resume</th>
                <th class="actions-column">Actions</th>
              </tr>
            </thead>
            <tbody>
              <!-- Display All News and Events -->
              <?php								
			  $rslt=mysqli_query($con,"select * from tbl_candidates order by id desc");
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
                <td><?php echo $row['position']; ?></td>
                <td><?php echo $row['comment']; ?></td>
                <td style="text-align:center;"><a href="../resume/<?php echo $row['resume']; ?>" style="text-align:center;" download class="tip" title="Download"><i class="icon-download"></i></a></td>
                <td><ul class="navbar-icons">
                    <li>
                      <button type="submit" title="Remove" onClick="return clickMe()" value="<?php echo $row['id'];?>" class="remove-button-icon" name="delete"><i class="icon-remove"></i></button>
                    </li>
                  </ul></td>
              </tr>
              <?php } ?>
              <!-- /Display All News and Events -->
            </tbody>
          </table>
        </form>
      </div>
    </div>
    <!-- /content wrapper --> </div>
  <!-- /content --> </div>
<!-- /content container -->
<?php     // echo response     if(isset($_SESSION["response"]))    {        echo "<script>alert('".$_SESSION["response"]."');</script>";        unset($_SESSION["response"]);    }    ?>
<!-- Footer -->
<?php include_once('footer.php'); ?>
<!-- /footer -->
</body>
</html>