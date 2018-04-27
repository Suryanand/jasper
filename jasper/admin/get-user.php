<?php /* get logged in user details*/
$defaultAvatar="default-profile.png";
$permission=array();
if($userType==2 || $userType==3)
{
$rslt=mysqli_query($con,"select * from tbl_users where userEmail='$username'");
if(mysqli_num_rows($rslt)>0)
{
while($row=mysqli_fetch_array($rslt))
{
	$name=$row['userFirstName']." ".$row["userLastName"]; 
	$CurrentUserId=$row['userId'];
	if(!empty($row['userAvatar']))
	{
	$defaultAvatar=$row['userAvatar'];
	}
	$defaultAvatar="user/".$defaultAvatar;
}
}
else
{
	$name="Super Admin";
}
//user permission set to array
$rslt=mysqli_query($con,"select * from tbl_previleges where user='".$username."'");
if(mysqli_num_rows($rslt)>0)
{
	while($row=mysqli_fetch_assoc($rslt))
	{		
		$rslt2=mysqli_query($con,"select * from tbl_modules where id='".$row["module"]."'");
		while($row2=mysqli_fetch_assoc($rslt2))
		{
			$permission[$row2["module"]]=$row["permission"];
		}
	}
}
else
{
	$rslt2=mysqli_query($con,"select * from tbl_modules");
		while($row2=mysqli_fetch_assoc($rslt2))
		{
			$permission[$row2["module"]]=0;
		}
}
}
else
{
	//header('location: index.php');	
	$name="Super Admin";
	$CurrentUserId=1;
	$rslt2=mysqli_query($con,"select * from tbl_modules");
		while($row2=mysqli_fetch_assoc($rslt2))
		{
			$permission[$row2["module"]]=4;
		}
}
?>