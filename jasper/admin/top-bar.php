<div id="top">

		<div class="fixed">

			<a href="index.php" title="" class="logo"><img src="img/logo.png" alt="" /></a>

			<ul class="top-menu">

				<li><a class="fullview" title="Full Screen"></a></li>

				<li><a class="showmenu" target="_blank" href="<?php echo $absolutePath;?>" title="Store Front"></a></li>

				<li><a href="<?php if($userType==1){ echo "user-log.php";} else {echo "#";} ?>" title="" class="messages"><i class="new-message"></i></a></li>

				<li class="dropdown">

					<a class="user-menu" data-toggle="dropdown"><img src="img/userpic.png" alt="" /><span><?php echo $name;?> <b class="caret"></b></span></a>

					<ul class="dropdown-menu">

						<?php

						if($userType==1) /* These menu only for admin*/

						{

						?>

                        <li><a href="new-user.php" title=""><i class="icon-user"></i>Add User</a></li>

						<li><a href="manage-user.php" title=""><i class="icon-cog"></i>Manage User</a></li>
                        <li><a href="company-profile.php" title=""><i class="icon-briefcase"></i>Company Profile</a></li>
                        <?php } ?>

						<li><a href="logout.php" title=""><i class="icon-remove"></i>Logout</a></li>

					</ul>

				</li>

			</ul>

		</div>

	</div>