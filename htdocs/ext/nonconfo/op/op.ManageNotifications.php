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
include("../../../inc/inc.LogInit.php");
include("../../../inc/inc.Utils.php");
include("../../../inc/inc.Language.php");
include("../inc/inc.NonConfoLanguages.php");
include("../../../inc/inc.Init.php");
include("../../../inc/inc.Extension.php");
include("../../../inc/inc.DBInit.php");
include("../../../inc/inc.ClassUI.php");
include("../inc/inc.ProcessOwners.php");
include("../inc/inc.Process.php");
include("../inc/inc.Nonconformities.php");
include("../inc/inc.NonConfoResponsibles.php");
include("op.NonConfoNotifications.php");
include("../../../inc/inc.Authentication.php");

if ($user->isGuest()) {
	UI::exitError(getMLText("nonconfo_title"),getMLText("access_denied"));
}

if (!isset($_GET['action'])) {
	UI::exitError(getMLText("nonconfo_title"),getMLText("nonconfo_invalid_id"));
}

if (!isset($_GET['nonconfoId'])) {
	UI::exitError(getMLText("nonconfo_title"),getMLText("nonconfo_invalid_id"));
}

if (!isset($_GET['processId'])) {
	UI::exitError(getMLText("nonconfo_title"),getMLText("nonconfo_no_process_selected"));
}

if (!$settings->_enableEmail) {
	$session->setSplashMsg(array('type'=>'error', 'msg'=>getMLText('nonconfo_send_error')));
	
	header("Location:../out/out.ViewNonConfo.php?nonconfoId=".$_GET['nonconfoId']);
	die();
}

$action = $_GET['action'];
switch ($action) {
	case '1': // For request approbations

		$process = getProcess($_GET['processId']);
		$nonconfo = getNonConfo($_GET['nonconfoId']);
		$notify = sendNotificationRequestApprobation($nonconfo['createdBy'], $process['name'], $_GET['nonconfoId']);

		$session->setSplashMsg(array('type'=>'success', 'msg'=>getMLText('nonconfo_send_success')));

		header("Location:../out/out.ViewNonConfo.php?nonconfoId=".$_GET['nonconfoId']);

		break;

	case '2': // For notify appobation

		$owners = getOwnersByProcess($_GET['processId']);
		$process = getProcess($_GET['processId']);
		if (count($owners) != 0) {
			if (count($owners) > 1) {
				foreach ($owners as $owner) {
					sendNotificationApprovedActions($owner['userId'], $process['name'], $_GET['nonconfoId']);
				}
			} else if (count($owners) == 1) {
				sendNotificationApprovedActions($owners[0]['userId'], $process['name'], $_GET['nonconfoId']);
			}

			$session->setSplashMsg(array('type'=>'success', 'msg'=>getMLText('nonconfo_send_success')));
		}

		header("Location:../out/out.ViewNonConfo.php?nonconfoId=".$_GET['nonconfoId']);

		break;

	case '3': // For notify desapprobation

		$owners = getOwnersByProcess($_GET['processId']);
		$process = getProcess($_GET['processId']);
		$nonconfo = getNonConfo($_GET['nonconfoId']);
		if (count($owners) != 0) {
			if (count($owners) > 1) {
				foreach ($owners as $owner) {
					sendNotificationDisapproveActions($owner['userId'], $process['name'], $nonconfo);
				}
			} else if (count($owners) == 1) {
				sendNotificationDisapproveActions($owners[0]['userId'], $process['name'], $nonconfo);
			}

			$session->setSplashMsg(array('type'=>'success', 'msg'=>getMLText('nonconfo_send_success')));
		}

		header("Location:../out/out.ViewNonConfo.php?nonconfoId=".$_GET['nonconfoId']);

		break;

		default:
			if (!isset($_GET['action'])) {
				UI::exitError(getMLText("nonconfo_title"),getMLText("nonconfo_invalid_id"));
			}
		break;
}



