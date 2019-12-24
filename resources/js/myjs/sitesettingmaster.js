$(document).ready(function() {


    validate = 1;


    //for submite of from inserting or updating Recored  --------Start
    $(document).on('submit', '#master_form', function(e) {
        e.preventDefault();

        $('#classcategory_name').trigger('blur');

        var status = 0;
        if ($('#status').is(":checked")) {
            status = 1;
        } else {
            status = 0;
        }

        $('#statusinfo').val(status);

        $.ajax({
            data: $('#master_form').serialize(),
            url: add_data,
            type: "POST",
            dataType: 'json',
            success: function(data) {

                if (data == '100') {
                    swal({
                        title: "Site Name  Exist",
                        text: "Please Enter Another Site Name  !!",
                        type: "warning",
                    });
                } else if (data == '101') {
                    swal({
                        title: "Email Exist",
                        text: "Please Enter Another Email  !!",
                        type: "warning",
                    });
                } else {
                    datashow();
                    $(".tablehideshow").show();
                    $(".formhideshow").hide();
                    successTost("Opration Save Success fully!!!");

                    from_clear();
                }



            },
            error: function(data) {
                console.log('Error:', data);

            }
        });


    });
    //for submite of from inserting or updating Recored  --------Start

    // datashow();

    //form clear ------Strat
    function from_clear() {

        $('#save_update').val('');
        $('#statusinfo').val('');
        $('#btnsave').text('Save');
        $('#status').bootstrapToggle('on');
        $("#upload").attr("required", true);



        $('#site_name').val('');
        $('#uploadimg_hidden').val('');
        $('#msg').html('');
        $('#email').val('');
        $('#profileimg').attr('src', imgurl + 'resources/sass/img/no-image-available.png');


        $('#about_us').val('');
        $('#about_us_c').val('');
        $('#contact_us').val('');
        $('#contact_us_c').val('');
        $('#tel_no').val('');
        $('#website').val('');
        $('#facebook').val('');
        $('#instagram').val('');
        $('#firebase').val('');
        $('#map').val('');
        $('#save_update').val('');



    }
    //form clear ------End
    datashow();
    //for desplay in table with data toggel Buttton------Strat
    function datashow() {
        if ($.fn.DataTable.isDataTable('#laravel_crud')) {
            $('#laravel_crud').DataTable().destroy();
        }
        $('#laravel_crud tbody').empty();

        $.get('getallsitesettinginfo', function(data) {

            var data = eval(data);
            var html = '';

            for (var i = 0; i < data.length; i++) {
                var sr = i + 1;
                var st = data[i].status;
                var chehc = "";
                var about1 = "";
                var about2 = "";
                var contact1 = "";
                var contact2 = "";

                if (data[i].site_about_details1 != null) {
                    about1 = data[i].site_about_details1;
                } else {
                    about1 = "";
                }
                if (data[i].site_about_details2 != null) {
                    about2 = data[i].site_about_details2;
                } else {
                    about2 = "";
                }
                if (data[i].site_contact_detalis1 != null) {
                    contact1 = data[i].site_contact_detalis1;
                } else {
                    contact1 = "";
                }
                if (data[i].site_contact_detalis2 != null) {
                    contact2 = data[i].site_contact_detalis2;
                } else {
                    contact2 = "";
                }


                html += '<tr>' +
                    '<td id="site_name_' + data[i].sitesetting_id + '">' + data[i].site_name + '</td>' +
                    '<td id="packagepoint_' + data[i].sitesetting_id + '"> <img src="' + imgurl + '/uploads/' + data[i].site_logo + '"  style="width:50px; height: 50px; "></td>' +
                    '<td id="site_email_' + data[i].sitesetting_id + '">' + data[i].site_email + '</td>' +

                    '<td style="display:none;" id="sitelogo_' + data[i].sitesetting_id + '">' + data[i].site_logo + '</td>' +
                    '<td style="display:none;" id="about_details1_' + data[i].sitesetting_id + '">' + about1 + '</td>' +
                    '<td style="display:none;" id="about_details2_' + data[i].sitesetting_id + '">' + about2 + '</td>' +
                    '<td style="display:none;" id="site_contact_detalis1_' + data[i].sitesetting_id + '">' + contact1 + '</td>' +
                    '<td style="display:none;" id="site_contact_detalis2_' + data[i].sitesetting_id + '">' + contact2 + '</td>' +
                    '<td style="display:none;" id="telephone_no_' + data[i].sitesetting_id + '">' + data[i].telephone_no + '</td>' +
                    '<td style="display:none;" id="website_' + data[i].sitesetting_id + '">' + data[i].website + '</td>' +
                    '<td style="display:none;" id="facebook_' + data[i].sitesetting_id + '">' + data[i].facebook + '</td>' +
                    '<td style="display:none;" id="instagram_' + data[i].sitesetting_id + '">' + data[i].instagram + '</td>' +
                    '<td style="display:none;" id="firebase_' + data[i].sitesetting_id + '">' + data[i].firebase + '</td>' +
                    '<td style="display:none;" id="map_' + data[i].sitesetting_id + '">' + data[i].map + '</td>' +


                    '<td class="not-export-column" ><button name="edit"  value="edit" class="edit_data btn btn-xs btn-success" id=' +
                    data[i].sitesetting_id +
                    '  status=' + data[i].status + '><i class="fa fa-edit"></i></button>&nbsp;<button name="delete" value="Delete" class="delete_data btn btn-xs btn-danger" id=' +
                    data[i].sitesetting_id + '><i class="fa fa-trash"></i></button></td>' + '</tr>';




            }

            $('#table_tbody').html(html);
            $('#laravel_crud').DataTable({

            });


        })

    }
    //for desplay in table with data toggel Buttton------End

    //Edit Button Code Strat Here
    $(document).on('click', ".edit_data", function(e) {
        e.preventDefault();

        $(".tablehideshow").hide();
        $(".formhideshow").show();

        var id = $(this).attr("id");
        var status = $(this).attr("status");
        var site_name = $('#site_name_' + id).html();
        var site_email = $('#site_email_' + id).html();
        var sitelogo = $('#sitelogo_' + id).html();
        var about_details1 = $('#about_details1_' + id).html();
        var about_details2 = $('#about_details2_' + id).html();
        var site_contact_detalis1 = $('#site_contact_detalis1_' + id).html();
        var site_contact_detalis2 = $('#site_contact_detalis2_' + id).html();
        var telephone_no = $('#telephone_no_' + id).html();
        var website = $('#website_' + id).html();
        var facebook = $('#facebook_' + id).html();
        var instagram = $('#instagram_' + id).html();
        var firebase = $('#firebase_' + id).html();
        var map = $('#map_' + id).html();


        if (sitelogo == "") {
            $("#upload").attr("required", true);
        } else {
            $("#upload").removeAttr("required");
        }


        $('#site_name').val(site_name);
        $('#uploadimg_hidden').val(sitelogo);
        $('#msg').html(sitelogo);
        $('#email').val(site_email);
        $('#profileimg').attr('src', imgurl + '/uploads/' + sitelogo);


        $('#about_us').val(about_details1);
        $('#about_us_c').text(about_details2);
        $('#contact_us').text(site_contact_detalis1);
        $('#contact_us_c').text(site_contact_detalis2);
        $('#tel_no').val(telephone_no);
        $('#website').val(website);
        $('#facebook').val(facebook);
        $('#instagram').val(instagram);
        $('#firebase').val(firebase);
        $('#map').val(map);
        $('#save_update').val(id);
        $('#statusinfo').val(status);
        $('#btnsave').text('Update');

        // CKEDITOR.instances.editor1.setData('<p>This is the editor data.</p>');

        $("about_us_c#blogcontent").val(about_details2);




    });
    //Edit Button Code End  Here------


    //Delete  Button Code Strat  Here------

    $(document).on('click', '.delete_data', function() {
        var id1 = $(this).attr('id');

        if (id1 != "") {
            swal({
                    title: "Are you sure to delete ?",
                    text: "You will not be able to recover this Data !!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, delete it !!",
                    closeOnConfirm: false
                },
                function() {
                    $.ajax({
                        type: "GET",
                        url: delete_data + '/' + id1,
                        success: function(data) {

                            if (data == true) {
                                swal("Deleted !!", "Hey, your Data has been deleted !!", "success");
                                $('.closehideshow').trigger('click');
                                $('#save_update').val("");
                                datashow(); //call function show all data
                            } else {
                                errorTost("Data Delete Failed");
                            }

                        },
                        error: function(data) {
                            console.log('Error:', data);
                        }
                    });


                    return false;
                });
        }
    });

    //Delete  Button Code Strat  Here------

    $(document).on('change', '.btnstatus', function() {
        var id = $(this).attr('id');

        var status = "";

        if ($('#' + id).is(":checked")) {
            status = 1;
        } else {
            status = 0;
        }

        id = id.split("_");
        swal({
                title: "Are you sure Change Status ?",

                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes",
                closeOnConfirm: false
            },
            function() {
                $.ajax({
                    type: "GET",
                    url: changestatus + '/' + id[1] + "/" +
                        status,
                    success: function(data) {

                        if (data == 100) {
                            swal({
                                title: "Class Category  Exist In Class Module Please Deacive First",

                                type: "warning",
                            });
                            datashow();

                        } else {
                            $('.cancel').trigger('click');
                            datashow(); //call function show all data
                        }

                    },
                    error: function(data) {
                        console.log('Error:', data);
                    }
                });


                return false;
            });


    });
    $(document).on('click', '.cancel', function() {
        datashow();
    });

    //blur Event of Category Name
    $(document).on('blur', '#classcategory_name', function() {
        var catname = $('#classcategory_name').val();
        var save_update = $('#save_update').val();


        if (save_update == "") {
            url = checkcategory + "/" + catname;


            $.ajax({
                url: url,
                type: "GET",

                contentType: false,
                cache: false,
                processData: false,
                dataType: "json",
                success: function(data) {

                    if (data > 0) {
                        swal({
                            title: "Class Category  Exist",
                            text: "Please Enter Another Class Category!!",
                            type: "warning",
                        });
                        validate = 0;
                    } else {
                        validate = 1;
                    }
                }
            });
        }

        // $.ajax({
        //     type: "GET",
        //     url: url,
        //     success: function(data) {



        //     },
        //     error: function(data) {
        //         console.log('Error:', data);
        //     }
        // });
    });

    //click Event of  Button cancle
    $(document).on('click', ".closehideshow", function(e) {
        e.preventDefault();

        from_clear();
    });

    $('#upload').change(function() {
        var id = $(this).attr('id');




        if ($(this).val() != '') {
            upload(this, id);

        }
    });

    function upload(img, id) {

        var form_data = new FormData();
        form_data.append('file', img.files[0]);

        $.ajax({
            url: uploadfileurl,
            data: form_data,
            type: 'POST',
            contentType: false,
            processData: false,
            success: function(data) {
                //alert(data);


                $('#msg').html(data);
                $('#uploadimg_hidden').val(data);
                $('#profileimg').attr('src', imgurl + '/uploads/' + data);
                $("#upload").removeAttr("required");

            }
        });
    }

});