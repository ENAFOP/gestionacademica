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
class SeedDMS_View_FollowAction extends SeedDMS_Bootstrap_Style {

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

		$expdate = date('Y-m-d');

	?>
	<div class="row">
		<div class="col-md-12">
		<?php $this->startBoxSolidPrimary(getMLText("action")); ?>
				<div class="table-responsive">
					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th width="50%" class="align-center"><?php echo getMLText('nonconfo_action_detail'); ?></th>
								<th width="25%" class="align-center"><?php echo getMLText('nonconfo_action_date_start'); ?></th>
								<th width="25%" class="align-center"><?php echo getMLText('nonconfo_action_date_end'); ?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>
									<div>
										<textarea class="form-control" cols="100" rows="5" readonly="true" disabled="true"><?php echo $action[0]['description']; ?></textarea>
									</div>
								</td>
								<td class="align-center"><span class="label label-success">
									<?php echo $dateStart->format('d-m-Y'); ?>
								</span></td>
								<td class="align-center"><span class="label label-warning">
									<?php echo $dateEnd->format('d-m-Y'); ?>
								</span></td>
							</tr>
						</tbody>
					</table>
				</div>
			<?php $this->endsBoxSolidPrimary(); ?>
		</div>
	</div>

<div class="row">
	<div class="col-md-12">
		<?php $this->startBoxSolidSuccess(getMLText("nonconfo_follow_action")); ?>
		<form action='../op/op.FollowAction.php' id='form1' name='form1' method='post'>
			<?php echo createHiddenFieldWithKey('followaction'); ?>
			<input type='hidden' name='actionId' value='<?php echo $action[0]['id']; ?>'/>
				<div class="form-group">
					<label><?php echo getMLText('nonconfo_action_real_date_end');?>:</label>
						<span class="input-append date span12" id="fromdate" data-date="<?php echo $expdate; ?>" data-date-format="yyyy-mm-dd">
		      		<input class="form-control" name="realDateEnd" type="text" value="<?php echo $expdate; ?>">
		      		<span class="add-on"><i class="icon-calendar"></i></span>
		    		</span>
				</div>
				<div class="form-group">
					<label><?php echo getMLText('nonconfo_follow_detail');?></label>
					<textarea class="form-control" name="description" rows="5" cols="100" required></textarea>
				</div>
				<div class="form-group">
					<label><?php echo getMLText('nonconfo_indicator_before');?>:</label>
					<input type="text" class="form-control" name="indicatorBefore" size="100" required />
				</div>
				<div class="form-group">
					<label><?php echo getMLText('nonconfo_indicator_after');?>:</label>
					<input type="text" class="form-control" name="indicatorAfter" size="100" required />
				</div>
				<div class="form-group">
					<label><?php printMLText("nonconfo_was_efective");?>:</label>
						<select class="form-control" name="finalStatus" required>
							<option value="-1"></option>
							<option value="<?php printMLText("nonconfo_yes"); ?>"><?php printMLText("nonconfo_yes"); ?></option>
							<option value="<?php printMLText("nonconfo_no"); ?>"><?php printMLText("nonconfo_no"); ?></option>
						</select>
				</div>
				<div class="box-footer">
					<button class="btn history-back"><?php echo getMLText('back'); ?></button>
					<button class="btn btn-info" type="submit"><i class="fa fa-save"></i> <?php printMLText("nonconfo_save_and_close");?></button>
				</div>
		</form>
		<?php $this->endsBoxSolidSuccess(); ?>
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
