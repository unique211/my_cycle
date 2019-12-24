$(document).ready(function() {


    validate = 1;

    var menu = 8;
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

    //for submite of from inserting or updating Recored  --------Start
    $(document).on('submit', '#master_form', function(e) {
        e.preventDefault();


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
                        title: "Class Name already Exist",
                        text: "Please Enter Another Class Name  !!",
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
        $('#room').val('');

        $('#save_update').val('');
        $('#statusinfo').val('');
        $('#class_name').val('');
        $('#class_category').val('').trigger('change');
        $('#class_description').val('');
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

        $.get('getallclass', function(data) {

            var data = eval(data);
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


                html += '<tr>' +
                    '<td id="id_' + data[i].class_id + '">' + sr + '</td>' +
                    '<td id="classname_' + data[i].class_id + '">' + data[i].class_name + '</td>' +
                    '<td id="classcategory_' + data[i].class_id + '">' + data[i].classcategory + '</td>' +
                    '<td  style="display:none;" id="classcategoryid_' + data[i].class_id + '">' + data[i].class_category + '</td>' +
                    '<td  style="display:none;" id="classdescription_' + data[i].class_id + '">' + des + '</td>';



                if (rights == 1) {
                    if (st == 1) {
                        html += '<td id="user_id_' + data[i].class_id + '"><input type="checkbox" class="btnstatus"  id="chekcstatus_' + data[i].class_id + '" name="chekcstatus_' + data[i].class_id + '" checked data-toggle="toggle"    data-on="Active" data-off="Inactive"  data-onstyle="success" data-offstyle="danger"  ></td>';
                    } else {
                        html += '<td id="user_id_' + data[i].class_id + '"> 	<input type="checkbox" class="btnstatus"  id="chekcstatus_' + data[i].class_id + '" name="chekcstatus_' + data[i].class_id + '"  data-toggle="toggle"    data-on="Active" data-off="Inactive"  data-onstyle="success" data-offstyle="danger"  ></td>';
                    }


                    html += '<td class="not-export-column" ><button name="edit"  value="edit" class="edit_data btn btn-xs btn-success" id=' +
                        data[i].class_id +
                        '  status=' + data[i].status + '><i class="fa fa-edit"></i></button>&nbsp;<button name="delete" value="Delete" class="delete_data btn btn-xs btn-danger" id=' +
                        data[i].class_id + '><i class="fa fa-trash"></i></button></td>' + '</tr>';
                } else {
                    if (st == 1) {
                        html += '<td id="user_id_' + data[i].class_id + '"><input type="checkbox" class="btnstatus" disabled  id="chekcstatus_' + data[i].class_id + '" name="chekcstatus_' + data[i].class_id + '" checked data-toggle="toggle"    data-on="Active" data-off="Inactive"  data-onstyle="success" data-offstyle="danger"  ></td>';
                    } else {
                        html += '<td id="user_id_' + data[i].class_id + '"><input type="checkbox" class="btnstatus" disabled id="chekcstatus_' + data[i].class_id + '" name="chekcstatus_' + data[i].class_id + '"  data-toggle="toggle"    data-on="Active" data-off="Inactive"  data-onstyle="success" data-offstyle="danger"  ></td>';
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
        $('#laravel_crud').dataTable({
            paging: false
        });

    }
    //for desplay in table with data toggel Buttton------End

    //Edit Button Code Strat Here
    $(document).on('click', ".edit_data", function(e) {
        e.preventDefault();

        var id = $(this).attr("id");
        var status = $(this).attr("status");
        var classname = $('#classname_' + id).html();
        var classcategoryid = $('#classcategoryid_' + id).html();
        var classdescription = $('#classdescription_' + id).html();




        if (status == 1) {

            $('#status').bootstrapToggle('on');

        } else {
            $('#status').bootstrapToggle('off');
            // $('#status').bootstrapToggle('off');
        }
        $('#class_name').val(classname);
        $('#class_category').val(classcategoryid).trigger('change');
        $('#class_description').val(classdescription);

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

                        if (data == true) {

                            $('.cancel').trigger('click');

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


    });
    $(document).on('click', '.cancel', function() {
        datashow();
    });

    //blur Event of room
    $(document).on('blur', '#class_name', function() {
        // var room = $('#class_name').val();
        var save_update = $('#save_update').val();
        // var url = "";

        // if (save_update == "") {
        //     url = checkclassexists + "/" + room;
        // } else {
        //     url = checkclassexists + "/" + room + "/" + save_update;
        // }

        // $.ajax({
        //     url: url,
        //     type: "GET",

        //     contentType: false,
        //     cache: false,
        //     processData: false,
        //     dataType: "json",
        //     success: function(data) {
        //         if (data > 0) {
        //             swal({
        //                 title: "Class Name already Exist",
        //                 text: "Please Enter Another Class Name!!",
        //                 type: "warning",
        //             });
        //             validate = 0;
        //         } else {
        //             validate = 1;
        //         }
        //     }
        // });
        if (save_update == "") {
            checkrclassname();
        }


    });

    function checkrclassname() {
        var room = $('#class_name').val();
        var save_update = $('#save_update').val();
        var url = "";

        if (save_update == "") {
            url = checkclassexists + "/" + room;
        } else {
            url = checkclassexists + "/" + room + "/" + save_update;
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
                        title: "Class Name already Exist",
                        text: "Please Enter Another Class Name!!",
                        type: "warning",
                    });
                    validate = 0;
                } else {
                    validate = 1;
                }
            }
        });
    }

    //for getting all Category
    getallcategory();


    function getallcategory() {
        $.ajax({
            url: "getallcategory",
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

                    name = data[i].classcategory_name;
                    id = data[i].classcategory_id;



                    html += '<option value="' + id + '">' + name + '</option>';
                }
                $('#class_category').html(html);

            }
        });
    }
    //click Event of  Button cancle
    $(document).on('click', ".closehideshow", function(e) {
        e.preventDefault();

        from_clear();
    });
});