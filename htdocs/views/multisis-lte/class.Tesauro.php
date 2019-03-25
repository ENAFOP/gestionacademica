<?php
/**
 * Implementation of MyDocuments view
 *
 * @category   DMS
 * @package    SeedDMS
 * @license    GPL 2
 * @version    @version@
 * @author     Uwe Steinmann <uwe@steinmann.cx> DMS with modifications of José Mario López Leiva
 * @copyright  Copyright (C) 2017 José Mario López Leiva
 *             marioleiva2011@gmail.com    
 				San Salvador, El Salvador, Central America

 *             
 * @version    Release: @package_version@
 */

/**
 * Include parent class
 */
require_once("class.Bootstrap.php");


/**
 * Include class to preview documents
 */
require_once("SeedDMS/Preview.php");



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
	$arrayProblemas=array();
	//$stringProblema="Problema jurídico";
	$catego=$dms->getDocumentCategory($idTipologia)->getName();
	//algoritmo: obtengo todos los usuarios, de cada un saco todos los documentos, de cada documento veo si la catego pasada al método 
	//es member de la lista de categos del doc. Así, de ese doc, obtengo el atributo "problema jurídico " y lo devuelvo
	$usuario=$dms->getUser(1);
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

		}

  $arrayProblemas=array_unique($arrayProblemas,SORT_REGULAR);
   $arrayProblemas = array_values($arrayProblemas);
  //$arrayProblemas = array_unique(array_map(function ($i) { return $i[0]; }, $arrayProblemas));
  /*  $data=array();
    foreach($arrayProblemas as $value )
    {

        $data[$value]= $value;

    }
    array_values($data);*/
    //$arrayProblemas=$data;
 //$arrayProblemas = array_map('unserialize', array_unique(array_map('serialize', $arrayProblemas)));
	return $arrayProblemas;
}

function ObtenerResolucionesProblemas($problema, $dms) //me devuelve un array con objetos Document que tienen como problema jurídico $problema
{
  //echo "Comenzando ObtenerResolucionesProblemas";
  //echo "Problema a analziar: ".$problema;
  $string="Problema jurídico";
  $arrayDocumentos=array();
   $usuario=$dms->getUser(1);
      $documentos=$usuario->getDocuments();
    foreach ($documentos as $documento) 
      {

        $atributoProblema=$dms->getAttributeDefinitionByName($string);
        $problemaJuridicoDocumento=$documento->getAttributeValue($atributoProblema);
        if(in_array($problema,$problemaJuridicoDocumento))
        {
          $arrayDocumentos[]=$documento;
        }
      }

    return $arrayDocumentos;
}

class SeedDMS_View_Tesauro extends SeedDMS_Bootstrap_Style 
{
 /**
 Método que muestra los documentos próximos a caducar sólo de 
 **/
	

	function show() 
	{ /* {{{ */
		$dms = $this->params['dms'];
		$user = $this->params['user'];
		$orderby = $this->params['orderby'];
		$showInProcess = $this->params['showinprocess'];
		$cachedir = $this->params['cachedir'];
		$workflowmode = $this->params['workflowmode'];
		$previewwidth = $this->params['previewWidthList'];
		$timeout = $this->params['timeout'];
		
		//$db = $dms->getDB();
		//$previewer = new SeedDMS_Preview_Previewer($cachedir, $previewwidth, $timeout);
		$ruta_pagina_salida="../out/out.CaducaranPronto.php";

		$this->htmlStartPage("Búsqueda por tesauro", "skin-blue sidebar-collapse sidebar-mini");
		$this->containerStart();
		$this->mainHeader();
		$this->mainSideBar();
		//$this->contentContainerStart("hoa");
		$this->contentStart();
          
		?>
    <div class="gap-10"></div>
    <div class="row">
    <div class="col-md-12">
    	   <section class="content-header">
      <h1>
       Buscador de resoluciones
        <small>del Tribunal de Ética Gubernamental</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="http://teg.gob.sv/"><i class="fa fa-dashboard"></i>Inicio</a></li>
         <li><a href="#">Buscador de resoluciones</a></li>
        <li><a href="#">Tesauro de tipologías</a></li>
        
      </ol>
    </section>

     <div class="row">
        <div class="col-xs-12">
          <div class="box box-default">
          
            <div class="box-body">
                <a href="/out/out.BusquedaSimple.php" button type="button" class="btn btn-default" role="button"><i class="fa fa-search"></i>
                Búsqueda simple
              </a>
              <a href="/out/out.BusquedaAvanzada.php" button type="button" class="btn btn-default" role="button"><i class="fa fa-search-plus"></i>
                Búsqueda avanzada
              </a>
                <a href="#" button type="button" class="btn btn-default" role="button"><i class="fa fa-gavel"></i>
                Tesauro de tipologías
              </a>
               
            </div>
          </div>
        </div>
      </div>
      <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-university"></i>Tesauro de resoluciones por tipología</h4>
                En esta pantalla puede ver las resoluciones según tipología, problema jurídico y su respectivo fundamento.
            </br>
                Se trata de un árbol de búsqueda. El primer nivel (el que posee el logo tel TEG) - <img src="/images/tegSmall.png"></img> - Se refiere a la tipología, la cual es una categoría general de problemas jurídicos dentro de la LEG. 
                 </br>
                 El segundo nivel le muestra los problemas jurídicos, indicado con el icono de la balanza- <img src="/images/balanza.png"></img>;
                   </br>
                Y el tercel nivel, indica el fundamento (o razón para tomar una decisión) acerca de la resolución- <img src="/images/mazo.png"></img>; Si hace click sobre el fundamento, será dirigido a la ficha de la resolución que cumple con la tipología y problema jurídico mostrado en los dos niveles superiores.
				</br>
				<b>Por favor, haga doble click en el elemento que desea cargar dentro del árbol, y espere brevemente a que éste sea cargado.</b>

              </div>


    <?php
    //en este bloque php va "mi" código
 $this->startBoxPrimary(getMLText("Tesauro: búsqueda por tipologías"));
$this->contentContainerStart();
//////INICIO MI CODIGO

  
 echo "<div id=\"jstree\">";
/*    //<!-- in this example the tree is populated from inline HTML -->
    echo "<ul>"; //inicio contenedos
    $tipologias=$dms->getDocumentCategories();
    foreach ($tipologias as $tipo) 
    {
      $idTipologia=$tipo->getID();
      $nombreTipologia=$tipo->getName();
      //echo "analizando tipologia: ".$nombreTipologia;
      echo "<li data-jstree='{\"icon\":\"/images/tegSmall.png\"}' id=".$idTipologia.">".$nombreTipologia;
      echo "<ul>";
            echo "<div id=\"segundoNivel\">";
      echo "</ul>";
    }
          echo "</li>";
      echo "</ul>"; //fin contenedor*/
  echo "</div>"; //fin estructura
?>

  

 <?php
 //////FIN MI CODIGO      
 //<div id="tree-container"></div>           
$this->contentContainerEnd();
$this->endsBoxPrimary();
     ?>
	     </div>
		</div>
		</div>

		<?php	
		$this->contentEnd();
		$this->mainFooter();		
		$this->containerEnd();
		//$this->contentContainerEnd();
		echo '<script type="text/javascript" src="/styles/multisis-lte/jstree/datosArbol.js"></script>'."\n"; //agregado 
		$this->htmlEndPage();
	} /* }}} */
}
?>
