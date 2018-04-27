<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
if($userType != 1) /* This page only for admin - if normal user redirect to index page */
{
	header('location: index.php');
}
include('get-user.php'); /* Geting logged in user details*/

$id = $_GET['id'];
$rslt=mysqli_query($con,"select * from tbl_student_registration where id='".$id."'");
$row=mysqli_fetch_assoc($rslt);

$studentName=$row["studentName"];
	$surName=$row["surName"];
	$dob=date('Y-m-d',strtotime($row["dob"]));
	$nationality=$row["nationality"];
	$gender=$row["gender"];
	$religion=$row["religion"];
	$firstLanguage=$row["firstLanguage"];
	$otherLanguage=$row["otherLanguage"];
	$nurseryAttended=$row["nurseryAttended"];
	
	$fname=$row["fname"];
	$fnationality=$row["fnationality"];
	$fprofession=$row["fprofession"];
	$femployer=$row["femployer"];
	$mname=$row["mname"];
	$mnationality=$row["mnationality"];
	$mprofession=$row["mprofession"];
	$memployer=$row["memployer"];
	$siblingSchool=$row["siblingSchool"];
	$siblingName1=$row["siblingName1"];
	$siblingDOB1=date('Y-m-d',strtotime($row["siblingDOB1"]));
	$siblingName2=$row["siblingName2"];
	$siblingDOB2=date('Y-m-d',strtotime($row["siblingDOB2"]));
	$siblingName3=$row["siblingName3"];
	$siblingDOB3=date('Y-m-d',strtotime($row["siblingDOB3"]));
	
	$address=$row["address"];
	$pobox=$row["pobox"];
	$homePhone=$row["homePhone"];
	$officePhone=$row["officePhone"];
	$mMobile=$row["mMobile"];
	$fMobile=$row["fMobile"];
	$mEmail=$row["mEmail"];
	$fEmail=$row["fEmail"];
	$emergencyName=$row["emergencyName"];
	$emergencyPhone=$row["emergencyPhone"];
	
	$authPerson1=$row["authPerson1"];
	$authRelation1=$row["authRelation1"];
	$authContact1=$row["authContact1"];
	$authPerson2=$row["authPerson2"];
	$authRelation2=$row["authRelation2"];
	$authContact2=$row["authContact2"];
	$authPerson3=$row["authPerson3"];
	$authRelation3=$row["authRelation3"];
	$authContact3=$row["authContact3"];
	
	$enrollmentTime=$row["enrollmentTime"];
	$enrollmentDay=$row["enrollmentDay"];



	if(isset($_POST["delete"]))
	{
		mysqli_query($con,"delete from tbl_student_registration where id='".$id."'");
		echo "<script>location.href = 'view-registrations.php'</script>";exit();
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
			    <!-- /page header -->
					<h5 class="widget-name"><i class="icon-th"></i>Registration Details
				</h5>

	                    <!-- Form validation -->
	                    <div class="widget">
	                       
                            
							<div class="well row-fluid">                            
                            	<div class="well-smoke body">
                            	<div class="span12">
									<table class="table">
										<tbody>
										<tr><td colspan="2"><h3>Child Information</h3></td></tr>
											<tr>
												<td align="left" valign="top" nowrap>Student Name</td><td>&nbsp;:&nbsp;<?php echo $studentName; ?></td>
											  </tr>
											  <tr>
												<td align="left" valign="top" nowrap>Surname</td><td>&nbsp;:&nbsp;<?php echo $surName;?></td>
											  </tr>
											  <tr>
												<td align="left" valign="top" nowrap>Date of Birth</td><td>&nbsp;:&nbsp;<?php echo $dob; ?></td>
											  </tr>
											  <tr>
												<td align="left" valign="top" nowrap>Nationality</td><td>&nbsp;:&nbsp;<?php echo $nationality; ?></td>
											  </tr>
											  <tr>
												<td align="left" valign="top" nowrap>Gender</td><td>&nbsp;:&nbsp;<?php echo $gender; ?></td>
											  </tr>
											  
											  <tr>
												<td align="left" valign="top" nowrap>Religion</td><td>&nbsp;:&nbsp;<?php echo $religion; ?></td>
											  </tr>
											  <tr>
												<td align="left" valign="top" nowrap>first Language</td><td>&nbsp;:&nbsp;<?php echo $firstLanguage; ?></td>
											  </tr>
											  <tr>
												<td align="left" valign="top" nowrap>Other Language</td><td>&nbsp;:&nbsp;<?php echo $otherLanguage; ?></td>
											  </tr>
											  <tr>
												<td align="left" valign="top" nowrap>Has the child attended nursery before?</td><td>&nbsp;:&nbsp;<?php echo $nurseryAttended; ?></td>
											  </tr>
											  
											  <tr><td colspan="2"><h3>Family Information</h3></td></tr>
											  
											  <tr>
												<td align="left" valign="top" nowrap>Father's Name</td><td>&nbsp;:&nbsp;<?php echo $fname; ?></td>
											  </tr>
											  <tr>
												<td align="left" valign="top" nowrap>Nationality</td><td>&nbsp;:&nbsp;<?php echo $fnationality; ?></td>
											  </tr>
											  <tr>
												<td align="left" valign="top" nowrap>Profession</td><td>&nbsp;:&nbsp;<?php echo $fprofession; ?></td>
											  </tr>
											  <tr>
												<td align="left" valign="top" nowrap>Employer</td><td>&nbsp;:&nbsp;<?php echo $femployer; ?></td>
											  </tr>
											  <tr>
												<td align="left" valign="top" nowrap>Mother's Name</td><td>&nbsp;:&nbsp;<?php echo $mname; ?></td>
											  </tr>
											  <tr>
												<td align="left" valign="top" nowrap>Nationality</td><td>&nbsp;:&nbsp;<?php echo $mnationality; ?></td>
											  </tr>
											  <tr>
												<td align="left" valign="top" nowrap>Profession</td><td>&nbsp;:&nbsp;<?php echo $mprofession; ?></td>
											  </tr>
											  <tr>
												<td align="left" valign="top" nowrap>Employer</td><td>&nbsp;:&nbsp;<?php echo $memployer; ?></td>
											  </tr>
											  <tr>
												<td align="left" valign="top" nowrap>Siblings Name 1</td><td>&nbsp;:&nbsp;<?php echo $siblingName1; ?></td>
											  </tr>
											  <tr>
												<td align="left" valign="top" nowrap>DOB</td><td>&nbsp;:&nbsp;<?php echo $siblingDOB1; ?></td>
											  </tr>
											  <tr>
												<td align="left" valign="top" nowrap>Siblings Name 2</td><td>&nbsp;:&nbsp;<?php echo $siblingName2; ?></td>
											  </tr>
											  <tr>
												<td align="left" valign="top" nowrap>DOB</td><td>&nbsp;:&nbsp;<?php echo $siblingDOB2; ?></td>
											  </tr>
											  <tr>
												<td align="left" valign="top" nowrap>Siblings Name 3</td><td>&nbsp;:&nbsp;<?php echo $siblingName3; ?></td>
											  </tr>
											  <tr>
												<td align="left" valign="top" nowrap>DOB</td><td>&nbsp;:&nbsp;<?php echo $siblingDOB3; ?></td>
											  </tr>
											  <tr>
												<td align="left" valign="top" nowrap>What school do siblings attend?</td><td>&nbsp;:&nbsp;<?php echo $siblingSchool; ?></td>
											  </tr>
											  
											  <tr><td colspan="2"><h3>Contact Details</h3></td></tr>
											  <tr>
												<td align="left" valign="top" nowrap>Home address</td><td>&nbsp;:&nbsp;<?php echo $address; ?></td>
											  </tr><tr>
												<td align="left" valign="top" nowrap>PO Box</td><td>&nbsp;:&nbsp;<?php echo $pobox; ?></td>
											  </tr><tr>
												<td align="left" valign="top" nowrap>Home Telephone</td><td>&nbsp;:&nbsp;<?php echo $homePhone; ?></td>
											  </tr><tr>
												<td align="left" valign="top" nowrap>Office Telephone</td><td>&nbsp;:&nbsp;<?php echo $officePhone; ?></td>
											  </tr><tr>
												<td align="left" valign="top" nowrap>Father's Mobile</td><td>&nbsp;:&nbsp;<?php echo $fMobile; ?></td>
											  </tr><tr>
												<td align="left" valign="top" nowrap>Mother's Mobile</td><td>&nbsp;:&nbsp;<?php echo $mMobile; ?></td>
											  </tr>
											  <tr>
												<td align="left" valign="top" nowrap>Father's Email</td><td>&nbsp;:&nbsp;<?php echo $fEmail; ?></td>
											  </tr>
											  <tr>
												<td align="left" valign="top" nowrap>Mother's Email</td><td>&nbsp;:&nbsp;<?php echo $mEmail; ?></td>
											  </tr>
											  <tr>
												<td align="left" valign="top" nowrap>Emergency Contact name</td><td>&nbsp;:&nbsp;<?php echo $emergencyName; ?></td>
											  </tr><tr>
												<td align="left" valign="top" nowrap>Emergency Contact Number</td><td>&nbsp;:&nbsp;<?php echo $emergencyPhone; ?></td>
											  </tr>
											  
											  <tr><td colspan="2"><h3>Authorised Persons to collect Child from Nursery</h3></td></tr>
											  
											  <tr>
												<td align="left" valign="top" nowrap>Person name 1</td><td>&nbsp;:&nbsp;<?php echo $authPerson1; ?></td>
											  </tr><tr>
												<td align="left" valign="top" nowrap>Relation to Student 1</td><td>&nbsp;:&nbsp;<?php echo $authRelation1; ?></td>
											  </tr><tr>
												<td align="left" valign="top" nowrap>Contact 1</td><td>&nbsp;:&nbsp;<?php echo $authContact1; ?></td>
											  </tr>
											  <tr>
												<td align="left" valign="top" nowrap>Person name 2</td><td>&nbsp;:&nbsp;<?php echo $authPerson2; ?></td>
											  </tr><tr>
												<td align="left" valign="top" nowrap>Relation to Student 2</td><td>&nbsp;:&nbsp;<?php echo $authRelation2; ?></td>
											  </tr><tr>
												<td align="left" valign="top" nowrap>Contact 2</td><td>&nbsp;:&nbsp;<?php echo $authContact2; ?></td>
											  </tr>
											  <tr>
												<td align="left" valign="top" nowrap>Person name 3</td><td>&nbsp;:&nbsp;<?php echo $authPerson3; ?></td>
											  </tr><tr>
												<td align="left" valign="top" nowrap>Relation to Student 3</td><td>&nbsp;:&nbsp;<?php echo $authRelation3; ?></td>
											  </tr><tr>
												<td align="left" valign="top" nowrap>Contact 3</td><td>&nbsp;:&nbsp;<?php echo $authContact3; ?></td>
											  </tr>
											  <tr>
												<td align="left" valign="top" nowrap>Enrolment Days and Timings</td><td>&nbsp;:&nbsp;<?php echo $enrollmentDay." - ".$enrollmentTime; ?></td>
											  </tr>
											
										</tbody>
									</table>
									<form action="" method="post">
									<div class="control-group">
	                                <div class="controls">									
										<a href="view-registrations.php" class="btn btn-info" >Back</a>
	                                </div>
									</div>
									</form>
                                    </div>
									
									<br clear="all"/>
                                    </div>                                
												
	                        </div>

	                    </div>
	                    <!-- /form validation -->
				<!-- /form validation -->

				<!-- form submition - add new user-->                
				<?php
				?>  
				<!-- /form submition -->                              
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
$('#exampleModal').on('show.bs.modal', function (event) {
})
</script>
</body>
</html>
