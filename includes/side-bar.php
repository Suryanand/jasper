<style>
.sidebar{
	margin-left:0px !important;
}
.sidebar li{
	list-style:none;
	    padding: 5px;
    border-bottom: dotted 1px #dddddd;
}
</style>
<div id="mySidenav" style="z-index:2" class="sidenav">
<ul>
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
       <li style=" list-style-type: none;" class="<?php if($pageName=='about'){ echo "active";}?>"><a href="<?php echo $absolutePath;?>about">About Us</a></li>
	   <li style=" list-style-type: none;" ><a href="#">Ask a Doctor</a><i style=" color: #fff; font-size: 11px; position: absolute; right: 25%;">coming soon</i></li>
       <li style=" list-style-type: none;" ><a href="#">Book an Appointment</a><i style=" color: #fff; font-size: 11px; position: absolute; right: 40%;">coming soon</i></li>
	   <li style=" list-style-type: none;"  class="<?php if($pageName=='insurance'){ echo "active";}?>"><a href="<?php echo $absolutePath;?>insurance">Insurance</a></li>

  <a href="#">Clients</a>
  <a href="#">Contact</a>
  </ul>
</div>