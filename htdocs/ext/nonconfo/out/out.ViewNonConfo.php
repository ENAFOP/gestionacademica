<?php
//    Copyright (C) 2017 Multisistemas e Inversiones S.A. de C.V.
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
include("../../../inc/inc.Settings.php");
include("../../../inc/inc.Language.php");
include("../inc/inc.NonConfoLanguages.php");
include("../../../inc/inc.Init.php");
include("../../../inc/inc.Extension.php");
include("../../../inc/inc.DBInit.php");
include("../../../inc/inc.ClassUI.php");
include("../inc/inc.Process.php");
include("../inc/inc.ProcessOwners.php");
include("../inc/inc.Nonconformities.php");
include("../inc/inc.NonConfoAnalysis.php");
include("../inc/inc.NonConfoAction.php");
include("../inc/inc.FollowAction.php");
include("../inc/inc.ActionComment.php");
include("../../../inc/inc.Authentication.php");

if ($user->isGuest()) {
	UI::exitError(getMLText("nonconfo_view_nonconfo"),getMLText("access_denied"));
}
if (!isset($_GET['nonconfoId'])) {
	UI::exitError(getMLText("nonconfo_view_nonconfo"),getMLText("nonconfo_invalid_id"));
}
if(isset($_GET['operation'])) {
	$operation = $_GET['operation'];
} else {
	$operation = 'add';
}
$nonconfo = getNonConfo($_GET['nonconfoId']);
if (is_bool($nonconfo) && $nonconfo == false) {
	UI::exitError(getMLText("nonconfo_view_nonconfo"),getMLText("nonconfo_not_exists"));
}
// Get all users
$allUsers = $dms->getAllUsers($settings->_sortUsersInList);
// Get the analysis for the nonconfo
$analysis = getNonConfoAnalysisByNonconfoId($_GET['nonconfoId']);
if(!empty($analysis)) {
	$operation = 'edit';
}

$process = getProcess($nonconfo['processId']);
$actions = getNonConfoActions($_GET['nonconfoId']);
$processOwners = getAllProcessOwners($nonconfo['processId']);


$actionsFollows = array();
$actionsComments = array();

if (false != $actions && count($actions) > 0) {
	for ($i=0; $i < count($actions); $i++) { 
		array_push($actionsFollows, getActionFollowById($actions[$i]['id']));
	}

	for ($i=0; $i < count($actions); $i++) { 
		array_push($actionsComments, getActionCommentByActionId($actions[$i]['id']));
	}
}

$tmp = explode('.', basename($_SERVER['SCRIPT_FILENAME']));
$view = UI::factory($theme, $tmp[1], array('dms'=>$dms, 'user'=>$user));
if($view) {
	$view->setParam('nonconfo', $nonconfo);
	$view->setParam('process', $process);
	$view->setParam('allUsers', $allUsers);
	$view->setParam('analysis', $analysis);
	$view->setParam('actions', $actions);
	$view->setParam('operation', $operation);
	$view->setParam('processOwners', $processOwners);
	$view->setParam('actionsFollows', $actionsFollows);
	$view->setParam('actionsComments', $actionsComments);
	$view($_GET);
	exit;
}
?>