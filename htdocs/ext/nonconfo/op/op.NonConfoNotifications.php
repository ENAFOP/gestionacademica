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

function sendNotificationNonconfoAdded($id, $nonconfoId, $process){
	global $db, $dms, $user, $notifier, $settings;

	$sender = "dms@gestiontotal.net";
	$user = $dms->getUser($id);

	$subject = "nonconfo_request_review_email_subject";
	$message = "nonconfo_review_request_email_body";
	$params = array();
	$params['process'] = $process;
	$params['username'] = $user->getFullName();
	$params['url'] = "http".((isset($_SERVER['HTTPS']) && (strcmp($_SERVER['HTTPS'],'off')!=0)) ? "s" : "")."://".$_SERVER['HTTP_HOST'].$settings->_httpRoot."ext/nonconfo/out/out.ViewNonConfo.php?nonconfoId=".$nonconfoId;

	$notifier->toIndividual($sender, $user, $subject, $message, $params);
}

function sendNotificationRequestApprobation($id, $processName, $nonconfoId){
	global $db, $dms, $user, $notifier, $settings;

	$sender = "dms@gestiontotal.net";
	$user = $dms->getUser($id);

	$subject = "nonconfo_request_approbation";
	$message = "nonconfo_request_approbation_email_body";
	$params = array();
	$params['process'] = $processName;
	$params['username'] = $user->getFullName();
	$params['url'] = "http".((isset($_SERVER['HTTPS']) && (strcmp($_SERVER['HTTPS'],'off')!=0)) ? "s" : "")."://".$_SERVER['HTTP_HOST'].$settings->_httpRoot."ext/nonconfo/out/out.ViewNonConfo.php?nonconfoId=".$nonconfoId;

	$notifier->toIndividual($sender, $user, $subject, $message, $params);
}

function sendNotificationApprovedActions($ownerId, $processName, $nonconfoId){
	global $db, $dms, $user, $notifier, $settings;

	$sender = "dms@gestiontotal.net";
	$user = $dms->getUser($ownerId);

	$subject = "nonconfo_notify_approbation";
	$message = "nonconfo_notify_approbation_email_body";
	$params = array();
	$params['process'] = $processName;
	$params['username'] = $user->getFullName();
	$params['url'] = "http".((isset($_SERVER['HTTPS']) && (strcmp($_SERVER['HTTPS'],'off')!=0)) ? "s" : "")."://".$_SERVER['HTTP_HOST'].$settings->_httpRoot."ext/nonconfo/out/out.ViewNonConfo.php?nonconfoId=".$nonconfoId;

	$notifier->toIndividual($sender, $user, $subject, $message, $params);
}

function sendNotificationDisapproveActions($ownerId, $processName, $nonconfo) {
	global $db, $dms, $user, $notifier, $settings;

	$sender = "dms@gestiontotal.net";
	$userOwner = $dms->getUser($ownerId);
	$nonconfouser = $dms->getUser($nonconfo['createdBy']);

	$subject = "nonconfo_notify_desapprobation";
	$message = "nonconfo_notify_desapprobation_email_body";
	$params = array();
	$params['process'] = $processName;
	$params['username'] = $userOwner->getFullName();
	$params['url'] = "http".((isset($_SERVER['HTTPS']) && (strcmp($_SERVER['HTTPS'],'off')!=0)) ? "s" : "")."://".$_SERVER['HTTP_HOST'].$settings->_httpRoot."ext/nonconfo/out/out.ViewNonConfo.php?nonconfoId=".$nonconfo['id'];

	$notifier->toIndividual($sender, $userOwner, $subject, $message, $params);
}