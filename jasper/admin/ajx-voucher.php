<?php
include_once('config.php');
include_once('session.php');

gen_random_string();
function gen_random_string()
{
	$chars ="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";//length:36
    $final_rand='';
    for($i=0;$i<6; $i++)
    {
        $final_rand .= $chars[ rand(0,strlen($chars)-1)];
    }
	$rslt=mysqli_query($con,"select * from tbl_customer_vouchers where voucherCode='".$final_rand."'");
	if(mysqli_num_rows($rslt)>0)
	{
		gen_random_string();
	}
	else
	{
	echo $final_rand;
	}	
}
