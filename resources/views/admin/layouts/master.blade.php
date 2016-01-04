<!DOCTYPE html>
<html class="st-layout ls-top-navbar ls-bottom-footer show-sidebar sidebar-l2" lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>:: Admin ::</title>
  <link href="{{URL::asset('assets/admin_asset/css/vendor/all.css')}}" rel="stylesheet">
  <link href="{{URL::asset('assets/admin_asset/css/app/app.css')}}" rel="stylesheet">
  <link href="{{URL::asset('assets/shared_asset/css/jquery.fileupload.css')}}" rel="stylesheet">
  <script src="{{URL::asset('assets/admin_asset/js/modules/config.js')}}"></script>
  <script src="{{URL::asset('assets/admin_asset/js/vendor/all.js')}}"></script>



  <!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

</head>

<body>

<div id="master_overlay"></div>

<div class="modal fade slide-down" id="deletePopup" aria-hidden="true">
  <div class="modal-dialog">
    <div class="v-cell">
      <div class="modal-content modal-sm h-center">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
          <h4 class="modal-title">Delete Confirmation</h4>
        </div>
        <div class="modal-body">
        Are you sure you want to delete <label class="text-danger" id="deleted_entity_name"></label>?
        </div>
        <div class="modal-footer">
          <button type="button" id="confirm_delete_button" class="btn btn-primary">Yes</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
        </div>
      </div>
    </div>
  </div>
</div>

  <!-- Wrapper required for sidebar transitions -->
  <div class="st-container">

    <!-- Fixed navbar -->
    @include('admin.layouts.nav')

    <!-- Sidebar component with st-effect-1 (set on the toggle button within the navbar) -->

    <!-- sidebar effects OUTSIDE of st-pusher: -->
    <!-- st-effect-1, st-effect-2, st-effect-4, st-effect-5, st-effect-9, st-effect-10, st-effect-11, st-effect-12, st-effect-13 -->

    <!-- content push wrapper -->
    <div class="st-pusher">

      <!-- Sidebar component with st-effect-3 (set on the toggle button within the navbar) -->
      @include('admin.layouts.left')

      <!-- sidebar effects INSIDE of st-pusher: -->
      <!-- st-effect-3, st-effect-6, st-effect-7, st-effect-8, st-effect-14 -->

      <!-- this is the wrapper for the content -->
      <div class="st-content" id="content">

			 @yield('content')

      </div>
      <!-- /st-content -->

    </div>
    <!-- /st-pusher -->

    <!-- Footer -->
    <footer class="footer">
      <strong>ThemeKit</strong> v4.0.0 &copy; Copyright 2015
    </footer>
    <!-- // Footer -->

  </div>
  <!-- /st-container -->

  <!-- Inline Script for colors and config objects; used by various external scripts; -->
  <script src="{{URL::asset('assets/admin_asset/js/app/app.js')}}"></script>
  <script src="{{URL::asset('assets/shared_asset/js/jquery.iframe-transport.js')}}"></script>
  <script src="{{URL::asset('assets/shared_asset/js/jquery.fileupload.js')}}"></script>

  <script src="{{URL::asset('assets/admin_asset/js/modules/utility.js')}}"></script>
  <script src="{{URL::asset('assets/admin_asset/js/modules/validator.js')}}"></script>
  <script src="{{URL::asset('assets/admin_asset/js/modules/')}}/@yield('jsmodule')"></script>  

</body>

</html>