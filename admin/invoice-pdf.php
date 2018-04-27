<?php
session_start();
require('fpdf/fpdf.php');
include_once("config.php");

$orderNo=$_GET["id"];
$customer=$_SESSION['username'];

$rslt=mysqli_query($con,"SELECT * FROM tbl_orders WHERE orderNo='".$orderNo."'");
if(mysqli_num_rows($rslt)>0)
{
$row=mysqli_fetch_assoc($rslt);
$orderPlaced=date('d M Y',strtotime($row["orderDate"]));
$orderAmount=$row["orderAmount"];
$orderDiscount=$row["orderDiscount"];
$paymentStatus=$row["paymentStatus"];
$shippingCharge=$row["shippingCharge"];
$transactionId="";
$shipTo=explode('<br />',$row["billingAddress"]);
$fullName=$shipTo[0];
unset($shipTo[0]);
//var_dump(array_filter(array_map('trim', $shipTo)));
$shipTo=implode(', ',array_filter(array_map('trim', $shipTo)));

}
else{
	echo "<script>location.href = '".$absolutePath."my-orders'</script>";
}
$rslt=mysqli_query($con,"SELECT * FROM tbl_transaction WHERE fkOrderId='".$orderNo."'");
if(mysqli_num_rows($rslt)>0)
{
	$row=mysqli_fetch_assoc($rslt);
	$transactionId=$row["transactionId"];
}


//get company profile
$rslt=mysqli_query($con,"select * from tbl_company");
$row=mysqli_fetch_array($rslt);
$companyName =	$row["companyName"];
$companyAddress	=	$row["companyAddress"];
$companyAvatar=$row["companyAvatar"];
$activeAvatar=$row["activeAvatar"];
$companyArray=explode("\n", $companyAddress);

$paid="PAID";
if($paymentStatus==0)
{
	$paid="UNPAID";
}


$invoiceDetails	=	"Invoice Number\n# ".$orderNo."\nInvoice Date\n".$orderPlaced;

$fccAmount			= 0;
$rslt=mysqli_query($con,"select * from tbl_transaction where fkOrderId='$orderNo' and gateway='Families Club Card'");
if(mysqli_num_rows($rslt)>0 && $paymentStatus!=1)
{
	$row=mysqli_fetch_assoc($rslt);
	$fccAmount=$row["transactionAmount"];
}


class PDF extends FPDF
{
	
// Page header
function Header()
{
	global $paymentStatus;
	global $paid;
	global $absolutePath;

    // Logo
		$this->Image($absolutePath.'images/invoice-header.jpg',10,10,190);
    // Arial bold 15
    $this->SetFont('Arial','B',15);
    // Move to the right
    //$this->Cell(80);
    // Title
	$this->Ln(40);
    $this->Cell(190,10,'INVOICE',0,0,'C');
    $this->Ln(10);  
    // Line break
    $this->Ln(10);
	// Applicant Image
}

// Page footer
function Footer()
{
	global $paymentStatus;
	global $currency;
	global $orderNo;
	    // Position at 1.5 cm from bottom
    // Arial italic 8
    // Page number
$this->SetY(265);
	
if($paymentStatus==1)
	$rslt=mysqli_query($con,"select * from tbl_transaction where fkOrderId='$orderNo'");
else
	$rslt=mysqli_query($con,"select * from tbl_transaction where fkOrderId='".$orderNo."' and gateway='Families Club Card'");
if(mysqli_num_rows($rslt)>0)
{
    $this->SetY(-70);
	$this->SetFont('Arial','B',9);
	$this->Ln(25);
	$this->Cell(10,10,'#',0,0,'L',1);
	$this->Cell(55,10,'Transaction Id',0,0,'L',1);
	$this->Cell(55,10,'Transaction Date','',0,'L',1);
	$this->Cell(25,10,'Gateway',0,0,'L',1);
	$this->Cell(45,10,'Amount ('.$currency.')',0,0,'R',1);	

	$this->Ln(0);
	$this->Cell(190,10,'','B',0,'R');
	$this->SetFont('Arial','',9);
	while($row=mysqli_fetch_array($rslt))
	{
	$this->Ln(10);
	$this->Cell(10,10,'1',0,0,'L');
	$this->Cell(55,10,$row["transactionId"],0,0,'L');
	$this->Cell(55,10,$row["transactionDate"],'',0,'L');
	$this->Cell(25,10,$row["gateway"],0,0,'L');
	$this->Cell(45,10,$row["transactionAmount"],0,0,'R');
	}	

}
//$this->setY(-50);
$this->Ln(15);
	$this->SetFont('Arial','',9);

	$this->Cell(95,10,'Our Bank:  xxxx. A/C No. xxxxxx',0,0,'L');
	$this->Cell(95,10,'IBAN: xxxxxxxxxxxxxx',0,0,'R');
	$this->Ln(4);
	$this->Cell(95,10,'Arabian Gulf Road Office Branch, Abu Dhabi, UAE.',0,0,'L');
	$this->Cell(95,10,'Swift: xxxxxxxxx',0,0,'R');
}
}

// Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
//$pdf->SetAuthor('Nawaz Labour Supply');
//$pdf->SetTitle('Application For Employment');
$pdf->SetLineWidth(0);

$x = $pdf->GetX();
$y = $pdf->GetY();
	$pdf->SetFont('Arial','B',9);
	$pdf->SetXY($x, $y);
	$pdf->MultiCell(45,5,"Order Placed:",0,'L',0);
	$pdf->SetFont('Arial','',9);
	$pdf->SetXY($x + 25, $y);	
	$pdf->MultiCell(75,5,$orderPlaced,0,'L',0);
$y=$y+5;
	
	$pdf->SetFont('Arial','B',9);
	$pdf->SetXY($x, $y);
	$pdf->MultiCell(45,5,"Order #:",0,'L',0);
	$pdf->SetFont('Arial','',9);
	$pdf->SetXY($x + 25, $y);	
	$pdf->MultiCell(75,5,$orderNo,0,'L',0);
$y=$y+5;

	$pdf->SetFont('Arial','B',9);
	$pdf->SetXY($x, $y);
	$pdf->MultiCell(45,5,"Order Total:",0,'L',0);
	$pdf->SetFont('Arial','',9);
	$pdf->SetXY($x + 25, $y);	
	$pdf->MultiCell(75,5,$orderAmount+$shippingCharge-$orderDiscount,0,'L',0);
$y=$y+5;

	$pdf->SetFont('Arial','B',9);
	$pdf->SetXY($x, $y);
	$pdf->MultiCell(45,5,"Order Status:",0,'L',0);
	$pdf->SetFont('Arial','',9);
	$pdf->SetXY($x + 25, $y);
	if($paymentStatus==1)
	{
    $pdf->SetTextColor(0,102,0);
	}
	else
	{
    $pdf->SetTextColor(255,0,0);		
	}
	$pdf->MultiCell(75,5,$paid,0,'L',0);
    $pdf->SetTextColor(0,0,0);		



	
$x = $pdf->GetX();
$y = $pdf->GetY();

// Invoice Items Starts here
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(190,10,'INVOICE ITEMS',0,0,'L');

	$pdf->Ln(10);
    $pdf->SetFillColor(230,230,250);	
	$pdf->Cell(10,10,'#',0,0,'L',1);
	$pdf->Cell(70,10,'Items Ordered',0,0,'L',1);
	$pdf->Cell(30,10,'Quantity',0,0,'L',1);
	$pdf->Cell(40,10,'Unit Price ('.$currency.')',0,0,'L',1);
	$pdf->Cell(40,10,'Total ('.$currency.')',0,0,'R',1);
	$pdf->Ln(0);
	$pdf->Cell(190,10,'','B',0,'R');
$i=0;
	$pdf->SetFont('Arial','',9);
	
	$pdf->Ln(10);



$rslt1=mysqli_query($con,"SELECT t1.id as oId,t1.*,t2.*,t3.productName FROM tbl_orders t1	LEFT JOIN tbl_order_items t2 ON  t1.orderNo=t2.fkOrderNumber LEFT JOIN tbl_products t3 ON t2.productId=t3.productId WHERE t1.orderNo='".$orderNo."'");
while($row1=mysqli_fetch_assoc($rslt1))
{	
	$shippingCharge=$row1["shippingCharge"];
	$productName	= $row1["productName"];
	$price			= $row1["unitPrice"];
	$paymentMethod=$row1["paymentMethod"];
	$oId	= $row1["oId"];
	$invoice=$row1["invoice"];
	$options="";
	$rslt2=mysqli_query($con,"SELECT t3.fkOptionValue FROM tbl_product_options_value t3 WHERE t3.id='".$row1["productOptions"]."'");
	if(mysqli_num_rows($rslt2)>0)
	{
		$row2=mysqli_fetch_assoc($rslt2);
		$fkOptionValue=$row2["fkOptionValue"];
		if(!empty($fkOptionValue))
		{
		$rslt2=mysqli_query($con,"select * from tbl_option_values where id IN($fkOptionValue)");
		while($row2=mysqli_fetch_assoc($rslt2))
		{
			$options.=$row2["optionValue"]." ";
		}
		}
	}
	

	//$pdf->Cell(190,10,'','B',0,'R');
	//$pdf->Ln(10);
	$pdf->Cell(10,10,++$i,0,0,'L');
	$pdf->Cell(70,10,$productName." ".$options,'',0,'L');
	$pdf->Cell(30,10,$row1["quantity"],0,0,'L');
	$pdf->Cell(40,10,$price,0,0,'L');
	$pdf->Cell(40,10,$row1["total"],0,0,'R');
	$pdf->Ln(8);
}
	$pdf->Ln(15);
	$pdf->Cell(190,10,'','B',0,'R');
	$pdf->Ln(5);

$x = $pdf->GetX();
$y = $pdf->GetY();

	$pdf->Ln(5);
	$pdf->Cell(10,10,'',0,0,'L');
	$pdf->Cell(135,10,'','',0,'L');
	$pdf->Cell(45,10,'Sub Total : '.$orderAmount,0,0,'R');

	if($orderDiscount>0)
	{
	$pdf->Ln(5);
	$pdf->Cell(10,10,'',0,0,'L');
	$pdf->Cell(135,10,'','',0,'L');
	$pdf->Cell(45,10,'Discount : '.$orderDiscount,0,0,'R');
	}
	
	if($shippingCharge!=0){$shipping='Shipping Charge: '.$currency." ".$shippingCharge;?><?php } else{ if($invoice!=2) $shipping="Free Shipping";}
	
	$pdf->Ln(5);
	$pdf->Cell(10,10,'',0,0,'L');
	$pdf->Cell(135,10,'','',0,'L');
	$pdf->Cell(45,10,$shipping,0,0,'R');
	if($fccAmount>0)
	{
	$pdf->Ln(5);
	$pdf->Cell(10,10,'',0,0,'L');
	$pdf->Cell(135,10,'','',0,'L');
	$pdf->Cell(45,10,'Amount Deducted From Families Club Card : '.$fccAmount,0,0,'R');
	}
	$pdf->SetFont('Arial','B',9);
	$pdf->Ln(5);
	$pdf->Cell(10,10,'',0,0,'L');
	$pdf->Cell(135,10,'','',0,'L');
	$pdf->Cell(45,10,'Grand Total : '.($orderAmount+$shippingCharge-$orderDiscount-$fccAmount),0,0,'R');	


$y=$y+7;
	$pdf->SetFont('Arial','B',9);
	$pdf->SetXY($x, $y);	
	$pdf->MultiCell(50,5,'Shipping Address:',0,'L',0);
	$pdf->SetFont('Arial','',9);
$y=$y+5;	
	$pdf->SetXY($x, $y);	
	$pdf->MultiCell(60,5,$fullName,0,'L',0);
$y=$y+5;	
	$pdf->SetXY($x, $y);	
	$pdf->MultiCell(60,5,strip_tags($shipTo),0,'L',0);
	$pdf->SetFont('Arial','',9);
$pdf->Ln(8);
	
	/*$pdf->SetFont('Arial','B',9);
	$pdf->Cell(190,10,'PAYMENT INFORMATION','BT',0,'C');
	$pdf->SetFont('Arial','B',9);
	$pdf->Ln(10);
	$pdf->Cell(60,10,'Payment Method: '.$paymentMethod,'',0,'L');
	$pdf->Cell(70,10,'Transaction Id: '.$transactionId,'',0,'L');
	$pdf->Cell(60,10,'Total: '.($orderAmount+$shippingCharge-$orderDiscount),'',0,'R');

	$pdf->SetFont('Arial','',9);
		$pdf->Ln(5);*/

$pdf->Output();
?>