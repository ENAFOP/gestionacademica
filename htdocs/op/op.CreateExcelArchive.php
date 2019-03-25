<?php
//    MyDMS. Document Management System
//    Copyright (C) 2010 Matteo Lucarelli
//    Copyright (C) 2010-2016 Uwe Steinmann
//
//    This program is free software; you can redistribute it and/or modify
//    it under the terms of the GNU General Public License as published by
//    the Free Software Foundation; either version 2 of the License, or
//    (at your option) any later version.
//
//    This program is distributed in the hope that it will be useful,
//    but WITHOUT ANY WARRANTY; without even the implied warranty of
//    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//    GNU General Public License for more details.
//
//    You should have received a copy of the GNU General Public License
//    along with this program; if not, write to the Free Software
//    Foundation, Inc., 675 Mass Ave, Cambridge, MA 02139, USA.

include("../inc/inc.Version.php");
include("../inc/inc.Settings.php");
include("../inc/inc.LogInit.php");
include("../inc/inc.Language.php");
include("../inc/inc.Init.php");
include("../inc/inc.Extension.php");
include("../inc/inc.DBInit.php");
include("../inc/inc.ClassUI.php");
include("../inc/inc.Authentication.php");
require_once("../lib/PHPExcel.php");

if (!$user->isAdmin()) {
	UI::exitError(getMLText("admin_tools"),getMLText("access_denied"));
}

$v = new SeedDMS_Version;
$excel_name = $settings->_contentDir.date('Y-m-d\TH-i-s')."_".$v->_number.".xlsx";
/*
if(!$dms->createDump($dump_name))
	UI::exitError(getMLText("admin_tools"),getMLText("error_occured"));
*/

// Field names
$field_names = ["ID_DMS",
                "Tipo_de_Resolución", 
                "Año_de_Resolución",
                "Referencia",
                "Fecha_de_Resolución",
                "Tesauro_o_Tipología",
                "Problema_Jurídico",
                "Fundamento",
                "Decisión",
                "Deber_Ético",
                "Prohibición_Ética",
                "Principio",
                "Ley"];

// Create your database query
$query = "
SELECT DISTINCT d.id ID_DMS, 
       (SELECT z.value FROM tblDocumentAttributes z WHERE z.attrdef = 13 AND z.document = d.id) Tipo_de_Resolución,
       (SELECT right(z.value,2) FROM tblDocumentAttributes z WHERE z.attrdef = 14 AND z.document = d.id) Año_de_Resolución,
       d.name Referencia, 
       (SELECT DATE_FORMAT(z.value, '%d/%m/%Y') FROM tblDocumentAttributes z WHERE z.attrdef = 1 AND z.document = d.id) Fecha_de_Resolución,
       (SELECT GROUP_CONCAT(x.categoryID) FROM tblDocumentCategory x WHERE x.documentID = d.id GROUP BY documentID) Tesauro_o_Tipología,
       (SELECT z.value FROM tblDocumentAttributes z WHERE z.attrdef = 6 AND z.document = d.id) Problema_Jurídico,
       (SELECT REPLACE(z.value, '\r\n', ' ') FROM tblDocumentAttributes z WHERE z.attrdef = 7 AND z.document = d.id) Fundamento,
       (SELECT z.value FROM tblDocumentAttributes z WHERE z.attrdef = 8 AND z.document = d.id) Decisión,
       (SELECT z.value FROM tblDocumentAttributes z WHERE z.attrdef = 4 AND z.document = d.id) Deber_Ético,
       (SELECT z.value FROM tblDocumentAttributes z WHERE z.attrdef = 5 AND z.document = d.id) Prohibición_Ética,
       'Este campo no existe en el DMS' Principio,
       (SELECT z.value FROM tblDocumentAttributes z WHERE z.attrdef = 17 AND z.document = d.id) Ley
FROM tblDocuments d
INNER JOIN tblDocumentAttributes da
ON d.id = da.document
INNER JOIN tblAttributeDefinitions ad
ON da.attrdef = ad.id;
";  

// Execute the database query
$result = $db->getResultArray($query);

$objPHPExcel = new \PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator($user->getFullName())
							 ->setLastModifiedBy($user->getFullName())
							 ->setTitle("Resultado de la búsqueda en buscador de resoluciones TEG")
							 ->setSubject("Office 2007 XLSX Test Document")
							 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 teg buscador")
							 ->setCategory("Resoluciones");

// Initialise the Excel row number
$rowCount = 1; 

//start of printing column names as names of MySQL fields  
$column = 'A';
for ($i = 1; $i <= count($field_names); $i++)  
{
    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $field_names[$i-1]);
    $column++;
}
//end of adding column names  

//start while loop to get data  
$rowCount = 2; 

// Iterate through each result from the SQL query in turn
// We fetch each database result row into $row in turn
foreach($result as $row) {
	$column = 'A';
	for ($i = 1; $i <= count($field_names); $i++)  
	{
	    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $row[$field_names[$i-1]]);
	    $column++;
	}
    $rowCount++; 
} 

// Instantiate a Writer to create an OfficeOpenXML Excel .xlsx file
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
// Write the Excel file to filename some_excel_file.xlsx in the current directory
$objWriter->save($excel_name); 


// Compress file
if (SeedDMS_Core_File::gzcompressfile($excel_name,9)) unlink($excel_name);
else UI::exitError(getMLText("admin_tools"),getMLText("error_occured"));

add_log_line();

header("Location:../out/out.BackupTools.php");

?>