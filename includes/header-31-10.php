<?php 
$rslt=mysqli_query($con,"select * from tbl_company_profile") or die(mysqli_error($con));
$row=mysqli_fetch_array($rslt);
$logo=$row['logo'];
$logoAlt=$row['logoAlt'];
$favicon=$row['favicon'];
$faviconAlt=$row["faviconAlt"];
$footerText=$row["footerText"];
?>
<div class="header-area navbar-fixed-top sticky">
			<div class="container"> <!-- Start container -->
				<div class="row">
					<div class="col-md-3">
						<div class="logo"> <!-- Site logo -->
							<a href="<?php echo $absolutePath;?>">								
								<img src="<?php echo $absolutePath;?>images/<?php echo $logo;?>" alt="<?php echo $logoAlt;?>">
							</a>
						</div>
						<div class="responsive-menu-wrap">						
						</div>
					</div>
					<div class="col-md-9">
						<div class="main-menu" id="data-scroll"> <!-- Start Main Menu -->
							<ul class="nav" id="navigation" >
                                                                <li><a href="#">Ask a Doctor</a></li>
                                                                <li><a href="#">Book an Appointment</a></li>
								<li><a href="<?php echo $absolutePath;?>insurance.php">Insurance</a></li>
                                                                <li><a href="<?php echo $absolutePath;?>about.php">About Us</a></li>
<!--								<li><a href="<?php echo $absolutePath;?>articles">Articles</a></li>
								<li><a href="<?php echo $absolutePath;?>news.php">News and Events </a></li>-->
								
								<!--<li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Pages <b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="doctor-profile.php">Doctor Profile Page</a></li>                                       
                                        <li><a href="blog-list.php">Blog List Page</a></li>                                       
                                        <li><a href="single-page.php">Blog Single Page</a></li>                                       
                                        <li><a href="404.php">404 Error Page</a></li>                                       
                                        <li><a href="coming-soon.php">Coming Soon Page</a></li>                                       
                                    </ul>
                                </li>-->
<li><a class="health-care-btn menu-btn" href="<?php echo $absolutePath;?>login.php" style="width: 100%;height: 45%;">Login / Sign up</a></li>
<!--                                                                <li><a class="health-care-btn menu-btn" href="#">Ask Doctor</a></li>-->
                                

		                
							</ul>
						</div> <!-- End Main Menu -->
					</div>
				</div>
			</div> <!-- End container -->
		</div> <!-- End Header Area -->
