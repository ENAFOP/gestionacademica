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
include("../../../inc/inc.Authentication.php");

if ($user->isGuest()) {
	UI::exitError(getMLText("nonconfo_add_owners"),getMLText("access_denied"));
}

// Get all process saved
$processes = getProcesses();

if ($processes == null || count($processes) <= 0) {
	UI::exitError(getMLText("nonconfo_add_owners"),getMLText("nonconfo_no_process"));
}

// Get all users
$allUsers = $dms->getAllUsers($settings->_sortUsersInList);

$tmp = explode('.', basename($_SERVER['SCRIPT_FILENAME']));

if(isset($_GET['processid']) && $_GET['processid']) {
	$selProcess = getProcess($_GET['processid']);
} else {
	$selProcess = null;
}

// Get process creator
if($selProcess != null) {
	$userCreator = $dms->getUser($selProcess["createdBy"]);
} else {
	$userCreator = null;
}

if ($selProcess != null) {
		$owners = getOwnersByProcess($selProcess["id"]);
} else {
		$owners = null;
}

$view = UI::factory($theme, $tmp[1], array('dms'=>$dms, 'user'=>$user));
if($view) {
	$view->setParam('processes', $processes);
	$view->setParam('selProcess', $selProcess);
	$view->setParam('allUsers', $allUsers);
	$view->setParam('userCreator', $userCreator);
	$view->setParam('owners', $owners);
	$view($_GET);
	exit;
}

?>
