<?php
include_once('config.php');
if(isset($_POST["productId"]) && isset($_POST["optionValues"]) && isset($_POST["productOptions"])){
	$optionValues=trim($_POST["optionValues"],',');
	$optionValue=$_POST["optionValue"];
	$productOptions=trim($_POST["productOptions"],','); //option ids
	$productId=$_POST["productId"];
	$price=0;
	$error=0;
	$rslt=mysqli_query($con,"SELECT * FROM tbl_option_values WHERE id='".$optionValue."'");
	$rows=mysqli_fetch_array($rslt);
	$option=$rows["fkOptionId"];
	$count=sizeOf(explode(',',$productOptions)); // total select options
	$select="";
	$key = array_search($option, explode(',',$productOptions)); // nth option selected
	$opArray=array();
	$optionValuesArray=explode(',',$productOptions);

	if(($key+1)<$count)		
	{
		$i=$key+1;
		$select='<option value="">Choose</option>';
		//get all option values for this product with selected option value
		$qry1="";
		foreach(explode(',',$optionValues) as $opVal)
		{
			$qry1.=" and FIND_IN_SET('".$opVal."',t1.fkOptionValue)";
		}
		$rslt=mysqli_query($con,"SELECT t1.id,t1.* FROM tbl_product_options_value t1 WHERE t1.fkProductId='".$productId."'".$qry1);
		//$qry1="SELECT t1.id,t1.* FROM tbl_product_options_value t1 WHERE t1.fkProductId='".$productId."'".$qry1;
		$opValPrev="";
		$prev="";
		//$qry1="";
		$optionArray=array();
		while($row=mysqli_fetch_assoc($rslt))
		{
			$opValue=array_unique(explode(',',$row["fkOptionValue"]));			
				$opValPrev=$opValue[$i];
				$rslt2=mysqli_query($con,"select distinct id,optionValue from tbl_option_values where fkOptionId='".$optionValuesArray[$i]."' and FIND_IN_SET(id,'".$row["fkOptionValue"]."')");
				//$qry1.="select distinct id,optionValue from tbl_option_values where fkOptionId='".$optionValuesArray[$i]."' and FIND_IN_SET(id,'".$row["fkOptionValue"]."')";
				while($row2=mysqli_fetch_assoc($rslt2))
				{
					$prev=$row2["id"];
					if(!in_array($prev,$optionArray))
					{
						
					$select.='<option value="'.$row2["id"].'">'.$row2["optionValue"].'</option>';
					}
					array_push($optionArray,$row2["id"]);
				}
				//$qry1.=$prev;
		}
		array_push($opArray,$select);
	}
	
	
	/*foreach(explode(',',$optionValues) as $option)
	{*/
	if($key+1==$count)
	{
		$qry="";
		foreach(explode(',',$optionValues) as $opVal)
		{
			$qry.=" and FIND_IN_SET('".$opVal."',fkOptionValue)";
		}
		$rslt=mysqli_query($con,"SELECT * FROM tbl_product_options_value WHERE fkProductId='".$productId."'".$qry);
		if(mysqli_num_rows($rslt)>0)
		{
			$error=0;
		$rows=mysqli_fetch_array($rslt);
		$price+=$rows["price"];$qry1=$price;
		}
	}
	/*}*/
	$rslt=mysqli_query($con,"SELECT * FROM tbl_products WHERE productId='".$productId."'");
	$rows=mysqli_fetch_array($rslt);
	{
			$oldPrice=$rows["listPrice"]+$price;			
			$discount=$rows["discount"];			
			$discountType=$rows["discountType"];
			if($discount != 0)
			{
				if($discountType=="percentage")
				{
					$price=$oldPrice-($oldPrice*($discount/100));
				}
				else
				{
					$price=$oldPrice-$discount;
					$discount=round(($discount*100)/$oldPrice);
				}
			}
			else
			{
				$price=$oldPrice;
			}
			$price=$price;
			$oldPrice=$currency." ".$oldPrice;
	}
	
	$arr = array('price' => $price,'oldPrice'=>$oldPrice,'error'=>$error, 'dropdown'=>$opArray, 'id'=>$key+2,'qr'=>$qry1);
	echo json_encode($arr);	
}

if(isset($_POST["pId"]))
{	
	$price=0;
	$options='';
	$rslt=mysqli_query($con,"SELECT t1.fkOptionId,t2.optionName FROM tbl_product_options t1,tbl_options t2 WHERE t1.fkProductId='".$_POST["pId"]."' AND t1.fkOptionId=t2.id order by t2.sortOrder asc");
	if(mysqli_num_rows($rslt)>0)
	{
		$rslt2=mysqli_query($con,"SELECT GROUP_CONCAT(fkOptionValue) as optionValues FROM tbl_product_options_value WHERE fkProductId='".$_POST["pId"]."'");
		$row2=mysqli_fetch_assoc($rslt2);
		$optionValues=explode(',',$row2["optionValues"]);
		$optionValues=implode("','",$optionValues);
	
        $options.='<label class="control-label">Options: <span class="text-error">*</span></label>';
     
		$i=0;
		$j=mysqli_num_rows($rslt);
		while($row=mysqli_fetch_assoc($rslt))
		{										
			$i++;
			$rslt1=mysqli_query($con,"select t1.* from tbl_option_values t1 where t1.fkOptionId='".$row["fkOptionId"]."' and t1.id IN('$optionValues')");
			$num=mysqli_num_rows($rslt1);
			if($num>0)
			{

		$options.='<div class="controls">
			<div class="attribute-label">'.$row["optionName"].':</div>
				<div class="attribute-list">
					<select id="options'.$i.'" class="input-large" name="options[]" required onChange="changeOption(this.value)">
						<option value="">Choose</option>';
						while($row1=mysqli_fetch_assoc($rslt1))
						{						
						$options.='<option value="'.$row1["id"].'">'.$row1["optionValue"].'</option>';
						}
					$options.='</select>
					<input type="hidden" name="productOptions[]" value="'.$row["fkOptionId"].'"/>
                </div>
            </div>';
}}
		$arr = array('options' => $options,'option'=> '1');
	echo json_encode($arr);	
}
else{
	$rslt=mysqli_query($con,"select * from tbl_products where productId='".$_POST["pId"]."'");
	$rows=mysqli_fetch_array($rslt);
	{
			$oldPrice=$rows["listPrice"]+$price;			
			$discount=$rows["discount"];			
			$discountType=$rows["discountType"];
			if($discount != 0)
			{
				if($discountType=="percentage")
				{
					$price=$oldPrice-($oldPrice*($discount/100));
				}
				else
				{
					$price=$oldPrice-$discount;
					$discount=round(($discount*100)/$oldPrice);
				}
			}
			else
			{
				$price=$oldPrice;
			}
			$price=$price;
			$oldPrice=$currency." ".$oldPrice;
	}
		$arr = array('price' => $price,'option'=> '0');
	echo json_encode($arr);	

}
}		
?>
