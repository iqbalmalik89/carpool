// #################### event bindings ##########################
$(document).ready( function () {
	$( "#loginBtn" ).click(function() {
		$.login();
	});

	$( "#forgotBtn" ).click(function() {
		$.resetPassword();
	});

	$( "#updatePasswordBtn" ).click(function() {
		$.updatePassword();
	});

	$( "#showForgot" ).click(function() {
		showHideForgot(1);
	});

	$( "#hide_forgot_link" ).click(function() {
		showHideForgot(0);
	});

	$('#login_form').keypress(function (e) {
	 var key = e.which;
	 if(key == 13)  // the enter key code
	  {
		$.login();
	  }
	});   

});

// #################### actual functions ##########################

$.resetPassword = function() {
	var email = $.trim($('#forgot_email').val());
	var check = true;
	check = validateEmail('#forgot_email', '#response_msg', email, check);
	if(check)
	{
		var requestData = {"email":email}
		var request = ajaxExec('auth/forgot', requestData, 'POST', '#response_msg');
		request.done(function(data) {
			if(data.status == 'success')
			{
				$.msgShow('#response_msg', data.message, 'success');
				$('#forgot_email').val('');
			}
			else
			{
				$.msgShow('#response_msg', data.message, 'error');
			}
		});		
	}
}

$.updatePassword = function() {
	var code = $.trim($('#code').val());	
	var userId = $.trim($('#user_id').val());		
	var newPassword = $.trim($('#new_password').val());	
	var confirmNewPassword = $.trim($('#confirm_new_password').val());	

	var check = true;
	check = validateText('#new_password', newPassword, check);
	check = validateText('#confirm_new_password', confirmNewPassword, check);
	
	if(newPassword != '' && confirmNewPassword != '' && check)
	{
		check = validatePassword('#new_password', '#response_msg', newPassword, check);
		check = validatePassword('#confirm_new_password', '#response_msg', confirmNewPassword, check);
		if(check)
			check = compare(newPassword, confirmNewPassword, '#new_password', '#confirm_new_password',check , '#response_msg', 'New password and confirm password doesn\'t match');
	}



	if(check)
	{
		var requestData = {'user_id' : userId, "new_password":newPassword, 'confirm_password' : confirmNewPassword, "code": code}
		var request = ajaxExec('auth/update_password', requestData, 'POST', '#response_msg');
		request.done(function(data) {
			if(data.status == 'success')
			{
				$.msgShow('#response_msg', data.message + ' Redirecting ...', 'success');
				$('#new_password, #confirm_new_password').val('');
				$.redirect(appConfig.adminUrl + '/', 1500);
			}
			else
			{
				$.msgShow('#response_msg', data.message, 'error');
			}
		});		
	}
}

var showHideForgot = function(show) {
	if(show)
	{
		$('#login_container, #showForgot').toggle();
		$('#forgot_container, #hide_forgot_link').fadeToggle();		
	}
	else
	{
		$('#forgot_container, #hide_forgot_link').toggle();		
		$('#login_container, #showForgot').fadeToggle();
	}
}

$.login = function() {
	var check = true;
	var email = $.trim($('#email').val());
	var password = $.trim($('#password').val());	
	check = validateText('#email', email, check);
	check = validateText('#password', password, check);

	if(check)
	{
		var requestData = {"email":email, "password":password};
		$('#login_spinner').show();
		var request = ajaxExec('auth/login', requestData, 'POST', '#response_msg');
		request.done(function(data) {
			$('#login_spinner').hide();
			if(data.status == 'success')
			{
				$.msgShow('#response_msg', data.message, 'success');
				$.redirect(appConfig.adminUrl + 'dashboard/', 1000);
			}
			else
			{
				$.msgShow('#response_msg', data.message, 'error');
			}
		});
	}
};

