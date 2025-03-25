import DataTable from 'datatables.net-dt';
import Swal from 'sweetalert2'
import toastr from 'toastr';

document.addEventListener('DOMContentLoaded', async ()=>{

    // TOKEN
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // MAKE DATATABLE
    let table = new DataTable('#records-list', {
        responsive: false
    });

    // DELETE BTN INIT
    delete_btn_init(token);

    // init multiple select tag in edit form
    init_multiple_select_responder();

    // init set location for edit form
    // set_location_edit_form();

    // edit form submit
    // submit_edit_response();

    // init edit record
    init_edit_record();
});

// delete btn init
function delete_btn_init(token){

    // get all delete buttons
    const delete_action_btn = document.querySelectorAll('.delete-action-btn');

    // loop all the buttons and add event listener
    Array.from(delete_action_btn).forEach(item => {

        // the onclick event
        item.onclick = (e)=>{
            e.stopImmediatePropagation();

            // get id from data id attribute in the button
            const id = e.currentTarget.getAttribute('data-id');

            // prompt confirmation deletion
            Swal.fire({
              title: "Are you sure?",
              text: `You won't be able to revert this!`,
              icon: "warning",
              showCancelButton: true,
              confirmButtonColor: "#3085d6",
              cancelButtonColor: "#d33",
              confirmButtonText: "Yes, delete it!"
            }).then(async (result) => {

                // if confirmed then delet data
                if (result.isConfirmed) {

                    // DELETE DATA IN DATABASE
                    try {

                        // DELETE API ENDPOINT
                        const uri = `/admin/delete/${id}`;

                        // FETCH API
                        const response = await fetch(uri, {
                            method : 'DELETE',
                            headers : {
                                'X-CSRF-TOKEN' : token
                            }
                        });

                        // json response parse
                        const response_json = await response.json();

                        // if exception
                        if(response_json.special_error){
                            throw new Error(response_json.special_error);
                        }

                        // if errors
                        if(response_json.error){
                            throw new Error(response_json.error);
                        }

                        // if success
                        if(response_json.success){
                            // alert success alert
                            toastr.success('Successfuly Deleted Response', 'Success');

                            // refresh page
                            setInterval(()=>{
                                window.location.reload();
                            }, 1500);
                        }

                    } catch (error) { // catch thrown errors
                        toastr.error('Failed to delete response', "Error");
                        console.error(error.message);
                    }
                }
            });

        };
    });
}

// init multiple selecttag in editform
function init_multiple_select_responder(){
    // new multi select
    new MultiSelectTag('responder', {
        rounded: true,    // default true
        shadow: true,      // default false
        placeholder: 'Search',  // default Search...
        tagColor: {
            textColor: 'rgb(0, 0, 87)',
            borderColor: 'rgb(0, 0, 87)',
            bgColor: 'white',
        },
        shadow : false
    });
}

// init set location for edit form
function set_location_edit_form(){
    Array.from(document.querySelectorAll('.edit-location')).forEach(item => {
        const location = item.getAttribute('data-location');

        const options = item.querySelectorAll('option');

        Array.from(options).forEach(opt => {
            if(opt.value == location) opt.selected = true;
            else opt.selected = false;
        });
    });
}

// edit form submit
function submit_edit_response(){
    const forms = document.querySelectorAll('.form-edit-response');

    Array.from(forms).forEach(item => {
        // const submit_btn = item.querySelector('.btn-edit-response');
        // console.log(submit_btn);
        item.onsubmit = async (e)=>{
            e.preventDefault();
            console.log(e.target);

            // if(btn){
            //     console.log(1);
            // }else{
            //     console.log(0);
            // }
        }
    });
}

// edit record
function init_edit_record(){
    const edit_btn = document.querySelectorAll('.edit-record-btn');

    Array.from(edit_btn).forEach(btn => {
        const id = btn.dataset.id;

        btn.onclick = async (e)=>{
            e.stopImmediatePropagation();

            try {
                const url = `/`;
                const response = await fetch(url);
            } catch (error) {
                console.error(error.message);
                toastr.error("Something went wrong!, Please Contact Developer!", 'Error');
            }
        };
    });
}