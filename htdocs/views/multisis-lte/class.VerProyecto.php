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

    function dimeUbicaciones($id, $dms)
   {
    $res=true;
    $db = $dms->getDB();
    $consultar = "SELECT id_ubicacion FROM app_ubicacion_item WHERE id_item=$id;";
    //echo "Consultar: ".$consultar;
    $res1 = $db->getResultArray($consultar);
    $ubicaciones=array();
    foreach ($res1 as $ubics) 
    {
      $idUbicacion=$ubics['id_ubicacion'];
      array_push($ubicaciones, $idUbicacion);
      $consultar2 = "SELECT nombre,descripcion FROM app_ubicacion WHERE id=$idUbicacion;";
       $res2 = $db->getResultArray($consultar2);
      foreach ($res2 as $a) 
      {
          $nombre=$a['nombre'];
          $com=$a['descripcion'];
          print "<p>$nombre</p> <br>";
          print "<p>($com)</p>";
          print "--------------";
      }
    }
    
     
     
     
    

   }
class SeedDMS_View_VerProyecto extends SeedDMS_Bootstrap_Style 
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

		$this->htmlStartPage("Ver detalle de proyecto", "skin-blue sidebar-mini  sidebar-collapse");
		$this->containerStart();
		$this->mainHeader();
		$this->mainSideBar();
		//$this->contentContainerStart("hoa");
		$this->contentStart();
		$consultar = "SELECT * FROM app_proyecto where id=$idItem;";
    //echo "consultar: ".$consultar;
        $res1 = $db->getResultArray($consultar);
          
		?>
    <ol class="breadcrumb">
        <li><a href="/out/out.ViewFolder.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="/out/out.GestionarItems.php"> Gestionar proyectos</a></li>
        <li><a href="/out/out.VerItems.php"> Ver la lista de proyectos</a></li>
        <li class="active">Ver y editar proyecto</li>
      </ol>
    <div class="gap-10"></div>
    <div class="row">
    <div class="col-md-12">
      

    <?php
    //en este bloque php va "mi" código
  
  $this->startBoxPrimary("Viendo información del proyecto "."<b>".$res1[0]['nombre']."</b>");
$this->contentContainerStart();
//////INICIO MI CODIGO
?>
<div class="alert alert-info alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-info"></i> En esta pantalla puede ver información del proyecto</h4>
                <br>
              </div>
<?php
 //////FIN MI CODIGO                 


?>
<div class="row">
	<div class="col-md-3">

        </div>


        <div class="col-md-6">
          <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab">Información</a></li>
              <li><a href="#tab_2" data-toggle="tab">Que artículos se compraron en este proyecto</a></li>
              <li><a href="#tab_3" data-toggle="tab">Datos de gasto</a></li>

              <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
              	            <div class="box-body no-padding">
              <table id="tablaEventos" class="table table-hover table-striped table-condensed">
              	<thead>
                <tr>
                  <th>Nombre</th>
                  <th>Origen de fondos</th>
                  <th>Código SETEFE</th>
                  <th>Fecha de finalización</th>
                  <th>Monto total del proyecto</th>
                  <th>Monto de activos y materiales</th>
                  <th>Monto asignado a material divulgativo</th>                 
                </tr>
               </thead>
               <tbody>
                	<?php
            
                	//////////////// DIBUJO TABLA
                	$consultar = "SELECT * FROM app_proyecto WHERE id=$idItem;";
					//echo "Consultar: ".$consultar;
				  	$res1 = $db->getResultArray($consultar);
                	
                		echo ' <tr>';
                		//1. nombre
                    $idItem=$res1[0]['id'];
                		 echo "<td><a href=\"#\" id=\"nombre\" data-type=\"text\" data-pk=\"$idItem\" data-url=\"/modificarProyectoEditable.php\" data-title=\"Enter username\">".$res1[0]['nombre']."</a></td>";
                		 //2. fecha de inicio a fin
                		 echo "<td><a href=\"#\" id=\"origen_fondos\" data-type=\"text\" data-pk=\"$idItem\" data-url=\"/modificarProyectoEditable.php\" data-title=\"Enter username\">".$res1[0]['origen_fondos']."</a></td>";
                		  // 3. lugar
                		  echo "<td><a href=\"#\" id=\"codigo_setefe\" data-type=\"text\" data-pk=\"$idItem\" data-url=\"/modificarProyectoEditable.php\" data-title=\"Enter username\">".$res1[0]['codigo_setefe']."</a></td>";
                      /////////////////////
                      $fechitaFormateada= date("d-m-Y", strtotime($res1[0]['fecha_finalizacion']));
                		  echo "<td><a href=\"#\" id=\"fecha_finalizacion\" data-type=\"combodate\"  data-pk=\"$idItem\" data-url=\"/modificarProyectoEditable.php\" data-title=\"Enter username\">".$fechitaFormateada."</a></td>";
                      //////////////////////////////////
                		  echo "<td><a href=\"#\" id=\"monto_total\" data-type=\"number\" step=\"any\" data-pk=\"$idItem\" data-url=\"/modificarProyectoEditable.php\" data-title=\"Enter username\">".$res1[0]['monto_total']."</a></td>";
                      ///////////////////////
                		  echo "<td><a href=\"#\" id=\"monto_bienes\" data-type=\"number\" data-pk=\"$idItem\" data-url=\"/modificarProyectoEditable.php\" data-title=\"Enter username\">".$res1[0]['monto_bienes']."</a></td>";
                		  // 4. enlace para editar
                		 echo "<td><a href=\"#\" id=\"monto_materiales\" data-type=\"text\" data-pk=\"$idItem\" data-url=\"/modificarProyectoEditable.php\" data-title=\"Enter username\">".$res1[0]['monto_materiales']."</a></td>";

                     echo ' </tr>';		           
                	                               
                ?>
            </tbody>
              <tfoot>
              </tfoot>
                

               
              </table>
            </div>
            <!-- /.box-body -->
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_2">
                <p>Las transacciones están ordenadas desde la más reciente</p>
                <table id="tablaEventos" class="table table-hover table-striped table-condensed">
                <thead>
                <tr>
                  <th>Fecha de la operación</th>
                  <th>Persona que lo hizo</th>
                  <th>Razón</th>
                  <th>Cantidad de artículos tomados/puestos</th>
                
                </tr>
               </thead>
               <tbody>
                                  <?php            
                  //////////////// DIBUJO TABLA
                  $consultar = "SELECT * FROM app_transaccion WHERE id_item=$idItem ORDER BY fecha DESC;";
          //echo "Consultar: ".$consultar;
            $res1 = $db->getResultArray($consultar);
                  
                    foreach ($res1 as $transa) 
                    {
                      echo ' <tr>';
                    //1. fecha
                    $idItem=$res1[0]['id_item'];
                     echo "<td>".$transa['fecha']."</td>";
                     
                     //// 2 persona
                     $idUsuario=$transa['id_usuario'];
                     $usuario=$dms->getUser($idUsuario);
                     $nombreUser=$usuario->getFullName();
                     echo "<td>".$nombreUser."</td>";
                     /// 3 razon
                     echo "<td>".$transa['razon']."</td>";

                     /// 4 cantidad
                      echo "<td>".$transa['cantidad_variada']."</td>";

                     //
                       echo ' </tr>';                                                                 
                    }//fin foreach transaccion
                ?>
                 </tbody>
              <tfoot>
              </tfoot>              
              </table>
                
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_3">

                   <img <?php echo "src=\"/images/items/item".$idItem.".jpg\""?> alt="Foto del artículo" height="400" width="280">
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- nav-tabs-custom -->
        </div>
        <!-- /.col -->

        <div class="col-md-3">

      

        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
 <!-- /.box-header -->

<?php
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
        echo '<script type="text/javascript" src="/styles/'.$this->theme.'/jquery-editable/js/jquery-editable-poshytip.min.js"></script>'."\n";
    echo '<script type="text/javascript" src="/styles/'.$this->theme.'/poshytip-1.2/src/jquery.poshytip.min.js"></script>'."\n";
    echo "<script type='text/javascript' src='/modificarPerfil.js'></script>";
		$this->htmlEndPage();
	} /* }}} */
}
?>
