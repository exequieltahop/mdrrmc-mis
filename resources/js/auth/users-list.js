import DataTable from "datatables.net-dt";
import Swal from "sweetalert2";
import toastr from "toastr";

window.onload = async ()=>{
    // get csrf-token
    const token = document.querySelector('meta[name="csrf-token"]').content;

    // new data table users list
    const users_list_table = new DataTable('#users-list-table',{
        responsive : true
    });

    // add user init submit form
    add_user();

    // init form reset add user
    dismiss_btn_modal_add_user_click();

    // init delete
    delete_user(users_list_table, token);

    // init edit user
    edit_user(users_list_table, token);
};


// add user
function add_user(){
    const form = document.getElementById('form-add-user'); // get add user form

    // submit form add user
    form.onsubmit = async (e)=>{
        e.preventDefault();

        const submit_btn = document.getElementById('submit-add-user-btn'); // get submit btn

        submit_btn.disabled = true; // disable btn true

        // form data
        const formData = new FormData(e.target);

        // validate password and confirm password if the same
        if(formData.get('password') != formData.get('password_confirmation')){
            toastr.error("Password and confirm pasword not the same", "Error");
            submit_btn.disabled = false; // disable btn false
        }else{ // if the same add user
            try {
                // set up fetch api post request
                const uri = `/add-new-user`;

                const response = await fetch(uri, {
                    method : 'POST',
                    body : formData
                });

                // check status code and display toastr notification base on the status request
                if(response.status == 200){
                    toastr.success("Successfully Added User!", "Success"); // display success message

                    // reload page
                    setTimeout(()=>{
                        window.location.reload();
                    },1500);

                } else if (response.status == 422) {
                    toastr.error("Failed to register user, email may already exist!", "Error");
                } else if (response.status == 500) {
                    toastr.error("Unexpected error, Please contact developer! Thank you!", "Error");
                }

                submit_btn.disabled = false; // disable btn false
            } catch (error) {
                /**
                 * display error
                 * log error
                 * enable btn again
                 */
                toastr.error("Failed to add user!, Please try again", "Error");
                console.error(error.message);
                submit_btn.disabled = false;
            }
        }

    };
}

// modal add user btn dismiss click
function dismiss_btn_modal_add_user_click(){
    const btn_dismiss = document.getElementById('btn-dismiss-modal');
    const form = document.getElementById('form-add-user');

    btn_dismiss.onclick = (e)=>{
        e.stopImmediatePropagation();

        form.reset();
    };
}

// delete user
function delete_user(table, token){
    table.on('click', '.delete-user-btn', function(e){
        e.stopImmediatePropagation();

        const id = e.currentTarget.getAttribute('data-id');

        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then(async (result) => {
            if (result.isConfirmed) {
                try {
                    const url = `/delete-user/${id}`; // uri

                    // fetch api delete request
                    const response = await fetch(url, {
                        method : 'DELETE',
                        headers : {
                            'X-CSRF-TOKEN' : token
                        }
                    });

                    // if success
                    if(response.ok){
                        toastr.success("Successfully Deleted user");
                        setTimeout(()=>{
                            window.location.reload();
                        },1500);
                    }

                    // if error
                    if(!response.ok){
                        toastr.error("Failed to delete user, Pls try again, If the problem persist pls contact developer!, Thank you");
                    }
                } catch (error) {
                    console.error(error.message);
                    toastr.error("Unexpected Error, Please Again!, If the problem persist contact developer!", "Error");
                }
            }
        });
    });
}

// edit user init
function edit_user(table, token){
    table.on('click', '.edit-record-btn', async function(e){ // add click event in the edit btn for user
        e.stopImmediatePropagation();

        /**
         * get id , edit modal,
         * and input fields for edit form user
         */
        const id = e.currentTarget.dataset.id;
        const edit_modal = new bootstrap.Modal(document.getElementById('edit-user-modal'));

        const edit_id = document.getElementById('edit_id');
        const name = document.getElementById('edit_name');
        const email = document.getElementById('edit_email');
        const new_password = document.getElementById('edit_new_password');
        const confirm_new_password = document.getElementById('edit_new_password_confirmation');

        /**
         * try and catch
         * fetch api
         * fetch user data for editing
         */
        try {
            const response = await fetch(`/get-user-data/${id}`);

            /**
             * check if response was not okay
             * if not then throw new Error
             */
            if(!response.ok){
                throw new Error("Failed to get user data");
            }
            /**
             * else parse json response then assign the name and email value
             */
            else{
                const response_json = await response.json();
                const data = response_json.data;

                edit_id.value = id;
                name.value = data.name;
                email.value = data.email;

                // init edit user
                submit_edit_user_form(new_password, confirm_new_password, token);
            }
        } catch (error) { // catch errors
            toastr.error("Something Went Wrong!, Pls try again!, If the problem persist contact developer!", "Error");
            console.error(error.message);
        } finally { // finally show modal
            edit_modal.show();
        }
    })
}

// submit edit form
function submit_edit_user_form(new_password, confirm_new_password, token){
    const form = document.getElementById('edit-user-form');

    form.onsubmit = async (e)=>{
        e.preventDefault();

        const submit_btn = document.getElementById('submit-edit-user-btn');

        submit_btn.disabled = true;

        try {
            const formData = new FormData(e.target);

            const data = Object.fromEntries(formData.entries());

            console.log(formData.get('edit_id'));

            const response = await fetch('/edit-user', {
                method : 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN' : token,
                },
                body : JSON.stringify(data)
            })

            if(response.status === 404){
                toastr.error("Error!, Something Went, Pls try again!,Thank you, if the problem persist pls contact developer!");
            }
            if(response.status === 409){
                toastr.error("Error!, Check if email already exist or invalid");
            }
            if(response.status === 422){
                toastr.error("Error!, Check if you change password make sure to make password and confirm password the same");
            }
            if(response.status === 500){
                toastr.error("Error!, Unexpected error, Pls contact developer, Thank you!");
            }
            if(response.status === 200){
                toastr.success("Successfully updated user!");

                setTimeout(()=>{
                    window.location.reload();
                },1500);
            }

            submit_btn.disabled = false;
        } catch (error) {
            submit_btn.disabled = false;
            toastr.error("Failed to edit user, If the problem persist pls contact developer!s", "Error");
            console.error(error);
        }

    };
}