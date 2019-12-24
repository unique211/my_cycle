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
                        title: "Class Category Exist",
                        text: "Please Enter Another Class Category  !!",
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
        $('#category_description').val('');
        $('#classcategory_name').val('');
        $('#save_update').val('');
        $('#statusinfo').val('');
        $('#btnsave').text('Save');
        $('#status').bootstrapToggle('on');

    }
    //form clear ------End
    datashow();
    //for desplay in table with data toggel Buttton------Strat
    function datashow() {
        if ($.fn.DataTable.isDataTable('#laravel_crud')) {
            $('#laravel_crud').DataTable().destroy();
        }
        $('#laravel_crud tbody').empty();

        $.get('getdesibleall_classcategory', function(data) {

            var data = eval(data);
            var html = '';

            for (var i = 0; i < data.length; i++) {
                var sr = i + 1;
                var st = data[i].status;
                var chehc = "";
                var des = "";
                if (data[i].category_description != null) {
                    des = data[i].category_description;
                } else {
                    des = "";
                }


                html += '<tr>' +
                    '<td id="id_' + data[i].classcategory_id + '">' + sr + '</td>' +
                    '<td id="classcategoryname_' + data[i].classcategory_id + '">' + data[i].classcategory_name + '</td>' +
                    '<td id="categorydescription_' + data[i].classcategory_id + '">' + des + '</td>';

                if (st == 1) {
                    html += '<td id="user_id_' + data[i].classcategory_id + '"> 	<input type="checkbox" class="btnstatus"  id="chekcstatus_' + data[i].classcategory_id + '" name="chekcstatus_' + data[i].classcategory_id + '" checked data-toggle="toggle"    data-on="Active" data-off="Inactive"  data-onstyle="success" data-offstyle="danger"  ></td>';
                } else {
                    html += '<td id="user_id_' + data[i].classcategory_id + '"> 	<input type="checkbox" class="btnstatus"  id="chekcstatus_' + data[i].classcategory_id + '" name="chekcstatus_' + data[i].classcategory_id + '"  data-toggle="toggle"    data-on="Active" data-off="Inactive"  data-onstyle="success" data-offstyle="danger"  ></td>';
                }

                if (data[i].active == 1) {
                    html += '<td class="not-export-column" ><button name="edit"  value="edit" class="edit_data btn btn-xs btn-success" id=' +
                        data[i].classcategory_id +
                        '  status=' + data[i].status + '><i class="fa fa-edit"></i></button>&nbsp;</button></td>' + '</tr>';
                } else {
                    html += '<td class="not-export-column" ><button name="edit"  value="edit" class="edit_data btn btn-xs btn-success" id=' +
                        data[i].classcategory_id +
                        '  status=' + data[i].status + '><i class="fa fa-edit"></i></button>&nbsp;<button name="delete" value="Delete" class="delete_data btn btn-xs btn-danger" id=' +
                        data[i].classcategory_id + '><i class="fa fa-trash"></i></button></td>' + '</tr>';
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
        var classcategoryname = $('#classcategoryname_' + id).html();
        var categorydescription = $('#categorydescription_' + id).html();


        if (status == 1) {

            $('#status').bootstrapToggle('on');

        } else {
            $('#status').bootstrapToggle('off');
            // $('#status').bootstrapToggle('off');
        }
        $('#category_description').val(categorydescription);
        $('#classcategory_name').val(classcategoryname);

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

});