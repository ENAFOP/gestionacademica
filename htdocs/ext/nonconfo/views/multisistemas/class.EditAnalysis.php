<?php
/**
 * Implementation of EditAnalysis view
 *
 * @category   DMS
 * @package    SeedDMS
 * @license    GPL 2
 * @version    @version@
 * @author     Herson Cruz <herson@multisistemas.com.sv>
 * @author     Luis Medrano <lmedrano@multisistemas.com.sv>
 * @copyright  Copyright (C) 2011-2017 Multisistemas,
 * @version    Release: @package_version@
 */

/**
 * Include parent class
 */
require_once("../../../views/$theme/class.Bootstrap.php");

/**
 * Class which outputs the html page for EditAnalysis view
 *
 * @category   DMS
 * @package    SeedDMS
 * @author     Markus Westphal, Malcolm Cowe, Uwe Steinmann <uwe@steinmann.cx>
 * @copyright  Copyright (C) 2002-2005 Markus Westphal,
 *             2006-2008 Malcolm Cowe, 2010 Matteo Lucarelli,
 *             2010-2012 Uwe Steinmann
 * @version    Release: @package_version@
 */
class SeedDMS_View_EditAnalysis extends SeedDMS_Bootstrap_Style {

	function js() { /* {{{ */
		header('Content-Type: application/javascript; charset=UTF-8');
?>
function checkForm() {
	msg = new Array();
	if (document.form1.name.value == "") msg.push("<?php printMLText("js_no_name");?>");

	if (msg != "") {
  	noty({
  		text: msg.join('<br />'),
  		type: 'error',
      dismissQueue: true,
  		layout: 'topRight',
  		theme: 'defaultTheme',
			_timeout: 1500,
  	});
		return false;
	}
	else
		return true;
}

$(document).ready(function() {
	$('body').on('submit', '#form1', function(ev){
		if(checkForm()) return;
		ev.preventDefault();
	});

	

});

<?php
	} /* }}} */

	function show() { /* {{{ */
		$dms = $this->params['dms'];
		$user = $this->params['user'];
		$analysis = $this->params['analysis'];

		$this->htmlStartPage(getMLText("nonconfo_title"));
		$this->globalNavigation();
		$this->contentStart();
		$this->pageNavigation("nonconfo_title", "nonconfo_view_navigation", "");

?>

<div class="row-fluid">
	<div class="span12">
		<?php $this->contentHeading(getMLText("nonconfo_edit_analysis")); ?>
		<div class="well">
			<form class="form-horizontal" action="../op/op.EditAnalysis.php" id="form1" name="form1" method="post">
			<?php echo createHiddenFieldWithKey('editanalysis'); ?>
			<input type="hidden" name="analysisId" value="<?php echo $analysis['id']; ?>">
			<table class="table">
				<tr>
					<td class="lbl-right">
							<?php printMLText("nonconfo_analysis_description");?>:</td>		
					</td>
					<td class="lbl-right">
						<div  class="span10">
							<textarea style="width: 100%;" cols="200" rows="5" name="description"><?php echo $analysis['comment']; ?></textarea>
						</div>
					</td>
				</tr>
				<tr>
					<td colspan="2" class="" class="comment-width">
						<input class="btn btn-success" type="submit" value="<?php printMLText("nonconfo_save");?>">
					</td>
				</tr>
			</table>
			</form>
		</div>
	</div>
</div>

<?php

		$this->contentContainerEnd();
		$this->contentEnd();
		$this->htmlEndPage();

	} /* }}} */
}
?>
