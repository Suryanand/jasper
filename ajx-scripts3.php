<?php 
include_once('admin/config.php');
$rslt=mysqli_query($con,"select * from tbl_settings");
$row=mysqli_fetch_assoc($rslt);
$default_doctor_image=$row["default_doctor_image"];
$default_firm_image=$row["default_firm_image"];
if(isset($_POST["doctor"]))
{
	$qry1="";
	$qry2="";
	$qry3="";
	if(isset($_POST["gender"]))
	{
	$gender=$_POST["gender"];	
		$genderlist=implode(',',$gender);
		$qry1=" and find_in_set(gender,'$genderlist')";
	}
	if(isset($_POST["loc"]))
	{
		$loc=$_POST["loc"];
		$loclist=implode(',',$loc);
		$qry2=" and find_in_set(location,'$loclist')";
	}
	if(isset($_POST["nationality"]))
	{
		$nationality=$_POST["nationality"];	
		$nationalitylist=implode(',',$nationality);
		$qry3=" and find_in_set(nationality,'$nationalitylist')";
	}
	$rslt=mysqli_query($con,"select * from tbl_trainers where activeStatus=1 and type=1".$qry1.$qry2.$qry3);
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
                  <a href="<?php echo $absolutePath;?>nutritionist/<?php echo $row["urlName"];?>">
                    <h3><?php echo $row["fullName"];?></h3>
                    <?php 
					$qualification=strip_tags($row["qualification"]);
					?>
                   <!-- <p><?php echo substr($qualification,0,50);?></p>-->
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
        <!--<br clear="all"/>
       <a href="#">  <div class="col-md-4 p-0 black-tab">
                <span><i class="fa fa-phone-square" style="padding-top: 22px;" aria-hidden="true"></i><h4 style="text-align: left;"><span style="font-size:12px;">New Patients</span><br><?php if($contactNo!=''){ echo $contactNo; } else { echo"-";}?></h4></span>
                </div></a>
       <a href="<?php echo $absolutePath;?>nutritionist/<?php echo $row["urlName"];?>"> <div class="col-md-4 p-0 black-tab">
                 <span><h4><i class="fa fa-calendar" style="" aria-hidden="true"></i>Request an Appointment</h4></span>
                </div></a>
       <a href="<?php echo $absolutePath;?>nutritionist/<?php echo $row["urlName"];?>"> <div class="col-md-4 p-0 black-tab">
                 <span><h4> <i class="fa fa-star" style="" aria-hidden="true"></i>Leave a Review</h4></span>
		</div></a><br clear="all"/>-->
		<?php }
		if(mysqli_num_rows($rslt)==0) echo "No list available";
}


if(isset($_POST["hospital"]))
{
	$companyType=$_POST["companyType"];
	$qry1="";
	if(isset($_POST["loc"]))
	{
		$loc=$_POST["loc"];
		$loclist=implode(',',$loc);
		$qry1=" and find_in_set(location,'$loclist')";
	}
	$rslt=mysqli_query($con,"select * from tbl_firm where activeStatus=1 and companyType='$companyType'".$qry1);
					while($row=mysqli_fetch_assoc($rslt))
					{
						$image=$absolutePath."uploads/images/hospitals/".$row["image"];
						if(empty($row["image"]))
							$image=$absolutePath."uploads/images/".$default_firm_image;
						$crop_str='...';
						$n_chars=200;
						$buff=strip_tags($row['profile']);
						 if(strlen($buff) > $n_chars)
						{
							$cut_index=strpos($buff,' ',$n_chars);
							$buff=trim(substr($buff,0,($cut_index===false? $n_chars: $cut_index+1))).$crop_str;
						}
?>
		<div class="doc_class">
					<div class="col-md-3">
                        <img src="<?php echo $image;?>">
                    </div>
					<div class="col-md-9">
                        <a href="<?php echo $absolutePath.$url.$row["urlName"];?>"><h3 style="margin:0px;"><?php echo $row["companyName"];?></h3></a>
						<p style="margin-bottom:0px;"><?php echo $row["area"].", ".$row["location"];?></p>
						<label class="filter-label"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></label>
						<?php echo $buff;?>
                    </div>
					<br clear="all"/>
					<hr>
                    </div>
		<?php }
		if(mysqli_num_rows($rslt)==0) echo "No list available";
}
?>
