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
 function contarItems($dms)
   {
    $res=true;
    $db = $dms->getDB();
    $consultar = "SELECT COUNT(*) FROM app_item;";
    //echo "Consultar: ".$consultar;
    $res1 = $db->getResultArray($consultar);
    return $res1[0]['COUNT(*)'];
   }
   function contarUbicaciones($dms)
   {
    $res=true;
    $db = $dms->getDB();
    $consultar = "SELECT COUNT(*) FROM app_ubicacion;";
    //echo "Consultar: ".$consultar;
    $res1 = $db->getResultArray($consultar);
    return $res1[0]['COUNT(*)'];
   }
class SeedDMS_View_GestionarItems extends SeedDMS_Bootstrap_Style 
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

		$this->htmlStartPage("Gestionar items", "skin-blue sidebar-mini  sidebar-collapse");
		$this->containerStart();
		$this->mainHeader();
		$this->mainSideBar();
		//$this->contentContainerStart("hoa");
		$this->contentStart();
          
		?>
		   <ol class="breadcrumb">
        <li><a href="out.ViewFolder.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">ITEMS</li>
      </ol>
    <div class="gap-10"></div>
    <div class="row">
    <div class="col-md-12">
      

    <?php
    //en este bloque php va "mi" código
  
 $this->startBoxPrimary("Gestión de items y existencias");
$this->contentContainerStart();
//////INICIO MI CODIGO
?>
<div class="row">
        <div class="col-md-3">

        </div> <!-- FIN DE COLUMNA 1 -->

        <div class="col-md-6">
        		<div class="box">
            <div class="box-header">
              <h3 class="box-title">Acciones sobre ítems</h3>
            </div>
            <div class="box-body">
              <p>Haga clic en un botón para acceder:</p>
              <a class="btn btn-app" href="out.AnadeItem.php">
                <i class="fa  fa-plus"></i> Añadir ítem
              </a>
              <a class="btn btn-app" href="out.VerItems.php">
              	<span class="badge bg-teal"><?php print contarItems($dms);?></span>
                <i class="fa fa-list-ol"></i> Ver y buscar todos los ítems
              </a> 
              <a class="btn btn-app" href="out.AnadeUbicacion.php">
                
                <i class="fa fa-archive"></i> Añadir ubicación
              </a>
                <a class="btn btn-app" href="out.VerUbicaciones.php">
                  <span class="badge bg-teal"><?php print contarUbicaciones($dms);?></span>
                <i class="fa fa-list-alt"></i> Ver y buscar todas las ubicaciones
              </a> 

        
            </div>
            <!-- /.box-body -->
  </div>
          <!-- /.box -->

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
