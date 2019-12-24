$(document).ready(function() {

    getallsechedule();

    var menu = 12;
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

    function getallsechedule() {
        var starttime = $("#start_time").text();
        var end_time = $("#end_time").text();
        var date = $("#today").text();

        var time = $("#starttime").val();

        starttime = starttime.split(" ");


        var hrs = starttime[0].split(":");

        if (starttime[1] == "PM" && hrs[0] < 12) hrs[0] = parseInt(hrs[0]) + parseInt(12);
        if (starttime[1] == "AM" && hrs[0] == 12) hrs[0] = parseInt(hrs[0]) - parseInt(12);
        var shours = hrs[0].toString();

        shours = shours + ":" + "00" + ":" + "00";
        end_time = end_time.split(" ");


        var hrs1 = end_time[0].split(":");


        if (end_time[1] == "PM" && hrs1[0] < 12) hrs1[0] = parseInt(hrs1[0]) + parseInt(12);
        if (end_time[1] == "AM" && hrs1[0] == 12) hrs1[0] = parseInt(hrs1[0]) - parseInt(12);
        var ehours = hrs1[0].toString();
        console.log(ehours);


        ehours = ehours + ":" + "00" + ":" + "00";






        var tdateAr = date.split('/');
        var start_time = tdateAr[2] + '-' + tdateAr[1] + '-' + tdateAr[0] + " " + shours;

        var tdateAr = date.split('/');
        var end_time = tdateAr[2] + '-' + tdateAr[1] + '-' + tdateAr[0] + " " + ehours;


        $.ajax({
            data: {
                start_time: start_time,
                end_time: end_time,

            },
            url: getdata,
            type: "POST",
            dataType: 'json',
            async: false,
            success: function(data) {
                if (data.length > 0) {
                    for (var i = 0; i < data.length; i++) {

                        var html = '<tr><td><a href="#" id="classsechedle_' + data[i].classsechedule_id + '"  class="classname"><font color="blue">' + data[i].classname + '</font></a></td>' +
                            '<td>' + data[i].instructorname + '</td>' +
                            // '<td>' + data[i].class_schedule + '</td>' +
                            // '<td>' + data[i].class_schedule + '</td>' +

                            "</tr>";

                        $('#classlisttbody').append(html);


                    }
                }

            },
            error: function(data) {
                console.log('Error:', data);
            }
        });
    }

    $(document).on('click', ".classname", function(e) {
        e.preventDefault();


        var classid = $(this).attr('id');

        classid = classid.split("_");
        $('#classsecid').val(classid[1]);

        $.ajax({
            data: {
                classid: classid[1],


            },
            url: getsechedulemember,
            type: "POST",
            dataType: 'json',
            async: false,
            success: function(data) {
                $('#studebt_list').html('');


                for (var i = 0; i < data.length; i++) {



                    var html = '<div class="col-sm-4">' +
                        '<br> <input class="checkmebmeratt" type="checkbox" id="check_' + data[i].booking_id + '" name="' + data[i].booking_id + '" data value="0">&nbsp;<span>' + data[i].membername + '</span>' +
                        '</div>';


                    $('#studebt_list').append(html);
                    if (data[i].attandancestatus == 1) {

                        $("#check_" + data[i].booking_id).prop('checked', true);
                        $("#check_" + data[i].booking_id).val(1);

                    }

                }

            }
        });

    });

    $(document).on('change', ".checkmebmeratt", function(e) {
        e.preventDefault();
        if ($(this).is(":checked")) {
            $(this).val(1);

        } else {
            $(this).val(0);

        }

    });
    $(document).on('submit', '#master_form', function(e) {
        e.preventDefault();

        var class_schedule = $('#classsecid').val();
        var start_time = $('#start_time').text();
        var end_time = $('#end_time').text();
        var date = $('#today').text();
        var save_update = $('#save_update').text();

        studejsonObj = [];
        $(".checkmebmeratt").each(function() {
            var id1 = $(this).attr('id');
            var value = $(this).val();

            id1 = id1.split("_");
            student = {}

            student["bookidid"] = id1[1];
            student["bookvalvalue"] = value;
            studejsonObj.push(student);


        });


        var tdateAr = date.split('/');
        date = tdateAr[2] + '-' + tdateAr[1] + '-' + tdateAr[0];

        $.ajax({
            data: {
                save_update: save_update,
                class_schedule: class_schedule,
                start_time: start_time,
                end_time: end_time,
                date: date,
                studejsonObj: studejsonObj,

            },
            url: saveattandance,
            type: "POST",
            dataType: 'json',
            async: false,
            success: function(data) {


                successTost("Opration Save Success fully!!!");
                form_clear();

            }
        });

    });

    function form_clear() {
        $('#studebt_list').html('');
    }



});