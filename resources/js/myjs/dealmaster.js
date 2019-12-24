$(document).ready(function() {


    validate = 1;


    //for submite of from inserting or updating Recored  --------Start
    $(document).on('submit', '#master_form', function(e) {
        e.preventDefault();
        $('#deal_title').trigger('blur');

        var stratdate = $('#start_date').val();
        var enddate = $('#end_date').val();
        var save_update = $('#save_update').val();


        var classsh = '';
        var mintime = '';

        if (save_update == "") {
            classsh = checktime(stratdate);
            mintime = mincanclatontime(stratdate, enddate);
        } else {
            classsh = 1;
            mintime = 1;
        }
        if (classsh == 1 && mintime == 1) {
            $.ajax({
                data: $('#master_form').serialize(),
                url: add_data,
                type: "POST",
                dataType: 'json',
                success: function(data) {
                    if (data == '100') {
                        swal({
                            title: "Title already Exist",
                            text: "Please Enter Another Title  !!",
                            type: "warning",
                        });
                    } else {
                        datashow();

                        successTost("Opration Save Success fully!!!");

                        from_clear();
                    }




                },
                error: function(data) {
                    console.log('Error:', data);

                }
            });
        } else {

            swal('Start Date Time is always greater then Current Time & End Date Time is always greater then Start Date Time!!!');

        }




    });
    //for submite of from inserting or updating Recored  --------Start

    datashow();

    //form clear ------Strat
    function from_clear() {
        $('#deal_title').val('');
        $('#msg').html('');
        $('#uploadimg_hidden').html('');
        $('#upload').val('');

        $('#save_update').val('');
        $('#statusinfo').val('');
        var date = new Date();
        var date2 = new Date();
        date = date.toString('dd/MM/yyyy HH:mm:ss');
        date2.setMinutes(date2.getMinutes() + 5);
        date2 = date2.toString('dd/MM/yyyy HH:mm:ss');

        $("#end_date").val(date);
        $("#start_date").val(date2);
        $("#upload").attr("required", true);
        $('#btnsave').text('Save');
    }
    //form clear ------End
    //datashow();
    //for desplay in table with data toggel Buttton------Strat
    function datashow() {
        if ($.fn.DataTable.isDataTable('#laravel_crud')) {
            $('#laravel_crud').DataTable().destroy();
        }
        $('#laravel_crud tbody').empty();

        $.get('getalldeal', function(data) {
            var startdate = "";
            var end_date = "";
            var data = eval(data);
            var html = '';

            for (var i = 0; i < data.length; i++) {
                var sr = i + 1;

                var date = data[i].start_date;
                var fdateslt = date.split('-');
                var time = fdateslt[2].split(' ');
                startdate = time[0] + '/' + fdateslt[1] + '/' + fdateslt[0] + ' ' + time[1];


                var date = data[i].end_date;
                var fdateslt = date.split('-');
                var time = fdateslt[2].split(' ');
                end_date = time[0] + '/' + fdateslt[1] + '/' + fdateslt[0] + ' ' + time[1];


                html += '<tr>' +

                    '<td id="deal_title_' + data[i].deal_id + '">' + data[i].deal_title + '</td>' +
                    '<td id="startdate_' + data[i].deal_id + '">' + startdate + '</td>' +
                    '<td id="end_date_' + data[i].deal_id + '">' + end_date + '</td>' +
                    '<td style="display:none;" id="uploadimg_' + data[i].deal_id + '">' + data[i].upload_img + '</td>' +

                    '<td class="not-export-column" ><button name="edit"  value="edit" class="edit_data btn btn-xs btn-success" id=' +
                    data[i].deal_id +
                    '><i class="fa fa-edit"></i></button>&nbsp;<button name="delete" value="Delete" class="delete_data btn btn-xs btn-danger" id=' +
                    data[i].deal_id + '><i class="fa fa-trash"></i></button></td>' + '</tr>';


            }

            $('#table_tbody').html(html);
            $('#laravel_crud').DataTable({});


        })

    }
    //for desplay in table with data toggel Buttton------End

    //Edit Button Code Strat Here
    $(document).on('click', ".edit_data", function(e) {
        e.preventDefault();

        var id = $(this).attr("id");


        var deal_title = $('#deal_title_' + id).html();
        var startdate = $('#startdate_' + id).html();
        var end_date = $('#end_date_' + id).html();
        var uploadimg = $('#uploadimg_' + id).html();

        if (uploadimg == "") {
            $("#upload").attr("required", true);
        } else {
            $("#upload").removeAttr("required");
        }


        $('#deal_title').val(deal_title);
        $('#uploadimg_hidden').val(uploadimg);
        $('#msg').html(uploadimg);
        $('#start_date').val(startdate);
        $('#end_date').val(end_date);
        $('#save_update').val(id);
        $('#btnsave').text('Update');




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



    //blur Event of room
    $(document).on('blur', '#deal_title', function() {
        var deal_title = $('#deal_title').val();
        var save_update = $('#save_update').val();
        var url = "";

        if (save_update == "") {
            url = checkexistdealtitle + "/" + deal_title;
        } else {
            url = checkexistdealtitle + "/" + deal_title + "/" + save_update;
        }
        if (save_update == "") {
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
                            title: "Title already Exist",
                            text: "Please Enter Another Title!!",
                            type: "warning",
                        });
                        validate = 0;
                    } else {
                        validate = 1;
                    }
                }
            });
        }


    });

    $('#upload').change(function() {
        var id = $(this).attr('id');



        if ($(this).val() != '') {
            upload(this, id);

        }
    });

    function upload(img, id) {
        $("#wait").show();
        var form_data = new FormData();
        form_data.append('file', img.files[0]);
        //form_data.append('_token', '{{csrf_token()}}');

        $.ajax({
            url: uploadfileurl,
            data: form_data,
            type: 'POST',
            contentType: false,
            processData: false,
            success: function(data) {
                //alert(data);

                // $('#upload').val('');
                $('#msg').html(data);
                $('#uploadimg_hidden').val(data);
                $("#wait").hide();

            }
        });
    }

    //blur event of  class sechedule
    $(document).on('blur', '#start_date', function() {
        var class_schedule = $('#start_date').val();
        var checktime1 = checktime(class_schedule);
        if (checktime1 == 0) {
            swal({
                title: "Start Date Time is always greater then Current Time !!!",

            });
        }

    });

    //blur event of  class sechedule
    $(document).on('blur', '#end_date', function() {
        var enddate = $('#end_date').val();
        var stratdate = $('#start_date').val();
        var checktime1 = mincanclatontime(stratdate, enddate);
        if (checktime1 == 0) {
            swal({
                title: "End Date Time is always greater then Start Date Time !!!",

            });
        }

    });



    //function for checking time to current time
    function checktime(class_schedule) {


        var date = class_schedule;
        var fdateslt = date.split('/');
        var time = fdateslt[2].split(' ');
        var checkouttime = time[0] + '/' + fdateslt[1] + '/' + fdateslt[0];
        var usrDate = time[0] + '/' + fdateslt[1] + '/' + fdateslt[0] + ' ' + time[1];

        currentDate = new Date(); //system current date
        currentMonth = currentDate.getMonth() + 1;
        currentDay = currentDate.getDate();
        currentYear = currentDate.getFullYear();
        currentHours = currentDate.getHours();
        currentMinutes = currentDate.getMinutes();
        currentSeconds = currentDate.getSeconds();



        currentcpDateTime = currentMonth + "/" + currentDay + "/" + currentYear + " " + currentHours + ":" + currentMinutes + ":" + currentSeconds;

        if (Date.parse(usrDate) > Date.parse(currentcpDateTime)) {
            return 1;
        } else {
            return 0;
        }



    }

    //End Date time check
    function mincanclatontime(class_schedule, min_cancelation) {



        if (Date.parse(min_cancelation) > Date.parse(class_schedule)) {
            return 1;
        } else {
            return 0;
        }



    }

    //
    $(document).on('click', ".closehideshow", function(e) {
        e.preventDefault();

        from_clear();
    });

});