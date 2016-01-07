$(function () {
    uploadFile('#user_image_upload', 'testimonial/image', '#file_path', '#user_image', '#response_msg')

	$( "#save_btn" ).click(function() {
		$.addUpdateTestimonial();
	});

	$( "#addbutton" ).click(function() {
		$('#id').val('');
		$.resetForm();
	});


	// List records
	$.getListing(0);

	$('body').keypress(function (e) {
	 var key = e.which;
	 if(key == 13)  // the enter key code
	  {
	  	if($('#add_popup').is(':visible'))
	  	{
			$.addUpdateTestimonial();
	  	}
	  }
	});

});

$.resetForm = function()
{
	var id = $.trim($('#id').val());
	if(id != '' && id != '0')
		$('#popupTitle').html('Update Testimonial');
	else
		$('#popupTitle').html('Add Testimonial');		

	//reset fields
	$('#name, #description, #id').val('');
	$('#statusactive').prop('checked', true);
	$('div').removeClass('has-error');
}

$.getListing = function(page)
{
	var requestData = {"page":page, limit:12};
	var request = ajaxExec('testimonial', requestData, 'get', '#response_msg', $.listing);
}

$.showEditPopup = function(id)
{
	$.resetForm();
	$('#popupTitle').html('Update Testimonial');
	$('#id').val(id);
    $('#add_popup').modal('show');
    $.getRec();
}

$.getRec = function() {
	var id = $('#id').val();
	var requestData = {"id": id};
	var request = ajaxExec('testimonial/' + id, requestData, 'GET', '#response_msg');	

	request.done(function(data) {
		if(data.status == 'success')
		{
			$('#name').val(data.data.name);
			$('#description').val(data.data.description);
			$('#status' + data.data.status).prop('checked', true);


			if(data.data.pic_path != '')
			{
				var userImage = '<img src="'+data.data.image+'" style="margin-right:10px;" width="40" class="img-circle" /> ';
			}
        	else
	        {
        		var userImage = '<img style="float:left; margin-right:10px;" data-name="'+data.data.name+'" class="profile"/> ';
			}

			$('#user_image').html(userImage);
			$('.profile').initial({width:30, height: 30, fontSize:10});         

		}
	});
}

$.deleteTestimonial = function(id) 
{
	var requestData  = {};
    var request = ajaxExec('testimonial/' + id, requestData, 'delete', '#response_msg');
	request.done(function(data) {

		if(data.status == 'success' )
		{
			// $.msgShow('#response_msg', data.message, 'success');
			$('#deletePopup').modal('hide');
			$.getListing(0);
		}
		else
		{
			$.msgShow('#response_msg', data.message, 'error');
		}
	});
}

$.listing = function(data) {
	var html = '';
	if(data.status == 'success')
	{
		if(data.data.data.length > 0)
		{
	        $.each( data.data.data, function( key, rec ) {

	        	if(rec.status == 'active')
	        	{
					var statusClass = 'btn-success';
	        	}
	        	else
	        	{
	        		var statusClass = 'btn-inverse';
	        	}


	        	if(rec.image == '')
	        	{
	        		var userImage = '<img style="float:left; margin-right:10px;" data-name="'+rec.name+'" class="profile"/> ';
	        	}
	        	else
	        	{
					var userImage = '<img src="'+rec.image+'" style="margin-right:10px; width:30px; height:30px;" /> ';
	        	}

	 			html += '<tr>\
	                            <td class="text-left">'+ (key + 1) +'</td>\
	                            <td class="text-left">\
									'+userImage + rec.name +'\
	                            </td>\
	                            <td class="text-left">'+ rec.description +'</td>\
	                            <td class="text-left"> <span class="label label-primary">'+rec.created_at_formatted+'</span> </td>\
	                            <td class="text-right">\
	                              <a href="javascript:void(0);"><button class="btn '+statusClass+' btn-xs">'+ucfirst(rec.status)+'</button></a>\
	                              <a href="javascript:void(0);" onclick="$.showEditPopup('+rec.id+');" class="btn btn-default btn-xs" data-target="#add_popup" data-modal-options="slide-down" data-content-options="modal-sm h-center" title="Edit"><i class="fa fa-pencil"></i></a>\
	                              <a href="javascript:void(0);" onclick="$.confirmDel('+rec.id+', this, \'deleteTestimonial\');" data-entityname="' + rec.name+'" class="btn btn-danger btn-xs" title="Delete"><i class="fa fa-times"></i></a>\
	                            </td>\
	                          </tr>';
	        });

	        $('#responsive-table-body').html(html);
			$('#pagination').twbsPagination({
			        totalPages: data.data.paginator.total_pages,
			        visiblePages: 7,
			        onPageClick: function (event, page) {
						$.getListing(page);
			        }
			});

			$('.profile').initial({width:30, height: 30, fontSize:10});         
		}
		else
		{
	        $('#responsive-table-body').html('<tr><th style="text-align:center;" colspan="5">No records found</th></tr>');
		}

	}
}

$.addUpdateTestimonial = function()
{
	var check = true;
	var method = 'POST';
	var endPoint = 'testimonial';
	var name = $.trim($('#name').val());
	var description = $.trim($('#description').val());
	var status = $('input[name=status]:checked').val();
	var imagePath = $.trim($('#file_path').val());
	var id = $.trim($('#id').val());

	check = validateText('#name', name, check);
	check = validateText('#description', description, check);

	if(id != '')
	{
		method = 'PUT';
		endPoint += '/' + id;
	}

	if(check)
	{
		requestData = {"id": id, 'name': name, 'description': description, 'status': status, "pic_path":imagePath};
		var request = ajaxExec(endPoint, requestData, method, '#response_msg');
		request.done(function(data) {
			if(data.status == 'success')
			{
			    setTimeout(function(){
					$('#add_popup').modal('hide');

				$.getListing(0);

					// // Rest Data
					// $.resetForm();

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