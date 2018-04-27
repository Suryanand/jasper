<?php 
include("session.php"); 
include("config.php"); 
if($userType != 1) /* This page only for admin - if normal user redirect to index  */
{
	header('location: index.php');
}
include('get-user.php'); 
if(isset($_POST["delete"]))
{		
	mysqli_query($con,"delete from tbl_registration where id='".$_POST["delete"]."'");
	if(isset($_GET["id"]))
		echo "<script>location.href = 'view-enquiries.php?id=1'</script>";
	else
		echo "<script>location.href = 'view-enquiries.php'</script>";
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

<?php include_once('js-scripts.php'); ?><script>/* confirm to delete job */function clickMe(){var r=confirm("Are you sure to delete?");if(r==true)  { return true;  }else{return false;}}</script>
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
      <h5 class="widget-name"><i class="icon-th"></i><?php if(isset($_GET["id"])) echo "Registrations"; else echo "Contact Form Enquiries"?> 
	  <a class=" pull-right" href='export-list.php<?php if(isset($_GET["id"])) echo "?id=".$_GET["id"];?>' ><i style="padding:4px;" class="icon-download"></i> Export</a>
	  </h5>
      <div class="table-overflow">
        <form action="" method="post">
		
          <table class="table table-striped table-bordered table-checks media-table">
            <thead>
              <tr>
                <th>Sr.No.</th>
                <th>Parent Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Relation</th>
                <th>Student Name</th>
				<th>Gender</th>
				<th>DOB</th>
				<th>School Year</th>
				<th>Class</th>
				<th>Sibling</th>
                <th class="actions-column">Actions</th>
              </tr>
            </thead>
            <tbody>
              <!-- Display All News and Events -->
              <?php	
				if(isset($_GET["id"]))
					$rslt=mysqli_query($con,"select * from tbl_registration where formType=1 order by id desc");
				else
					$rslt=mysqli_query($con,"select * from tbl_registration where formType=0 order by id desc");
			  $i=0;								
			  while($row=mysqli_fetch_array($rslt))								
			  {									
				$i++;
				?>
              <tr>
                <td><?php echo $i;?></td>
                <td><?php echo $row['parentFirstName']." ".$row["parentLastName"]; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['phone']; ?></td>
                <td><?php echo $row['relation']; ?></td>
                <td><?php echo $row['studentFirstName']." ".$row["studentLastName"]; ?></td>
				<td><?php echo $row['gender']; ?></td>
				<td><?php echo $row['dob']; ?></td>
                <td><?php echo $row['schoolYear']; ?></td>
                <td><?php echo $row['class']; ?></td>               
                <td><?php echo $row['sibling']; ?></td>               
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
<script src="js/table2excel.js"></script>
<script>
			
		</script>
</body>
</html>