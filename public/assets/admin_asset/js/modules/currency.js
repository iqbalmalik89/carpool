$(function () {

	$( "#save_btn" ).click(function() {
		$.addUpdateCurrency();
	});

	$( "#addbutton" ).click(function() {
		$('#id').val('');
		$.resetForm();
	});


	// List Records
	$.getListing(0);

	$('body').keypress(function (e) {
	 var key = e.which;
	 if(key == 13)  // the enter key code
	  {
	  	if($('#add_popup').is(':visible'))
	  	{
			$.addUpdateCurrency();
	  	}
	  }
	});

});

$.resetForm = function()
{
	var id = $.trim($('#id').val());
	if(id != '' && id != '0')
		$('#popupTitle').html('Update Currency');
	else
		$('#popupTitle').html('Add Currency');		

	//reset fields
	$('#currency, #symbol, #id').val('');
	$('div').removeClass('has-error');
}

$.getListing = function(page)
{
	var requestData = {"page":page, limit:12};
	var request = ajaxExec('currency', requestData, 'get', '#response_msg', $.listing);
}

$.showEditPopup = function(id)
{
	$.resetForm();
	$('#popupTitle').html('Update currency');
	$('#id').val(id);
    $('#add_popup').modal('show');
    $.getRec();
}

$.getRec = function() {
	var id = $('#id').val();
	var requestData = {"id": id};
	var request = ajaxExec('currency/' + id, requestData, 'GET', '#response_msg');	

	request.done(function(data) {
		if(data.status == 'success')
		{
			$('#currency').val(data.data.currency);
			$('#symbol').val(data.data.symbol);
		}
	});
}

$.deleteCurrency = function(id) 
{
	var requestData  = {};
    var request = ajaxExec('currency/' + id, requestData, 'delete', '#response_msg');
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
	                            <td class="text-left">'+ rec.currency +'</td>\
	                            <td class="text-left">'+ rec.symbol +'</td>\
	                            <td class="text-left"> <span class="label label-primary">'+rec.created_at_formatted+'</span> </td>\
	                            <td class="text-right">\
	                              <a href="javascript:void(0);" onclick="$.showEditPopup('+rec.id+');" class="btn btn-default btn-xs" data-target="#add_popup" data-modal-options="slide-down" data-content-options="modal-sm h-center" title="Edit"><i class="fa fa-pencil"></i></a>\
	                              <a href="javascript:void(0);" onclick="$.confirmDel('+rec.id+', this, \'deleteCurrency\');" data-entityname="' + rec.currency+'" class="btn btn-danger btn-xs" title="Delete"><i class="fa fa-times"></i></a>\
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

$.addUpdateCurrency = function()
{
	var check = true;
	var method = 'POST';
	var endPoint = 'currency';
	var currency = $.trim($('#currency').val());
	var symbol = $.trim($('#symbol').val());
	var id = $.trim($('#id').val());

	check = validateText('#currency', currency, check);
	check = validateText('#symbol', symbol, check);

	if(id != '')
	{
		method = 'PUT';
		endPoint += '/' + id;
	}

	if(check)
	{
		requestData = {"id": id, 'currency': currency, 'symbol': symbol};
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