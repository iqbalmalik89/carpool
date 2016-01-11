      <div class="sidebar left sidebar-size-2 sidebar-offset-0 sidebar-skin-blue sidebar-visible-desktop"  id=sidebar-menu data-type=collapse>
        <div class="split-vertical">
          <div class="sidebar-block tabbable tabs-icons">
            <ul class="nav nav-tabs">
<!--               <li class="active"><a href="#sidebar-tabs-menu" data-toggle="tab"><i class="fa fa-bars"></i></a></li>
               <li><a href="#sidebar-tabs-2" data-toggle="tab"><i class="fa fa-bar-chart-o"></i></a></li> -->
            </ul>
          </div>
          <div class="split-vertical-body">
            <div class="split-vertical-cell">
              <div class="tab-content">

                <div class="tab-pane active" id="sidebar-tabs-menu">
                  <div data-scrollable>
                  <?php $currentRoute = \Route::getCurrentRoute()->getPath(); ?>
                    <ul class="sidebar-menu sm-bordered sm-active-item-bg">
                      <li class="<?php if($currentRoute == 'admin/dashboard') echo 'active'; ?>"><a href="{{\URL::to('admin/dashboard')}}"><i class="fa fa-bar-chart"></i> <span>Dashboard</span></a></li>
                      <li class="<?php if($currentRoute == 'admin/system-users') echo 'active'; ?>"><a href="{{\URL::to('admin/system-users')}}"><i class="fa fa-male"></i> <span>System Users</span></a></li>
                      <li class="<?php if($currentRoute == 'admin/users') echo 'active'; ?>"><a href="{{\URL::to('admin/users')}}"><i class="fa fa-users"></i> <span>Users</span></a></li>
                      <li class="hasSubmenu">
                        <a href="#nav-master"><i class="fa fa-gears"></i> <span>Master</span></a>
                        <ul id="nav-master">
                          <li><a href="{{\URL::to('admin/country')}}"><i class="fa fa-globe"></i> <span>Country</span></a></li>
                          <li><a href="{{\URL::to('admin/language')}}"><i class="fa fa-language"></i> <span>Language</span></a></li>
                          <li><a href="{{\URL::to('admin/currency')}}"><i class="fa fa-usd"></i> <span>Currency</span></a></li>
                          <li><a href="{{\URL::to('admin/radius')}}"><i class="fa fa-usd"></i> <span>Radius</span></a></li>
                          <li><a href="{{\URL::to('admin/vehicle-brands')}}"><i class="fa fa-usd"></i> <span>Vehicle Brands</span></a></li>
                        </ul>
                      </li>


                      <li class="hasSubmenu">
                        <a href="#cms-nav"><i class="fa fa-file-text-o"></i> <span>CMS</span></a>
                        <ul id="cms-nav">
                          <li><a href="{{\URL::to('admin/cms')}}"><i class="fa fa-file-text"></i> <span>Pages</span></a></li>
                          <li><a href="{{\URL::to('admin/testimonial')}}"><i class="fa fa-thumbs-up"></i> <span>Testimonial</span></a></li>
                          <li><a href="{{\URL::to('admin/subscriber')}}"><i class="fa fa-thumbs-up"></i> <span>Subscribers</span></a></li>
                        </ul>
                      </li>


<!--                       <li><a href="email.html"><i class="fa fa-envelope"></i> <span>Email</span></a></li>
                      <li><a href="chat.html"><i class="fa fa-comments"></i> <span>Chat</span></a></li> -->
                    </ul>
<!-- 
                    <h4 class="category">Components</h4>
                    <ul class="sidebar-menu sm-bordered sm-active-item-bg">
                      <li class="hasSubmenu text-multiple open">
                        <a href="#components">
                          <i class="fa fa-circle-o"></i>
                          <span class="text">
                                            <span class="title">Essentials</span>
                          <span class="details">UI Kit</span>
                          </span>
                        </a>
                        <ul id="components" class="in">
                          <li><a href="essential-overview.html"><i class="fa fa-circle-o"></i> <span>Overview</span></a></li>
                          <li><a href="essential-buttons.html"><i class="fa fa-th"></i> <span>Buttons</span></a></li>
                          <li><a href="essential-icons.html"><i class="fa fa-paint-brush"></i> <span>Icons</span></a></li>
                          <li><a href="essential-typography.html"><i class="fa fa-font"></i> <span>Typography</span></a></li>
                          <li><a href="essential-expandable.html"><i class="fa fa-ellipsis-h"></i> <span>Expandable</span></a></li>
                          <li><a href="essential-ribbons.html"><i class="fa fa-circle-o"></i> <span>Ribbons</span></a></li>
                          <li><a href="essential-forms.html"><i class="fa fa-sliders"></i> <span>Forms</span></a></li>
                          <li><a href="essential-wizards.html"><i class="fa fa-magic"></i> <span>Wizards</span></a></li>
                          <li><a href="essential-tabs.html"><i class="md md-tab-unselected"></i> <span>Tabs</span></a></li>
                          <li><a href="essential-nestable.html"><i class="md md-menu"></i> <span>Nestable</span></a></li>
                          <li><a href="essential-tree.html"><i class="md md-loupe"></i> <span>Tree View</span></a></li>
                          <li><a href="essential-modals.html"><i class="fa fa-circle-o"></i> <span>Modals</span></a></li>
                          <li class="active"><a href="essential-tables.html"><i class="fa fa-table"></i> <span>Tables</span></a></li>
                          <li><a href="essential-progress.html"><i class="fa fa-tasks"></i> <span>Progress</span></a></li>
                          <li><a href="essential-grid.html"><i class="fa fa-columns"></i> <span>Grid</span></a></li>
                        </ul>
                      </li>
                      <li class="">
                        <a href="layout-fluid-1-sidebar.html"><i class="md md-tab-unselected"></i> <span>Layouts</span></a>
                      </li>
                      <li class="hasSubmenu">
                        <a href="#submenu-media"><i class="fa fa-photo"></i> <span>Media</span></a>
                        <ul id="submenu-media">
                          <li><a href="media-gallery.html"><i class="fa fa-camera"></i> <span>Gallery</span></a></li>
                          <li><a href="media-carousel.html"><i class="fa fa-circle-o"></i> <span>Carousels</span></a></li>
                        </ul>
                      </li>
                      <li class="hasSubmenu">
                        <a href="#nav-maps"><i class="fa fa-globe"></i> <span>Maps</span></a>
                        <ul id="nav-maps">
                          <li><a href="maps-google-themes.html"><i class="fa fa-eyedropper"></i> <span>Themes</span></a></li>
                          <li><a href="maps-google-filters.html"><i class="fa fa-map-marker"></i> <span>Filters</span></a></li>
                          <li><a href="maps-google-json.html"><i class="fa fa-map-marker"></i> <span>JSON</span></a></li>
                          <li><a href="maps-google-pagination.html"><i class="fa fa-map-marker"></i> <span>Pagination</span></a></li>
                          <li><a href="maps-google-edit.html"><i class="fa fa-pencil"></i> <span>Edit</span></a></li>
                          <li><a href="maps-google-markers.html"><i class="fa fa-map-marker"></i> <span>Markers</span></a></li>
                          <li><a href="maps-vector.html"><i class="fa fa-map-marker"></i> <span>Vector Maps</span></a></li>
                        </ul>
                      </li>
                      <li class="hasSubmenu">
                        <a href="#nav-charts"><i class="fa fa-bar-chart"></i> <span>Charts</span></a>
                        <ul id="nav-charts">
                          <li><a href="charts-morris.html"><i class="fa fa-bar-chart"></i> <span>Morris</span></a></li>
                          <li><a href="charts-flot.html"><i class="fa fa-bar-chart"></i> <span>Flot</span></a></li>
                        </ul>
                      </li>
                    </ul>

                    <h4 class="category">Other</h4>
                    <ul class="sidebar-menu sm-bordered sm-active-item-bg">
                      <li><a href="tickets.html"><i class="fa fa-ticket"></i> <span>Tickets</span></a></li>
                      <li><a href="appointments.html"><i class="fa fa-calendar"></i> <span>Appointments</span></a></li>
                    </ul>

                    <div class="sidebar-block equal-padding">
                      <ul class="list-group list-group-menu">
                        <li class="list-group-item"><a href="login.html"><i class="fa fa-fw fa-lock"></i> <span>Login</span></a></li>
                        <li class="list-group-item"><a href="sign-up.html"><i class="fa fa-fw fa-pencil"></i> <span>Sign Up</span></a></li>
                      </ul>
                    </div>

                    <h4 class="category">Versions</h4>
                    <div class="sidebar-block text-center">
                      <a class="btn btn-primary btn-block active" href="index.html">
                        <strong>HTML</strong>
                      </a>
                      <a class="btn btn-primary btn-block" href="../admin-angular/index.html">
                        <strong>AngularJS</strong>
                      </a>
                      <a class="btn btn-primary btn-block" href="../admin-rtl/index.html">
                        <strong>RTL</strong>
                      </a>
                    </div> -->

                  </div>
                </div>


<!--                 <div class="tab-pane" id="sidebar-tabs-2">
                  <div data-scrollable>

                    <div class="category">Activity</div>
                    <div class="sidebar-block">
                      <div class="sidebar-feed">
                        <ul>
                          <li class="media news-item">
                            <span class="news-item-success pull-right "><i class="fa fa-circle"></i></span>
                            <span class="pull-left media-object">
                                                <i class="fa fa-fw fa-bell"></i>
                                            </span>
                            <div class="media-body">
                              <a href="" class="text-white">Adrian</a> just logged in
                              <span class="time">2 min ago</span>
                            </div>
                          </li>
                          <li class="media news-item">
                            <span class="news-item-success pull-right "><i class="fa fa-circle"></i></span>
                            <span class="pull-left media-object">
                                                <i class="fa fa-fw fa-bell"></i>
                                            </span>
                            <div class="media-body">
                              <a href="" class="text-white">Adrian</a> just added <a href="" class="text-white">mosaicpro</a> as their office
                              <span class="time">2 min ago</span>
                            </div>
                          </li>
                          <li class="media news-item">
                            <span class="pull-left media-object">
                                                <i class="fa fa-fw fa-bell"></i>
                                            </span>
                            <div class="media-body">
                              <a href="" class="text-white">Adrian</a> just logged in
                              <span class="time">2 min ago</span>
                            </div>
                          </li>
                          <li class="media news-item">
                            <span class="pull-left media-object">
                                                <i class="fa fa-fw fa-bell"></i>
                                            </span>
                            <div class="media-body">
                              <a href="" class="text-white">Adrian</a> just logged in
                              <span class="time">2 min ago</span>
                            </div>
                          </li>
                          <li class="media news-item">
                            <span class="pull-left media-object">
                                                <i class="fa fa-fw fa-bell"></i>
                                            </span>
                            <div class="media-body">
                              <a href="" class="text-white">Adrian</a> just logged in
                              <span class="time">2 min ago</span>
                            </div>
                          </li>
                        </ul>
                      </div>
                    </div>


                    <div class="sidebar-block equal-padding">
                      <div class="btn-group btn-group-justified" data-toggle="buttons">
                        <label class="btn btn-default active">
                          <input type="radio" name="options" id="option1" autocomplete="off" checked> <i class="fa fa-envelope"></i>
                        </label>
                        <label class="btn btn-default">
                          <input type="radio" name="options" id="option2" autocomplete="off"> <i class="fa fa-lock"></i>
                        </label>
                        <label class="btn btn-default">
                          <input type="radio" name="options" id="option31" autocomplete="off"> <i class="fa fa-list"></i>
                        </label>
                        <label class="btn btn-default">
                          <input type="radio" name="options" id="option32" autocomplete="off"> <i class="fa fa-group"></i>
                        </label>
                      </div>
                    </div>


                    <div class="category">Calendar</div>
                    <div class="sidebar-block padding-none">
                      <div class="datepicker"></div>
                    </div>

                  </div>
                </div> -->

              </div>
              <!-- // END .tab-content -->

            </div>
            <!-- // END .split-vertical-cell -->

          </div>
          <!-- // END .split-vertical-body -->

<!--           <ul class="sidebar-menu sm-active-item-bg sm-icons-right sm-icons-block">
            <li><a href="../../../index.html"><i class="fa fa-eyedropper"></i> <span>Themes</span></a></li>
          </ul> -->

        </div>
      </div>