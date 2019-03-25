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

class SeedDMS_View_BusquedaSimple extends SeedDMS_Bootstrap_Style 
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
		 <style>

      input[type="text"] 
      {
         width: 900px;
         border: 1px solid #CCC;
      }
</style>
   <!--   <div class="content-wrapper"> -->
    
    <section class="content-header">
      <h1>
       Buscador de resoluciones
        <small>del Tribunal de Ética Gubernamental</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="http://teg.gob.sv/"><i class="fa fa-dashboard"></i>Inicio</a></li>
         <li><a href="#">Buscador de resoluciones</a></li>
        <li><a href="#">Búsqueda simple</a></li>
        
      </ol>
    </section>

     <div class="row">
        <div class="col-xs-12">
          <div class="box box-default">
          
            <div class="box-body">
              <a href="#" button type="button" class="btn btn-default" role="button"><i class="fa fa-search"></i>
                Búsqueda simple
              </a>
              <a href="/out/out.BusquedaAvanzada.php" button type="button" class="btn btn-default" role="button"><i class="fa fa-search-plus"></i>
                Búsqueda avanzada
              </a>
                <a href="/out/out.Tesauro.php" button type="button" class="btn btn-default" role="button"><i class="fa fa-gavel"></i>
                Tesauro de tipologías
              </a>
			  <?php
				// if(!$user->isGuest())
				// {
					// echo "<a href=\"/out/out.Charts.php\" button type=\"button\" class=\"btn btn-default\" role=\"button\"><i class=\"fa fa-pie-chart\"></i>
                // Estadísticas de resoluciones";
				// }
                
				 ?>
              </a>
            </div>
          </div>
        </div>
      </div>
 <div class="alert alert-info alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-info"></i>Ingrese los términos de interés</h4>
                Por favor, digite la palabra o palabras que le interesen. Por ejemplo, puede ingresar un número de resolución, una frase o palabra. El buscador devolverá una lista de resoluciones del Tribunal de Ética Gubernamental para esos términos.
                   </div>
    <?php
    //en este bloque php va "mi" código
  
 $this->startBoxPrimary(getMLText("busqueda_simple"));

 $this->contentContainerStart();
 ?>
<form action="../out/out.Search.php" name="form1">
	<input type="hidden" name="mode" value="1">
	<input type="hidden" name="ownerid" value="-1">
	<input type="hidden" name="resultmode" value="3">
	<input type="hidden" name="targetid" value="1">
	<input type="hidden" name="targetnameform1" value="">
      
    <span class="input-group-btn">            
        <div class="form-group">
            <!--  <input type="text" class="form-control" name="terminos" placeholder="Términos de búsqueda"> -->
            <input type="search" name="query" class="form-control input-lg " placeholder="<?php echo getMLText("ingrese_termino"); ?>">
            <label class="h4">
	            <div class="icheckbox_flat-green" aria-checked="false" aria-disabled="false" style="position: relative;">
		            <input type="checkbox" class="flat-red" id="frase-exacta" name="fraseExacta" style="position: relative; opacity: 0;">
		            <ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 10px; background: rgb(255, 255, 255); border: 0px; opacity: 0;">
		            </ins>
		        </div>&nbsp;
		        	<?php echo getMLText("frase_exacta"); ?>
            </label>
			<p>
            <label class="h4">Máximo de registros (arrastre el botón para modificar el número)</label> 
            <input id="ex6" name="limiteResultados" type="text" data-slider-min="10" data-slider-max="300" data-slider-step="10" data-slider-value="50" data-slider-id='ex1Slider'/>
			<span class="h4" id="ex6CurrentSliderValLabel">Número máximo de resultados que se mostrarán a para su búsqueda: <span id="ex6SliderVal">50</span>
			</span>
			</p>
				<button type="submit" class="center-block btn  btn-success btn-lg"><i class="fa fa-search"></i> Buscar</button>
		</div>
    </span>
</form>             
    <?php

//////INICIO MI CODIGO
?>
 
 <?php
  //////FIN MI CODIGO                 
$this->contentContainerEnd();
$this->endsBoxPrimary();
     ?>
	   <!-- </div>   fin Content Wrapper. Contains page content -->
		   </div>
    </div>
    </div>

		<?php	
		$this->contentEnd();
		$this->mainFooter();		
		$this->containerEnd();
		//$this->contentContainerEnd();
     echo "<script type='text/javascript' src='/styles/multisis-lte/plugins/bootstrap-slider/bootstrap-slider.js'></script>\n";
     echo "<script type='text/javascript' src='/styles/multisis-lte/plugins/bootstrap-slider/hacer.js'></script>\n";
     echo "<script type='text/javascript' src='/styles/multisis-lte/plugins/iCheck/icheck.js'></script>\n";
     echo "<script type='text/javascript' src='/js/BusquedaSimple.js'></script>\n";
    //echo "<script type='text/javascript' src='/styles/multisis-lte/bower_components/ion.rangeSlider/js/ion.rangeSlider.min.js'></script>";
   //echo "<script type='text/javascript' src='/styles/multisis-lte/bower_components/bootstrap-slider/activarSlider.js'></script>";

		$this->htmlEndPage();
	} /* }}} */
}
?>
