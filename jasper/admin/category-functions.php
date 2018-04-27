<?php
function update_order($catId,$order)
{
	global $con;
	mysqli_query($con,"update tbl_category set sortOrder='".$order."' where id='".$catId."'");
}

function update_all_order($post)
{
	global $con;
	$rslt=mysqli_query($con,"select * from tbl_category");
	while($row=mysqli_fetch_array($rslt))
	{
		$id=$row["id"];
		if(!isset($post["order".$id]))
			continue;
		$sortOrder=mysqli_real_escape_string($con,$post["order".$id]);		
		mysqli_query($con,"update tbl_category set sortOrder='".$sortOrder."' where id='".$id."'");
	}
}

function delete_category($deleteId)
{
	global $con;
	$deleteId	= mysqli_real_escape_string($con,$_POST["delete"]);
	/* delete category */
	$rslt=mysqli_query($con,"select * from tbl_category where parentId='$deleteId'");
	if(mysqli_num_rows($rslt)>0)
	{
		$_SESSION['response'] = 'Category Cannot Delete';	
	}
	else
	{
		$rslt = mysqli_query($con,"select banner,menuImage from tbl_category where id='$deleteId'");
		$row  = mysqli_fetch_assoc($rslt);
		if(!empty($row["banner"]))
		{
			unlink("../uploads/".$row["banner"]);
		}
		if(!empty($row["menuImage"]))
		{
			unlink("../uploads/".$row["menuImage"]);
		}
		mysqli_query($con,"delete from tbl_category where id='$deleteId'");
		$_SESSION['response'] = 'Category Deleted';
	}
}

function delete_image($imageType,$image,$category)
{
	global $con;
	mysqli_query($con,"update tbl_category set $imageType='' where id='$category'");
	if(!empty($row["banner"]))
	{
		unlink("../uploads/".$image);
	}
}
?>