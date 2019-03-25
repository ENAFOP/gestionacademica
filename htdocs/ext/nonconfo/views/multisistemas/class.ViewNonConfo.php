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
//		echo '<script src="../../styles/application.js"></script>'."\n";
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

		$this->htmlStartPage(getMLText("nonconfo_title"));
		$this->globalNavigation();
		$this->contentStart();
		$this->pageNavigation("nonconfo_title", "nonconfo_view_navigation", "");
		
?>

<div class="row-fluid">
	<div class="span12">
		<?php $this->contentHeading(getMLText("nonconfo_view_nonconfo")); ?>
		<div class="well">
			<?php echo $this->contentSubHeading(getMLText("nonconfo_general_info")); ?>
			<div style="overflow-x: auto;">
			<table class="table table-striped">
				<?php
					$date = new DateTime();
					$date->setTimestamp($nonconfo['created']);
				?>
				<thead>
					<tr>
						<th><?php echo getMLText('nonconfo_correlative'); ?></th>
						<th><?php echo getMLText("nonconfo_process_name"); ?></th>
						<th><?php echo getMLText("nonconfo_request_date"); ?></th>
						<th><?php echo getMLText("nonconfo_action_type"); ?></th>
						<th><?php echo getMLText("nonconfo_origin_source"); ?></th>
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
			<div style="overflow-x: auto;">
			<table class="table">
				<thead>
					<tr>
						<th><?php echo getMLText("nonconfo_description"); ?>	</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>
							<div class="span12">
								<form class="form-horizontal" action="<?php echo '../op/op.EditNonConfo.php' ?>" id="form2" name="form2" method="post">
								<?php echo createHiddenFieldWithKey('editnonconfo'); ?>
								<?php echo	"<textarea id='nonconfo-description' class='comment_width' name='nonconfo-description' rows='5' cols='100' disabled>".$nonconfo['description']."</textarea>" ?>
									<?php 
										if ($user->getID() == $nonconfo['createdBy']) {
											echo "<div>";
											echo "<hr>";
											echo "<a type=\"button\" class=\"btn btn-sm btn-info\" id='enable-desc-btn'><i class=\"icon-unlock\"></i> ".getMLText('nonconfo_enable_desc_box')."</a> ";
											echo "<input type=\"hidden\" name=\"nonconfoId\" value=\"".$nonconfo['id']."\"></input>";
											echo "<input type=\"submit\" class=\"btn btn-success\" value='".getMLText('nonconfo_save')."'>";
											echo "</div>";
										}
									?>
								</form>
							</div>
						</td>
					</tr>
					<tr>
						<td class="lbl-right">
						<?php if (false != $processOwners) {
							for($i = 0; $i < count($processOwners); $i++){
								if ($user->getID() == $processOwners[$i]['userId'] && $analysis == false) {
									echo "<a type=\"button\" id=\"display-analysis\" class=\"btn btn-sm btn-warning\">".getMLText('nonconfo_add_analysis')."</a>";
								}
							}
						} else { 
							echo getMLText('nonconfo_non_owner_exists');
						}
						?>
						</td>
					</tr>
				</tbody>
			</table>
			</div>
		</div>
	</div>
</div>

<?php 
	/**
	 * This code block if for analysis management
	 */
?>
<div class="row-fluid" id="analysis-block" <?php if ($analysis == false) { echo "style=\"display: none;\""; } ?>>
	<div class="span12">
		<div class="well">
		<?php 
			echo $this->contentSubHeading(getMLText("nonconfo_analysis")); 
			if($operation == 'add') {
				$action = "../op/op.AddAnalysis.php";
			} else {
				$action = "../op/op.EditAnalysis.php";
			}
		?>
			<form class="form-horizontal" action="<?php echo $action ?>" id="form1" name="form1" method="post" enctype="multipart/form-data">
			<?php echo createHiddenFieldWithKey($operation.'analysis'); ?>
			<input type="hidden" name="nonconfoId" value="<?php echo $nonconfo['id']; ?>">
			<div style="overflow-x: auto;">
				<table class="table">
						<thead>
							<tr>
								<th><?php echo getMLText("nonconfo_analysis_description"); ?>	</th>
								<th><?php echo getMLText("nonconfo_attached_files"); ?>	</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>
									<div class="span12">
									<?php
									if($analysis != false) { 
											echo "<textarea id='analysis-comment' class=\"comment_width\" name=\"description\" rows=\"5\" cols=\"100\" disabled>".$analysis['comment']."</textarea>";
										} else {
											echo "<textarea class=\"comment_analysis\" name=\"description\" rows=\"5\" cols=\"100\"></textarea>";
										}
									?>
									</div>
								</td>
								<td>
									<div class="span12">
									<?php if(!empty($analysis['fileName'])) {
										echo("<a href='../op/op.ViewAnalysisAttach.php?filename=".$analysis['fileName']."&type=".$analysis['mimeType']."'>".$analysis['fileName']."</a>");
									} else {
										echo getMLText('nonconfo_none');
									}
									?>
									</div>
								</td>
							</tr>
							<tr>
								<td class=""><?php printMLText("nonconfo_attach_file");?>:
	                <div id="upload-files">
	                  <div id="upload-file">
	                    <div class="input-append">
	                      <input type="text" class="form-control" readonly>
	                      <span class="btn btn-default btn-file">
										     	<?php printMLText("browse");?>&hellip; <input id="filename" type="file" name="attach[]">
										    </span>
	                    </div>
	                  </div>
	                </div>
            		</td>
            		<td></td>
							</tr>
							<tr>
								<td>

								<?php 

									if (false != $processOwners) {
										for($i = 0; $i < count($processOwners); $i++){
											if ($user->getID() == $processOwners[$i]['userId']) {
												if($analysis == false ) { 
													echo "<input type=\"hidden\" name=\"operation\" value=\"add\"></input>";
													echo "<input type=\"submit\" class=\"btn btn-primary\" value=\"".getMLText('nonconfo_save')."\">";
													echo "<a type=\"button\" id=\"cancel-btn\" class=\"btn btn-sm btn-default\">".getMLText('cancel')."</a>";
												} else {
													echo "<div>";
													echo "<a type=\"button\" class=\"btn btn-sm btn-info\" id='enable-comment-btn' title=\"".getMLText('nonconfo_edit_nonconfo_analysis')."\"><i class=\"icon-unlock\"></i> ".getMLText('nonconfo_enable_comment_box')."</a> ";
													echo "<input type=\"hidden\" name=\"analysisId\" value=\"".$analysis['id']."\"></input>";
													echo "<input type=\"hidden\" name=\"operation\" value=\"edit\"></input>";
													echo "<input type=\"submit\" class=\"btn btn-success\" value='".getMLText('nonconfo_save')."' title=\"".getMLText('nonconfo_edit_nonconfo_analysis')."\">";
													echo "</div>";
												}
											}
										}
									}
								?>

								</td>
								<td class="lbl-right">
								<?php if($analysis != false ) {
									if (false != $processOwners) {
										for($i = 0; $i < count($processOwners); $i++){
											if ($user->getID() == $processOwners[$i]['userId']) {
												if (false != $actions && count($actions) >= 1) {
													echo "<a type=\"button\" href=\"../op/op.ManageNotifications.php?action=1&nonconfoId=".$nonconfo['id']."&processId=".$process['id']."\" id=\"send-request-btn\" class=\"btn btn-sm btn-info\"><i class=\"icon-envelope\"></i> ".getMLText('nonconfo_aprovation_request')."</a><br/><br/>";
												}
												echo "<a type=\"button\" href=\"../out/out.AddAction.php?nonconfoId=".$nonconfo['id']."\" id=\"add-actions-btn\" class=\"btn btn-sm btn-warning\"><i class=\"icon-plus\"></i> ".getMLText('nonconfo_add_actions')."</a>";
											}
										}
									} 
									if ($user->getID() == $nonconfo['createdBy'] && count($actions) >= 1) {
										echo "<a type=\"button\" href=\"../op/op.ManageNotifications.php?action=2&nonconfoId=".$nonconfo['id']."&processId=".$process['id']."\" id=\"send-request2-btn\" class=\"btn btn-sm btn-primary\"><i class=\"icon-envelope\"></i> ".getMLText('nonconfo_approved')."</a><br/><br/>";
										echo "<a type=\"button\" href=\"../op/op.ManageNotifications.php?action=3&nonconfoId=".$nonconfo['id']."&processId=".$process['id']."\" id=\"send-request3-btn\" class=\"btn btn-sm btn-danger\"><i class=\"icon-envelope\"></i> ".getMLText('nonconfo_disapprove')."</a>";
									}
								} ?>
								</td>
							</tr>
						</tbody>
					</table>
					</div>
				</form>
		</div>
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
	echo "<div class='row-fluid'>
		<div class='span12'>
			<div class='well'>
				<div style='overflow-x: auto;''>
					<table class='table table-striped'>
						<thead>
							<tr>
								<th>".getMLText('nonconfo_action_detail')."</th>
								<th>".getMLText('nonconfo_action_date_start')."</th>
								<th>".getMLText('nonconfo_action_date_end')."</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class='span8'>
									<div class='comment_width'>
										<strong>".$i['description']."</strong>
									</div>
								</td>
								<td><span class='label label-success'>
									".$dateStart->format('d-m-Y')."
								</span></td>
								<td><span class='label label-warning'>
									".$dateEnd->format('d-m-Y')."
								</span></td>
								<td>";
								if ($i['status'] != 2) {
									if (false != $processOwners) {
											for($j = 0; $j < count($processOwners); $j++){
												if ($user->getID() == $processOwners[$j]['userId']) {
													if ($i['status'] == 0) {
														echo "<a type='button' href='../out/out.EditAction.php?actionId=".$i['id']."' class='btn btn-success' rel='' id='btn-edit-action'><i class='icon-pencil'></i> ".getMLText('nonconfo_edit')."</a> ";
														echo "<a type='button' href='../op/op.DeleteAction.php?actionId=".$i['id']."&nonconfoId=".$nonconfo['id']."' class='btn btn-danger' rel='' id='btn-edit-action'><i class='icon-close'></i> ".getMLText('nonconfo_delete')."</a>";
													} else if ($i['status'] == 1) {
														echo "<span class='label label-primary'>".getMLText('nonconfo_action_approved')."</span>";
													}
											}
										}
									}

									if ($user->getID() == $nonconfo['createdBy'] && $i['status'] == 0) {
										echo "<a type='button' href='../op/op.ApproveAction.php?actionId=".$i['id']."' class='btn btn-info' rel='' id='btn-aprove-action'><i class='icon-check'></i> ".getMLText('nonconfo_approve')."</a> ";
										if (!isset($actionsComments[$k][0]['actionId'])) {
											echo "<a type='button' class='btn btn-warning' rel='".$i["id"]."' id='btn-comment-action'><i class='icon-pencil'></i> ".getMLText('nonconfo_comment')."</a>";
										}
									}

									if ($user->getID() == $nonconfo['createdBy'] && $i['status'] == 1) {
										echo "<a type='button' href='../out/out.FollowAction.php?actionId=".$i['id']."' class='btn btn-warning' rel='' id='btn-follow-action'><i class='icon-star'></i> ".getMLText('nonconfo_follow')."</a>";
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
												<td><a type='button' class='btn btn-danger' href='../op/op.DeleteComment.php?commentId=".$actionsComments[$k][0]['id']."&nonconfoId=".$nonconfo['id']."'>".getMLText('nonconfo_delete_comment')."</a>
												</td>
											</tr>";
								}
							}
	echo				"<tr id='action-comment-".$i['id']."' style='display:none;'>
								<form class='form-horizontal' action='../op/op.AddComment.php' method='post'>
									<td>
										<textarea class=\"comment_width\" name=\"action-comment\" rows=\"5\" cols=\"100\" ></textarea>
									</td>
									<td>
										<input type=\"hidden\" name=\"nonconfoId\" value=\"".$nonconfo['id']."\"></input>
										<input type=\"hidden\" name=\"actionId\" value=\"".$i['id']."\"></input>".
										createHiddenFieldWithKey('addactioncomment')."
										<input type=\"submit\" class=\"btn btn-primary\" value='".getMLText('nonconfo_save')."'>
									</td>
								</form>
							</tr>
						</tbody>
					</table><hr>"; ?>
		<?php if ($i['status'] == 2) { 
					if (false != $actionsFollows && count($actionsFollows) >= 1) { ?>
					<div style="overflow-x: auto;">
						<table class="table table-striped">
							<thead>
							<tr>
								<th><?php echo getMLText('nonconfo_follow_detail');?></th>
								<th><?php echo getMLText('nonconfo_action_date_start'); ?></th>
								<th><?php echo getMLText('nonconfo_action_real_date_end');?></th>
								<th><?php echo getMLText('nonconfo_before'); ?></th>
								<th><?php echo getMLText('nonconfo_after'); ?></th>
								<th><?php echo getMLText('nonconfo_was_efective');?></th>
							</tr>
							</thead>
							<tbody>
							<?php if (isset($actionsFollows[$k][0]['actionId']) && $actionsFollows[$k][0]['actionId'] == $i['id']) { ?>
								<tr>
									<td class="td_follow">
										<div class="comment_width">
											<?php echo $actionsFollows[$k][0]['followResult']; ?>											
										</div>
									</td>
									<td class="td_follow">
										<?php echo $dateStart->format('d-m-Y'); ?>
									</td>
									<td class="td_follow">
										<?php $date = new DateTime();
													$date->setTimestamp($actionsFollows[$k][0]['realDateEnd']);
										echo 	$date->format('d-m-Y'); ?>
									</td>
									<td class="td_follow">
										<?php echo $actionsFollows[$k][0]['indicatorBefore'];?>
									</td>
									<td class="td_follow">
										<?php echo $actionsFollows[$k][0]['indicatorAfter'];?>
									</td>
									<td class="td_follow_efective">
										<?php echo $actionsFollows[$k][0]['finalStatus']; ?>
									</td>
								</tr>
							<?php } ?>
							</tbody>
						</table>
					</div>
					<?php 
						} 
					}
	echo	"</div>
			</div>
		</div>
	</div>";
	$i++;
	$k++;
} } ?>

<?php

		$this->contentContainerEnd();
		$this->contentEnd();
		$this->htmlEndPage();

	} /* }}} */
}
?>
