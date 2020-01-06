@include('layout.headerlink')


<body class="overflow-hidden">
    <!-- Overlay Div -->
    @include('layout.header')



    <div id="wrapper" class="preload">

        @include('layout.sidebar')
        <div id="main-container">
            <div id="breadcrumb">
                <ul class="breadcrumb">
                    <li><i class="fa fa-home"></i><a href="#"> @lang('site_lables.Home')/@lang('site_lables.Class_Booking')</a></li>
                    <li class="active"></li>
                </ul>
            </div><!-- /breadcrumb-->

            <div class="padding-md">
                <div class="row">
                    <div class="col-md-12">



                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4><b>@lang('site_lables.Class_Booking_Report')</b></h4>

                                {{-- <button type="button" class="btn btn-primary btn-xs pull-right btnhideshow"><i
                                                                class="fa fa-plus"></i> @lang('site_lables.Add_New')</button> --}}
                            </div>
                            <div class="panel-body ">

                                <form id="master_form" name="master_form">
                                    @csrf
                                    <div class="form-group row">

                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>@lang('site_lables.From')*</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <div class="input-group date" data-provide="datepicker">
                                                    <input type="text"
                                                        class="form-control input-sm placeholdesize datepicker"
                                                        id="from" name="from" required>
                                                    <div class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>@lang('site_lables.To')*</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <div class="input-group date" data-provide="datepicker">
                                                    <input type="text"
                                                        class="form-control input-sm placeholdesize datepicker" id="to"
                                                        name="to" required>
                                                    <div class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>@lang('site_lables.Class')*</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <select name="class" id="class" class="form-control input-sm" required>
                                                    <option value="">All</option>
                                                    <option value="1">Class 1</option>
                                                    <option value="2">Class 2</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>@lang('site_lables.Instructor')*</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <select name="instructorid" id="instructorid"
                                                    class="form-control input-sm" required>
                                                    <option value="">All</option>
                                                    <option value="1">Instructor 1</option>
                                                    <option value="2">Instructor 2</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>@lang('site_lables.Member')*</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <select name="member_id" id="member_id"
                                                    class="form-control input-sm" required>
                                                    <option value="">All</option>
                                                    <option value="1">Member 1</option>
                                                    <option value="2">Member 2</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <button type="submit"
                                                    class="btn btn-success">@lang('site_lables.Search')</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <div class="table-responsive" id="show_master">
                                    <table class="table-striped" id="data_table" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>@lang('site_lables.Class_Name')</th>
                                                <th>@lang('site_lables.Schedule')</th>
                                                <th>@lang('site_lables.Instructor_Name')</th>
                                                <th>@lang('site_lables.Number_of_members_booked')</th>
                                                <th>@lang('site_lables.Max_vacancy')</th>


                                            </tr>
                                        </thead>
                                        <tbody id="table_tbody">
                                            {{--  <tr>
                                                <td>Class 5</td>
                                                <td>10:00</td>
                                                <td>ABCD</td>
                                                <td><a href="#">21</a></td>
                                                <td>10</td>

                                            </tr>  --}}




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
<script type="text/javascript">
    $(document).ready(function () {
    $.ajaxSetup({
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });

      // var getallcategory="{{ url('getallcategory') }}";

});

</script>


<script>
    {{--  $('#from #to').datepicker({
'todayHighlight': true,
format: 'dd/mm/yyyy',
autoclose: true,
});  --}}
var date = new Date();
date = date.toString('dd/MM/yyyy');

$("#from").val(date);
$("#to").val(date);

var getdata="{{ url('get_class_booking_report') }}";
</script>
 <script type='text/javascript' src="{{ URL::asset('/resources/js/myjs/class_booking_report.js',true) }}"></script>


</html>
