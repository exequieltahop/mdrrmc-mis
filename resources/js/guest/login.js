$(function() {

    // login
    $('#form_login').on('submit', function(e){
        e.preventDefault();

        const uri = `login-user`;
        const data = $(this).serialize();

        // disable btn login
        $('#btn_login').prop('disabled', true);

        $.ajax({
            url : uri,
            type : 'POST',
            data : data,
            success : function(response){
                if(response.success){
                    // alert
                    toastr.success("Successfully Login, Redirecting...");

                    // enable button again
                    $('#btn_login').prop('disabled', false);

                    // redirect 1.5s
                    setInterval(()=>{ window.location.href = response.url }, 1500);
                }
            },
            error : function(jqHXR, error){
                // enable button again
                $('#btn_login').prop('disabled', false);

                // if special error
                if(jqHXR.responseJSON.special_error){
                    console.log(jqHXR.responseJSON.special_error);
                    toastr.error(jqHXR.responseJSON.special_error, 'Error');
                }

                // if error
                else if(jqHXR.responseJSON.error){
                    console.log(jqHXR.responseJSON.error);
                    toastr.error(jqHXR.responseJSON.error, 'Error');
                }

            },
        });
    });

    // Show password
    $('#show_password').on('change', function(e) {
        if ($(this).is(':checked')) {
            $('#password').prop('type', 'text');
        } else {
            $('#password').prop('type', 'password');
        }
    });
});
