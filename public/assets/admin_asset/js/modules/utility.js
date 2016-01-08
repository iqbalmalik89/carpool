$(document).ready( function () {
  $( "input" ).keypress(function() {
    var id = '#' + $(this).attr('id');
    if($(id).parent().hasClass('has-error'))
      $(id).parent().removeClass('has-error');
  });

  $( ".showmodal" ).click(function() {
    $($(this).attr('data-target')).modal('show');
  });





});

$.showLoading = function() 
{
  $('#master_overlay').show();
}

$.hideLoading = function() 
{
  $('#master_overlay').hide();
}

$.confirmDel = function(entityId, curObj, callback) 
{
  $('#deleted_entity_name').html($(curObj).data('entityname'));
  $('#deletePopup').modal('show');
  $('#confirm_delete_button').attr('onclick', '$.' + callback + '('+entityId+')');
}

$.redirect = function(url, seconds)
{
  setTimeout(function(){ 
    window.location = url;
  }, seconds);  
}

$.msgShow = function(id, msg, type)
{
  if($(id).css('display') == 'block')
    return false;

  $(id).removeClass('alert-danger');
  $(id).removeClass('alert-success')  
  if(type == 'success')
  {
      $(id).addClass('alert-success');
      $(id).html(msg).slideDown('fast').delay(2500).slideUp(1000);   
  }
  else
  { 
      $(id).addClass('alert-danger');
      $(id).html(msg).addClass('red').slideDown('fast').delay(2500).slideUp(1000,function(){$(id).removeClass('red')});
  }
}



function uploadFile(controlId, fileRoute, hiddenInput, responseDivId, errorDivId)
{
  $(controlId).fileupload({
      url: appConfig.apiUrl + fileRoute,
      dataType: 'json',
      singleFileUploads: true,
      start: function (e, data) {
//        $('#progress').show();
      },
      fail: function (e, data) {
        var errorObject = jQuery.parseJSON( data.jqXHR.responseText );
        var messages = '';
        $.each( errorObject.message, function( key, value ) {
          messages += value;
        });

        if(messages != '')
          $.msgShow(errorDivId, messages, 'error');

      },      
      done: function (e, data) {

        setTimeout(function(){
          $('#progress').hide();
        }, 1000);

        if(data.result.status == 'success')
        {
          $(hiddenInput).val(data.result.path);

          // populate response
          if(data.result.file_type == 'image')
          {
            $(responseDivId).html('<img src="'+data.result.web_url+'" width="50" class="img-circle" height="50">');
          }

        }
          // $.each(data.result.files, function (index, file) {
          //     $('<p/>').text(file.name).appendTo('#files');
          // });
      },
      progressall: function (e, data) {
          // var progress = parseInt(data.loaded / data.total * 100, 10);
          // $('#progress .progress-bar').css(
          //     'width',
          //     progress + '%'
          // );
      }
  }).prop('disabled', !$.support.fileInput)
      .parent().addClass($.support.fileInput ? undefined : 'disabled');  
}

function ajaxExec(endpoint, requestData, method, divId, callback)
{
    var request = $.ajax({
        url: appConfig.apiUrl + endpoint,
        data: requestData,
        type: method,
        crossDomain: true,
        dataType: 'json'
    });
    
    request.fail(function(jqXHR, textStatus) {
        var jsonResponse = $.parseJSON(jqXHR.responseText);


        if (divId != '')
        {
          if(jQuery.type(jsonResponse.message) == 'object')
          {
            var messages = '';
            $.each( jsonResponse.message, function( key, value ) {
              messages += value;
            });            
          }
          else
          {
            var messages = jsonResponse.error.message;
          }
          $.msgShow(divId, messages, 'error');
 
        }
    });
    // If callback is function, execute on ajax success
    if (typeof callback == 'function') {
        request.done(function(data) {
            callback(data);
        });
    }
    return request;

};

function ucfirst(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}