<?php
/**
 * Implementation of AddProcess view
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
 * Class which outputs the html page for AddProcess view
 *
 * @category   DMS
 * @package    SeedDMS
 * @author     Markus Westphal, Malcolm Cowe, Uwe Steinmann <uwe@steinmann.cx>
 * @copyright  Copyright (C) 2002-2005 Markus Westphal,
 *             2006-2008 Malcolm Cowe, 2010 Matteo Lucarelli,
 *             2010-2012 Uwe Steinmann
 * @version    Release: @package_version@
 */
class SeedDMS_View_AddProcess extends SeedDMS_Bootstrap_Style {

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

	$('body').on('click', 'a.delete-process-btn', function(ev){
		id = $(ev.currentTarget).attr('rel');
		confirmmsg = $(ev.currentTarget).attr('confirmmsg');
		msg = $(ev.currentTarget).attr('msg');
		formtoken = "<?php echo createFormKey('removeprocess'); ?>";
		
		bootbox.confirm({
    		message: confirmmsg,
    		buttons: {
        	confirm: {
            label: "<i class='fa fa-times'></i> <?php printMLText("nonconfo_rm_process"); ?>",
            className: 'btn-danger'
        	},
        	cancel: {
            label: "<?php printMLText("cancel"); ?>",
            className: 'btn-default'
        	}
    		},
	    		callback: function (result) {
	    			if (result) {
	    				$.get('../op/op.DeleteProcess.php',
							{ command: 'deleteprocess', id: id, formtoken: formtoken },
										function(data) {
											if(data.success) {
												$('#table-row-process-'+id).hide('slow');
												noty({
													text: data.message,
													type: 'success',
													dismissQueue: true,
													layout: 'topRight',
													theme: 'defaultTheme',
													timeout: 1500,
												});
											} else {
												noty({
													text: data.message,
													type: 'error',
													dismissQueue: true,
													layout: 'topRight',
													theme: 'defaultTheme',
													timeout: 3500,
												});
											}
										},
										'json'
									);
								}
	    			}	
					});
			});
});

<?php
	} /* }}} */

	function show() { /* {{{ */
		$dms = $this->params['dms'];
		$user = $this->params['user'];
		$processes = $this->params['processes'];

		$this->htmlStartPage(getMLText("nonconfo_title"), "skin-blue sidebar-mini");
		$this->containerStart();
		$this->mainHeader();
		$this->mainSideBar(0, 3, 0);
		$this->contentStart();
		$this->getNonconfoPathHTML();
?>
<div class="row">

	<div class="col-md-4">

		<?php $this->startBoxPrimary(getMLText("nonconfo_add_process")); ?>

			<form action="../op/op.AddProcess.php" id="form1" name="form1" method="post">
			<?php echo createHiddenFieldWithKey('addprocess'); ?>
				<div class="form-group">
					<label><?php printMLText("nonconfo_process_name");?>:</label>
					<input type="text" class="form-control" name="name">
				</div>
				<div class="box-footer">
					<button class="btn btn-info" type="submit"><i class="fa fa-save"></i> <?php printMLText("nonconfo_add_process");?></button>
				</div>
			</form>

		<?php $this->endsBoxPrimary(); ?>

	</div>

	<div class="col-md-8">

		<?php $this->startBoxSuccess(getMLText("nonconfo_process_list")); ?>

		<?php if(count($processes) > 0) { ?>
			<table id="table1" class="table table-bordered table-striped">
				<thead>
					<tr>
						<th><?php echo getMLText("nonconfo_process_name"); ?></th>
						<th><?php echo getMLText("nonconfo_actions"); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($processes as $process): ?>
						<tr id="table-row-process-<?php echo $process['id']?>">
							<td>
								<?php echo $process['name']; ?>
							</td>
							<td>
								<div class="list-action">
									<a type="button" class="btn btn-danger btn-sm delete-process-btn" rel="<?php echo $process['id']; ?>" msg="<?php echo getMLText('nonconfo_rm_process'); ?>"confirmmsg="<?php echo htmlspecialchars(getMLText("nonconfo_confirm_rm_process", array ("nonconfo_process_name" => $process['name'])), ENT_QUOTES); ?>" title="<?php echo getMLText("nonconfo_rm_process"); ?>"><i class="fa fa-times"></i></a>									
									<a type="button" class="btn btn-success btn-sm" href="../out/out.EditProcess.php?processid=<?php echo $process['id']; ?>" title="<?php echo getMLText("nonconfo_edit_process"); ?>">
									<i class="fa fa-pencil"></i></a>
								</div>
							</td>
						</tr>
					<?php endforeach ?>
				</tbody>
			</table>
		<?php	} ?>

		<?php $this->endsBoxSuccess(); ?>

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
