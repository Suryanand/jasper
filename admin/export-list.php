<?php
include("session.php"); /*Check for session is set or not if not redirect to login page */
include_once("config.php"); /* Connection String*/
include('get-user.php');
if($userType != 1) /* This page only for admin - if normal user redirect to index  */
{
	header('location: index.php');
}
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
$objPHPExcel->getProperties()->setCreator("Horizon Kids Nursery")
							 ->setLastModifiedBy("Horizon Kids Nursery")
							 ->setTitle("Horizon Kids Nursery Registration")
							 ->setSubject("Horizon Kids Nursery Registration")
							 ->setDescription("Horizon Kids Nursery Registration")
							 ->setKeywords("Horizon Kids Nursery Registration")
							 ->setCategory("Horizon Kids Nursery Registration");


for($col = 'A'; $col !== 'T'; $col++) {
    $objPHPExcel->getActiveSheet()
        ->getColumnDimension($col)
        ->setAutoSize(true);
}
// Add some data
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Parent Name')
            ->setCellValue('B1', 'Email')
            ->setCellValue('C1', 'Phone')
            ->setCellValue('D1', 'Relation')
            ->setCellValue('E1', 'Student Name')
            ->setCellValue('F1', 'Gender')
            ->setCellValue('G1', 'DOB')
            ->setCellValue('H1', 'School Year')
            ->setCellValue('I1', 'Class')
            ->setCellValue('J1', 'Sibling');

if(isset($_GET["id"]))
	$rslt=mysqli_query($con,"select * from tbl_registration where formType=1 order by id desc");
else
	$rslt=mysqli_query($con,"select * from tbl_registration where formType=0 order by id desc");
$i=1;
while($row=mysqli_fetch_array($rslt))
{
	$i++;
	$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$i, $row['parentFirstName']." ".$row["parentLastName"])
            ->setCellValue('B'.$i, $row['email'])
            ->setCellValue('C'.$i, $row['phone'])
            ->setCellValue('D'.$i, $row['relation'])
            ->setCellValue('E'.$i, $row['studentFirstName']." ".$row["studentLastName"])
            ->setCellValue('F'.$i, $row['gender'])
            ->setCellValue('G'.$i, $row['dob'])
            ->setCellValue('H'.$i, $row['schoolYear'])
            ->setCellValue('I'.$i, $row["class"])
            ->setCellValue('J'.$i, $row['sibling']);
}



// Rename worksheet
//$objPHPExcel->getActiveSheet()->setTitle('Simple');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="01simple.xls"');
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
