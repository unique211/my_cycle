$(document).ready(function() {


    validate = 1;

    var menu = 2;
    var rights = 1;
    user_access_rights();

    function user_access_rights() {

        $(".btnhideshow").show();
        $(".formhideshow").show();
        $(':input[type="submit"]').show();
        $.ajax({
            type: "POST",
            url: 'get_current_rights2/' + menu,
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


    //for submite of from inserting or updating Recored  --------Start
    $(document).on('submit', '#master_form', function(e) {
        e.preventDefault();






        $.ajax({
            data: $('#master_form').serialize(),
            url: add_data,
            type: "POST",
            dataType: 'json',
            success: function(data) {

                if (data == '100') {
                    swal({
                        title: "Member Type Exist",
                        text: "Please Enter Another Member Type !!",
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


    });
    //for submite of from inserting or updating Recored  --------Start

    // datashow();

    //form clear ------Strat
    function from_clear() {
        $('#member_type').val('');
        $('#save_update').val('');
        $('#statusinfo').val('');
        $('#btnsave').text('Save');


    }
    //form clear ------End
    datashow();
    //for desplay in table with data toggel Buttton------Strat
    function datashow() {
        if ($.fn.DataTable.isDataTable('#laravel_crud')) {
            $('#laravel_crud').DataTable().destroy();
        }
        $('#laravel_crud tbody').empty();

        $.get('getallmemberttype', function(data) {

            var data = eval(data);
            var html = '';

            for (var i = 0; i < data.length; i++) {
                var sr = i + 1;
                var st = data[i].status;
                var chehc = "";
                var des = "";



                html += '<tr>' +
                    '<td id="id_' + data[i].membertype_id + '">' + sr + '</td>' +
                    '<td id="member_type_' + data[i].membertype_id + '">' + data[i].member_type + '</td>';

                if (rights == 1) {
                    html += '<td class="not-export-column" ><button name="edit"  value="edit" class="edit_data btn btn-xs btn-success" id=' +
                        data[i].membertype_id +
                        '  status=' + data[i].status + '><i class="fa fa-edit"></i></button>&nbsp;<button name="delete" value="Delete" class="delete_data btn btn-xs btn-danger" id=' +
                        data[i].membertype_id + '><i class="fa fa-trash"></i></button></td>' + '</tr>';
                } else {
                    html += '<td class="not-export-column" >-</td>' + '</tr>';
                }





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

        var id = $(this).attr("id");
        var status = $(this).attr("status");
        var member_type = $('#member_type_' + id).html();





        $('#member_type').val(member_type);

        $('#save_update').val(id);
        $('#statusinfo').val(status);
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

    //for cancle button
    $(document).on('click', '.cancel', function() {
        datashow();
    });

    //blur Event of Category Name
    $(document).on('blur', '#member_type', function() {
        var member_type = $('#member_type').val();
        var save_update = $('#save_update').val();


        if (save_update == "") {
            url = checkmembertype + "/" + member_type;


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
                            title: "Member Type Already  Exist",
                            text: "Please Enter Another Member Type!!",
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

});