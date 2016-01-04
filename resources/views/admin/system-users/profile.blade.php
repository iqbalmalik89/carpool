@extends('admin.layouts.master')

@section('title', 'Page Title')
@section('jsmodule', 'users.js')
@section('content')

        <!-- extra div for emulating position:fixed of the menu -->
        <div class="st-content-inner">

          <div class="container-fluid">
    <!-- jumbotron -->
            <div class=" text-center bg-transparent margin-none">
            <div class="page-section">
              <div class="row">
                <div class="col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1">
                <h4 class="text-headline">Personal Information</h4>

                <div class="panel panel-default">
                    <div class="panel-body">
                    <div class="alert" id="response_msg" style="display:none;">
                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                      Invalid User or Password
                    </div>

                    <form class="form-horizontal" role="form" id="user_form">
                      <input type="hidden" id="file_path" name="file_path" value="">
                      <input type="hidden" id="id" name="id" value="">

                      <div id="progress" style="display:none;" class="progress">
                              <div class="progress-bar progress-bar-success"></div>
                      </div>

                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">First Name</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="user_first_name" placeholder="First name">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Last Name</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="user_last_name" placeholder="Last name">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Contact Number</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="user_mobile" placeholder="Contact Number">
                        </div>
                      </div>                      
                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Email</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="user_email" placeholder="email">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label"> Profile Picture </label>
                        <div class="col-sm-9">
                          <span class="btn btn-primary fileinput-button">
                                <i class="glyphicon glyphicon-plus"></i>
                                <span>Upload Profile Picture</span>
                                <!-- The file input field used as target for the file upload widget -->
                                <input id="user_image_upload" type="file" name="user_image_upload">
                          </span>

                          <span id="user_image"></span>

                        </div>
                      </div>

                      <div class="form-group margin-none">
                        <div class="col-sm-offset-3 col-sm-9">
                          <button onclick="$.addUpdateSystemUser();" type="button" class="btn btn-primary" style="float:right">Update</button>
                        </div>
                      </div>

                    </form>


                    </div>
                </div>

                <h4 class="text-headline">Update Password</h4>

                <div class="panel panel-default">
                    <div class="panel-body">

                    <div class="alert" id="password_msg" style="display:none;">
                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                      
                    </div>

                    <form class="form-horizontal" role="form" id="password_form">
                      <input type="hidden" id="file_path" name="file_path" value="">
                      <input type="hidden" id="id" name="id" value="">

                      <div id="progress" style="display:none;" class="progress">
                              <div class="progress-bar progress-bar-success"></div>
                      </div>



                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Old Password</label>
                        <div class="col-sm-9">
                          <input type="password" class="form-control" id="old_password" placeholder="Old password">
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">New Password</label>
                        <div class="col-sm-9">
                          <input type="password" class="form-control" id="new_password" placeholder="New Password">
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Confirm Password</label>
                        <div class="col-sm-9">
                          <input type="password" class="form-control" id="confirm_password" placeholder="Confirm Password">
                        </div>
                      </div>

                      <div class="form-group margin-none">
                        <div class="col-sm-offset-3 col-sm-9">
                          <button onclick="$.updatePassword();" type="button" class="btn btn-primary" style="float:right">Update</button>
                        </div>
                      </div>

                    </form>


                    </div>
                </div>
					

              </div>
            </div>
            </div>


          </div>

        </div>
    
    <script type="text/javascript">
    $(function () {
      $.showEditPopup('1');
    });
    </script>

        <!-- /st-content-inner -->
@endsection