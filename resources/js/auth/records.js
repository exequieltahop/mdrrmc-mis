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
    // init_multiple_select_responder();

    // init set location for edit form
    // set_location_edit_form();

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
function submit_edit_response(id){
    const form = document.getElementById('form-edit-record');
    const submit_btn = document.getElementById('submit-btn-edit-record');

    form.onsubmit = async (e)=>{
        e.preventDefault();

        try {
            /**
             * url, and data (form data)
             */
            const url = `/admin/update-record`;
            const data = new FormData(e.target);

            data.append('id', id); // append the id for update

            /**
             * the fetch api with method put body of data(form data)
             */
            const response = await fetch(url, {
                method : 'POST',
                body: data
            });

            const response_json = await response.json(); // parse json response

            /**
             * check different type of responses
             * if error throw new error
             * if special error then directly display error
             * if success then display success alert
             * then after 1500 ms reload page
             */
            if (response_json.error) {
                throw new Error(response_json.error);
            } else if (response_json.special_error) {
                toastr.error(response_json.special_error);
            } else if (response_json.success) {
                toastr.success("Successfully updated record!");
                setInterval(()=>{
                    window.location.reload();
                }, 1500);
            }
        } catch (error) { // catch thrown errors and handle them accordingly
            toastr.error("Failed to update record, Pls try again!, If the problem persist pls contact developer!");
            console.error(error.message);
        }
    };
}

// edit record
function init_edit_record(){
    // get all edit btn
    const edit_btn = document.querySelectorAll('.edit-record-btn');

    // loop node elements
    Array.from(edit_btn).forEach(btn => {
        const id = btn.dataset.id;

        // onclick edit btn
        btn.onclick = async (e)=>{
            e.stopImmediatePropagation();

            try {
                // uri and fetch api
                const url = `/admin/get-record/${id}`;
                const response = await fetch(url);

                // parse json
                const response_json = await response.json();

                // check the response if error, specia error or data
                if (response_json.error) {
                    throw new Error(response_json.error);
                } else if (response_json.special_error) {
                    toastr.error(response_json.special_error);
                } else if (response_json.data) {

                    // get response data
                    const data = response_json.data[0];

                    // get all input from the form
                    const respondent = document.getElementById('responder');
                    const location = document.getElementById('location');
                    const datetime = document.getElementById('datetime');
                    const involve = document.getElementById('involve');
                    const hospital = document.getElementById('hospital');
                    const incident_type = document.getElementById('incident_type');
                    const cause = document.getElementById('cause');
                    const remarks = document.getElementById('remarks');

                    // loop the option in the select tag to check what are the correct respondent
                    Array.from(respondent.querySelectorAll('option')).forEach(item => {
                        if(data.respondent_full_names.includes(item.textContent.toString().trim())){
                            item.selected = true;
                            console.log(1);
                        }else{
                            console.log(2);
                            item.selected = false;
                        }
                    });

                    /**
                     * get select tag
                     * if not null then remove it
                     * if null nothing happens
                     */
                    const prev_multi_select = document.querySelector('.mult-select-tag');

                    /**
                     * remove node
                     */
                    if(prev_multi_select){
                        prev_multi_select.remove();
                    }

                    // init multiple select tag in edit form
                    init_multiple_select_responder();

                    // set values of the input in the form base from the data of the response from the database
                    location.value = data.location;
                    datetime.value = data.formatted_date_time;
                    involve.value = data.involve;
                    hospital.value = data.refered_hospital;
                    incident_type.value = data.incident_type;
                    cause.value = data.immediate_cause_or_reason;
                    remarks.value = data.remark;

                    // edit form submit
                    submit_edit_response(id);
                } else {
                    throw new Error("Unexpected Error! Please Contact Developer!");
                }

            } catch (error) { // catch thrown errors
                console.error(error.message);
                toastr.error("Something went wrong!, Please Contact Developer!", 'Error');
            }

        };

    });
}