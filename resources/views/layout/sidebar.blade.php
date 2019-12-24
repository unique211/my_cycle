<aside class="fixed skin-6">
    <div class="sidebar-inner scrollable-sidebar">
        <div class="size-toggle">
            <a class="btn btn-sm" id="sizeToggle">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <a class="btn btn-sm pull-right logoutConfirm_open" href="#logoutConfirm">
                <i class="fa fa-power-off"></i>
            </a>
        </div>
        {{-- /size-toggle --}}
        {{--  <div class="user-block clearfix">
            <img src="img/user.jpg" alt="User Avatar">
            <div class="detail">
                <strong>John Doe</strong><span class="badge badge-danger m-left-xs bounceIn animation-delay4">4</span>
                <ul class="list-inline">
                    <li><a href="profile.html">Profile</a></li>
                    <li><a href="inbox.html" class="no-margin">Inbox</a></li>
                </ul>
            </div>
        </div>--}}
        {{-- /user-block --}}
        <div class="search-block">
            <div class="input-group">
                <input type="text" class="form-control input-sm" placeholder="search here...">
                <span class="input-group-btn">
                    <button class="btn btn-default btn-sm" type="button"><i class="fa fa-search"></i></button>
                </span>
            </div>{{-- /input-group --}}
        </div>{{-- /search-block --}}
        <div class="main-menu">
            <ul>
                <li class="active">
                    <a href="{{ url('dashboard') }}">
                        <span class="menu-icon">
                            <i class="fa fa-desktop fa-lg"></i>
                        </span>
                        <span class="text">
                            @lang('site_lables.Dashboard')
                        </span>
                        <span class="menu-hover"></span>
                    </a>
                </li>


                <li>
                    <a href="{{ url('user_access') }}">
                        <span class="menu-icon">
                            <i class="fa fa-plus fa-lg"></i>
                        </span>
                        <span class="text">
                              @lang('site_lables.User_Access')
                        </span>
                        <span class="menu-hover"></span>
                    </a>
                </li>

                <li>
                    <a href="{{ url('instructor') }}">
                        <span class="menu-icon">
                            <i class="fa fa-plus fa-lg"></i>
                        </span>
                        <span class="text">
                             @lang('site_lables.Instructor')
                        </span>
                        <span class="menu-hover"></span>
                    </a>
                </li>

                <li>
                    <a href="{{ url('member') }}">
                        <span class="menu-icon">
                            <i class="fa fa-plus fa-lg"></i>
                        </span>
                        <span class="text">
                            @lang('site_lables.Member')
                        </span>
                        <span class="menu-hover"></span>
                    </a>
                </li>

                <li>
                    <a href="{{ url('package') }}">
                        <span class="menu-icon">
                            <i class="fa fa-plus fa-lg"></i>
                        </span>
                        <span class="text">
                             @lang('site_lables.Package')
                        </span>
                        <span class="menu-hover"></span>
                    </a>
                </li>

                <li>
                    <a href="{{ url('class_category') }}">
                        <span class="menu-icon">
                            <i class="fa fa-plus fa-lg"></i>
                        </span>
                        <span class="text">
                             @lang('site_lables.Class_Category')
                        </span>
                        <span class="menu-hover"></span>
                    </a>
                </li>

                <li>
                    <a href="{{ url('room') }}">
                        <span class="menu-icon">
                            <i class="fa fa-plus fa-lg"></i>
                        </span>
                        <span class="text">
                             @lang('site_lables.Room')
                        </span>
                        <span class="menu-hover"></span>
                    </a>
                </li>

                <li>
                    <a href="{{ url('class') }}">
                        <span class="menu-icon">
                            <i class="fa fa-plus fa-lg"></i>
                        </span>
                        <span class="text">
                             @lang('site_lables.Class')
                        </span>
                        <span class="menu-hover"></span>
                    </a>
                </li>

                <li>
                    <a href="{{ url('class_schedule') }}">
                        <span class="menu-icon">
                            <i class="fa fa-plus fa-lg"></i>
                        </span>
                        <span class="text">
                             @lang('site_lables.Class_Schedule')
                        </span>
                        <span class="menu-hover"></span>
                    </a>
                </li>



                <li>
                    <a href="{{ url('deals') }}">
                        <span class="menu-icon">
                            <i class="fa fa-plus fa-lg"></i>
                        </span>
                        <span class="text">
                             @lang('site_lables.Deals')
                        </span>
                        <span class="menu-hover"></span>
                    </a>
                </li>



                <li>
                    <a href="{{ url('gallery') }}">
                        <span class="menu-icon">
                            <i class="fa fa-plus fa-lg"></i>
                        </span>
                        <span class="text">
                            @lang('site_lables.Gallery')
                        </span>
                        <span class="menu-hover"></span>
                    </a>
                </li>

                <li>
                    <a href="{{ url('member_attendence_taking') }}">
                        <span class="menu-icon">
                            <i class="fa fa-plus fa-lg"></i>
                        </span>
                        <span class="text">
                             @lang('site_lables.Member_Attendence_Tacking')
                        </span>
                        <span class="menu-hover"></span>
                    </a>
                </li>



                <li class="openable">
                    <a href="#">
                        <span class="menu-icon">
                            <i class="fa fa-cog"></i>
                        </span>
                        <span class="text">
                             @lang('site_lables.Setting')
                        </span>
                        <span class="menu-hover"></span>

                    </a>
                    <ul class="submenu">
                        <li><a href="{{ url('language') }}"><span class="submenu-label"> <i class="fa fa-plus fa-lg"></i>  @lang('site_lables.Language')</span></a></li>
                        <li><a href="{{ url('member_type') }}"><span class="submenu-label"> <i class="fa fa-plus fa-lg"></i> @lang('site_lables.Member_Type')</span></a></li>
                        <li><a href="{{ url('site_setting') }}"><span class="submenu-label"> <i class="fa fa-plus fa-lg"></i> @lang('site_lables.Site_Setting')</span></a></li>
                        <li><a href="{{ url('mobile_notification') }}"><span class="submenu-label"> <i class="fa fa-plus fa-lg"></i> @lang('site_lables.Mobile_Notification')</span></a></li>

                        <li><a href="{{ url('profile_manager') }}"><span class="submenu-label"><i class="fa fa-plus fa-lg"></i> @lang('site_lables.Profile_Manager')</span></a></li>
                    </ul>
                </li>


                 <li class="openable">
                    <a href="#">
                        <span class="menu-icon">
                            <i class="fa fa-file fa-lg"></i>
                        </span>
                        <span class="text">
                            @lang('site_lables.Reports')
                        </span>
                        <span class="menu-hover"></span>

                    </a>
                    <ul class="submenu">
                        {{-- <li><a href="{{ url('class_booking') }}"><span class="submenu-label"><i class="fa fa-plus fa-lg"></i> @lang('site_lables.Class_Booking')</span></a>
                        </li> --}}
                        <li><a href="{{ url('attendence_rating') }}"><span class="submenu-label"><i class="fa fa-plus fa-lg"></i>  @lang('site_lables.Attendence_&_Rating')</span></a></li>

                    </ul>
                </li>
                {{-- <li>
                    <a href="{{ url('usermanage') }}">
                <span class="menu-icon">
                    <i class="fa fa-plus fa-lg"></i>
                </span>
                <span class="text">
                    User Management
                </span>
                <span class="menu-hover"></span>
                </a>
                </li> --}}
                {{--  <li class="openable">
                    <a href="#">
                        <span class="menu-icon">
                            <i class="fa fa-tag fa-lg"></i>
                        </span>
                        <span class="text">
                            Component
                        </span>
                        <span class="badge badge-success bounceIn animation-delay5">9</span>
                        <span class="menu-hover"></span>
                    </a>
                    <ul class="submenu">
                        <li><a href="ui_element.html"><span class="submenu-label">UI Features</span></a></li>
                        <li><a href="button.html"><span class="submenu-label">Button & Icons</span></a></li>
                        <li><a href="tab.html"><span class="submenu-label">Tab</span></a></li>
                        <li><a href="nestable_list.html"><span class="submenu-label">Nestable List</span></a></li>
                        <li><a href="calendar.html"><span class="submenu-label">Calendar</span></a></li>
                        <li><a href="table.html"><span class="submenu-label">Table</span></a></li>
                        <li><a href="widget.html"><span class="submenu-label">Widget</span></a></li>
                        <li><a href="form_element.html"><span class="submenu-label">Form Element</span></a></li>
                        <li><a href="form_wizard.html"><span class="submenu-label">Form Wizard</span></a></li>
                    </ul>
                </li>


                <li>
                    <a href="gallery.html">
                        <span class="menu-icon">
                            <i class="fa fa-picture-o fa-lg"></i>
                        </span>
                        <span class="text">
                            Gallery
                        </span>
                        <span class="menu-hover"></span>
                    </a>
                </li>
                <li>
                    <a href="inbox.html">
                        <span class="menu-icon">
                            <i class="fa fa-envelope fa-lg"></i>
                        </span>
                        <span class="text">
                            Inbox
                        </span>
                        <span class="badge badge-danger bounceIn animation-delay6">4</span>
                        <span class="menu-hover"></span>
                    </a>
                </li>
                <li>
                    <a href="email_selection.html">
                        <span class="menu-icon">
                            <i class="fa fa-tasks fa-lg"></i>
                        </span>
                        <span class="text">
                            Email Template
                        </span>
                        <small class="badge badge-warning bounceIn animation-delay7">New</small>
                        <span class="menu-hover"></span>
                    </a>
                </li>
                <li class="openable">
                    <a href="#">
                        <span class="menu-icon">
                            <i class="fa fa-magic fa-lg"></i>
                        </span>
                        <span class="text">
                            Multi-Level menu
                        </span>
                        <span class="menu-hover"></span>
                    </a>
                    <ul class="submenu">
                        <li class="openable">
                            <a href="#">
                                <span class="submenu-label">menu 2.1</span>
                                <span class="badge badge-danger bounceIn animation-delay1 pull-right">3</span>
                            </a>
                            <ul class="submenu third-level">
                                <li><a href="#"><span class="submenu-label">menu 3.1</span></a></li>
                                <li><a href="#"><span class="submenu-label">menu 3.2</span></a></li>
                                <li class="openable">
                                    <a href="#">
                                        <span class="submenu-label">menu 3.3</span>
                                        <span class="badge badge-danger bounceIn animation-delay1 pull-right">2</span>
                                    </a>
                                    <ul class="submenu fourth-level">
                                        <li><a href="#"><span class="submenu-label">menu 4.1</span></a></li>
                                        <li><a href="#"><span class="submenu-label">menu 4.2</span></a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="openable">
                            <a href="#">
                                <span class="submenu-label">menu 2.2</span>
                                <span class="badge badge-success bounceIn animation-delay2 pull-right">3</span>
                            </a>
                            <ul class="submenu third-level">
                                <li class="openable">
                                    <a href="#">
                                        <span class="submenu-label">menu 3.1</span>
                                        <span class="badge badge-success bounceIn animation-delay1 pull-right">2</span>
                                    </a>
                                    <ul class="submenu fourth-level">
                                        <li><a href="#"><span class="submenu-label">menu 4.1</span></a></li>
                                        <li><a href="#"><span class="submenu-label">menu 4.2</span></a></li>
                                    </ul>
                                </li>
                                <li><a href="#"><span class="submenu-label">menu 3.2</span></a></li>
                                <li><a href="#"><span class="submenu-label">menu 3.3</span></a></li>
                            </ul>
                        </li>
                    </ul>
                </li>  --}}
            </ul>

            {{--  <div class="alert alert-info">
                Welcome to Endless Admin. Do not forget to check all my pages.
            </div>  --}}
        </div>{{-- /main-menu --}}
    </div>{{-- /sidebar-inner --}}
</aside>
