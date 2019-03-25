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

class SeedDMS_View_EstadisticasDecisiones extends SeedDMS_Bootstrap_Style 
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

$arrayTodo=array();
    $numeroSinLugar = $this->params['numeroSinLugar'];
    $numeroSanciona = $this->params['numeroSanciona'];
    $numeroImprocedente = $this->params['numeroImprocedente'];
    $numeroNoSanciona = $this->params['numeroNoSanciona'];
    $numeroSobreseimiento = $this->params['numeroSobreseimiento'];
    $numeroInadmisible = $this->params['numeroInadmisible'];
    $numeroDesistimiento = $this->params['numeroDesistimiento'];
 $fechaInicial = $this->params['fechaInicial'];
  $fechaFinal = $this->params['fechaFinal'];

$arrayTodo[]=$numeroSinLugar;
$arrayTodo[]=$numeroSanciona;
$arrayTodo[]=$numeroImprocedente;
$arrayTodo[]=$numeroNoSanciona;
$arrayTodo[]=$numeroSobreseimiento;
$arrayTodo[]=$numeroInadmisible;
$arrayTodo[]=$numeroDesistimiento;


$mayorValor=max($arrayTodo);
   

		$db = $dms->getDB();
		$previewer = new SeedDMS_Preview_Previewer($cachedir, $previewwidth, $timeout);
		//$ruta_pagina_salida="../out/out.CaducaranPronto.php";

		$this->htmlStartPage(getMLText("estadisticas_decisiones"), "skin-blue sidebar-collapse sidebar-mini");
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
           <li><a href="#">Estadísticas de resoluciones</a></li>
        <li><a href="#">Número de resoluciones según decisiones del Tribunal</a></li>
        
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
                <a href="/out/out.Tesauro.php" button type="button" class="btn btn-default" role="button"><i class="fa fa-gavel"></i>
                Tesauro de tipologías
              </a>
                <a href="/out/out.Charts.php" button type="button" class="btn btn-default" role="button"><i class="fa fa-pie-chart"></i>
                Estadísticas de resoluciones
              </a>
            </div>
          </div>
        </div>
      </div>
    <?php
    //en este bloque php va "mi" código
  
 $this->startBoxPrimary("Decisión de las resoluciones en el rango temporal entre $fechaInicial y $fechaFinal");
//$this->contentContainerStart();

//////INICIO MI CODIGO
?>
 <!-- line chart canvas element -->
 <!--
        <canvas id="buyers" width="600" height="400"></canvas>
         pie chart canvas element 
        <canvas id="countries" width="600" height="400"></canvas>
        bar chart canvas element -->
           <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Número de resoluciones por decisión del TEG</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div class="chart">
                <canvas id="graficoPastel" style="height:250px"></canvas>
              </div>
             
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->



     <?php  
      //////FIN MI CODIGO               
//$this->contentContainerEnd();
$this->endsBoxPrimary();
     ?>
	     </div>
		</div>
		</div>
<!-- MANDO -->
<input type="hidden" id="numeroSinLugar" value="<?php echo $numeroSinLugar ?>" />
<input type="hidden" id="numeroSanciona" value="<?php echo $numeroSanciona ?>" />
<input type="hidden" id="numeroImprocedente" value="<?php echo $numeroImprocedente ?>" />
<input type="hidden" id="numeroNoSanciona" value="<?php echo $numeroNoSanciona ?>" />
<input type="hidden" id="numeroSobreseimiento" value="<?php echo $numeroSobreseimiento ?>" />
<input type="hidden" id="numeroInadmisible" value="<?php echo $numeroInadmisible ?>" />
<input type="hidden" id="numeroDesistimiento" value="<?php echo $numeroDesistimiento ?>" />

<input type="hidden" id="mayorValor" value="<?php echo $mayorValor ?>" />
		<?php	
		$this->contentEnd();
		$this->mainFooter();		
		$this->containerEnd();
		//$this->contentContainerEnd();/bower_componentsdatos
  //script que dibuja
   //echo "<script > var actasAhuachapan= $actasAhuachapan; </script>";
    echo '<script type="text/javascript" src="/styles/multisis-lte/bower_components/Chart.js/Chart.js"></script>'."\n"; //agregado 
  // echo "<script type='text/javascript'src='/styles/multisis-lte/bower_components/meterVariables.js'></script>";

  echo "<script type='text/javascript'  src='/styles/multisis-lte/bower_components/datos2.js'></script>";

		$this->htmlEndPage();

	} /* }}} */

}


?>  

