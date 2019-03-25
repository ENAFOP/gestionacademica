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

function getNonconformities(){

	global $db;
	
	$queryStr = "SELECT * FROM tblNonconformities";
	$ret = $db->getResultArray($queryStr);
	return $ret;
}

function addNonconformity($correlative, $processId, $type, $source, $description){

	global $db,$user;

	$queryStr = "INSERT INTO tblNonconformities (correlative, processId, type, source, description, createdBy) VALUES ".
		"(\"".$correlative."\", ".$processId.", \"".$type."\", \"".$source."\", \"".$description."\",".$user->getID().")";
	
	$ret = $db->getResult($queryStr);
	
	if(is_bool($ret) && $ret) {
		$id = $db->getInsertID($queryStr);
	} else {
		$id = 0;
	}
	
	return $id;
}

function getNonconformity($id){

	global $db;
	
	$queryStr = "SELECT * FROM tblNonconformities WHERE id = ".$id;
	$ret = $db->getResultArray($queryStr);
	
	if (is_bool($ret) && $ret == false) return false;
	else if (count($ret) <= 0) return false;
		
	return $ret[0];	
}

function getNonConfo($id){
	
	global $db;
	
	$queryStr = "SELECT * FROM tblNonconformities WHERE id = ".$id;
	$ret = $db->getResultArray($queryStr);
	
	if (is_bool($ret) && $ret == false) return false;
	else if (count($ret) <= 0) return false;
		
	return $ret[0];
}

function editNonconformities($id, $source, $description){

	if (!is_numeric($id)) return false;

	global $db, $user;
	
	$queryStr = "UPDATE tblNonconformities SET source = \"".$source."\", description = \"".$description."\", modified = ".$db->getCurrentTimestamp().", modifiedBy = ".$user->getID()." WHERE id = ".(int) $id;

	$ret = $db->getResult($queryStr);	
	return $ret;
}

function getNonconformitiesByCreator($id){
	global $db;
	
	$queryStr = "SELECT * FROM tblNonconformities WHERE createdBy = ".$id;
	$ret = $db->getResultArray($queryStr);
	
	if (is_bool($ret) && $ret == false) return false;
	else if (count($ret) <= 0) return false;
	
	return $ret;
}

function getNonconformitiesByProcess($id){
	global $db;
	
	$queryStr = "SELECT * FROM tblNonconformities WHERE processId = ".$id;
	$ret = $db->getResultArray($queryStr);
	
	if (is_bool($ret) && $ret == false) return false;
	else if (count($ret) <= 0) return false;
	
	return $ret;
}

function delNonconformities($id){

	if (!is_numeric($id)) return false;
	
	global $db, $settings;

	$db->startTransaction();

	$queryStr1 = "SELECT * FROM `tblActions` WHERE `nonconformityId` = ".(int) $id; //Actions
	$actions = $db->getResultArray($queryStr1);

	// For action comments
	if (is_array($actions) && count($actions) > 0 && $actions != false) {
		for ($i=0; $i < count($actions); $i++) {
			$query1 = "SELECT * FROM `tblActionsComments` WHERE `actionId` = ".(int) $actions[$i]['id']; //Action
			$comment = $db->getResultArray($query1);
			if ($comment != null || $comment != false) {
				$query2 = "DELETE FROM `tblActionsComments` WHERE `actionId` = ".(int) $actions[$i]['id'];
				if (!$db->getResult($query2)) {
					$db->rollbackTransaction();
					return false;
				}	
			}
		}
	}

	// For action follows
	if (is_array($actions) && count($actions) > 0 && $actions != false) {
		for ($i=0; $i < count($actions); $i++) {
			$queryStr2 = "SELECT * FROM `tblActionsFollows` WHERE `actionId` = ".(int) $actions[$i]['id']; //Action
			$follow = $db->getResultArray($queryStr2);
			if ($follow != null || $follow != false) {
				$queryStr3 = "DELETE FROM `tblActionsFollows` WHERE `actionId` = ".(int) $actions[$i]['id'];
				if (!$db->getResult($queryStr3)) {
					$db->rollbackTransaction();
					return false;
				}	
			}
		}
	}

	if (is_array($actions) && count($actions) > 0 && $actions != false) {
		$queryStr4 = "DELETE FROM `tblActions` WHERE `nonconformityId` = ".(int) $id; 
		if (!$db->getResult($queryStr4)) {
			$db->rollbackTransaction();
			return false;
		}	
	}

	$queryStr5 = "SELECT * FROM `tblNonconfoResponsibles` WHERE `nonconformityId` = ".(int) $id; // Responsibles
	$responsibles = $db->getResultArray($queryStr5);
	if (is_array($responsibles) && count($responsibles) > 0 && $responsibles != false) {
		$queryStr6 = "DELETE FROM `tblNonconfoResponsibles` WHERE `nonconformityId` = ".(int) $id;
		if (!$db->getResult($queryStr6)) {
			$db->rollbackTransaction();		
			return false;
		}
	}

	$queryStr7 = "SELECT * FROM `tblNonconfoAnalysis` WHERE `nonconformityId` = ".(int) $id;
	$analysis = $db->getResultArray($queryStr7);
	if (is_array($analysis) && count($analysis) > 0 && $analysis != false) {
		if ($analysis[0]['fileName'] != "") {
			$thefile = $settings->_contentDir . 'nonconfo/'. $analysis[0]['fileName'];
			if (file_exists($thefile)) {
				unlink($thefile);
			}
		}

		$queryStr8 = "DELETE FROM `tblNonconfoAnalysis` WHERE `nonconformityId` = ".(int) $id; // Analysis
		if (!$db->getResult($queryStr8)) {
			$db->rollbackTransaction();		
			return false;
		}
	}


	$queryStr9 = "DELETE FROM `tblNonconformities` WHERE id = " . (int) $id;
	$result = $db->getResult($queryStr9);
	if (!$result) {
		$db->rollbackTransaction();		
		return false;
	}

    $db->commitTransaction();
	return true;
}

function editNonConfo($id, $description){
	if (!is_numeric($id)) return false;

	global $db, $user;
	
	$queryStr = "UPDATE tblNonconformities SET description = \"".$description."\", modified = ".$db->getCurrentTimestamp().", modifiedBy = ".$user->getID()." WHERE id = ".(int) $id;

	$ret = $db->getResult($queryStr);	
	return $ret;
}

?>
