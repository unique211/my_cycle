$(document).ready(function() {


    $('.date').datepicker({
        //todayHighlight: true,
        format: 'dd/mm/yyyy',
        autoclose: false,
        endDate: "today"
      //  beforeShowDay: highlightDays,           
        });
        $('.date').datepicker('refresh');

    validate = 1;


    var menu = 7;
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

    function getDate(input) {
        from = input.split("/");
        return new Date(from[2], from[1] - 1, from[0]);
    }

    //for submite of from inserting or updating Recored  --------Start
    $(document).on('submit', '#master_form', function(e) {
        e.preventDefault();

        var from = $('#from').val();
        var to = $('#to').val();
        var instructorid = $('#instructorid').val();
        var classid = $('#class').val();


        var date1 = new Date();
        date1 = date1.toString('dd/MM/yyyy');
        var cur_date = getDate(date1);
        var date_ini = getDate(from);
        var date_end = getDate(to);



        var tdateAr = from.split('/');
        var fromdate = tdateAr[2] + '-' + tdateAr[1] + '-' + tdateAr[0];

        var tdateAr = to.split('/');
       var todate = tdateAr[2] + '-' + tdateAr[1] + '-' + tdateAr[0];





        var today = new Date().toDateString();

        var date_ini2 = new Date(fromdate).toDateString();
        var date_end2 = new Date(todate).toDateString();





        if (date_ini < date_end) {

            datashow();
            //put code here to call server
        } else {
            if (date_ini2 == date_end2) {
                datashow();
            } else {
                swal("To Date is Invalid", "Hey, To Date is Always > OR = From Date !!", "error");
            }

        }



  


    });
    //for submite of from inserting or updating Recored  --------Start

   

    //form clear ------Strat
    function from_clear() {
        $('#room').val('');
        $('#status').bootstrapToggle('on');
        $('#save_update').val('');
        $('#statusinfo').val('');
        $('#btnsave').text('Save');
    }


function datashow(){

    var from = $('#from').val();
    var to = $('#to').val();
    var instructorid = $('#instructorid').val();
    var classid = $('#class').val();


    var tdateAr = from.split('/');
    var fromdate = tdateAr[2] + '-' + tdateAr[1] + '-' + tdateAr[0];

    var tdateAr = to.split('/');
   var todate = tdateAr[2] + '-' + tdateAr[1] + '-' + tdateAr[0];

    $.ajax({
        data: {
            from: fromdate,
            to: todate,
            instructorid: instructorid,
            classid: classid,
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
            if (data.length > 0) {

                var Attendence = '';
                var html = "";
                for (var i = 0; i < data.length; i++) {

                    var date = data[i].date_time;
                    var fdateslt = date.split('-');
                    var time = fdateslt[2].split(' ');
                    var datetime = time[0] + '/' + fdateslt[1] + '/' + fdateslt[0] + ' ' + time[1];
                    if (data[i].instructorname != "" && data[i].classname != "") {

                        if (data[i].attandancestatus == 1) {
                            Attendence = "Present";
                        } else {
                            Attendence = "Absent";
                        }

                        var rating = '';
                        if (data[i].rating_points == -1) {
                            rating = '-';
                        } else {
                            rating = data[i].rating_points;
                        }
                        html += '<tr>' +
                            '<td id="id_' + data[i].bookid + '">' + datetime + '</td>' +
                            '<td id="classname_' + data[i].bookid + '">' + data[i].classname + '</td>' +
                            '<td id="classcategory_' + data[i].bookid + '">' + data[i].userid + '</td>' +
                            '<td id="classcategory_' + data[i].bookid + '">' + data[i].membername + '</td>' +
                            '<td id="classcategory_' + data[i].bookid + '">' + data[i].instructorname + '</td>' +
                            '<td id="classcategory_' + data[i].bookid + '">' + rating + '</td>' +
                            '<td id="classcategory_' + data[i].bookid + '">' + Attendence + '</td>' +
                            '</tr>';
                    }


                }
                $('#table_tbody').html(html);
                $('#data_table').dataTable({
                    dom: 'Bfrtip',

                    buttons: [{
                            extend: 'excelHtml5',
                            title: 'Attendence',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5]
                            },

                        },
                        {
                            extend: 'pdfHtml5',
                            title: 'Attendence',
                            orientation: 'landscape',
                            pageSize: 'A4',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5]
                            },
                        }
                    ]
                });

            }


        }
    });
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

                html += '<option selected disabled value="" >Select</option>';

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

                html += '<option selected disabled value="" >Select</option>';
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









});
