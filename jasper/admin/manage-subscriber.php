<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
include('get-user.php'); /* Geting logged in user details*/

if($userType==2 && !isset($m_subscription)) /* This page only for admin - if normal user redirect to index page */
{
	header('location: index.php');
}

$emailId="";
$group="";
if(isset($_GET["edit_id"]))
{
	$rslt=mysqli_query($con,"select * from tbl_subscription where subscriptionId='".$_GET["edit_id"]."'");
	$row=mysqli_fetch_assoc($rslt);
	$emailId=$row["subscriptionEmail"];
	$group=$row["emailGroup"];
}

if(isset($_POST["save"]))
{
	$emailId=$_POST["emailId"];
	$group=$_POST["emailGroup"];
	if(isset($_GET["edit_id"]))
		mysqli_query($con,"update tbl_subscription set subscriptionEmail='".$emailId."',emailGroup='".$group."' where subscriptionId='".$_GET["edit_id"]."'");
	else
		mysqli_query($con,"insert into tbl_subscription(subscriptionEmail,emailGroup,subscriptionDate) values('".$emailId."','".$group."',NOW())");
	echo "<script>location.href = 'manage-subscriber.php';</script>";
}

if(isset($_POST["delete"]))
{
	$deleteId	= mysqli_real_escape_string($con,$_POST["delete"]);
	mysqli_query($con,"delete from tbl_subscription where subscriptionId='$deleteId'");
}

if(isset($_POST["unsubscribe"]))
{
	$unsubscribeId	= mysqli_real_escape_string($con,$_POST["unsubscribe"]);
	mysqli_query($con,"update tbl_subscription set activeStatus=0 where subscriptionId='$unsubscribeId'");
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

if(isset($_POST["apply"]))
{
	if(isset($_POST["selected_email"]))
	{
		if($_POST["bulk_action"]==1)
		{
			foreach($_POST["selected_email"] as $email)
			{
				mysqli_query($con,"update tbl_subscription set activeStatus='0' where subscriptionEmail='".$email."'");
			}
		}
		else if($_POST["bulk_action"]==2)
		{
			$mailGroup=$_POST["mailGroup"];
			foreach($_POST["selected_email"] as $email)
			{
				mysqli_query($con,"update tbl_subscription set emailGroup='".$mailGroup."' where subscriptionEmail='".$email."'");
			}
		}
		else
		{
			foreach($_POST["selected_email"] as $email)
			{
				mysqli_query($con,"delete from tbl_subscription where subscriptionEmail='".$email."'");
			}
		}
	}
}

if (isset($_POST['upload'])) {
	if (is_uploaded_file($_FILES['filename']['tmp_name'])) {
		//echo "<h1>" . "File ". $_FILES['filename']['name'] ." uploaded successfully." . "</h1>";
		/* echo "<h2>Displaying contents:</h2>";
		readfile($_FILES['filename']['tmp_name']); */
	}

	//Import uploaded file to Database
	$handle = fopen($_FILES['filename']['tmp_name'], "r");
	$duplicate="";
	while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
		$rslt=mysqli_query($con,"select * from tbl_subscription where subscriptionEmail='$data[0]'");
		if(!mysqli_num_rows($rslt)>0)
		{
			if(isset($_GET["id"]))
				mysqli_query($con,"INSERT into tbl_subscription(subscriptionEmail,emailGroup) values('".$data[0]."','".$_GET["id"]."')") or die(mysqli_error($con));
			else
				mysqli_query($con,"INSERT into tbl_subscription(subscriptionEmail) values('$data[0]')") or die(mysqli_error($con));
		}
		else
		{
			$duplicate.=$data[0].'<br>';			
		}
	}

	fclose($handle);
	//view upload form
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
      <!--  <br>--> 
      <!-- /page header -->
      <br clear="all"/>
      <h5 class="widget-name"><i class="icon-envelope-alt"></i>Manage Subscribers 
	  <!--<a href="csv-download.php" target="_blank" style="float:right;color:#555 !important;"> <i style="padding:4px;" class="icon-plus"></i>Export</a> -->
	  <a href="manage-mail-groups.php" style="float:right;color:#555 !important;"> <i style="padding:3px;" class="icon-th"></i>Mail Groups</a>
	  <a href="manage-unsubscriber.php" style="float:right;color:#555 !important;margin-right:10px"> <i style="padding:3px;" class="icon-th"></i>Unsubscribe List</a>
	  </h5>
        <fieldset>
          <!-- Form validation -->
          <div class="widget">
            <div class="well row-fluid">
			<form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">
              <div class="control-group">
                <label class="control-label">Import email address:<br>
				<a href="downloads/email_csv.csv" download> Download sample file</a>
				</label>
                <div class="controls">
                  <input size='50' type='file' name='filename'>
                  <input type='submit' class="btn btn-info updt-btn" name='upload' value='Upload'>
                </div>
              </div>
              <?php if(isset($_POST["upload"])){?>
              <div class="control-group"> <span style="color:#07A90E;">Import Done</span><br>
                <?php if(!empty($duplicate)) echo "<strong>Duplicate entries :</strong><br>".$duplicate;?>
              </div>
              <?php }?>
			<form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">			  
              <div class="control-group">
                <label class="control-label">Email / Group<br>
				</label>
                <div class="controls">
					<input type="text" value="<?php if(isset($_GET["edit_id"])) echo $emailId;?>" placeholder="Email" class="validate[required] input-large" name="emailId" />
					<select name="emailGroup" id="emailGroup" class="input-large">
                    <option value="">Choose Group...</option>
                    <?php
					$rslt1=mysqli_query($con,"select * from tbl_mail_groups");
					while($row1=mysqli_fetch_array($rslt1))
					{
					?>
                    <option value="<?php echo $row1["id"];?>" <?php if(isset($_GET["edit_id"]) && $row1["id"]==$group) echo "selected";?>><?php echo $row1["groupName"];?></option>
                    <?php } ?>
                  </select>
                  <button type='submit' class="btn btn-info updt-btn" name='save'><?php if(isset($_GET["edit_id"])) echo "Update";else echo "Save";?></button>
                </div>
              </div>
			</form>
			  
            </div>
          </div>
          <!-- /form validation -->
        </fieldset>
      <div class="table-overflow">
        <form action="" method="post">
          <table class="table table-striped table-bordered table-checks media-table">
            <thead>
				<?php 
				$all=0;
				$magazine=0;
				$video=0;
				$rslt=mysqli_query($con,"select * from tbl_subscription where activeStatus=1");
				while($row=mysqli_fetch_assoc($rslt))
				{
					$all++;
				}
				?>
				<tr>
					<th colspan="">
						<input type="checkbox" style="margin-top:12px;float:left;" class="styled select_all" name="select_all" />
					</td>
					<th colspan="5">
						<div  style="float:left;">
							<select name="bulk_action" class="input-medium bulk_action" style="padding:0px 5px;">
								<option value="1">Unsubscribe</option>
								<option value="2">Move To</option>
								<option value="3">Delete</option>
							</select>
							<select name="mailGroup" style="display:none" id="mailGroup" class="input-large">
								<option value="">Choose Group...</option>
								<?php
								$rslt1=mysqli_query($con,"select * from tbl_mail_groups");
								while($row1=mysqli_fetch_array($rslt1))
								{
								?>
								<option value="<?php echo $row1["id"];?>" <?php if(isset($_GET["edit_id"]) && $row1["id"]==$group) echo "selected";?>><?php echo $row1["groupName"];?></option>
								<?php } ?>
							  </select>
						  <input type="submit" class="btn btn-info updt-btn" value="Apply" name="apply"/>
						</div>
						<div style="float:right;padding-top:8px;">
						<a href="manage-subscriber.php">All (<?php echo $all;?>) &nbsp;&nbsp;&nbsp; </a>
						<?php
								$rslt1=mysqli_query($con,"select * from tbl_mail_groups");
								while($row1=mysqli_fetch_array($rslt1))
								{
									$rslt2=mysqli_query($con,"select * from tbl_subscription where emailGroup='".$row1["id"]."'");									
								?>
								<a href="manage-subscriber.php?id=<?php echo $row1["id"]?>"> | &nbsp;&nbsp;&nbsp;<?php echo $row1["groupName"];?> (<?php echo mysqli_num_rows($rslt2);?>) &nbsp;&nbsp;&nbsp; </a>
								<?php }?>
						<div>
					</th>
					<!--<th colspan="2" style="text-align:center;">
						<a href="manage-subscriber.php">All (<?php echo $all;?>) &nbsp;&nbsp;&nbsp; </a>
					</th>-->
				</tr>
              <tr>
                <th></th>
                <th class="width5 align-center">Sr.No.</th>
                <th>Subscriber</th>
                <th class="align-center">Mail Group</th>
                <th class="align-center">Date</th>
                <th class="align-center">Actions</th>
              </tr>
            </thead>
            <tbody>
              <!-- Display All Subscribers -->
              <?php
				$rslt=mysqli_query($con,"select * from tbl_subscription where activeStatus=1");
				if(isset($_GET["id"]))
				{
					$rslt=mysqli_query($con,"select * from tbl_subscription where emailGroup='".$_GET["id"]."' and activeStatus=1");
				}
				$i=0;
				while($row=mysqli_fetch_array($rslt))
				{
				$i++;
				?>
              <tr>
				<td><input type="checkbox" class="styled selected_email" value="<?php echo $row['subscriptionEmail'];?>" name="selected_email[]" /></td>
                <td class="align-center"><?php echo $i;?></td>
                <td><?php echo $row['subscriptionEmail']; ?></td>
                
                <td class="align-center"><?php
											$rslt1=mysqli_query($con,"select * from tbl_mail_groups");
											while($row1=mysqli_fetch_array($rslt1))
											{
											?>
                    <?php if($row["emailGroup"]==$row1["id"]) echo $row1["groupName"];?>
                    <?php } ?>
                  </td>
				  <td class="align-center"><?php echo date('d M Y',strtotime($row['subscriptionDate'])); ?></td>
                <td class="align-center">
					<ul class="navbar-icons">
						<li>
							<button type="submit" title="Unsubscribe" style="float:left;" value="<?php echo $row['subscriptionId'];?>" class="remove-button-icon tip" name="unsubscribe"> 
						  <i class="icon-minus idesign3"></i></button>
						</li>
						<li><a href="manage-subscriber.php?edit_id=<?php echo $row['subscriptionId'];?>" class="tip" title="Edit"><i class="icon-pencil idesign"></i></a></li>
						
						<li>
							<button type="submit" title="Remove" onClick="return clickMe()" value="<?php echo $row['subscriptionId'];?>" class="tip remove-button-icon" name="delete"><i class="icon-remove idesign2"></i> </button>
						</li>
                  </ul>
				</td>
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
<script>
//select all checkboxes
$(".select_all").change(function(){  //"select all" change 
    var status = this.checked; // "select all" checked status
    $('.selected_email').each(function(){ //iterate all listed checkbox items
        this.checked = status; //change ".checkbox" checked status
    });
});

$('.selected_email').change(function(){ //".checkbox" change 
    //uncheck "select all", if one of the listed checkbox item is unchecked
    if(this.checked == false){ //if this item is unchecked
        $(".select_all")[0].checked = false; //change "select all" checked status to false
    }
    
    //check "select all" if all checkbox items are checked
    if ($('.selected_email:checked').length == $('.selected_email').length ){ 
        $(".select_all")[0].checked = true; //change "select all" checked status to true
    }
});

$(".bulk_action").change(function(){
	if($(this).val()==2)
	{
		$("#mailGroup").show();
	}
	else
	{
		$("#mailGroup").hide();
	}
});
</script>
</body>
</html>
