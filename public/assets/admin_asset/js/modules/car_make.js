$(function () {
	$( "#save_user_btn" ).click(function() {
		$.addUpdateSystemUser();
	});

	$( "#addbutton" ).click(function() {
		$.resetCarForm();
	});

	// List users
	$.getMakeListing(0);

});

$.resetCarForm = function()
{
	var makeId = $.trim($('#make_id').val());

	//reset fields
	$('#car_make, #make_id').val('');
	$('#statusactive').prop('checked', true);

	if(makeId != '' && makeId != '0')
	{
		$('#popupTitle').html('Add car make');
	}
	else
	{
		$('#popupTitle').html('Add car make');		
	}

	//reset divs

}

$.getMakeListing = function(page)
{
	var requestData = {"page":page, limit:12};
	var request = ajaxExec('car/make', requestData, 'get', '#response_msg', $.makeListing);
}

$.showEditPopup = function(id)
{
	$.resetUserForm();
	$('#popupTitle').html('Update system user');
	$('#user_id').val(userId);
    $('#user_popup').modal('show');
    $.getUser();
}

$.getUser = function() {
	var userId = $('#user_id').val();
	var requestData = {"user_id": userId};
	var request = ajaxExec('system_users/' + userId, requestData, 'GET', '#response_msg');	

	request.done(function(data) {
		if(data.status == 'success')
		{
			$('#user_first_name').val(data.data.first_name);
			$('#user_last_name').val(data.data.last_name);
			$('#user_email').val(data.data.email);
			$('#user_mobile').val(data.data.mobile);
			$('#file_path').val(data.data.pic_path);
			$('#status' + data.data.status).prop('checked', true);
			if(data.data.pic_path != '')
			{
				var userImage = '<img src="'+data.data.profile_pic+'" style="margin-right:10px;" width="40" class="img-circle" /> ';
			}
        	else
	        {
        		var userImage = '<img style="float:left; margin-right:10px;" data-name="'+data.data.first_name+'" class="profile"/> ';
			}

			$('#user_image').html(userImage);
			$('.profile').initial({width:30, height: 30, fontSize:10});         

		}
	});
}

$.deleteUser = function(userId) 
{
	var requestData  = {};
    var request = ajaxExec('system_users/' + userId, requestData, 'delete', '#response_msg');
	request.done(function(data) {

		if(data.status == 'success' )
		{
			$.msgShow('#response_msg', data.message, 'success');
			$('#deletePopup').modal('hide');
			$.getUserListing(0);
		}
		else
		{
			$.msgShow('#response_msg', data.message, 'error');
		}
	});
}

$.makeListing = function(data) {
	var userHtml = '';
	if(data.status == 'success')
	{
		if(data.data.data.length > 0)
		{
	        $.each( data.data.data, function( key, userRec ) {



	        	if(userRec.pic_path == '')
	        	{
	        		var userImage = '<img style="float:left; margin-right:10px;" data-name="'+userRec.first_name+'" class="profile"/> ';
	        	}
	        	else
	        	{
					var userImage = '<img src="'+userRec.profile_pic+'" style="margin-right:10px; width:30px; height:30px;" /> ';
	        	}

	        	if(userRec.status == 'active')
	        	{
					var userStatusClass = 'btn-success';
	        	}
	        	else
	        	{
	        		var userStatusClass = 'btn-inverse';
	        	}

	 			userHtml += '<tr>\
	                            <td class="text-left">\
									'+userImage + userRec.first_name + ' ' + userRec.last_name +'\
	                            </td>\
	                            <td class="text-left"><a href="mailto:'+userRec.email+'">'+userRec.email+'</a></td>\
	                            <td class="text-left">'+ userRec.mobile +'</td>\
	                            <td class="text-left"> <span class="label label-primary">'+userRec.created_at_formatted+'</span> </td>\
	                            <td class="text-right">\
	                              <a href="javascript:void(0);"><button class="btn '+userStatusClass+' btn-xs">'+ucfirst(userRec.status)+'</button></a>\
	                              <a href="javascript:void(0);" onclick="$.showEditPopup('+userRec.id+');" class="btn btn-default btn-xs" data-target="#user_popup" data-modal-options="slide-down" data-content-options="modal-sm h-center" title="Edit"><i class="fa fa-pencil"></i></a>\
	                              <a href="javascript:void(0);" onclick="$.confirmDel('+userRec.id+', this, \'deleteUser\');" data-entityname="'+userRec.first_name + ' ' + userRec.last_name+'" class="btn btn-danger btn-xs" title="Delete"><i class="fa fa-times"></i></a>\
	                            </td>\
	                          </tr>';
	        });

	        $('#responsive-table-body').html(userHtml);
			$('#user_pagination').twbsPagination({
			        totalPages: data.data.paginator.total_pages,
			        visiblePages: 7,
			        onPageClick: function (event, page) {
						$.getUserListing(page);
			        }
			});

			$('.profile').initial({width:30, height: 30, fontSize:10});         
		}

	}
}

$.addUpdateSystemUser = function()
{
	var check = true;
	var method = 'POST';
	var endPoint = 'system_users';
	var firstName = $.trim($('#user_first_name').val());
	var lastName = $.trim($('#user_last_name').val());
	var email = $.trim($('#user_email').val());
	var password = $.trim($('#user_password').val());
	var mobile = $.trim($('#user_mobile').val());
	var status = $('input[name=user_status]:checked').val();
	var imagePath = $.trim($('#file_path').val());
	var userId = $.trim($('#user_id').val());
	if(userId != '')
	{
		method = 'PUT';
		endPoint += '/' + userId;
	}

	check = validateText('#user_first_name', firstName, check);
	check = validateText('#user_last_name', lastName, check);
	check = validateText('#user_mobile', mobile, check);
	check = validateText('#user_email', email, check);
	check = validateText('#user_password', password, check);

	if(email != '')
	{
		check = validateEmail('#user_email', '#response_msg', email, check);
	}

	if(password != '')
	{
		check = validatePassword('#user_password', '#response_msg', password, check);
	}

	// user image validation

	if(check)
	{
		requestData = {"user_id": userId, "first_name":firstName, "last_name":lastName, "email":email, "password":password, "mobile":mobile, "status":status, "image_path":imagePath};
		var request = ajaxExec(endPoint, requestData, method, '#response_msg');
		request.done(function(data) {
			if(data.status == 'success')
			{
			    setTimeout(function(){
					$('#user_popup').modal('hide');

				$.getUserListing(0);

					// Rest Data
					$.resetUserForm();

			    }, 2000);  
				$.msgShow('#response_msg', data.message, 'success');
			}
			else
			{
				$.msgShow('#response_msg', data.message, 'error');
			}
		});
	}
	
	
}