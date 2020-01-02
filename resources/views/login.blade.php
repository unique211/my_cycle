@include('layout.headerlink')

<body>
    <div class="login-wrapper">
        <div class="text-center">
            <h2 class="fadeInUp animation-delay8" style="font-weight:bold">
                {{--  <span class="text-success">Endless</span> <span style="color:#ccc; text-shadow:0 1px #fff">Admin</span>  --}}
                {{--  <span class="text-success">Gym</span>  --}}
                <img src="<?php echo url('/'); ?>/resources/sass/img/web_hi_res_512.png" style="height:150px;width:400px" >
            </h2>
        </div>
        <div class="login-widget animation-delay1">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    <div class="text-center">
                        <i class="fa fa-lock fa-lg"></i> Login
                    </div>

                    {{--  <div class="pull-right">
                        <span style="font-size:11px;">Don&#39;t have any account?</span>
                        <a class="btn btn-default btn-xs login-link" href="register.html" style="margin-top:-2px;"><i
                                class="fa fa-plus-circle"></i> Sign up</a>
                    </div>  --}}
                </div>
                <div class="panel-body">
                    <form class="form-login" id="login_form" name="login_form">
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" placeholder="Username" name="user_id" id="user_id"
                                class="form-control input-sm bounceIn animation-delay2" required>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" placeholder="Password" name="password" id="password"
                                class="form-control input-sm bounceIn animation-delay4" required>
                        </div>
                        {{--  <div class="form-group">
                            <label class="label-checkbox inline">
                                <input type="checkbox" class="regular-checkbox chk-delete" />
                                <span class="custom-checkbox info bounceIn animation-delay4"></span>
                            </label>
                            Remember me
                        </div>  --}}

                        <div class="seperator"></div>
                        {{--  <div class="form-group">
                            Forgot your password?<br />
                            Click <a href="#">here</a> to reset your password
                        </div>  --}}

                        <hr />
                        <button type="submit"
                            class="btn btn-success btn-sm bounceIn animation-delay5  pull-right">
                            <i class="fa fa-sign-in"></i> Sign in</button>

                    </form>
                </div>
            </div><!-- /panel -->
        </div><!-- /login-widget -->
    </div><!-- /login-wrapper -->

    @include('layout.footerlink')

</body>
<script type="text/javascript">
    $(document).ready(function () {
    $.ajaxSetup({
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });

});
var login="{{ url('login_check') }}";
var redirect="{{ url('dashboard') }}";

</script>

<script type='text/javascript' src="{{ URL::asset('/resources/js/myjs/login.js',true) }}">
</script>

</html>
