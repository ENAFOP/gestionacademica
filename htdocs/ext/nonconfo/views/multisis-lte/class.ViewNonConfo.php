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
require_once("../op/op.Ajax.php");

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
class SeedDMS_View_ViewNonConfo extends SeedDMS_Bootstrap_Style {

	function js() { /* {{{ */
		$nonconfo = $this->params['nonconfo'];
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

	/* Show analysis form */
	$("#display-analysis").on('click', function() {
   	$("#analysis-block").fadeIn('slow');
	});

	/* Cancel analysis */
	$("#cancel-btn").on('click', function() {
   	$("#analysis-block").fadeOut('slow');
	});

	$("#enable-comment-btn").on('click', function(){
		$("#analysis-comment").attr('disabled', false);
	});

	$("#enable-desc-btn").on('click', function(){
		$("#nonconfo-description").attr('disabled', false);
	});

	$("#send-request-btn").on('click', function(){
		$(this).attr('disabled', true);
	});

	$("#send-request2-btn").on('click', function(){
		$(this).attr('disabled', true);
	});

	$("#send-request3-btn").on('click', function(){
		$(this).attr('disabled', true);
	});

	$("#btn-comment-action").on('click', function(){
		var id = $(this).attr('rel');
		$('#action-comment-'+id).show('slow');
	});

	$('#send-request-btn').on('click', function(){
		$("#theemailactions").append("<div class=\"overlay\"><i class=\"fa fa-refresh fa-spin\"></i></div>");
	});

	$('#send-request2-btn').on('click', function(){
		$("#theemailactions").append("<div class=\"overlay\"><i class=\"fa fa-refresh fa-spin\"></i></div>");
	});

	$('#send-request3-btn').on('click', function(){
		$("#theemailactions").append("<div class=\"overlay\"><i class=\"fa fa-refresh fa-spin\"></i></div>");
	});

});

<?php

} /* }}} */

	function show() { /* {{{ */
		$dms = $this->params['dms'];
		$user = $this->params['user'];
		$allUsers = $this->params['allUsers'];
		$nonconfo = $this->params['nonconfo'];
		$process = $this->params['process'];
		$analysis = $this->params['analysis'];
		$actions = $this->params['actions'];
		$processOwners = $this->params['processOwners'];
		$actionsFollows = $this->params['actionsFollows'];
		$actionsComments = $this->params['actionsComments'];
		$operation = $this->params['operation'];

		$this->htmlStartPage(getMLText("nonconfo_title"), "skin-blue sidebar-mini");
		$this->containerStart();
		$this->mainHeader();
		$this->mainSideBar(0,5,0);
		$this->contentStart();
		$this->getNonconfoPathHTML();
		
?>

<div class="row">
	<div class="col-md-12">

		<?php $this->startBoxCollapsablePrimary(getMLText("nonconfo_general_info")); ?>

			<div class="col-md-12">
			<table class="table table-bordered table-striped">
				<?php
					$date = new DateTime();
					$date->setTimestamp($nonconfo['created']);
				?>
				<thead>
					<tr>
						<th class="align-center"><?php echo getMLText('nonconfo_correlative'); ?></th>
						<th class="align-center"><?php echo getMLText("nonconfo_process_name"); ?></th>
						<th class="align-center"><?php echo getMLText("nonconfo_request_date"); ?></th>
						<th class="align-center"><?php echo getMLText("nonconfo_action_type"); ?></th>
						<th class="align-center"><?php echo getMLText("nonconfo_origin_source"); ?></th>
					</tr>	
				</thead>
				<tbody>
					<tr>
						<td><?php echo $nonconfo['correlative']; ?></td>
						<td><?php echo $process['name']; ?></td>
						<td><?php echo $date->format('d-m-Y H:i:s'); ?></td>
						<td><?php echo $nonconfo['type'] ?></td>
						<td><?php echo $nonconfo['source'] ?></td>
					</tr>
				</tbody>
			</table>
			</div>
			<div class="col-md-12">
				<form action="<?php echo '../op/op.EditNonConfo.php' ?>" id="form2" name="form2" method="post">
				<?php echo createHiddenFieldWithKey('editnonconfo'); ?>
				<div class="form-group">
					<label><?php printMLText("nonconfo_description") ?></label>
					<textarea id="nonconfo-description" class="form-control" name='nonconfo-description' rows='5' cols='100' disabled><?php echo $nonconfo['description']?></textarea>
				</div>
				<?php 
					if ($user->getID() == $nonconfo['createdBy']) { ?>
						<div class="form-group">
							<a type="button" class="btn btn-success" id='enable-desc-btn'><i class="fa fa-unlock"></i> <?php echo getMLText('nonconfo_enable_desc_box'); ?></a>
							<input type="hidden" name="nonconfoId" value="<?php echo $nonconfo['id']; ?>"></input>
							<button type="submit" class="btn btn-info"><i class="fa fa-save"></i> <?php echo getMLText('nonconfo_save'); ?></button>
						</div>
					<?php } ?>
				</form>
			</div>
			<div class="col-md-12">
				<div class="pull-right">
				<?php 
				if (false != $processOwners) {
					for($i = 0; $i < count($processOwners); $i++){
						if ($user->getID() == $processOwners[$i]['userId'] && $analysis == false) {
							echo "<a type=\"button\" id=\"display-analysis\" class=\"btn btn-warning\"><i class=\"fa fa-plus\"></i>".getMLText('nonconfo_add_analysis')."</a>";
						}
					}
				} else { 
					echo $this->errorMsg(getMLText('nonconfo_non_owner_exists'));
				}
				?>
				</div>
			</div>

		<?php	$this->endsBoxCollapsablePrimary(); ?>

	</div>
</div>

<?php 
	/**
	 * This code block if for analysis management
	 */
?>
<div class="row" id="analysis-block" <?php if ($analysis == false) { echo "style=\"display: none;\""; } ?>>
	<div class="col-md-12">
		
	<?php $this->startBoxCollapsableSuccess(getMLText("nonconfo_analysis")) ?>

		<?php
			if($operation == 'add') {
				$action = "../op/op.AddAnalysis.php";
			} else {
				$action = "../op/op.EditAnalysis.php";
			}
		?>
			<form action="<?php echo $action ?>" id="form1" name="form1" method="post" enctype="multipart/form-data">
			<?php echo createHiddenFieldWithKey($operation.'analysis'); ?>
			<input type="hidden" name="nonconfoId" value="<?php echo $nonconfo['id']; ?>">
			<div class="col-md-8">
				<div class="form-group">
					<label><?php echo getMLText("nonconfo_analysis_description"); ?>	</label>
					<?php
						if($analysis != false) { 
							echo "<textarea id=\"analysis-comment\" class=\"form-control\" name=\"description\" rows=\"5\" cols=\"100\" disabled>".$analysis['comment']."</textarea>";
						} else {
							echo "<textarea class=\"form-control\" name=\"description\" rows=\"5\" cols=\"100\"></textarea>";
						}
					?>
				</div>
				<div class="form-group">
					<label><?php echo getMLText("nonconfo_attached_files"); ?></label><br/>
				<?php 
					if(!empty($analysis['fileName'])) {
						echo("<label><a href='../op/op.ViewAnalysisAttach.php?filename=".$analysis['fileName']."&type=".$analysis['mimeType']."'>".$analysis['fileName']."</a></label>");
					} else {
						echo $this->infoMsg(getMLText('nonconfo_none'));
					}
				?>
				</div>
				<div class="form-group">
					<label><?php printMLText("nonconfo_attach_file");?></label>
					<div id="upload-files">
		        <div id="upload-file">
		          <div class="input-append">
		            <input type="text" class="form-control" readonly>
		            <span class="btn btn-primary btn-file">
							 	<?php printMLText("browse");?>&hellip; <input id="filename" type="file" name="attach[]">
							  </span>
		          </div>
		        </div>
		      </div>
	      </div>
				<div class="form-group">
					<?php 
						if (false != $processOwners) {
							for($i = 0; $i < count($processOwners); $i++){
								if ($user->getID() == $processOwners[$i]['userId']) {
									if($analysis == false ) { 
										echo "<input type=\"hidden\" name=\"operation\" value=\"add\"></input>";
										echo "<button type=\"submit\" class=\"btn btn-info\"><i class=\"fa fa-save\"></i> ".getMLText('nonconfo_save')."</button>";
										echo "<a type=\"button\" id=\"cancel-btn\" class=\"btn btn-default\">".getMLText('cancel')."</a>";
									} else {
										echo "<a type=\"button\" class=\"btn btn-success\" id='enable-comment-btn' data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"".getMLText('nonconfo_edit_nonconfo_analysis')."\"><i class=\"icon-unlock\"></i> ".getMLText('nonconfo_enable_comment_box')."</a> ";
										echo "<input type=\"hidden\" name=\"analysisId\" value=\"".$analysis['id']."\"></input>";
										echo "<input type=\"hidden\" name=\"operation\" value=\"edit\"></input>";
										echo "<button type=\"submit\" class=\"btn btn-info\"><i class=\"fa fa-save\"></i> ".getMLText('nonconfo_save')."</button>";
									}
								}
							}
						}
					?>
				</div>
			</div>
			<div class="col-md-4">
				<div class="">
					<?php 
					$this->startBoxCollapsablePrimary(getMLText("actions"), "", "theemailactions");
					if($analysis != false ) {
						if (false != $processOwners) {
							for($i = 0; $i < count($processOwners); $i++){
								if ($user->getID() == $processOwners[$i]['userId']) {
									if (false != $actions && count($actions) >= 1) {
										echo "<div><a type=\"button\" href=\"../op/op.ManageNotifications.php?action=1&nonconfoId=".$nonconfo['id']."&processId=".$process['id']."\" id=\"send-request-btn\" class=\"btn btn-info\"><i class=\"fa fa-envelope\"></i> ".getMLText('nonconfo_aprovation_request')."</a></div><br>";
									}

										echo "<div><a type=\"button\" href=\"../out/out.AddAction.php?nonconfoId=".$nonconfo['id']."\" id=\"add-actions-btn\" class=\"btn btn-warning\"><i class=\"fa fa-plus\"></i> ".getMLText('nonconfo_add_actions')."</a></div>";
								}
							}
						} 

						if ($user->getID() == $nonconfo['createdBy'] && count($actions) >= 1) {
							echo "<div><a type=\"button\" href=\"../op/op.ManageNotifications.php?action=2&nonconfoId=".$nonconfo['id']."&processId=".$process['id']."\" id=\"send-request2-btn\" class=\"btn btn-primary\"><i class=\"fa fa-envelope\"></i> ".getMLText('nonconfo_approved')."</a></div><br>";
							echo "<div><a type=\"button\" href=\"../op/op.ManageNotifications.php?action=3&nonconfoId=".$nonconfo['id']."&processId=".$process['id']."\" id=\"send-request3-btn\" class=\"btn btn-danger\"><i class=\"fa fa-envelope\"></i> ".getMLText('nonconfo_disapprove')."</a></div>";
						}
					} 

					$this->endsBoxCollapsablePrimary();
					?>			
				</div>
			</div>	
		</form>
		
		<?php $this->endsBoxCollapsableSuccess(); ?>

	</div>
</div>

<?php 
	/**
	 * This code block is for actions management 
	 */
	if (false != $actions && count($actions) >= 1 ) { 
	$i = 0;
	$k = 0;
	$dateStart = new DateTime();
	$dateEnd = new DateTime();
	foreach ($actions as $action => $i) {
	$dateStart->setTimestamp($i['dateStart']);
	$dateEnd->setTimestamp($i['dateEnd']);
	echo "<div class='row'>
				<div class='col-md-12'>";

	$this->startBoxCollapsablePrimary(getMLText("action"));

	echo  "<div class=\"table-responsive\"><table class='table table-bordered table-striped'>
						<thead>
							<tr>
								<th width='40%' class=\"align-center\">".getMLText('nonconfo_action_detail')."</th>
								<th width='20%' class=\"align-center\">".getMLText('nonconfo_action_date_start')."</th>
								<th width='20%' class=\"align-center\">".getMLText('nonconfo_action_date_end')."</th>
								<th width='20%' class=\"align-center\">".getMLText('nonconfo_actions')."</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>
									<div>
										<textarea class=\"form-control\" cols=\"100\" rows=\"5\" disabled>".$i['description']."</textarea>
									</div>
								</td>
								<td class=\"align-center\"><span class='label label-success'>
									".$dateStart->format('d-m-Y')."
								</span></td>
								<td class=\"align-center\"><span class='label label-warning'>
									".$dateEnd->format('d-m-Y')."
								</span></td>
								<td class=\"align-center\">";
								if ($i['status'] != 2) {
									if (false != $processOwners) {
											for($j = 0; $j < count($processOwners); $j++){
												if ($user->getID() == $processOwners[$j]['userId']) {
													if ($i['status'] == 0) {
														echo "<a type='button' href='../out/out.EditAction.php?actionId=".$i['id']."' class='btn btn-success' rel='' id='btn-edit-action'><i class='fa fa-pencil'></i></a> ";
														echo "<a type='button' href='../op/op.DeleteAction.php?actionId=".$i['id']."&nonconfoId=".$nonconfo['id']."' class='btn btn-danger' rel='' id='btn-edit-action'><i class='fa fa-times'></i></a>";
													} else if ($i['status'] == 1) {
														echo "<span class='label label-primary'>".getMLText('nonconfo_action_approved')."</span>";
													}
											}
										}
									}

									if ($user->getID() == $nonconfo['createdBy'] && $i['status'] == 0) {
										echo "<a type='button' href='../op/op.ApproveAction.php?actionId=".$i['id']."' class='btn btn-info' rel='' id='btn-aprove-action'><i class='fa fa-check'></i> ".getMLText('nonconfo_approve')."</a> ";
										if (!isset($actionsComments[$k][0]['actionId'])) {
											echo "<a type='button' class='btn btn-warning' rel='".$i["id"]."' id='btn-comment-action'><i class='fa fa-pencil'></i> ".getMLText('nonconfo_comment')."</a>";
										}
									}

									if ($user->getID() == $nonconfo['createdBy'] && $i['status'] == 1) {
										echo "<a type='button' href='../out/out.FollowAction.php?actionId=".$i['id']."' class='btn btn-warning' rel='' id='btn-follow-action'><i class='fa fa-rss'></i> ".getMLText('nonconfo_follow')."</a>";
									}

								} else {
									echo "<span class='label label-danger'>".getMLText('nonconfo_action_closed')."</span>";
								}
	echo 				"</td>
							</tr>";
							if (false != $actionsComments && count($actionsComments) >= 1) {
								if (isset($actionsComments[$k][0]['actionId']) && $actionsComments[$k][0]['actionId'] == $i['id']) {
								echo "<tr>
												<td>
													<div class='alert alert-danger'>".
														$actionsComments[$k][0]['description']."
													</div>
												</td>
												<td><a type='button' class='btn btn-danger' href='../op/op.DeleteComment.php?commentId=".$actionsComments[$k][0]['id']."&nonconfoId=".$nonconfo['id']."'><i class=\"fa fa-times\"></i> ".getMLText('nonconfo_delete_comment')."</a>
												</td>
											</tr>";
								}
							}
	echo				"<tr id='action-comment-".$i['id']."' style='display:none;'>
								<form class='form-horizontal' action='../op/op.AddComment.php' method='post'>
									<td>
										<textarea class=\"form-control\" name=\"action-comment\" rows=\"5\" cols=\"100\" ></textarea>
									</td>
									<td>
										<input type=\"hidden\" name=\"nonconfoId\" value=\"".$nonconfo['id']."\"></input>
										<input type=\"hidden\" name=\"actionId\" value=\"".$i['id']."\"></input>".
										createHiddenFieldWithKey('addactioncomment')."
										<button type=\"submit\" class=\"btn btn-info\"><i class=\"fa fa-save\"></i> ".getMLText('nonconfo_save')."</button>
									</td>
								</form>
							</tr>
						</tbody>
					</table></div>"; ?>
		<?php if ($i['status'] == 2) { 
					if (false != $actionsFollows && count($actionsFollows) >= 1) { ?>
					<div class="table-responsive">
						<table class="table table-bordered table-striped">
							<thead>
							<tr>
								<th width='30%' class="align-center th-info-background"><?php echo getMLText('nonconfo_follow_detail');?></th>
								<th class="align-center th-info-background"><?php echo getMLText('nonconfo_action_date_start'); ?></th>
								<th class="align-center th-info-background"><?php echo getMLText('nonconfo_action_real_date_end');?></th>
								<th class="align-center th-info-background"><?php echo getMLText('nonconfo_before'); ?></th>
								<th class="align-center th-info-background"><?php echo getMLText('nonconfo_after'); ?></th>
								<th class="align-center th-info-background"><?php echo getMLText('nonconfo_was_efective');?></th>
							</tr>
							</thead>
							<tbody>
							<?php if (isset($actionsFollows[$k][0]['actionId']) && $actionsFollows[$k][0]['actionId'] == $i['id']) { ?>
								<tr>
									<td class="align-center">
										<div>
											<textarea class="form-control" cols="100" rows="5" disabled="true" readonly="true"><?php echo $actionsFollows[$k][0]['followResult']; ?></textarea>
										</div>
									</td>
									<td class="align-center">
										<span class='label label-info'>
										<?php echo $dateStart->format('d-m-Y'); ?>
										</span>
									</td>
									<td class="align-center">
										<span class='label label-info'>
										<?php $date = new DateTime();
													$date->setTimestamp($actionsFollows[$k][0]['realDateEnd']);
										echo 	$date->format('d-m-Y'); ?>
										</span>
									</td>
									<td class="align-center">
										<?php echo $actionsFollows[$k][0]['indicatorBefore'];?>
									</td>
									<td class="align-center">
										<?php echo $actionsFollows[$k][0]['indicatorAfter'];?>
									</td>
									<td class="align-center">
										<strong>
										<?php echo $actionsFollows[$k][0]['finalStatus']; ?>
										</strong>
									</td>
								</tr>
							<?php } ?>
							</tbody>
						</table>
					</div>
					<?php 
						} 
					}
		$this->endsBoxCollapsablePrimary();
	echo "</div>
	</div>";
	$i++;
	$k++;
} } ?>

<?php

		echo "</div>";

		$this->contentEnd();
		$this->mainFooter();		
		$this->containerEnd();
		$this->htmlEndPage();

	} /* }}} */
}
?>
