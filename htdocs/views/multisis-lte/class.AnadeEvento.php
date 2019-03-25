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

class SeedDMS_View_AnadeEvento extends SeedDMS_Bootstrap_Style 
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

		$this->htmlStartPage(getMLText("anadir_evento"), "skin-blue sidebar-mini  sidebar-collapse");
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
  
 $this->startBoxPrimary(getMLText("anadir_evento"));
$this->contentContainerStart();
//////INICIO MI CODIGO
?>
<!-- ***************** UNA FILA TRES COLUMNAS *********************-->
<div class="row">
        <div class="col-md-3">

        </div> <!-- FIN DE COLUMNA 1 -->

        <div class="col-md-6">
        		<div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Datos del evento</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
      <form class="form-horizontal" name="formularioEvento" id="formularioEvento" action="../out/out.ProcesarEvento.php" method="POST" enctype="multipart/form-data>
              <div class="box-body">

                <div class="form-group">
                  <label for="nombreEvento" class="col-sm-2 control-label">Nombre del evento</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="nombreEvento" name="nombreEvento" placeholder="Nombre del evento" required>
                  </div>
                </div>

                <div class="form-group">
                  <label for="lugarEvento" class="col-sm-2 control-label">Lugar</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="lugarEvento" name="lugarEvento" placeholder="ej: Sheraton" required>
                  </div>
                </div>

                <div class="form-group">
                  <label for="totalInvitados" class="col-sm-2 control-label">Total de invitados</label>

                  <div class="col-sm-10">
                    <input type="number" class="form-control" id="totalInvitados" name="totalInvitados" min="1"  placeholder="Número total de personas que se prevee asistirán" required>
                  </div>
                </div>

                <div class="form-group">
                	<label for="fechaInicio" class="col-sm-2 control-label">Fecha de inicio</label>
                   <div class="col-xs-4"> <!-- *******INICIO PERIODO INICIAL****** -->
                  	    	                   							
						    <span class="input-append date datepicker" data-date="<?php echo date('Y-m-d'); ?>" data-date-format="yyyy-mm-dd" data-date-language="<?php echo str_replace('_', '-', $this->params['session']->getLanguage()); ?>">
                              <input class="form-control" name="fechaInicio" id="fechaInicio" type="text" value="" required>
                              <span class="add-on"><i class="icon-calendar"></i></span>
                            </span>						              
						             
                     </div> <!-- *******FIN PERIODO INICIAL****** -->
                </div>

                <div class="form-group">
                  <label for="fechaFin" class="col-sm-2 control-label">Fecha de fin del evento</label>

                  <div class="col-xs-4"> <!-- *******INICIO PERIODO INICIAL****** -->
                  	    	                   							
						    <span class="input-append date datepicker" data-date="<?php echo date('Y-m-d'); ?>" data-date-format="yyyy-mm-dd" data-date-language="<?php echo str_replace('_', '-', $this->params['session']->getLanguage()); ?>">
                              <input class="form-control" name="fechaFin" id="fechaFin" type="text" value="" required>
                              <span class="add-on"><i class="icon-calendar"></i></span>
                            </span>						              
						             
                     </div> <!-- *******FIN PERIODO INICIAL****** -->
                </div>

                 <div class="form-group">
                  <label for="comentarios" class="col-sm-2 control-label">Comentarios</label>

                  <div class="col-sm-10">
                     <textarea class="form-control" id="comentarios" name="comentarios" rows="3" placeholder="Añada comentarios  ..."></textarea>
                  </div>
              

              

              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="reset" class="btn btn-default">Borrar campos</button>
                <button type="submit" class="btn btn-info pull-right">Crear evento</button>
              </div>
              <!-- /.box-footer -->
            </form>
          </div>

        </div> <!-- FIN DE COLUMNA 2 -->


        <div class="col-md-3">

        </div> <!-- FIN DE COLUMNA 3 -->
</div> <!-- FIN DE FILA -->


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
