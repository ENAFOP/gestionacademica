<?php
/**
 * Implementation of AddOwners view
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
 * Class which outputs the html page for AddEvent view
 *
 * @category   DMS
 * @package    SeedDMS
 * @author     Markus Westphal, Malcolm Cowe, Uwe Steinmann <uwe@steinmann.cx>
 * @copyright  Copyright (C) 2002-2005 Markus Westphal,
 *             2006-2008 Malcolm Cowe, 2010 Matteo Lucarelli,
 *             2010-2012 Uwe Steinmann
 * @version    Release: @package_version@
 */
class SeedDMS_View_AddOwners extends SeedDMS_Bootstrap_Style {

	function js() { /* {{{ */
		$selProcess = $this->params['selProcess'];

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

	$('body').on('click', 'a.delete-owner-btn', function(ev){
		id = $(ev.currentTarget).attr('rel');
		confirmmsg = $(ev.currentTarget).attr('confirmmsg');
		msg = $(ev.currentTarget).attr('msg');
		formtoken = "<?php echo createFormKey('removeowner'); ?>";

		bootbox.confirm({
    		message: confirmmsg,
    		buttons: {
        	confirm: {
            label: "<i class='fa fa-times'></i> <?php printMLText("nonconfo_rm_owner"); ?>",
            className: 'btn-danger'
        	},
        	cancel: {
            label: "<?php printMLText("cancel"); ?>",
            className: 'btn-default'
        	}
    		},
	    		callback: function (result) {
	    			if (result) {
	    				$.get('../op/op.DeleteProcessOwner.php',
							{ command: 'deleteowner', id: id, formtoken: formtoken },
										function(data) {
											if(data.success) {
												$('#table-row-owner-'+id).hide('slow');
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

	$("#selector").change(function() {
		$('div.ajax').trigger('update', {processid: $(this).val()});
	});

});

<?php
	} /* }}} */

	function showForm($selProcess) { /* {{{ */
		$dms = $this->params['dms'];
		$user = $this->params['user'];
		$allUsers = $this->params['allUsers'];
		$userCreator = $this->params['userCreator'];
		$owners = $this->params['owners'];

		if($selProcess) {
			$date = new DateTime();
			$date->setTimestamp($selProcess['created']);

			$this->startBoxCollapsablePrimary(getMLText("nonconfo_process_info"));
			?>
			<table class="table table-bordered table-striped">
				<tr>
					<td><?php echo "<b>".getMLText('nonconfo_process_name').":</b> ".$selProcess['name']; ?></td>
				</tr>
				<tr>
					<td><?php echo "<b>".getMLText('nonconfo_created').":</b> ".$date->format('d-m-Y H:i:s'); ?></td>	
				</tr>
				<tr>	
					<td><?php echo "<b>".getMLText('nonconfo_created_by').":</b> "."<a href=\"mailto:".htmlspecialchars($userCreator->getEmail())."\">".htmlspecialchars($userCreator->getFullName())."</a>"; ?></td>
				</tr>
			</table>
		<?php
			$this->endsBoxCollapsablePrimary();


			$this->startBoxSolidSuccess(getMLText("nonconfo_add_owners"));
		?>
		
		<form class="form-inline" action="../op/op.AddOwners.php" method="POST" name="form_2" id="form_2">
			<?php echo createHiddenFieldWithKey('addowner'); ?>
			<input type="hidden" name="processId" value="<?php echo $selProcess['id']; ?>">
				<div class="form-group">
						<select name="userId" id="userid" class="form-control">
							<option value="-1"><?php printMLText("select_one");?></option>
							<?php
								foreach ($allUsers as $user)
									if (!$user->isAdmin()) {
										print "<option value=\"".$user->getID()."\">" . htmlspecialchars($user->getLogin()." - ".$user->getFullName()) . "</option>\n";
									}
							?>
						</select>
					<div class="form-group">
						<button type="submit" class="btn btn-info"><i class="fa fa-save"></i> <?php printMLText("add"); ?></button>
					</div>
				</div>
		</form>

	<?php	
		$this->endsBoxSolidSuccess();

		if ($owners != null) {
			$this->startBoxCollapsablePrimary(getMLText("nonconfo_owners_added"));
	?>
			<table id="viewfolder-table" class="table table-condensed table-hover">
				<thead>
					<tr>
						<th><?php echo getMLText("nonconfo_owner"); ?></th>
						<th><?php echo getMLText("nonconfo_actions"); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($owners as $owner): ?>
						<tr id="table-row-owner-<?php echo $owner['id']?>">
							<td>
								<?php 
								$username = $dms->getUser($owner["userId"]);
								echo $username->getFullName(); 
								?>
							</td>
							<td>
								<div class="list-action">
									<a type="button" class="btn btn-danger btn-sm delete-owner-btn" rel="<?php echo $owner['id']; ?>" msg="<?php echo getMLText('nonconfo_rm_owner'); ?>"confirmmsg="<?php echo htmlspecialchars(getMLText("nonconfo_confirm_rm_owner", array ("nonconfo_owner" => $username->getFullName())), ENT_QUOTES); ?>" title="<?php echo getMLText("nonconfo_rm_owner"); ?>"><i class="fa fa-times"></i></a>
								</div>
							</td>
						</tr>
					<?php endforeach ?>
				</tbody>
			</table>
		<?php 
			$this->endsBoxCollapsablePrimary();

			} else {

				$this->infoMsg(getMLText("nonconfo_non_owner_exists"));

			}

		}
	} /* }}} */

	function form() { /* {{{ */
		$selProcess = $this->params['selProcess'];
		$this->showForm($selProcess);
	} /* }}} */

	function show() { /* {{{ */
		$dms = $this->params['dms'];
		$user = $this->params['user'];
		$processes = $this->params['processes'];
		$selProcess = $this->params['selProcess'];
		$userCreator = $this->params['userCreator'];
		$owners = $this->params['owners'];

		$this->htmlStartPage(getMLText("nonconfo_title"), "skin-blue sidebar-mini");
		$this->containerStart();
		$this->mainHeader();
		$this->mainSideBar(0, 4, 0);
		$this->contentStart();
		$this->getNonconfoPathHTML();
?>
<div class="row">
	<div class="col-md-4">
		<?php $this->startBoxPrimary(getMLText("nonconfo_add_owners")); ?>
			<form>
						<div class="form-group">
							<label><?php printMLText("nonconfo_select_process");?>:</label>
								<select class="chzn-select form-control" name="selector" id="selector">
									<option value="-1"><?php echo getMLText("nonconfo_select_process")?></option>
										<?php
											foreach ($processes as $process) {
												print "<option value=\"".$process['id']."\" data-subtitle=\"\"";
												print ">" . htmlspecialchars($process['name']) . "</option>\n";
											}
										?>
								</select>
							
						</div>
			</form>
		<?php $this->endsBoxPrimary(); ?>
	</div>
	<div class="col-md-8">
		<?php $this->startBoxSuccess(getMLText("nonconfo_owners_details")); ?>
			<div class="ajax" data-view="AddOwners" data-action="form" <?php echo ($process ? "data-query=\"processid=".$selProcess['id']."\"" : "") ?>></div>
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
