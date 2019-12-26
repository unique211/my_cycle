$(document).ready(function() {


    validate = 1;


    var menu = 15;
    var rights = 1;
    user_access_rights();

    function user_access_rights() {

        $(".btnhideshow").show();
        $.ajax({
            type: "POST",
            url: 'get_current_rights/' + menu,
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

    datashow();


    function datashow() {
        if ($.fn.DataTable.isDataTable('#laravel_crud')) {
            $('#laravel_crud').DataTable().destroy();
        }
        $('#laravel_crud tbody').empty();

        $.get('get_all_inquiry', function(data) {

            var data = eval(data);
            var html = '';

            for (var i = 0; i < data.length; i++) {
                var sr = i + 1;


                html += '<tr>' +
                    '<td id="id_' + data[i].id + '">' + sr + '</td>' +
                    '<td id="classcategoryname_' + data[i].id + '">' + data[i].name + '</td>' +
                    '<td id="categorydescription_' + data[i].id + '">' + data[i].email + '</td>' +
                    '<td id="categorydescription_' + data[i].id + '">' + data[i].subject + '</td>' +
                    '<td id="categorydescription_' + data[i].id + '">' + data[i].message + '</td>' +
                    '</tr>';






            }

            $('#table_tbody').html(html);
            $('#laravel_crud').DataTable({
                dom: 'Bfrtip',

                buttons: [{
                        extend: 'excelHtml5',
                        title: 'Inquiry',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4]
                        },

                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'Inquiry',
                        //  orientation: 'landscape',
                        pageSize: 'A4',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4]
                        },
                    }
                ]
            });


        })


    }











});