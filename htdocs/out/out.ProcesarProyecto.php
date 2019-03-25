<?php
//    
//    Copyright (C) José Mario López Leiva. marioleiva2011@gmail.com_addre
//    September 2017. San Salvador (El Salvador)
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

include("../inc/inc.Settings.php");
include("../inc/inc.Language.php");
include("../inc/inc.Init.php");
include("../inc/inc.Extension.php");
include("../inc/inc.DBInit.php");
include("../inc/inc.ClassUI.php");
include("../inc/inc.Authentication.php");
/////////////////////////////        FUNCIONES AUXILIARES ///////////////////////////////////////////////////////
//devuelve el id del item recien creado
 function crearProyecto($fecha_fin,$setefe,$montoTotal,$nombre,$montoBienes,$montoMateriales,$origen_fondos,$dms)
	 {
	 	$res=true;
		$db = $dms->getDB();
		$insertar = "INSERT INTO app_proyecto VALUES(NULL,'$fecha_fin',$setefe,$montoTotal,'$nombre',$montoBienes,$montoMateriales,$origen_fondos)";
		//echo "INSERTAR: ".$insertar;
		$res1 = $db->getResult($insertar);
		$idCreado=$db->getInsertID();
		return $idCreado;
	 }
	 function insertarUbicacionItem($idItem,$idUbicacion,$dms)
	 {
	 	$res=true;
		$db = $dms->getDB();
		$insertar = "INSERT INTO app_ubicacion_item VALUES(NULL,$idItem,$idUbicacion)";
		//echo "INSERTAR: ".$insertar;
		$res1 = $db->getResult($insertar);
		if (!$res1)
		{
			$res=false;
		}
		return $res;
	 }
////////////////////////////////////////////////////////////////////////////////////
//tabla seeddms.tblattributedefinitions;
 //generan
if ($user->isGuest()) {
	UI::exitError(getMLText("no_permitido"),getMLText("access_denied"));
}

// Check to see if the user wants to see only those documents that are still
// in the review / approve stages.
$showInProcess = false;
if (isset($_GET["inProcess"]) && strlen($_GET["inProcess"])>0 && $_GET["inProcess"]!=0) {
	$showInProcess = true;
}

$orderby='n';
if (isset($_GET["orderby"]) && strlen($_GET["orderby"])==1 ) {
	$orderby=$_GET["orderby"];
}

$tmp = explode('.', basename($_SERVER['SCRIPT_FILENAME']));
$view = UI::factory($theme, $tmp[1], array('dms'=>$dms, 'user'=>$user));

//---------PESTAÑA 1: DATOS GENERALES:
$nombreProyecto="";
$codigoSetefe="";
$montoTotal="";
$fechaFin="";
$montoBienes="";
$montoMateriales="";
$origenFondos="";

/////////////////
if (isset($_POST["nombreProyecto"])) 
{
    $nombreProyecto=$_POST["nombreProyecto"]; 
}
if (isset($_POST["codigoSetefe"])) 
{
    $codigoSetefe=$_POST["codigoSetefe"]; 
}
if (isset($_POST["montoTotal"])) 
{
    $montoTotal=$_POST["montoTotal"]; 
}
if (isset($_POST["fechaFin"])) 
{
    $fechaFin=$_POST["fechaFin"]; 
}
if (isset($_POST["montoBienes"])) 
{
    $montoBienes=$_POST["montoBienes"]; 
}
if (isset($_POST["montoMateriales"])) 
{
    $montoMateriales=$_POST["montoMateriales"]; 
}
if (isset($_POST["origenFondos"])) 
{
    $origenFondos=$_POST["origenFondos"]; 
}


////////hago metida en BD
crearProyecto($fechaFin,$codigoSetefe,$montoTotal,$nombreProyecto,$montoBienes,$montoMateriales,$origenFondos,$dms);

if($view) 
{
	$view->setParam('orderby', $orderby);
	$view->setParam('showinprocess', $showInProcess);
	$view->setParam('workflowmode', $settings->_workflowMode);
	$view->setParam('cachedir', $settings->_cacheDir);
	$view->setParam('previewWidthList', $settings->_previewWidthList);
	$view->setParam('timeout', $settings->_cmdTimeout);
	$view->setParam('nombreProyecto', $nombreProyecto);
	$view->setParam('codigoSetefe', $codigoSetefe);
	$view($_GET);
	exit;
}
?>
