<?php
include("../inc/inc.ClassSettings.php");

function usage() { /* {{{ */
	echo "Usage:\n";
	echo "  seeddms-importeg [--config <file>] [-h] [-v] -f <filename>\n";
	echo "\n";
	echo "Description:\n";
	echo "  This program imports CSV data for TEG resolutions.\n";
	echo "\n";
	echo "Options:\n";
	echo "  -h, --help: print usage information and exit.\n";
	echo "  -v, --version: print version and exit.\n";
	echo "  --config: set alternative config file.\n";
	echo "  -f <filename>: CSV file with TEG resolutions data\n";
	echo "  -e <encoding>: encoding used by filesystem (defaults to iso-8859-1)\n";
} /* }}} */

function update_attribute($id, $docid, $value) {
	global $db;
	
	$exists = false;
	$sentence = "";
	
	if(!empty($docid) && !empty($id)) {
	
		$query = "SELECT * FROM `tblDocumentAttributes` WHERE `document` = $docid AND `attrdef` = $id;";
		
		$resArr = $db->getResultArray($query);
		
		if (is_bool($resArr) && $resArr == false)
			$exists = false;
		else
			$exists = true;
	
		if(!$resArr)
			$exists = false;
		else
			$exists = true;
	
		if($exists) {
			if($value != $resArr[0]["value"]) {
				$sentence = "UPDATE `tblDocumentAttributes` SET `value` = ".$db->qstr($value)." WHERE `document` = $docid AND `attrdef` = $id;";
			}
		} else {
				$sentence = "INSERT INTO `tblDocumentAttributes`(`document`, `attrdef`, `value`) VALUES (".$docid.", ".$id.", ".$db->qstr($value).");";
		}
		
		if(!empty($sentence)) {
			echo $sentence."\n";
			$res = $db->getResult($sentence);
			if (!$res)
				return false;
		}
	}
	
	return true;
}

$version = "0.0.1";
$shortoptions = "d:f:hv";
$longoptions = array('help', 'version', 'config:');
if(false === ($options = getopt($shortoptions, $longoptions))) {
	usage();
	exit(0);
}

/* Print help and exit */
if(!$options || isset($options['h']) || isset($options['help'])) {
	usage();
	exit(0);
}

/* Print version and exit */
if(isset($options['v']) || isset($options['verѕion'])) {
	echo $version."\n";
	exit(0);
}

/* Set encoding of names in filesystem */
$fsencoding = 'iso-8859-1';
if(isset($options['e'])) {
	$fsencoding = $options['e'];
}

/* Set alternative config file */
if(isset($options['config'])) {
	$settings = new Settings($options['config']);
} else {
	$settings = new Settings();
}

if(isset($settings->_extraPath))
	ini_set('include_path', $settings->_extraPath. PATH_SEPARATOR .ini_get('include_path'));

require_once("SeedDMS/Core.php");

$filename = '';
if(isset($options['f'])) {
	$filename = $options['f'];
} else {
	usage();
	exit(1);
}

$db = new SeedDMS_Core_DatabaseAccess($settings->_dbDriver, $settings->_dbHostname, $settings->_dbUser, $settings->_dbPass, $settings->_dbDatabase);
$db->connect() or die ("Could not connect to db-server \"" . $settings->_dbHostname . "\"");
$db->_debug = 0;


$dms = new SeedDMS_Core_DMS($db, $settings->_contentDir.$settings->_contentOffsetDir);
if(!$dms->checkVersion()) {
	echo "Database update needed.";
	exit;
}

//echo $settings->_contentDir.$settings->_contentOffsetDir."\n";

$dms->setRootFolderID($settings->_rootFolderID);
$dms->setMaxDirID($settings->_maxDirID);
$dms->setEnableConverting($settings->_enableConverting);
$dms->setViewOnlineFileTypes($settings->_viewOnlineFileTypes);

/* Create a global user object */
$user = $dms->getUser(1);

$row = 1;
if (($handle = fopen($filename, "r")) !== FALSE) {
    while (($data = fgetcsv($handle)) !== FALSE) {
        $num = count($data);
        //echo "<p> $num fields in line $row: <br /></p>\n";
        $row++;
        
        if($row > 1) {
	        $obj = new StdClass();
	        $categories = array();
	        
	        $obj->id = isset($data[0]) ? $data[0] : '';
	        $obj->type = isset($data[1]) ? $data[1] : '';
	        $obj->year = isset($data[2]) ? $data[2] : '';
	        $obj->reference = isset($data[3]) ? $data[3] : '';
	        $obj->date = isset($data[4]) ? $data[4] : '';
	        $obj->old_tesaurus = isset($data[5]) ? $data[5] : '';
	        $obj->problem = isset($data[6]) ? $data[6] : '';
	        $obj->fundament = isset($data[7]) ? $data[7] : '';
	        $obj->decision = isset($data[8]) ? $data[8] : '';
	        $obj->duty = isset($data[9]) ? $data[9] : '';
	        $obj->prohibition = isset($data[10]) ? $data[10] : '';
	        $obj->law = isset($data[11]) ? $data[11] : '';
	        $obj->new_tesaurus = isset($data[12]) ? $data[12] : '';
	        $obj->tesaurus = isset($data[13]) ? $data[13] : '';
	        
	        $cats = explode(',', $obj->tesaurus);
	        
	        foreach($cats as $cat) {
		        $catObj = $dms->getDocumentCategory($cat);
		        if($catObj) {
			        $categories[] = $catObj;
		        }
	        }
	     
	     	$doc = $dms->getDocument($obj->id);
	     	
	     	if(count($categories) > 0 && !is_bool($doc)) {
	     		$doc->setCategories($categories);
	     	}
	     	
	     	update_attribute(13, $obj->id, $obj->type);
	     	update_attribute(14, $obj->id, $obj->year);
	//     	update_attribute(13, $obj->id, $obj->reference);
	     	update_attribute(1, $obj->id, $obj->date);
	     	update_attribute(6, $obj->id, $obj->problem);
	     	update_attribute(7, $obj->id, $obj->fundament);
	     	update_attribute(8, $obj->id, $obj->decision);
	     	update_attribute(17, $obj->id, $obj->law);
	     	
	     	if($obj->law = 'Vigente') {
		     	update_attribute(15, $obj->id, $obj->duty);
		     	update_attribute(16, $obj->id, $obj->prohibition);
	     	} else {
		     	update_attribute(4, $obj->id, $obj->duty);
		     	update_attribute(5, $obj->id, $obj->prohibition);	     	
	     	}
	 	}
    } // END WHILE
    fclose($handle);
}

