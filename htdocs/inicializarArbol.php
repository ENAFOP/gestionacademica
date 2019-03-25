<?php
header("Content-type:application/json");
include("./inc/inc.Settings.php");
include("./inc/inc.Utils.php");
include("./inc/inc.Init.php");
include("./inc/inc.DBInit.php");

/////////////////////////////////////////////////////////////////////////////////////////////////////////// MAIN ////////////////////////////////////////////////////////////////////////////////////////////////
//contenedores
//$start = microtime(true);
$myArray=array();
 $tipologias=$dms->getUsedCategories();
    foreach ($tipologias as $tipo) 
    {
      $idTipologia=$tipo->getID();
      $nombreTipologia=$tipo->getName();
      //echo "analizando tipologia: ".$nombreTipologia;
	   $nivel2=array("id" => $idTipologia, "text" => $nombreTipologia, "icon" => "/images/tegSmall.png");
	   $myArray[]=$nivel2;
    }

echo json_encode($myArray);
?>