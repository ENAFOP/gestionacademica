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
 function hacerTransaccion($idItem,$razon,$cantidadVariada,$idUsuario,$operacion,$dms,$grupoReceptor,$tipoTransaccion)
	 {
	 	//$tipoTransaccion=1, es quitar
	 	// 2 es devolver de ese artículo
	 	$res=true;
		$db = $dms->getDB();
		$insertar = "INSERT INTO app_transaccion VALUES(NULL,NOW(),$idItem,$idUsuario,'$razon',$cantidadVariada,$grupoReceptor,$tipoTransaccion)";
		
		$res1 = $db->getResult($insertar);
		if (!$res1)
		{
			$res=false;
		}
		/////////// ya cree el historial, ahora actualizar la cantidad existente
		//a) obtengo valor actual:

		$consultar="SELECT cantidad_actual FROM app_item WHERE id=$idItem";
		$res2 = $db->getResultArray($consultar);
		$datoActual=$res2[0]['cantidad_actual'];
		$datoNuevo=0;
		if(strcmp($operacion, "sumar")==0)
		{
			$datoNuevo=$datoActual+$cantidadVariada;
		}
		else
		{
			$datoNuevo=$datoActual-$cantidadVariada;
		}
		$actualizar = "UPDATE app_item set cantidad_actual=$datoNuevo WHERE id=$idItem;";
		//echo "actualizar: ".$actualizar;
		$res3 = $db->getResult($actualizar);
		return $datoNuevo;
	 }

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

//---------PESTAÑA 1: DATOS GENERALES: recibo un array de cada uno.
$arrayNuevaCantidad=array();
$idItem=array();
$radio=""; //pone o quita item con radio button
$motivo="";
$cantidad="";
$operacion="";
$grupoReceptor="";
$tipoTransaccion=0; //1 si es quitar y 2 si es añadir

/////////////////
    if (isset($_POST["radio"])) //puede tomar valor "sumar" o restar"
		{
		    $radio=$_POST["radio"]; 
		}
		if (isset($_POST["motivo"])) 
		{
		    $motivo=$_POST["motivo"]; 
		}
		if (isset($_POST["cantidad"])) 
		{
		    $cantidad=$_POST["cantidad"]; 
		}
		if (isset($_POST["grupoReceptor"])) 
		{
		    $grupoReceptor=$_POST["grupoReceptor"]; 
		}
		if(strcmp($radio, "sumar")==0) //solo puede ser sumar o restar
		{
		  $tipoTransaccion=2;
		}
		else
		{
			$tipoTransaccion=1;
		}
$idUsuario=$user->getID();
if (isset($_POST["nombreItem"])) 
{
    $idItem=$_POST["nombreItem"];
		
		foreach ($idItem as $key) 
	    {
	    	$nuevaCantidad=hacerTransaccion($key,$motivo,$cantidad,$idUsuario,$radio,$dms,$grupoReceptor,$tipoTransaccion);
	    	array_push($arrayNuevaCantidad, $nuevaCantidad);
	    }
}

////////hago metida en BD
if($view) 
{
	$view->setParam('orderby', $orderby);
	$view->setParam('showinprocess', $showInProcess);
	$view->setParam('workflowmode', $settings->_workflowMode);
	$view->setParam('cachedir', $settings->_cacheDir);
	$view->setParam('previewWidthList', $settings->_previewWidthList);
	$view->setParam('timeout', $settings->_cmdTimeout);
	$view->setParam('idItem', $idItem);
	$view->setParam('motivo', $motivo);
	$view->setParam('cantidad', $cantidad);
	$view->setParam('operacion', $operacion);
	$view->setParam('arrayNuevaCantidad', $arrayNuevaCantidad);
	$view->setParam('arrayIdItems', $idItem);
	$view($_GET);
	exit;
}
?>
