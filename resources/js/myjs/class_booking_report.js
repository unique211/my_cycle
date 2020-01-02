$(document).ready(function() {


    validate = 1;


    var menu = 6;
    var rights = 1;
    user_access_rights();

    function user_access_rights() {

        $(".btnhideshow").show();
        $.ajax({
            type: "POST",
            url: 'get_current_rights2/' + menu,
            dataType: "JSON",
            async: false,
            success: function(data) {

                if (data == 0 || data == "0") {
                    $(".btnhideshow").hide();
                    rights = 0;
                } else {
                    $(".btnhideshow").show();
                    rights = 1;
                }
            }
        });
    }



    //for submite of from inserting or updating Recored  --------Start
    $(document).on('submit', '#master_form', function(e) {
        e.preventDefault();

        var from = $('#from').val();
        var to = $('#to').val();
        var instructorid = $('#instructorid').val();
        var classid = $('#class').val();
        var member_id = $('#member_id').val();


        var tdateAr = from.split('/');
        from = tdateAr[2] + '-' + tdateAr[1] + '-' + tdateAr[0];

        var tdateAr = to.split('/');
        to = tdateAr[2] + '-' + tdateAr[1] + '-' + tdateAr[0];



        $.ajax({
            data: {
                from: from,
                to: to,
                instructorid: instructorid,
                classid: classid,
                member_id: member_id,
            },
            url: getdata,
            type: "POST",
            dataType: 'json',
            // async: false,
            success: function(data) {
                if ($.fn.DataTable.isDataTable('#data_table')) {

                    $('#data_table').DataTable().destroy();
                }
                $('#data_table tbody').empty();
                var html = "";
                if (data.length > 0) {

                    var Attendence = '';

                    for (var i = 0; i < data.length; i++) {
                        html += '<tr>' +
                            '<td>' + data[i].class_name + '</td>' +
                            '<td>' + data[i].schedule + '</td>' +
                            '<td>' + data[i].instructor_name + '</td>' +
                            '<td >' + data[i].booked_members + '</td>' +
                            '<td>' + data[i].vacancy + '</td>' +
                            '</tr>';
                    }


                }
                $('#table_tbody').html(html);
                $('#data_table').dataTable({
                    dom: 'Bfrtip',
                    "pageLength": 50,
                    buttons: [{
                            extend: 'excelHtml5',
                            title: 'Class Booking',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4]
                            },

                        },
                        {
                            extend: 'print',
                            title: 'Class Booking',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4]
                            },



                        }
                    ]
                });

            }
        });


    });
    //for submite of from inserting or updating Recored  --------Start

    // datashow();

    //form clear ------Strat
    function from_clear() {
        $('#room').val('');
        $('#status').bootstrapToggle('on');
        $('#save_update').val('');
        $('#statusinfo').val('');
        $('#btnsave').text('Save');
    }









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

                html += '<option  disabled value="" >Select</option>';

                html += '<option  selected  value="All" >All</option>';

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

    getallclasses();

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

                html += '<option  disabled value="" >Select</option>';
                html += '<option selected  value="All" >All</option>';
                for (i = 0; i < data.length; i++) {
                    var id = '';

                    name = data[i].class_name;
                    id = data[i].class_id;



                    html += '<option value="' + id + '">' + name + '</option>';
                }
                $('#class').html(html);

            }
        });
    }

    getallmember();

    function getallmember() {
        $.ajax({
            url: "getallmember",
            type: "GET",

            contentType: false,
            cache: false,
            processData: false,
            dataType: "json",
            success: function(data) {

                html = '';
                var name = '';

                html += '<option  disabled value="" >Select</option>';
                html += '<option selected  value="All" >All</option>';
                for (i = 0; i < data.length; i++) {
                    var id = '';

                    name = data[i].membername;
                    id = data[i].member_id;



                    html += '<option value="' + id + '">' + name + '</option>';
                }
                $('#member_id').html(html);

            }
        });
    }









});