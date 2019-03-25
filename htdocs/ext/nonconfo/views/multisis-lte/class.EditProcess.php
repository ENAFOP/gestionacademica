<?php
/**
 * Implementation of EditProcess view
 *
 * @category   DMS
 * @package    SeedDMS
 * @license    GPL 2
 * @version    @version
 * @author     Luis Medrano <lmedrano@multisistemas.com.sv>
 * @copyright  Copyright (C) 2011-2017 Multisistemas,
 * @version    Release: @package_version@
 */

/**
 * Include parent class
 */
require_once("../../../views/$theme/class.Bootstrap.php");

/**
 * Class which outputs the html page for EditProcess view
 *
 * @category   DMS
 * @package    SeedDMS
 * @author     Markus Westphal, Malcolm Cowe, Uwe Steinmann <uwe@steinmann.cx>
 * @copyright  Copyright (C) 2002-2005 Markus Westphal,
 *             2006-2008 Malcolm Cowe, 2010 Matteo Lucarelli,
 *             2010-2012 Uwe Steinmann
 * @version    Release: @package_version@
 */
class SeedDMS_View_EditProcess extends SeedDMS_Bootstrap_Style {

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
		$process = $this->params['process'];

		$this->htmlStartPage(getMLText("nonconfo_title"), "skin-blue sidebar-mini");
		$this->containerStart();
		$this->mainHeader();
		$this->mainSideBar(0,5,0);
		$this->contentStart();
		$this->getNonconfoPathHTML();

?>

<div class="row">
	<div class="col-md-12">
		<?php $this->startBoxSuccess(getMLText("nonconfo_edit_process")); ?>
			<form action="../op/op.EditProcess.php" id="form1" name="form1" method="post">
					<?php echo createHiddenFieldWithKey('editprocess'); ?>
					<div class="form-group">
						<input type="hidden" name="processid" value="<?php echo $process['id']; ?>">
						<label><?php printMLText("nonconfo_process_name");?>:</label>
						<input type="text" class="form-control" name="name" size="100" value="<?php echo $process['name']; ?>">
					</div>
					<div class="box-footer">
						<button class="btn history-back"><?php echo getMLText('back'); ?></button>
						<button class="btn btn-info" type="submit"><i class="fa fa-save"></i> <?php printMLText("nonconfo_save");?></button>
					</div>
			</form>
		<?php $this->endsBoxPrimary(); ?>
	</div>
</div>

<?php

		echo "</div>";

		$this->contentEnd();
		$this->mainFooter();		
		$this->containerEnd();
		$this->htmlEndPage();

	} /* }}} */
}
?>
