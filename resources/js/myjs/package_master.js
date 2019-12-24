$(document).ready(function() {


    validate = 1;

    var menu = 5;
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
        $('#package_name').trigger('blur');
        var packageprice = $('#package_price').val();


        var status = 0;
        if ($('#status').is(":checked")) {
            status = 1;
        } else {
            status = 0;
        }
        $('#statusinfo').val(status);

        if (packageprice > 0) {

            $.ajax({
                data: $('#master_form').serialize(),
                url: add_data,
                type: "POST",
                dataType: 'json',
                success: function(data) {

                    datashow();

                    if (data == '100') {
                        swal({
                            title: "Package Name Exist",
                            text: "Please Enter Another Package Name  !!",
                            type: "warning",
                        });
                    } else {
                        successTost("Opration Save Success fully!!!");

                        from_clear();
                    }



                },
                error: function(data) {
                    console.log('Error:', data);

                }
            });
        } else {
            swal({
                title: "Package Price Should Be Greater than Zero",

                type: "warning",
            });
        }


    });
    //for submite of from inserting or updating Recored  --------Start

    datashow();

    //form clear ------Strat
    function from_clear() {
        $('#package_price').val('');
        $('#package_point').val('');
        $('#package_name').val('');
        $('#save_update').val('');
        $('#statusinfo').val('');
        $('#status').bootstrapToggle('on');
        $('#btnsave').text("Save");
    }


    //form clear ------End

    //for desplay in table with data toggel Buttton------Strat
    function datashow() {
        if ($.fn.DataTable.isDataTable('#laravel_crud')) {
            $('#laravel_crud').DataTable().destroy();
        }
        $('#laravel_crud tbody').empty();

        $.get('get_all', function(data) {

            var data = eval(data);
            var html = '';

            for (var i = 0; i < data.length; i++) {
                var sr = i + 1;
                var st = data[i].status;
                var chehc = "";

                html += '<tr>' +
                    '<td id="id_' + data[i].packege_id + '">' + sr + '</td>' +
                    '<td id="packagename_' + data[i].packege_id + '">' + data[i].package_name + '</td>' +
                    '<td style="text-align:right;" id="packagepoint_' + data[i].packege_id + '">' + data[i].package_point + '</td>' +
                    '<td style="text-align:right;" id="package_price_' + data[i].packege_id + '">' + data[i].package_price + '</td>';


                if (rights == 1) {
                    if (st == 1) {
                        html += '<td id="user_id_' + data[i].packege_id + '"> 	<input type="checkbox" class="btnstatus"   id="chekcstatus_' + data[i].packege_id + '" name="chekcstatus_' + data[i].packege_id + '" checked data-toggle="toggle"    data-on="Active" data-off="Inactive"  data-onstyle="success" data-offstyle="danger"  ></td>';
                    } else {
                        html += '<td id="user_id_' + data[i].packege_id + '"> 	<input type="checkbox" class="btnstatus"   id="chekcstatus_' + data[i].packege_id + '" name="chekcstatus_' + data[i].packege_id + '"  data-toggle="toggle"    data-on="Active" data-off="Inactive"  data-onstyle="success" data-offstyle="danger"  ></td>';
                    }
                    html += '<td class="not-export-column" ><button name="edit"  value="edit" class="edit_data btn btn-xs btn-success" id=' +
                        data[i].packege_id +
                        '  status=' + data[i].status + '><i class="fa fa-edit"></i></button>&nbsp;<button name="delete" value="Delete" class="delete_data btn btn-xs btn-danger" id=' +
                        data[i].packege_id + '><i class="fa fa-trash"></i></button></td>' + '</tr>';
                } else {
                    if (st == 1) {
                        html += '<td id="user_id_' + data[i].packege_id + '"> 	<input type="checkbox" class="btnstatus" disabled  id="chekcstatus_' + data[i].packege_id + '" name="chekcstatus_' + data[i].packege_id + '" checked data-toggle="toggle"    data-on="Active" data-off="Inactive"  data-onstyle="success" data-offstyle="danger"  ></td>';
                    } else {
                        html += '<td id="user_id_' + data[i].packege_id + '"> 	<input type="checkbox" class="btnstatus" disabled  id="chekcstatus_' + data[i].packege_id + '" name="chekcstatus_' + data[i].packege_id + '"  data-toggle="toggle"    data-on="Active" data-off="Inactive"  data-onstyle="success" data-offstyle="danger"  ></td>';
                    }
                    html += '<td class="not-export-column" >-</td>' + '</tr>';
                }



            }

            $('#table_tbody').html(html);

            $('.btnstatus').bootstrapToggle();

        })

        $('#laravel_crud').DataTable({

            "fnDrawCallback": function() { //for display for bootstraptoggle button
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
        var packagename = $('#packagename_' + id).html();
        var packagepoint = $('#packagepoint_' + id).html();
        var package_price = $('#package_price_' + id).html();

        if (status == 1) {

            $('#status').bootstrapToggle('on');

        } else {
            $('#status').bootstrapToggle('off');
            // $('#status').bootstrapToggle('off');
        }
        $('#package_price').val(package_price);
        $('#package_point').val(packagepoint);
        $('#package_name').val(packagename);
        $('#save_update').val(id);
        $('#statusinfo').val(status);
        $('#btnsave').text("Update");




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

    //blur Event of package name
    $(document).on('blur', '#package_name', function() {
        var packagename = $('#package_name').val();
        var save_update = $('#save_update').val();
        var url = "";
        if (save_update == "") {
            url = checkpackagename + "/" + packagename;
        } else {
            //  url = checkpackagename + "/" + packagename + "/" + save_update;
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
                            title: "Package Name Exist",
                            text: "Please Enter Another Package Name  !!",
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
    $(document).on('click', ".closehideshow", function(e) {
        e.preventDefault();

        from_clear();
    });


    $("#package_price").keypress(function(e) {
        console.log('hiii');
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && e.which !== '-' && (e.which < 48 || e.which > 57)) {

            //$("#errmsg").html("Digits Only");
            return false;
        } else {
            $("#errmsg").hide();
        }
    });

});