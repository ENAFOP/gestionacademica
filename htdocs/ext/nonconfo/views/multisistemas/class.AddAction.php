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
class SeedDMS_View_AddAction extends SeedDMS_Bootstrap_Style {

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

	$("#add-actions-btn").on('click', function(){
		$("#analysis-block").after("<div class='row-fluid' id='action-counter-'><div class='span12'><div class='well'><form class='form-horizontal' action='../op/op.AddAction.php' id='form2' name='form2' method='post'><input type='hidden' name='nonconfoId' value='<?php echo $nonconfo['id']; ?>'/><div style='overflow-x: auto;'><table class='table'><thead><tr><th><?php echo getMLText('nonconfo_action_detail'); ?></th><th><?php echo getMLText('nonconfo_action_creation'); ?></th><th><?php echo getMLText('nonconfo_action_date_end'); ?></th><th></th></tr></thead><tbody><?php $expdate = date('m-d-Y'); ?><tr><td><div><textarea name='description' style='min-width: 500px;' cols='30' rows='3'></textarea></div></td><td><span class='input-append date span12' id='fromdate' data-date='<?php echo $expdate; ?>' data-date-format='yyyy-mm-dd'><input class='span6' size='16' name='start' type='text' value='<?php echo $expdate; ?>'><span class='add-on'><i class='icon-calendar'></i></span></span></td><td><span class='input-append date span12' id='todate' data-date='<?php echo $expdate; ?>' data-date-format='yyyy-mm-dd'><input class='span6' size='16' name='end' type='text' value='<?php echo $expdate; ?>'><span class='add-on'><i class='icon-calendar'></i></span></span></td><td><button type='submit' class='btn btn-success'><i class='icon-save'></i> <?php echo getMLText('nonconfo_save'); ?></button><a type='button' class='btn btn-default' rel='' id='btn-cancel-action'><?php echo getMLText('nonconfo_cancel'); ?></a></td></tr></tbody></table></div></form></div></div></div>");
		add();
	});

	/* Cancel action */
	$('#btn-cancel-action-'+counter).on('click', function(ev) {
		id = $(ev.currentTarget).attr('rel');
		$('#action-counter-'+id).fadeOut('slow');
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
		$nonconfoId = $this->params['nonconfoId'];

		$this->htmlStartPage(getMLText("nonconfo_title"));
		$this->globalNavigation();
		$this->contentStart();
		$this->pageNavigation("nonconfo_title", "nonconfo_view_navigation", "");

		$expdate = date('Y-m-d');
?>

<div class="row-fluid">
	<div class="span12">
		<?php $this->contentHeading(getMLText("nonconfo_add_actions")); ?>
		<div class="well">
		<form class='form-horizontal' action='../op/op.AddAction.php' id='form1' name='form1' method='post'>
			<?php echo createHiddenFieldWithKey('addaction'); ?>
			<input type='hidden' name='nonconfoId' value='<?php echo $nonconfoId; ?>'/>
			<table class="table">
				<tr>
					<td class="lbl-right"><?php echo getMLText('nonconfo_action_detail');?>:</td>
					<td><textarea class="comment_width" name="description" rows="5" cols="100"></textarea></td>
				</tr>
				<tr>
					<td class="lbl-right"><?php echo getMLText('nonconfo_action_date_start');?>:</td>
					<td>
						<span class="input-append date span12" id="fromdate" data-date="<?php echo $expdate; ?>" data-date-format="yyyy-mm-dd">
		      		<input class="span6" size="16" name="start" type="text" value="<?php echo $expdate; ?>">
		      		<span class="add-on"><i class="icon-calendar"></i></span>
		    		</span>
					</td>
				</tr>
				<tr>
					<td class="lbl-right"><?php echo getMLText('nonconfo_action_date_end');?>:</td>
					<td>
						<span class="input-append date span12" id="todate" data-date="<?php echo $expdate; ?>" data-date-format="yyyy-mm-dd">
		      		<input class="span6" size="16" name="end" type="text" value="<?php echo $expdate; ?>">
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
