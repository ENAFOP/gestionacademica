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

function getAllNonConfoAnalysis(){
	global $db;
	
	$queryStr = "SELECT * FROM tblNonconfoAnalysis";
	$ret = $db->getResultArray($queryStr);
	return $ret;
}

function addNonConfoAnalysis($nonconfoId, $description, $fileName='', $mimeType=''){
	global $db,$user;
	$queryStr = "INSERT INTO tblNonconfoAnalysis (nonconformityId, comment, createdBy, fileName, mimeType) VALUES ".
		"($nonconfoId, '$description', ".$user->getID().", '$fileName', '$mimeType')";
	
	$ret = $db->getResult($queryStr);
	
	if(is_bool($ret) && $ret) {
		$id = $db->getInsertID($queryStr);
	} else {
		$id = 0;
	}
	
	return $id;
}

function getNonConfoAnalysis($id){
	global $db;
	
	$queryStr = "SELECT * FROM tblNonconfoAnalysis WHERE id = ".$id;
	
	$ret = $db->getResultArray($queryStr);
	
	if (is_bool($ret) && $ret == false) return false;
	else if (count($ret) <= 0) return false;
		
	return $ret[0];	
}

function getNonConfoAnalysisByNonconfoId($nonconfoid){
	global $db;
	
	$queryStr = "SELECT * FROM tblNonconfoAnalysis WHERE nonconformityId = ".$nonconfoid;
	
	$ret = $db->getResultArray($queryStr);
	
	if (is_bool($ret) && $ret == false) return false;
	else if (count($ret) <= 0) return false;
		
	return $ret[0];	
}

function editNonconfoAnalysis($id, $source, $description, $fileName='', $mimeType=''){
	if (!is_numeric($id)) return false;
	global $db, $user;
	
	$queryStr = "UPDATE tblNonconfoAnalysis SET comment = \"".$description."\", modified = ".$db->getCurrentTimestamp().", modifiedBy = ".$user->getID();
	
	if(!empty($fileName)) {
		$queryStr .= ", fileName = '$fileName'";
	}
	
	if(!empty($mimeType)) {
		$queryStr .= ", mimeType = '$mimeType'";
	}
	
	$queryStr .= " WHERE id = ".(int) $id;
	$ret = $db->getResult($queryStr);	
	return $ret;
}

function delNonconfoAnalysis($id){

	if (!is_numeric($id)) return false;
	
	global $db;
	
	$queryStr = "DELETE FROM tblNonconfoAnalysis WHERE id = " . (int) $id;
	$ret = $db->getResult($queryStr);	
	return $ret;
}

?>