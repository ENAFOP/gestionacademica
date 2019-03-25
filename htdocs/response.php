<?php
header("Content-type:application/json");
include("./inc/inc.Settings.php");
include("./inc/inc.Utils.php");
include("./inc/inc.Init.php");
include("./inc/inc.DBInit.php");
function add3dots($string, $repl, $limit) 
{
  if(strlen($string) > $limit) 
  {
    return substr($string, 0, $limit) . $repl; 
  }
  else 
  {
    return $string;
  }
}
function obtenerProblemas($string,$idTipologia,$dms) //funcion que obtiene problemas atributos (definidos en String) dada una tipologia, devuelve array con problemas
{
	//echo "En obtener problemas problema metido: ".$
	$arrayProblemas=array();
	//$stringProblema="Problema jurídico";
	$catego=$dms->getDocumentCategory($idTipologia)->getName();
	//algoritmo: obtengo todos los usuarios, de cada un saco todos los documentos, de cada documento veo si la catego pasada al método 
	//es member de la lista de categos del doc. Así, de ese doc, obtengo el atributo "problema jurídico " y lo devuelvo
	   $usuarios=$dms->getAllUsers();
	   foreach($usuarios as $usuario)
	   {
		   $documentos=$usuario->getDocuments();
		   	foreach ($documentos as $documento) 
			{
				$categoriasDocumento=$documento->getCategories();
				$arrayCats=array();
				foreach ($categoriasDocumento as $cat) 
				{
					$arrayCats[]=$cat->getName();
				}

				if(in_array($catego, $arrayCats))
				{
					$atributoProblema=$dms->getAttributeDefinitionByName($string);
					$problemaJuridico=$documento->getAttributeValue($atributoProblema);
					$arrayProblemas[]=$problemaJuridico;
				}

			}//fin foreach recorre documentos
	   }
		//$documentos=$usuario->getDocuments();
	

  $arrayProblemas=array_unique($arrayProblemas,SORT_REGULAR);
   $arrayProblemas = array_values($arrayProblemas);
	return $arrayProblemas;
}

function ObtenerResolucionesProblemas($problema, $dms) //me devuelve un array con objetos String con el Ratio decidiendi que tienen como problema jurídico $problema
{
  $arrayDocumentos=array();
$settings = new Settings(); //acceder a parámetros de settings.xml con _antes
    $driver=$settings->_dbDriver;
    $host=$settings->_dbHostname;
    $user=$settings->_dbUser;
    $pass=$settings->_dbPass;
    $base=$settings->_dbDatabase;
  $manejador=new SeedDMS_Core_DatabaseAccess($driver,$host,$user,$pass,$base);
  $estado=$manejador->connect();
 // echo "problema: ".$problema;
  if($estado!=1)
  {
    echo "/response.php: no se pudo conectar a la BD";
  } 
  //query de consulta:
  $miQuery="SELECT document FROM tblDocumentAttributes WHERE value like '%$problema%'";
  //echo "mi query: ".$miQuery;
  $resultado=$manejador->getResultArray($miQuery);
  foreach($resultado as $res)
  {
	  $idoc=$res['document'];
	  //echo "Idoc a devolver: ".$idoc;
	  $nuevoDoc=$dms->getDocument($idoc);
	   $arrayDocumentos[]=$nuevoDoc;
  }
    return $arrayDocumentos;
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////// MAIN ////////////////////////////////////////////////////////////////////////////////////////////////
//contenedores
//$start = microtime(true);
$stringProblema="Problema jurídico";
$stringRatio="Fundamento";
$myArray = array(); //contenedos gene
		   $idTipologia = $_GET['id'];	
		   $nivel=intval($_GET['nivel']);
		   //Si el nivel obtenido es 1, quiero los problemas jurídicos.
		   // Si se ha puesto nivel 2, ratio decidiendi
		  //error_log("Recibida petición de problema jurídico, id ".$idTipologia);
			if($nivel==1)
			{
			$listaProblemasJuridicos=obtenerProblemas($stringProblema,$idTipologia,$dms);
			  $contenedor2=array();		  
				 foreach($listaProblemasJuridicos as $problema)
				 {
					 $idProblema=$idTipologia*rand(15,95);
					 $texto=$problema;
					 $nivel2=array("id" => $texto, "text" => $texto, "icon" => "/images/balanza.png");
					 $myArray[]=$nivel2;
				 }
			}
			if($nivel==2) //RATIOS DECIDIENDI, NIVEL 3 Y EL MÁS BAJO
			{
				$documentosResolucion=ObtenerResolucionesProblemas($idTipologia, $dms);
				 foreach($documentosResolucion as $documentoResolucion)
				 {
					 $idDoc=$documentoResolucion->getID();
					// echo "EN MAIN: ".$idDoc;
					 $atributoRatio=$dms->getAttributeDefinitionByName($stringRatio);
					
					 $ratioDecidiendi=$documentoResolucion->getAttributeValue($atributoRatio);
					
					 //$idRatio=$documentoResolucion->getID();
					 $texto=add3dots($ratioDecidiendi, "...", 230); 
					 $texto = trim(preg_replace('/\s\s+/', ' ', $texto));
					 //$texto=utf8_encode($texto);
					 //echo "texto: ".$texto."\n";
					 $arrayConf=array();
					 $enlace="/out/out.ViewDocument.php?documentid=".$idDoc;
					 //echo "enlace: ".$enlace."\n";
					  $enlace=array("href" =>$enlace);
					  $arrayConf[]=$enlace;
					 $nivel2=array("id" => $idDoc, "text" => $texto, "icon" => "/images/mazo.png", "a_attr" => $enlace);
					 $myArray[]=$nivel2;
				 }
			}

echo json_encode($myArray);
?>
