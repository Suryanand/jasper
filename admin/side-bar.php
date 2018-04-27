
<div id="sidebar">
  <div class="sidebar-tabs">
    <ul class="tabs-nav two-items">
      <li><a href="#general" title=""><i class="icon-reorder"></i></a></li>
      <li><a href="#stuff" title=""><i class="icon-cogs"></i></a></li>
    </ul>
    <div id="general"> 
      <!-- Sidebar user -->
      <div class="sidebar-user widget" style="text-align: center;">
        <div class="navbar">
          <div class="navbar-inner">
            <h6 style="text-align:center;float:none;">
              <?php if($userType==3) echo $company; else echo $name;?>
            </h6>
          </div>
        </div>
        <a href="index.php"><img src="img/<?php echo $adminLogo;?>" style="width:45%;" alt="" /></a> </div>
      <!-- /sidebar user -->
      <?php if($userType!=3)
					{		/* These menu only for admin*/
					?>
      <ul class="navigation widget" style="margin-top:0px;">
          <li><a href="#" title="" class="expand"><i class="icon-home"></i>Home</a>
              <ul>
              <li><a href="edit-banner.php?id=1" title="" class="">Home Banner</a></li>
              <li><a href="edit-page.php?id=3" title="" class="">Home Text</a></li>
              </ul>
          </li>
	  
	  <li><a href="manage-news.php" title="" class=""><i class="icon-book"></i>News</a></li>
			<li><a href="#" title="" class="expand"><i class="icon-cogs"></i>Manage Firms</a>
			    <ul>
				<?php $rslt=mysqli_query($con,"select * from tbl_category where activeStatus=1");
					while($row=mysqli_fetch_assoc($rslt))
					{?>
					  <li><a href="manage-firm.php?id=<?php echo $row["id"];?>" title="" class=""><?php echo $row["categoryName"];?></a></li>
					<?php }?>
					<li><a href="manage-category.php" title="">Category Master</a></li>
					<li><a href="import.php" title="">Import From CSV</a></li>
			    </ul>
			</li>
			<li><a href="#" title="" class="expand"><i class="icon-globe"></i>Blog</a>
			    <ul>
					<li><a href="manage-blog.php" title="">Manage Articles</a></li>
					<li><a href="manage-article-category.php" title="">Article Category Master</a></li>
			    </ul>
			</li>
			<li><a href="#" title="" class="expand"><i class="icon-list"></i>Pages</a>
			    <ul>
					<li><a href="edit-page.php?id=1" title="">About</a></li>
			    </ul>
			</li>
			<li><a href="#" title="" class="expand"><i class="icon-list"></i>Insurance</a>
			    <ul>
					<li><a href="manage-insurance.php" title="">Insurance List</a></li>
					<li><a href="edit-page.php?id=2" title="">Insurance Page Text</a></li>
			    </ul>
			</li>
			<li><a href="manage-users.php" title=""><i class="icon-user"></i>Users</a></li>
			<li><a href="manage-trainer.php?id=3" title=""><i class="icon-user"></i>Doctors</a></li>
			<li><a href="#"  class="expand" title=""><i class="icon-user"></i>Appointments</a>
                        <ul>
                        <li><a href="appointments.php" title="">Doctors</a></li>   
                        <li><a href="trainer-appointments.php" title="">Fitness Trainers</a></li>
                        <li><a href="nutritionist-appointments.php" title="">Nutritionists</a></li>
                        </ul>
                        </li>
                        <li><a href="#"  class="expand" title=""><i class="icon-reorder"></i>Comments</a>
                        <ul>
                        <li><a href="doctor-comment.php" title="">Doctors</a></li>   
                        <li><a href="trainer-comment.php" title="">Fitness Trainers</a></li>
                        <li><a href="nutritionist-comment.php" title="">Nutritionists</a></li>
                        </ul>
                        </li>
			<li><a href="manage-testimonials.php" title=""><i class="icon-user"></i>Testimonials</a></li>
			<li><a href="manage-header.php" title=""><i class="icon-list"></i>Header & Footer</a></li>
                        <li><a href="manage-subscribers.php" title=""><i class="icon-user"></i>Subscribers</a></li>
                          <li><a href="#" title="" class="expand"><i class="icon-list"></i>Health & Fitness</a>
			    <ul>
			    <li><a href="manage-trainer.php?id=0" title="">Fitness Trainers</a></li>
                            <li><a href="manage-trainer.php?id=1" title="">Nutritionists</a></li>
                            <li><a href="manage-trainer.php?id=2" title="">Club Manager</a></li>
                            <li><a href="manage-gymnasium.php" title="">Gymnasiums</a></li>
			    </ul>
			</li>
      </ul>
      <?php }?>
    </div>
    
    <!--Settings Tab-->
    <div id="stuff"> 
      <!-- Sidebar user -->
      <div class="sidebar-user widget" style="text-align: center;">
        <div class="navbar">
          <div class="navbar-inner">
            <h6 style="text-align:center;float:none;">
              <?php if($userType==3) echo $company; else echo $name;?>
            </h6>
          </div>
        </div>
      </div>
        <a href="index.php"><img src="img/<?php echo $adminLogo;?>" style="width:45%;margin-left: 68px;" alt="" /></a> 
      <!-- /sidebar user -->
      <?php if($userType!=3)
{		/* These menu only for admin*/
?>
      <ul class="navigation widget" style="margin-top:0px;">
                <li><a href="#" class="expand" title=""><i class="icon-cogs"></i>Specialist</a>
         <ul>
			    <li><a href="manage-specialist.php?type=1#stuff" title="">Medical Specialist</a></li>
                            <li><a href="manage-specialist.php?type=2#stuff" title="">Fitness Specialist</a></li>
			    </ul>
         </li>
        <li><a href="" title="" class="expand"><i class="icon-cogs"></i>Settings</a>
          <ul>
            <li><a href="general-settings.php#stuff" title="">General Settings</a></li>
            <li><a href="mail-settings.php#stuff" title="">Mail Settings</a></li>
            <!--<li><a href="gateway-settings.php#stuff" title="">Gateway Settings</a></li>-->
          </ul>
        </li>
         <li><a href="manage-services.php#stuff" title=""><i class="icon-cogs"></i>Services</a></li>
         <li><a href="#" class="expand" title=""><i class="icon-cogs"></i>Specialties</a>
         <ul>
			    <li><a href="manage-specialty.php#stuff" title="">Medical Specialty</a></li>
                            <li><a href="manage-fitness-specialty.php#stuff" title="">Fitness Specialty</a></li>
			    </ul>
         </li>
    <li><a href="manage-network.php#stuff" title=""><i class="icon-cogs"></i>Networks</a></li>
    <li><a href="manage-location.php#stuff" title=""><i class="icon-cogs"></i>Locations</a></li>
         <li><a href="manage-language.php#stuff" title=""><i class="icon-cogs"></i>Languages</a></li>
        <li><a href="social-links.php#stuff" title=""><i class="icon-briefcase"></i>Social Media Links</a></li>
        <!-- <li><a href="" title="" class="expand"><i class="icon-cogs"></i>Subscription</a>
          <ul>
            <li><a href="manage-subscriber.php#stuff" title="">Manage Subscriber</a></li>
            <li><a href="mail-templates.php#stuff" title="">Mail Templates</a></li>
          </ul>
        </li>-->
      </ul>
      <?php } 
?>
    </div>
  </div>
</div>
<!-- /sidebar --> 
