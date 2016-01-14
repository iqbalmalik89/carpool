var moduleName = 'Vehicle Types';
var endPoint = 'vehicle_type';

$(function () {

    uploadFile('#vehicle_type_image_upload', 'vehicle_type/image', '#file_path', '#vehicle_type_image', '#response_msg')


	$( "#save_btn" ).click(function() {
		$.addUpdateEntity();
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
			$.addUpdateEntity();
	  	}
	  }
	});

});

$.resetForm = function()
{
	var id = $.trim($('#id').val());
	if(id != '' && id != '0')
		$('#popupTitle').html('Update ' + ucfirst(moduleName) );
	else
		$('#popupTitle').html('Add ' + ucfirst(moduleName));		

	//reset fields
	$('#vehicle_type, #id, #file_path, #cat_id').val('');
	$('#statusactive').prop('checked', true);
	$('div').removeClass('has-error');
}

$.getListing = function(page)
{
	var requestData = {"page":page, limit:12};
	var request = ajaxExec(endPoint, requestData, 'get', '#response_msg', $.listing);
}

$.showEditPopup = function(id)
{
	$.resetForm();
	$('#popupTitle').html('Update ');
	$('#id').val(id);
    $('#add_popup').modal('show');
    $.getRec();
}

$.getRec = function() {
	var id = $('#id').val();
	var requestData = {"id": id};
	var request = ajaxExec(endPoint+ '/' + id, requestData, 'GET', '#response_msg');	

	request.done(function(data) {
		if(data.status == 'success')
		{
			$('#vehicle_type').val(data.data.vehicle_type);
			$('#cat_id').val( data.data.category_id).trigger("change");
			$('#status' + data.data.status).prop('checked', true);
			$('#file_path').val(data.data.pic_path);			
			if(data.data.pic_path != '')
			{
				var image = '<img src="'+data.data.image+'" style="margin-right:10px;" width="40" class="img-circle" /> ';
			}
        	else
	        {
        		var image = '<img style="float:left; margin-right:10px;" data-name="'+data.data.vehicle_type+'" class="profile"/> ';
			}

			$('#vehicle_type_image').html(image);
			$('.profile').initial({width:30, height: 30, fontSize:10});         



		}
	});
}

$.deleteEntity = function(id) 
{
	var requestData  = {};
    var request = ajaxExec(endPoint +'/' + id, requestData, 'delete', '#response_msg');
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

	        	if(rec.image == '')
	        	{
	        		var image = '<img style="float:left; margin-right:10px;" data-name="'+rec.vehicle_type+'" class="profile"/> ';
	        	}
	        	else
	        	{
					var image = '<img src="'+rec.image+'" style="margin-right:10px; width:30px; height:30px;" /> ';
	        	}

	 			html += '<tr>\
	                            <td class="text-left">'+ (key + 1) +'</td>\
	                            <td class="text-left">' + image + rec.vehicle_type + '</td>\
	                            <td class="text-left">'+ rec.category +'</td>\
	                            <td class="text-left"> <span class="label label-primary">'+rec.created_at_formatted+'</span> </td>\
	                            <td class="text-right">\
	                              <a href="javascript:void(0);" onclick="$.showEditPopup('+rec.id+');" class="btn btn-default btn-xs" data-target="#add_popup" data-modal-options="slide-down" data-content-options="modal-sm h-center" title="Edit"><i class="fa fa-pencil"></i></a>\
	                              <a href="javascript:void(0);" onclick="$.confirmDel('+rec.id+', this, \'deleteEntity\');" data-entityname="' + rec.category+'" class="btn btn-danger btn-xs" title="Delete"><i class="fa fa-times"></i></a>\
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

$.addUpdateEntity = function()
{
	var check = true;
	var method = 'POST';
	var vehicleType = $.trim($('#vehicle_type').val());	
	var catId = $.trim($('#cat_id').val());		
	var status = $('input[name=status]:checked').val();
	var vehicleTypeImage = $.trim($('#file_path').val());

	var id = $.trim($('#id').val());

	check = validateText('#vehicle_type', vehicleType, check);
	check = validateText('#cat_id', catId, check);
	// check = validateText('#file_path', vehicleTypeImage, check);

	var newEndPoint = endPoint;
	if(id != '')
	{
		method = 'PUT';
		newEndPoint = endPoint + '/' + id;
	}

	if(check)
	{
		requestData = {"id": id, 'vehicle_type': vehicleType, 'category_id':catId, 'pic_path':vehicleTypeImage, 'status': status};
		var request = ajaxExec(newEndPoint, requestData, method, '#response_msg');
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