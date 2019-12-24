@include('layout.headerlink')


<body class="overflow-hidden">
    <!-- Overlay Div -->
    @include('layout.header')



    <div id="wrapper" class="preload">

        @include('layout.sidebar')
        <div id="main-container">
            <div id="breadcrumb">
                <ul class="breadcrumb">
                    <li><i class="fa fa-home"></i><a href="#"> @lang('site_lables.Home')/@lang('site_lables.Member_Attendence_Tacking')</a></li>
                    <li class="active"></li>
                </ul>
            </div><!-- /breadcrumb-->

            <div class="padding-md">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4><b>@lang('site_lables.Member_Attendence_Tacking')</b></h4>

                                {{-- <button type="button" class="btn btn-primary btn-xs pull-right btnhideshow"><i
                                        class="fa fa-plus"></i> @lang('site_lables.Add_New')</button> --}}
                            </div>
                            <div class="panel-body ">
                                <div class="col-lg-12">

                                    <form id="master_form" name="master_form">
                                        <h5><b>@lang('site_lables.Member_Attendence') : </b><span id="today"></span></h5>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <b><span id="start_time">00 :00</span></b>
                                            </div>
                                            <div class="col-sm-4">
                                                <b> <span id="end_time">00:00</span></b>
                                            </div>
                                            <br>
                                        </div>

                                        <div class="row">
                                            <h5>@lang('site_lables.Class_List')</h5>
                                            <table class="table table-striped">

                                                <thead>
                                                    <tr>
                                                        <th>
                                                           @lang('site_lables.Class_Name')
                                                        </th>
                                                        <th>
                                                            @lang('site_lables.Instructor_Name')
                                                        </th>
                                                        {{-- <th>
                                                           @lang('site_lables.Attendence')
                                                        </th> --}}
                                                    </tr>
                                                </thead>
                                                <tbody id="classlisttbody">
                                                    {{-- <tr>
                                                        <td>
                                                            Class 1
                                                        </td>
                                                        <td class="attendence">
                                                            <a href="#">Take Attendence</a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            Class 2
                                                        </td>
                                                        <td class="attendence">
                                                            <a href="#">Take Attendence</a>
                                                        </td>
                                                    </tr> --}}
                                                </tbody>
                                            </table>
                                        </div>

                                            <div class="row">
                                                <h6 style="text-align:center;"><b>@lang('site_lables.Students_List')</b></h6>
                                            </div>
                                        <div class="row" id="studebt_list">

                                            {{-- <table id="student_table" class="table table-striped">
                                                <thead>
                                                    <tr>

                                                        <th></th>
                                                        <th></th>
                                                        <th>@lang('site_lables.Students_List')</th>
                                                        <th></th>
                                                        <th></th>

                                                    </tr>
                                                </thead> --}}

                                                {{-- <tbody id="student_table_tbody">
                                                    <tr>
                                                        <td>
                                                            <input type="checkbox" name="member1" value="0">@lang('site_lables.Member_Name')
                                                        </td>
                                                        <td>
                                                            <input type="checkbox" name="member1" value="0"> @lang('site_lables.Member_Name')
                                                        </td>
                                                        <td>
                                                            <input type="checkbox" name="member1" value="0"> @lang('site_lables.Member_Name')
                                                        </td>
                                                        <td>
                                                            <input type="checkbox" name="member1" value="0"> @lang('site_lables.Member_Name')
                                                        </td>
                                                        <td>
                                                            <input type="checkbox" name="member1" value="0"> @lang('site_lables.Member_Name')
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <input type="checkbox" name="member1" value="0"> @lang('site_lables.Member_Name')
                                                        </td>
                                                        <td>
                                                            <input type="checkbox" name="member1" value="0"> @lang('site_lables.Member_Name')
                                                        </td>
                                                        <td>
                                                            <input type="checkbox" name="member1" value="0"> @lang('site_lables.Member_Name')
                                                        </td>
                                                        <td>
                                                            <input type="checkbox" name="member1" value="0"> @lang('site_lables.Member_Name')
                                                        </td>
                                                        <td>
                                                            <input type="checkbox" name="member1" value="0"> @lang('site_lables.Member_Name')
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <input type="checkbox" name="member1" value="0"> @lang('site_lables.Member_Name')
                                                        </td>
                                                        <td>
                                                            <input type="checkbox" name="member1" value="0"> @lang('site_lables.Member_Name')
                                                        </td>
                                                        <td>
                                                            <input type="checkbox" name="member1" value="0"> @lang('site_lables.Member_Name')
                                                        </td>
                                                        <td>
                                                            <input type="checkbox" name="member1" value="0"> @lang('site_lables.Member_Name')
                                                        </td>
                                                        <td>
                                                            <input type="checkbox" name="member1" value="0"> @lang('site_lables.Member_Name')
                                                        </td>
                                                    </tr>
                                                </tbody>--}}
                                            {{-- </table> --}}
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="col-lg-10"></div>
                                            <div class="col-lg-2 " style="text-align: right">
                                                <input type="hidden" id="save_update" value="">
                                                <input type="hidden" id="classsecid" value="">

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


                        {{--  <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4><b>Room List</b></h4>


                            </div>
                            <div class="panel-body ">

                                <div class="table-responsive" id="show_master">
                                    <table class="table-striped" id="data_table" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Room</th>

                                                <th>Action</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Room 1</td>

                                                <td><Button type="button" class="btn btn-primary"><i
                                                            class="fa fa-edit"></i></Button>&nbsp;<Button type="button"
                                                        class="btn btn-danger"><i class="fa fa-trash-o"></i></Button>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Room 8</td>

                                                <td><Button type="button" class="btn btn-primary"><i
                                                            class="fa fa-edit"></i></Button>&nbsp;<Button type="button"
                                                        class="btn btn-danger"><i class="fa fa-trash-o"></i></Button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Room 6</td>

                                                <td><Button type="button" class="btn btn-primary"><i
                                                            class="fa fa-edit"></i></Button>&nbsp;<Button type="button"
                                                        class="btn btn-danger"><i class="fa fa-trash-o"></i></Button>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>








                            </div><!-- /panel -->
                        </div><!-- /panel -->  --}}
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
    {{--  $("#student_table").DataTable();  --}}
</script>

<script type="text/javascript">
    $(document).ready(function () {
    $.ajaxSetup({
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });

});
var getdata="{{ url('getbetweenclasssechedule') }}";
var getsechedulemember="{{ url('getsechedulemember') }}";
var saveattandance="{{ route('member_attendence_taking.store') }}";

</script>
<script>
    $('.dob').datepicker({
                       'todayHighlight': true,
                       format: 'dd/mm/yyyy',
                       autoclose: true,
                  });
                  var date1 = new Date();
                var  date = date1.toString('dd/MM/yyyy');
                  $("#today").text(date);
                  //  $("#fdate").val(date);

                  var hours = date1.getHours();
                    var minutes = date1.getMinutes();
                    var ampm = hours >= 12 ? 'PM' : 'AM';
                    hours = hours % 12;
                    hours = hours ? hours : 12; // the hour '0' should be '12'
                    minutes = minutes < 10 ? '0' +minutes : minutes;
                     var strTime=hours + ':00 ' + ampm;
var plus=parseInt(hours)+1;
var strTime1=plus + ':00 ' + ampm;

                    $("#start_time").text(strTime);
                    $("#end_time").text(strTime1);

</script>
<script type='text/javascript' src="{{ URL::asset('/resources/js/myjs/memberattandance.js',true) }}">
</script>
</html>
