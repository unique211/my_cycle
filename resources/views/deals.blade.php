@include('layout.headerlink')


<body class="overflow-hidden">
    <!-- Overlay Div -->
    @include('layout.header')



    <div id="wrapper" class="preload">

        @include('layout.sidebar')
        <div id="main-container">
            <div id="breadcrumb">
                <ul class="breadcrumb">
                    <li><i class="fa fa-home"></i><a href="#"> @lang('site_lables.Home')/@lang('site_lables.Deals')</a></li>
                    <li class="active"></li>
                </ul>
            </div><!-- /breadcrumb-->

            <div class="padding-md">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4><b>@lang('site_lables.Deals')</b></h4>

                                {{-- <button type="button" class="btn btn-primary btn-xs pull-right btnhideshow"><i
                                        class="fa fa-plus"></i> @lang('site_lables.Add_New')</button> --}}
                            </div>
                            <div class="panel-body ">
                                <div class="row " id="documents">

                                    <form id="master_form" name="master_form">

                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>@lang('site_lables.Title')*</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <input type="text" id="deal_title" name="deal_title" class="form-control input-sm"
                                                    placeholder="@lang('site_lables.Title')">
                                            </div>
                                        </div>

                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>@lang('site_lables.Upload_Image_or_Video')*</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <input type="file" id="upload" class="form-control" name="upload" accept=".mp4,image/*" required>
                                                <input type="hidden" id="uploadimg_hidden" name="uploadimg_hidden" value="">
                                                <div id="msg" name="msg"></div>
                                                <div id="msg" name="msg"></div>
                                                <div id="wait" style="width:100px;height:100px;position:absolute;top:;left:45%;padding:2px;display:none"><img src="{{ env('APP_URL') }}/resources/sass/img/loader.gif" width="100" height="100" /><br><center><h5>Please Wait...</h5></center></div>
                                            </div>
                                            <br>
                                        </div>

                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>@lang('site_lables.Start_Date')*</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                    <div class='input-group datetimepicker' id='datetimepicker2'>
                                                            <input type='text' class="form-control" style="width:100%"
                                                                id="start_date" name="start_date" />
                                                            <div class="input-group-addon">
                                                                <span class="glyphicon glyphicon-calendar"></span>
                                                            </div>
                                                        </div>
                                                {{-- <div class="input-group date" data-provide="datepicker">
                                                    <input type="text"
                                                        class="form-control input-sm placeholdesize datepicker"
                                                        id="start_date" name="start_date" required>
                                                    <div class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </div>
                                                </div> --}}
                                            </div>
                                        </div>

                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>@lang('site_lables.End_Date')*</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">

                                                    <div class='input-group datetimepicker' id='datetimepicker2'>
                                                            <input type='text' class="form-control" style="width:100%"
                                                                id="end_date" name="end_date" />
                                                            <div class="input-group-addon">
                                                                <span class="glyphicon glyphicon-calendar"></span>
                                                            </div>
                                                        </div>
                                                {{-- <div class="input-group date" data-provide="datepicker">
                                                    <input type="text"
                                                        class="form-control input-sm placeholdesize datepicker"
                                                        id="end_date" name="end_date" required>
                                                    <div class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </div>
                                                </div> --}}
                                            </div>
                                        </div>






                                        <div class="col-lg-12">
                                            <div class="col-lg-10"></div>
                                            <div class="col-lg-2 " style="text-align: right">
                                                <input type="hidden" id="save_update" name="save_update" value="">

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


                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4><b>@lang('site_lables.Deals_List')</b></h4>

                                {{-- <button type="button" class="btn btn-primary btn-xs pull-right btnhideshow"><i
                                                                class="fa fa-plus"></i> @lang('site_lables.Add_New')</button> --}}
                            </div>
                            <div class="panel-body ">

                                <div class="table-responsive" id="show_master">
                                    <table class="table-striped" id="laravel_crud" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th><font style="font-weight:bold">@lang('site_lables.Title')</font></th>
                                                <th><font style="font-weight:bold"></font>@lang('site_lables.Start_Date')</th>
                                                <th><font style="font-weight:bold">@lang('site_lables.End_Date')</font></th>
                                                <th style="display:none;"><font style="font-weight:bold">@lang('site_lables.Upload_Img')</font></th>
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

      // var getallcategory="{{ url('getallcategory') }}";
       $("#data_table").DataTable();

});

</script>
<script>
    var uploadfileurl="{{ url('dealuploadimg') }}";
    var checkexistdealtitle="{{ url('checkdealtitle') }}";
    var add_data="{{route('deals.store') }}";
    var delete_data="{{ url('deletedeals') }}";
    $('.clockpicker').clockpicker();
        $('.datetimepicker').datetimepicker({

        format: 'DD/MM/YYYY HH:mm:ss',

        });
$('.date').datepicker({
'todayHighlight': true,
format: 'dd/mm/yyyy',
autoclose: true,
});

var date = new Date();
var date2 = new Date();
date = date.toString('dd/MM/yyyy HH:mm:ss');
date2.setMinutes(date2.getMinutes() + 5);
date2 = date2.toString('dd/MM/yyyy HH:mm:ss');

                    $("#end_date").val(date);
                    $("#start_date").val(date2);
</script>
<script type='text/javascript' src="{{ URL::asset('/resources/js/myjs/dealmaster.js',true) }}"></script>
</html>
