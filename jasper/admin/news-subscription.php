<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
include('get-user.php'); /* Geting logged in user details*/

if($userType!=1) /* This page only for admin - if normal user redirect to index page */
{
	header('location: index.php');
}


if(isset($_POST["submit"]))
{
	$rslt=mysqli_query($con,"select * from tbl_company_address");
	$row=mysqli_fetch_assoc($rslt);
	$companyEmail = $row["companyEmail"];
	$companyName = $row["companyName"];
	
	$rslt=mysqli_query($con,"select subscriptionEmail from tbl_settings");
	$row=mysqli_fetch_assoc($rslt);
	$subscriptionEmail = $row["subscriptionEmail"];

	$rslt=mysqli_query($con,"select * from tbl_subscription_mails where id='".$_GET["id"]."'");
	$row=mysqli_fetch_assoc($rslt);
	$subject=$row["subject"];
	$signature=$row["signature"];
	$body=$row["body"]."<br>".$signature;
	$email_to="";
	$emailFrom=$subscriptionEmail;
	foreach($_POST['email'] as $grp)
	{
		$rslt=mysqli_query($con,"select * from tbl_subscription where emailGroup='".$grp."' and activeStatus=1");
		while($row=mysqli_fetch_assoc($rslt))
		{
			$email_to.=$row["subscriptionEmail"].",";
		}
	}
	$email_to=rtrim($email_to,',');
	$toEmail=explode(",",$email_to);
	require "mail.php";
	/* $headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: '.$email_from. "\r\n";
	@mail($email_to, $subject, $body, $headers);
 */	
	echo "<script>location.href = 'news-subscription.php'</script>;";												
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
<script type="text/javascript">
function clickMe()
{
	if($('#select').is(':checked'))
	{
		$('.email').each(function(){
			this.checked = true;
		});
	}
	else
	{
		$('.email').each(function(){
			this.checked = false;
		});
	}
}
function validate()
{
	var flag=0;
	$('.email').each(function(){
			if(this.checked == true)
				flag=1;
		});
	
	if(flag==1)
		return true;
	else
	{
		alert("No recipient choosen");
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
			    <!-- Page header -->
			          <h5 class="widget-name"><i class="icon-mail"></i>Send Mail</h5>

			    <!-- /page header -->


				                <!-- Default wizard -->
                <div class="widget">
                    
                    <form id="" method="post" action="" class="form-horizontal row-fluid well">                        
                        <fieldset id="step2" class="step">
								<div class="control-group">
	                                <div class="controls">
										<label class="checkbox inline">
											<input class="styled" onClick="clickMe()" type="checkbox" name="select" id="select" value="" data-prompt-position="topLeft:-1,-5"/>
											Select All
										</label>
	                                </div>
	                            </div>                        

								<div class="control-group">
	                                <label class="control-label">Group: <span class="text-error">*</span></label>
									<?php
									$rslt=mysqli_query($con,"select * from tbl_mail_groups");
									while($row=mysqli_fetch_array($rslt))
									{
									?>								
	                                <div class="controls">
										<label class="checkbox inline">
											<input class="email validate[minCheckbox[1]]" type="checkbox" name="email[]" id="" value="<?php echo $row['id']; ?>" data-prompt-position="topLeft:-1,-5"/>
											<?php echo $row['groupName']; ?>
										</label>
	                                </div>
									<?php } ?>
	                            </div>                        
						</fieldset>
                        <div class="form-actions align-right">
                            <input type="submit" onClick="return validate()" class="btn btn-info" name="submit" id="next-1" value="Next">
                        </div>
                    </form>
                </div>
                <!-- /default wizard -->


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
