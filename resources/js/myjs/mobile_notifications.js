$(document).ready(function() {

    getallmembers();




    var member_count = 0;
    var member_list = "";

    var menu = 4;
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





    function getallmembers() {


        $.ajax({
            type: "GET",
            url: 'get_all_members',
            dataType: "JSON",

            async: false,
            success: function(data) {
                var table = "";
                for (var i = 0; i < data.length; i++) {
                    table += '<tr>' +
                        '<td><span ><input type="checkbox"  id="_' + data[i].linkrelid + '" name="' + data[i].linkrelid + '" class="main_chk"  value="0"></span></td>' +
                        '<td>' + data[i].userid + '</td>' +
                        '<td>' + data[i].name + '</td>' +
                        '</tr>';

                }
                $('#tbd_user_rights').html(table);

            }


        });


        // userright();
    }

    function form_clear() {

        $("#notification").val('');
        $("#save_update").val('');
        $(".main_chk").prop('checked', false);
        $("#select_all").prop('checked', false);


    }

    $(document).on('change', "#select_all", function(e) {
        e.preventDefault();
        if ($(this).is(":checked")) {
            $(this).val(1);
            $(".main_chk").prop('checked', true);
            $(".main_chk").val(1);
            members();

        } else {
            $(this).val(0);
            $(".main_chk").prop('checked', false);
            $(".main_chk").val(0);
            members();
        }

    });

    $(document).on('change', ".main_chk", function(e) {
        e.preventDefault();
        $("#select_all").prop('checked', false);
        if ($(this).is(":checked")) {
            $(this).val(1);

            members();

        } else {
            $(this).val(0);
            members();
        }

    });

    function members() {

        var member_list1 = "";
        var count = 0;
        $(".main_chk").each(function() {
            var member = $(this).attr('id');

            if ($(this).prop("checked") == true) {
                member = member.split("_");

                if (member_list1 == "") {
                    member_list1 = member[1];
                    count = 1;
                } else {
                    member_list1 = member_list1 + ',' + member[1];
                    count = count + 1;
                }

            }


        });
        member_count = count;
        member_list = member_list1;
        // alert(member_list);

    }






    $(document).on('submit', '#master_form', function(e) {
        e.preventDefault();
        //alert("in submit");
        var save_update = $("#save_update").val();
        var notification_text = $("#notification").val();
        // var ins_id = $("#ins_id").val();


        if (member_count == 0) {
            swal("Member Not Selected", "Hey, Atleast Save 1 Member to Send Notification !!", "error");
        } else {
            //  alert(groups_id);
            $.ajax({
                data: {

                    save_update: save_update,
                    count: member_count,
                    member_list: member_list,
                    notification_text: notification_text,
                    //  user_type: 'Instructor',
                },
                url: add_data,
                type: "POST",
                dataType: 'json',
                // async: false,
                success: function(data) {


                    $(".closehideshow").trigger('click');
                    form_clear();
                    successTost("Saved Successfully");
                    $('#save_update').val('');
                    datashow();
                },
                error: function(data) {
                    console.log('Error:', data);;
                }




            });
        }





    });
    datashow();
    // for desplay in table with data ------Strat
    function datashow() {
        if ($.fn.DataTable.isDataTable('#laravel_crud')) {
            $('#laravel_crud').DataTable().destroy();
        }
        $('#laravel_crud tbody').empty();

        $.get('get_all_notifications', function(data) {

            var data = eval(data);
            var html = '';

            for (var i = 0; i < data.length; i++) {
                var sr = i + 1;

                var date = data[i].updated_at;
                var fdateslt = date.split('-');
                var time = fdateslt[2].split(' ');
                var updated_at = time[0] + '/' + fdateslt[1] + '/' + fdateslt[0] + ' ' + time[1];


                var notification = "";
                var notification_text = data[i].notification_text;

                //   alert(notification_text);
                if (notification_text.length > 105) {
                    notification = notification_text.substring(0, 100) + '.....';
                } else {
                    notification = notification_text;
                }


                html += '<tr>' +
                    '<td id="id_' + data[i].id + '">' + sr + '</td>' +
                    '<td id="classcategoryname_' + data[i].id + '">' + updated_at + '</td>' +
                    '<td id="classcategoryname_' + data[i].id + '">' + notification + '</td>' +
                    '<td id="categorydescription_' + data[i].id + '">' + data[i].count + '</td>';



            }

            $('#table_tbody').html(html);
            $('#laravel_crud').DataTable({
                "fnDrawCallback": function() {
                    jQuery('#laravel_crud .btnstatus').bootstrapToggle();
                }
            });
            $('.btnstatus').bootstrapToggle({
                on: 'Active',
                off: 'Inactive'
            });

        })

    }





    $(document).on('click', '.closehideshow', function() {
        form_clear();
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