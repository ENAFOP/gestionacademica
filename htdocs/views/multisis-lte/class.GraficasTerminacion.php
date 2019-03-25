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
function contarTipo($tipo,$fechaInicio,$fechaFin) //le puedo pasar "Anormal " o "Definitiva"
//me da la fecha de la resolución del IAIP
{
	$contador=0;
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
		UI::exitError(getMLText("document_title", array("documentname" => getMLText("invalid_doc_id"))),getMLText("generarExcel: No se pudo conectar a la BD"));
	}	
	//query de consulta:
	if(strcmp($tipo, "Anormal")==0)
	{
		//echo "En anormal";
		$miQuery="SELECT COUNT(*) from tblDocumentAttributes WHERE attrdef=1 and value between '$fechaInicio' and '$fechaFin' and document  in (SELECT document FROM tblDocumentAttributes WHERE attrdef=13 and value='Anormal');";
	}

	if(strcmp($tipo, "Definitiva")==0)
	{
		//echo "En def";
		$miQuery="SELECT COUNT(*) from tblDocumentAttributes WHERE attrdef=1 and value between '$fechaInicio' and '$fechaFin' and document  in (SELECT document FROM tblDocumentAttributes WHERE attrdef=13 and value='Definitiva');";
	}
	//echo "mi query: ".$miQuery;
	$resultado=$manejador->getResultArray($miQuery);
	$contador=$resultado[0]['COUNT(*)'];
	if(!$resultado)
	{
		UI::exitError(getMLText("document_title", array("documentname" => getMLText("invalid_doc_id"))),getMLText("No se pudo generar estádisitcas de tipo de resolución"));
	}
	
	//echo "fecha= ".$fecha;
    return $contador;
} 
class SeedDMS_View_GraficasTerminacion extends SeedDMS_Bootstrap_Style 
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
	

		$this->htmlStartPage("Estadísticas de resoluciones: por tipo de resolución", "skin-blue sidebar-mini sidebar-collapse");
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
  $fechaInicial=$_POST["fechaInicio"];
$fechaFinal=$_POST["fechaFin"];
$inicialFormato=explode("-", $fechaInicial);
$diaInicial=$inicialFormato[0];
$mesInicial=$inicialFormato[1];
$anoInicial=$inicialFormato[2];
$fullInicial=$anoInicial."-".$mesInicial."-".$diaInicial;
//echo "full inicial_ ".$fullInicial;
///////////////////////////////
$finalFormato=explode("-", $fechaFinal);
$diaFinal=$finalFormato[0];
$mesFinal=$finalFormato[1];
$anoFinal=$finalFormato[2];
$fullFinal=$anoFinal."-".$mesFinal."-".$diaFinal;
//echo "full fullFinal ".$fullFinal;
///////////
$numeroAnormales=contarTipo("Anormal",$fullInicial,$fullFinal);
$numeroDefinitivas=contarTipo("Definitiva",$fullInicial,$fullFinal);
$mayorValor=max($numeroDefinitivas,$numeroAnormales);
 $this->startBoxPrimary("Gráfico de resoluciones por tipo, en el perido  ".$fechaInicial." al ".$fechaFinal);
$this->contentContainerStart();

//////INICIO MI CODIGO
?>
   <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo "Existen $numeroDefinitivas resoluciones definitivas y $numeroAnormales anormales para este periodo"  ?></h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div class="chart">
                <canvas id="graficoBarras" style="height:250px"></canvas>
              </div>
             
            </div>
            <!-- /.box-body -->
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
<input type="hidden" id="numeroAnormales" value="<?php echo $numeroAnormales ?>" />
<input type="hidden" id="numeroDefinitivas" value="<?php echo $numeroDefinitivas ?>" />
<input type="hidden" id="mayorValor" value="<?php echo $mayorValor ?>" />
		<?php	
		$this->contentEnd();
		$this->mainFooter();		
		$this->containerEnd();
		//$this->contentContainerEnd();
			//$this->contentContainerEnd();/bower_componentsdatos
  //script que dibuja
   //echo "<script > var actasAhuachapan= $actasAhuachapan; </script>";
    echo '<script type="text/javascript" src="/styles/multisis-lte/bower_components/Chart.js/Chart.js"></script>'."\n"; //agregado 
  // echo "<script type='text/javascript'src='/styles/multisis-lte/bower_components/meterVariables.js'></script>";

  echo "<script type='text/javascript'  src='/styles/multisis-lte/bower_components/datos3.js'></script>";

		$this->htmlEndPage();
	} /* }}} */
}
?>
