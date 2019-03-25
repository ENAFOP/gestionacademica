<?php

include("./inc/inc.Settings.php");
include("./inc/inc.Utils.php");
include("./inc/inc.Init.php");
include("./inc/inc.DBInit.php");
$name="";
$pk=""; //me dirá el numero de linea del fichero
$value="";  //nuevo contenido de la línea pk

if(isset($_POST['pk'])) //pk es el idenfiticador del elemento que yo puse en EditarEvento
{
  $pk=$_POST['pk'];
}
if(isset($_POST['name'])) //name es el nombre del campo en la base mysql
{
  $name=$_POST['name'];
}
if(isset($_POST['value'])) //value es el nuevo valor modificado por el usuario
{
  $value=$_POST['value'];
  //$value = iconv("UTF-8","windows-1250",$value);
}

$tmp = explode("_", $name);
$respuesta=false;
//echo "Fichero: ".$nombreFichero;
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
    echo "modificar ubicacion editable.php: Error: no se pudo conectar a la BD para modificar a ";
	exit;
  } 

  $modificar="UPDATE app_item SET $name = '$value' WHERE id=$pk;";
		  //echo "mi query modificargrado: ".$modificar;
		  $resultado1=$manejador->getResult($modificar);
		  if(!$resultado1)
		  {
			$respuesta=false;
		  }
?>