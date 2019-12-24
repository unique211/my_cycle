@include('layout.headerlink')


<body class="overflow-hidden">
    <!-- Overlay Div -->
    @include('layout.header')



    <div id="wrapper" class="preload">

        @include('layout.sidebar')
        <div id="main-container">
            <div id="breadcrumb">
                <ul class="breadcrumb">
                    <li><i class="fa fa-home"></i><a href="#"> @lang('site_lables.Home')/@lang('site_lables.Language')</a></li>
                    <li class="active"></li>
                </ul>
            </div><!-- /breadcrumb-->

            <div class="padding-md">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4><b>@lang('site_lables.Language')</b> (<?php echo $val=Session::get('locale');?>)</h4>

                                {{-- <button type="button" class="btn btn-primary btn-xs pull-right btnhideshow"><i
                                        class="fa fa-plus"></i> @lang('site_lables.Add_New')</button> --}}
                            </div>
                            <div class="panel-body ">
                                <div class="row " id="documents">

                                    <form id="master_form" name="master_form" action="{{ url('change_lang') }}"
                                        method="POST">
                                        @csrf
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>@lang('site_lables.Select') @lang('site_lables.Language')*</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <select class="form-control" id="languages" name="languages"
                                                    onchange="this.form.submit()">
                                                    <option value="0" selected disabled>@lang('site_lables.Select') @lang('site_lables.Language')</option>
                                                    <option value="zh" <?php if($val!=null){ if($val=="zh"){?> selected
                                                        <?php }}?>>Chinese</option>
                                                    <option value="en" <?php if($val!=null){ if($val=="en"){?> selected
                                                    <?php }}if($val==""){ ?>selected <?php }?>>English</option>
                                                </select>
                                            </div>
                                        </div>









                                        {{-- <div class="col-lg-12">
                                            <div class="col-lg-10"></div>
                                            <div class="col-lg-2 " style="text-align: right">
                                                <input type="hidden" id="save_update" value="">

                                                <button type="submit"
                                                    class="btn btn-sm btn-success btn-sm ">Save</button>

                                                <button type="button"
                                                    class="btn btn-sm btn-info  closehideshow">Close</button>
                                            </div>

                                        </div> --}}

                                    </form>
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
<script type='text/javascript'>
    $("#data_table").DataTable();

</script>

<script type='text/javascript'>
    $(document).ready(function() {
        $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });
        $(document).on('change', '#languages', function() {

            var languages=$('#languages').val();

$("#master_form").trigger('submit');

            {{-- $.ajax({
            data:{
                languages:languages,
            },
            url: "{{ url('change_lang') }}",
            type: "POST",
            dataType: 'json',
            success: function(data) {
                alert("ds");
            }
            }); --}}


        });
  });

</script>

</html>
