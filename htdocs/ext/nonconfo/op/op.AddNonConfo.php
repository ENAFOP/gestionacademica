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
	UI::exitError(getMLText("nonconfo_add_nonconfo"),getMLText("access_denied"));
}

/* Check if the form data comes from a trusted request */
if(!checkFormKey('addnonconfo')) {
	UI::exitError(getMLText("nonconfo_add_nonconfo"),getMLText("invalid_request_token"));
}

if ($_POST['processId'] == -1) {
	UI::exitError(getMLText("nonconfo_add_nonconfo"),getMLText("nonconfo_no_process_selected"));
}

if ($_POST['type'] == -1) {
	UI::exitError(getMLText("nonconfo_add_nonconfo"),getMLText("nonconfo_no_type_selected"));
}

$res = addNonconformity($_POST['correlative'], $_POST['processId'], $_POST['type'], $_POST['source'], $_POST['description']);

if ($res == 0 || empty($res)) {
	UI::exitError(getMLText("nonconfo_add_nonconfo"),getMLText("error_occured"));
}

if($settings->_enableEmail) {
	if ($res != 0) {
		$owners = getOwnersByProcess($_POST['processId']);
		$process = getProcess($_POST['processId']);
		if ($owners == false || $process == false) {
			$session->setSplashMsg(array('type'=>'error', 'msg'=>getMLText('nonconfo_non_owner_exists')));
			header("Location:../out/out.ViewNonConfo.php?nonconfoId=".$res);
			die();
		} else {
		
			if (count($owners) != 0) {
				if (count($owners) > 1) {
					foreach ($owners as $owner) {
						$resp = addNonConfoResponsible($res, $owner['userId']);
						sendNotificationNonconfoAdded($owner['userId'], $res, $process['name']);
					}
				} else if (count($owners) == 1) {
					$resp = addNonConfoResponsible($res, $owners[0]['userId']);
					sendNotificationNonconfoAdded($owners[0]['userId'], $res, $process['name']);
				}
			}
		}
	}
} else {
	$session->setSplashMsg(array('type'=>'error', 'msg'=>getMLText('nonconfo_send_error')));
	header("Location:../out/out.ViewNonConfo.php?nonconfoId=".$res);
	die();
}

$session->setSplashMsg(array('type'=>'success', 'msg'=>getMLText('nonconfo_added_success')));

header("Location:../out/out.ViewNonConfo.php?nonconfoId=".$res);

?>
