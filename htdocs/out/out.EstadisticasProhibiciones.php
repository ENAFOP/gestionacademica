<?php
//    
//    Copyright (C) José Mario López Leiva. marioleiva2011@gmail.com_addre
//    September 2017. San Salvador (El Salvador)
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

include("../inc/inc.Settings.php");
include("../inc/inc.Language.php");
include("../inc/inc.Init.php");
include("../inc/inc.Extension.php");
include("../inc/inc.DBInit.php");
include("../inc/inc.ClassUI.php");
include("../inc/inc.Authentication.php");

//esta es una variable global y acceso a ella desde $GLOBALS
 /*
 FUNCION QUE RECIBE UNA CARPETA, CORRESPONDIENTE A UN DEPARAMENTO, Y CUENTA
 */
 //creado José Mario López Leiva
 /**
DEVUELVE EL ID DE USUARIO DADO UN ID DE FOLDER QUE ES EL HOME FOLDER
 **/


function getUserFromHomeFolder($id_folder) //dado un id de usuario, me devuelve el id del folder de inicio de ese usuario
{
	//echo "Función getDefaultUserFolder. Se ha pasado con argumento: ".$id_usuario;
	$idUsuario=0;
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
		echo "out.viewFolder.php[getUserFromHomeFolder]Error: no se pudo conectar a la BD ".$base;
		exit;
	}	
	//query de consulta:
	$miQuery="SELECT id FROM seeddms.tblusers WHERE homefolder=".$id_folder;
	//echo "mi query: ".$miQuery;
	$resultado=$manejador->getResultArray($miQuery);
	if($resultado==FALSE)
	{
		echo "out.viewFolder.php[getUserFromHomeFolder]Error: no se pudo  hacer la consulta ".$miQuery;
		exit;
	}
	//echo "pos cero:; ".print_r($resultado[1])."</br>";
	//$idUsuario=$resultado[0]['id'];
	//echo "id_folder: ".$id_folder;
	//print_r($resultado);
	return $idUsuario;
}
/**
FUNCION QUE DADO UN DIRECTORIO, ESCANEA TODOS SUS SUBFOLDERS Y CUENTA EL NUMERO DE ACTAS DE INEXISTENCIA
O DECLARATORIAS, SEGÚN EL ARGUMENTO tipo_documento
**/
function contarDocumentos($tipo_documento,$folder,$orderby)
{
	$contadorFinal=0;
	$stringDeclaratoriasReserva="Declaratorias de reserva";
$stringActas="Actas de inexistencia"; //string tal como aparece en la tabla tblcategory
    // un departamento es un folder, cada subfolder será un municipio
    //print "<p> Municipios del departamento de ".$departamento->getName()."</p>";
		$municipios=$folder->getSubFolders();
		foreach ($municipios as $municipio) 
		{
			//echo "municipio ".$municipio->getName()."</br>";				
					$listaDocumentos=$municipio->getDocuments($orderby);

					foreach ($listaDocumentos as $documento)
					 {
							$categoriasDocumento=$documento->getCategories();
				   	    	foreach ($categoriasDocumento as $categoria) 
				   	    	{
				   	    		if(strcmp($tipo_documento, "ACTAS")==0)
				   	    		{
				   	    			//echo "acta </br>";
				   	    			if(strcmp($categoria->getName(),$stringActas)==0)
					   	    		{
					   	    			//echo "es una declaratoria de reserva </br>";
					   	    			$contadorFinal++;
					   	    		}

				   	    		}
				   	    		if(strcmp($tipo_documento, "RESERVAS")==0)
				   	    		{
				   	    			//echo "reserva</br>";
				   	    			if(strcmp($categoria->getName(),$stringDeclaratoriasReserva)==0)
					   	    		{
					   	    			//echo "es una declaratoria de reserva </br>";
					   	    			$contadorFinal++;
					   	    		}
				   	    		
				   	    		}
				   	    	}
				   	      }
				   	 	
		   }   
   	    ///////////////////////////////
return $contadorFinal;
}
function contarSinRegistro($folder,$orderby)
{
	$contadorFinal=0;
	
    // un departamento es un folder, cada subfolder será un municipio
    //print "<p> Municipios del departamento de ".$departamento->getName()."</p>";
		$municipios=$folder->getSubFolders();
		foreach ($municipios as $municipio) 
		{
			//echo "municipio ".$municipio->getName()."</br>";				
					$listaDocumentos=$municipio->getDocuments($orderby);
					if($listaDocumentos==FALSE)
					{
						//echo "esta carpeta no tiene documentos";
						$contadorFinal++;
					}				   	 	
		   }   
   	    ///////////////////////////////
return $contadorFinal;

}
//////---------------------------------------------------------------------------------------------------------------------------------------------------------

/* //generan
if ($user->isGuest()) {
	UI::exitError(getMLText("my_documents"),getMLText("access_denied"));
}
*/
// Check to see if the user wants to see only those documents that are still
// in the review / approve stages.
$showInProcess = false;
if (isset($_GET["inProcess"]) && strlen($_GET["inProcess"])>0 && $_GET["inProcess"]!=0) {
	$showInProcess = true;
}

$orderby='n';
if (isset($_GET["orderby"]) && strlen($_GET["orderby"])==1 ) {
	$orderby=$_GET["orderby"];
}
 //calcular cúantos documentos tiene cada literal de prohibición ÉTICA (desde la A hasta la L)
$numeroAs=0;
$numeroBs=0;
$numeroCs=0;
$numeroDs=0;
$numeroEs=0;
$numeroFs=0;
$numeroGs=0;
$numeroHs=0;
$numeroIs=0;
$numeroJs=0;
$numeroKs=0;
$numeroLs=0;
//////////////////////////
$usuarios=$dms->getAllUsers("n");
$stringProhibiciones="Prohibiciones éticas (Art. 6 LEG)";
$stringA="a) Solicitar o aceptar cualquier bien o servicio de valor económico o beneficio adicional al que percibe por el desempeño de sus labores, por hacer, apresurar, retardar o dejar de hacer tareas o trámites relativos a sus funciones";
$stringB="b) Solicitar o aceptar cualquier bien o servicio de valor económico, para hacer valer su influencia en razón del cargo que ocupa ante otra persona sujeta a la aplicación de esta Ley, con la finalidad que éste haga, apresure, retarde o deje de hacer tareas o trámites relativos a sus funciones";
$stringC="c) Percibir más de una remuneración proveniente del presupuesto del Estado, cuando las labores deben ejercerse dentro del mismo horario";
$stringD="d) Desempeñar simultáneamente dos o más empleos en el sector público que fueren incompatibles entre sí por prohibición expresa de la normativa aplicable, por coincidir en las horas de trabajo o porque vaya en contra de los intereses insitucionales";
$stringE="e) Realizar actividades privadas durante la jornada ordinaria de trabajo";
$stringF="f) Exigir o solicitar a los subordinados que empleen el tiempo ordinario de labores para que realicen actividades que no sean las que se les requiera para el cumplimiento de los fines insitucionales";
$stringG="g) Aceptar o mantener un empleo, relaciones contractuales o responsabilidades en el sector privado, que menoscaben la imparcialidad o provoquen un conflicto de interés en el desempeño de su función pública";
$stringH="h) Nombrar, contratar, promover, o ascender en la entidad pública donde ejerce autoridad, a su cónyuge, conviviente, parientes, dentro del cuarto grado de consanguinidad o segundo de afinidad o socio";
$stringI="i) Retardar sin motivo legal la prestación de los servicios, trámites o procedimientos administrativos que le corresponden según sus funciones";
$stringJ="j) Denegar a una persona la prestación de un servicio público a que tenga derecho, en razón de su nacionalidad, raza, sexo, religión, opinión política, condición social o económica, discapacidad o cualquier otra razón injustificada";
$stringK="k) Utilizar indebidamente los bienes muebles o inmuebles de la institución para hacer actos de proselitismo político partidario";
$stringL="l) Prevalerse del cargo para hacer política partidista";
$prohibiciones=$dms->getAttributeDefinitionByName($stringProhibiciones);
foreach ($usuarios as $usuario) 
{
	$documentos=$usuario->getDocuments();
		foreach ($documentos as $documento) 
		{
				//echo "analizando documento: ".$documento->getName();
				$literalesDocumento=$documento->getAttributeValue($prohibiciones);
				//$literales=$prohibiciones->getMultipleValues(); esto solo cuenta cuantas diferentes opciones tiene el atributo
				//echo "literales: ".print_r($literalesDocumento);
				//print_r($literales);
				if($literalesDocumento)
				{
					if(in_array($stringA, $literalesDocumento))
				{
					$numeroAs=$numeroAs+1;
					//echo "hola a";
				}
				if(in_array($stringB, $literalesDocumento))
				{
					$numeroBs=$numeroBs+1;
					//echo "hola b";
				}
				if(in_array($stringC, $literalesDocumento))
				{
					$numeroCs=$numeroCs+1;
				}
				if(in_array($stringD, $literalesDocumento))
				{
					$numeroDs=$numeroDs+1;
				}
				if(in_array($stringE, $literalesDocumento))
				{
					$numeroEs=$numeroEs+1;
				}
				if(in_array($stringF, $literalesDocumento))
				{
					$numeroFs=$numeroFs+1;
				}
				if(in_array($stringG, $literalesDocumento))
				{
					$numeroGs=$numeroGs+1;
				}
				if(in_array($stringH, $literalesDocumento))
				{
					$numeroHs=$numeroHs+1;
				}
				if(in_array($stringI, $literalesDocumento))
				{
					$numeroIs=$numeroIs+1;
				}
				if(in_array($stringJ, $literalesDocumento))
				{
					$numeroJs=$numeroJs+1;
				}
				if(in_array($stringK, $literalesDocumento))
				{
					$numeroKs=$numeroKs+1;
				}
				if(in_array($stringL, $literalesDocumento))
				{
					$numeroLs=$numeroLs+1;
				}
				
				}
		
				
			

		}//fin de recorrer todas las resoluciones
}//fin de recorrer todos los usuarios



$tmp = explode('.', basename($_SERVER['SCRIPT_FILENAME']));
$view = UI::factory($theme, $tmp[1], array('dms'=>$dms, 'user'=>$user));
if($view) 
{
	$view->setParam('orderby', $orderby);
	$view->setParam('showinprocess', $showInProcess);
	$view->setParam('workflowmode', $settings->_workflowMode);
	$view->setParam('cachedir', $settings->_cacheDir);
	$view->setParam('previewWidthList', $settings->_previewWidthList);
	$view->setParam('timeout', $settings->_cmdTimeout);
	
	$view->setParam('numeroAs', $numeroAs);
	$view->setParam('numeroBs', $numeroBs);
	$view->setParam('numeroCs', $numeroCs);
	$view->setParam('numeroDs', $numeroDs);
	$view->setParam('numeroEs', $numeroEs);
	$view->setParam('numeroFs', $numeroFs);
	$view->setParam('numeroGs', $numeroGs);
	$view->setParam('numeroHs', $numeroHs);
	$view->setParam('numeroIs', $numeroIs);
	$view->setParam('numeroJs', $numeroJs);
	$view->setParam('numeroKs', $numeroKs);
	$view->setParam('numeroLs', $numeroLs);


	$view($_GET);
	exit;
}

?>
