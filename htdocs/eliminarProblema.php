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

//////////////// MAIN ///////////////
  //echo "valores: ".$valores;
 $problemaEliminar=$_POST["attributes"];
 $problema=$problemaEliminar[6][0];
$conDelimitador="*".$problema;
$atributoProblema=$dms->getAttributeDefinitionByName("Problema jurídico");  
$valores=$atributoProblema->getValueSet();
$final=str_replace($conDelimitador,"",$valores);
$atributoProblema->setValueSet($final);
//echo "TERMINADO";
 header("Location: /out/out.GestionProblemasJuridicos.php?eliminado=1");

?>
