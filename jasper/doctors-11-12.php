<?php 
include_once('admin/config.php');

$rslt=mysqli_query($con,"select * from tbl_settings");
$row=mysqli_fetch_assoc($rslt);
$default_doctor_image=$row["default_doctor_image"];
?>
<!DOCTYPE html>
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en-US"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en-US"> <![endif]-->
<!--[if gt IE 8]><!-->
<html lang="en">
		<head>
		<!-- Meta Description -->
		<meta charset="UTF-8">
		<?php include_once("includes/meta-tags.php");?>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<!-- Site Title -->
		<!-- Site Favicon -->
		<link rel="icon" href="<?php echo $absolutePath;?>assets/img/fav_icon.png">
		<!-- Bootstrap -->
		<link rel="stylesheet" href="<?php echo $absolutePath;?>assets/css/bootstrap.min.css">
               
		<!-- Fontawesome -->
		<link rel="stylesheet" href="<?php echo $absolutePath;?>assets/css/font-awesome.min.css">
		<!-- Owl Carousel -->
		<link rel="stylesheet" href="<?php echo $absolutePath;?>assets/css/owl.carousel.min.css">
		<link rel="stylesheet" href="<?php echo $absolutePath;?>assets/css/owl.theme.default.min.css">
		<!-- Animate css -->
		<link rel="stylesheet" href="<?php echo $absolutePath;?>assets/css/animate.min.css">
		<!-- Icon Font -->
		<link rel="stylesheet" href="<?php echo $absolutePath;?>assets/css/icofont.css">
		<!-- Responsive Menu css -->
		<link rel="stylesheet" href="<?php echo $absolutePath;?>assets/css/slicknav.min.css">
		<!-- Custom css -->
		<link rel="stylesheet" href="<?php echo $absolutePath;?>assets/css/style.css">
		<!-- Responsive css -->
		<link rel="stylesheet" href="<?php echo $absolutePath;?>assets/css/responsive.css">
		<style>
.sidebar-title {
	padding: 10px;
	background: #343434;
	color: #fff;
}
.filter-label input {
	margin-right: 5px;
}
.filter-label {
	width: 100%;
	font-size: 14px;
	font-family: 'Ubuntu', sans-serif;
	font-weight: 300;
	cursor: pointer;
}
.contact-info h4 {
	font-weight: 800;
	font-family: 'Ubuntu', sans-serif;
}
</style>
		</head>

		<body>
<!-- Start Site Preloader Area -->
<div class="site-preloader">
          <div class="spinner"></div>
        </div>
<!-- End Site Preloader Area --> 

<!-- Start Header Area -->
<?php include_once("includes/header.php");?>
<!-- Start Breadcrumb Section -->
<div class="home-slider-wrapper" id="top">
          <div class="home-slider"> <!-- Start Slider -->
    <div class="Breadcrumbs page-header-img-1"> <!-- Slider Image -->
              <div class="bg-overlay opacity-9"></div>
              <!-- Slider Overlay -->
              <div class="slider-item-table">
        <div class="slider-item-table-cell">
                  <div class="container">
            <div class="row">
                      <div class="col-md-12 slider-content"> <!-- Slider Text & Button -->
                <h2 class="wow fadeInDown">Doctors</h2>
                <ol class="breadcrumb">
                          <li><a href="<?php echo $absolutePath;?>">Home</a></li>
                          <li class="active">Doctors</li>
                        </ol>
              </div>
                    </div>
          </div>
                </div>
      </div>
            </div>
  </div>
        </div>
<!-- End Breadcrumb Section --> 

<!-- Start Dortor Profile Section -->
<div class="health-care-content-block solid-color"> <!-- Start Content Block -->
          
          <div class="container "> <!-- Start container -->
    
<div class="row">
<div class="col-xs-12 col-sm-12 col-md-12"> <!-- Feature 1 -->
<div class="single-feature-item wow fadeIn text-left mt-0">
<h3 class="mt-0" style="text-align:center">Let's get started. What type of specialist are you looking for?</h3><br clear="all"/>
<?php
$rslt=mysqli_query($con,"SELECT * FROM tbl_specialty where activeStatus='1' order by Name DESC");
while($row=mysqli_fetch_array($rslt))
{
?>
<form method="post" action="<?php echo $absolutePath;?>doctor-department.php">
<div class="tab3" style="float: left; margin-right: 10px; margin-bottom: 10px;">
<input type="hidden" name="specid" value="<?php echo $row['id'];?>">    
<input type="submit" name='searchdepartment' value='<?php echo $row['Name'];?>' class="health-care-btn2 slider-btn wow fadeInUp" style="height: 57px;width: 270px; border:1;">
</div>
</form>    
<?php }?>
</div>
</div>
<br clear="all"/> <br clear="all"/>        
              <div class="col-md-12">
        <div class="tab">
                  <button class="tablinks" onclick="openCity(event, '1')" id="defaultOpen">Find a Doctor</button>
                  <button class="tablinks" onclick="openCity(event, '2')">Search by Name</button>
                </div>
        <div id="1" class="tabcontent" style='height: 80px;     padding: 23px 30px !important;'>
                  <form action="search-doctors.php" method="get">
 <div class="col-md-3 col-xs-12">
<!--    <input type="text" name="location" required placeholder="City,State" class="form-control">   -->
						<select name="location" id="category" data-placeholder="City/State" class="select form-control" data-prompt-position="topLeft:-1,-5">
													
												<?php 
												//$rslt=mysqli_query($con,"SELECT t1.categoryId AS catId,categoryName FROM tbl_category t1 WHERE t1.activeStatus=1 and parentId=0");
												$rslt=mysqli_query($con,"SELECT * from tbl_locations order by region asc");
												while($row=mysqli_fetch_assoc($rslt))
												{
												?>			                                            
														<option value="<?php echo $row["region"];?>"><?php echo $row["region"];?></option>
												<?php } ?>
													</select>
                    </div>                      
            <div class="col-md-3 col-xs-12 p-0">
                      <select name='specialty' required class="form-control">
                <option value=''>Select a Specialty...</option>
                <?php
$rslt=mysqli_query($con,"SELECT * FROM tbl_specialty order by Name ASC");
while($row=mysqli_fetch_array($rslt))
{
?>
                <option value='<?php echo $row['Name'];?>'><?php echo $row['Name'];?></option>
                <?php } ?>
              </select>
                    </div>
           
            <div class="col-md-3 col-xs-12">
                      <input type="text" name="insurance" placeholder="Insurance (Optional)..." class="form-control">
                    </div>
            <div class="col-md-3 col-xs-12">
                      <input type="submit" name='search' value='Search' class="health-care-btn slider-btn wow fadeInUp" style="padding:7px 30px;border:none;">
                      <!-- Button --> 
                    </div>
          </form>
                </div>
        <div id="2" class="tabcontent" style='height: 80px; padding: 23px 30px !important;'>
                  <form action="search-doctors.php" method="get">
            <div class="col-md-3 col-xs-12">
                      <input type="text" name="fname" placeholder="First Name" class="form-control">
                    </div>
            <div class="col-md-3 col-xs-12">
                      <input type="text" name="lname" required placeholder="Last Name(Required)" class="form-control">
                    </div>
            <div class="col-md-3 col-xs-12 p-0">
                      <input type="submit" name='go' value='Go' class="health-care-btn slider-btn wow fadeInUp" style="padding:7px 30px;border:none;">
                      <!-- Button --> 
                    </div>
          </form>
                </div>
      </div>
              <br clear='all'>
              <br clear='all'>
              <div class="col-md-3">
    <div class="contact-info wow fadeIn">
                  <h4 class="sidebar-title1">Area</h4>
<input type="checkbox" id="mycheckbox1" />
<?php 
$rslt=mysqli_query($con,"select distinct area from tbl_trainers where type=3 and activeStatus=1 order by area asc limit 0,5");
while($row=mysqli_fetch_assoc($rslt)){ ?>
<label class="filter-label">
<input type="checkbox" class="location" value="<?php echo $row["area"];?>">
<?php echo $row["area"];?></label>
<?php }?>
<?php 
$rslt=mysqli_query($con,"select distinct area from tbl_trainers where type=3 and activeStatus=1 order by area asc limit 5,1000");
while($row=mysqli_fetch_assoc($rslt)){ ?>
<label class="filter-label moretext1">
<input type="checkbox" class="location" value="<?php echo $row["area"];?>">
<?php echo $row["area"];?></label>
<?php }?>
<label for="mycheckbox1" class="showmore1" style="float: right;"><i style="color: #727272;font-size: 12px !important;">more...</i></label>
                </div>
        <br clear="all"/> 
      
        <div class="contact-info wow fadeIn">
                  <h4 class="sidebar-title1">Gender</h4>
                  <label class="filter-label">
            <input type="checkbox" class="gender" value="1">
            Male</label>
                  <label class="filter-label">
            <input type="checkbox" class="gender" value="0">
            Female</label>
                </div>
        <br clear="all"/>
<div class="contact-info wow fadeIn">
<h4 class="sidebar-title1">Nationality</h4>
<input type="checkbox" id="mycheckbox2" />
<?php 
$rslt=mysqli_query($con,"select distinct nationality from tbl_trainers where type=3 and activeStatus=1 order by nationality asc limit 0,5");
while($row=mysqli_fetch_assoc($rslt)){?>
<label class="filter-label">
<input type="checkbox" class="nationality" value="<?php echo $row["nationality"];?>"><?php echo $row["nationality"];?></label>
<?php }?>
<?php 
$rslt=mysqli_query($con,"select distinct nationality from tbl_trainers where type=3 and activeStatus=1 order by nationality asc limit 5,1000");
while($row=mysqli_fetch_assoc($rslt)){?>
<label class="filter-label moretext2">
<input type="checkbox" class="nationality" value="<?php echo $row["nationality"];?>"><?php echo $row["nationality"];?></label>
<?php }?>
<label for="mycheckbox2" class="showmore2" style="float: right;"><i style="color: #727272;font-size: 12px !important;">more...</i></label>
</div>
        <br clear="all"/>
  <div class="contact-info wow fadeIn">
                  <h4 class="sidebar-title1">Insurance</h4>
                  <input type="checkbox" id="mycheckbox" />
                  <?php 
						$rslt=mysqli_query($con,"select * from tbl_insurance where activeStatus=1 order by insurance asc limit 0,5");
						while($row=mysqli_fetch_assoc($rslt))
						{
						?>
                  <label class="filter-label" title="<?php echo $row["insurance"];?>">
            <input type="checkbox" class="location" value="<?php echo $row["id"];?>">
           <?php echo substr($row["insurance"],0,20);?>...</label>
                  <?php }?>
                         <?php 
						$rslt=mysqli_query($con,"select * from tbl_insurance where activeStatus=1 order by insurance asc limit 5,1000");
						while($row=mysqli_fetch_assoc($rslt))
						{
						?>
                  <label class="filter-label moretext" title="<?php echo $row["insurance"];?>">
            <input type="checkbox" class="location" value="<?php echo $row["id"];?>">
           <?php echo substr($row["insurance"],0,20);?>...</label>
                  <?php }?>
                  <label for="mycheckbox" class="showmore" style="float: right;"><i style="color: #727272;font-size: 12px !important;">more...</i></label>
                </div>
        <br clear="all"/>        
        <?php /*<h4 class="sidebar-title">Rating</h4>
						<label class="filter-label"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></label>
						<label class="filter-label"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-o"></i></label>
						<label class="filter-label"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i></label>
						<label class="filter-label"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i></label>
						<label class="filter-label"><i class="fa fa-star"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i></label>*/?>
      </div>
              <div class="col-md-9 doctors_list p-0" style="border: 1px solid #d8d8d8;">
        <?php 
					$rslt=mysqli_query($con,"select * from tbl_trainers where activeStatus=1 and type=3 order by fullName asc");
					while($row=mysqli_fetch_assoc($rslt))
					{
						if(!empty($row["image"]))
						{
							$image=$absolutePath."uploads/images/trainers/".$row["image"];
						}
						else
						{
							$image=$absolutePath."uploads/images/".$default_doctor_image;
						}
					?>
        <div class="doc_class" >
                  <div class="col-md-4 pd1" style=""> <img class="img-bd" src="<?php echo $image;?>" alt="<?php echo $row["fullName"];?>" style="width:100%;"> 
                  <a href="<?php echo $absolutePath;?>doctors/<?php echo $row["urlName"];?>">
                    <h3><?php echo $row["fullName"];?></h3>
                    <?php 
					$qualification=strip_tags($row["qualification"]);
					?>
                    <!--<p><?php echo substr($qualification,0,50);?></p>-->
                    </a>
            <?php
//                            $specialized=$row["specialized"];
//                                                $rslt5=mysqli_query($con,"select * from tbl_specialty where id=$specialized");
//						$row5=mysqli_fetch_assoc($rslt5);
                        ?>
            <p><?php // echo $row5["Name"];?></p>
            <p><?php echo $row["location"];?></p>
            
            <p><label class="filter-label"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></label></p>
          <?php
          $shortprofile=strip_tags($row['profile']);
          ?>
            <?php /*?><p style="font-size:14px; line-height:14px;"><i style="margin-right:10px" class="fa fa-crosshairs" aria-hidden="true"></i><?php echo substr($shortprofile,0,65);?> <a href="<?php echo $absolutePath;?>doctors/<?php echo $row["urlName"];?>">See more...</a></p><?php */?>
                  
                  </div>
                  <!--<div class="col-md-9"> 
          </div>-->
             
                </div>
                  <?php
                  $contactNo=$row['contactNo'];
                  ?>
        
       <?php /*?><a href="#">  
       <div class="col-md-4 p-0 black-tab">
                <span><i class="fa fa-phone-square" style="padding-top: 22px;" aria-hidden="true"></i><h4 style="text-align: left;"><span style="font-size:12px;">New Patients</span><br><?php if($contactNo!=''){ echo $contactNo; } else { echo"-";}?></h4></span>
                </div></a>
       <a href="<?php echo $absolutePath;?>doctors/<?php echo $row["urlName"];?>"> 
       <div class="col-md-4 p-0 black-tab">
                 <span><h4><i class="fa fa-calendar" style="" aria-hidden="true"></i>Request an Appointment</h4></span>
                </div></a>
       <a href="<?php echo $absolutePath;?>doctors/<?php echo $row["urlName"];?>"> 
       <div class="col-md-4 p-0 black-tab">
                 <span><h4> <i class="fa fa-star" style="" aria-hidden="true"></i>Leave a Review</h4></span>
                </div></a><?php */?>
        <?php }
					if(mysqli_num_rows($rslt)==0) echo "No list available";
					?>
      </div>
            </div>
  </div>
          <!-- End container --> 
        </div>

<!-- End Dortor Profile Section --> 

<!-- Start Footer Section -->
<?php include_once("includes/footer.php");?>

<!-- js scripts --> 
<script src="<?php echo $absolutePath;?>assets/js/jquery.min.js"></script> 
<script src="<?php echo $absolutePath;?>assets/js/bootstrap.min.js"></script> 
<script src="<?php echo $absolutePath;?>assets/js/owl.carousel.min.js"></script> 
<script src="<?php echo $absolutePath;?>assets/js/wow.min.js"></script> 
<script src="<?php echo $absolutePath;?>assets/js/jquery.slicknav.min.js"></script> 
<script src="<?php echo $absolutePath;?>assets/js/jquery.scrollTo.min.js"></script> 
<script src="<?php echo $absolutePath;?>assets/js/active.js"></script> 
<script>
		$(".gender").change(function(){
			filter();
		});
		$(".specialized").change(function(){
			filter();
		});
		$(".location").change(function(){
			filter();
		});
                $(".nationality").change(function(){
			filter();
		});
		function filter()
		{
			var gender = [];
			var loc = [];
			var spec = [];
                        var nat = [];
				
				var i=0;
				$('input.gender:checkbox:checked').each(function () {
					i=1;
					gender.push($(this).val());					
				});
				$('input.location:checkbox:checked').each(function () {
					i=1;					
					loc.push($(this).val());
				});
				$('input.specialized:checkbox:checked').each(function () {
					i=1;
					spec.push($(this).val());
				});
                                $('input.nationality:checkbox:checked').each(function () {
					i=1;					
					nat.push($(this).val());
				});
				
					$.ajax({
						 type: "POST",
						 url: "ajx-scripts.php",
						 data: {gender:gender,loc:loc,nat:nat,spec:spec,doctor:i},
						 success: function(data) {
							 //alert(data);
						 $(".doctors_list").html(data);
						},
						error: function(x,a,y){ //add this error function
						alert(JSON.stringify(x)+" "+a);
						}
					});
								
				
		}
		</script>
<style>


/* Style the tab */
div.tab {
    overflow: hidden;
    border: 1px solid #ccc;
    background-color: #f1f1f1;
    font-weight: 700;
}

/* Style the buttons inside the tab */
div.tab button {
    background-color: inherit;
    float: left;
    border: none;
    outline: none;
    cursor: pointer;
    padding: 14px 16px;
    transition: 0.3s;
    font-size: 16px;
	font-family: 'Ubuntu', sans-serif;
}

/* Change background color of buttons on hover */
div.tab button:hover {
    background-color: #ddd;
}

/* Create an active/current tablink class */
div.tab button.active {
    background-color: #2591fd;
    color: #fff;
    font-family: 'Ubuntu', sans-serif;
}

/* Style the tab content */
.tabcontent {
    display: none;
        padding: 17px 30px;
    border: 1px solid #ccc;
    border-top: none;
	    background: #fff;
		
}
.tabcontent h4{
	font-family: 'Montserrat', sans-serif;
    font-weight: 300;
}
.black-tab{
	    height: 60px;
        line-height: 3.5;
	text-align:center;
	background: #064b90;
    color: #fff;
    border-left: 1px solid #eee;
	
}
.black-tab span{
	display: inline-block;
  vertical-align: middle;
  line-height: normal;
	
}
.black-tab h4{
	float:left;
	    font-size: 16px;
	
}
.black-tab i{
	float: left;
    margin-right: 10px;
    margin-left: 10px;
    vertical-align: middle;
}
.pd1 {
    padding-bottom: 20px;
    padding-left: 20px !important;
}
</style>
<script>
function openCity(evt, cityName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";
}

// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();
</script>
<style>
#mycheckbox:checked ~ .moretext {
  display: block;
}

.moretext{
  display: none;
}

#mycheckbox{
  display: none;
}
.showmore{
  cursor: pointer;
}    
</style>
<style>
#mycheckbox1:checked ~ .moretext1 {
  display: block;
}

.moretext1{
  display: none;
}

#mycheckbox1{
  display: none;
}
.showmore1{
  cursor: pointer;
}    
</style> 
<style>
#mycheckbox2:checked ~ .moretext2 {
  display: block;
}

.moretext2{
  display: none;
}

#mycheckbox2{
  display: none;
}
.showmore2{
  cursor: pointer;
}
.col-md-4.pd1 {
    height: 440px;
}    
</style> 
</body>
</html>