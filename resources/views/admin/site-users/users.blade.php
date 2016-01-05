@extends('admin.layouts.master')

@section('title', 'Users')
@section('jsmodule', 'users.js')
@section('content')
	  <div class="modal fade" id="user_popup">
	    <div class="modal-dialog">
	      <div class="v-cell">
	        <div class="modal-content">
	          <div class="modal-header">
	            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	            <h4 class="modal-title" id="popupTitle">Add User</h4>
	          </div>
	          <div class="modal-body">

              <div class="alert" id="response_msg" style="display:none;">
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                Invalid User or Password
              </div>

	              <div class="panel panel-default">
	                <div class="panel-body">
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
                        <label for="inputEmail3" class="col-sm-3 control-label">Password</label>
                        <div class="col-sm-9">
                          <input type="password" class="form-control" id="user_password" placeholder="Password">
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Status</label>
                        <div class="col-sm-9">
                            <div class="radio radio-info radio-inline">
                              <input type="radio" id="statusactive" value="active" name="user_status" checked="">
                              <label for="statusactive">Active</label>
                            </div>
                            <div class="radio radio-inline">
                              <input type="radio" id="statusinactive" value="inactive" name="user_status">
                              <label for="statusinactive">Inactive</label>
                            </div>
                        </div>
                      </div>


	                    <div class="form-group">
	                      <label for="inputEmail3" class="col-sm-3 control-label"> </label>
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
	                  </form>
	                </div>
	              </div>


	          </div>
	          <div class="modal-footer">
	            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	            <button type="button" class="btn btn-primary" id="save_user_btn">Save</button>
	          </div>
	        </div>
	      </div>
	    </div>
	  </div>


        <!-- extra div for emulating position:fixed of the menu -->
        <div class="st-content-inner">

          <div class="container-fluid">
<!-- jumbotron -->
            <div class=" text-center bg-transparent margin-none">
            <div class="page-section">
              <div class="row">
                <div class="col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1">

					<div>
                      <div style="float:left;"><h1>Users</h1></div>
                      <button id="addbutton" data-target="#user_popup" data-modal-options="slide-down" data-content-options="modal-sm h-center" style="float:right; margin-top:16px;" class="btn btn-inverse showmodal">Add User</button>
					</div>
					
					<div style="clear:both;"></div>

                  <div class="panel panel-default">
                    <!-- Progress table -->
                    <div class="table-responsive">
                      <table class="table v-middle">
                        <thead>
                          <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Created at</th>
                            <th class="text-right">Action</th>
                          </tr>
                        </thead>
                        <tbody id="responsive-table-body">
                        
                        </tbody>
                      </table>
                    </div>
                    <!-- // Progress table -->

                    <div class="panel-footer padding-none text-center">
                      <ul class="pagination" id="user_pagination">

                      </ul>
                    </div>
                  </div>


                </div>
              </div>
            </div>
            </div>


          </div>

        </div>

        <!-- /st-content-inner -->
@endsection