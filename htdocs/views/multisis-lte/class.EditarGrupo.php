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
function convertirFecha($fecha) //convierte una fecha en formato año-mes-dia a dia-mes-añño
{
$newDate = date("d-m-Y", strtotime($fecha));
return  $newDate;
}
class SeedDMS_View_EditarGrupo extends SeedDMS_Bootstrap_Style 
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
		$idGrupo = $this->params['idGrupo'];

		$db = $dms->getDB();
		$previewer = new SeedDMS_Preview_Previewer($cachedir, $previewwidth, $timeout);

		$this->htmlStartPage("Edición de grupos", "skin-blue sidebar-mini  sidebar-collapse");
		$this->containerStart();
		$this->mainHeader();
		$this->mainSideBar();
		//$this->contentContainerStart("hoa");
		$this->contentStart();
    $consultar = "SELECT * FROM app_grupo where id=$idGrupo;";
    $res1 = $db->getResultArray($consultar);
          
		?>
    <div class="gap-10"></div>
    <div class="row">
    <div class="col-md-12">
      

    <?php
    //en este bloque php va "mi" código
  
 $this->startBoxPrimary("Editanto el grupo "."<b>".$res1[0]['nombre']."</b>");
$this->contentContainerStart();
//////INICIO MI CODIGO
//echo "id a editar: ".$idEvento;
	
				  	?>
 <div class="alert alert-info alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-info"></i> En esta pantalla puede editar datos del grupo</h4>
                Tales como el nombre y descripción relacionadas.
                <br> Haga click en un elemento, editelo en el cuadro que aparece y presione el botón OK para realizar los cambios. El botón cancel deshace todo cambio.
              </div>

				  	<div class="box-body no-padding">
              <table id="tablaEditarGrupos" class="table table-hover table-striped table-condensed">
              	<thead>
                <tr>
                  <th>Nombre del grupo</th>
                  <th>Descripción</th>            
                </tr>
               </thead>
               <tbody>
               	<?php
               			
					//echo "Consultar: ".$consultar;
				    	
                		echo ' <tr>';
                		//1. nombre
                	   //pk vendría a ser el primary KEY SEGUN BASE DE DATOS, ES DECIR, EL ID DE grupo QUE DEFINÍ.
                		 echo "<td><a href=\"#\" id=\"nombre\" data-type=\"text\" data-pk=\"$idGrupo\" data-url=\"/modificarGrupoEditable.php\" data-title=\"Enter nombre\">".$res1[0]['nombre']."</a></td>";
                		 //2. descripcion
                		 echo "<td><a href=\"#\" id=\"descripcion\" data-type=\"text\" data-pk=\"$idGrupo\" data-url=\"/modificarGrupoEditable.php\" data-title=\"Enter descripcion\">".$res1[0]['descripcion']."</a></td>";
                		 echo ' <tr>';
                	
                	
               	?>

               	 </tbody>
              <tfoot>
              </tfoot>
                

               
              </table>
          </div>
          <p>-----------------------------------------------------------------</p>
          <a href="/out/out.VerGrupos.php"><b> Volver a la lista de grupos</b></a>

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
		echo '<script type="text/javascript" src="/styles/'.$this->theme.'/jquery-editable/js/jquery-editable-poshytip.min.js"></script>'."\n";
		echo '<script type="text/javascript" src="/styles/'.$this->theme.'/poshytip-1.2/src/jquery.poshytip.min.js"></script>'."\n";
		echo "<script type='text/javascript' src='/modificarPerfil.js'></script>";
		$this->htmlEndPage();
	} /* }}} */
}
?>
