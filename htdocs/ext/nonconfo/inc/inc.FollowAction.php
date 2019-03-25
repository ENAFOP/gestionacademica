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

// DB //////////////////////////////////////////////////////////////////////////

function getAllActionsFollows(){

	global $db;
	
	$queryStr = "SELECT * FROM tblActionsFollows";
	$ret = $db->getResultArray($queryStr);

	return $ret;
}

function getActionFollowById($actionId){

	global $db;
	
	$queryStr = "SELECT * FROM tblActionsFollows WHERE actionId = ".(int) $actionId;
	$ret = $db->getResultArray($queryStr);

	if (is_bool($ret) && $ret == false) return false;
	else if (count($ret) <= 0) return false;

	return $ret;
}

function addActionFollow($actionId, $realDateEnd, $followResult, $indicatorBefore, $indicatorAfter, $finalStatus){

	global $db,$user;

	$realDate = strtotime($realDateEnd);

	$queryStr = "INSERT INTO tblActionsFollows (actionId, realDateEnd, followResult, indicatorBefore, indicatorAfter, finalStatus, createdBy) VALUES ".
		"(".$actionId.", ".$realDate.", \"".$followResult."\", \"".$indicatorBefore."\", \"".$indicatorAfter."\", \"".$finalStatus."\", ".$user->getID().")";
	
	$ret = $db->getResult($queryStr);
	
	if(is_bool($ret) && $ret) {
		$id = $db->getInsertID($queryStr);
	} else {
		$id = 0;
	}
	
	return $id;
}

function delActionFollow($id){

	if (!is_numeric($id)) return false;
	
	global $db;
	
	$queryStr = "DELETE FROM tblActionsFollows WHERE id = " . (int) $id;
	$ret = $db->getResult($queryStr);	
	return $ret;
}


?>
