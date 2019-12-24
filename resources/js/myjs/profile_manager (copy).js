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
                                    '<td><input type="radio" class="mmenu_' + data[i].menuid + '" name="main_chk_' + data[i].menuid + '" value="readonly" id="r_' + data[i].menuid + '_0' + '" checked="true"/></td>' +
                                    '<td><input type="radio" class="mmenu_' + data[i].menuid + '" name="main_chk_' + data[i].menuid + '" value="modify" id="m_' + data[i].menuid + '_0' + '"/></td>' +
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
                    var employee_name = $("#employee_name").val();
                    var date = $("#date").val();
                    var user_type = $("#user_type").val();
                    var mobile = $("#mobile").val();
                    var email = $("#email").val();
                    var password = $("#password").val();
                    var groups_id = $("#group_name").val();
                    var urdata = new Array();
                    var count = 0;
                    var menu = 0;
                    var userpermission = [];

                    //  alert(groups_id);

                    // if (save_update != "") {

                    //     $.ajax({
                    //         data: {
                    //             save_update: save_update,

                    //         },
                    //         url: delete_from_user_rights,
                    //         type: "POST",
                    //         dataType: 'json',
                    //         async: false,
                    //         success: function(data) {
                    //             //

                    //         },
                    //         error: function(data) {
                    //             console.log('Error:', data);
                    //         }
                    //     });

                    // }
                    $(".main_chk").each(function() {
                            var id1 = $(this).attr('id');


                            if ($('#' + id1).prop('checked')) {


                                $(".mmenu_").each(function() {
                                        var name = $(this).attr('name');

                                        var permision = $("input[name=" + name + "]:checked").val();

                                        console.log(permision);

                                    }


                                    var id1 = $(this).attr('id'); id1 = id1.split("_");
                                    var menu = $(this).val();

                                    var premision = {};

                                    if (menu == 1 || menu == "1") {

                                        var id = id1;

                                        if ($('#main_chk_' + id[1]).prop('checked')) {
                                            urdata[count] = [id[1], 0];
                                            premision["mainmenu"] = id[1];
                                            premision["userright"] = 0;
                                            premision["submenu"] = 0;



                                        } else {
                                            urdata[count] = [id[1], 1];
                                            premision["mainmenu"] = id[1];
                                            premision["userright"] = 1;
                                            premision["submenu"] = 0;
                                        }


                                        $(".submenu_" + id[1]).each(function() {
                                            var name = $(this).attr('name');
                                            if ($('#' + name).prop('checked')) {
                                                urdata[count] = [id[1], 0];
                                                premision["mainmenu"] = id[1];
                                                premision["userright"] = 0;
                                                premision["submenu"] = 0;



                                            } else {
                                                urdata[count] = [id[1], 1];
                                                premision["mainmenu"] = id[1];
                                                premision["userright"] = 1;
                                                premision["submenu"] = 0;
                                            }

                                        });
                                        count++;

                                    }

                                }



                            });

                        console.log(urdata);


                        //  alert(groups_id);
                        $.ajax({
                            data: {
                                urdata: urdata,
                                save_update: save_update,
                                employee_name: employee_name,
                                date: date,
                                user_type: user_type,
                                groups_id: groups_id,
                                mobile: mobile,
                                email: email,
                                password: password,

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
                                successTost("Saved Successfully");
                                $('#save_update').val('');
                                datashow();
                                $("#if_yes").hide();
                                $(':input[type="submit"]').prop('disabled', false);
                            },
                            error: function(data) {
                                console.log('Error:', data);
                                //  $('#btn-save').html('Save Changes');
                            }
                        });


                    });

            });