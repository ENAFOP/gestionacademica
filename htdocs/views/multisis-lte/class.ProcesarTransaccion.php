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
function dameArrayDeNombres($arrayDeIDs,$dms) 
{
	$arrayNombres=array();
	$db = $dms->getDB();
	foreach ($arrayDeIDs as $id) 
	{
		$consultar="SELECT nombre FROM app_item WHERE id=$id";
		$res2 = $db->getResultArray($consultar);

		$nombrecito=$res2[0]['nombre'];
		array_push($arrayNombres, $nombrecito);
	}
		
		return $arrayNombres;
}
class SeedDMS_View_ProcesarTransaccion extends SeedDMS_Bootstrap_Style 
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
		////////del form
		$idItem = $this->params['idItem'];
		$motivo = $this->params['motivo'];
		$cantidad = $this->params['cantidad'];
		$operacion = $this->params['operacion'];
		$arrayNuevaCantidad = $this->params['arrayNuevaCantidad'];
		$arrayIdItems = $this->params['arrayIdItems'];
		$nombres=dameArrayDeNombres($arrayIdItems,$dms);


		
		$previewer = new SeedDMS_Preview_Previewer($cachedir, $previewwidth, $timeout);

		$this->htmlStartPage("Operación realizada", "skin-blue sidebar-mini  sidebar-collapse");
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
  
 $this->startBoxPrimary("Item creado con éxito");
$this->contentContainerStart();
//////INICIO MI CODIGO
?>
          <div class="box box-default">
            <div class="box-header with-border">
              <i class="fa fa-bullhorn"></i>

              <h3 class="box-title">Operación registrada con éxito</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            
              <div class="callout callout-success">
                <h4>Resumen de las transacciones:</h4>
				 <table class="table table-bordered">
                <tr>
                  <th>Nombre del artículo</th>
                  <th style="width: 10px">Nueva cantidad</th>
                </tr>
                <?php 
                $cont=0;
                foreach ($nombres as $nom) 
                {
                	//echo "Nombre del item: ".$nom
                echo '<tr>';
                   echo "<td>$nom</td>";
                   echo "<td>".$arrayNuevaCantidad[$cont]."</td>";
                echo '<tr>';
                $cont++;
                }
                
                ?>
              </table>
		     </div>
            </div>
            <!-- /.box-body -->

            <a href="out/out.ViewFolder.php"><b>Retornar al inicio</b></a>
          </div>
          <!-- /.box -->
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
