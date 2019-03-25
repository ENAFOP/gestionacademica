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
class SeedDMS_View_EditAction extends SeedDMS_Bootstrap_Style {

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
		$action = $this->params['action'];

		$this->htmlStartPage(getMLText("nonconfo_title"), "skin-blue sidebar-mini");
		$this->containerStart();
		$this->mainHeader();
		$this->mainSideBar(0,5,0);
		$this->contentStart();
		$this->getNonconfoPathHTML();

		$dateStart = new DateTime();
		$dateEnd = new DateTime();
		$dateStart->setTimestamp($action[0]['dateStart']);
		$dateEnd->setTimestamp($action[0]['dateEnd']);

?>

<div class="row">
	<div class="col-md-12">

		<?php $this->startBoxSuccess(getMLText("nonconfo_edit_action")); ?>

			<form action="../op/op.EditAction.php" id="form1" name="form1" method="post">
			<?php echo createHiddenFieldWithKey('editaction'); ?>
			<input type='hidden' name='actionId' value='<?php echo $action[0]['id']; ?>'/>
				<div class="form-group">
					<label><?php echo getMLText('nonconfo_action_detail');?>:</label>
					<textarea class="form-control" name="description" rows="5" cols="100"><?php echo $action[0]['description'] ;?></textarea>
				</div>
				<div class="form-group">
					<label><?php echo getMLText('nonconfo_action_date_start');?>:</label>
						<span class="input-append date span12" id="fromdate" data-date="<?php echo $dateStart->format('Y-m-d'); ?>" data-date-format="yyyy-mm-dd">
		      		<input class="form-control" name="start" type="text" value="<?php echo $dateStart->format('Y-m-d'); ?>">
		      		<span class="add-on"><i class="icon-calendar"></i></span>
		    		</span>
				</div>
				<div class="form-group">
					<label><?php echo getMLText('nonconfo_action_date_end');?>:</label>
						<span class="input-append date span12" id="todate" data-date="<?php echo $dateEnd->format('Y-m-d'); ?>" data-date-format="yyyy-mm-dd">
		      		<input class="form-control" name="end" type="text" value="<?php echo $dateEnd->format('Y-m-d'); ?>">
		      		<span class="add-on"><i class="icon-calendar"></i></span>
		    		</span>
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
