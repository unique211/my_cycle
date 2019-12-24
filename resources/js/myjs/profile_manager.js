$(document).ready(function() {

    getallmenu();

    function getallmenu() {
        $.ajax({
            type: "GET",
            url: 'get_menu',
            dataType: "JSON",

            async: false,
            success: function(data) {
                var table = "";
                for (var i = 0; i < data.length; i++) {


                    if (data[i].submenudata.length > 0) {
                        table += '<tr class="main_menu">' +
                            '<td><span ><input type="checkbox" checked  class="main_chk"  id="_' + data[i].menuid + '" name="' + data[i].menuid + '" value="1">' + data[i].menu_name + '</span></td>' +
                            '<td></td>' +
                            '<td></td>' +
                            '</tr>';
                        for (var j = 0; j < data[i].submenudata.length; j++) {
                            table += '<tr class="sub_menu">' +
                                '<td ><span >' + data[i].submenudata[j].submenuname + '</span></td>' +
                                '<td><input type="radio" class="submenu_' + data[i].menuid + '" name="main_chk_' + data[i].menuid + '_' + data[i].submenudata[j].submenu_id + '" value="readonly" id="sub_' + data[i].submenudata[j].submenu_id + '" checked="true"/></td>' +
                                '<td><input type="radio" class="submenu_' + data[i].menuid + '" name="main_chk_' + data[i].menuid + '_' + data[i].submenudata[j].submenu_id + '" value="modify" id="sub2_' + data[i].submenudata[j].submenu_id + '"/></td>' +
                                '</tr>';
                        }

                    } else {
                        table += '<tr class="main_menu">' +
                            '<td><span ><input type="checkbox" checked id="_' + data[i].menuid + '" name="' + data[i].menuid + '" class="main_chk" value="1">' + data[i].menu_name + '</span></td>' +
                            '<td><input type="radio" class="mmenu_' + data[i].menuid + '" name="main_chk_' + data[i].menuid + '" value="readonly" id="r_' + data[i].menuid + '" checked="true"/></td>' +
                            '<td><input type="radio" class="mmenu_' + data[i].menuid + '" name="main_chk_' + data[i].menuid + '" value="modify" id="m_' + data[i].menuid + '" /></td>' +
                            '</tr>';
                    }
                }
                $('#tbd_user_rights').html(table);

            }


        });

    }

    $(document).on('submit', '#master_form', function(e) {
        e.preventDefault();
        // alert("in submit");
        //$(':input[type="submit"]').prop('disabled', true);
        var save_update = $("#save_update").val();
        var profiletype = $("#profiletype").val();

        var userpermission = [];

        //  alert(groups_id);

        if (save_update != "") {

            $.ajax({
                data: {
                    save_update: save_update,

                },
                url: delete_from_user_rights,
                type: "POST",
                dataType: 'json',
                async: false,
                success: function(data) {
                    //
                    // alert(data);

                },
                error: function(data) {
                    console.log('Error:', data);
                }
            });

        }
        studejsonObj = [];
        $(".main_chk").each(function() {
            var id1 = $(this).attr('id');

            if ($(this).prop("checked") == true) {
                console.log('from checked');
                id1 = id1.split("_");



                student = {};




                if ($("#r_" + id1[1]).prop("checked") == true) {
                    student["menuid"] = id1[1];
                    student["permission"] = 0;
                    student["submenu"] = 0;
                } else if ($("#m_" + id1[1]).prop("checked") == true) {
                    student["menuid"] = id1[1];
                    student["permission"] = 1;
                    student["submenu"] = 0;
                }




                var sub_menu = "";
                $(".submenu_" + id1[1]).each(function() {
                    console.log("hiiifromdsfd");

                    var submenu = $(this).attr('id');
                    //  var submenu=$(this).attr('name');

                    submenu = submenu.split("_");
                    student = {};

                    if ($("#sub_" + submenu[1]).prop("checked") == true) {

                        student["menuid"] = id1[1];
                        student["permission"] = 0;
                        student["submenu"] = submenu[1];

                        if (sub_menu != submenu[1]) {
                            studejsonObj.push(student);
                        }



                    } else if ($("#sub2_" + submenu[1]).prop("checked") == true) {
                        student["menuid"] = id1[1];
                        student["permission"] = 1;
                        student["submenu"] = submenu[1];

                        if (sub_menu != submenu[1]) {
                            studejsonObj.push(student);
                        }

                    }

                    sub_menu = submenu[1];




                });
                studejsonObj.push(student);



            }

        });

        console.log(studejsonObj);


        //  alert(groups_id);
        $.ajax({
            data: {
                studejsonObj: studejsonObj,
                save_update: save_update,
                profiletype: profiletype,


            },
            url: add_data,
            type: "POST",
            dataType: 'json',
            // async: false,
            success: function(data) {


                // alert(data);
                // $("#master_form").trigger('reset');
                $(".closehideshow").trigger('click');
                form_clear();
                //form_form_clear();
                successTost("Saved Successfully");
                $('#save_update').val('');
                datashow();
                // $('input:checkbox').removeAttr('checked');
            },
            error: function(data) {
                console.log('Error:', data);
                //  $('#btn-save').html('Save Changes');
            }
        });


    });

    function form_clear() {
        $('#profiletype').val('');
        $('#save_update').val('');
        $('#btnsave').text('Save');
        $('.deletedata').hide();

        getallmenu();
    }
    datashow();

    function datashow() {
        if ($.fn.DataTable.isDataTable('#laravel_crud')) {
            $('#laravel_crud').DataTable().destroy();
        }
        $('#laravel_crud tbody').empty();

        $.get('get_all_profile', function(data) {

            var data = eval(data);
            var html = '';

            for (var i = 0; i < data.length; i++) {
                var sr = i + 1;
                var st = data[i].status;
                var chehc = "";

                html += '<tr>' +
                    '<td id="id_' + data[i].profile_id + '">' + sr + '</td>' +
                    '<td id="profile_type_' + data[i].profile_id + '">' + data[i].profile_type + '</td>' +



                    '<td class="not-export-column" ><button name="edit"  value="edit" class="edit_data btn btn-xs btn-success" id=' +
                    data[i].profile_id +
                    '  status=' + data[i].status + '><i class="fa fa-edit"></i></button>&nbsp;<button name="delete" value="Delete" class="delete_data btn btn-xs btn-danger" id=' +
                    data[i].profile_id + '><i class="fa fa-trash"></i></button></td>' + '</tr>';


            }

            $('#table_tbody').html(html);
            $('#laravel_crud').DataTable({

                // "fnDrawCallback": function() { //for display for bootstraptoggle button
                //     jQuery('#laravel_crud .btnstatus').bootstrapToggle();
                // }

            });

            //$('.btnstatus').bootstrapToggle();
            // $('.btnstatus').bootstrapToggle({
            //     on: 'Active',
            //     off: 'Inactive'
            // });
        })


    }
    $(document).on('click', ".edit_data", function(e) {
        e.preventDefault();
        $(".tablehideshow").hide();
        $(".formhideshow").show();
        $('input:checkbox').removeAttr('checked');

        var id = $(this).attr("id");

        var profile_type = $('#profile_type_' + id).html();

        $('#profiletype').val(profile_type);
        $('#save_update').val(id);



        $.get('user_rights/' + id, function(data) {
            var data = eval(data);

            for (var i = 0; i < data.length; i++) {



                if (data[i].userright == 0) {

                    $('#r_' + data[i].menuid).prop('checked', true);
                    $('#sub_' + data[i].submenuid).prop('checked', true);


                } else {
                    $('#m_' + data[i].menuid).prop('checked', true);
                    $('#sub2_' + data[i].submenuid).prop('checked', true);
                }

                if (data[i].menuid > 0) {
                    $('#_' + data[i].menuid).prop('checked', true);
                }

            }

        });
        $('.deletedata').show();
        $('#delete').val(id);


        $('#btnsave').text('Update');


    });

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

    $(document).on('click', '.deletedata', function() {
        var id1 = $(this).val();

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

    $(document).on('click', '.closehideshow', function() {
        form_clear();
    });


});