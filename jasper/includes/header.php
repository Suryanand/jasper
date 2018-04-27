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
					<div class="col-md-3" style="margin-top: -17px;">
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
                                                                <li><a class="link-1" href="#">Ask a Doctor</a><i style=" color: #fff; font-size: 11px; position: absolute; right: 25%;">coming soon</i></li>
                                                                <li><a class="link-1" href="#">Book an Appointment</a><i style=" color: #fff; font-size: 11px; position: absolute; right: 40%;">coming soon</i></li>
								<li class="<?php if($pageName=='insurance'){ echo "active";}?>"><a class="link-1" href="<?php echo $absolutePath;?>insurance">Insurance</a></li>
                                                                <li class="<?php if($pageName=='about'){ echo "active";}?>"><a class="link-1" href="<?php echo $absolutePath;?>about">About Us</a></li>
<!--								<li><a class="link-1" href="<?php echo $absolutePath;?>articles">Articles</a></li>
								<li><a class="link-1" href="<?php echo $absolutePath;?>news.php">News and Events </a></li>-->
								
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
<li>
<form action="search.php" method="get">   
<div class="search">
<input type="text" name="key" required class="form-control input-sm" maxlength="64" placeholder="Search" />
<button type="submit" class="btn btn-primary btn-sm" style="color: #fff;background-color: #3290f2;border-color: #3290f2;"><i class="fa fa-search" aria-hidden="true"></i></button>
</div>
</form>
</li>                                                                
<!--<li><a class="health-care-btn menu-btn" href="<?php echo $absolutePath;?>login" style="width: 100%;height: 45%;">Login / Sign up</a></li>-->
<!--                                                                <li><a class="health-care-btn menu-btn" href="#">Ask Doctor</a></li>-->
                                

		                
							</ul>
						</div> <!-- End Main Menu -->
					</div>
				</div>
			</div> <!-- End container -->
		</div> <!-- End Header Area -->
                <style>
#search {
    float: right;
    margin-top: 9px;
    width: 250px;
}

.search {
    padding: 5px 0;
    width: 230px;
    height: 30px;
    position: relative;
    left: 10px;
    float: left;
    line-height: 22px;
}

    .search input {
        position: absolute;
        width: 0px;
        float: Left;
        margin-left: 210px;
        -webkit-transition: all 0.7s ease-in-out;
        -moz-transition: all 0.7s ease-in-out;
        -o-transition: all 0.7s ease-in-out;
        transition: all 0.7s ease-in-out;
        height: 30px;
        line-height: 18px;
        padding: 0 2px 0 2px;
        border-radius:1px;
    }

        .search:hover input, .search input:focus {
            width: 200px;
            margin-left: 0px;
        }

.btn {
    height: 30px;
    position: absolute;
    right: 0;
    top: 5px;
    border-radius:1px;
}
.main-menu li a:hover{
color:#8cc63f;
}
                    
                </style>
