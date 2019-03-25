<?php
//    MyDMS. Document Management System
//    Copyright (C) 2010-2016 Uwe Steinmann
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

require_once("../../../inc/inc.Settings.php");
require_once("../../../inc/inc.LogInit.php");
require_once("../../../inc/inc.Utils.php");
require_once("../../../inc/inc.Language.php");
require_once("../../../inc/inc.Init.php");
require_once("../../../inc/inc.Extension.php");
require_once("../../../inc/inc.Init.php");
require_once("../../../inc/inc.DBInit.php");
require_once("../../../inc/inc.ClassNotificationService.php");
require_once("../../../inc/inc.ClassEmailNotify.php");
require_once("../../../inc/inc.ClassUI.php");

require_once("../../../inc/inc.ClassSession.php");
require_once("../../../inc/inc.ClassPasswordStrength.php");
require_once("../../../inc/inc.ClassPasswordHistoryManager.php");

global $db, $dms;
/* Load session */
if (isset($_COOKIE["mydms_session"])) {
	$dms_session = $_COOKIE["mydms_session"];
	$session = new SeedDMS_Session($db);
	if(!$resArr = $session->load($dms_session)) {
		header('Content-Type: application/json');
		echo json_encode(array('error'=>1));
		exit;
	}

	/* Update last access time */
	$session->updateAccess($dms_session);

	/* Load user data */
	$user = $dms->getUser($resArr["userID"]);
	if (!is_object($user)) {
		header('Content-Type: application/json');
		echo json_encode(array('error'=>1));
		exit;
	}
	$dms->setUser($user);
	if($user->isAdmin()) {
		if($resArr["su"]) {
			$user = $dms->getUser($resArr["su"]);
		}
	}
	$notifier = new SeedDMS_NotificationService();
	if($settings->_enableEmail) {
		$notifier->addService(new SeedDMS_EmailNotify($dms));
	}
	include $settings->_rootDir . "languages/" . $resArr["language"] . "/lang.inc";
} else {
	$user = null;
}

/* make sure the browser doesn't cache the output of this page.
 * Edge doesn't if not explicitly told to not do it, see bug #280
 */
header("Cache-Control: no-cache,no-store");

if(isset($_SERVER['command'])) {
	$command = $_REQUEST['command'];

	switch($command) {
		case 'toggleanalysisedit': /* {{{ */
			$ps = new Password_Strength();
			$ps->set_password($_REQUEST["pwd"]);
			if($settings->_passwordStrengthAlgorithm == 'simple')
				$ps->simple_calculate();
			else
				$ps->calculate();
			$score = $ps->get_score();
			if($settings->_passwordStrength) {
				if($score >= $settings->_passwordStrength) {
					header('Content-Type: application/json');
					echo json_encode(array('error'=>0, 'strength'=>$score, 'score'=>$score/$settings->_passwordStrength, 'ok'=>1));
				} else {
					header('Content-Type: application/json');
					echo json_encode(array('error'=>0, 'strength'=>$score, 'score'=>$score/$settings->_passwordStrength, 'ok'=>0));
				}
			} else {
				header('Content-Type: application/json');
				echo json_encode(array('error'=>0, 'strength'=>$score));
			}
			break; /* }}} */
		}
}