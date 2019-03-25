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

function getNonConfoResponsibles(){

	global $db;
	
	$queryStr = "SELECT * FROM tblNonconfoResponsibles";
	$ret = $db->getResultArray($queryStr);
	return $ret;
}

function addNonConfoResponsible($nonconformityId, $userId){

	global $db,$user;

	$queryStr = "INSERT INTO tblNonconfoResponsibles (nonconformityId, userId, createdBy) VALUES ".
		"(".$nonconformityId.", ".$userId.", ".$user->getID().")";
	
	$ret = $db->getResult($queryStr);
	return $ret;
}

function getNonConfoResponsible($nonconfoId){

	if (!is_numeric($nonconfoId)) return false;

	global $db;
	
	$queryStr = "SELECT * FROM tblNonconfoResponsibles WHERE nonconformityId = " . (int) $nonconfoId;
	$ret = $db->getResultArray($queryStr);
	
	if (is_bool($ret) && $ret == false) return false;
	else if (count($ret) <= 0) return false;
		
	return $ret;	
}

function delNonConfoResponsible($id){

	if (!is_numeric($id)) return false;
	
	global $db;
	
	$queryStr = "DELETE FROM tblNonconfoResponsibles WHERE id = " . (int) $id;
	$ret = $db->getResult($queryStr);	
	return $ret;
}

?>
