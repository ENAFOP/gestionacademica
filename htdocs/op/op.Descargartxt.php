<?php

include("../inc/inc.Settings.php");
include("../inc/inc.LogInit.php");
include("../inc/inc.Language.php");
include("../inc/inc.Utils.php");
include("../inc/inc.Init.php");
include("../inc/inc.Extension.php");
include("../inc/inc.DBInit.php");
include("../inc/inc.ClassUI.php");
include("../inc/inc.ClassController.php");
include("../inc/inc.Authentication.php");
include('../class.pdf2text.php');

$tmp = explode('.', basename($_SERVER['SCRIPT_FILENAME']));
$controller = Controller::factory($tmp[1]);
if (isset($_GET["version"])) 
{
	// document download
	if (!isset($_GET["documentid"]) || !is_numeric($_GET["documentid"]) || intval($_GET["documentid"])<1) {
		UI::exitError(getMLText("document_title", array("documentname" => getMLText("invalid_doc_id"))),getMLText("invalid_doc_id"));
	}

	$documentid = $_GET["documentid"];
	$document = $dms->getDocument($documentid);
	$nombreCabecera=$document->getName().".txt";
	header('Content-Type: "text/plain"');
    header("Content-Disposition: attachment; filename=$nombreCabecera");
    header("Content-Transfer-Encoding: binary"); 
    header('Pragma: no-cache'); 

	if (!is_object($document)) {
		UI::exitError(getMLText("document_title", array("documentname" => getMLText("invalid_doc_id"))),getMLText("invalid_doc_id"));

	}
    //echo "Nombre del documento: ".$document->getName();
	$contenido=$document->getLatestContent();
	$offsetDir=$settings->_contentOffsetDir;
	$contentDir = $settings->_contentDir;
	$pathParcial=$contentDir.$offsetDir;
	$fullPath=$contentDir.$offsetDir."/".$contenido->getPath();
//echo "Path: ".$fullPath;
$a = new PDF2Text();
$a->setFilename($fullPath); 
$a->decodePDF();
$crudo=$a->output(); 
$formateado=utf8_encode($crudo);
//echo $formateado;
//ya tengo la data en txt, ahora solo creo el nuevo fichero
$nombreFichero=$pathParcial."/".$document->getName().".txt";
//$namecito=$document->getName()."txt";
$myfile = fopen($nombreFichero, "w") or die("Error técnico: Imposible crear el fichero txt ".$nombreFichero);
fwrite($myfile, $formateado);
    fclose($myfile);
    //header('Content-Description: Descarga de resolución del TEG en txt');
   
    // Send the file contents.
   // set_time_limit(0);
    /////////////////////////////////////////////////////////////////////////////
    ob_end_clean();

    
    readfile($nombreFichero);
	//echo "Terminado";
	//unlink($nombreFichero);
	exit;
} 