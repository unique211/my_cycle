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


        userright();
    }

    function userright() {
        $.get('getintructorright', function(data) {
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
    }


    $('#photo').change(function() {
        var id = $(this).attr('id');



        if ($(this).val() != '') {
            upload(this, id);

        }
    });

    function upload(img, id) {
        $("#wait").show();
        var form_data = new FormData();
        form_data.append('file', img.files[0]);
        //form_data.append('_token', '{{csrf_token()}}');

        $.ajax({
            url: uploadfileurl,
            data: form_data,
            type: 'POST',
            contentType: false,
            processData: false,
            success: function(data) {
                //alert(data);

                // $('#photo').val(data);
                $('#msgid').html(data);
                $('#imghidden').val(data);
                $('#profileimg').attr('src', imgurl + '/uploads/' + data);
                $("#photo").removeAttr("required");
                $("#wait").hide();
            }
        });
    }

    $(document).on('blur', ".cpassword", function(e) {
        e.preventDefault();
        $("#submit_btn").attr("disabled", false);
        var password = $("#password").val();
        var cpassword = $('#cpassword').val();
        $("#submit_btn").attr("disabled", false);


        if (password != "" && cpassword != "") {
            if (password != cpassword) {

                $("#submit_btn").attr("disabled", true);
                $('#cpass_error').show();

            } else {
                $("#submit_btn").attr("disabled", false);
                $('#cpass_error').hide();

            }
        }
    });


    $(document).on('blur', "#user_id", function(e) {
        e.preventDefault();
        $("#submit_btn").attr("disabled", false);
        var user_id = $("#user_id").val();
        var save_update = $("#save_update").val();
        // alert(email);

        if (save_update == "") {



            if (user_id != "") {
                $.get('checkuserid/' + user_id, function(data) {

                    if (data == 0 || data == "0") {

                        $("#user_id").val(user_id);
                        $("#submit_btn").attr("disabled", false);

                    } else {
                        swal("User id Already Exists Please Enter Another User id");
                        $("#user_id").val('');
                        $("#submit_btn").attr("disabled", true);
                    }
                });

            }
        }

    });

    $(document).on('submit', '#master_form', function(e) {
        e.preventDefault();

        var save_update = $("#save_update").val();
        var ins_id = $("#ins_id").val();


        var name = $("#name").val();
        var tel_no = $("#tel_no").val();
        var imghidden = $("#imghidden").val();
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

            $.ajax({
                data: {
                    save_update: save_update,

                },
                url: instrucotrdel,
                type: "POST",
                dataType: 'json',
                async: false,
                success: function(data) {
                    //
                    //  alert(data);

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
                ins_id: ins_id,
                name: name,
                tel_no: tel_no,
                imghidden: imghidden,
                user_id: user_id,
                password: password,
                cpassword: cpassword,
                //  user_type: 'Instructor',
            },
            url: add_data,
            type: "POST",
            dataType: 'json',
            // async: false,
            success: function(data) {

                if (data == "100") {
                    swal("Instructor Name Already Exists Please Enter Another Instructor Name");
                } else if (data == "101") {
                    swal("User id Already Exists Please Enter Another User id");
                } else {
                    $(".closehideshow").trigger('click');
                    form_clear();
                    successTost("Saved Successfully");
                    $('#save_update').val('');
                    datashow();
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
        if ($.fn.DataTable.isDataTable('#laravel_crud')) {
            $('#laravel_crud').DataTable().destroy();
        }
        $('#laravel_crud tbody').empty();

        $.get('getall_instructor', function(data) {


            var html = '';

            for (var i = 0; i < data.length; i++) {
                var sr = i + 1;
                var st = data[i].status;
                var chehc = "";

                html += '<tr>' +
                    '<td id="instructor_id_' + data[i].instructorid + '">' + data[i].instructor_id + '</td>' +
                    '<td id="instructor_name_' + data[i].instructorid + '">' + data[i].instructor_name + '</td>' +
                    '<td style="text-align:right;" id="packagepoint_' + data[i].instructorid + '"> <img src="' + imgurl + '/uploads/' + data[i].instructor_img + '"  style="width:50px; height: 50px; "></td>' +
                    '<td style="text-align:right;" id="instructor_telno_' + data[i].instructorid + '">' + data[i].instructor_telno + '</td>' +
                    '<td style="text-align:right;display:none;" id="instructor_img' + data[i].instructorid + '">' + data[i].instructor_img + '</td>' +
                    '<td style="text-align:right;display:none;" id="userid_' + data[i].instructorid + '">' + data[i].userid + '</td>' +



                    '<td class="not-export-column" ><button name="edit"  value="edit" class="edit_data btn btn-xs btn-success" id=' +
                    data[i].instructorid +
                    '  status=' + data[i].status + '><i class="fa fa-edit"></i></button>&nbsp;<button name="delete" value="Delete" class="delete_data btn btn-xs btn-danger" id=' +
                    data[i].instructorid + '><i class="fa fa-trash"></i></button></td>' + '</tr>';


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
        var instructor_name = $('#instructor_name_' + id).html();
        var instructor_id_ = $('#instructor_id_' + id).html();
        var instructor_telno = $('#instructor_telno_' + id).html();
        var instructor_img = $('#instructor_img' + id).html();
        var userid = $('#userid_' + id).html();
        // alert(userid);

        $('#ins_id').val(instructor_id_);
        $('#name').val(instructor_name);
        $('#tel_no').val(instructor_telno);
        $('#user_id').val(userid);
        $('#imghidden').val(instructor_img);
        $('#msgid').html(instructor_img);
        $('#save_update').val(id);

        if (instructor_img == "") {

            $("#photo").attr("required", true);
        } else {
            $('#photo').removeAttr('required');
        }

        $('#profileimg').attr('src', imgurl + '/uploads/' + instructor_img);



        $('#password').removeAttr('required');
        $('#cpassword').removeAttr('required');
        $('.hidepassword').hide();

        $('#btnsave').text("Update");


        $.get('geteditintructorright/' + id, function(data) {
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
        getallmenu();
        $("#submit_btn").attr("disabled", false);
        $('#ins_id').val('');
        $('#name').val('');
        $('#tel_no').val('');
        $('#user_id').val('');
        $('#imghidden').val('');
        $('#msgid').html('');
        $('#save_update').val('');
        $('#profileimg').attr('src', imgurl + '/resources/sass/img/no-image-available.png/');

        $('.hidepassword').show();
        $("#photo").attr("required", true);
        $("#password").attr("required", true);
        $("#cpassword").attr("required", true);
        $("#password").val('');
        $("#cpassword").val('');

    }

    $(document).on('click', '.closehideshow', function() {
        form_clear();
    });

    //for check same instuctor

    $(document).on('blur', "#name", function(e) {
        e.preventDefault();

        var name = $("#name").val();
        var save_update = $("#save_update").val();
        // alert(email);

        if (save_update == "") {



            if (user_id != "") {
                $.get('checkinstuctorname/' + name, function(data) {

                    if (data == 0 || data == "0") {




                    } else {
                        swal("Instructor Already Exists Please Enter Another Instructor");
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