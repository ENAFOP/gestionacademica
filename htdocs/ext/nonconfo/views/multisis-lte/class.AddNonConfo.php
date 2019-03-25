<?php
/**
 * Implementation of AddNonConfo view
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
 * Class which outputs the html page for AddNonConfo view
 *
 * @category   DMS
 * @package    SeedDMS
 * @author     Markus Westphal, Malcolm Cowe, Uwe Steinmann <uwe@steinmann.cx>
 * @copyright  Copyright (C) 2002-2005 Markus Westphal,
 *             2006-2008 Malcolm Cowe, 2010 Matteo Lucarelli,
 *             2010-2012 Uwe Steinmann
 * @version    Release: @package_version@
 */
class SeedDMS_View_AddNonConfo extends SeedDMS_Bootstrap_Style {

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

	$('#form1').one('submit', function() {
    $(this).find('input[type="submit"]').attr('disabled','disabled');
	});
});

<?php

} /* }}} */

	function show() { /* {{{ */
		$dms = $this->params['dms'];
		$user = $this->params['user'];
		$allUsers = $this->params['allUsers'];
		$processes = $this->params['processes'];

		$this->htmlStartPage(getMLText("nonconfo_title"), "skin-blue sidebar-mini");
		$this->containerStart();
		$this->mainHeader();
		$this->mainSideBar(0, 2, 0);
		$this->contentStart();
		$this->getNonconfoPathHTML();
?>
<div class="row">
	<div class="col-md-12">

		<?php $this->startBoxPrimary(getMLText("nonconfo_add_nonconfo")); ?>

			<form action="../op/op.AddNonConfo.php" id="form1" name="form1" method="post">
			<?php echo createHiddenFieldWithKey('addnonconfo'); ?>

						<div class="form-group">
							<label><?php printMLText("nonconfo_correlative");?>:</label>
							<input data-toggle="tooltip" data-placement="bottom" title="<?php echo getMLText("nonconfo_correlative_warning"); ?>" type="text" class="form-control" name="correlative" value="" size="100" />
						</div>

						<div class="form-group">
							<label><?php printMLText("nonconfo_select_process");?>:</label>
							<div>
								<select class="chzn-select form-control" name="processId" id="selector">
									<option value="-1"><?php echo getMLText("nonconfo_select_process")?></option>
										<?php
											foreach ($processes as $process) {
												print "<option value=\"".$process['id']."\" data-subtitle=\"\"";
												print ">" . htmlspecialchars($process['name']) . "</option>\n";
											}
										?>
								</select>
							</div>
						</div>

						<div class="form-group">
							<input type="hidden" class="form-control" name="date" value="<?php echo date("d-m-Y H:i:sa"); ?>" size="100" disabled />
						</div>

						<div class="form-group">
							<label><?php printMLText("nonconfo_action_type");?>:</label>
							<div>
								<select name="type" class="form-control">
									<option value="-1"><?php printMLText("select_one"); ?></option>
									<option value="<?php printMLText("nonconfo_corrective_action"); ?>"><?php printMLText("nonconfo_corrective_action"); ?></option>
									<option value="<?php printMLText("nonconfo_risk_action"); ?>"><?php printMLText("nonconfo_risk_action"); ?></option>
									<option value="<?php printMLText("nonconfo_improvement_action"); ?>"><?php printMLText("nonconfo_improvement_action"); ?></option>
									<option value="<?php printMLText("nonconfo_correction"); ?>"><?php printMLText("nonconfo_correction"); ?></option>
								</select>
							</div>
						</div>

						<div class="form-group">
							<label><?php printMLText("nonconfo_origin_source"); ?>:</label>
							<input type="text" class="form-control" name="source" />
						</div>

						<div class="form-group">
							<label><?php printMLText("nonconfo_description"); ?>:</label>
							<textarea class="form-control" name="description" rows="5" cols="100"></textarea>
						</div>

						<div class="form-group">
							<input type="hidden" class="form-control" name="reporter" value="<?php echo $user->getFullName(); ?>" size="100" disabled />
						</div>

						<div class="box-footer">
							<button class="btn btn-info" type="submit"><i class="fa fa-save"></i> <?php printMLText("save");?></button>
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
