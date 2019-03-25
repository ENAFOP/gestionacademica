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
function imprimirItems()
{
  //LOS DEPARTAMENTOS LEIDOS DE LA BD
  $settings = new Settings(); //acceder a parámetros de settings.xml con _antes
    $driver=$settings->_dbDriver;
    $host=$settings->_dbHostname;
    $user=$settings->_dbUser;
    $pass=$settings->_dbPass;
    $base=$settings->_dbDatabase;
  $manejador=new SeedDMS_Core_DatabaseAccess($driver,$host,$user,$pass,$base);
  $estado=$manejador->connect();
  //echo "Conectado: ".$estado;
  if($estado!=1)
  {
    echo "out.AnadePersona.php[]Error: no se pudo conectar a la BD";
  } 
  //query de consulta:
  $miQuery="SELECT nombre,id FROM app_item;";
  //echo "mi query: ".$miQuery;
  $resultado=$manejador->getResultArray($miQuery);
  ////////////////////// EL SELECT
  echo " <select class=\"form-control chzn-select\" id=\"nombreItem\" multiple=\"multiple\" name=\"nombreItem[]\">";

  echo "<option disabled  value>Seleccione uno o varios artículos de la lista</option>";
  foreach ($resultado as $a) 
  {
       echo "<option value=\"".$a['id']."\">".$a['nombre']."</option>";
  }

  echo "</select>";
}// fin de imprimir departamentos

function imprimirReceptores()
{
  //LOS DEPARTAMENTOS LEIDOS DE LA BD
  $settings = new Settings(); //acceder a parámetros de settings.xml con _antes
    $driver=$settings->_dbDriver;
    $host=$settings->_dbHostname;
    $user=$settings->_dbUser;
    $pass=$settings->_dbPass;
    $base=$settings->_dbDatabase;
  $manejador=new SeedDMS_Core_DatabaseAccess($driver,$host,$user,$pass,$base);
  $estado=$manejador->connect();
  //echo "Conectado: ".$estado;
  if($estado!=1)
  {
    echo "out.AnadePersona.php[]Error: no se pudo conectar a la BD";
  } 
  //query de consulta:
  $miQuery="SELECT id,nombre from app_grupos_receptores;";
  //echo "mi query: ".$miQuery;
  $resultado=$manejador->getResultArray($miQuery);
  ////////////////////// EL SELECT
  echo " <select class=\"form-control chzn-select\" id=\"grupoReceptor\" name=\"grupoReceptor\">";
  echo "<option disabled selected value>Seleccione un grupo de la lista</option>";
 
  foreach ($resultado as $a) 
  {
      echo "<option value=\"".$a['id']."\">".$a['nombre']."</option>";   
  }

  echo "</select>";
}// fin de imprimir receptores
class SeedDMS_View_RealizarTransaccion extends SeedDMS_Bootstrap_Style 
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

		$this->htmlStartPage("Realizar ingreso o retiro de artículos", "skin-blue sidebar-mini  sidebar-collapse");
		$this->containerStart();
		$this->mainHeader();
		$this->mainSideBar();
		//$this->contentContainerStart("hoa");
		$this->contentStart();
          
		?>
     <ol class="breadcrumb">
        <li><a href="/out/out.ViewFolder.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Hacer transacción nueva</li>
      </ol>
    <div class="gap-10"></div>
    <div class="row">
    <div class="col-md-12">
      

    <?php
    //en este bloque php va "mi" código
  
 $this->startBoxPrimary("Realizar ingreso o retiro de artículos");
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
              <h3 class="box-title">Datos de la transacción</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
      <form class="form-horizontal" name="formularioGrupo" id="formularioGrupo" action="../out/out.ProcesarTransaccion.php" method="POST" enctype="multipart/form-data">
              <div class="box-body">

              
                <div class="form-group">
                  <label for="nombreItem" class="col-sm-2 control-label">Artículo o lista de artículos que va a retirar o añadir</label>

                  <div class="col-sm-10">
                    <?php imprimirItems()?>
                  </div>
                </div>

          <div class="form-group has-feedback" id="divMostrarNumero">
              <div class="col-sm-10" id="iconito">

         <label id="chequecito" class="control-label" for="inputSuccess" style="display: none;"><i class="fa fa-check"></i>
         </label>
         </div>

        </div>
 


                            <!-- radio -->
                <div class="form-group">
                  <div class="radio">
                    <label>
                      <div class="col-sm-10">
                        <input type="radio" name="radio" id="tomar" value="restar" checked>
                        Voy a tomar o agarrar de estos artículos 
                      </div>                    
                    </label>
                  
                  <div class="radio">
                    <label>
                         <div class="col-sm-10">
                            <input type="radio" name="radio" id="poner" value="sumar">
                           Voy a añadir o reponer de estos artículos
                       </div>
                    </label>
                  </div>
                </div>
                </div>

                <div class="form-group">
                  <label for="cantidad" class="col-sm-2 control-label">Cantidad que va a tomar/añadir</label>

                  <div class="col-sm-10">
                    <input type="number"  class="form-control" id="cantidad" min="1" name="cantidad" placeholder="por ejemplo agarro 30..." required>
                  </div>

                </div> 

                <div class="form-group">
                  <label for="cantidad" class="col-sm-2 control-label">Grupo que va a recibir los materiales entregados:</label>

                  <div class="col-sm-10">
                      <?php imprimirReceptores()?>
                  </div>

                </div> 

                      <div class="form-group has-feedback" id="divPermitirCantidad">
                         <div class="col-sm-10">

                           <label id="chequecito2" class="control-label" for="inputSuccess" style="display: none;"><i class="fa fa-check"></i>
                           </label>
                         </div>

                  </div>


                          
                 <div class="form-group">
                  <label for="motivo" class="col-sm-2 control-label">Motivo de la operación</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="motivo" name="motivo" placeholder="por ejemplo para dar en taller ..." required>
                  </div>
                </div> 

                


              <!-- /.box-body -->
              <div class="box-footer">
                <button type="reset" class="btn btn-default">Borrar campos</button>
                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modal-default">
               Hacer transacción
              </button>
              </div>
              <!-- /.box-footer -->
           
          </div>

          </div>




        </div> <!-- FIN DE COLUMNA 2 -->


        <div class="col-md-3">

        </div> <!-- FIN DE COLUMNA 3 -->
</div> <!-- FIN DE FILA -->
   <div class="modal fade" id="modal-default">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Confirma operación con el artículo?</h4>
              </div>
              <div class="modal-body">
                <p>Esta acción no tiene vuelta atrás </p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary">Proceder</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
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
    echo '<script src="/checkCantidad.js"></script>';
		$this->htmlEndPage();
	} /* }}} */
}
?>
