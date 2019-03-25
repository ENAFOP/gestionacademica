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

class SeedDMS_View_BusquedaAvanzada extends SeedDMS_Bootstrap_Style 
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
		//$ruta_pagina_salida="../out/out.CaducaranPronto.php";
		//////////// COSAS NECESARIAS QUE NO ME PASAN POR FORMULARIO Y LAS CALCULO
		$categories=$dms->getDocumentCategories();
		$allCats = $dms->getDocumentCategories();
		$attrdefs = $dms->getAllAttributeDefinitions(array(SeedDMS_Core_AttributeDefinition::objtype_document, SeedDMS_Core_AttributeDefinition::objtype_documentcontent, SeedDMS_Core_AttributeDefinition::objtype_folder, SeedDMS_Core_AttributeDefinition::objtype_all));
		//echo "categories: ".print_r($categories);

		$this->htmlStartPage(getMLText("buscador_resoluciones_teg"), "skin-blue sidebar-collapse sidebar-mini");
		$this->containerStart();
		$this->mainHeader();
		$this->mainSideBar();
		//$this->contentContainerStart("hoa");
		$this->contentStart();
		$stringFecha="Fecha de resolución";
		$stringDecision="Decisión";
		$stringDeberes="Deberes éticos (Art. 5 LEG)";
		$stringProhibiciones="Prohibiciones éticas (Art. 6 LEG)";
          
		?>
    <div class="gap-10"></div>
    <div class="row">
    <div class="col-md-12">

   <section class="content-header">
      <h1>
       Buscador de resoluciones
        <small>del Tribunal de Ética Gubernamental</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="http://teg.gob.sv/"><i class="fa fa-dashboard"></i>Inicio</a></li>
        <li><a href="#">Buscador de resoluciones</a></li>
        <li><a href="#">Búsqueda avanzada</a></li>
        
      </ol>
    </section>

     <div class="row">
        <div class="col-xs-12">
          <div class="box box-default">
          
            <div class="box-body">

                <a href="/out/out.BusquedaSimple.php" button type="button" class="btn btn-default" role="button"><i class="fa fa-search"></i>
                Búsqueda simple
              </a>
              <a href="#" button type="button" class="btn btn-default" role="button"><i class="fa fa-search-plus"></i>
                Búsqueda avanzada
              </a>
                <a href="/out/out.Tesauro.php" button type="button" class="btn btn-default" role="button"><i class="fa fa-gavel"></i>
                Tesauro de tipologías
              </a>
               
           

            </div>
          </div>
        </div>
      </div>
   <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-sticky-note"></i> Este es el buscador avanzado de resoluciones del TEG</h4>
               
			   Para realizar una búsqueda avanzada:
			   </br>
			   (1) Ingrese los términos de interés (palabra o frase) o puede dejar ese espacio en blanco.
			   </br>
              (2) Delimite su búsqueda haciendo click en los espacios sugeridos y rellenando la información requerida (se puede rellenar uno o más campos).
			  </br>
               (3) Presionar el botón Buscar resoluciones.
            
              </div>

   <!-- INICIO DEL FORMULARIO -->
  <form action="../out/out.Search.php" name="busquedaAvanzada" id="busquedaAvanzada">
     <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Ingrese los términos de interés</h3>

 
             </div>
            <!-- /.box-header -->
            <!-- form start -->
        
              <div class="box-body">
         
                <div class="form-group">
                  
                  <!--  <input type="text" class="form-control" name="terminos" placeholder="Términos de búsqueda"> -->
                    <input type="text" name="query" class="form-control input-lg " placeholder="<?php echo getMLText("ingrese_termino"); ?>">  
		            <label class="h4">
			            <div class="icheckbox_flat-green" aria-checked="false" aria-disabled="false" style="position: relative;">
				            <input type="checkbox" class="flat-red" id="frase-exacta" name="fraseExacta" style="position: relative; opacity: 0;">
				            <ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 10px; background: rgb(255, 255, 255); border: 0px; opacity: 0;">
				            </ins>
				        </div>&nbsp;
				        	<?php echo getMLText("frase_exacta"); ?>
		            </label>
                </div>
            
              </div>
              <!-- /.box-body -->
          </div>      

		    <!-- SEGUNDA CAJA: DELIMITACIÓN DE LA BÚSQUEDA -->        			             

<div class="box box-success" id="">
  <div class="box-header with-border">
    <h3 class="box-title"><?php printMLText('delimite_busqueda'); ?></h3>
		<div class="box-tools pull-right">
    	<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
    </div>
  </div>
  <div class="box-body">
				<table class="table">

<!-- ....................................INICIO DE PONER CAJAS DE BUSQUEDA CON ATRIBUTOS ............................................. -->   

 <!-- ENTRADA EN LA TABLA: DE RANGO DE FECHAS -->    	
				<tr>		
				<td><?php printMLText("rango_fechas");?>
				</td>			
				<td>
	 <?php $creationdate=FALSE ?>
       <!--  <label class="checkbox inline">
				  <input type="checkbox" name="quieroRango" value="true" <?php if($creationdate) echo "checked"; ?>/><?php printMLText("quiero rango");?>
        </label><br />
        &nbsp; -->
 <label>Fecha inicial: </label>
   <span class="input-append date" style="display: inline;" id="createstartdate" data-date="<?php echo date('d-m-Y'); ?>" data-date-format="dd-mm-yyyy" data-date-language="<?php echo str_replace('_', '-', $this->params['session']->getLanguage()); ?>">
          <input class="span4 form-control" size="16" id="fechaInicio" name="fechaInicio" type="text" placeholder="Ingrese fecha inicial">
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
          <input class="span4 form-control" size="16" name="fechaFin" id="fechaFin" type="text" placeholder="Ingrese fecha final"> 
          <span class="add-on"><i class="icon-calendar"></i></span>
        </span>

</td>

<div id="errores"></div>
				</tr>
 			<!--******************** FIN DE RANCO DE FECHAS ***************-->  

 					 <!-- ENTRADA EN LA TABLA: DE FECHA EXACTA -->    	
				<tr>					
				<td><?php printMLText("fecha_exacta");?>
				</td>

				<td>
					<?php 
					$atributoFecha=$dms->getAttributeDefinitionByName($stringFecha);
					//echo "di attributo fecha: ".$atributoFecha->getID();
					$this->printAttributeEditField($atributoFecha, $atributoFecha->getID(),'attributes', true);

					?>
				
		
				</td>
				</tr>
 			<!-- FIN DE FECHA EXACTA****************************************** -->   

 					 <!-- ENTRADA EN LA TABLA: DE DECISION DE RESOLUCION -->    	
				<tr>					
				<td><?php printMLText("decision");?>
				</td>

				<td>
					<?php 
					$atributoDecision=$dms->getAttributeDefinitionByName($stringDecision);
					//echo "di attributo fecha: ".$atributoFecha->getID();
					$this->printAttributeEditField($atributoDecision, $atributoDecision->getID(),'attributes', true);

					?>
				
		
				</td>
				</tr>
 			<!-- FIN DE TIPO DE RESOLUCION****************************************** -->   



		 <!-- ENTRADA EN LA TABLA: DE TIPOLOGIA -->    	
				<tr>					
				<td><?php printMLText("category");?>:
				</td>

				<td>
				<select class="mario" name="categoryids[]" id="tipologias" multiple="multiple" data-placeholder="<?php printMLText('select_category'); ?>" data-no_results_text="<?php printMLText('unknown_document_category'); ?>">
				<!--
				<option value="-1"><?php printMLText("all_categories");?>
				-->
				<?php
						$tmpcatids = array();
						foreach($categories as $tmpcat)
							$tmpcatids[] = $tmpcat->getID();
						   
						foreach ($allCats as $catObj) {
							print "<option value=\"".$catObj->getID()."\" ".(in_array($catObj->getID(), $tmpcatids) ? "" : "").">" . htmlspecialchars($catObj->getName()) . "\n";
						}						
				?>
				</select>
				</td>
				</tr>


 			<!-- FIN DE TIPOLOGÍA -->  
 			 <!-- ENTRADA EN LA TABLA: DEBER ETICO ARTICULO 6 --> 


				<tr>					
				<td><?php echo "Filtrar por deberes y prohibiciones éticas <br>(ley derogada y vigente)"?>:
				</td>
				<td>
					<?php 

					// 	$stringLey="Ley";
					// $atrLey=$dms->getAttributeDefinitionByName($stringLey);
					// //echo "di attributo fecha: ".$atributoFecha->getID();
					// $this->printAttributeEditField2($atrLey, $atrLey->getID(),'attributes', true);

					 $titulos=array("Ley vigente","Ley derogada");
				  echo " <select class=\"form-control select\"  id=\"ley\">";
				  echo "<option disabled selected value>Seleccione ley</option>";
				    foreach ($titulos as $doc) 
				    {
				    echo "<option value=\"".$doc."\">".$doc."</option>";
				  } //fin del bucle
					echo "</select>";



					?>				
				</td>
				</tr>  

 					 <!-- ENTRADA EN LA TABLA: DEBER ETICO ARTICULO 5 -->    	
				<tr style="display: none;" id="deberesDerogados">					
				<td><?php printMLText("deber_etico");?>:
				</td>
				<td>
					<?php 
					$atributoDeberes=$dms->getAttributeDefinitionByName($stringDeberes);
					//echo "di attributo fecha: ".$atributoFecha->getID();
					$this->printAttributeEditField2($atributoDeberes, $atributoDeberes->getID(),'attributes', true);
					?>		
				</td>
				</tr>
					 <!-- Adenda 2018: deber etico, legislación vigente --> 

				<tr style="display: none;" id="deberesVigentes">					
				<td><?php echo "Deber ético (Art. 5 de la LEG, legislación vigente)";?>:
				</td>
				<td>
					<?php 
					$stringDeberesVigentes="Deberes éticos (Art. 5 legislación vigente)";
					$atributoDeberesVigentes=$dms->getAttributeDefinitionByName($stringDeberesVigentes);
					//echo "di attributo fecha: ".$atributoFecha->getID();
					$this->printAttributeEditField2($atributoDeberesVigentes, $atributoDeberesVigentes->getID(),'attributes', true);
					?>		
				</td>
				</tr>
 			<!-- FIN DE ART 5****************************************** -->   

 				 <!-- ENTRADA EN LA TABLA: DEBER ETICO ARTICULO 6 -->    	
				<tr style="display: none;" id="prohibicionesDerogadas">					
				<td><?php printMLText("prohibiciones_eticas");?>:
				</td>
				<td>
					<?php 
					$atributoProhiciones=$dms->getAttributeDefinitionByName($stringProhibiciones);
					//echo "di attributo fecha: ".$atributoFecha->getID();
					$this->printAttributeEditField2($atributoProhiciones, $atributoProhiciones->getID(),'attributes', true);
					?>				
				</td>
				</tr>
					 <!-- Adenda 2018: prohibicion etico, legislación vigente --> 

				<tr style="display: none;" id="prohibicionesVigentes">					
				<td><?php echo "Prohibición ética (Art. 6 de la LEG, legislación vigente)";?>:
				</td>
				<td>
					<?php 
					$stringProhibicionesVigentes="Prohibiciones éticas (Art. 6 legislación vigente)";
					$atributoProhibicionesVigentes=$dms->getAttributeDefinitionByName($stringProhibicionesVigentes);
					//echo "di attributo fecha: ".$atributoFecha->getID();
					$this->printAttributeEditField2($atributoProhibicionesVigentes, $atributoDeberesVigentes->getID(),'attributes', true);
					?>		
				</td>
				</tr>
 			<!-- FIN DE ART 6****************************************** -->   



				</table>

    </div>
<td>
     
                	  <input type="hidden" name="vengoDeBusquedaAvanzada" value="">

			</td>
    		<div class="box-footer">
    			<div class="form-group">
    			    <label>Máximo de registros que devolverá la búsqueda: (arrastre el botón para modificar el número)</label> 
					<input id="ex6" name="limiteResultados" type="text" data-slider-min="10" data-slider-max="300" data-slider-step="10" data-slider-value="50" data-slider-id='ex1Slider'/>
					<span id="ex6CurrentSliderValLabel">Número máximo de resultados que se mostrarán  para su búsqueda: <span id="ex6SliderVal">50</span>
					</span>

              	</div>
                <div class='text-center'>
	            	<div class="center btn-group">
	              		  <!-- <input type="reset" id="form_reset2" value="Reset Me - Click Only Once" /> -->
	              		
	              		<button type="reset" id="form_reset2" class="center-block btn  btn-warning btn-lg"><i class="icon-search"></i> <?php printMLText("borrar_formulario"); ?>
			            </button>	  			             
		            </div>
		         </div>

              </div>
  </div>
     <!-- Block buttons -->
          <div class="box">
           
            <div class="box-body">
              <button id="submit" type="submit" class="center-block btn  btn-success btn-lg"><i class="fa fa-search"></i> <?php printMLText("buscar_resoluciones"); ?>
			               </button>
            </div>
          </div>
          <!-- /.box -->
   
  </form>
<?php
 //////FIN MI CODIGO                 
//$this->contentContainerEnd();
//$this->endsBoxPrimary();
     ?>
	     </div>
		</div>
		</div>

		<?php	
		$this->contentEnd();
		$this->mainFooter();		
		$this->containerEnd();

		//$this->contentContainerEnd();
	//echo "<script type='text/javascript' src='/styles/multisis-lte/plugins/resetearChosen.js'></script>";
	echo "<script type='text/javascript' src='/styles/multisis-lte/plugins/bootstrap-slider/bootstrap-slider.js'></script>";
    echo "<script type='text/javascript' src='/styles/multisis-lte/plugins/bootstrap-slider/hacer.js'></script>";
	echo "<script type='text/javascript' src='/validarDinamico.js'></script>";
    echo "<script type='text/javascript' src='/styles/multisis-lte/plugins/iCheck/icheck.js'></script>\n";
    echo "<script type='text/javascript' src='/js/BusquedaSimple.js'></script>\n";

		$this->htmlEndPage();
	} /* }}} */
}
?>
