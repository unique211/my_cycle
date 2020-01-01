$(document).ready(function() {

    var menu = 4;
    var rights = 1;
    user_access_rights();

    function user_access_rights() {

        $(".btnhideshow").show();

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

                    $(':input[type="submit"]').show();
                    rights = 1;
                }
            }
        });
    }

    $(document).on('click', '#plus2', function() {
        var id = $('#tbl_id').val();
        id = parseInt(id) + parseInt(1);

        table = '<tr class="tblusername" id="tbluserid_' + id + '">' +
            '<td><input type="text" name="rel_name_' + id + '" id="rel_name_' + id + '" class="form-control" placeholder="Name"></td>' +

            '<td><input type="text" name="relation_' + id + '" id="relation_' + id + '" class="form-control" placeholder="Relationship"></td>' +
            '<td><input type="number" name="rel_user_id_' + id + '" id="rel_user_id_' + id + '" class="form-control checkuserid" placeholder="User Id"></td>' +

            '<td><input type="password" name="rel_password_' + id + '" id="rel_password_' + id + '" placeholder="Password" class="form-control"></td>' +
            '<td>' +

            ' <button type="button" name="delete_' + id + '" id="tbluserid_' + id + '" value="Delete" class="btn delete_data1 btn-danger"><i class="fa fa-trash"></i></button></td></tr>';
        $('#file_info_tbody2').append(table);
        $('#tbl_id').val(id);
        // $('#row').val(row_id);
        $('#ids').val('');
    });

    $(document).on('click', '.delete_data1', function() {
        if (confirm("Are you sure you want to delete this?")) {
            $(this).parents("tr").remove();
        } else {
            return false;
        }
    });


    // $(document).on('click', '.edit_data', function() {
    //     $(".tablehideshow").hide();
    //     $(".formhideshow").show();
    //     $(".deletehideshow").show();
    //     $(".viewhideshow").hide();

    //     $("#user_id").val('ajaz');
    //     $("#name").val('Ajazkhan');
    //     $("#ic_number").val('1111');
    //     $("#address").val('rajkot');

    // });

    $(document).on('click', '.view_data', function() {
        $(".tablehideshow").hide();
        $(".formhideshow").hide();
        $(".viewhideshow").show();
        $(".deletehideshow").show();

        $("#user_id").val('ajaz');
        $("#name").val('Ajazkhan');
        $("#ic_number").val('1111');
        $("#address").val('rajkot');

    });
    $(document).on('blur', '#user_id', function() {
        var user_id = $("#user_id").val();
        $("#submit_btn").attr("disabled", false);
        if (user_id != "") {
            $.get('checkuserid_member/' + user_id, function(data) {

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

    });
    $(document).on('click', '.closehideshow', function() {
        $(".deletehideshow").hide();
        $(".viewhideshow").hide();

        $("#user_id").val('');
        $("#name").val('');
        $("#ic_number").val('');
        $("#address").val('');
        $("#if_edit").hide();
        form_clear();
    });

    $(document).on('change', '#member_type', function() {
        var member_type = $("#member_type").val();
        $("#if_group").hide();
        $("#file_info_tbody2").html('');
        if (member_type == "Individual") {

            $("#if_group").hide();

        } else {
            $("#if_group").show();


        }

    });

    $('#upload').change(function() {
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

                //   $('#upload').val('');
                $('#msg').html(data);
                $('#uploadimg_hidden').val(data);
                $("#wait").hide();

            }
        });
    }

    $(document).on('submit', '#master_form', function(e) {
        e.preventDefault();
        var save_update = $('#save_update').val();
        var user_id = $('#user_id').val();
        var password = $('#password').val();
        var name = $('#name').val();

        var dob = $('#dob').val();
        var ic_number = $('#ic_number').val();

        var max_vacancy = $('#max_vacancy').val();
        var address = $('#address').val();
        var email = $('#email').val();
        var package = $('#package').val();
        var doe = $('#doe').val();
        var bal_point = $('#bal_point').val();
        var uploadimg_hidden = $('#uploadimg_hidden').val();
        var member_type = $('#member_type').val();

        var tdateAr = dob.split('/');
        dob = tdateAr[2] + '-' + tdateAr[1] + '-' + tdateAr[0];

        var tdateAr = doe.split('/');
        doe = tdateAr[2] + '-' + tdateAr[1] + '-' + tdateAr[0];

        var l1 = $('table#student').find('tbody').find('tr');
        var r = l1.length;
        var sr = 0;
        studejsonObj = [];
        student = {}
        student["relname"] = name;
        student["relation"] = "Main Member";
        student["reluserid"] = user_id;
        student["password"] = password;
        studejsonObj.push(student);

        if (save_update != "") {
            $.ajax({
                data: {
                    save_update: save_update,

                },
                url: deletemember,
                type: "POST",
                dataType: 'json',
                async: false,
                success: function(data) {
                    //


                },
                error: function(data) {
                    console.log('Error:', data);
                }
            });

        }

        $(".tblusername").each(function() {
            var id1 = $(this).attr('id');
            relation = {}
            id1 = id1.split("_");

            var relname = $('#rel_name_' + id1[1]).val();
            var relation = $('#relation_' + id1[1]).val();
            var reluser_id = $('#rel_user_id_' + id1[1]).val();
            var password = $('#rel_password_' + id1[1]).val();

            student = {}

            student["relname"] = relname;
            student["relation"] = relation;
            student["reluserid"] = reluser_id;
            student["password"] = password;

            studejsonObj.push(student);


        });



        $.ajax({
            data: {
                studejsonObj: studejsonObj,
                user_id: user_id,
                password: password,
                name: name,
                ic_number: ic_number,
                dob: dob,
                address: address,
                email: email,
                package: package,
                doe: doe,
                bal_point: bal_point,
                member_type: member_type,
                uploadimg_hidden: uploadimg_hidden,
                save_update: save_update,

            },
            url: add_data,
            type: "POST",
            dataType: 'json',
            // async: false,
            success: function(data) {

                form_clear();
                successTost("Opration Save Success fully!!!");
                datashow();
                $(".tablehideshow").show();
                $(".formhideshow").hide();
                $(".deletehideshow").show();
                $(".viewhideshow").hide();
            }

        });





        $('#statusinfo').val(status);




    });

    //for get all package
    getallpackage();

    function getallpackage() {

        $.ajax({
            url: "getdropdwnallpackage",
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

                    name = data[i].package_name;
                    id = data[i].packege_id;



                    html += '<option value="' + id + '">' + name + '</option>';
                }
                $('#package').html(html);

            }
        });
    }




    //for get all member type
    get_member_type();

    function get_member_type() {

        $.ajax({
            url: "getallmemberttype",
            type: "GET",

            contentType: false,
            cache: false,
            processData: false,
            dataType: "json",
            success: function(data) {

                var html = '';
                var name = '';

                html += '<option selected  value="Individual" >Individual</option>';

                for (i = 0; i < data.length; i++) {
                    var id = '';

                    name = data[i].member_type;
                    id = data[i].membertype_id;



                    html += '<option value="' + id + '">' + name + '</option>';
                }
                $('#member_type').html(html);

            }
        });
    }

    //get package point
    $(document).on('change', '#package', function(e) {
        e.preventDefault();
        var package = $(this).val();
        $.ajax({
            data: {
                package: package,

            },
            url: getpackagepoint,
            type: "POST",
            dataType: 'json',
            // async: false,
            success: function(data) {
                if (data.length > 0) {
                    $('#bal_point').val(data[0].package_point);
                }
            }

        });

    });
    datashow();

    function datashow() {
        if ($.fn.DataTable.isDataTable('#laravel_crud')) {
            $('#laravel_crud').DataTable().destroy();
        }
        $('#laravel_crud tbody').empty();

        $.get('getallmember', function(data) {

            var data = eval(data);
            var html = '';

            for (var i = 0; i < data.length; i++) {
                var sr = i + 1;
                var st = data[i].status;
                var chehc = "";
                var des = "";
                var doe = "";
                if (data[i].dateofexpire != "") {
                    var tdateAr = data[i].dateofexpire.split('-');
                    doe = tdateAr[2] + '/' + tdateAr[1] + '/' + tdateAr[0];
                }


                // var tdateAr = doe.split('/');
                // doe = tdateAr[2] + '-' + tdateAr[1] + '-' + tdateAr[0];


                html += '<tr>' +
                    '<td id="userid_' + data[i].member_id + '">' + data[i].user_id + '</td>' +
                    '<td id="membername_' + data[i].member_id + '">' + data[i].membername + '</td>' +
                    '<td id="icno_' + data[i].member_id + '">' + data[i].icno + '</td>' +
                    '<td id="packagename_' + data[i].member_id + '">' + data[i].packagename + '</td>' +
                    '<td id="membertype_' + data[i].member_id + '">' + data[i].membertype + '</td>' +
                    '<td style="display:none;" id="membertype_id_' + data[i].member_id + '">' + data[i].membertype_id + '</td>' +
                    '<td id="doe_' + data[i].member_id + '">' + doe + '</td>' +
                    '<td id="membercount_' + data[i].member_id + '">' + data[i].membercount + '</td>' +

                    '<td style="display:none;" id="dob_' + data[i].member_id + '">' + data[i].dob + '</td>' +
                    '<td style="display:none;" id="address_' + data[i].member_id + '">' + data[i].address + '</td>' +
                    '<td style="display:none;" id="image_url_' + data[i].member_id + '">' + data[i].image_url + '</td>' +
                    '<td style="display:none;" id="email_' + data[i].member_id + '">' + data[i].email + '</td>' +
                    '<td style="display:none;" id="currentpackage_' + data[i].member_id + '">' + data[i].currentpackage + '</td>' +
                    '<td style="display:none;" id="balancepoint_' + data[i].member_id + '">' + data[i].balancepoint + '</td>' +
                    '<td style="display:none;" id="password_' + data[i].member_id + '">' + data[i].password + '</td>';


                if (rights == 1) {
                    html += '<td class="not-export-column" ><button name="view"  value="view" class="btn btn-xs btn-warning view_data" id=' +
                        data[i].member_id +
                        ' ><i class="fa fa-eye"></i></button>&nbsp;<button name="edit"  value="edit" class="edit_data btn btn-xs btn-success" id=' +
                        data[i].member_id +
                        '  status=' + data[i].status + '><i class="fa fa-edit"></i></button>&nbsp;<button name="delete" value="Delete" class="delete_data btn btn-xs btn-danger" id=' +
                        data[i].member_id + '><i class="fa fa-trash"></button></td>' + '</tr>';
                } else {
                    html += '<td class="not-export-column" ><button name="view"  value="view" class="btn btn-xs btn-warning view_data" id=' +
                        data[i].member_id +
                        ' ><i class="fa fa-eye"></i></button></td>' + '</tr>';
                }





            }

            $('#table_tbody').html(html);
            $('#laravel_crud').DataTable({

            });


        })
    }

    //Edit Button Code Strat Here
    $(document).on('click', ".view_data", function(e) {
        e.preventDefault();
        $(".tablehideshow").hide();
        $(".formhideshow").hide();
        $(".deletehideshow").hide();
        $(".viewhideshow").show();


        var id = $(this).attr("id");
        var status = $(this).attr("status");
        var userid = $('#userid_' + id).html();
        var membername = $('#membername_' + id).html();
        var icno = $('#icno_' + id).html();
        var membertype = $('#membertype_' + id).html();
        var doe = $('#doe_' + id).html();
        var dob_ = $('#dob_' + id).html();
        var address_ = $('#address_' + id).html();
        var email_ = $('#email_' + id).html();
        var currentpackage_ = $('#currentpackage_' + id).html();
        var balancepoint_ = $('#balancepoint_' + id).html();
        var image_url_ = $('#image_url_' + id).html();
        var password = $('#password_' + id).html();

        if (password == null) {
            password = "";
        }
        if (dob_ != "") {
            var tdateAr = dob_.split('-');
            dob_ = tdateAr[2] + '/' + tdateAr[1] + '/' + tdateAr[0];
        }

        $('#user_id_v').text(userid);
        $('#password_v').text(password);
        $('#name_v').text(membername);

        $('#dob_v').text(dob_);
        $('#ic_number').text(icno);


        $('#address_v').text(address_);
        $('#email_v').text(email_);
        $('#package_v').text(currentpackage_);
        $('#doe_v').text(doe);
        $('#bal_point_v').text(balancepoint_);
        $('#member_type_v').text(membertype);


        $.ajax({
            data: {
                id: id,

            },
            url: getgroupinfo,
            type: "POST",
            dataType: 'json',
            // async: false,
            success: function(data) {
                var sr = 0;
                if (data.length > 0) {
                    for (var i = 0; i < data.length; i++) {
                        sr = sr + 1;
                        $('#linkrelationdata').show();
                        var table = '<tr>' +
                            '<td> ' + data[i].name + ' </td>' +
                            '<td> ' + data[i].relation + ' </td>' +
                            '<td> ' + data[i].userid + '</td>' +
                            '<td> ' + data[i].password + ' </td>' +
                            '</tr>';
                        $('#file_info_tbody2_v').html(table);

                    }
                } else {
                    $('#linkrelationdata').hide();
                }

            }

        });





        $.ajax({
            type: "GET",
            url: getpointusage + '/' + id,
            success: function(data) {
                var sr = 0;
                var html = '';
                for (var i = 0; i < data.length; i++) {
                    html += '<tr>' +
                        '<td id="userid_' + data[i].id + '">' + data[i].date_time + '</td>' +
                        '<td id="membername_' + data[i].id + '">' + data[i].user_id + '</td>' +
                        '<td id="icno_' + data[i].id + '">' + data[i].class_name + '</td>' +
                        '<td id="packagename_' + data[i].id + '">' + data[i].point_use + '</td>' +
                        '<td id="packagename_' + data[i].id + '">' + data[i].Instructor + '</td>' +
                        '</tr>';

                }
                $('#history_tbody2').html(html);

            }
        });





    });

    //Edit Button Code Strat Here
    $(document).on('click', ".edit_data", function(e) {
        e.preventDefault();
        $(".tablehideshow").hide();
        $(".formhideshow").show();
        $(".deletehideshow").show();
        $(".viewhideshow").hide();
        $('#history_tbody').html('');


        $("#if_edit").show();
        var id = $(this).attr("id");
        var status = $(this).attr("status");
        var userid = $('#userid_' + id).html();
        var membername = $('#membername_' + id).html();
        var icno = $('#icno_' + id).html();
        var membertype = $('#membertype_id_' + id).html();
        var doe = $('#doe_' + id).html();
        var dob_ = $('#dob_' + id).html();
        var address_ = $('#address_' + id).html();
        var email_ = $('#email_' + id).html();
        var currentpackage_ = $('#currentpackage_' + id).html();
        var balancepoint_ = $('#balancepoint_' + id).html();
        var password = $('#password_' + id).html();
        var image_url_ = $('#image_url_' + id).html();
        if (password == null) {
            password = "";
        }
        if (dob_ != "") {
            var tdateAr = dob_.split('-');
            dob_ = tdateAr[2] + '/' + tdateAr[1] + '/' + tdateAr[0];
        }

        if (membertype == 0) {
            $('#member_type').val('Individual').trigger('change');
        } else {
            $('#member_type').val(membertype).trigger('change');
        }

        $('#user_id').val(userid);
        $('#password').val(password);
        $('#name').val(membername);
        $('#save_update').val(id);

        $('#dob').val(dob_);
        $('#ic_number').val(icno);


        $('#address').val(address_);
        $('#email').val(email_);
        $('#package').val(currentpackage_).trigger('change');
        $('#doe').val(doe);

        $('#bal_point').val(balancepoint_);




        if (image_url_ == "") {
            $("#upload").attr("required", true);
        } else {
            $("#upload").removeAttr("required");
        }
        $('#uploadimg_hidden').val(image_url_);
        $('#msg').html(image_url_);



        $.ajax({
            data: {
                id: id,

            },
            url: getgroupinfo,
            type: "POST",
            dataType: 'json',
            // async: false,
            success: function(data) {
                var sr = 0;
                for (var i = 0; i < data.length; i++) {
                    var table = '<tr class="tblusername" id="tbluserid_' + sr + '">' +
                        '<td><input type="text" name="rel_name_' + sr + '" id="rel_name_' + sr + '" class="form-control" value="' + data[i].name + '" placeholder="Name"></td>' +

                        '<td><input type="text" name="relation_' + sr + '" id="relation_' + sr + '" value="' + data[i].relation + '" class="form-control" placeholder="Relationship"></td>' +
                        '<td><input type="number" name="rel_user_id_' + sr + '" id="rel_user_id_' + sr + '" class="form-control checkuserid" value="' + data[i].userid + '"  placeholder="User Id"></td>' +

                        '<td><input type="password" name="rel_password_' + sr + '"  value="' + data[i].password + '" id="rel_password_' + sr + '" placeholder="Password" class="form-control"></td>' +
                        '<td>' +

                        ' <button type="button" name="delete_' + sr + '" id="tbluserid_' + sr + '" value="Delete" class="btn delete_data1 btn-danger"><i class="fa fa-trash"></i></button></td></tr>';
                    $('#file_info_tbody2').append(table);
                    $('#tbl_id').val(sr);
                }

            }

        });

        if ($.fn.DataTable.isDataTable('#history')) {
            $('#history').DataTable().destroy();
        }
        $('#history tbody').empty();

        // alert(getpointusage);


        $.ajax({
            type: "GET",
            url: getpointusage + '/' + id,
            success: function(data) {
                var sr = 0;
                var html = '';
                for (var i = 0; i < data.length; i++) {
                    html += '<tr>' +
                        '<td id="userid_' + data[i].id + '">' + data[i].date_time + '</td>' +
                        '<td id="membername_' + data[i].id + '">' + data[i].user_id + '</td>' +
                        '<td id="icno_' + data[i].id + '">' + data[i].class_name + '</td>' +
                        '<td id="packagename_' + data[i].id + '">' + data[i].point_use + '</td>' +
                        '<td id="packagename_' + data[i].id + '">' + data[i].Instructor + '</td>' +
                        '</tr>';

                }
                $('#history_tbody').html(html);
                $('#history').DataTable({

                });
            }
        });






    });


    //form clear
    function form_clear() {

        $('#user_id').val('');
        $('#password').val('');
        $('#name').val('');
        $('#save_update').val('');

        $('#dob').val('');
        $('#ic_number').val('');


        $('#address').val('');
        $('#email').val('');
        $('#package').val('');
        $('#doe').val('');

        $('#bal_point').val('');

        $('#member_type').val('');



        $('#user_id').val('');
        $('#password').val('');
        $('#name').val('');

        $('#dob').val('');
        $('#ic_number').val('');


        $('#address').val('');
        $('#email').val('');
        $('#package').val('').trigger('change');
        $('#doe').val('');
        $('#bal_point').val('');
        $('#member_type').val('').trigger('change');

        $('#upload').val('');
        $('#uploadimg_hidden').val('');
        $('#msg').html('');
        $("#submit_btn").attr("disabled", false);
        $('#history_tbody').html('');
        $('#history_tbody2').html('');
    }

    //delete of member

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


    //blur event of userid
    $(document).on('blur', '.checkuserid', function() {
        var userid = $(this).val();
        var id = $('#save_update').val();
        var url = "";
        if (id == "") {
            url = checkuseridexis + "/" + userid;
        } else {
            url = checkuseridexis + "/" + userid + "/" + id;
        }

        $.ajax({
            type: "GET",
            url: url,
            success: function(data) {

                if (data == 0) {
                    $("#btnsave").attr("disabled", false);

                } else {
                    $("#btnsave").attr("disabled", true);
                    swal("User id Already Exists Please Enter Another User id");

                }


            },
            error: function(data) {
                console.log('Error:', data);
            }
        });

    });


});
