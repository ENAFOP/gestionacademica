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

class SeedDMS_View_EstadisticasTerminacion extends SeedDMS_Bootstrap_Style 
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
	

		$this->htmlStartPage("Estadísticas sobre resoluciones: tipo", "skin-blue sidebar-mini sidebar-collapse");
		$this->containerStart();
		$this->mainHeader();
		$this->mainSideBar();
		//$this->contentContainerStart("hoa");
		$this->contentStart();
          
		?>
    <div class="gap-10"></div>
    <div class="row">
    <div class="col-md-12">
      

    <?php
    //en este bloque php va "mi" código
  
 $this->startBoxPrimary("Seleccione un rango de fechas, para mostrar estadísticas sobre el tipo de las resoluciones (Anormal/Definitiva)en ese periodo");
$this->contentContainerStart();
//////INICIO MI CODIGO
 ?>


<?php $creationdate=FALSE ?>
    <form name="busquedaAvanzada" id="busquedaAvanzada" action="/out/out.GraficasTerminacion.php" method="POST">
 <label>Fecha inicial: </label>
   <span class="input-append date" style="display: inline;" id="createstartdate" data-date="<?php echo date('d-m-Y'); ?>" data-date-format="dd-mm-yyyy" data-date-language="<?php echo str_replace('_', '-', $this->params['session']->getLanguage()); ?>">
          <input class="span4 form-control" size="16" id="fechaInicio" name="fechaInicio" type="text" placeholder="Ingrese fecha inicial" required> 
          <span class="add-on"><i class="icon-calendar"></i></span>
        </span>&nbsp;
          <label>Fecha final: </label>
		<!--   AQUI HAGO AGARRAR UNA FECHA DE FIN -->
<!--   AQUI HAGO AGARRAR UNA FECHA DE INICIO 
		name: fechaFin
		id: createenddate
		Estos id y nombre, debo buscarlos en el fichero /out/out.Search.php, en la parte con el comment "// Is the search restricted to documents created between two specific dates?"
		en la línea if(isset($_GET["fechaFin"])) {
		-->
		   <span class="input-append date" style="display: inline;" id="createenddate" data-date="<?php echo date('d-m-Y'); ?>" data-date-format="dd-mm-yyyy" data-date-language="<?php echo str_replace('_', '-', $this->params['session']->getLanguage()); ?>">
          <input class="span4 form-control" size="16" name="fechaFin" id="fechaFin" type="text" placeholder="Ingrese fecha final" required> 
          <span class="add-on"><i class="icon-calendar"></i></span>
        </span>
 				

                  <br>
                    <button type="submit" class="btn  btn-info btn-lg">Mostrar estadísticas para este rango de fecha</button>
                     <button type="reset" class="btn  btn-danger btn-lg">Borrar campos</button>
          </form> 
<?php
 //////FIN MI CODIGO                 
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
		$this->htmlEndPage();
	} /* }}} */
}
?>
