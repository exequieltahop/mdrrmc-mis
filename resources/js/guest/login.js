$(function() {
    // login
    $('#form_login').on('submit', function(e){
        e.preventDefault();

        const uri = `/login-user`;
        const data = $(this).serialize();

        // disable btn login
        $('#btn_login').prop('disabled', true);

        $.ajax({
            url : uri,
            type : 'POST',
            data : data,
            success : function(response){
                // dd
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

// document.addEventListener('DOMContentLoaded', async ()=>{
//     login();
// });

// login
function login(){
    const form = document.getElementById('form_login');
    console.log(form);
    form.onsubmit = async (e)=>{
        e.preventDefault();

        const btn_login = document.getElementById('btn_login');

        btn_login.disabled = true;

        try {
            const response = await fetch('/login-user', {
                method : 'POST',
                headers: token,
                data : new FormData(e.target)
            });

            const response_json = await response.json();

            if(response_json.special_error){
                throw new Error(response_json.special_error);
            }

            else if (response_json.success){
                toastr.success("Successfully Login, Redirecting...");

                // redirect 1.5s
                setInterval(()=>{
                    btn_login.disabled = true;
                    window.location.href = response.url
                }, 1500);
            }
        } catch (error) {
            btn_login.disabled = false;
            console.log(error.message);
            toastr.error("Failed to Log in!, Please Try Again, If the problem persist contact developer", 'Error');
        }
    };
}
