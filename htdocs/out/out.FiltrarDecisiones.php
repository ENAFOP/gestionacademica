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

//esta es una variable global y acceso a ella desde $GLOBALS
 /*
 FUNCION QUE RECIBE UNA CARPETA, CORRESPONDIENTE A UN DEPARAMENTO, Y CUENTA
 */
 //creado José Mario López Leiva
 /**
DEVUELVE EL ID DE USUARIO DADO UN ID DE FOLDER QUE ES EL HOME FOLDER
 **/


function contarDecisionSegunRango($decision,$fechaInicial,$fechaFinal) //dado un id de usuario, me devuelve el id del folder de inicio de ese usuario
{
	//echo "Función getDefaultUserFolder. Se ha pasado con argumento: ".$id_usuario;
	$idUsuario=0;
	 $settings = new Settings(); //acceder a parámetros de settings.xml con _antes
  	$driver=$settings->_dbDriver;
    $host=$settings->_dbHostname;
    $user=$settings->_dbUser;
    $pass=$settings->_dbPass;
    $base=$settings->_dbDatabase;
	$manejador=new SeedDMS_Core_DatabaseAccess($driver,$host,$user,$pass,$base);
	$estado=$manejador->connect();
	//echo "Conectado: ".$estado;
	if($estado!=1)
	{
		echo "out.EstadisticaDecisiones-Error: no se pudo conectar a la BD ".$base;
		exit;
	}	
	$miQuery="";
	if(strcmp($decision, "Sanciona"))
	{
		$miQuery="SELECT COUNT(*) from tblDocumentAttributes WHERE attrdef=1 and value between '$fechaInicial' and '$fechaFinal' and document in (SELECT document FROM tblDocumentAttributes WHERE attrdef=8 and value='-Sanciona')";
	}
	if(strcmp($decision, "Improcedente"))
	{
		$miQuery="SELECT COUNT(*) from tblDocumentAttributes WHERE attrdef=1 and value between '$fechaInicial' and '$fechaFinal' and document in (SELECT document FROM tblDocumentAttributes WHERE attrdef=8 and value='-Improcedente')";
	}
	if(strcmp($decision, "No sanciona"))
	{
		$miQuery="SELECT COUNT(*) from tblDocumentAttributes WHERE attrdef=1 and value between '$fechaInicial' and '$fechaFinal' and document in (SELECT document FROM tblDocumentAttributes WHERE attrdef=8 and value='-No sanciona')";
	}
	if(strcmp($decision, "Sin lugar a la apertura del procedimiento"))
	{
		$miQuery="SELECT COUNT(*) from tblDocumentAttributes WHERE attrdef=1 and value between '$fechaInicial' and '$fechaFinal' and document in (SELECT document FROM tblDocumentAttributes WHERE attrdef=8 and value='-Sin lugar a la apertura del procedimiento')";
	}
	if(strcmp($decision, "Sobreseimiento"))
	{
		$miQuery="SELECT COUNT(*) from tblDocumentAttributes WHERE attrdef=1 and value between '$fechaInicial' and '$fechaFinal' and document in (SELECT document FROM tblDocumentAttributes WHERE attrdef=8 and value='-Sobreseimiento')";
	}
	if(strcmp($decision, "Inadmisible"))
	{
		$miQuery="SELECT COUNT(*) from tblDocumentAttributes WHERE attrdef=1 and value between '$fechaInicial' and '$fechaFinal' and document in (SELECT document FROM tblDocumentAttributes WHERE attrdef=8 and value='-Inadmisible')";
	}
	if(strcmp($decision, "Desistimiento"))
	{
		$miQuery="SELECT COUNT(*) from tblDocumentAttributes WHERE attrdef=1 and value between '$fechaInicial' and '$fechaFinal' and document in (SELECT document FROM tblDocumentAttributes WHERE attrdef=8 and value='-Desistimiento')";
	}
	//query de consulta:
	
	/////////////////////////////////////
	$resultado=$manejador->getResultArray($miQuery);
	if($resultado==FALSE)
	{
		echo "out.Estadisticas Decisiones.php--Error: no se pudo  hacer la consulta ".$miQuery;
		exit;
	}
	$contador=$resultado[0]['COUNT(*)'];
		return $contador;
}

//////---------------------------------------------------------------------------------------------------------------------------------------------------------

/* //generan
if ($user->isGuest()) {
	UI::exitError(getMLText("my_documents"),getMLText("access_denied"));
}
*/
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
 //calcular cúantos documentos tiene cada literal de prohibición ÉTICA (desde la A hasta la L)
$numeroSanciona=0;
$numeroSinLugar=0;
$numeroImprocedente=0;
$numeroNoSanciona=0;
$numeroSobreseimiento=0;
$numeroInadmisible=0;
$numeroDesistimiento=0;
// -Sin lugar a la apertura del procedimiento
// -Sanciona
// -Improcedente
// -No sanciona
// -Sobreseimiento
// -Inadmisible
// -Desistimiento
//////////////////////////
  $fechaInicial=$_POST["fechaInicio"];
$fechaFinal=$_POST["fechaFin"];

$stringDecisiones="Decisión";
////
$stringSinLugar="Sin lugar a la apertura del procedimiento";
$stringSanciona="Sanciona";
$stringImprocedente="Improcedente";
$stringNoSanciona="No sanciona";
$stringSobreseimiento="Sobreseimiento";
$stringInadmisible="Inadmisible";
$stringDesistimiento="Desistimiento";

$numeroSanciona=contarDecisionSegunRango($stringSanciona,$fechaInicial,$fechaFinal);
$numeroSinLugar=contarDecisionSegunRango($stringSinLugar,$fechaInicial,$fechaFinal);
$numeroImprocedente=contarDecisionSegunRango($stringImprocedente,$fechaInicial,$fechaFinal);
$numeroNoSanciona=contarDecisionSegunRango($stringNoSanciona,$fechaInicial,$fechaFinal);
$numeroSobreseimiento=contarDecisionSegunRango($stringSobreseimiento,$fechaInicial,$fechaFinal);
$numeroInadmisible=contarDecisionSegunRango($stringInadmisible,$fechaInicial,$fechaFinal);
$numeroDesistimiento=contarDecisionSegunRango($stringDesistimiento,$fechaInicial,$fechaFinal);

$tmp = explode('.', basename($_SERVER['SCRIPT_FILENAME']));
$view = UI::factory($theme, $tmp[1], array('dms'=>$dms, 'user'=>$user));
if($view) 
{
	$view->setParam('orderby', $orderby);
	$view->setParam('showinprocess', $showInProcess);
	$view->setParam('workflowmode', $settings->_workflowMode);
	$view->setParam('cachedir', $settings->_cacheDir);
	$view->setParam('previewWidthList', $settings->_previewWidthList);
	$view->setParam('timeout', $settings->_cmdTimeout);
	
	$view->setParam('numeroSinLugar', $numeroSinLugar);
	$view->setParam('numeroSanciona', $numeroSanciona);
	$view->setParam('numeroImprocedente', $numeroImprocedente);
	$view->setParam('numeroNoSanciona', $numeroNoSanciona);
	$view->setParam('numeroSobreseimiento', $numeroSobreseimiento);
	$view->setParam('numeroInadmisible', $numeroInadmisible);
	$view->setParam('numeroDesistimiento', $numeroDesistimiento);
	$view($_GET);
	exit;
}

?>