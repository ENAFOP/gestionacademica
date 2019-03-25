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

function getProcesses(){

	global $db;

	//$date = mktime(12,0,0, $month, $day, $year);
	
	$queryStr = "SELECT * FROM tblProcesses";
	$ret = $db->getResultArray($queryStr);
	return $ret;
}

function addProcess($name){

	global $db,$user;

	$queryStr = "INSERT INTO tblProcesses (name, createdBy) VALUES ".
		"(".$db->qstr($name).", ".$user->getID().")";
	
	$ret = $db->getResult($queryStr);
	return $ret;
}

function getProcess($id){

	if (!is_numeric($id)) return false;

	global $db;
	
	$queryStr = "SELECT * FROM tblProcesses WHERE id = " . (int) $id;
	$ret = $db->getResultArray($queryStr);
	
	if (is_bool($ret) && $ret == false) return false;
	else if (count($ret) <= 0) return false;
		
	return $ret[0];	
}

function editProcess($id, $name){

	if (!is_numeric($id)) return false;

	global $db, $user;
	
	$queryStr = "UPDATE tblProcesses SET name = \"".$name."\", modified = ".$db->getCurrentTimestamp().", modifiedBy = ".$user->getID()." WHERE id = ".(int) $id;

	$ret = $db->getResult($queryStr);	
	return $ret;
}

function delProcess($id){

	if (!is_numeric($id)) return false;
	
	global $db;
	
	$queryStr = "DELETE FROM tblProcesses WHERE id = " . (int) $id;
	$ret = $db->getResult($queryStr);	
	return $ret;
}

?>
