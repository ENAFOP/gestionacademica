<?php
////// SE LLAMA DESDE el JS checkRegistro.js; mediante llamada Ajax. COmprueba si un nombre de usuario existe en la BD, devuelve true si existe o false si no (o sea, el nombre está disponible y se puede tomar)
header("Content-type:application/json");
include("./inc/inc.Settings.php");
include("./inc/inc.Utils.php");
include("./inc/inc.Init.php");
include("./inc/inc.DBInit.php");
/////////////////////////////////////////////////////////////////////////////////////////////////////////// MAIN ////////////////////////////////////////////////////////////////////////////////////////////////
$respuesta=array(); //devuelvo un array con dos elementos: cantidad y nombre del productom o item a consutlar
$idItem = $_GET['id']; //obtengo el id del ítem

											  
$settings = new Settings(); //acceder a parámetros de settings.xml con _antes
$driver=$settings->_dbDriver;
$host=$settings->_dbHostname;
$user=$settings->_dbUser;
$pass=$settings->_dbPass;
$base=$settings->_dbDatabase;
$manejador=new SeedDMS_Core_DatabaseAccess($driver,$host,$user,$pass,$base);
  $estado=$manejador->connect();
  //echo "Conectado: ".$estado;
  if($estado!=1)
  {
    echo "comprobarExistencias.php: Error: no se pudo conectar a la BD para modificar a ";
	exit;
  } 
 
    $consultarCantidad="SELECT cantidad_actual FROM app_item WHERE id=$idItem;";
     $consultarNombre="SELECT nombre FROM app_item WHERE id=$idItem;";
	//echo "Consultar: ".$consultar;
	 $resultado1=$manejador->getResultArray($consultarCantidad);
	 if(!$resultado1)
	 {
		$respuesta=false;
	 }
	 $resultado2=$manejador->getResultArray($consultarNombre);		  

	 $cantidad=$resultado1[0]['cantidad_actual'];
	 $nom=$resultado2[0]['nombre'];
	 array_push($respuesta, $cantidad);
	 array_push($respuesta, $nom);
echo json_encode($respuesta);
?>