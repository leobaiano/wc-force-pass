(function($) {
	$(document).ready(function() {
		$(document.body).on('keyup change', 'form.register #reg_password, form.checkout #account_password, form.edit-account #password_1, form.lost_reset_password #password_1', function() {
			$(this).closest('form').find('input[type="submit"]').attr('disabled', false).removeClass('disabled');
		});
	});
})(jQuery);