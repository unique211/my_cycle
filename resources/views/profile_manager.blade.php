@include('layout.headerlink')


<body class="overflow-hidden">
    <!-- Overlay Div -->
    @include('layout.header')



    <div id="wrapper" class="preload">

        @include('layout.sidebar')
        <div id="main-container">
            <div id="breadcrumb">
                <ul class="breadcrumb">
                    <li><i class="fa fa-home"></i><a href="#"> @lang('site_lables.Home')/@lang('site_lables.Profile_Manager')</a></li>
                    <li class="active"></li>
                </ul>
            </div><!-- /breadcrumb-->

            <div class="padding-md">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default formhideshow">
                            <div class="panel-heading">
                                <h4><b>@lang('site_lables.Profile_Manager')</b></h4>

                                <button type="button"
                                    class="btn btn-primary btn-xs  pull-right closehideshow">@lang('site_lables.View_Profile')
                                </button>
                            </div>
                            <div class="panel-body ">
                                <div class="col-lg-12" id="documents">

                                    <form id="master_form" name="master_form">
                                        <div class="row">
                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label>@lang('site_lables.Profile_Type')*</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    {{-- <select name="member_type" id="member_type"
                                                        class="form-control input-sm" required>

                                                        <option value="Admin" selected>Admin</option>
                                                        <option value="Staff">Staff</option>

                                                    </select> --}}
                                                    <input type="text" class="form-control" name="profiletype" id="profiletype" placeholder="@lang('site_lables.Profile_Type')" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div style="margin-top:0px;border-bottom:2px solid;width:100%;">
                                                <h4 class="modal-title">@lang('site_lables.User_Rights')</h4>
                                            </div>
                                            <style>
                                                .main_menu {
                                                    font-weight: bold;
                                                    background: #33414e;
                                                    color: white;
                                                }

                                                .sub_menu {
                                                    margin-left: 20px;
                                                }
                                            </style>
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>@lang('site_lables.Menu_Name')</th>
                                                            <th>@lang('site_lables.Readonly')</th>
                                                            <th>@lang('site_lables.Modify')</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tbd_user_rights">
                                                        <tr class="main_menu">
                                                            <td><input type="checkbox" name="" value="">
                                                                <span>@lang('site_lables.Dashboard')</span></td>
                                                            <td><input type="radio" name="a" /></td>
                                                            <td><input type="radio" name="a" /></td>
                                                        </tr>

                                                        <tr class="main_menu">
                                                            <td><input type="checkbox" name="" value="">
                                                                <span>@lang('site_lables.User_Access')</span></td>
                                                            <td><input type="radio" name="a" /></td>
                                                            <td><input type="radio" name="a" /></td>
                                                        </tr>
                                                        <tr class="main_menu">
                                                            <td><input type="checkbox"  name=""
                                                                    value=""><span>@lang('site_lables.Instructor')</span>
                                                            </td>
                                                            <td><input type="radio" name="a" /></td>
                                                            <td><input type="radio" name="a" /></td>
                                                        </tr>
                                                        <tr class="main_menu">
                                                            <td><input type="checkbox" name=""
                                                                    value=""><span>@lang('site_lables.Member')</span>
                                                            </td>
                                                            <td><input type="radio" name="a" /></td>
                                                            <td><input type="radio" name="a" /></td>
                                                        </tr>
                                                        <tr class="main_menu">
                                                            <td><input type="checkbox" name=""
                                                                    value=""><span>@lang('site_lables.Package')</span>
                                                            </td>
                                                            <td><input type="radio" name="a" /></td>
                                                            <td><input type="radio" name="a" /></td>
                                                        </tr>
                                                        <tr class="main_menu">
                                                            <td><input type="checkbox" name=""
                                                                    value=""><span>@lang('site_lables.Setting')</span>
                                                            </td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                        <tr class="sub_menu">
                                                            <td><span>@lang('site_lables.Language')</span></td>
                                                            <td><input type="radio" name="b" /></td>
                                                            <td><input type="radio" name="b" /></td>
                                                        </tr>
                                                        <tr class="sub_menu">
                                                            <td><span>@lang('site_lables.Member_Type')</span></td>
                                                            <td><input type="radio" name="b" /></td>
                                                            <td><input type="radio" name="b" /></td>
                                                        </tr>
                                                        <tr class="sub_menu">
                                                            <td><span>@lang('site_lables.Site_Setting')</span></td>
                                                            <td><input type="radio" name="b" /></td>
                                                            <td><input type="radio" name="b" /></td>
                                                        </tr>
                                                        <tr class="sub_menu">
                                                            <td><span>@lang('site_lables.Mobile_Notification')</span>
                                                            </td>
                                                            <td><input type="radio" name="b" /></td>
                                                            <td><input type="radio" name="b" /></td>
                                                        </tr>
                                                        <tr class="main_menu">
                                                            <td><input type="checkbox" name=""
                                                                    value=""><span>@lang('site_lables.Reports')</span>
                                                            </td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                        <tr class="sub_menu">
                                                            <td><span>@lang('site_lables.Class_Booking')</span></td>
                                                            <td><input type="radio" name="b" /></td>
                                                            <td><input type="radio" name="b" /></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="col-lg-9"></div>
                                            <div class="col-lg-3 " style="text-align: right">
                                                <input type="hidden" id="save_update" name="save_update" value="">

                                                <button type="submit" id="btnsave"
                                                    class="btn btn-sm btn-success btn-sm ">@lang('site_lables.Save')</button>

                                                <button type="button"
                                                    class="btn btn-sm btn-info  closehideshow">@lang('site_lables.Cancel')</button>
                                                    <button type="button"
                                                    class="btn btn-sm btn-danger  deletedata" id="delete" style="display:none;">Delete</button>

                                            </div>


                                        </div>

                                    </form>
                                </div>

                            </div><!-- /panel -->
                        </div><!-- /panel -->


                        <div class="panel panel-default tablehideshow">
                            <div class="panel-heading">
                                <h4><b>@lang('site_lables.Profile_List')</b></h4>

                                <button type="button" class="btn btn-primary btn-xs pull-right btnhideshow"><i
                                        class="fa fa-plus"></i> @lang('site_lables.Add_Profile')</button>
                            </div>
                            <div class="panel-body">

                                <div class="table-responsive" id="show_master">
                                    <table class="table-striped" id="laravel_crud" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th><font style="font-weight:bold">@lang('site_lables.Sr.No.')</font></th>
                                                <th><font style="font-weight:bold"></font>@lang('site_lables.Profile_Type')</th>
                                                <th class="not-export-column"><font style="font-weight:bold">@lang('site_lables.Action')</font>   </th>

                                            </tr>
                                        </thead>
                                        <tbody id="table_tbody">


                                        </tbody>
                                    </table>
                                </div>








                            </div><!-- /panel -->
                        </div><!-- /panel -->
                    </div><!-- /.col -->




                </div>
            </div><!-- /.padding-md -->
        </div><!-- /main-container -->

        @include('layout.footer')


    </div><!-- /wrapper -->

    <a href="" id="scroll-to-top" class="hidden-print"><i class="fa fa-chevron-up"></i></a>


    <!-- Logout confirmation -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->

    @include('layout.footerlink')

</body>
<script>
    $("#data_table").DataTable();
</script>
<script type="text/javascript">
    $(document).ready(function () {
    $.ajaxSetup({
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });

});
 var add_data="{{route('profile_manager.store') }}";
// var delete_data="{{url('deletepackage')}}";
// var changestatus="{{ url('changestatus') }}";
// var checkpackagename="{{ url('chackpackagename') }}";
var delete_from_user_rights="{{ url('deleteuserright')}}";
var delete_data="{{url('deleteprofile')}}";
</script>
<script>
    $('.dob').datepicker({
                       'todayHighlight': true,
                       format: 'dd/mm/yyyy',
                       autoclose: true,
                  });
                  var date = new Date();
                  date = date.toString('dd/MM/yyyy');
                  $("#dob").val(date);
                  //  $("#fdate").val(date);
</script>
<script type='text/javascript' src="{{ URL::asset('/resources/js/myjs/profile_manager.js') }}">
</script>
</html>
