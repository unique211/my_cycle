{{-- <div id="overlay" class="transparent"></div> --}}

{{--  <a href="" id="theme-setting-icon"><i class="fa fa-cog fa-lg"></i></a>  --}}
<div id="theme-setting">
    <div class="title">
        <strong class="no-margin">Skin Color</strong>
    </div>
    <div class="theme-box">
        <a class="theme-color" style="background:#323447" id="default"></a>
        <a class="theme-color" style="background:#efefef" id="skin-1"></a>
        <a class="theme-color" style="background:#a93922" id="skin-2"></a>
        <a class="theme-color" style="background:#3e6b96" id="skin-3"></a>
        <a class="theme-color" style="background:#635247" id="skin-4"></a>
        <a class="theme-color" style="background:#3a3a3a" id="skin-5"></a>
        <a class="theme-color" style="background:#495B6C" id="skin-6"></a>
    </div>
    <div class="title">
        <strong class="no-margin">Sidebar Menu</strong>
    </div>
    <div class="theme-box">
        <label class="label-checkbox">
            <input type="checkbox" checked id="fixedSidebar">
            <span class="custom-checkbox"></span>
            Fixed Sidebar
        </label>
    </div>
</div><!-- /theme-setting -->

<div id="top-nav" class="fixed skin-6">
    <a href="#" class="brand">
        {{--  <span>Gym</span>  --}}
        <img src="<?php echo url('/'); ?>/resources/sass/img/MyCycle.png" style="height:35px;width:120px" >
        {{--  <span class="text-toggle">Classes</span>  --}}
    </a><!-- /brand -->
    <button type="button" class="navbar-toggle pull-left" id="sidebarToggle">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
    <button type="button" class="navbar-toggle pull-left hide-menu" id="menuToggle">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
    <ul class="nav-notification clearfix">

        <li class="profile dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <strong><?php echo Session::get('user_name');?></strong>
                <span><i class="fa fa-chevron-down"></i></span>
            </a>
            <ul class="dropdown-menu">
                <li>
                    <a class="clearfix" href="#">


                            {{--  <strong>John Doe</strong>
                            <p class="grey">John_Doe@email.com</p>  --}}
                            <h4 class="text-center"><?php echo Session::get('user_name');?></h4>
                            <hr>
                            <p class="grey">User Id : <?php echo Session::get('userid');?></p>
                            <p class="grey">Role : <?php echo Session::get('role');?></p>
                            <hr>
                    </a>
                </li>

                <li>
                    <a tabindex="-1" class="main-link logoutConfirm_open text-center" href="#logoutConfirm"><i
                            class="fa fa-lock fa-lg"></i> Log out</a></li>
            </ul>
        </li>
    </ul>
</div><!-- /top-nav-->
