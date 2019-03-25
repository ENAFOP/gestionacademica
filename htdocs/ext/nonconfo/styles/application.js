$(document).ready( function() {
	$('body').on('click', 'a.enable-comment-btn', function(ev){ /* {{{ */
		alert('IN');
		ev.preventDefault();
		attr_rel = $(ev.currentTarget).attr('rel');
		attr_msg = $(ev.currentTarget).attr('msg');
		id = attr_rel;
		$.get('../op/op.Ajax.php',
			{ command: 'toggleanalysisedit', id: id },
			function(data) {
				if(data.success) {
					$("#table-row-document-"+id).html('Loading').load('../op/op.Ajax.php?command=view&view=documentlistrow&id='+id)
					noty({
						text: attr_msg,
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
	}); /* }}} */
}); /* }}} */