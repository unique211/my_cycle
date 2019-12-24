$(document).ready(function() {



    datashow();
    //for desplay in table with data toggel Buttton------Strat
    function datashow() {

        // alert("asdas");

        if ($.fn.DataTable.isDataTable('#laravel_crud')) {

            $('#laravel_crud').DataTable().destroy();
        }
        $('#laravel_crud tbody').empty();

        $.get('upcoming_booking_details', function(data) {

            var data = eval(data);
            var html = '';

            for (var i = 0; i < data.length; i++) {
                var sr = i + 1;

                var date = data[i].date;
                var fdateslt = date.split('-');
                var time = fdateslt[2].split(' ');
                var date1 = time[0] + '/' + fdateslt[1] + '/' + fdateslt[0] + ' ' + time[1];


                html += '<tr>' +
                    '<td id="id_' + data[i].class_id + '">' + sr + '</td>' +
                    '<td id="classname_' + data[i].class_id + '">' + date1 + '</td>' +
                    '<td id="classcategory_' + data[i].class_id + '">' + data[i].class + '</td>' +
                    '<td   id="classcategoryid_' + data[i].class_id + '">' + data[i].instructor + '</td>' +
                    '<td   id="classdescription_' + data[i].class_id + '">' + data[i].members_count + '</td>';
                '</tr>';


            }

            $('#table_tbody').html(html);
            $('#laravel_crud').dataTable({

            });



        })


    }









});