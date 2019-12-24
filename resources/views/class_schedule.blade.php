@include('layout.headerlink')


<body class="overflow-hidden">
    <!-- Overlay Div -->
    @include('layout.header')



    <div id="wrapper" class="preload">

        @include('layout.sidebar')
        <div id="main-container">
            <div id="breadcrumb">
                <ul class="breadcrumb">
                    <li><i class="fa fa-home"></i><a href="#"> @lang('site_lables.Home')/@lang('site_lables.Class_Schedule')</a></li>
                    <li class="active"></li>
                </ul>
            </div><!-- /breadcrumb-->

            <div class="padding-md">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4><b>@lang('site_lables.Class_Schedule')</b></h4>

                                {{-- <button type="button" class="btn btn-primary btn-xs pull-right btnhideshow"><i
                                        class="fa fa-plus"></i> @lang('site_lables.Add_New')</button> --}}
                            </div>
                            <div class="panel-body ">
                                <div class="row " id="documents">

                                    <form id="master_form" name="master_form">
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>@lang('site_lables.Class_Name')*</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">


                                                <select name="classsechedule_name" id="classsechedule_name" class="form-control input-sm"
                                                    required>
                                                    <option value="" selected disabled>Select</option>
                                                    <option value="class_1">Class 1</option>
                                                    <option value="class_2">Class 2</option>
                                                    <option value="class_3">Class 3</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>@lang('site_lables.Class_Schedule')*</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <div class='input-group datetimepicker' id='datetimepicker2'>
                                                    <input type='text' class="form-control" style="width:100%"
                                                        id="class_schedule" name="class_schedule" required />
                                                    <div class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>@lang('site_lables.Instructor')* </label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">

                                                <select name="instructorid" id="instructorid"
                                                    class="form-control input-sm" required>
                                                    <option value="" selected disabled>Select</option>
                                                    <option value="1">Instructor 1</option>
                                                    <option value="2">Instructor 2</option>
                                                    <option value="3">Instructor 3</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>@lang('site_lables.Max_Vacancy')*</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <input type="number" class="form-control input-sm placeholdesize"
                                                value="0" min="0"   style="text-align:right;"  placeholder="@lang('site_lables.Max_Vacancy')" id="max_vacancy" name="max_vacancy" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label> @lang('site_lables.Class_Duration') (@lang('site_lables.In_Minutes'))*</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <input type="number" class="form-control input-sm placeholdesize"
                                                    placeholder="@lang('site_lables.Class_Duration')" id="class_duration"
                                                  value="0"   name="class_duration"  style="text-align:right;" min="0" required >
                                            </div>
                                        </div>

                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>@lang('site_lables.Room')*</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">

                                                <select name="room_id" id="room_id" class="form-control input-sm" required>
                                                    <option value="" selected disabled>Select</option>
                                                    <option value="1">Room 1</option>
                                                    <option value="2">Room 2</option>
                                                    <option value="3">Room 3</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>@lang('site_lables.Min_Cancelation')*</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <div class='input-group datetimepicker' id='datetimepicker2'>
                                                    <input type='text' class="form-control" style="width:100%"
                                                        id="min_cancelation" name="min_cancelation" required/>
                                                    <div class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>@lang('site_lables.Min_Booking')*</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <div class='input-group datetimepicker' id='datetimepicker2'>
                                                    <input type='text' class="form-control" style="width:100%"
                                                        id="min_booking" name="min_booking" required/>
                                                    <div class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>@lang('site_lables.Status')</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                {{--  <input type="radio" name="status" value="active">Active
                                                <input type="radio" name="status" value="inactive">Inactive  --}}
                                                <input type="hidden" id="statusinfo" name="statusinfo" value="">
                                                <input type="hidden" id="classendtime" name="classendtime" value="">
                                                    <input type="checkbox"  id="status" checked data-toggle="toggle"      data-on="@lang('site_lables.Active')" data-off="@lang('site_lables.Inactive')"  data-onstyle="success" data-offstyle="danger"  >
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="col-lg-10"></div>
                                            <div class="col-lg-2 " style="text-align: right">
                                                <input type="hidden" id="save_update" name="save_update" value="">

                                                <button type="submit"
                                                    class="btn btn-sm btn-success btn-sm ">@lang('site_lables.Save')</button>

                                                <button type="button"
                                                    class="btn btn-sm btn-info  closehideshow">@lang('site_lables.Cancel')</button>
                                            </div>

                                        </div>

                                    </form>
                                </div>

                            </div><!-- /panel -->
                        </div><!-- /panel -->


                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4><b>@lang('site_lables.Class_Schedule')</b></h4>

                                {{-- <button type="button" class="btn btn-primary btn-xs pull-right btnhideshow"><i
                                                                class="fa fa-plus"></i> @lang('site_lables.Add_New')</button> --}}
                            </div>
                            <div class="panel-body ">

                                <div class="table-responsive" id="show_master">
                                    <table class="table-striped" id="laravel_crud" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th><font style="font-weight:bold"></font>@lang('site_lables.Class_Name')</th>
                                                <th style="display:none;"><font style="font-weight:bold"></font>@lang('site_lables.Class_Id')</th>
                                                <th><font style="font-weight:bold">@lang('site_lables.Class_Schedule')</font></th>
                                                <th style="display:none;"><font style="font-weight:bold">@lang('site_lables.Instructor')</font></th>
                                                <th><font style="font-weight:bold">@lang('site_lables.Instructor')</font></th>
                                                <th><font style="font-weight:bold">@lang('site_lables.Max_Vacancy')</font></th>
                                                <th style="display:none;"><font style="font-weight:bold;">@lang('site_lables.Class_Schedule')</font></th>
                                                <th style="display:none;"><font style="font-weight:bold;"> @lang('site_lables.Class_Duration')</font></th>
                                                <th style="display:none;"><font style="font-weight:bold;">@lang('site_lables.Room')</font></th>
                                                <th style="display:none;"><font style="font-weight:bold;">@lang('site_lables.Min_Cancelation')</font></th>
                                                <th style="display:none;"><font style="font-weight:bold;">@lang('site_lables.Min_Booking')</font></th>
                                                <th style="display:none;"><font style="font-weight:bold;">@lang('site_lables.Endtime')</font></th>
                                                <th><font style="font-weight:bold">@lang('site_lables.Status')</font></th>
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
    $(document).ready(function () {
    $.ajaxSetup({
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });


});
</script>
<script>
     var add_data="{{route('class_schedule.store') }}";
     var delete_data="{{ url('deleteclasssechedule') }}";
     var changestatus="{{ url('changeclasssechedulestatus') }}";
    $('.clockpicker').clockpicker({
        //'timeFormat':'H:i'
    });
        $('.datetimepicker').datetimepicker({

       // format: 'DD/MM/YYYY  h:ia',
      //format: 'DD/MM/YYYY hh:mm A',
      format: 'DD/MM/YYYY HH:mm:ss',

      //pick12HourFormat: false,



        });
    $('.dob').datepicker({
                       'todayHighlight': true,
                       format: 'dd/mm/yyyy',
                       autoclose: true,
                  });
                  var date = new Date();
                  date = date.toString('dd/MM/yyyy');
                  $("#dob").val(date);
                  //  $("#fdate").val(date);

                  $('#status').bootstrapToggle({
                on: '@lang('site_lables.Active')',
                off: '@lang('site_lables.Inactive')'
                });
</script>
<script type='text/javascript' src="{{ URL::asset('/resources/js/myjs/classschedule.js',true) }}"></script>
</html>
