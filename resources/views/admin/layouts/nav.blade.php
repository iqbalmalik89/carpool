 <div class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header"><!-- href= -->
          <a href="#sidebar-menu" data-toggle="sidebar-menu" data-effect="st-effect-3" class="toggle pull-left visible-xs"><i class="fa fa-bars"></i></a>

          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a href="index.html" class="navbar-brand hidden-xs navbar-brand-primary">Carpool</a>
        </div>
        <div class="navbar-collapse collapse" id="collapse">
          <form class="navbar-form navbar-left hidden-xs" role="search">
            <div class="search-2">
              <div class="input-group">
                <input type="text" class="form-control form-control-w-150" placeholder="Search ..">
                <span class="input-group-btn">
            <button class="btn btn-primary" type="button"><i class="fa fa-search"></i></button>
        </span>
              </div>
            </div>
          </form>
          <ul class="nav navbar-nav navbar-right">
            <!-- notifications -->
<!--             <li class="dropdown notifications updates hidden-xs hidden-sm">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-bell-o"></i>
                <span class="badge badge-primary">4</span>
              </a>
              <ul class="dropdown-menu" role="notification">
                <li class="dropdown-header">Notifications</li>
                <li class="media">
                  <div class="pull-right">
                    <span class="label label-success">New</span>
                  </div>
                  <div class="media-left">
                    <img src="{{URL::asset('assets/admin_asset/images/people/50/guy-2.jpg')}}" alt="people" class="img-circle" width="30">
                  </div>
                  <div class="media-body">
                    <a href="#">Adrian D.</a> posted <a href="#">a photo</a> on his timeline.
                    <br/>
                    <span class="text-caption text-muted">5 mins ago</span>
                  </div>
                </li>
                <li class="media">
                  <div class="pull-right">
                    <span class="label label-success">New</span>
                  </div>
                  <div class="media-left">
                    <img src="{{URL::asset('assets/admin_asset/images/people/50/guy-6.jpg')}}" alt="people" class="img-circle" width="30">
                  </div>
                  <div class="media-body">
                    <a href="#">Bill</a> posted <a href="#">a comment</a> on Adrian's recent <a href="#">post</a>.
                    <br/>
                    <span class="text-caption text-muted">3 hrs ago</span>
                  </div>
                </li>
                <li class="media">
                  <div class="media-left">
                    <span class="icon-block s30 bg-grey-200"><i class="fa fa-plus"></i></span>
                  </div>
                  <div class="media-body">
                    <a href="#">Mary D.</a> and <a href="#">Michelle</a> are now friends.
                    <p>
                      <span class="text-caption text-muted">1 day ago</span>
                    </p>
                    <a href="">
                      <img class="width-30 img-circle" src="{{URL::asset('assets/admin_asset/images/people/50/woman-6.jpg')}}" alt="people">
                    </a>
                    <a href="">
                      <img class="width-30 img-circle" src="{{URL::asset('assets/admin_asset/images/people/50/woman-3.jpg')}}" alt="people">
                    </a>
                  </div>
                </li>
              </ul>
            </li> -->
            <!-- // END notifications -->
            <!-- messages -->
<!--             <li class="dropdown notifications hidden-xs hidden-sm">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-envelope-o"></i>

                <span class="badge floating badge-danger">12</span>

              </a>
              <ul class="dropdown-menu">
                <li class="media">
                  <div class="media-left">
                    <a href="#">
                      <img class="media-object thumb" src="{{URL::asset('assets/admin_asset/images/people/50/woman-3.jpg')}}" alt="people">
                    </a>
                  </div>
                  <div class="media-body">
                    <div class="pull-right">
                      <span class="label label-default">5 min</span>
                    </div>
                    <h5 class="media-heading">Adrian D.</h5>

                    <p class="margin-none">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                  </div>
                </li>
                <li class="media">
                  <div class="media-left">
                    <a href="#">
                      <img class="media-object thumb" src="{{URL::asset('assets/admin_asset/images/people/50/woman-3.jpg')}}" alt="people">
                    </a>
                  </div>

                  <div class="media-body">
                    <div class="pull-right">
                      <span class="label label-default">2 days</span>
                    </div>
                    <h5 class="media-heading">Jane B.</h5>
                    <p class="margin-none">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                  </div>
                </li>
                <li class="media">
                  <div class="media-left">
                    <a href="#">
                      <img class="media-object thumb" src="{{URL::asset('assets/admin_asset/images/people/50/woman-3.jpg')}}" alt="people">
                    </a>
                  </div>

                  <div class="media-body">
                    <div class="pull-right">
                      <span class="label label-default">3 days</span>
                    </div>
                    <h5 class="media-heading">Andrew M.</h5>
                    <p class="margin-none">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                  </div>
                </li>
              </ul>
            </li>
 -->            <!-- // END messages -->
            <!-- user -->
            <li class="dropdown user">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                @if (\Session::get('user')['pic_path'] != '')
                  <img src="{{Session::get('user')['profile_pic']}}" alt="" class="img-circle" />
                @else
                  <img src="" alt="" class="profile img-circle" data-name="{{\Session::get('user')['first_name']}}" />
                @endif

                {{\Session::get('user')['first_name'].' '.\Session::get('user')['last_name']}}<span class="caret"></span>

              </a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="{{URL::to('admin/profile')}}"><i class="fa fa-user"></i>Profile</a></li>
<!--                 <li><a href="#"><i class="fa fa-wrench"></i>Settings</a></li> -->
                <li><a href="{{URL::to('admin/logout')}}"><i class="fa fa-sign-out"></i>Logout</a></li>
              </ul>
            </li>
            <!-- // END user -->
            <!-- country flags -->

            <!-- // END country flags -->
          </ul>
        </div>
      </div>
    </div>