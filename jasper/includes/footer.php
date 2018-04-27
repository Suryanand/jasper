<footer class="site-footer">
			<div class="footer-top">
				<div class="container"> <!-- Start Container -->
					<div class="row">
                    <div class="col-xs-12 col-md-5 col-sm-12 mb-20">
                    <div class="footer-wid wow fadeIn"> <!-- Start Services Menu Widgets -->
                    <h3>About Us</h3> 
                    <?php echo $footerText;?>
                    <a href="<?php echo $absolutePath;?>login" class="health-care-btn view-all-btn wht">Register Now
								</a>
                    </div>
                    </div> <!-- End Services Menu Widgets -->	
						<div class="col-xs-12 col-md-2 col-sm-4">
							<div class="footer-wid wow fadeIn"> <!-- Start Services Menu Widgets -->	
								<h3>Company</h3> 							
								<ul>
								<?php 
							$rslt=mysqli_query($con,"select * from tbl_category where activeStatus=1 limit 6");
							while($row=mysqli_fetch_assoc($rslt))
							{
							?>
									<li><a href="<?php echo $absolutePath;?>category/<?php echo $row["urlName"];?>"><i class="fa fa-angle-right" aria-hidden="true"></i>
									<?php echo $row["categoryName"];?> </a></li>
							<?php }?>
									
								</ul>
							</div> <!-- End Services Menu Widgets -->								
						</div>
						<div class="col-xs-12 col-md-2 col-sm-4">
							<div class="footer-wid wow fadeIn"> <!-- Resources Widgets -->
								<h3 >Press</h3>									
								<ul>
									<li><a href="<?php echo $absolutePath;?>news"><i class="fa fa-angle-right" aria-hidden="true"></i>
									Latest News</a></li>
									<li><a href="<?php echo $absolutePath;?>articles"><i class="fa fa-angle-right" aria-hidden="true"></i>
									Articles </a></li>
									<li><a href="<?php echo $absolutePath;?>news"><i class="fa fa-angle-right" aria-hidden="true"></i>
									Events  </a></li>
									<li><a href="<?php echo $absolutePath;?>appointment"><i class="fa fa-angle-right" aria-hidden="true"></i>
									Contact Us</a></li>
									
								</ul>
							</div> <!-- End Resources Widgets -->								
						</div>
						<div class="col-xs-12 col-md-3 col-sm-4">
                        <div class="footer-wid wow fadeIn"> <!-- Resources Widgets -->
								<h3 >For patients</h3>									
								<ul>
									<li><a href="#"><i class="fa fa-angle-right" aria-hidden="true"></i>
									Ask free health questions</a></li>
									<li><a href="#"><i class="fa fa-angle-right" aria-hidden="true"></i>
									Search for doctors</a></li>
									<li><a href="#"><i class="fa fa-angle-right" aria-hidden="true"></i>
									Search for clinics</a></li>
									<li><a href="#"><i class="fa fa-angle-right" aria-hidden="true"></i>
									Search for hospitals</a></li>
									<li><a href="#"><i class="fa fa-angle-right" aria-hidden="true"></i>
									Search for diagnostics</a></li>
                                    <li><a href="#"><i class="fa fa-angle-right" aria-hidden="true"></i>
									Read health articles</a></li>
								</ul>
							</div> <!-- End Resources Widgets -->		
														
						</div>
					</div>					
				</div> <!-- End Container -->
			</div>			
			
			<!-- Start Footer Soket Text -->
			<div class="copyrgiht-text t-center">
				<div class="container"> <!-- Start Container -->
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 ">
                        <div class="social-icon">
                        <p style="color:white">Follow Us</p>
<?php
$rslt5=mysqli_query($con,"select * from tbl_social_media");
$row5=mysqli_fetch_assoc($rslt5);
?>                        
<?php if($row5['fb']!=''){?><a href="<?php echo $row5['fb'];?>" target="_blank"> <i class="fa fa-facebook-square fa-2x wht" aria-hidden="true"></i></a><?php } ?>
<?php if($row5['tw']!=''){?><a href="<?php echo $row5['tw'];?>" target="_blank"> <i class="fa fa-twitter-square fa-2x wht" aria-hidden="true"></i></a><?php } ?>
<?php if($row5['yt']!=''){?><a href="<?php echo $row5['yt'];?>" target="_blank"> <i class="fa fa-youtube-square fa-2x wht" aria-hidden="true"></i></a><?php } ?>
<?php if($row5['li']!=''){?><a href="<?php echo $row5['li'];?>" target="_blank"> <i class="fa fa-linkedin-square fa-2x wht" aria-hidden="true"></i></a><?php } ?>
<?php if($row5['gp']!=''){?><a href="<?php echo $row5['gp'];?>" target="_blank"> <i class="fa fa-google-plus-square fa-2x wht" aria-hidden="true"></i></a><?php } ?>
<?php if($row5['pi']!=''){?><a href="<?php echo $row5['pi'];?>" target="_blank"> <i class="fa fa-pinterest-square fa-2x wht" aria-hidden="true"></i></a><?php } ?>
<?php if($row5['ig']!=''){?><a href="<?php echo $row5['ig'];?>" target="_blank"> <i class="fa fa-instagram fa-2x wht" aria-hidden="true"></i></a><?php } ?>
<?php if($row5['rss']!=''){?><a href="<?php echo $row5['rss'];?>" target="_blank"> <i class="fa fa-rss-square fa-2x wht" aria-hidden="true"></i></a><?php } ?>
                        
                        </div>
							<div class="footer-text">
								<p>ⓒ Copyright 2017. All Rights Reserved by : <a href="<?php echo $absolutePath;?>">Alodawaa</a></p>
							 </div>
						</div>
						<!-- End Footer Menu -->
					</div>	
				</div> <!-- End Container -->
			</div> <!-- End Footer Soket Text -->
		</footer><!-- End Footer Section -->
              
        <!-- Scroll To Up -->
        <div class="scroll-to-up hidden-xs">
            <div class="scrollup">
                <i class="fa fa-caret-up"></i>
            </div>
        </div>