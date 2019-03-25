<?php
/**
 * Implementation of MyDocuments view
 *
 * @category   DMS
 * @package    SeedDMS
 * @license    GPL 2
 * @version    @version@
 * @author    José Mario López Leiva
 * @copyright  Copyright (C) 2017 José Mario López Leiva
 *             marioleiva2011@gmail.com    
        San Salvador, El Salvador, Central America

/**
 * Class which outputs the html page for MyDocuments view
 *
 * @category   DMS
 * @package    SeedDMS
 * @author     Markus Westphal, Malcolm Cowe, Uwe Steinmann <uwe@steinmann.cx>
 * @copyright  Copyright (C) 2002-2005 Markus Westphal,
 *             2006-2008 Malcolm Cowe, 2010 Matteo Lucarelli,
 *             2010-2012 Uwe Steinmann
 * @version    Release: @package_version@
 */
 /**
 Función que muestra los documentos próximos a caducar de todos los usuarios
 mostrarTodosDocumentos(lista_usuarios,dias)
 -dias: documentos que van a caducar dentro de cúantos días
 */
 header('Content-Type: text/html; charset=utf-8' );
   include("./inc/inc.Settings.php");
include("./inc/inc.LogInit.php");
include("./inc/inc.Utils.php");
include("./inc/inc.Language.php");
include("./inc/inc.Init.php");
include("./inc/inc.Extension.php");
include("./inc/inc.DBInit.php");
include("./inc/inc.Authentication.php");
include("./inc/inc.ClassUI.php");

/*function ingresarProblema($problema) //ddodo un id de documento que ha sido revocada la reserva,
//me da la fecha de la resolución del IAIP
{
  $resultado=array();
  //echo "Función getDefaultUserFolder. Se ha pasado con argumento: ".$id_usuario;
  
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
    UI::exitError(getMLText("document_title", array("documentname" => getMLText("invalid_doc_id"))),getMLText(".GestionProblemasJuridicos: No se pudo conectar a la BD"));
  } 
  //query de consulta:
  $miQuery="SELECT fechaResolucion FROM seeddms.revocacionreservas WHERE idDocumento=".$documento;
  //echo "mi query: ".$miQuery;
  $resultado=$manejador->getResult($miQuery);
  //echo "fecha= ".$fecha;
    if(!$resultado)
  {
    UI::exitError(getMLText("document_title", array("documentname" => getMLText("invalid_doc_id"))),getMLText("Indice desclasificados: Parece ser que hubo un error obteniendo la fecha de revocación de la reserva del documento."));
  }
  $fecha=$resultado[0]['fechaResolucion'];
  //echo "id_folder: ".$id_folder;
  return $fecha;
}*/
//////////////// MAIN ///////////////
 $separador="*"; //separador que es el primer elemento del string
  $atributoProblema=$dms->getAttributeDefinitionByName("Problema jurídico");
  
  $valores=$atributoProblema->getValueSet();
  //echo "valores: ".$valores;
 $problema=$_POST["nuevoProblema"];
 $conSeparador=$separador.$problema;
 $final=$valores.$conSeparador;
 //echo "con spearados ingresado: ".$conSeparador;
 $atributoProblema->setValueSet($final);
 header("Location: /out/out.GestionProblemasJuridicos.php?subido=1");
?>
