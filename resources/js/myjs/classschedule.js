$(document).ready(function() {


    validate = 1;

    var menu = 9;
    var rights = 1;
    user_access_rights();

    function user_access_rights() {

        $(".btnhideshow").show();
        $(".formhideshow").show();
        $(':input[type="submit"]').show();
        $.ajax({
            type: "POST",
            url: 'get_current_rights/' + menu,
            dataType: "JSON",
            async: false,
            success: function(data) {

                if (data == 0 || data == "0") {
                    $(".btnhideshow").hide();
                    $(".formhideshow").hide();
                    $(':input[type="submit"]').hide();
                    rights = 0;
                } else {
                    $(".btnhideshow").show();
                    $(".formhideshow").show();
                    $(':input[type="submit"]').show();
                    rights = 1;
                }
            }
        });
    }


    var date = new Date();
    var date2 = new Date();


    date = date.toString('dd/MM/yyyy HH:mm:ss');


    date2.setMinutes(date2.getMinutes() + 5);

    date2 = date2.toString('dd/MM/yyyy HH:mm:ss');

    $("#class_schedule").val(date2);
    $("#min_cancelation").val(date);
    $("#min_booking").val(date);
    //for submite of from inserting or updating Recored  --------Start
    $(document).on('submit', '#master_form', function(e) {
        e.preventDefault();
        var class_schedule = $('#class_schedule').val();
        var min_cancelation = $('#min_cancelation').val();
        var min_booking = $('#min_booking').val();
        var classsh = checktime(class_schedule);
        var mintime = checktime(min_cancelation);
        // var mintime = mincanclatontime(class_schedule, min_cancelation);
        var minbooktime = checktime(min_booking);
        //var minbooktime = mincanclatontime(class_schedule, min_booking);
        var class_duration = $('#class_duration').val();
        var max_vacancy = $('#max_vacancy').val();
        console.log("classsh" + classsh + "mintime" + mintime + "minbooktime" + minbooktime);

        if (class_duration > 0 && max_vacancy > 0) {

            if (classsh == 1 && mintime == 1 && minbooktime == 1) {

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


                        datashow();

                        successTost("Opration Save Success fully!!!");

                        from_clear();


                    },
                    error: function(data) {
                        console.log('Error:', data);

                    }
                });
            } else {
                swal('Min Cancelation Time,Min Booking Time And Class Schedule Time is Always Greater then Current Time !!!');
            }
        } else {
            swal('Class Duration (In Minutes) And Max Vacancy Greater Zero');
        }


    });
    //for submite of from inserting or updating Recored  --------Start

    // datashow();

    //form clear ------Strat
    function from_clear() {
        $('#room').val('');

        $('#save_update').val('');
        $('#statusinfo').val('');
        $('#classsechedule_name').val('').trigger('change');

        $('#instructorid').val('').trigger('change');
        $('#max_vacancy').val('');
        $('#class_duration').val('');
        $('#room_id').val('').trigger('change');
        // $('#class_schedule').val('');
        // $('#min_cancelation').val('');
        // $('#min_booking').val('');
        $('#classendtime').val('');
        $('#status').bootstrapToggle('on');

        var date = new Date();
        var date2 = new Date();


        date = date.toString('dd/MM/yyyy HH:mm:ss');


        date2.setMinutes(date2.getMinutes() + 5);

        date2 = date2.toString('dd/MM/yyyy HH:mm:ss');

        $("#class_schedule").val(date2);
        $("#min_cancelation").val(date);
        $("#min_booking").val(date);

    }
    //form clear ------End
    datashow();
    //for desplay in table with data toggel Buttton------Strat
    function datashow() {

        if ($.fn.DataTable.isDataTable('#laravel_crud')) {
            $('#laravel_crud').DataTable().destroy();
        }
        $('#laravel_crud tbody').empty();


        $.get('getscedulaclass', function(data) {

            //  var data = eval(data);

            // $('#laravel_crud').DataTable().destroy();
            var html = '';

            for (var i = 0; i < data.length; i++) {
                var sr = i + 1;
                var st = data[i].status;
                var chehc = "";
                var des = "";
                if (data[i].class_description != null) {
                    des = data[i].class_description;
                } else {
                    des = "";
                }
                var date = data[i].class_schedule;
                var fdateslt = date.split('-');
                var time = fdateslt[2].split(' ');
                var checkouttime = time[0] + '/' + fdateslt[1] + '/' + fdateslt[0] + ' ' + time[1];

                var checkdate = time[0] + '/' + fdateslt[1] + '/' + fdateslt[0];

                var duration = getclassdutation(checkouttime, data[i].class_duration)

                html += '<tr>' +

                    '<td id="classname_' + data[i].classsechedule_id + '">' + data[i].classname + '</td>' +
                    '<td style="display:none;" id="classsechedule_name_' + data[i].classsechedule_id + '">' + data[i].classsechedule_name + '</td>' +
                    '<td   id="class_schedule_' + data[i].classsechedule_id + '">' + checkouttime + "-" + duration + '</td>' +
                    '<td  style="display:none;" id="instructor_' + data[i].classsechedule_id + '">' + data[i].instructor + '</td>' +
                    '<td   id="instructor_name' + data[i].classsechedule_id + '">' + data[i].instructor_name + '</td>' +
                    '<td   id="max_vacancy_' + data[i].classsechedule_id + '">' + data[i].max_vacancy + '</td>' +

                    '<td  style="display:none;" id="classsechedule_' + data[i].classsechedule_id + '">' + checkouttime + '</td>' +
                    '<td  style="display:none;" id="class_duration_' + data[i].classsechedule_id + '">' + data[i].class_duration + '</td>' +
                    '<td  style="display:none;" id="room_id_' + data[i].classsechedule_id + '">' + data[i].room_id + '</td>' +
                    '<td  style="display:none;" id="min_cancelation_' + data[i].classsechedule_id + '">' + data[i].min_cancelation + '</td>' +
                    '<td  style="display:none;" id="min_booking_' + data[i].classsechedule_id + '">' + data[i].min_booking + '</td>' +
                    '<td  style="display:none;" id="endtime_' + data[i].classsechedule_id + '">' + checkdate + " " + duration + '</td>';


                if (rights == 1) {
                    if (st == 1) {
                        html += '<td id="user_id_' + data[i].classsechedule_id + '"><input type="checkbox" class="btnstatus"  id="chekcstatus_' + data[i].classsechedule_id + '" name="chekcstatus_' + data[i].classsechedule_id + '" checked data-toggle="toggle"    data-on="Active" data-off="Inactive"  data-onstyle="success" data-offstyle="danger"  ></td>';
                    } else {
                        html += '<td id="user_id_' + data[i].classsechedule_id + '"> 	<input type="checkbox" class="btnstatus"  id="chekcstatus_' + data[i].classsechedule_id + '" name="chekcstatus_' + data[i].classsechedule_id + '"  data-toggle="toggle"    data-on="Active" data-off="Inactive"  data-onstyle="success" data-offstyle="danger"  ></td>';
                    }


                    html += '<td class="not-export-column" ><button name="edit"  value="edit" class="edit_data btn btn-xs btn-success" id=' +
                        data[i].classsechedule_id +
                        '  status=' + data[i].status + '><i class="fa fa-edit"></i></button>&nbsp;<button name="delete" value="Delete" class="delete_data btn btn-xs btn-danger" id=' +
                        data[i].classsechedule_id + '><i class="fa fa-trash"></i></button></td>' + '</tr>';
                } else {
                    if (st == 1) {
                        html += '<td id="user_id_' + data[i].classsechedule_id + '"><input type="checkbox" class="btnstatus" disabled  id="chekcstatus_' + data[i].classsechedule_id + '" name="chekcstatus_' + data[i].classsechedule_id + '" checked data-toggle="toggle"    data-on="Active" data-off="Inactive"  data-onstyle="success" data-offstyle="danger"  ></td>';
                    } else {
                        html += '<td id="user_id_' + data[i].classsechedule_id + '"> 	<input type="checkbox" class="btnstatus" disabled id="chekcstatus_' + data[i].classsechedule_id + '" name="chekcstatus_' + data[i].classsechedule_id + '"  data-toggle="toggle"    data-on="Active" data-off="Inactive"  data-onstyle="success" data-offstyle="danger"  ></td>';
                    }


                    html += '<td class="not-export-column" >-</td>' + '</tr>';
                }



            }

            $('#table_tbody').html(html);



            $('.btnstatus').bootstrapToggle({
                on: 'Active',
                off: 'Inactive'
            });

        })

        $('#laravel_crud').DataTable({
            "fnDrawCallback": function() {
                jQuery('#laravel_crud .btnstatus').bootstrapToggle();
            }
        });

    }
    //for desplay in table with data toggel Buttton------End

    //Edit Button Code Strat Here
    $(document).on('click', ".edit_data", function(e) {
        e.preventDefault();

        var id = $(this).attr("id");
        var status = $(this).attr("status");
        var classsechedule_name = $('#classsechedule_name_' + id).html();
        var instructor = $('#instructor_' + id).html();
        var max_vacancy = $('#max_vacancy_' + id).html();
        var classsechedule = $('#classsechedule_' + id).html();
        var class_duration = $('#class_duration_' + id).html();
        var room_id = $('#room_id_' + id).html();
        var min_cancelation = $('#min_cancelation_' + id).html();
        var min_booking = $('#min_booking_' + id).html();
        var endtime = $('#endtime_' + id).html();


        var fdateslt = min_cancelation.split('-');
        var time = fdateslt[2].split(' ');
        var min_cancelation1 = time[0] + '/' + fdateslt[1] + '/' + fdateslt[0] + ' ' + time[1];

        var fdateslt = min_booking.split('-');
        var time = fdateslt[2].split(' ');
        var min_booking1 = time[0] + '/' + fdateslt[1] + '/' + fdateslt[0] + ' ' + time[1];


        if (status == 1) {

            $('#status').bootstrapToggle('on');

        } else {
            $('#status').bootstrapToggle('off');
            // $('#status').bootstrapToggle('off');
        }
        $('#classsechedule_name').val(classsechedule_name).trigger('change');
        $('#class_schedule').val(classsechedule);
        $('#instructorid').val(instructor).trigger('change');
        $('#max_vacancy').val(max_vacancy);
        $('#class_duration').val(class_duration);
        $('#room_id').val(room_id).trigger('change');
        $('#min_cancelation').val(min_cancelation1);
        $('#min_booking').val(min_booking1);

        $('#save_update').val(id);
        $('#statusinfo').val(status);

        $('#classendtime').val(endtime);


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

                        if (data == true) {

                            $('.cancel').trigger('click');
                            datashow(); //call function show all data
                        } else {

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

    //blur Event of room
    $(document).on('blur', '#room', function() {
        var room = $('#room').val();
        var save_update = $('#save_update').val();
        var url = "";

        if (save_update == "") {
            url = checkcategory + "/" + room;
        } else {
            url = checkcategory + "/" + room + "/" + save_update;
        }

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
                        title: "Room already Exist",
                        text: "Please Enter Another Room!!",
                        type: "warning",
                    });
                    validate = 0;
                } else {
                    validate = 1;
                }
            }
        });


    });

    //for getting all Category
    getallclasses();
    getallroom();


    function getallclasses() {
        $.ajax({
            url: "getdropallclass",
            type: "GET",

            contentType: false,
            cache: false,
            processData: false,
            dataType: "json",
            success: function(data) {

                html = '';
                var name = '';

                html += '<option selected disabled value="" >Select</option>';

                for (i = 0; i < data.length; i++) {
                    var id = '';

                    name = data[i].class_name;
                    id = data[i].class_id;



                    html += '<option value="' + id + '">' + name + '</option>';
                }
                $('#classsechedule_name').html(html);

            }
        });
    }

    function getallroom() {
        $.ajax({
            url: "getdropallroom",
            type: "GET",

            contentType: false,
            cache: false,
            processData: false,
            dataType: "json",
            success: function(data) {

                html = '';
                var name = '';

                html += '<option selected disabled value="" >Select</option>';

                for (i = 0; i < data.length; i++) {
                    var id = '';

                    name = data[i].room;
                    id = data[i].rooom_id;



                    html += '<option value="' + id + '">' + name + '</option>';
                }
                $('#room_id').html(html);

            }
        });
    }
    $(document).on('blur', '#class_duration', function() {
        var class_schedule = $('#class_schedule').val();
        var class_duration = $('#class_duration').val();
        var classendtime = getclassdutation(class_schedule, class_duration);
        $('#classendtime').val(classendtime);
    });

    $(document).on('blur', '#class_schedule', function() {
        var class_schedule = $('#class_schedule').val();
        var class_duration = $('#class_duration').val();
        var classendtime = getclassdutation(class_schedule, class_duration);
        $('#classendtime').val(classendtime);
    });

    function getclassdutation(class_schedule, class_duration) {



        if (class_duration != "" && class_schedule != "") {
            var date = class_schedule;
            var fdateslt = date.split('/');
            var time = fdateslt[2].split(' ');
            var checkouttime = time[0] + '/' + fdateslt[1] + '/' + fdateslt[0] + ' ';


            var conprodArr = time[1].split(":");
            var hh1 = parseInt(conprodArr[0]);
            var mm1 = parseInt(conprodArr[1]) + parseInt(class_duration);
            var ss1 = parseInt(conprodArr[2]);

            if (ss1 > 59) {
                var ss2 = ss1 % 60;
                var ssx = ss1 / 60;
                var ss3 = parseInt(ssx); //add into min
                var mm1 = parseInt(mm1) + parseInt(ss3);
                var ss1 = ss2;
            }
            if (mm1 > 59) {
                var mm2 = mm1 % 60;
                var mmx = mm1 / 60;
                var mm3 = parseInt(mmx); //add into hour
                var hh1 = parseInt(hh1) + parseInt(mm3);
                var mm1 = mm2;
            }
            var finaladd = checkouttime + ' ' + hh1 + ':' + mm1 + ':' + ss1;
            return finaladd;

        }

    }

    //blur event of  class sechedule
    $(document).on('blur', '#class_schedule', function() {
        var class_schedule = $('#class_schedule').val();
        var checktime1 = checktime(class_schedule);
        if (checktime1 == 0) {
            swal({
                title: "Class Schedule Time is always greater then Current Time !!!",

            });
        }

    });

    //blur event of  class sechedule
    $(document).on('blur', '#min_cancelation', function() {
        var class_schedule = $('#class_schedule').val();
        var min_cancelation = $('#min_cancelation').val();
        var mintime = checktime(min_cancelation);


        if (mintime == 0) {
            swal({
                title: "Min Cancelation Time is always greater then Current Time !!!",

            });
        }


    });

    //blur event of  class sechedule
    $(document).on('blur', '#min_booking', function() {
        var class_schedule = $('#class_schedule').val();
        var min_booking = $('#min_booking').val();
        // var mintime = mincanclatontime(class_schedule, min_booking);
        var mintime = checktime(min_booking);

        if (mintime == 0) {
            swal({
                title: "Min Booking Time is always greater then Current Time !!!",

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

    //Min Cancelation time check
    function mincanclatontime(class_schedule, min_cancelation) {



        if (Date.parse(min_cancelation) > Date.parse(class_schedule)) {
            return 1;
        } else {
            return 0;
        }



    }





    $("#max_vacancy").keypress(function(e) {
        console.log('hiii');
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && e.which !== '-' && (e.which < 48 || e.which > 57)) {

            //$("#errmsg").html("Digits Only");
            return false;
        } else {
            $("#errmsg").hide();
        }
    });
    $("#class_duration").keypress(function(e) {
        console.log('hiii');
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && e.which !== '-' && (e.which < 48 || e.which > 57)) {

            //$("#errmsg").html("Digits Only");
            return false;
        } else {
            $("#errmsg").hide();
        }
    });

    $(document).on('click', ".closehideshow", function(e) {
        e.preventDefault();

        from_clear();
    });
    getinstructor();
    /*-----get all instructor -----*/
    function getinstructor() {
        $.ajax({
            url: "getdropallinstuctor",
            type: "GET",

            contentType: false,
            cache: false,
            processData: false,
            dataType: "json",
            success: function(data) {

                html = '';
                var name = '';

                html += '<option selected disabled value="" >Select</option>';

                for (i = 0; i < data.length; i++) {
                    var id = '';

                    name = data[i].instructor_name;
                    id = data[i].instructorid;



                    html += '<option value="' + id + '">' + name + '</option>';
                }
                $('#instructorid').html(html);

            }
        });
    }


});