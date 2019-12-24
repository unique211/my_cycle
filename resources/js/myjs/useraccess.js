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
                            '<td><span ><input type="checkbox" checked id="_' + data[i].menuid + '" name="' + data[i].menuid + '" class="main_chk"  value="1">' + data[i].menu_name + '</span></td>' +
                            '<td><input type="radio" class="mmenu_' + data[i].menuid + '" name="main_chk_' + data[i].menuid + '" value="readonly" id="r_' + data[i].menuid + '" checked="true"/></td>' +
                            '<td><input type="radio" class="mmenu_' + data[i].menuid + '" name="main_chk_' + data[i].menuid + '" value="modify" id="m_' + data[i].menuid + '"/></td>' +
                            '</tr>';
                    }
                }
                $('#tbd_user_rights').html(table);

            }


        });



    }

    function userright(usertype) {
        $.get('getallprofileright/' + usertype, function(data) {
            if (data.length > 0) {
                $('input:checkbox').removeAttr('checked');
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
                        $('#_' + data[i].menuid).prop('checked', true).trigger('change');
                    }

                }
            } else {
                getallmenu();
            }

        });
    }

    $(document).on('change', "#user_type", function(e) {
        e.preventDefault();
        var usertype = $(this).val();

        userright(usertype);
    });


    $(document).on('blur', ".cpassword", function(e) {
        e.preventDefault();
        var password = $("#password").val();
        var cpassword = $('#cpassword').val();
        $("#btnsave").attr("disabled", false);


        if (password != "" && cpassword != "") {
            if (password != cpassword) {

                $("#btnsave").attr("disabled", true);
                $('#cpass_error').show();

            } else {
                $("#btnsave").attr("disabled", false);
                $('#cpass_error').hide();

            }
        }
    });

    $(document).on('blur', "#email", function(e) {
        e.preventDefault();
        var email = $("#email").val();
        var save_update = $('#save_update').val();
        if (email != "") {
            if (save_update == "") {
                $.get('checkemailaddress/' + email, function(data) {

                    if (data == 0 || data == "0") {

                        $('#checkuser_id').show();

                        $('#user_id').val(email);


                    } else {
                        swal("Email Address Already Exists Please Enter Another Email Address");
                    }
                });
            } else {
                $('#user_id').val(email);
            }


        }


    });


    $(document).on('blur', "#user_id", function(e) {
        e.preventDefault();

        var user_id = $("#user_id").val();
        var save_update = $("#save_update").val();
        // alert(email);

        if (save_update == "") {



            if (user_id != "") {
                $.get('checkaccessuserid/' + user_id, function(data) {

                    if (data == 0 || data == "0") {

                        $('#checkuser_id').show();


                    } else {
                        swal("User id Already Exists Please Enter Another User id");
                    }
                });

            }
        }

    });

    $(document).on('submit', '#master_form', function(e) {
        e.preventDefault();

        var save_update = $("#save_update").val();



        var name = $("#name").val();
        var email = $("#email").val();
        var phone = $("#phone").val();
        var user_type = $("#user_type").val();
        var user_type_hidden = $("#user_type_hidden").val();
        var user_id = $("#user_id").val();
        var password = "";
        var cpassword = "";
        if (save_update == "") {
            password = $("#password").val();
            // cpassword = $("#cpassword").val();
        } else {
            password = "";
        }




        var userpermission = [];



        if (save_update != "") {
            //  alert(fromhere)
            $.ajax({
                data: {
                    save_update: save_update,

                },
                url: useracessrightdelete,
                type: "POST",
                dataType: 'json',
                async: false,
                success: function(data) {
                    //
                    //alert(data);

                },
                error: function(data) {
                    console.log('Error:', data);
                }
            });

        }
        studejsonObj = [];
        $(".main_chk").each(function() {
            var id1 = $(this).attr('id');
            console.log(id1);
            if ($(this).prop("checked") == true) {

                id1 = id1.split("_");



                student = {};

                console.log('from checked' + id1[1]);


                if ($("#r_" + id1[1]).prop("checked") == true) {

                    student["menuid"] = id1[1];
                    student["permission"] = 0;
                    student["submenu"] = 0;

                } else if ($("#m_" + id1[1]).prop("checked") == true) {
                    console.log('from m');
                    student["menuid"] = id1[1];
                    student["permission"] = 1;
                    student["submenu"] = 0;

                } else {
                    console.log('from m');
                    student["menuid"] = id1[1];
                    student["permission"] = 1;
                    student["submenu"] = 0;

                }


                studejsonObj.push(student);

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




            }

        });

        console.log(studejsonObj);


        //  alert(groups_id);
        $.ajax({
            data: {
                studejsonObj: studejsonObj,
                save_update: save_update,

                name: name,
                email: email,
                phone: phone,
                user_id: user_id,
                password: password,
                user_type_hidden: user_type_hidden,
                user_type: user_type,
            },
            url: add_data,
            type: "POST",
            dataType: 'json',
            // async: false,
            success: function(data) {

                if (data == "100") {
                    swal("User Name Already Exists Please Enter Another User Name");
                } else if (data == "101") {
                    swal("User id OR Email  Already Exists Please Enter Another User id OR Email");
                } else {
                    $(".closehideshow").trigger('click');
                    form_clear();
                    datashow();
                    successTost("Saved Successfully");
                    $('#save_update').val('');
                }



            },
            error: function(data) {
                console.log('Error:', data);;
            }
        });


    });
    datashow();
    //for desplay in table with data ------Strat
    function datashow() {
        $.get('get_all_profile_data', function(data) {
            html = '';
            var name = '';

            html += '<option selected disabled value="" >Select</option>';

            for (i = 0; i < data.length; i++) {
                var id = '';

                name = data[i].profile_type;
                id = data[i].profile_id;



                html += '<option value="' + id + '">' + name + '</option>';
            }
            $('#user_type').html(html);
        });

        if ($.fn.DataTable.isDataTable('#laravel_crud')) {
            $('#laravel_crud').DataTable().destroy();
        }
        $('#laravel_crud tbody').empty();


        $.get('getall_useraccess', function(data) {


            var html = '';

            for (var i = 0; i < data.length; i++) {
                var sr = i + 1;
                var st = data[i].status;
                var chehc = "";

                html += '<tr>' +
                    '<td id="user_name_' + data[i].useraccess_id + '">' + data[i].user_name + '</td>' +
                    '<td id="email_id_' + data[i].useraccess_id + '">' + data[i].email_id + '</td>' +
                    //'<td style="text-align:right;" id="packagepoint_' + data[i].useraccess_id + '"> <img src="' + imgurl + '/uploads/' + data[i].instructor_img + '"  style="width:50px; height: 50px; "></td>' +
                    '<td style="text-align:right;" id="mobileno_' + data[i].useraccess_id + '">' + data[i].mobileno + '</td>' +
                    '<td style="text-align:right; display:none;" id="role_' + data[i].useraccess_id + '">' + data[i].role + '</td>' +
                    '<td style="text-align:right;" id="profile_type_' + data[i].useraccess_id + '">' + data[i].profile_type + '</td>' +
                    '<td style="text-align:right;" id="userid_' + data[i].useraccess_id + '">' + data[i].userid + '</td>' +



                    '<td class="not-export-column" ><button name="edit"  value="edit" class="edit_data btn btn-xs btn-success" id=' +
                    data[i].useraccess_id +
                    '  status=' + data[i].status + '><i class="fa fa-edit"></i></button>&nbsp;<button name="delete" value="Delete" class="delete_data btn btn-xs btn-danger" id=' +
                    data[i].useraccess_id + '><i class="fa fa-trash"></i></button></td>' + '</tr>';


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

    //Edit Button Code Strat Here
    $(document).on('click', ".edit_data", function(e) {
        e.preventDefault();

        $(".tablehideshow").hide();
        $(".formhideshow").show();

        var id = $(this).attr("id");
        var status = $(this).attr("status");
        var user_name = $('#user_name_' + id).html();
        var email_id = $('#email_id_' + id).html();
        var mobileno = $('#mobileno_' + id).html();
        var role_ = $('#role_' + id).html();
        var userid = $('#userid_' + id).html();


        $("#name").val(user_name);
        $("#email").val(email_id);
        $("#phone").val(mobileno);
        $("#user_type").val(role_).trigger('change');

        $("#user_id").val(email_id);

        $('#save_update').val(id);



        $("#user_type_hidden").val(role_);



        $('#password').removeAttr('required');
        $('#cpassword').removeAttr('required');
        $('.hidepassword').hide();

        $('#btnsave').text("Update");


        $.get('getedituserright/' + id, function(data) {
            if (data.length > 0) {
                $('input:checkbox').removeAttr('checked');
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
                        $('#_' + data[i].menuid).prop('checked', true).trigger('change');
                    }

                }
            }

        });

    });

    //form-clear
    function form_clear() {
        $("#submit_btn").attr("disabled", false);
        getallmenu();
        $('#save_update').val('');



        $("#user_type_hidden").val('');
        $("#name").val('');
        $("#email").val('');
        $("#phone").val('');
        $("#user_type").val('');

        $("#user_id").val('');
        $("#password").val('');
        $("#cpassword").val('');
        $('.hidepassword').show();
        $("#photo").attr("required", true);
        $("#password").attr("required", true);
        $("#cpassword").attr("required", true);

        $('#btnsave').text("Save");

    }
    $(document).on('click', '.closehideshow', function() {
        form_clear();
    });

    //for check same instuctor

    $(document).on('blur', "#name", function(e) {
        e.preventDefault();

        var name = $("#name").val();
        var save_update = $("#save_update").val();


        if (save_update == "") {



            if (user_id != "") {
                $.get('checkusername/' + name, function(data) {

                    if (data == 0 || data == "0") {




                    } else {
                        swal("User Access Name Already Exists Please Enter Another User Access Name");
                    }
                });

            }
        }

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




});