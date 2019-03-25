<?php
/**
 * Implementation of ViewAllNonConfo view
 *
 * @category   DMS
 * @package    SeedDMS
 * @license    GPL 2
 * @version    @version@
 * @author     Luis Medrano <lmedrano@multisistemas.com.sv>
 * @copyright  Copyright (C) 2011-2017 Multisistemas,
 * @version    Release: @package_version@
 */

/**
 * Include parent class
 */
require_once("../../../views/$theme/class.Bootstrap.php");

/**
 * Class which outputs the html page for ViewAllNonConfo view
 *
 * @category   DMS
 * @package    SeedDMS
 * @author     Markus Westphal, Malcolm Cowe, Uwe Steinmann <uwe@steinmann.cx>
 * @copyright  Copyright (C) 2002-2005 Markus Westphal,
 *             2006-2008 Malcolm Cowe, 2010 Matteo Lucarelli,
 *             2010-2012 Uwe Steinmann
 * @version    Release: @package_version@
 */
class SeedDMS_View_ViewAllNonConfo extends SeedDMS_Bootstrap_Style {

	function js() { /* {{{ */
		header('Content-Type: application/javascript; charset=UTF-8');
?>
function checkForm()
{
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

	$('body').on('click', 'a#delete-btn', function(ev){
		id = $(ev.currentTarget).attr('rel');
		confirmmsg = $(ev.currentTarget).attr('confirmmsg');
		msg = $(ev.currentTarget).attr('msg');
		formtoken = "<?php echo createFormKey('deletenonconfo'); ?>";

		bootbox.confirm({
    		message: confirmmsg,
    		buttons: {
        	confirm: {
            label: "<i class='fa fa-times'></i> <?php printMLText("nonconfo_rm_nonconfo"); ?>",
            className: 'btn-danger'
        	},
        	cancel: {
            label: "<?php printMLText("cancel"); ?>",
            className: 'btn-default'
        	}
    		},
	    		callback: function (result) {
	    			if (result) {
	  					$.get('../op/op.DeleteNonConfo.php',
							{ id: id, formtoken: formtoken },
										function(data) {
											if(data.success) {
												$('#table-row-nonconfo-'+id).hide('slow');
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
		$nonconfos = $this->params['nonconformities'];
		$processOwners = $this->params['processOwners'];
		$nonconfosByProcess = $this->params['nonconfosByProcess'];

		$this->htmlStartPage(getMLText("nonconfo_title"), "skin-blue sidebar-mini");
		$this->containerStart();
		$this->mainHeader();
		$this->mainSideBar(0, 1, 0);
		$this->contentStart();
		$this->getNonconfoPathHTML();
		$date = new DateTime();
?>
<div class="row">
	<div class="col-md-12">

		<?php $this->startBoxPrimary(getMLText("nonconfo_created_by_current_user")); ?>

			<div style="overflow-x: auto;">
			<table class="table table-bordered table-striped">
				<thead>
					<tr>
						<th class="align-center">#</th>
						<th class="align-center"><?php echo getMLText("nonconfo_correlative"); ?></th>
						<th class="align-center"><?php echo getMLText("nonconfo_process_name"); ?></th>
						<th class="align-center"><?php echo getMLText("nonconfo_request_date"); ?></th>
						<th class="align-center"><?php echo getMLText("nonconfo_action_type"); ?></th>
						<th class="align-center"><?php echo getMLText("nonconfo_origin_source"); ?></th>
						<th class="align-center"></th>
					</tr>	
				</thead>
				<tbody>				
				<?php $i = 0; $j = 1;
				if (false != $nonconfos) {
					foreach ($nonconfos as $nonconfo => $i) { ?>
						<tr id="table-row-nonconfo-<?php echo $i['id']; ?>">
							<td><?php echo $j; ?></td>
							<td><?php echo $i['correlative']; ?></td>
							<td><?php
							for ($k=0; $k < count($processes); $k++) { 
								if ($i['processId'] == $processes[$k]['id']) {
									echo $processes[$k]['name'];
								}
							}
							?></td>
							<td><?php $date->setTimestamp($i['created']); echo $date->format('d-m-Y H:i:s'); ?></td>
							<td><?php echo $i['type']; ?></td>
							<td><?php echo $i['source']; ?></td>
							<td><a type="button" class="btn btn-info" href="../out/out.ViewNonConfo.php?nonconfoId=<?php echo $i['id']; ?>"><i class="fa fa-eye"></i></a>
							
							<a type="button" id="delete-btn" class="btn btn-danger" rel="<?php echo $i['id']; ?>" msg="<?php echo getMLText('nonconfo_rm_nonconfo'); ?>"confirmmsg="<?php echo htmlspecialchars(getMLText("nonconfo_confirm_rm_nonconfo"), ENT_QUOTES); ?>" title="<?php echo getMLText("nonconfo_rm_nonconfo"); ?>"><i class="fa fa-times"></i></a></td>
						</tr>
					<?php $j++; 
					}
				}	 
				?>
				</tbody>
			</table>
			</div>

			<?php $this->endsBoxPrimary(); ?>

	</div>
</div>

<div class="row">
	<div class="col-md-12">

		<?php $this->startBoxSuccess(getMLText("nonconfo_user_are_responsible")); ?>

			<div style="overflow-x: auto;">
			<table class="table table-bordered table-striped">
				<thead>
					<tr>
						<th class="align-center">#</th>
						<th class="align-center"><?php echo getMLText("nonconfo_correlative"); ?></th>
						<th class="align-center"><?php echo getMLText("nonconfo_process_name"); ?></th>
						<th class="align-center"><?php echo getMLText("nonconfo_request_date"); ?></th>
						<th class="align-center"><?php echo getMLText("nonconfo_action_type"); ?></th>
						<th class="align-center"><?php echo getMLText("nonconfo_origin_source"); ?></th>
						<th class="align-center"></th>
					</tr>	
				</thead>
				<tbody>
				<?php if(count($nonconfosByProcess) > 0 && $nonconfosByProcess != null){ ?>
					<?php $l = 1; ?>
					<?php for($i = 0; $i < count($nonconfosByProcess); $i++) { ?>
						<?php if(false != $nonconfosByProcess[$i]) { ?>
							<?php for($j = 0; $j < count($nonconfosByProcess[$i]); $j++) { ?>
								<tr>
									<td><?php echo $l; ?></td>
									<td><?php echo $nonconfosByProcess[$i][$j]['correlative']; ?></td>
									<td>
									<?php for ($k=0; $k < count($processes); $k++) { 
										if ($nonconfosByProcess[$i][$j]['processId'] == $processes[$k]['id']) {
											echo $processes[$k]['name'];
										}
									} ?>
									</td>
									<td>
									<?php $date->setTimestamp($nonconfosByProcess[$i][$j]['created']); echo $date->format('d-m-Y H:i:s'); ?>
									</td>
									<td><?php echo $nonconfosByProcess[$i][$j]['type']; ?></td>
									<td><?php echo $nonconfosByProcess[$i][$j]['source']; ?></td>
									<td>
										<a type="button" class="btn btn-info" href="../out/out.ViewNonConfo.php?nonconfoId=<?php echo $nonconfosByProcess[$i][$j]['id']; ?>"><i class="fa fa-eye"></i></a>
									</td>
								</tr>
							<?php	$l++; } ?>
						<?php } ?>
					<?php } ?>
				<?php } ?>
				</tbody>
			</table>
			</div>

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
