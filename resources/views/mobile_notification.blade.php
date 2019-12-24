@include('layout.headerlink')


<body class="overflow-hidden">
    <!-- Overlay Div -->
    @include('layout.header')



    <div id="wrapper" class="preload">

        @include('layout.sidebar')
        <div id="main-container">
            <div id="breadcrumb">
                <ul class="breadcrumb">
                    <li><i class="fa fa-home"></i><a href="#"> @lang('site_lables.Home')/@lang('site_lables.Mobile_Notification')</a></li>
                    <li class="active"></li>
                </ul>
            </div><!-- /breadcrumb-->

            <div class="padding-md">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4><b>@lang('site_lables.Mobile_Notification')</b></h4>

                                {{-- <button type="button" class="btn btn-primary btn-xs pull-right btnhideshow"><i
                                        class="fa fa-plus"></i> @lang('site_lables.Add_New')</button> --}}
                            </div>
                            <div class="panel-body ">
                                <div class="row " id="documents">

                                    <form id="master_form" name="master_form">
                                        @csrf
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>@lang('site_lables.Notification_Text')*</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-10">
                                            <div class="form-group">

                                                <textarea name="notification" id="notification" placeholder="@lang('site_lables.Notification_Text')" class="form-control" style="resize: none;" required></textarea>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div style="margin-top:0px;border-bottom:2px solid;width:100%;">
                                                <h4 class="modal-title"> @lang('site_lables.Members')</h4>
                                            </div>

                                            <div class="table-responsive">
                                                <br>
                                                <table class="table table-striped" id="member_table" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 10%"><input type="checkbox" id="select_all" name="select_all" value="0"> @lang('site_lables.Select_All')</th>
                                                            <th> @lang('site_lables.User_Id')</th>
                                                            <th>@lang('site_lables.Member_Name')</th>
                                                        </tr>
                                                    </thead>
                                                     <tbody id="tbd_user_rights">

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="col-lg-10"></div>
                                            <div class="col-lg-2 " style="text-align: right">
                                                <input type="hidden" id="save_update" value="">

                                                <button type="submit"
                                                    class="btn btn-sm btn-success btn-sm ">@lang('site_lables.Send')</button>

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
                                <h4><b>@lang('site_lables.Class_List')</b></h4>

                                {{-- <button type="button" class="btn btn-primary btn-xs pull-right btnhideshow"><i
                                                                class="fa fa-plus"></i> @lang('site_lables.Add_New')</button> --}}
                            </div>
                            <div class="panel-body ">

                                <div class="table-responsive" id="show_master">
                                    <table class="table-striped" id="laravel_crud" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th><font style="font-weight:bold">@lang('site_lables.Sr.No.')</font></th>
                                                <th><font style="font-weight:bold">@lang('site_lables.Date_&_Time')</font></th>
                                                <th><font style="font-weight:bold">@lang('site_lables.Notification')</font></th>
                                                <th ><font style="font-weight:bold;">@lang('site_lables.Total_Members')</font></th>


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
var add_data="{{route('mobile_notification.store') }}";

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
<script type='text/javascript' src="{{ URL::asset('/resources/js/myjs/mobile_notifications.js',true) }}">
</script>

</html>
