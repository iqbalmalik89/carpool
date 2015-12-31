<!DOCTYPE html>
<html class="login" lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>::Admin::</title>
  <link href="{{URL::asset('assets/admin_asset/css/vendor/all.css')}}" rel="stylesheet">
  <link href="{{URL::asset('assets/admin_asset/css/app/app.css')}}" rel="stylesheet">
  <link href="{{URL::asset('assets/shared_asset/css/spinners.css')}}" rel="stylesheet">
  <script src="{{URL::asset('assets/admin_asset/js/modules/config.js')}}"></script>
  <script src="{{URL::asset('assets/admin_asset/js/vendor/all.js')}}"></script>
  <script src="{{URL::asset('assets/admin_asset/js/app/app.js')}}"></script>
  <script src="{{URL::asset('assets/admin_asset/js/modules/utility.js')}}"></script>
  <script src="{{URL::asset('assets/admin_asset/js/modules/validator.js')}}"></script>
  <script src="{{URL::asset('assets/admin_asset/js/modules/auth.js')}}"></script>  

  <!-- If you don't need support for Internet Explorer <= 8 you can safely remove these -->
  <!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

</head>

<body>

  <div class="container-fluid">

    <div class="brand-logo">
      <img src="{{URL::asset('assets/shared_asset/images/logo.gif')}}" alt="guy" />
    </div>
    <div class="row">

      <h1>Account Access</h1>
      {{--*/ $resetDisplay = 'none' /*--}}      
      {{--*/ $loginDisplay = 'block' /*--}}      

      @if(  empty($code))
        {{--*/ $code = '' /*--}}
      @endif

      @if(  empty($user_id))
        {{--*/ $user_id = '' /*--}}
      @endif

      @if( ! empty($access) && $access === true)
          {{--*/ $resetDisplay = 'block' /*--}}
          {{--*/ $loginDisplay = 'none' /*--}}
      @elseif( isset($access) && $access === false)
          {{--*/ $resetDisplay = 'block' /*--}}
          {{--*/ $loginDisplay = 'none' /*--}}
      @endif

      <div class="col-sm-4 col-sm-offset-4">
        <div class="panel panel-default">
          <div class="panel-body">

              <div class="alert" id="response_msg" style="display:none;">
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                Invalid User or Password
              </div>

            <div id="login_container" style="display:{{{$loginDisplay}}}">
              <form role="form" id="login_form">
                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                    <input type="text" class="form-control" placeholder="Email" id="email" name="email">
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-shield"></i></span>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                  </div>
                </div>
                <div class="text-center">
                  <a href="javascript:void(0);" id="loginBtn" class="btn btn-success">Login  <i class="fa fa-fw fa-unlock-alt"></i></a>
<!--                   <div id="login_spinner" class="plus-loader" style="width:30px; float:right; height:30px; position:fixed; top:60%; display:none;">Loading…</div> -->
                </div>




              </form>
            </div>

            <div  id="forgot_container"  style="display:none;">
             <form role="form" action="index.html">
                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                    <input type="text" class="form-control" placeholder="Email" id="forgot_email" name="forgot_email">
                  </div>
                </div>

                <div class="text-center">
                  <a href="javascript:void(0);" id="forgotBtn" class="btn btn-success">Reset Password</a>
                </div>
              </form>            
            </div>

            <div  id="reset_container"  style="display:{{{$resetDisplay}}}">
             <form role="form" action="index.html">
                <input type="hidden" id="code" name="code" value="{{{ $code }}}">
                <input type="hidden" id="user_id" name="user_id" value="{{{ $user_id }}}">

                <?php
                  if(isset($access) && $access === true)
                  {
                ?>
                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                    <input type="password" class="form-control" placeholder="New Password" id="new_password" name="new_password">
                  </div>
                </div>

                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                    <input type="password" class="form-control" placeholder="Confirm New Password" id="confirm_new_password" name="confirm_new_password">
                  </div>
                </div>

                <div class="text-center">
                  <a href="javascript:void(0);" id="updatePasswordBtn" class="btn btn-success">Update Password</a>
                </div>
                <?php 
                 }
                 else
                 {
                    echo 'Password reset link expired.';
                 }
                ?>


              </form>            
            </div>


          </div>

<!-- forgot starts -->
<!-- Forgot end           -->
        </div>

        <a href="javascript:void(0);" id="showForgot" class="forgot-pass"  style="display:{{{$loginDisplay}}}">
            Forgot your Password?
            <i class="fa fa-question-circle"></i>
        </a>

        <a href="javascript:void(0);" id="hide_forgot_link" style="display:none;">
            Back
        </a>

      </div>
    </div>

  </div>

  <!-- Inline Script for colors and config objects; used by various external scripts; -->
  <script>
    var colors = {
      "danger-color": "#e74c3c",
      "success-color": "#81b53e",
      "warning-color": "#f0ad4e",
      "inverse-color": "#2c3e50",
      "info-color": "#2d7cb5",
      "default-color": "#6e7882",
      "default-light-color": "#cfd9db",
      "purple-color": "#9D8AC7",
      "mustard-color": "#d4d171",
      "lightred-color": "#e15258",
      "body-bg": "#f6f6f6"
    };
    var config = {
      theme: "admin",
      skins: {
        "default": {
          "primary-color": "#3498db"
        }
      }
    };
  </script>

</body>

</html>