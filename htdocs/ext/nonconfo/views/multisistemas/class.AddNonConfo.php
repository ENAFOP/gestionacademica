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

		$this->htmlStartPage(getMLText("nonconfo_title"));
		$this->globalNavigation();
		$this->contentStart();
		$this->pageNavigation("nonconfo_title", "nonconfo_view_navigation", "");

?>

<div class="row-fluid">
	<div class="span12">
		<div class="span8">
		<?php $this->contentHeading(getMLText("nonconfo_add_nonconfo")); ?>
		<div class="well">
			<?php echo $this->contentSubHeading(getMLText("nonconfo_general_info")); ?>
			<hr/>
			<form class="form-horizontal" action="../op/op.AddNonConfo.php" id="form1" name="form1" method="post">
			<?php echo createHiddenFieldWithKey('addnonconfo'); ?>
					<table class="table-condensed">
						<tr>
							<td class="lbl-right"><?php printMLText("nonconfo_correlative");?>:</td>
							<td><input type="text" name="correlative" value="" size="100" /></td>
						</tr>
						<tr>
							<td class="lbl-right"><?php printMLText("nonconfo_select_process");?>:</td>
							<td>
								<select class="chzn-select" name="processId" id="selector">
									<option value="-1"><?php echo getMLText("nonconfo_select_process")?></option>
										<?php
											foreach ($processes as $process) {
												print "<option value=\"".$process['id']."\" data-subtitle=\"\"";
												print ">" . htmlspecialchars($process['name']) . "</option>\n";
											}
										?>
								</select>
							</td>
						</tr>
						<tr>
							<td class="lbl-right"><?php printMLText("nonconfo_request_date");?>:</td>
							<td><input type="text" name="date" value="<?php echo date("d-m-Y H:i:sa"); ?>" size="100" disabled /></td>
						</tr>					
						<tr>
							<td class="lbl-right"><?php printMLText("nonconfo_action_type");?>:</td>
							<td>
								<select name="type">
									<option value="-1"><?php printMLText("select_one"); ?></option>
									<option value="<?php printMLText("nonconfo_corrective_action"); ?>"><?php printMLText("nonconfo_corrective_action"); ?></option>
									<option value="<?php printMLText("nonconfo_risk_action"); ?>"><?php printMLText("nonconfo_risk_action"); ?></option>
									<option value="<?php printMLText("nonconfo_improvement_action"); ?>"><?php printMLText("nonconfo_improvement_action"); ?></option>
									<option value="<?php printMLText("nonconfo_correction"); ?>"><?php printMLText("nonconfo_correction"); ?></option>
								</select>
							</td>
						</tr>
						<tr>
							<td class="lbl-right"><?php printMLText("nonconfo_origin_source"); ?>:</td>
							<td><input type="text" name="source" size="200" /></td>
						</tr>
						<tr>
							<td class="lbl-right"><?php printMLText("nonconfo_description"); ?>:</td>
							<td><textarea class="comment_width" name="description" rows="5" cols="100"></textarea></td>
						</tr>
						<tr>
							<td class="lbl-right"><?php printMLText("nonconfo_reporter_name"); ?>:</td>
							<td><input type="text" name="reporter" value="<?php echo $user->getFullName(); ?>" size="100" disabled /></td>
						</tr>
						<tr>
							<td colspan="2" class="lbl-right"><input class="btn btn-success" type="submit" value="<?php printMLText("save");?>"></td>
						</tr>
				</table>
			</form>
		</div>
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
