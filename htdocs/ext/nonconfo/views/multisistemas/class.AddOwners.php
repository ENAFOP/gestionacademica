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
		bootbox.dialog(confirmmsg, [{
		"label" : "<i class='icon-remove'></i><?php echo getMLText("nonconfo_rm_owner"); ?>",
		"class" : "btn-danger",
		"callback": function() {
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
				}, {
					"label" : "<?php echo getMLText("cancel"); ?>",
					"class" : "btn-cancel",
					"callback": function() {
					}
				}]);
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
			$this->contentSubHeading(getMLText("nonconfo_process_info"));
		?>
			<hr/>
			<table class="table-condensed">
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
			<hr/>

		<?php

		$this->contentSubHeading(getMLText("nonconfo_add_owners"));
?>
		
		<form class="form-inline" action="../op/op.AddOwners.php" method="POST" name="form_2" id="form_2">
			<?php echo createHiddenFieldWithKey('addowner'); ?>
			<input type="hidden" name="processId" value="<?php echo $selProcess['id']; ?>">
			<table class="table-condensed">
				<tr>
					<td>
						<select name="userId" id="userid">
							<option value="-1"><?php printMLText("select_one");?></option>
							<?php
								foreach ($allUsers as $user)
									if (!$user->isAdmin()) {
										print "<option value=\"".$user->getID()."\">" . htmlspecialchars($user->getLogin()." - ".$user->getFullName()) . "</option>\n";
									}
							?>
						</select>
					</td>
					<td>
						<input type="submit" class="btn btn-success" value="<?php printMLText("add"); ?>">
					</td>
				</tr>
			</table>
		</form>

		<hr/>
	<?php	
		$this->contentSubHeading(getMLText("nonconfo_owners_added"));

		if ($owners != null) {
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
									<a class="delete-owner-btn" rel="<?php echo $owner['id']; ?>" msg="<?php echo getMLText('nonconfo_rm_owner'); ?>"confirmmsg="<?php echo htmlspecialchars(getMLText("nonconfo_confirm_rm_owner", array ("nonconfo_owner" => $username->getFullName())), ENT_QUOTES); ?>" title="<?php echo getMLText("nonconfo_rm_owner"); ?>"><i class="icon-remove"></i></a>
								</div>
							</td>
						</tr>
					<?php endforeach ?>
				</tbody>
			</table>
		<?php 
			} else {
				echo getMLText("nonconfo_non_owner_exists");
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

		$this->htmlAddHeader('<script type="text/javascript" src="/styles/'.$this->theme.'/bootbox/bootbox.min.js"></script>'."\n", 'js');

		$this->htmlStartPage(getMLText("nonconfo_title"));
		$this->globalNavigation();
		$this->contentStart();
		$this->pageNavigation("nonconfo_title", "nonconfo_view_navigation", "");

?>

<div class="row-fluid">
	<div class="span4">
		<?php $this->contentHeading(getMLText("nonconfo_add_owners")); ?>
		<div class="well">
			<form class="form-horizontal">
					<table class="table">
						<tr>
							<td><?php printMLText("nonconfo_select_process");?>:</td>
							<td>
								<select class="chzn-select" name="selector" id="selector">
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
					</table>
			</form>
		</div>
	</div>
	<div class="span8">
		<?php $this->contentHeading(getMLText("nonconfo_owners_details")); ?>
		<div class="well">
			<div class="ajax" data-view="AddOwners" data-action="form" <?php echo ($process ? "data-query=\"processid=".$selProcess['id']."\"" : "") ?>></div>
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
