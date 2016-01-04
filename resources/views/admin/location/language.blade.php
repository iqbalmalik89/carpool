@extends('admin.layouts.master')

@section('title', 'Language')
@section('jsmodule', 'language.js')
@section('content')
	  <div class="modal fade" id="add_popup">
	    <div class="modal-dialog">
	      <div class="v-cell">
	        <div class="modal-content">
	          <div class="modal-header">
	            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	            <h4 class="modal-title" id="popupTitle">Add Language</h4>
	          </div>
	          <div class="modal-body">

              <div class="alert" id="response_msg" style="display:none;">
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                
              </div>

	              <div class="panel panel-default">
	                <div class="panel-body">
	                  <form class="form-horizontal" role="form" id="user_form">
                      <input type="hidden" id="id" name="id" value="">


	                    <div class="form-group">
	                      <label for="inputEmail3" class="col-sm-3 control-label">Language</label>
	                      <div class="col-sm-9">
	                        <input type="text" class="form-control" id="language" placeholder="Language">
	                      </div>
	                    </div>
	                    <div class="form-group">
	                      <label for="inputEmail3" class="col-sm-3 control-label">Language Code</label>
	                      <div class="col-sm-9">
	                        <input type="text" class="form-control" id="language_code" placeholder="Langauge Code">
	                      </div>
	                    </div>

	                  </form>
	                </div>
	              </div>


	          </div>
	          <div class="modal-footer">
	            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	            <button type="button" class="btn btn-primary" id="save_btn">Save</button>
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
                      <div style="float:left;"><h1>Language</h1></div>
                      <button id="addbutton" data-target="#add_popup" data-modal-options="slide-down" data-content-options="modal-sm h-center" style="float:right; margin-top:16px;" class="btn btn-inverse showmodal">Add Language</button>
					</div>
					
					<div style="clear:both;"></div>

                  <div class="panel panel-default">
                    <!-- Progress table -->
                    <div class="table-responsive">
                      <table class="table v-middle">
                        <thead>
                          <tr>
                            <th>Id</th>
                            <th>Language</th>
                            <th>Language Code</th>                            
                            <th>Created</th>
                            <th class="text-right">Action</th>
                          </tr>
                        </thead>
                        <tbody id="responsive-table-body">
                        
                        </tbody>
                      </table>
                    </div>
                    <!-- // Progress table -->

                    <div class="panel-footer padding-none text-center">
                      <ul class="pagination" id="pagination">

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