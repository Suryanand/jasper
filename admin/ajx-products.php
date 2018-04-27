<?php
include_once('config.php');
include_once('session.php');

// select specification for category
if(isset($_POST["catId"])){
	$category=$_POST["catId"];
	$i=0;
	$spec='';
	$similarProducts='';
	
	$spec.='<form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">';
	$rslt=mysqli_query($con,"select * from tbl_specifications where fkCategoryId='".$category."' order by id asc");
	while($row=mysqli_fetch_assoc($rslt))
	{
		$i++;	
		$spec.= '<div class="control-group">
					<label class="control-label">'.$row["specification"].':</label>
					<div class="controls">
						<input type="text" value="" class="validate[] input-large" name="spec'.$i.'" />
						<input type="hidden" value="'.$row["id"].'" class="validate[] input-large" name="specId'.$i.'" />															
					</div>
				</div>';
	}
		$spec.='<input type="hidden" value="'.$i.'" class="validate[] input-large" name="iValue" />                                
				</form>';
	$similarProducts .='<label class="control-label">Similar Products: <span class="text-error">*</span></label>
	                    <div class="controls">';
	$rslt=mysqli_query($con,"SELECT productName,productId FROM tbl_products where fkCategoryid='".$category."'");									
	while($row=mysqli_fetch_assoc($rslt))
	{
    $similarProducts .='<label class="radio inline">
							<input class="validate[] styled" type="checkbox" name="similarProducts[]" value="'.$row["productId"].'" data-prompt-position="topLeft:-1,-5"/>
							'.$row["productName"].'
                        </label>';
	}								
	$similarProducts .='</div>';
	
	$arr = array('spec' => $spec , 'similarProducts' =>$similarProducts);
	echo json_encode($arr);
}

if(isset($_POST["category"])){
	$category=$_POST["category"];
	$subcategory='';
	$subcategory.='<option value="" selected>Select Sub Category</option>';
	$rslt=mysqli_query($con,"SELECT * FROM tbl_category t1 WHERE t1.activeStatus=1 and parentId='".$category."'");
	while($row=mysqli_fetch_array($rslt))
	{                                         
	$subcategory.='<option value="'.$row["categoryId"].'">'.$row["categoryName"].'</option>';
	}
	$arr = array('category' => $subcategory);
	echo json_encode($arr);	
}

// options
if(isset($_POST["optionId"])){
	$print='<table class="table">
												<thead>
													<tr>
														<th>Option Value</th>
														<th>Quantity</th>
														<th>Price</th>
														<th>Remove</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td colspan="3"></td>
														<td>
															<button type="button" onClick="addField()" class="btn btn-info"  style="margin-top:4px;"><i class="icon-plus"></i></button>
														</td>
													</tr>';
													
													$print.='<tr class="hide optionRow" id="addOption">
														<td>
															<select style="width:150px;" name="optionValue[]" onChange="catSpec(this.value)" class="validate[] options" data-prompt-position="topLeft:-1,-5">
																  ';
																
																	$rslt=mysqli_query($con,"select * from tbl_option_values where fkOptionId='".$_POST["optionId"]."'");
																	while($row=mysqli_fetch_array($rslt))
																	{
																
																$print.='<option value="'.$row["id"].'">'.$row["optionValue"].'</option>';
																	}
															$print.='</select>
														</td>
														<td>
															<input type="text" value="0"  class="validate[custom[number]] input-small" name="quantity[]"/>
														</td>
														<td>
														<select style="width:40px;font-weight: bold;" name="priceOp[]">
															<option value="+">+</option>
															<option value="-">-</option>
														</select>
														<input type="text" value="0"  class="validate[custom[number]] input-small" name="price[]"/></td>														
														<td>
															<button type="button" onClick="removeField(this)" class="btn btn-danger"  style="margin-top:4px;"><i class="icon-minus"></i></button>
														</td>
													</tr>
												</tbody>
												</table>';
												echo $print;
}
?>
