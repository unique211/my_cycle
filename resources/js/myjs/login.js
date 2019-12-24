$(document).ready(function() {



    /*---------login-----------------*/
    $(document).on("submit", "#login_form", function(e) {
        e.preventDefault();
        var user_id = $('#user_id').val();
        var password = $('#password').val();


        $.ajax({
            data: $('#login_form').serialize(),
            url: login,
            type: "POST",
            dataType: 'json',
            success: function(data) {
                console.log(data);
                //  alert(data);
                if (data == 1 || data == "1") {
                    successTost("Login Successfully");
                    location.href = redirect;
                    //  location.href = baseurl + "Welcome/dashboard";
                } else {
                    errorTost("Invalide Login Detail");
                }

            },
            error: function(data) {
                console.log('Error:', data);

            }
        });
    });
    /*---------login-----------------*/
});