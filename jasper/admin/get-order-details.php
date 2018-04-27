<?php 
$rslt=mysqli_query($con,"select * from tbl_orders where orderNo='".$orderId."'");
$row=mysqli_fetch_assoc($rslt);
$orderTotal=$row["orderAmount"];
$orderAddress=$row["billingAddress"];
$orderPaymentMethod=$row["paymentMethod"];

						$productDetails='<table>
							<thead>
								<tr>
									<th style="margin:0px 20px">Product Details</th>
									<th style="margin:0px 20px">Quantity</th>
									<th style="margin:0px 20px">Unit Price</th>
									<th style="margin:0px 20px">Total</th>
								</tr>
                            </thead>
                            <tbody>';							
								$rslt2=mysqli_query($con,"SELECT * FROM tbl_products,tbl_order_items where deleteStatus='0' and tbl_order_items.productId=tbl_products.productId and tbl_order_items.fkOrderNumber='".$orderId."'") or die(mysqli_error($con));
								while($row2=mysqli_fetch_array($rslt2))
								{	
									$productName	= $row2["productName"];
									$oldPrice		= $row2["listPrice"];
									$discount		= $row2["discount"];
									$discountType	= $row2["discountType"];
							  
									$productDetails.='<tr style="border-bottom:solid thin #ddd;">
									<td class="">'.$productName.'</td>
									<td class="">'.$row2["quantity"].'</td>
									<td class="">'.$row2["unitPrice"].'</td>
									<td class="">'.$orderTotal.'</td>
								</tr>';
								 }
                            $productDetails.='</tbody>
                        </table>';
						?>