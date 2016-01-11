var moduleName = 'subscriber';
var endPoint = 'subscriber';

$(function () {

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
	$('#distance_from, #distance_to, #radius, #id').val('');
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
			$('#distance_from').val(data.data.distance_from);
			$('#distance_to').val(data.data.distance_to);
			$('#radius').val(data.data.radius);
			$('#status' + data.data.status).prop('checked', true);

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


	 			html += '<tr>\
	                            <td class="text-left">'+ (key + 1) +'</td>\
	                            <td class="text-left">'+ rec.email +'</td>\
	                            <td class="text-left">'+ rec.ip +'</td>\
	                            <td class="text-left"> <span class="label label-primary">'+rec.created_at_formatted+'</span> </td>\
	                            <td class="text-right">\
	                              <a href="javascript:void(0);" onclick="$.confirmDel('+rec.id+', this, \'deleteEntity\');" data-entityname="' + rec.email+'" class="btn btn-danger btn-xs" title="Delete"><i class="fa fa-times"></i></a>\
	                            </td>\
	                          </tr>';
	        });
	                              // <a href="javascript:void(0);" onclick="$.showEditPopup('+rec.id+');" class="btn btn-default btn-xs" data-target="#add_popup" data-modal-options="slide-down" data-content-options="modal-sm h-center" title="Edit"><i class="fa fa-pencil"></i></a>\
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
	var distanceFrom = $.trim($('#distance_from').val());
	var distanceTo = $.trim($('#distance_to').val());
	var radius = $.trim($('#radius').val());	
	var status = $('input[name=status]:checked').val();
	var id = $.trim($('#id').val());

	check = validateText('#distance_from', distanceFrom, check);
	check = validateText('#distance_to', distanceTo, check);
	check = validateText('#radius', radius, check);

	if(id != '')
	{
		method = 'PUT';
		endPoint += '/' + id;
	}

	if(check)
	{
		requestData = {"id": id, 'distance_from': distanceFrom, 'distance_to': distanceTo, 'radius': radius, 'status': status};
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