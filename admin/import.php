<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
include('get-user.php'); /* Geting logged in user details*/
include('functions.php'); 

if($userType!=1) /* This page only for admin - if normal user redirect to index page */
{
	header('location: index.php');
}

// form submit
if(isset($_POST['submit'])){
    
    $sql="insert into tbl_firm(userId,location,profile,companyName,address,contactNo,fax,googleMap,urlName,companyType,country,area,network1,network2,website)values";
    //validate whether uploaded file is a csv file
    $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
    if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'],$csvMimes)){
        if(is_uploaded_file($_FILES['file']['tmp_name'])){
            
            //open uploaded csv file with read only mode
            $csvFile = fopen($_FILES['file']['tmp_name'], 'r');
            
            //skip first line
            fgetcsv($csvFile);
            //parse data from csv file line by line
            while(($line = fgetcsv($csvFile)) !== FALSE){
                //check whether member already exists in database with same email                
                {
                    //insert member data into database
                    /*$con->query("INSERT INTO members (name, email, phone, created, modified, status) VALUES ('".$line[0]."','".$line[1]."','".$line[2]."','".$line[3]."','".$line[3]."','".$line[4]."')");*/
					
					$companyType = mysqli_real_escape_string($con,$_POST["companyType"]);
	$country = mysqli_real_escape_string($con,$line[1]);
	$address = mysqli_real_escape_string($con,$line[4]);
	$area = mysqli_real_escape_string($con,$line[3]);
	$network1 = mysqli_real_escape_string($con,$line[7]);
	$network2 = mysqli_real_escape_string($con,$line[8]);
	$location=mysqli_real_escape_string($con,$line[2]);
	$companyName	=mysqli_real_escape_string($con,$line[0]);
	$profile	=mysqli_real_escape_string($con,$line[9]);
	$email	=mysqli_real_escape_string($con,$line[10]);
	$contactNo	=mysqli_real_escape_string($con,$line[5]);
	$fax	=mysqli_real_escape_string($con,$line[6]);
	$googleMap	=mysqli_real_escape_string($con,$line[11]);
	$website	=mysqli_real_escape_string($con,$line[12]);
	
	$urlName=$companyName;
	$urlName = set_url_name($urlName);

	$sql.="('0','".$location."','$profile','$companyName','$address','$contactNo','$fax','$googleMap','$urlName','$companyType','$country','$area','$network1','$network2','$website'),";
	//mysqli_query($con,"insert into tbl_firm(userId,location,profile,companyName,address,contactNo,fax,googleMap,urlName,companyType,country,area,network1,network2)values('0','".$location."','$profile','$companyName','$address','$contactNo','$fax','$googleMap','$urlName','$companyType','$country','$area','$network1','$network2')") or die(mysqli_error($con));
		
		//			
					
                }
				
            }
            
            //close opened csv file
            fclose($csvFile);
			$sql=rtrim($sql,',');
			mysqli_query($con,$sql);
			echo '<script>alert("Import Successfully Completed");</script>';
            $qstring = '?status=succ';
        }else{
            $qstring = '?status=err';
        }
    }else{
        $qstring = '?status=invalid_file';
    }
	echo "<script>location.href = 'import.php'</script>";exit();
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

			    <!-- Page header --><br><!-- /Page header -->
				<h5 class="widget-name"><i class="icon-picture"></i>Import</h5>
				<form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">
	                <fieldset>

	                    <!-- Form validation -->
	                    <div class="widget">
	                    	<div class="well row-fluid">								
                                <div class="control-group">
										<label class="control-label">Type: <span class="text-error">*</span></label>
										<div class="controls">											
											<select name="companyType" class="validate[] styled">
											<?php $rslt=mysqli_query($con,"select * from tbl_category where activeStatus=1");
											while($row=mysqli_fetch_assoc($rslt))
											{?>
											<option value="<?php echo $row["id"];?>"><?php echo $row["categoryName"];?></option>
											<?php }?>
											</select>
										</div>
									</div>
								<div class="control-group">
	                                <label class="control-label">Choose CSV File:<br><a href="uploads/sample.csv" download><i class="icon-download"></i>Sample CSV File</a></label>
	                                <div class="controls">
	                                    <input type="file" name="file"  class="validate[required]">
	                                </div>
	                            </div>
                                
                                
	                            <div class="form-actions align-right">
	                                <button type="submit" class="btn btn-info" name="submit">Submit</button>
	                                <button type="reset" class="btn">Reset</button>
	                            </div>

	                        </div>

	                    </div>
	                    <!-- /form validation -->

	                </fieldset>
				</form>
				<!-- /form validation -->
                
                <!-- form submission -->
   
                <!-- /form submission -->             
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
