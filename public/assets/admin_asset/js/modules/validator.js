function validateText(id, value, check)
{
  if(value == '')
  {
    $(id).parent().addClass('has-error');
    if(check)
      $(id).focus();
    return false;
  }
  else
  {
    if(!check)
      return check;
    else
      return true;
  }
}

function compare(val1, var2, div1Id, div2Id, check, responseId, responseMsg)
{
  if(val1 == var2)
  {
    if(check)
      return check
  }
  else
  {
    $(div1Id + ', ' + div2Id).parent().addClass('has-error');
    $(div1Id).focus();
    $.msgShow(responseId, responseMsg, 'danger');
    return false;
  }
}

function validateEmail(id, divMsgId, email, check) 
{
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  if(regex.test(email))
  {
    if(check)
      return check;
    else
    {
      return false;
    }    
  }
  else
  {
    $(id).parent().addClass('has-error');
    if(check)
      $(id).focus();
    $.msgShow(divMsgId, 'Email format is not valid', 'danger');
    return false
  }
}

function validatePassword(id, divMsgId, password, check) 
{
  var regex = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;
  if(regex.test(password))
  {
    if(check)
      return check;
    else
    {
      return false;
    }    
  }
  else
  {
    $(id).parent().addClass('has-error');
    if(check)
      $(id).focus();
    $.msgShow(divMsgId, 'Password should be 8 characters long and should contain at least one digit one alphabet', 'danger');
    return false
  }
}