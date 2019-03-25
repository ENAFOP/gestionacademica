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

		$this->htmlStartPage(getMLText("nonconfo_title"));
		$this->globalNavigation();
		$this->contentStart();
		$this->pageNavigation("nonconfo_title", "nonconfo_view_navigation", "");

		$dateStart = new DateTime();
		$dateEnd = new DateTime();
		$dateStart->setTimestamp($action[0]['dateStart']);
		$dateEnd->setTimestamp($action[0]['dateEnd']);

?>

<div class="row-fluid">
	<div class="span12">
		<?php $this->contentHeading(getMLText("nonconfo_edit_action")); ?>
		<div class="well">
			<form class="form-horizontal" action="../op/op.EditAction.php" id="form1" name="form1" method="post">
			<?php echo createHiddenFieldWithKey('editaction'); ?>
			<input type='hidden' name='actionId' value='<?php echo $action[0]['id']; ?>'/>
			<table class="table">
				<tr>
					<td class="lbl-right"><?php echo getMLText('nonconfo_action_detail');?>:</td>
					<td><textarea class="comment_width" name="description" rows="5" cols="100"><?php echo $action[0]['description'] ;?></textarea></td>
				</tr>
				<tr>
					<td class="lbl-right"><?php echo getMLText('nonconfo_action_date_start');?>:</td>
					<td>
						<span class="input-append date span12" id="fromdate" data-date="<?php echo $dateStart->format('Y-m-d'); ?>" data-date-format="yyyy-mm-dd">
		      		<input class="span6" size="16" name="start" type="text" value="<?php echo $dateStart->format('Y-m-d'); ?>">
		      		<span class="add-on"><i class="icon-calendar"></i></span>
		    		</span>
					</td>
				</tr>
				<tr>
					<td class="lbl-right"><?php echo getMLText('nonconfo_action_date_end');?>:</td>
					<td>
						<span class="input-append date span12" id="todate" data-date="<?php echo $dateEnd->format('Y-m-d'); ?>" data-date-format="yyyy-mm-dd">
		      		<input class="span6" size="16" name="end" type="text" value="<?php echo $dateEnd->format('Y-m-d'); ?>">
		      		<span class="add-on"><i class="icon-calendar"></i></span>
		    		</span>
					</td>
				</tr>
				<tr>
					<td colspan="2">
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
