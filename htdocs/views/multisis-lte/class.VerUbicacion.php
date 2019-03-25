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
 function dameExistencias($id, $dms)
	 {
	 	$res=true;
		$db = $dms->getDB();
		$consultar = "SELECT cantidad_actual FROM app_item WHERE id=$id;";
		//echo "Consultar: ".$consultar;
		$res1 = $db->getResultArray($consultar);
		return $res1[0]['cantidad_actual'];
	 }
class SeedDMS_View_VerUbicacion extends SeedDMS_Bootstrap_Style 
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
		$idItem = $this->params['idItem'];

		$db = $dms->getDB();
		$previewer = new SeedDMS_Preview_Previewer($cachedir, $previewwidth, $timeout);

		$this->htmlStartPage("Ver detalle de ubicación", "skin-blue sidebar-mini  sidebar-collapse");
		$this->containerStart();
		$this->mainHeader();
		$this->mainSideBar();
		//$this->contentContainerStart("hoa");
		$this->contentStart();
		$consultar = "SELECT * FROM app_ubicacion where id=$idItem;";
        $res1 = $db->getResultArray($consultar);
          
		?>
    <ol class="breadcrumb">
        <li><a href="/out/out.ViewFolder.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="/out/out.GestionarItems.php"> Gestionar items</a></li>
        <li><a href="/out/out.VerUbicaciones.php"> Ver todas las ubicaciones</a></li>
        <li class="active">Ver datos de ubicación</li>
      </ol>
    <div class="gap-10"></div>
    <div class="row">
    <div class="col-md-12">
      

    <?php
    //en este bloque php va "mi" código
  
  $this->startBoxPrimary("Viendo información de la ubicación "."<b>".$res1[0]['nombre']."</b>");
$this->contentContainerStart();
//////INICIO MI CODIGO
?>
<div class="alert alert-info alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-info"></i> En esta pantalla puede ver datos de la ubicación</h4>
               así como editarla
                <br>
              </div>
<?php
 //////FIN MI CODIGO                 
$this->contentContainerEnd();

?>
<div class="row">
	<div class="col-md-3">


        </div>


        <div class="col-md-6">
          <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab">Haga clic en un elemento para editarlo, posteriormente pulse OK</a></li>
              <li ><a href="#tab_2" data-toggle="tab">Foto de la ubicación</a></li>

              <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
              	            <div class="box-body no-padding">
              <table id="tablaEventos" class="table table-hover table-striped table-condensed">
              	<thead>
                <tr>
                  <th>Nombre</th>
                  <th>descipción</th>
             
                </tr>
               </thead>
               <tbody>
                	<?php
            
                	//////////////// DIBUJO TABLA
                	$consultar = "SELECT * FROM app_ubicacion WHERE id=$idItem;";
					//echo "Consultar: ".$consultar;
				  	$res1 = $db->getResultArray($consultar);
                	
                		echo ' <tr>';
                		//1. nombre
                    $idItem=$res1[0]['id'];
                		  echo "<td><a href=\"#\" id=\"nombre\" data-type=\"text\" data-pk=\"$idItem\" data-url=\"/modificarUbicacionEditable.php\" data-title=\"Enter username\">".$res1[0]['nombre']."</a></td>";
                		 //2. fecha de inicio a fin
                		 echo "<td><a href=\"#\" id=\"descripcion\" data-type=\"text\" data-pk=\"$idItem\" data-url=\"/modificarUbicacionEditable.php\" data-title=\"Enter username\">".$res1[0]['descripcion']."</a></td>";
		           
                	                               
                ?>
            </tbody>
              <tfoot>
              </tfoot>
                

               
              </table>
            </div>
            <!-- /.box-body -->
              </div>

               <div class="tab-pane" id="tab_2">

                <img <?php echo "src=\"../images/ubicaciones/ubicacion".$idItem.".jpg\""?> alt="Foto de la ubicación" height="400" width="280">
               </div>

              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- nav-tabs-custom -->
        </div>
        <!-- /.col -->

        <div class="col-md-3">

          <a class="btn btn-app" href="out.VerUbicaciones.php">
                <i class="fa fa-backward"></i> Volver a la lista de ubicaciones
              </a> 

        </div>
        <!-- /.col -->

      </div>



      <!-- /.row -->
 <!-- /.box-header -->

<?php
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
    echo '<script type="text/javascript" src="/styles/'.$this->theme.'/jquery-editable/js/jquery-editable-poshytip.min.js"></script>'."\n";
    echo '<script type="text/javascript" src="/styles/'.$this->theme.'/poshytip-1.2/src/jquery.poshytip.min.js"></script>'."\n";
    echo "<script type='text/javascript' src='/modificarPerfil.js'></script>";
		$this->htmlEndPage();
	} /* }}} */
}
?>
