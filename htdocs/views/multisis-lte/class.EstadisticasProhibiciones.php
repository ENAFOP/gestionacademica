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

class SeedDMS_View_EstadisticasProhibiciones extends SeedDMS_Bootstrap_Style 
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
    $numeroAs = $this->params['numeroAs'];
    $numeroBs = $this->params['numeroBs'];
    $numeroCs = $this->params['numeroCs'];
    $numeroDs = $this->params['numeroDs'];
    $numeroEs = $this->params['numeroEs'];
    $numeroFs = $this->params['numeroFs'];
    $numeroGs = $this->params['numeroGs'];
    $numeroHs = $this->params['numeroHs'];
    $numeroIs = $this->params['numeroIs'];
    $numeroJs = $this->params['numeroJs'];
    $numeroKs = $this->params['numeroKs'];
    $numeroLs = $this->params['numeroLs'];

$arrayTodo[]=$numeroAs;
$arrayTodo[]=$numeroBs;
$arrayTodo[]=$numeroCs;
$arrayTodo[]=$numeroDs;
$arrayTodo[]=$numeroEs;
$arrayTodo[]=$numeroFs;
$arrayTodo[]=$numeroGs;
$arrayTodo[]=$numeroHs;
$arrayTodo[]=$numeroIs;
$arrayTodo[]=$numeroJs;
$arrayTodo[]=$numeroKs;
$arrayTodo[]=$numeroLs;

$mayorValor=max($arrayTodo);
   

		$db = $dms->getDB();
		$previewer = new SeedDMS_Preview_Previewer($cachedir, $previewwidth, $timeout);
		$ruta_pagina_salida="../out/out.CaducaranPronto.php";

		$this->htmlStartPage(getMLText("mi_sitio"), "skin-blue sidebar-collapse sidebar-mini");
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
        <li><a href="#">Número de resoluciones según prohibiciones éticas</a></li>
        
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
  
 $this->startBoxPrimary(getMLText("Estadísticas del índice de reserva"));
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
              <h3 class="box-title">Número de resoluciones por prohibición ética (literales art. 6 LEG)</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div class="chart">
                <canvas id="graficoBarras" style="height:250px"></canvas>
              </div>
             
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->


              <h3 class="box-title">Tomado de la Ley de Ética Gubernamental, artículo 6:</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <blockquote>
                <p>Solicitar  o  aceptar,  directamente  o  por  interpósita  persona, 
dádivas,  regalos,  pagos,  honorarios  o  cualquier  otro  tipo  de 
regalías,  por  a
cciones  relacionadas  con  las  funciones  del  cargo 
público.</p>
                <small><cite title="Source Title"> Literal a</cite></small>
              </blockquote>




                <blockquote>
                <p>Prevalecerse  de  su  cargo  público  para  obtener  o  procurar 
beneficios privados.</p>
                <small><cite title="Source Title"> Literal b</cite></small>
              </blockquote>



                <blockquote>
                <p>Desempeñar simultáneamente dos o más empleos en el sector 
público, salvo los casos permitidos en la ley. Prevalecerse  de  su  cargo  público  para  obtener  o  procurar 
beneficios privados.</p>
                <small><cite title="Source Title"> Literal c</cite></small>
              </blockquote>





                <blockquote>
                <p>Utilizar,  para  beneficio  privado,  la  información  reservada  o 
privilegiada que obtenga en función de su cargo. </p>
                <small><cite title="Source Title"> Literal d</cite></small>
              </blockquote>


                <blockquote>
                <p>Negarse  a  proporcionar  información  de  su  función  pública, exceptuando las que establecen la Constitución y la ley. </p>
                <small><cite title="Source Title"> Literal e</cite></small>
              </blockquote>



                <blockquote>
                <p>Intervenir en cualquier asunto en el que él o algún miembro de su unidad familiar tenga conflicto de intereses. </p>
                <small><cite title="Source Title"> Literal f</cite></small>
              </blockquote>



                <blockquote>
                <p>Nombrar a parientes dentro del cuarto grado de consanguinidad o segundo de afinidad, para que presten servicios en la entidad que preside o se desempeñe. </p>
                <small><cite title="Source Title"> Literal g</cite></small>
              </blockquote>




                <blockquote>
                <p>Utilizar en forma indebida los bienes y patrimonio del Estado. </p>
                <small><cite title="Source Title"> Literal h</cite></small>
              </blockquote>




                <blockquote>
                <p>Retardar  sin  motivo  legal  los  trámites  o  la  prestación  de 
servicios administrativos. </p>
                <small><cite title="Source Title"> Literal i</cite></small>
              </blockquote>




               <blockquote>
                <p>Denegar a una persona la prestación de un servicio público a que tenga derecho, en razón de su nacionalidad, sexo, raza o religión, opinión política, discapacidad, condición social o económica. </p>
                <small><cite title="Source Title"> Literal j</cite></small>
              </blockquote>



                <blockquote>
                <p>Utilizar indebidamente los bienes de la institución para hacer proselitismo político partidario.</p>
                <small><cite title="Source Title"> Literal k</cite></small>
              </blockquote>


              <blockquote>
                <p>Prevalerse del cargo para hacer política partidista.</p>
                <small><cite title="Source Title"> Literal l</cite></small>
              </blockquote>


            </div>
            <!-- /.box-body -->
          </div>


     <?php  
      //////FIN MI CODIGO               
//$this->contentContainerEnd();
$this->endsBoxPrimary();
     ?>
	     </div>
		</div>
		</div>
<!-- MANDO -->
<input type="hidden" id="numeroAs" value="<?php echo $numeroAs ?>" />
<input type="hidden" id="numeroBs" value="<?php echo $numeroBs ?>" />
<input type="hidden" id="numeroCs" value="<?php echo $numeroCs ?>" />
<input type="hidden" id="numeroDs" value="<?php echo $numeroDs ?>" />
<input type="hidden" id="numeroEs" value="<?php echo $numeroEs ?>" />
<input type="hidden" id="numeroFs" value="<?php echo $numeroFs ?>" />
<input type="hidden" id="numeroGs" value="<?php echo $numeroGs ?>" />
<input type="hidden" id="numeroHs" value="<?php echo $numeroHs ?>" />
<input type="hidden" id="numeroIs" value="<?php echo $numeroIs ?>" />
<input type="hidden" id="numeroJs" value="<?php echo $numeroJs ?>" />
<input type="hidden" id="numeroKs" value="<?php echo $numeroKs ?>" />
<input type="hidden" id="numeroLs" value="<?php echo $numeroLs ?>" />
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

  echo "<script type='text/javascript'  src='/styles/multisis-lte/bower_components/datos.js'></script>";

		$this->htmlEndPage();

	} /* }}} */

}


?>  

