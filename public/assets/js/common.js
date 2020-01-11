/**
 * delete modal script
 */
 function success_deleteAction(){
	$('#delete_modal').on('shown.bs.modal', function(e) {
		var action = $(e.relatedTarget).data('action');
		var msg = $(e.relatedTarget).data('msg');
		$(e.currentTarget).find('form').attr('action', action);
		$(e.currentTarget).find('form .modal-body .delete_note').html(msg);
	});
	$('#delete_modal').on('hidden.bs.modal', function (e) {
		$(e.currentTarget).find('.modal-body .delete_note').html('');
		$(e.currentTarget).find('form').attr('action', '');
	});
 }