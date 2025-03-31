import DataTable from 'datatables.net-dt';
import Swal from 'sweetalert2';
import toastr from 'toastr';

document.addEventListener('DOMContentLoaded', async ()=>{
    // token
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // init data table responders
    let table = new DataTable('#respondents-table', {
        responsive: true
    });

    // init delete
    delete_init(table, token);

    // init edit
    edit_init(table, token);

    // add new responder
    document.getElementById('form-add-respondent').onsubmit = async (e)=>{
        e.preventDefault();
        e.stopImmediatePropagation();

        const formData = new FormData(e.target);
        const url = `/add-respondent`;
        const btn = document.getElementById('btn-submit-respondent');

        btn.disabled = true;

        try {
            const response = await fetch(url, {
                method : 'POST',
                body : formData
            });

            const response_json = await response.json();

            if(response_json.error){
                throw new Error(response_json.error)
            }
            if(response_json.success){
                toastr.success("Successfully Added Respondent", "Success");
            }

        } catch (error) {
            toastr.error(`${error}`, 'Error');
            console.error(error);

        } finally {
            e.target.reset();
            btn.disabled = false;
            window.location.reload();
        }
    };
});


// delete reponder init
function delete_init(table, token) {
    table.on("click", ".delete-responder-btn", function (e) {
        e.stopImmediatePropagation();

        // get id and tr element
        const id = e.currentTarget.getAttribute("data-id");
        const tr_parent = e.currentTarget.closest("tr");

        // prompt for delete confirmation
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!",
        }).then(async (result) => {
            // if confirmed then delete
            if (result.isConfirmed) {
                try {
                    // fetch api es6 delete method
                    const uri = `/delete-responder/${id}`;
                    const response = await fetch(uri, {
                        method: "DELETE",
                        headers: {
                            "X-CSRF-TOKEN": token,
                            "Content-Type": "application/json",
                        },
                    });

                    // parse json
                    const response_json = await response.json();

                    /**
                     * if success, display success toastr
                     * then destroy datatable
                     * remove tr
                     * then re init datatable
                     */
                    if (response.status === 200) {
                        toastr.success("Successfully deleted responder", "Success");

                        table.destroy();

                        tr_parent.remove();

                        setTimeout(() => {
                            new DataTable("#respondents-table", {
                                responsive: true,
                            });
                        }, 300);
                    }

                    // if error throw new error
                    if (response_json.error) {
                        throw new Error(response_json.error);
                    }
                } catch (error) { // catch unxpected error and thrown errors
                    toastr.error(
                        "Failed to delete responder! Please Try Again!, If the problem persists, contact the developer!"
                    );
                    console.error(error.message);
                }
            }
        });
    });
}


function edit_init(table, token){
    table.on('click', '.edit-btn-responder', async function(e){
        e.stopImmediatePropagation();
        // get id
        const id = e.currentTarget.dataset.id;

        const edit_modal = new bootstrap.Modal(document.getElementById('modal-edit-respondent'));

        try {
            const response = await fetch(`/get-responder-data/${id}`);

            // data not found
            if(response.status == 404){
                throw new Error("Responder data not found, If the problem persist please contact developer!, Thank you");
            }

            // unexpected error
            if(response.status == 500){
                const response_json = await response.json();

                // throw new error
                if(response_json.error){
                    throw new Error(response_json.error);
                }
            }

            // if success then display data
            if(response.status == 200){
                const response_json = await response.json(); // parse json data

                const data = response_json.data; // data

                edit_modal.show(); // show modal

                // get the inputs
                const edit_id = document.getElementById('edit_id');
                const fname = document.getElementById('edit_fname');
                const mname = document.getElementById('edit_mname');
                const lname = document.getElementById('edit_lname');
                const gender = document.getElementById('edit_gender');
                const address = document.getElementById('edit_address');
                const birthdate = document.getElementById('edit_birthdate');
                const birthplace = document.getElementById('edit_birthplace');
                const civil_status = document.getElementById('edit_civil_status');
                const photo = document.getElementById('edit_photo');
                const photo_preview = document.getElementById('edit_responder_photo');

                // Set values of the inputs
                edit_id.value = data.encrypted_id;
                fname.value = data.first_name;
                mname.value = data.middle_name;
                lname.value = data.last_name;
                gender.value = data.gender;
                address.value = data.address;
                birthdate.value = data.birthdate;
                birthplace.value = data.birthplace;

                // Loop through civil_status options and assign value
                Array.from(civil_status.options).forEach(opt => {
                    opt.selected = opt.value === data.civil_status;
                });

                // File preview of the selected photo
                const file_reader = new FileReader();

                // Event listener for input
                photo.addEventListener('change', (e) => {
                    const file = e.target.files[0]; // Corrected: use `files`, not `file`

                    if (file) {
                        file_reader.readAsDataURL(file); // Read file as data URL

                        file_reader.onload = () => {
                            photo_preview.src = file_reader.result; // Set preview image src
                        };
                    }
                });

                // init submit edit responder's form
                init_submit_edit_form(token);
            }

        } catch (error) {
            toastr.error("Something Went Wrong Getting Data for edit responder, Please Contact Developer!, Thank you");
            console.error(error.message);
        }
    });
}

// submit edit responder form
function init_submit_edit_form(token){
    const form = document.getElementById('form-edit-respondent');

    form.onsubmit = async (e)=>{
        e.preventDefault();

        const submit_btn = document.getElementById('edit-btn-submit-respondent');
        submit_btn.disabled = true;
        try {
            const uri = `/edit-respondent`;
            const response = await fetch(uri, {
                method : 'post',
                headers : {
                    'X-CSRF-TOKEN' : token
                },
                body : new FormData(e.target)
            });

            if(response.status == 200){
                toastr.success("Successfully Updated Responder");
                setTimeout(()=>{
                    window.location.reload();
                },1500);
            } else if (response.status == 400 || response.status == 500){
                toastr.error("Failed to update, please contact developer!, Thank You!");
            } else if (response.status == 500){
                toastr.error("Unexpected Error, please contact developer!, Thank You!");
            }

        } catch (error) {
            console.error(error.message);
            toastr.error("Something went wrong, please contact developer!, Thank You!");
        } finally {
            submit_btn.disabled = false;
        }
    };
}
