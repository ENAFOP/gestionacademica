<?php
/**
 * Implementation of Search result view
 *
 * @category   DMS
 * @package    SeedDMS
 * @license    GPL 2
 * @version    @version@
 * @author     Uwe Steinmann <uwe@steinmann.cx>
 * @copyright  Copyright (C) 2002-2005 Markus Westphal,
 *             2006-2008 Malcolm Cowe, 2010 Matteo Lucarelli,
 *             2010-2012 Uwe Steinmann
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
 * Class which outputs the html page for Search result view
 *
 * @category   DMS
 * @package    SeedDMS
 * @author     Markus Westphal, Malcolm Cowe, Uwe Steinmann <uwe@steinmann.cx>
 * @copyright  Copyright (C) 2002-2005 Markus Westphal,
 *             2006-2008 Malcolm Cowe, 2010 Matteo Lucarelli,
 *             2010-2012 Uwe Steinmann
 * @version    Release: @package_version@
 */
 function add3dots($string, $repl, $limit) 
{
  if(strlen($string) > $limit) 
  {
    return substr($string, 0, $limit) . $repl; 
  }
  else 
  {
    return $string;
  }
}
function tomarTres($array,$i) //dado un array tomar 3 elementos a partir del índice i
	{
		return $array[$i].$array[$i+1].$array[$i+2];
	}
class SeedDMS_View_Search extends SeedDMS_Bootstrap_Style {

	/**
	 * Mark search query sting in a given string
	 *
	 * @param string $str mark this text
	 * @param string $tag wrap the marked text with this html tag
	 * @return string marked text
	 */
	function esMultiploTres($numero)
	{
		return $numero%3==0;
	}

	

	function markQuery($str, $tag = "b") { /* {{{ */
		$querywords = preg_split("/ /", $this->query);
		
		foreach ($querywords as $queryword)
			$str = str_ireplace("($queryword)", "<" . $tag . ">\\1</" . $tag . ">", $str);
		
		return $str;
	} /* }}} */

	function js() { /* {{{ */
		header('Content-Type: application/javascript; charset=UTF-8');

		parent::jsTranslations(array('cancel', 'splash_move_document', 'confirm_move_document', 'move_document', 'splash_move_folder', 'confirm_move_folder', 'move_folder'));

		$this->printFolderChooserJs("form1");
		$this->printDeleteFolderButtonJs();
		$this->printDeleteDocumentButtonJs();
		
	} /* }}} */

	function show() { /* {{{ */
		$dms = $this->params['dms'];
		$user = $this->params['user'];
		$fullsearch = $this->params['fullsearch'];
		$totaldocs = $this->params['totaldocs'];
		$totalfolders = $this->params['totalfolders'];
		$attrdefs = $this->params['attrdefs'];
		$allCats = $this->params['allcategories'];
		$allUsers = $this->params['allusers'];
		$mode = $this->params['mode'];
		$resultmode = $this->params['resultmode'];
		$workflowmode = $this->params['workflowmode'];
		$enablefullsearch = $this->params['enablefullsearch'];
		$enableclipboard = $this->params['enableclipboard'];
		$attributes = $this->params['attributes'];
		$categories = $this->params['categories'];
		$owner = $this->params['owner'];
		$startfolder = $this->params['startfolder'];
		$startdate = $this->params['startdate'];
		$stopdate = $this->params['stopdate'];
		$expstartdate = $this->params['expstartdate'];
		$expstopdate = $this->params['expstopdate'];
		$creationdate = $this->params['creationdate'];
		$expirationdate = $this->params['expirationdate'];
		$status = $this->params['status'];
		$this->query = $this->params['query'];
		$entries = $this->params['searchhits'];
		$totalpages = $this->params['totalpages'];
		$pageNumber = $this->params['pagenumber'];
		$searchTime = $this->params['searchtime'];
		$urlparams = $this->params['urlparams'];
		$searchin = $this->params['searchin'];
		$cachedir = $this->params['cachedir'];
		$previewwidth = $this->params['previewWidthList'];
		$timeout = $this->params['timeout'];
		$limiteResultados = $this->params['limiteResultados'];
		$vengoAvanzada = $this->params['vengoAvanzada'];
		$quieroRango = $this->params['quieroRango'];
		if($quieroRango==TRUE)
		{
			$fechaInicio = $this->params['fechaInicio'];
			$fechaFin = $this->params['fechaFin'];
		}
		//strings parametizables
		$stringFecha="Fecha de resolución";
		$stringProblema="Problema jurídico";
		$stringRatio="Fundamento";
		$stringDecision="Decisión";
		$arrayReferencias=array();
			$arrayFechas=array();
			$arrayTipologias=array();
			$arrayProblemas=array();
			$arrayDecisiones=array();
			$arrayRatios=array();
			$busqueda="";

		$this->htmlAddHeader('<script type="text/javascript" src="../styles/'.$this->theme.'/plugins/bootbox/bootbox.min.js"></script>'."\n", 'js');

		$this->htmlStartPage(getMLText("search_results"), "skin-blue sidebar-collapse sidebar-mini
			");
		$this->containerStart();
		$this->mainHeader();		
		$this->mainSideBar();
		$this->contentStart();
?>
    <div class="gap-10"></div>
    <div class="row">
    <div class="col-md-12">

  <div class="row">
        <div class="col-xs-12">
          <div class="box box-default">
          
            <div class="box-body">

              <a href="/out/out.BusquedaSimple.php" button type="button" class="btn btn-default" role="button"><i class="fa fa-search"></i>
                Búsqueda simple
              </a>

              <a href="/out/out.BusquedaAvanzada.php" button type="button" class="btn btn-default" role="button"><i class="fa fa-search"></i>
                Búsqueda avanzada
              </a>
                <a href="/out/out.Tesauro.php" button type="button" class="btn btn-default" role="button"><i class="fa fa-gavel"></i>
                Tesauro de tipologías
              </a>
                
           

            </div>
          </div>
        </div>
      </div>

<?php
$this->startBoxPrimary(getMLText("resultados_busqueda_coleccion"));
//$this->contentContainerStart();
//////INICIO MI CODIGO
/* ---------------------------------------------- Search Result ------------------------------------------------------------------*/
		//echo "<div class=\"col-md-6\">\n";
// Search Result {{{
		$foldercount = $doccount = 0;
		if($entries) {
			/*
			foreach ($entries as $entry) {
				if(get_class($entry) == $dms->getClassname('document')) {
					$doccount++;
				} elseif(get_class($entry) == $dms->getClassname('document')) {
					$foldercount++;
				}
			}
			 */
			$accion="/generarExcel.php";
			echo "<form action=\"".$accion."\" method=\"post\">";
			print "<button type=\"submit\" class=\"btn  btn-success btn-xs\"><i class=\"icon fa-file-excel-o\"></i>Descargar la tabla de resultados como Excel</button>";
			
			$this->infoMsg(getMLText("search_report", array("doccount" => $totaldocs, "foldercount" => $totalfolders, 'searchtime'=>$searchTime)));
			

			//print "<p></p>";
			//print "<div class=\"alert\">".getMLText("search_report", array("doccount" => $totaldocs, "foldercount" => $totalfolders, 'searchtime'=>$searchTime))."</div>";
			
			$this->pageList($pageNumber, $totalpages, "../out/out.Search.php", $urlparams);
//			$this->contentContainerStart();
			//echo "general: ".print_r($urlparams);
			$delimitadores="";
			if($vengoAvanzada==TRUE)
			{
				if($quieroRango==TRUE)
				{
					$delimitadores=$delimitadores."resoluciones comprendidas entre ".$fechaInicio. " y ".$fechaFin."; ";
				}
				foreach($attributes as $atr) 
				{

					if(is_array($atr))
					{
						$delimitadores=$delimitadores.$atr[0]."; ";
					}
					else
					{
						if(strlen($atr)==0)
					{
						continue;
					}
						$delimitadores=$delimitadores.$atr."; ";
					}
					
				} //fin foreach
				$busqueda="Términos de búsqueda: ".$this->query."; con delimitadores: ".$delimitadores;
			$this->startBoxPrimary(getMLText("search_results")." para los términos "."\"".$this->query."\" con los delimitadores: ".$delimitadores);

			}
			else
			{
				$this->startBoxPrimary(getMLText("search_results")." para los términos "."\"".$this->query."\"");
				$busqueda="Términos de búsqueda: ".$this->query;
			}
			//$this->startBoxPrimary(getMLText("search_results")." para los términos "."\"".$this->query."\"");
				
			print "<table class=\"table table-hover\">";
			print "<thead>\n<tr>\n";
			print "<th>Referencia</th>\n";
			print "<th>Tesauro</th>\n";
			print "<th>Problema jurídico</th>\n";
			print "<th>Decisión</th>\n";
			print "<th>Fundamento</th>\n";
			//print "<th>".getMLText("action")."</th>\n";
			print "</tr>\n</thead>\n<tbody>\n";
			$previewer = new SeedDMS_Preview_Previewer($cachedir, $previewwidth, $timeout);
			foreach ($entries as $entry) 
			{
				
				if(get_class($entry) == $dms->getClassname('document')) 
				{
					$txt = $this->callHook('documentListItem', $entry, $previewer);
					if(is_string($txt))
						echo $txt;
					else 
					{
						$document = $entry;
						$owner = $document->getOwner();
				
							
							
						$lc = $document->getLatestContent();
						$version = $lc->getVersion();
						$previewer->createPreview($lc);

						if (in_array(3, $searchin))
							$comment = $this->markQuery(htmlspecialchars($document->getComment()));
						else
							$comment = htmlspecialchars($document->getComment());
						if (strlen($comment) > 150) $comment = substr($comment, 0, 147) . "...";
						print "<tr id=\"table-row-document-".$document->getID()."\" class=\"table-row-document\" rel=\"document_".$document->getID()."\" formtoken=\"".createFormKey('movedocument')."\" draggable=\"false\">";
						//print "<td><img src=\"../out/images/file.gif\" class=\"mimeicon\"></td>";
						if (in_array(2, $searchin)) {
							$docName = $this->markQuery(htmlspecialchars($document->getName()), "i");
						} else {
							$docName = htmlspecialchars($document->getName());
						}
						//////PRIMERA ENTRADA: REFERENCIA+fecha de resolución
						print "<td><a class=\"standardText\" href=\"../out/out.ViewDocument.php?documentid=".$document->getID()."\">";
						$folder = $document->getFolder();
						$path = $folder->getPath();
						for ($i = 1; $i  < count($path); $i++) {

							print htmlspecialchars($path[$i]->getName())."/";
						}
						print $docName;
						$arrayReferencias[]=$docName;
						print "</a>";
						$atributoFecha=$dms->getAttributeDefinitionByName($stringFecha);
						$fechaResolucion=$document->getAttributeValue($atributoFecha);
						$arrayFechas[]=$fechaResolucion;

					  print "<br /><span style=\"font-size: 85%; font-style: italic; color: #666; \">"."<b>".$stringFecha.": ".htmlspecialchars($fechaResolucion)."</b></br></span>";
						/*if($comment) {
							print "<br /><span style=\"font-size: 85%;\">".htmlspecialchars($comment)."</span>";
						}*/
						print "</td>";
						/////////////////////////// SEGUNDA ENTRADA: TIPOLOGIA (categoría en argot seeddms)
						print "<td>";
						$categorias=$document->getCategories();
						$categos="";
						foreach ($categorias as $catego) 
						{
							$nombreCatego=$catego->getName();
							$categos=$categos." ".$nombreCatego;
							$arrayTipologias[]=$categos;
						}
						
					    print "<br /><span style=\"font-size: 85%; font-style: italic; color: #666; \"><b>".htmlspecialchars($categos)."</br></span>";

						print "</td>";
						////////////////////// TERCERA ENTRADA: PROBLEMA JURIDICO
						print "<td>";
						//print "<ul class=\"unstyled\">\n";
						$atributoProblema=$dms->getAttributeDefinitionByName($stringProblema);
						$problemaJuridico=$document->getAttributeValue($atributoProblema);
						$arrayProblemas[]=$problemaJuridico;
					    foreach ($problemaJuridico as $problemita) 
					    {
					    	print "<br/><p class=\"text-navy\">"."<b>".htmlspecialchars($problemita)."</b></br></p>";
					    }
						//print "</ul>\n";
					    print "</td>";
						/////////////////////////////////////////////////////////
								////////////////////// CUARTA ENTRADA: DECISION 
						print "<td>";
						//print "<ul class=\"unstyled\">\n";
						$atributoDecision=$dms->getAttributeDefinitionByName($stringDecision);
						$decision=$document->getAttributeValue($atributoDecision);
						$arrayDecisiones[]=$decision[0];
						print "<br/>";
						if(strcmp($decision[0], "Sanciona")==0)
						{
							print "<span class=\"label label-danger\">".htmlspecialchars($decision[0])."</span>";
						}
							else
							{
								print "<span class=\"label label-primary\">".htmlspecialchars($decision[0])."</span>";
							}
							
						//print "</ul>\n";
					    	//print "<br/>";
					    print "</td>";
						/////////////////////////////////////////////////////////
							////////////////////// QUINTA ENTRADA: RATIO DECIDIENDI
						print "<td>";
						$atributoRatio=$dms->getAttributeDefinitionByName($stringRatio);
						$ratioDecidiendi=$document->getAttributeValue($atributoRatio);
						//el ratio es un texto grande, lo parto en tres líneas por párrafo (metiendo br)
					/*	$ratioDecidiendiFinal="";
						$porciones = explode(". ", $ratioDecidiendi);					    
						$numeroPorciones=count($porciones);
						
						$ratioDecidiendiFinal=$porciones[0]."/n".$porciones[1]."/n";*/
						// if($numeroParrafosEnteros==0)
						// {
						// 	$numeroParrafosEnteros=1;
						// } 
						// echo "numero de parrafos enteros: ".$numeroParrafosEnteros;
						// $indice=0;
						// for ($i=0; $i<$numeroParrafosEnteros; $i++)
						// {
						// 	echo "agrupando ".print_r($porciones)." ".$indice."<br>";
						// 	$ratioDecidiendiFinal=$ratioDecidiendiFinal.tomarTres($porciones,$indice);
						// 	echo "vuelta: ratioDecidiendiFinal: ".$ratioDecidiendiFinal."<br>";
						// 	$indice+3;
						// }
						$paraExcel=add3dots($ratioDecidiendi, "...", 140);
						$arrayRatios[]=$paraExcel;
						// $resultat = utf8_encode($ratioDecidiendi);
						// $resultat = preg_replace('/[[:^print:]]/', "", $resultat);
						//$clean = preg_replace('/[^\PC\s]/u', '', $ratioDecidiendi);
						//echo $clean;
					   $limpia=str_replace("\xC2\x93", "'", $ratioDecidiendi);
						$limpia=str_replace("\xC2\x94", "'", $limpia);
						$limpia=str_replace("\xC2\x95", "'", $limpia);
						$limpia=str_replace("\xC2\x96", "-", $limpia);
						$limpia=str_replace("\xC2\x85", "...", $limpia);
					    print "<br/><p class=\"text-black\">".htmlspecialchars($limpia)."</br></p>";
						print "</td>";
						/////////////////////////////////////////////////////////
						print "</tr>\n"; //fin fila de la tabla
						//$contadosLimite++;
					}
				} 

			}//fin foreach
			print "</tbody></table>\n";

			$this->endsBoxPrimary();
//			$this->contentContainerEnd();
			$this->pageList($pageNumber, $totalpages, "../out/out.Search.php", $_GET);
		} else {
			$numResults = $totaldocs + $totalfolders;
			if ($numResults == 0) {
				print "<div class=\"alert alert-error\">".getMLText("search_no_results")."</div>";
			}
		}
// }}}
		//echo "</div>";
		//echo "</div>";
		echo "<div class=\"gap-20\"></div>";
		foreach($arrayReferencias as $value)
			{
			  echo '<input type="hidden" name="arrayReferencias[]" value="'. $value. '">';
			}
			foreach($arrayFechas as $value)
			{
			  echo '<input type="hidden" name="arrayFechas[]" value="'. $value. '">';
			}
			foreach($arrayTipologias as $value)
			{
			  echo '<input type="hidden" name="arrayTipologias[]" value="'. $value. '">';
			}
			foreach($arrayProblemas as $value)
			{
			  echo '<input type="hidden" name="arrayProblemas[]" value="'.base64_encode(serialize($value)). '">';
			}
			foreach($arrayDecisiones as $value)
			{
			  echo '<input type="hidden" name="arrayDecisiones[]" value="'. $value. '">';
			}
			foreach($arrayRatios as $value)
			{
			  echo '<input type="hidden" name="arrayRatios[]" value="'. $value. '">';
			}
			echo '<input type="hidden" name="busqueda" value="'. $busqueda.'">';
		echo "</form>"; //fin del form de generar excel
 //////FIN MI CODIGO                 
//$this->contentContainerEnd();
$this->endsBoxPrimary();
   ?>
	     </div>
		</div>
		</div>
		<?php	
		$this->contentEnd();
		$this->mainFooter();		
		$this->containerEnd();
		$this->htmlEndPage();
	} /* }}} */
}
?>
