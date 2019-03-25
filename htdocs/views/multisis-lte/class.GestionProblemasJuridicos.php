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
function obtenerProblemasJuridicos($dms) //ddodo un id de documento que ha sido revocada la reserva,
//me da la fecha de la resolución del IAIP
{
	$resultado=array();
	//echo "Función getDefaultUserFolder. Se ha pasado con argumento: ".$id_usuario;
	
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
		UI::exitError(getMLText("document_title", array("documentname" => getMLText("invalid_doc_id"))),getMLText(".GestionProblemasJuridicos: No se pudo conectar a la BD"));
	}	
	//query de consulta:
	$miQuery="SELECT fechaResolucion FROM seeddms.revocacionreservas WHERE idDocumento=".$documento;
	//echo "mi query: ".$miQuery;
	$resultado=$manejador->getResultArray($miQuery);
	//echo "fecha= ".$fecha;
    if(!$resultado)
	{
		UI::exitError(getMLText("document_title", array("documentname" => getMLText("invalid_doc_id"))),getMLText("Indice desclasificados: Parece ser que hubo un error obteniendo la fecha de revocación de la reserva del documento."));
	}
	$fecha=$resultado[0]['fechaResolucion'];
	//echo "id_folder: ".$id_folder;
	return $fecha;
}
class SeedDMS_View_GestionProblemasJuridicos extends SeedDMS_Bootstrap_Style 
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
		$confirmacionEliminado = $this->params['confirmacionEliminado'];
		$confirmacionSubida = $this->params['confirmacionSubida'];
		

		$db = $dms->getDB();
		$previewer = new SeedDMS_Preview_Previewer($cachedir, $previewwidth, $timeout);
		$ruta_pagina_salida="../out/out.CaducaranPronto.php";

		$this->htmlStartPage(getMLText("mi_sitio"), "skin-blue sidebar-mini");
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
  
 $this->startBoxPrimary("Consultar problemas jurídicos y añadir uno nuevo");
$this->contentContainerStart();
//////INICIO MI CODIGO
/*echo "<div class=\"box box-solid\">";
           echo  "<div class=\"box-header with-border\">";
              echo "<i class=\"fa fa-text-width\"></i>";

              echo "<h3 class=\"box-title\">Problemas jurídicos existentes</h3>";
            echo "</div>";
            
            echo "<div class=\"box-body\">";
              echo "<ul>";
              $atributoProblema=$dms->getAttributeDefinitionByName("Problema jurídico");
              $resultado=$atributoProblema->getValueSetAsArray();
               foreach ($resultado as $res) 
               {
               	    echo "<li>".$res."</li>";
               }
              echo "</ul>";
            echo "</div>";
          echo "</div>";*/

        echo $confirmacionSubida;
        echo $confirmacionEliminado;

            echo "<div class=\"box box-default collapsed-box\">";
            echo "<div class=\"box-header with-border\">";
              echo "<h3 class=\"box-title\">Problemas jurídicos actuales</h3>";
              	echo "<h5>Haga click en la cruz para desplegar, y a continuación, escriba los términos necesarios para buscar un problema jurídico en particular</h5>";
              echo "<div class=\"box-tools pull-right\">";
                echo "<button type=\"button\" class=\"btn btn-box-tool\" data-widget=\"collapse\"><i class=\"fa fa-plus\"></i>";
                echo "</button>";
              echo "</div>";
            
            echo "</div>";
           
            echo "<div class=\"box-body\">";
              $atributoProblema=$dms->getAttributeDefinitionByName("Problema jurídico");

               $this->printAttributeEditField($atributoProblema, $atributoProblema->getID(),'attributes', true);
           echo "</div>";
          
          echo "</div>";


 ?>  

		  
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Agregar nuevo problema jurídico</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" method="post" name="subirProblema" action="/subirProblema.php">
              <div class="box-body">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Subir un nuevo problema jurídico al sistema</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="nuevoProblema" name="nuevoProblema" placeholder="Ingrese el nuevo problema jurídico en el sistema..." required>
                  </div>
                </div>
       
             
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="reset" class="btn btn-default">Cancelar</button>
                <button type="submit" class="btn btn-info pull-right">Añadir problema jurídico</button>
              </div>
              <!-- /.box-footer -->
            </form>
          </div>

          <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">Eliminar un problema jurídico</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" method="post" name="eliminarProblema" action="/eliminarProblema.php">
              <div class="box-body">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Seleccione el problema jurídico que desea eliminar</label>

                  <div class="col-sm-10">
                    	<?php 
                  $atributoProblema=$dms->getAttributeDefinitionByName("Problema jurídico");
              	 $this->printAttributeEditField($atributoProblema, $atributoProblema->getID(),'attributes', true);
              
                   ?>
                  </div>
                </div>
       
             
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="reset" class="btn btn-default">Cancelar</button>
                <button type="submit" class="btn btn-info pull-right">Eliminar problema jurídico</button>
              </div>
              <!-- /.box-footer -->
            </form>
          </div>


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
