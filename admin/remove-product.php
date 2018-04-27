<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
if($userType!=1) /* This page only for admin - if normal user redirect to index page */
{
	header('location: index.php');
}
else
{
$deleteId=$_GET["id"];
/* delete category */
	mysqli_query($con,"update tbl_products set deleteStatus=1 where productId='$deleteId'");
	$_SESSION['response'] = 'Product Deleted';
echo "<script>location.href = 'manage-product.php'</script>;";												
}
?>