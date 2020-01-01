@include('layout.headerlink')

<body class="overflow-hidden">
    <!-- Overlay Div -->
    @include('layout.header')
    <div id="wrapper" class="preload">
        @include('layout.sidebar')
        <div id="main-container">
            <div id="breadcrumb">
                <ul class="breadcrumb">
                    <li><i class="fa fa-home"></i><a href="#"> @lang('site_lables.Home')/@lang('site_lables.Member')</a></li>
                    <li class="active"></li>
                </ul>
            </div><!-- /breadcrumb-->
            <div class="padding-md">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default formhideshow" style="display: none;">
                            <div class="panel-heading">
                                <h4 class="panel-title"><b>@lang('site_lables.Member')</b></h4>
                                <div class="panel-controls">
                                    <button type="button"
                                        class="btn btn-primary btn-xs  pull-right closehideshow">@lang('site_lables.View_Data')
                                    </button>
                                    <br><br>
                                </div>
                            </div>
                            <div class="panel-body ">
                                <div class="row " id="documents">
                                    <form id="master_form" name="master_form">
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>@lang('site_lables.User_Id')
                                                    (@lang('site_lables.Phone_Number'))*</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <input type="number" class="form-control input-sm placeholdesize checkuserid"
                                                    placeholder="@lang('site_lables.User_Id')" id="user_id"
                                                    name="user_id" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>@lang('site_lables.Password')</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <input type="password" class="form-control input-sm placeholdesize"
                                                    id="password" name="password"
                                                    placeholder="@lang('site_lables.Password')" >
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>@lang('site_lables.Name')*</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <input type="text" class="form-control input-sm placeholdesize"
                                                    placeholder="@lang('site_lables.Name')" id="name" name="name"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>@lang('site_lables.IC_number')</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <input type="text" class="form-control input-sm placeholdesize"
                                                    placeholder="@lang('site_lables.IC_number')" id="ic_number"
                                                    name="ic_number">
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>@lang('site_lables.Date_of_Birth')</label>
                                            </div>

                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <div class="input-group date date1" data-provide="datepicker">
                                                    <input type="text"
                                                        class="form-control input-sm placeholdesize datepicker" id="dob"
                                                        name="dob">
                                                    <div class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>@lang('site_lables.Address')</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <textarea name="address" id="address" rows="2" class="form-control"
                                                    placeholder="@lang('site_lables.Address')"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>@lang('site_lables.Email') @lang('site_lables.Address')</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <input type="email" class="form-control input-sm placeholdesize"
                                                    id="email" name="email"
                                                    placeholder="@lang('site_lables.Email') @lang('site_lables.Address')">
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>@lang('site_lables.Current') @lang('site_lables.Package')</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <select name="package" id="package" class="form-control input-sm">
                                                    <option value="" selected disabled>@lang('site_lables.Select')
                                                    </option>
                                                    <option value="package_1">@lang('site_lables.Package') 1</option>
                                                    <option value="package_2">@lang('site_lables.Package') 2</option>
                                                    <option value="package_3">@lang('site_lables.Package') 3</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>@lang('site_lables.Member_Type')</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <select name="member_type" id="member_type"
                                                    class="form-control input-sm">


                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>@lang('site_lables.Date_of_Expire')</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="input-group date" data-provide="datepicker">
                                                <input type="text"
                                                    class="form-control input-sm placeholdesize datepicker" id="doe"
                                                    name="doe">
                                                <div class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </div>
                                            </div>
                                            <br>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>@lang('site_lables.BalancePoint') </label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control input-sm placeholdesize"
                                                placeholder="Balance Point" id="bal_point" name="bal_point">
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>@lang('site_lables.Image')* </label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <input type="file" id="upload" name="upload" class="form-control" accept="image/*" required>
                                                <input type="hidden" id="uploadimg_hidden" name="uploadimg_hidden" value="">
                                                <div id="msg" name="msg"></div>
<div id="wait" style="width:100px;height:100px;position:absolute;top:;left:45%;padding:2px;display:none"><img src="{{ env('APP_URL') }}/resources/sass/img/loader.gif" width="100" height="100" /><br><center><h5>Please Wait...</h5></center></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12" id="if_group" style="display:none;">
                                            <div style="margin-top:0px;border-bottom:1px solid;width:100%;">
                                                <h5 class=""><b>@lang('site_lables.Link')
                                                        @lang('site_lables.Relationship')</b></h5>
                                            </div>
                                            <br>
                                            <div class="table-responsive row form-group" id="">
                                                <table id="file_info2"
                                                    style="width: 100%; margin-left: 0px; table-layout: fixed;"
                                                    class="table table-striped dataTable no-footer">
                                                    <thead>
                                                        <input type="hidden" id="row" class="row" value="0">
                                                        <tr>
                                                            <th>@lang('site_lables.Name')</th>
                                                            <th>@lang('site_lables.Relationship')</th>
                                                            <th>@lang('site_lables.User_Id')
                                                                (@lang('site_lables.Phone_Number'))</th>
                                                            <th>@lang('site_lables.Password')</th>
                                                            <th><button type="button" id="plus2" class="btn btn-success"
                                                                    value=""><i class="fa fa-plus"></i></button></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="file_info_tbody2"></tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-sm-12" id="if_edit" style="display:none">
                                            <div style="margin-top:0px;border-bottom:1px solid;width:100%;">
                                                <h5 class=""><b>@lang('site_lables.Point') @lang('site_lables.Usage')
                                                        @lang('site_lables.History')</b></h5>
                                            </div>
                                            <br>
                                            <div class="table-responsive row form-group" id="">
                                                <table id="history"
                                                    style="width: 100%; margin-left: 0px; table-layout: fixed;"
                                                    class="table table-striped dataTable no-footer">
                                                    <thead>
                                                        <tr>
                                                            <th>@lang('site_lables.Date_and_Time')</th>
                                                            <th>@lang('site_lables.User_Id')</th>
                                                            <th>@lang('site_lables.Class')</th>
                                                            <th>@lang('site_lables.Point') @lang('site_lables.Use')</th>
                                                            <th>@lang('site_lables.Instructor')</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="history_tbody">
                                                        <tr>
                                                            <td>01/01/1999 12:00:00</td>
                                                            <td> abc</td>
                                                            <td>5</td>
                                                            <td>56</td>
                                                            <td>xyz</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="col-lg-10"> <button type="button"
                                                    class="btn btn-sm btn-danger pull-left deletehideshow delete_data"
                                                    style="display: none">@lang('site_lables.Delete')</button>
                                            </div>
                                            <div class="col-lg-2 " style="text-align: right">
                                                <input type="hidden" id="save_update" name="save_update"  value="">
                                                {{-- <input type="hidden" id="save_update" value=""> --}}
                                                <button type="submit" id="btnsave"
                                                    class="btn btn-sm btn-success btn-sm ">@lang('site_lables.Save')</button>
                                                <button type="button"
                                                    class="btn btn-sm btn-info  closehideshow">@lang('site_lables.Cancel')</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div><!-- /panel -->
                        </div><!-- /panel -->
                        <div class="panel panel-default tablehideshow">
                            <div class="panel-heading">
                                <h4 class="panel-title"><b>@lang('site_lables.Members_List')</b></h4>
                                <div class="panel-controls">
                                    <button type="button" class="btn btn-primary btn-xs pull-right btnhideshow">
                                        @lang('site_lables.Add_New')
                                    </button>
                                    <br><br>
                                </div>
                            </div>
                            <div class="panel-body ">
                                <div class="table-responsive" id="show_master">
                                    <table class="table-striped" id="laravel_crud" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th><font style="font-weight:bold">@lang('site_lables.User_Id')</font></th>
                                                <th><font style="font-weight:bold"></font>@lang('site_lables.Name')</th>
                                                <th><font style="font-weight:bold"></font>@lang('site_lables.Ic_Number')</th>
                                                <th><font style="font-weight:bold"></font>@lang('site_lables.Current_Package')</th>
                                                <th><font style="font-weight:bold"></font>@lang('site_lables.Member_Type')</th>
                                                <th style="display:none;"><font style="font-weight:bold"></font>Member type id</th>
                                                <th><font style="font-weight:bold"></font>@lang('site_lables.Date_of_Expiry')</th>
                                                <th><font style="font-weight:bold"></font>@lang('site_lables.Member_Count')</th>
                                                <th style="display:none;"><font style="font-weight:bold"></font>Date of Birth</th>
                                                <th style="display:none;"><font style="font-weight:bold"></font>Address</th>
                                                <th style="display:none;"><font style="font-weight:bold"></font>Image</th>
                                                <th style="display:none;"><font style="font-weight:bold"></font>Email Address</th>
                                                <th style="display:none;"><font style="font-weight:bold"></font>Current Package</th>
                                                <th style="display:none;"><font style="font-weight:bold"></font>Current Package</th>
                                                <th style="display:none;"><font style="font-weight:bold"></font>Balance Point</th>
                                                <th class="not-export-column"><font style="font-weight:bold">@lang('site_lables.Action')</font>   </th>
                                            </tr>
                                        </thead>
                                        <tbody id="table_tbody">

                                        </tbody>
                                    </table>
                                </div>
                            </div><!-- /panel -->
                        </div><!-- /panel -->
                        <div class="panel panel-default viewhideshow" style="display: none;">
                            <div class="panel-heading">
                                <h4 class="panel-title"><b>@lang('site_lables.Member') @lang('site_lables.View')</b>
                                </h4>
                                <div class="panel-controls">
                                    <button type="button"
                                        class="btn btn-primary btn-xs  pull-right closehideshow">@lang('site_lables.View_Data')
                                    </button>
                                    <br><br>
                                </div>
                            </div>
                            <div class="panel-body ">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>@lang('site_lables.User_Id')
                                                    (@lang('site_lables.Phone_Number'))*</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <span id="user_id_v" class="">9904760745</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>@lang('site_lables.Password')*</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <span id="password_v" class="">****</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>@lang('site_lables.Name')*</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <span id="name_v" class="">Ajaz</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>@lang('site_lables.IC_number')</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <span id="ic_number_v" class="">1111</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>@lang('site_lables.Date_of_Birth')</label>
                                            </div>

                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <span id="dob_v" class="">25/09/1995</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>@lang('site_lables.Address')</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">

                                                <span id="address_v" class="">Rajkot</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>@lang('site_lables.Email') @lang('site_lables.Address')</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">

                                                <span id="email_v" class="">ajaz@gmail.com</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>@lang('site_lables.Current_Package')</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <span id="package_v" class="">Package 1</span>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>@lang('site_lables.Member_Type')</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <span id="member_type_v" class="">Group</span>

                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>@lang('site_lables.Date_of_Expire')</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <span id="doe_v" class="">31/12/2019</span>

                                            </div>

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>@lang('site_lables.BalancePoint')</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <span id="bal_point_v" class="">50</span>

                                            </div>

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12" id="linkrelationdata">
                                            <div style="margin-top:0px;border-bottom:1px solid;width:100%;">
                                                <h5 class=""><b>@lang('site_lables.Link') @lang('site_lables.Relationship')</b></h5>
                                            </div>
                                            <br>
                                            <div class="table-responsive row form-group" >
                                                <table id="file_info2_v"
                                                    style="width: 100%; margin-left: 0px; table-layout: fixed;"
                                                    class="table table-striped dataTable no-footer">
                                                    <thead>
                                                        <input type="hidden" id="row" class="row" value="0">
                                                        <tr>
                                                            <th>@lang('site_lables.Name')</th>
                                                            <th>@lang('site_lables.Relationship')</th>
                                                            <th>@lang('site_lables.User_Id')  (@lang('site_lables.Phone_Number'))</th>
                                                            <th>@lang('site_lables.Password')</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody id="file_info_tbody2_v">
                                                        <td>Ajazkhan</td>
                                                        <td>Friend</td>
                                                        <td>9904760745</td>
                                                        <td>51116</td>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div style="margin-top:0px;border-bottom:1px solid;width:100%;">
                                                <h5 class=""><b>@lang('site_lables.Point') @lang('site_lables.Usage') @lang('site_lables.History')</b></h5>
                                            </div>
                                            <br>
                                            <div class="table-responsive row form-group" id="">
                                                <table id="history2"
                                                    style="width: 100%; margin-left: 0px; table-layout: fixed;"
                                                    class="table table-striped dataTable no-footer">
                                                    <thead>
                                                        <tr>
                                                            <th>@lang('site_lables.Date_&_Time')</th>
                                                            <th>@lang('site_lables.User_Id')</th>
                                                            <th> @lang('site_lables.Class')</th>
                                                            <th> @lang('site_lables.Point') @lang('site_lables.Use')</th>
                                                            <th>@lang('site_lables.Instructor')</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="history_tbody2">
                                                        <tr>
                                                            <td>01/01/1999 12:00:00</td>
                                                            <td> abc</td>
                                                            <td>5</td>
                                                            <td>56</td>
                                                            <td>xyz</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="col-lg-10"> <button type="button"
                                                    class="btn btn-sm btn-danger pull-left deletehideshow delete_data"
                                                    style="display: none">@lang('site_lables.Delete')</button>
                                            </div>
                                            <div class="col-lg-2 " style="text-align: right">
                                                <input type="hidden" id="save_update" name="save_update" value="">
                                                <input type="hidden" id="tbl_id" name="tbl_id" value="0">

                                                {{--  <button type="submit"
                                                    class="btn btn-sm btn-success btn-sm ">@lang('site_lables.Save')</button>  --}}
                                                <button type="button"
                                                    class="btn btn-sm btn-info  closehideshow">@lang('site_lables.Close')</button>
                                            </div>
                                        </div>
                                    </div>

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
var add_data="{{route('member.store') }}";
var getpackagepoint="{{url('getpackagepoint')}}";
var changestatus="{{ url('changestatus') }}";
var checkpackagename="{{ url('chackpackagename') }}";
var deletemember="{{ url('deletemembers') }}"
var getgroupinfo="{{ url('getgroupwiseinfo') }}";
var delete_data="{{ url('deletememberinfo') }}";
var checkuseridexis="{{ url('checkuseridexist') }}";
var uploadfileurl="{{ url('member_img') }}";
var getpointusage="{{ url('getpointusage') }}"
</script>
<script>
    $('.date').datepicker({
                       'todayHighlight': true,
                       format: 'dd/mm/yyyy',
                       autoclose: true,
                       maxDate: '0',

                  });
                  $('.date1').datepicker({
                       'todayHighlight': true,
                       format: 'dd/mm/yyyy',
                       autoclose: true,
                       maxDate: '0',

                  });

                  var date = new Date();
                  date = date.toString('dd/MM/yyyy');


                  $("#dob").val(date);
                  $("#doe").val(date);
                  //  $("#fdate").val(date);
</script>
<script type='text/javascript' src="{{ URL::asset('/resources/js/myjs/member.js')}}"></script>

</html>
