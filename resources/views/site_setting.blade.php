@include('layout.headerlink')


<body class="overflow-hidden">
    {{-- Overlay Div --}}
    @include('layout.header')



    <div id="wrapper" class="preload">

        @include('layout.sidebar')
        <div id="main-container">
            <div id="breadcrumb">
                <ul class="breadcrumb">
                    <li><i class="fa fa-home"></i><a href="#">
                            @lang('site_lables.Home')/@lang('site_lables.Site_Setting')</a></li>
                    <li class="active"></li>
                </ul>
            </div>{{-- /breadcrumb--}}

            <div class="padding-md">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default formhideshow">
                            <div class="panel-heading">
                                <h4><b>@lang('site_lables.Site_Setting')</b></h4>

                                <button type="button" class="btn btn-primary btn-xs pull-right closehideshow"><i
                                        class="fa fa-plus"></i>@lang('site_lables.View_All')</button>
                            </div>
                            <div class="panel-body ">
                                <div class="row " id="documents">

                                    <form id="master_form" name="master_form">
                                        <div class="col-lg-6">
                                            <div class="row form-group">
                                                <div class="col-sm-4">

                                                    <label>@lang('site_lables.Site_Name')*</label>

                                                </div>
                                                <div class="col-sm-8">

                                                    <input type="text" class="form-control input-sm placeholdesize"
                                                        placeholder="@lang('site_lables.Site_Name')" id="site_name"
                                                        name="site_name" required>

                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-sm-4">

                                                    <label>@lang('site_lables.Logo')*</label>

                                                </div>
                                                <div class="col-sm-8">


                                                    <input type="file" id="upload" name="upload" class="form-control"
                                                        accept="image/*" required>
                                                    <input type="hidden" id="uploadimg_hidden" name="uploadimg_hidden"
                                                        value="">
                                                    <div id="msg" name="msg"></div>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-sm-4">

                                                    <label>@lang('site_lables.Email_Address')*</label>

                                                </div>
                                                <div class="col-sm-8">

                                                    <input type="email" class="form-control input-sm placeholdesize"
                                                        placeholder="@lang('site_lables.Email_Address')" id="email"
                                                        name="email" required>

                                                </div>
                                            </div>


                                        </div>
                                        <div class="col-lg-6 ">
                                            <img id="profileimg"
                                                src="{{ URL::asset('/resources/sass/img/no-image-available.png') }}"
                                                alt="User Avatar" style="width:100px; height: 100px; float:right;">
                                            <br>
                                        </div>
                                        <div class="col-lg-12 ">
                                            <div class="row form-group">
                                                <div class="col-sm-2">

                                                    <label>@lang('site_lables.About_Us')</label>

                                                </div>
                                                <div class="col-sm-5">
                                                    <label>@lang('site_lables.English_Text')</label>
                                                    <textarea name="about_us" id="about_us"
                                                        placeholder="@lang('site_lables.About_Us')"
                                                        class="form-control input-sm" rows="3"></textarea>

                                                </div>
                                                <div class="col-sm-5">
                                                    <label>@lang('site_lables.Chinese_Text')</label>
                                                    <textarea name="about_us_c" id="about_us_c"
                                                        placeholder="@lang('site_lables.About_Us')"
                                                        class="form-control input-sm" rows="3"></textarea>

                                                </div>
                                            </div>

                                            <div class="row form-group">
                                                <div class="col-sm-2">

                                                    <label>@lang('site_lables.Contact_Us')</label>

                                                </div>
                                                <div class="col-sm-5">
                                                    <label>@lang('site_lables.English_Text')</label>
                                                    <textarea name="contact_us" id="contact_us"
                                                        placeholder="@lang('site_lables.Contact_Us')"
                                                        class="form-control input-sm" rows="3"></textarea>

                                                </div>
                                                <div class="col-sm-5">
                                                    <label>@lang('site_lables.Chinese_Text')</label>
                                                    <textarea name="contact_us_c" id="contact_us_c"
                                                        placeholder="@lang('site_lables.Contact_Us')"
                                                        class="form-control input-sm" rows="3"></textarea>

                                                </div>
                                            </div>

                                            <div class="row form-group">
                                                <div class="col-sm-2">

                                                    <label>@lang('site_lables.Telephone_No').*</label>

                                                </div>
                                                <div class="col-sm-4">
                                                    <input type="number" class="form-control input-sm placeholdesize"
                                                        placeholder="@lang('site_lables.Telephone_No')." id="tel_no"
                                                        name="tel_no" required>

                                                </div>
                                                <div class="col-sm-2">

                                                    <label>@lang('site_lables.Website')*</label>

                                                </div>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control input-sm placeholdesize"
                                                        placeholder="@lang('site_lables.Website')" id="website"
                                                        name="website" required>

                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-sm-2">

                                                    <label>@lang('site_lables.Facebook')*</label>

                                                </div>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control input-sm placeholdesize"
                                                        placeholder="@lang('site_lables.Facebook')" id="facebook"
                                                        name="facebook" required>

                                                </div>
                                                <div class="col-sm-2">

                                                    <label>@lang('site_lables.Instagram')*</label>

                                                </div>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control input-sm placeholdesize"
                                                        placeholder="@lang('site_lables.Instagram')" id="instagram"
                                                        name="instagram" required>

                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-sm-2">

                                                    <label>@lang('site_lables.Firebase')*</label>

                                                </div>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control input-sm placeholdesize"
                                                        placeholder="@lang('site_lables.Firebase')" id="firebase"
                                                        name="firebase" required>

                                                </div>
                                                <div class="col-sm-2">

                                                    <label>@lang('site_lables.Map')</label>

                                                </div>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control input-sm placeholdesize"
                                                        placeholder="@lang('site_lables.Map')" id="map" name="map">

                                                </div>
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

                            </div>{{-- /panel --}}
                        </div>{{-- /panel --}}


                        <div class="panel panel-default tablehideshow">
                            <div class="panel-heading">
                                <h4><b>@lang('site_lables.Site_Setting')</b></h4>
                                <button type="button" class="btn btn-primary btn-xs pull-right btnhideshow"><i
                                        class="fa fa-plus"></i>@lang('site_lables.Add_New')</button>

                            </div>
                            <div class="panel-body ">

                                <div class="table-responsive" id="show_master">
                                    <table class="table-striped" id="laravel_crud" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th><font style="font-weight:bold">@lang('site_lables.Site_Name')</font></th>
                                                <th><font style="font-weight:bold">@lang('site_lables.Logo')</font></th>
                                                <th><font style="font-weight:bold">@lang('site_lables.Email_Address')</font></th>
                                                <th style="display:none;"><font style="font-weight:bold;">@lang('site_lables.Img_Url')</font></th>
                                                <th  style="display:none;"><font style="font-weight:bold;">@lang('site_lables.About_Us_1')</font></th>
                                                <th  style="display:none;"><font style="font-weight:bold;">@lang('site_lables.About_Us_2')</font></th>
                                                <th  style="display:none;"><font style="font-weight:bold;">@lang('site_lables.Contact_Us_1')</font></th>
                                                <th  style="display:none;"><font style="font-weight:bold;display:none;">@lang('site_lables.Contact_Us_2')</font></th>
                                                <th  style="display:none;"><font style="font-weight:bold;display:none;">@lang('site_lables.Telephone_No')</font></th>
                                                <th  style="display:none;"><font style="font-weight:bold;display:none;">@lang('site_lables.Website')</font></th>
                                                <th  style="display:none;"><font style="font-weight:bold;display:none;">@lang('site_lables.Facebook')</font></th>
                                                <th  style="display:none;"><font style="font-weight:bold;display:none;">@lang('site_lables.Instagram')</font></th>
                                                <th  style="display:none;"><font style="font-weight:bold;display:none;">@lang('site_lables.Firebase')</font></th>
                                                <th  style="display:none;"><font style="font-weight:bold;display:none;">@lang('site_lables.Map')</font></th>
                                                <th class="not-export-column"><font style="font-weight:bold">@lang('site_lables.Action')</font>   </th>

                                            </tr>
                                        </thead>
                                        <tbody id="table_tbody">


                                        </tbody>
                                    </table>
                                </div>








                            </div>
                        </div>
                    </div>




                </div>
            </div>{{-- /.padding-md --}}
        </div>{{--   /main-container --}}

        @include('layout.footer')


    </div>{{-- /wrapper --}}

    <a href="" id="scroll-to-top" class="hidden-print"><i class="fa fa-chevron-up"></i></a>


    {{-- Logout confirmation --}}

    {{-- Le javascript ================================================== --}}
    {{-- Placed at the end of the document so the pages load faster --}}

    @include('layout.footerlink')

</body>
<script>
    CKEDITOR.replace( 'about_us' );
    CKEDITOR.replace( 'contact_us' );
    CKEDITOR.replace( 'about_us_c' );
    CKEDITOR.replace( 'contact_us_c' );
</script>
<script type="text/javascript">
    $(document).ready(function () {
    $.ajaxSetup({
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });

});

</script>
<script>
    var add_data="{{route('site_setting.store') }}";
    var checkcategory="{{ url('checksitename') }}";
    var delete_data="{{ url('deletesitesetting') }}";
    var changestatus="{{ url('roomchangestatus') }}";
    var uploadfileurl="{{ url('instrucoruploadimg') }}";
    var imgurl="<?php  echo url('/') ?>";
    $("#data_table").DataTable();
</script>
<script type='text/javascript' src="{{ URL::asset('/resources/js/myjs/sitesettingmaster.js',true) }}"></script>

</html>
