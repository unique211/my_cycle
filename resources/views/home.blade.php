@include('layout.headerlink')

<body class="overflow-hidden">

    {{-- header --}}
    @include('layout.header')
    <div id="wrapper" class="preload">
        {{-- sidebar --}}

        @include('layout.sidebar')
        <div id="main-container">
            <div id="breadcrumb">
                <ul class="breadcrumb">
                    <li><i class="fa fa-home"></i><a href="index.html"> @lang('site_lables.Home')</a></li>
                    <li class="active">@lang('site_lables.Dashboard')</li>
                </ul>
            </div><!-- /breadcrumb-->
            <div class="main-header clearfix">
                <div class="page-title">
                    <h3 class="no-margin">@lang('site_lables.Dashboard')</h3>

                </div><!-- /page-title -->
            </div><!-- /main-header -->

            <div class="padding-md">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4><b>@lang('site_lables.Upcoming_Booking_Details')</b></h4>

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
                                                <th><font style="font-weight:bold">@lang('site_lables.Class')</font></th>
                                                <th><font style="font-weight:bold">@lang('site_lables.Instructor')</font></th>
                                                <th><font style="font-weight:bold">@lang('site_lables.Number_of_Members')</font></th>
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


        <!--Modal-->
        <div class="modal fade" id="newFolder">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4>Create new folder</h4>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label for="folderName">Folder Name</label>
                                <input type="text" class="form-control input-sm" id="folderName"
                                    placeholder="Folder name here...">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-sm btn-success" data-dismiss="modal" aria-hidden="true">Close</button>
                        <a href="#" class="btn btn-danger btn-sm">Save changes</a>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </div><!-- /wrapper -->

    <a href="" id="scroll-to-top" class="hidden-print"><i class="fa fa-chevron-up"></i></a>


    @include('layout.footer')
    @include('layout.footerlink')
</body>
<script type='text/javascript' src="{{ URL::asset('/resources/js/myjs/dashboard.js')}}"></script>
</html>
