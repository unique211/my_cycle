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

                <?php
                $setting=0;
                $report=0;
                ?>
                @if(is_null($sidebar))

                @else


                @foreach($sidebar as $val)






                @if($val->menuid==1)
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

                @endif
                @if($val->menuid==2)
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

                @endif
                @if($val->menuid==3)
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

                @endif
                @if($val->menuid==4)

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

                @endif
                @if($val->menuid==5)

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

                @endif
                @if($val->menuid==6)

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

                @endif
                @if($val->menuid==7)

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

                @endif
                @if($val->menuid==8)

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

                @endif
                @if($val->menuid==9)

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

                @endif
                @if($val->menuid==10)

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

                @endif
                @if($val->menuid==11)

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

                @endif
                @if($val->menuid==12)

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

                @endif
                @if($val->menuid==13)

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

                @endif
                @if($val->menuid==14)

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
                @endif
                @endforeach
                @endif

            </ul>

            {{--  <div class="alert alert-info">
                Welcome to Endless Admin. Do not forget to check all my pages.
            </div>  --}}
        </div>{{-- /main-menu --}}
    </div>{{-- /sidebar-inner --}}
</aside>
