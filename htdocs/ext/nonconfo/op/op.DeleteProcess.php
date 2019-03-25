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
include("../inc/inc.Process.php");
include("../../../inc/inc.Authentication.php");

if ($user->isGuest()) {
	UI::exitError(getMLText("nonconfo_delete_process"),getMLText("access_denied"));
}

if (!isset($_REQUEST["id"])) {
	UI::exitError(getMLText("nonconfo_delete_process"),getMLText("error_occured"));
}

header("Cache-Control: no-cache,no-store");

$command = $_REQUEST["command"];

switch ($command) {
	case 'deleteprocess':
		if(!checkFormKey('removeprocess', 'GET')) {
				header('Content-Type: application/json');
				echo json_encode(array('success'=>false, 'message'=>getMLText('invalid_request_token'), 'data'=>''));
			} else {
				$id = $_REQUEST["id"];

				$res = delProcess($id);
				                                
				if (is_bool($res) && !$res) {
					header('Content-Type: application/json');
					echo json_encode(array('success'=>false, 'message'=>getMLText('nonprocess_process_delete_error'), 'data'=>''));
				}

				header('Content-Type: application/json');
				echo json_encode(array('success'=>true, 'message'=>getMLText('nonconfo_delete_process_success'), 'data'=>''));
				add_log_line();
			}
		break;
}

?>
