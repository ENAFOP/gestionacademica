<?php
/**
	******************** GENERAR INDICE DE INFORMACION RESERVADA DEL ENTE OBLIGADO **********************************
	V1.0 27/09/17
	@author JOSE MARIO LOPEZ LEIVA
	marioleiva2011@gmail.com
	Script que lee de la aplicación de reserva de información y genera un Excel con el índice.
	
**/
/**
-------------------------------------- Parámetros que recibo a través del método POST desde el formulario ubicado en /views/multisis-lte/class.GenerarIndice.php

   -nombreUsuario: nombre del Oficial de Información
   -nombreEnteObligado: nombre del ente
   -fechaGeneracion: timestamp de la hora de creación del índice
   -fotoEnte: foto, si está definida, del logo del ente obligado
   -nombresDocumentos[]: array, conteniendo los nombres de los documentos que se van a reservar
   -unidadesEnte: array, con las unidades administrativas que generaron los documentos
   -numerosReserva: array, con los números de las reservas 
   -tiposReserva: total/parcial
   -autoridadReserva: autoridad que reserva, ejemplo, Dirección de auditoría interna
   -fundamentoLegal: array de arrays, con varios posibles literales del art. 19 LAIP
   -fechaClasificacion: fecha de clasificación de reservas, array de esto
   -fechaDesclasificacion: array de fechas de caducidad de reservas
   -motivoReserva: motivo de la reserva array.

   ----- para el indice de desclasificación

   
**/
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');



if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');

/** Include PHPExcel */
//require_once dirname(__FILE__) . '/Classes/PHPExcel.php';
    // echo "Hola, prueba de crear un excel y pushearlo al navegador";
	 //echo "<br>";
	 

	
///////////////////////// OBTENGO PARÁMETROS DESDE EL FORMULARIO
//1 Nombre del ente obligado
$referencias=array(); //valor por defecto
if (isset($_POST["arrayReferencias"])) //se envía a través del método POST porque es un formulario
{
	$referencias=$_POST["arrayReferencias"];
	//echo "creador excel: ".$creadorExcel;
}	
$fechas=array(); //valor por defecto
if (isset($_POST["arrayFechas"])) //se envía a través del método POST porque es un formulario
{
	$fechas=$_POST["arrayFechas"];
	//echo "creador excel: ".$creadorExcel;
}	
$tipologias=array(); //valor por defecto
if (isset($_POST["arrayTipologias"])) //se envía a través del método POST porque es un formulario
{
	$tipologias=$_POST["arrayTipologias"];
	//echo "creador excel: ".$creadorExcel;
}	
$problemas=array(); //valor por defecto
if (isset($_POST["arrayProblemas"])) //se envía a través del método POST porque es un formulario
{
	//$problemas=$_POST["arrayProblemas"];
  $problemas=unserialize(base64_decode($_POST['arrayProblemas']));
	//echo "creador excel: ".$creadorExcel;
}	
$decisiones=array(); //valor por defecto
if (isset($_POST["arrayDecisiones"])) //se envía a través del método POST porque es un formulario
{
	$decisiones=$_POST["arrayDecisiones"];
	//echo "creador excel: ".$creadorExcel;
}	
$ratios=array(); //valor por defecto
if (isset($_POST["arrayRatios"])) //se envía a través del método POST porque es un formulario
{
	$ratios=$_POST["arrayRatios"];
	//echo "creador excel: ".$creadorExcel;
}	
$busqueda="";
if (isset($_POST["busqueda"])) //se envía a través del método POST porque es un formulario
{
	$busqueda=$_POST["busqueda"];
	//echo "creador excel: ".$creadorExcel;
}





	 
//////////// CREO EL EXCEL
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator($creadorExcel)
							 ->setLastModifiedBy($creadorExcel)
							 ->setTitle("Resultado de la búsqueda en buscador de resoluciones TEG")
							 ->setSubject("Office 2007 XLSX Test Document")
							 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 teg buscador")
							 ->setCategory("Indice de información reservada");
//METER CABECERAS
// $datosOficial="Oficial de Información: ".$creadorExcel;
// $ultimaActualizacion="Última actualización: ".$fechaGeneracion;
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Resultados de la búsqueda en Buscador de resoluciones del TEG-El Salvador')
			->setCellValue('A2', $busqueda);				
$objPHPExcel->getActiveSheet()->mergeCells('A1:C1');
$style1 = array(
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        )
    );

 $objPHPExcel->getActiveSheet()->getStyle('A1:J1')->applyFromArray($style1);

$objPHPExcel->getActiveSheet()->mergeCells('A2:C2');
// $style2 = array(
        // 'alignment' => array(
            // 'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        // ),
        // 'font'  => array(
        // 'bold'  => true,
        // 'color' => array('rgb' => '#4b42f4'),
        // 'size'  => 17,
        // 'name'  => 'Candara'
    // )
    // );

 // $objPHPExcel->getActiveSheet()->getStyle('A2:J2')->applyFromArray($style2);

// $objPHPExcel->getActiveSheet()->mergeCells('A3:C3');
// $style3 = array(
        // 'alignment' => array(
            // 'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        // ),
        // 'font'  => array(
        // 'bold'  => true,
        // 'color' => array('rgb' => '#0c0104'),
        // 'size'  => 17,
        // 'name'  => 'Calibri'
    // )
    // );

 // $objPHPExcel->getActiveSheet()->getStyle('A3:J3')->applyFromArray($style3);


// $objPHPExcel->getActiveSheet()->mergeCells('A4:C4');
// $style4 = array(
        // 'alignment' => array(
            // 'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        // )
    // );

 // $objPHPExcel->getActiveSheet()->getStyle('A4:J4')->applyFromArray($style4);

 //cabeceras de columnas
 $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A5', 'Nº de referencia resolución')
             ->setCellValue('B5', 'Fecha de resolución')
            ->setCellValue('C5', 'Tipología')
            //->setCellValue('D5', 'Problema jurídico')
            ->setCellValue('D5', 'Decisión');	
            //->setCellValue('F5', 'Ratio Decidiendi');					

for($col = 'A'; $col !== 'N'; $col++) {
    $objPHPExcel->getActiveSheet()
        ->getColumnDimension($col)
        ->setAutoSize(true);
}
$style5 = array(
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        ),
        'font'  => array(
        'bold'  => true,
        'color' => array('rgb' => '#0c0104'),
        'size'  => 15,
        'name'  => 'Corbel'
    ),
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => '00c7ff')
        )
    );
 $objPHPExcel->getActiveSheet()->getStyle('A5:D5')->applyFromArray($style5);
////////////////////////////////////// 									empezar a poblar con los datos reales 			/	////////////////////////////////////////////////////////////////////////////////////////
  //FECHA DE DESCLASIFICACION.  A PARTIR DE LA J6
$limite=count($referencias);
$cont=0;
$col=0; //columnas desde cero: 0=A, 1=B, etc  G=6 H=7 E=4 I=8 F=5 J=9
//columna D Unidades 
$row=6; //filas empiezan desde 1 (numeración arábiga) Y DESDE EL 6 PARA MI TABLA, SIEMPRE
for($cont=0;$cont<$limite;$cont++)
{
	//echo "Bucle meter numeros de reserva";
	$data=$referencias[$cont];
	//echo "data: ".$data;
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $data);
	$row++;
	//echo "hola";
}
  // //MOTIVO RESERVA.  A PARTIR DE LA F6
$limite=count($fechas);
$cont=0;
$col=1; //columnas desde cero: 0=A, 1=B, etc  G=6 H=7 E=4 I=8 F=5
//columna D Unidades 
$row=6; //filas empiezan desde 1 (numeración arábiga) Y DESDE EL 6 PARA MI TABLA, SIEMPRE
for($cont=0;$cont<$limite;$cont++)
{
	//echo "Bucle meter numeros de reserva";
	$data=$fechas[$cont];
	//echo "data: ".$data;
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $data);
	$row++;
	//echo "hola";
}
 // //FECHA CLASIFICACION.  A PARTIR DE LA I6
$limite=count($tipologias);
$cont=0;
$col=2; //columnas desde cero: 0=A, 1=B, etc  G=6 H=7 E=4 I=8
//columna D Unidades 
$row=6; //filas empiezan desde 1 (numeración arábiga) Y DESDE EL 6 PARA MI TABLA, SIEMPRE
for($cont=0;$cont<$limite;$cont++)
{
	//echo "Bucle meter numeros de reserva";
	$data=$tipologias[$cont];
	//echo "data: ".$data;
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $data);
	$row++;
	//echo "hola";
}
/*   // //FUNDAMENTO LEGAL.  A PARTIR DE LA G6
$limite=count($problemas);
$cont=0;
$col=3; //columnas desde cero: 0=A, 1=B, etc  G=6 H=7 E=4
//columna D Unidades
$row=6; //filas empiezan desde 1 (numeración arábiga) Y DESDE EL 6 PARA MI TABLA, SIEMPRE
for($cont=0;$cont<$limite;$cont++)
{
	//echo "Bucle meter numeros de reserva";
	$data=$problemas[$cont][0];
	//echo "data: ".$data;
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $data);
	$row++;
	//echo "hola";
} */
 // //AUTORIDADD QUE RESERVA.  A PARTIR DE LA e6
// $limite=count($autoridadReserva);
$cont=0;
$col=3; //columnas desde cero: 0=A, 1=B, etc H=7 E=4
//columna D Unidades
$row=6; //filas empiezan desde 1 (numeración arábiga) Y DESDE EL 6 PARA MI TABLA, SIEMPRE
for($cont=0;$cont<$limite;$cont++)
{
	//echo "Bucle meter numeros de reserva";
	$data=$decisiones[$cont];
	//echo "data: ".$data;
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $data);
	$row++;
	//echo "hola";
}
  // //TIPOS DE CLASIFICACION.  A PARTIR DE LA H6
/* // $limite=count($tiposReserva);
$cont=0;
$col=5; //columnas desde cero: 0=A, 1=B, etc H=7
//columna D Unidades
$row=6; //filas empiezan desde 1 (numeración arábiga) Y DESDE EL 6 PARA MI TABLA, SIEMPRE
for($cont=0;$cont<$limite;$cont++)
{
	//echo "Bucle meter numeros de reserva";
	$data=$ratios[$cont];
	//echo "data: ".$data;
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $data);
	$row++;
	//echo "hola";
}
 */
//https://stackoverflow.com/questions/27764204/how-to-do-the-phpexcel-outside-border
// $BStyle = array(
  // 'borders' => array(
    // 'outline' => array(
      // 'style' => PHPExcel_Style_Border::BORDER_THIN
    // )
  // )
// );
// $numeroDocumentosIndice=$limite;
// $ultimaFila=5+$limite;
// $borderLandA="A5:A".$ultimaFila;
// $borderLandB="B5:B".$ultimaFila;
// $borderLandC="C5:C".$ultimaFila;
// $borderLandD="D5:D".$ultimaFila;
// $borderLandE="E5:E".$ultimaFila;
// $borderLandF="F5:F".$ultimaFila;
// $borderLandG="G5:G".$ultimaFila;
// $borderLandH="H5:H".$ultimaFila;
// $borderLandI="I5:I".$ultimaFila;
// $borderLandJ="J5:J".$ultimaFila;
// $objPHPExcel->getActiveSheet()->getStyle($borderLandA)->applyFromArray($BStyle);
// $objPHPExcel->getActiveSheet()->getStyle($borderLandB)->applyFromArray($BStyle);
// $objPHPExcel->getActiveSheet()->getStyle($borderLandC)->applyFromArray($BStyle);
// $objPHPExcel->getActiveSheet()->getStyle($borderLandD)->applyFromArray($BStyle);
// $objPHPExcel->getActiveSheet()->getStyle($borderLandE)->applyFromArray($BStyle);
// $objPHPExcel->getActiveSheet()->getStyle($borderLandF)->applyFromArray($BStyle);
// $objPHPExcel->getActiveSheet()->getStyle($borderLandG)->applyFromArray($BStyle);
// $objPHPExcel->getActiveSheet()->getStyle($borderLandH)->applyFromArray($BStyle);
// $objPHPExcel->getActiveSheet()->getStyle($borderLandI)->applyFromArray($BStyle);
// $objPHPExcel->getActiveSheet()->getStyle($borderLandJ)->applyFromArray($BStyle);
$objPHPExcel->getActiveSheet()->setTitle("Resultado buscador");

// $urlFoto=base64_decode($urlFoto);
// $gdImage = imagecreatefromstring ($urlFoto);
// // Add a drawing to the worksheetecho date('H:i:s') . " Add a drawing to the worksheet\n";
// $objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
// $objDrawing->setName('Sample image');$objDrawing->setDescription('Sample image');
// $objDrawing->setImageResource($gdImage);
// $objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
// $objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
// $objDrawing->setHeight(150);
// $objDrawing->setWidth(225);    
// $objDrawing->setCoordinates('D1');
// $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
// //$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');$objWriter->save(str_replace('.php', '.xlsx', __FILE__));
// //Redirect output to a client’s web browser (Excel2007)

/////////////////////////////////////////////////////////////////////////////
ob_end_clean();
$nombreFicheroFinal="consulta_TEG.xlsx";
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename=\"".$nombreFicheroFinal."\"");
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0
//header('Location: /generarExcel.php');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');

exit;

?>