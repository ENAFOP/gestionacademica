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
function getTime() {
	if (function_exists('microtime')) {
		$tm = microtime();
		$tm = explode(' ', $tm);
		return (float) sprintf('%f', $tm[1] + $tm[0]);
	}
	return time();
}
//tabla seeddms.tblattributedefinitions;
 //generan
if ($user->isGuest()) {
	UI::exitError(getMLText("my_documents"),getMLText("access_denied"));
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

/////lo que obtenigo del formulario de búsqueda simple
$terminos="";
if (isset($_POST["terminos"]) ) 
{

	$terminos=$_POST["terminos"];
}

$limit=0;
if (isset($_POST["limite"]) ) 
{

	$limit=$_POST["limite"];
}


//hago la búsqueda SIMPLE como tal
$startTime = getTime();

$resArr = $dms->search($terminos, $limit, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
$searchTime = getTime() - $startTime;
	$searchTime = round($searchTime, 2);
echo "search time: ".$searchTime;
   $entries="";
	$dcount = 0;
	if($resArr['docs']) {
		foreach ($resArr['docs'] as $entry) 
		{
			
				$entry->verifyLastestContentExpriry();
				$entries[] = $entry;
				$dcount++;
			
		}
	}
	$totalPages = (int) (count($entries)/$limit);
	if(count($entries)%$limit)
		$totalPages++;



//////////////////////
$tmp = explode('.', basename($_SERVER['SCRIPT_FILENAME']));
$view = UI::factory($theme, $tmp[1], array('dms'=>$dms, 'user'=>$user));

if($view) {
	$view->setParam('orderby', $orderby);
	$view->setParam('showinprocess', $showInProcess);
	$view->setParam('workflowmode', $settings->_workflowMode);
	$view->setParam('cachedir', $settings->_cacheDir);
	$view->setParam('previewWidthList', $settings->_previewWidthList);
	$view->setParam('timeout', $settings->_cmdTimeout);
	//meto lo que yo calcule
	$view->setParam('terminos', $terminos);
	$view->setParam('resultados', $resArr);
	$view->setParam('totalPages', $totalPages);
	$view->setParam('searchTime', $searchTime);

	$view($_GET);
	exit;
}


?>
