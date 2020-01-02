@include('layout.headerlink')


<body class="overflow-hidden">
    {{-- Overlay Div --}}
    @include('layout.header')



    <div id="wrapper" class="preload">

        @include('layout.sidebar')
        <div id="main-container">
            <div id="breadcrumb">
                <ul class="breadcrumb">
                    <li><i class="fa fa-home"></i><a href="#"> @lang('site_lables.Home')/@lang('site_lables.Instructor')</a></li>
                    <li class="active"></li>
                </ul>
            </div>{{-- /breadcrumb--}}

            <div class="padding-md">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default formhideshow" style="display:none">
                            <div class="panel-heading">
                                <h4><b>@lang('site_lables.Instructor')</b></h4>

                                <button type="button"
                                    class="btn btn-primary btn-xs  pull-right closehideshow">@lang('site_lables.Viewinstructor')
                                </button>
                            </div>
                            <div class="panel-body ">
                                <div class="row " id="documents">

                                    <form id="master_form" name="master_form">
                                        <div class="col-md-6">
                                            <div class="row form-group">
                                                <div class="col-sm-4">

                                                    <label>@lang('site_lables.Instructor_Id')*</label>

                                                </div>
                                                <div class="col-sm-8">

                                                    <input type="text" class="form-control input-sm placeholdesize"
                                                        placeholder="@lang('site_lables.Instructor_Id')" id="ins_id"
                                                        name="ins_id" required>

                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-sm-4">

                                                    <label>@lang('site_lables.Instructor_Name')*</label>

                                                </div>
                                                <div class="col-sm-8">

                                                    <input type="text" class="form-control input-sm placeholdesize"
                                                        id="name" name="name"
                                                        placeholder="@lang('site_lables.Instructor_Name')" required>

                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-sm-4">

                                                    <label>@lang('site_lables.Instructor_Tel_No')*</label>

                                                </div>
                                                <div class="col-sm-8">

                                                    <input type="number" class="form-control input-sm placeholdesize"
                                                        id="tel_no" name="tel_no"
                                                        placeholder="@lang('site_lables.Instructor_Tel_No')" required>

                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-sm-4">

                                                    <label>@lang('site_lables.Instructor_Photo')</label>

                                                </div>
                                                <div class="col-sm-8">

                                                    <input type="file" name="photo" id="photo" class="form-control" accept="image/*" >
                                                    <input type="hidden" name="imghidden" id="imghidden" value="0">
                                                    <div id="msgid"></div>
                                                    <div id="wait" style="width:100px;height:100px;position:absolute;top:;left:45%;padding:2px;display:none"><img src="{{ env('APP_URL') }}/resources/sass/img/loader.gif" width="100" height="100" /><br><center><h5>Please Wait...</h5></center></div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-md-6 ">
                                            <img id="profileimg" src="{{ URL::asset('/resources/sass/img/no-image-available.png') }}"
                                                alt="User Avatar" style="width:150px; height: 150px; float:right;">
                                        </div>

                                        <div class="col-sm-12">
                                            <div style="margin-top:0px;border-bottom:1px solid;width:100%;">
                                                <label class=""><b>@lang('site_lables.Login_Details')</b></label>
                                            </div>
                                            <br>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>@lang('site_lables.User_Id')</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <input type="text" class="form-control input-sm placeholdesize"
                                                    placeholder="@lang('site_lables.User_Id')" id="user_id"
                                                    name="user_id"  disabled>

                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group hidepassword">
                                                <label>@lang('site_lables.Password')*</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-2 ">
                                            <div class="form-group hidepassword">
                                                <input type="password" class="form-control input-sm placeholdesize cpassword"
                                                    placeholder="@lang('site_lables.Password')" id="password"
                                                    name="password" required>

                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group hidepassword">
                                                <label>@lang('site_lables.Confirm_Password')*</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group hidepassword">
                                                <input type="password" class="form-control input-sm placeholdesize cpassword"
                                                    placeholder="@lang('site_lables.Confirm_Password')" id="cpassword"
                                                    name="cpassword" required>
                                                <label class="text-danger " id="cpass_error" style="display:none;font-color:red">Password And Conform Password Not Match</label>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
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
                                                            <td><input type="checkbox" name=""
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
                                            <div class="col-lg-10"></div>
                                            <div class="col-lg-2 " style="text-align: right">
                                                <input type="hidden" id="save_update" name="save_update" value="">

                                                <button type="submit" id="submit_btn"
                                                    class="btn btn-sm btn-success btn-sm ">@lang('site_lables.Save')</button>

                                                <button type="button"
                                                    class="btn btn-sm btn-info  closehideshow">@lang('site_lables.Cancel')</button>
                                            </div>

                                        </div>

                                    </form>
                                </div>

                            </div>{{-- /panel --}}
                        </div>{{-- /panel --}}


                        <div class="panel panel-default tablehideshow">
                            <div class="panel-heading">
                                <h4><b>@lang('site_lables.Instructor_List')</b></h4>

                                <button type="button" class="btn btn-primary btn-xs pull-right btnhideshow"><i
                                        class="fa fa-plus"></i> @lang('site_lables.Addinstructor')</button>
                            </div>
                            <div class="panel-body ">

                                <div class="table-responsive" id="show_master">
                                    <table class="table-striped" id="laravel_crud" style="width:100%">
                                        <thead>
                                            <tr>


                                                <th><font style="font-weight:bold">@lang('site_lables.Instructor_Id')</font></th>
                                                <th><font style="font-weight:bold"></font>@lang('site_lables.Instructor_Name')</th>
                                                <th style="text-align:right;" ><font style="font-weight:bold">@lang('site_lables.Instructor_Photo')</font></th>
                                                <th style="text-align:right;"><font style="font-weight:bold">@lang('site_lables.Instructor_Tel_No')</font></th>
                                                <th style="text-align:right;display:none;"><font style="font-weight:bold">@lang('site_lables.Instructor_Tel_No')</font></th>
                                                <th style="text-align:right;display:none;"><font style="font-weight:bold">@lang('site_lables.Instructor_Tel_No')</font></th>
                                                <th class="not-export-column"><font style="font-weight:bold">@lang('site_lables.Action')</font>   </th>

                                            </tr>
                                        </thead>
                                        <tbody id="table_tbody">

                                        </tbody>
                                    </table>
                                </div>








                            </div>{{-- /panel --}}
                        </div>{{-- /panel --}}
                    </div>{{-- /.col --}}




                </div>
            </div>{{-- /.padding-md --}}
        </div>{{--   /main-container --}}

        @include('layout.footer')


    </div>{{-- /wrapper --}}

    <a href="" id="scroll-to-top" class="hidden-print"><i class="fa fa-chevron-up"></i></a>


    {{-- Logout confirmation --}}

    {{-- Le javascript
    ================================================== --}}
    {{-- Placed at the end of the document so the pages load faster --}}

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
var uploadfileurl="{{ url('instrucoruploadimg') }}";
var imgurl="<?php  echo url('/') ?>";
var instrucotrdel="{{ url('deleteinstructor') }}";
var add_data="{{route('instructor.store') }}";
var delete_data="{{ url('deleteallinfoin') }}"
</script>
<script>
    $("#data_table").DataTable();
</script>
<script type='text/javascript' src="{{ URL::asset('/resources/js/myjs/instrucutor.js',true) }}">
</script>
</html>
