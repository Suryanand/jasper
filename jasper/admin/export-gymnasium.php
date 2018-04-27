<?php
include("session.php"); /*Check for session is set or not if not redirect to login page */
include_once("config.php"); /* Connection String*/
include('get-user.php');
//if($userType != 1 || !isset($_GET["id"])) /* This page only for admin - if normal user redirect to index  */
//{
//	header('location: index.php');
//}

//$type=$_GET["id"];
/**
 * PHPExcel
 *
 * Copyright (c) 2006 - 2015 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2015 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    ##VERSION##, ##DATE##
 */

/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
//date_default_timezone_set('Europe/London');

if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');

/** Include PHPExcel */
require_once dirname(__FILE__) . '/PHPExcel/Classes/PHPExcel.php';


// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Alodawaa")
							 ->setLastModifiedBy("Alodawaa")
							 ->setTitle("Alodawaa Registration")
							 ->setSubject("Alodawaa Registration")
							 ->setDescription("Alodawaa Registration")
							 ->setKeywords("Alodawaa Registration")
							 ->setCategory("Alodawaa Registration");


for($col = 'A'; $col !== 'T'; $col++) {
    $objPHPExcel->getActiveSheet()
        ->getColumnDimension($col)
        ->setAutoSize(true);
}
// Add some data
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Name')
            ->setCellValue('B1', 'Category')
            ->setCellValue('C1', 'Country')
            ->setCellValue('D1', 'Region')
            ->setCellValue('E1', 'Area')
            ->setCellValue('F1', 'Address')
            ->setCellValue('G1', 'Phone')
            ->setCellValue('H1', 'Fax')
            ->setCellValue('I1', 'Email')
            ->setCellValue('J1', 'Network 1')
            ->setCellValue('K1', 'Network 2');

//if($type==2)
//	$category="Hospital";
//elseif($type==1)
//	$category="Clinic";
//else
//	$category="Pharmacy";
$rslt=mysqli_query($con,"SELECT * from tbl_gymnasium ORDER BY id desc");
$i=1;
while($row=mysqli_fetch_array($rslt))
{
	$i++;
	$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$i, $row['companyName'])
            ->setCellValue('B'.$i, 'Gymnasium')
            ->setCellValue('C'.$i, $row['country'])
            ->setCellValue('D'.$i, $row['location'])
            ->setCellValue('E'.$i, $row['area'])
            ->setCellValue('F'.$i, $row['address'])
            ->setCellValue('G'.$i, $row['contactNo'])
            ->setCellValue('H'.$i, $row['fax'])
            ->setCellValue('I'.$i, $row["email"])
            ->setCellValue('J'.$i, $row['network1'])
            ->setCellValue('K'.$i, $row['network2']);
}



// Rename worksheet
//$objPHPExcel->getActiveSheet()->setTitle('Simple');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="alodawaa-lists.xls"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
