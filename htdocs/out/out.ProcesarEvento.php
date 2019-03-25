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
 function crearEvento($nombreEvento,$lugarEvento,$totalInvitados,$fechaInicio,$fechaFin,$comentarios,$dms,$usuario)
	 {
	 	$res=true;
		$db = $dms->getDB();
		$insertar = "INSERT INTO app_evento VALUES(NULL,'$nombreEvento','$lugarEvento',$totalInvitados,'$fechaInicio','$fechaFin','$comentarios',$usuario)";
		//echo "INSERTAR: ".$insertar;
		$res1 = $db->getResult($insertar);
		if (!$res1)
		{
			$res=false;
		}
		return $res;
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

//---------PESTAÑA 1: DATOS GENERALES:
$nombreEvento="";
$lugarEvento="";
$totalInvitados="";
$fechaInicio="";
$fechaFin="";
$comentarios="";

if (isset($_POST["nombreEvento"])) 
{
    $nombreEvento=$_POST["nombreEvento"]; 
}
if (isset($_POST["lugarEvento"])) 
{
    $lugarEvento=$_POST["lugarEvento"]; 
}
if (isset($_POST["totalInvitados"])) 
{
    $totalInvitados=$_POST["totalInvitados"]; 
}
if (isset($_POST["fechaInicio"])) 
{
    $fechaInicio=$_POST["fechaInicio"]; 
}
if (isset($_POST["fechaFin"])) 
{
    $fechaFin=$_POST["fechaFin"]; 
}
if (isset($_POST["comentarios"])) 
{
    $comentarios=$_POST["comentarios"]; 
}

////////hago metida en BD
$resu=crearEvento($nombreEvento,$lugarEvento,$totalInvitados,$fechaInicio,$fechaFin,$comentarios,$dms,$user->getID());

if($view) 
{
	$view->setParam('orderby', $orderby);
	$view->setParam('showinprocess', $showInProcess);
	$view->setParam('workflowmode', $settings->_workflowMode);
	$view->setParam('cachedir', $settings->_cacheDir);
	$view->setParam('previewWidthList', $settings->_previewWidthList);
	$view->setParam('timeout', $settings->_cmdTimeout);
	$view->setParam('nombreEvento', $nombreEvento);
	$view->setParam('lugarEvento', $comentarios);
	$view->setParam('totalInvitados', $totalInvitados);
	$view->setParam('fechaInicio', $fechaInicio);
	$view->setParam('fechaFin', $fechaFin);
	$view->setParam('comentarios', $comentarios);
	$view($_GET);
	exit;
}


?>
