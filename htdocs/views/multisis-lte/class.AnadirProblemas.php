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
class SeedDMS_View_AnadirProblemas extends SeedDMS_Bootstrap_Style {

	/**
	 * Mark search query sting in a given string
	 *
	 * @param string $str mark this text
	 * @param string $tag wrap the marked text with this html tag
	 * @return string marked text
	 */
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

		$this->htmlAddHeader('<script type="text/javascript" src="../styles/'.$this->theme.'/plugins/bootbox/bootbox.min.js"></script>'."\n", 'js');

		$this->htmlStartPage(getMLText("search_results"), "skin-blue sidebar-mini");
		$this->containerStart();
		$this->mainHeader();		
		$this->mainSideBar();
		$this->contentStart();

		echo "<div class=\"row\">";
		echo "<div class=\"gap-20\"></div>";
		echo "<div class=\"col-md-6\">";
//echo "<pre>";print_r($_GET);echo "</pre>";
?>
<div class="nav-tabs-custom">
  <ul class="nav nav-tabs" id="searchtab">
	  <li <?php echo ($fullsearch == false) ? 'class="active"' : ''; ?>><a data-target="#database" data-toggle="tab"><?php printMLText('databasesearch'); ?></a></li>
<?php
		if($enablefullsearch) {
?>
	  <li <?php echo ($fullsearch == true) ? 'class="active"' : ''; ?>><a data-target="#fulltext" data-toggle="tab"><?php printMLText('fullsearch'); ?></a></li>
<?php
		}
?>
	</ul>
	<div class="tab-content">
	  <div class="tab-pane <?php echo ($fullsearch == false) ? 'active' : ''; ?>" id="database">
<form action="../out/out.Search.php" name="form1">
<?php
// Database search Form {{{
//$this->contentContainerStart();

?>
<div class="table-responsive">
<table class="table">




<tr>
<td><?php printMLText("creation_date");?>:</td>
<td>
       

        <span class="input-append date" id="createenddate" data-date="<?php echo date('Y-m-d'); ?>" data-date-format="yyyy-mm-dd" data-date-language="<?php echo str_replace('_', '-', $this->params['session']->getLanguage()); ?>">
          <input class="span4 form-control" size="16" name="createend" type="text" value="<?php if($stopdate) printf("%04d-%02d-%02d", $stopdate['year'], $stopdate['month'], $stopdate['day']); else echo date('Y-m-d'); ?>">
          <span class="add-on"><i class="icon-calendar"></i></span>
        </span>
</td>
</tr>

<?php
		if($attrdefs) {
			foreach($attrdefs as $attrdef) {
				$attricon = '';
				if($attrdef->getObjType() == SeedDMS_Core_AttributeDefinition::objtype_all) {
?>
<tr>
	<td><?php echo htmlspecialchars($attrdef->getName()); ?>:</td>
	<td><?php $this->printAttributeEditField($attrdef, isset($attributes[$attrdef->getID()]) ? $attributes[$attrdef->getID()] : '', 'attributes', true) ?></td>
</tr>

<?php
				}
			}
		}
?>

<tr>
<td></td><td><button type="submit" class="btn btn-info"><i class="fa fa-search"></i> <?php printMLText("search"); ?></button></td>
</tr>

</table>
</div>
<div class="gap-20"></div>
<?php

// }}}

		/* First check if any of the folder filters are set. If it is,
		 * open the accordion.
		 */
		$openfilterdlg = false;
		if($attrdefs) {
			foreach($attrdefs as $attrdef) {
				$attricon = '';
				if($attrdef->getObjType() == SeedDMS_Core_AttributeDefinition::objtype_document || $attrdef->getObjType() == SeedDMS_Core_AttributeDefinition::objtype_documentcontent) {
					if(!empty($attributes[$attrdef->getID()]))
						$openfilterdlg = true;
				}
			}
		}
		if($categories)
			$openfilterdlg = true;
		if($status)
			$openfilterdlg = true;
		if($expirationdate)
			$openfilterdlg = true;
?>

</div>

<?php
		/* First check if any of the folder filters are set. If it is,
		 * open the accordion.
		 */
		$openfilterdlg = false;
		if($attrdefs) {
			foreach($attrdefs as $attrdef) {
				$attricon = '';
				if($attrdef->getObjType() == SeedDMS_Core_AttributeDefinition::objtype_folder) {
					if(!empty($attributes[$attrdef->getID()]))
						$openfilterdlg = true;
				}
			}
		}
?>
<div class="box box-primary collapsed-box" id="">
  <div class="box-header with-border">
    <h3 class="box-title"><?php printMLText('filter_for_folders'); ?></h3>
		<div class="box-tools pull-right">
    	<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
    </div>
  </div>
  <div class="box-body">
				<table class="table-condensed">
				<?php
						if($attrdefs) {
							foreach($attrdefs as $attrdef) {
								$attricon = '';
								if($attrdef->getObjType() == SeedDMS_Core_AttributeDefinition::objtype_folder) {
				?>
				<tr>
					<td><?php echo htmlspecialchars($attrdef->getName()); ?>:</td>
					<td><?php $this->printAttributeEditField($attrdef, isset($attributes[$attrdef->getID()]) ? $attributes[$attrdef->getID()] : '', 'attributes', true) ?></td>
				</tr>
				<?php
								}
							}
						}
				?>
				</table>
      </div>
    </div>
</form>
</div>


<?php
/* ----------------------- second tab ---------------------------------------------------------------------------------- */
		if($enablefullsearch) {
	  	echo "<div class=\"tab-pane ".(($fullsearch == true) ? 'active' : '')."\" id=\"fulltext\">\n";
	$this->contentContainerStart();
?>
<form action="../out/out.Search.php" name="form2" style="min-height: 330px;">
<input type="hidden" name="fullsearch" value="1" />
<table class="table-condensed">
<tr>
<td><?php printMLText("search_query");?>:</td>
<td>
<input type="text" name="query" value="<?php echo htmlspecialchars($this->query); ?>" />
<!--
<select name="mode">
<option value="1" selected><?php printMLText("search_mode_and");?>
<option value="0"><?php printMLText("search_mode_or");?>
</select>
-->
</td>
</tr>
<tr>
<td><?php printMLText("owner");?>:</td>
<td>
<select class="chzn-select-deselect" name="ownerid" data-placeholder="<?php printMLText('select_users'); ?>" data-no_results_text="<?php printMLText('unknown_owner'); ?>">
<option value="-1"></option>
<?php
			foreach ($allUsers as $userObj) {
				if ($userObj->isGuest() || ($userObj->isHidden() && $userObj->getID() != $user->getID() && !$user->isAdmin()))
					continue;
				print "<option value=\"".$userObj->getID()."\" ".(($owner && $userObj->getID() == $owner->getID()) ? "selected" : "").">" . htmlspecialchars($userObj->getLogin()." - ".$userObj->getFullName()) . "</option>\n";
			}
?>
</select>
</td>
</tr>
<tr>
<td><?php printMLText("category_filter");?>:</td>
<td>
<select class="chzn-select" name="categoryids[]" multiple="multiple" data-placeholder="<?php printMLText('select_category'); ?>" data-no_results_text="<?php printMLText('unknown_document_category'); ?>">
<!--
<option value="-1"><?php printMLText("all_categories");?>
-->
<?php
		$tmpcatids = array();
		foreach($categories as $tmpcat)
			$tmpcatids[] = $tmpcat->getID();
		foreach ($allCats as $catObj) {
			print "<option value=\"".$catObj->getID()."\" ".(in_array($catObj->getID(), $tmpcatids) ? "selected" : "").">" . htmlspecialchars($catObj->getName()) . "\n";
		}
?>
</select>
</td>
</tr>
<tr>
<td></td><td><button type="submit" class="btn"><i class="icon-search"></i> <?php printMLText("search"); ?></button></td>
</tr>
</table>

</form>
<?php
			$this->contentContainerEnd();
			echo "</div>\n";
		}
?>
	</div>
<?php
		echo "</div>\n";

/* ---------------------------------------------- Search Result ------------------------------------------------------------------*/
		echo "<div class=\"col-md-6\">\n";
        echo "Hola";
		echo "<div class=\"gap-20\"></div>";
		echo "</div>";
		echo "</div>";
		echo "</div>";
		
		$this->contentEnd();
		$this->mainFooter();		
		$this->containerEnd();
		$this->htmlEndPage();
	} /* }}} */
}
?>
