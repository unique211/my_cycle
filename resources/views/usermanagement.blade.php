@include('layout.headerlink')


<body class="overflow-hidden">
    <!-- Overlay Div -->
    @include('layout.header')



    <div id="wrapper" class="preload">

        @include('layout.sidebar')
        <div id="main-container">
            <div id="breadcrumb">
                <ul class="breadcrumb">
                    <li><i class="fa fa-home"></i><a href="#"> @lang('site_lables.Home')/User Management</a></li>
                    <li class="active"></li>
                </ul>
            </div><!-- /breadcrumb-->

            <div class="padding-md">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <b></b>
                                <button type="button" class="btn btn-primary btn-xs pull-right btnhideshow"><i
                                        class="fa fa-plus"></i> @lang('site_lables.Add_New')</button>
                            </div>
                            <div class="panel-body ">
                                <div class="row formhideshow" id="documents">

                                    <form id="master_form" name="master_form">
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>User Name</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <input type="text" class="form-control input-sm placeholdesize"
                                                    id="user_name" name="user_name" style="font-size:1rem;" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>Email ID</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <input type="email" class="form-control input-sm placeholdesize"
                                                    id="email" name="email">
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>Phone Number</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <input type="text" class="form-control input-sm placeholdesize"
                                                    id="phone" name="phone" maxlength="10">
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>Mobile Number</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <input type="text" class="form-control input-sm placeholdesize"
                                                    id="mobile" name="mobile" maxlength="10">
                                            </div>
                                        </div>

                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>Role</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <select class="form-control input-sm select2 placeholdesize roleselect"
                                                    id="user_type" name="user_type" required>
                                                    <option selected disabled>Select</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>Date of Joining</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <div class="input-group date doj" data-provide="datepicker">
                                                    <input type="text"
                                                        class="form-control input-sm placeholdesize datepicker" id="doj"
                                                        name="doj">
                                                    <div class="input-group-addon">
                                                        <span class="fa fa-calender"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div style="margin-top:0px;border-bottom:1px solid;width:100%;">
                                                <label class=""><b>Login Details</b></label>
                                            </div>
                                            <br>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>User Id</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <input type="text" class="form-control input-sm placeholdesize"
                                                    id="user_id" name="user_id" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>Password</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <input type="password" class="form-control input-sm placeholdesize"
                                                    id="password" name="password" required maxlength="36">
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>Confirm Password</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <input type="password" class="form-control input-sm placeholdesize"
                                                    id="cpassword" name="cpassword" required maxlength="36">
                                                <label class="text-danger" id="cpass_error"></label>
                                            </div>
                                        </div>



                                        <div class="col-lg-12">
                                            <input type="hidden" id="save_update" value="">
                                            &nbsp; &nbsp; <button type="button"
                                                class="btn btn-sm btn-danger pull-left delete_data">Delete</button>
                                            &nbsp; &nbsp; <button type="submit"
                                                class="btn btn-sm btn-success btn-sm pull-right">Save</button>
                                            &nbsp; &nbsp; <button type="button"
                                                class="btn btn-sm btn-info pull-right closehideshow">Close</button>
                                        </div>

                                    </form>
                                </div>

                                <div class="col-lg-12 tablehideshow">
                                    <div class="table-responsive" id="show_master">

                                    </div>
                                </div>







                            </div><!-- /panel -->
                        </div><!-- /panel -->

                    </div><!-- /.col -->
                </div>
            </div><!-- /.padding-md -->
        </div><!-- /main-container -->
        <!-- Footer
        ================================================== -->
        @include('layout.footer')


    </div><!-- /wrapper -->

    <a href="" id="scroll-to-top" class="hidden-print"><i class="fa fa-chevron-up"></i></a>
    </div><!-- /wrapper -->

    <!-- Logout confirmation -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->

    @include('layout.footerlink')

</body>

</html>
