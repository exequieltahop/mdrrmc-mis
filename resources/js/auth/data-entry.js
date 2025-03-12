document.addEventListener('DOMContentLoaded', ()=>{

    // new multi select
    new MultiSelectTag('respondent', {
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

    // submit response
    document.getElementById('form-data-entry').onsubmit = async (e) => {
        e.preventDefault();
        e.stopImmediatePropagation();

        const btn_submit = document.getElementById('submit-report');
        const newForm = new FormData(e.target);


        // disabled btn
        btn_submit.disabled = true;

        try {
            /**
             * url
             * method
             * body with the form data that was serialize
            */

           // url
           const url = `/admin/submit-response`;

           // fetch api
            const response = await fetch(url, {
                method : 'POST',
                body : new FormData(e.target),
            });

            // parse response json
            const response_json = await response.json();

            // if error
            if(response_json.error){
                throw new Error(response_json.error)
            }

            // if special error
            if(response_json.special_error){
                toastr.error(`response_json.special_error`, 'Error');
            }

            // if Success
            if(response_json.success){
                toastr.success('Successfully Submitted Response', 'Success');
            }
            // reset form
            e.target.reset();

            // clear select tag
            document.querySelector('.input-container').innerHTML = '';

            // put btn back to it s original state
            btn_submit.disabled = false;
        } catch (error) {
            // process errors
            toastr.error(`Error Submit Response, If the Problem Persist Call Developer`, 'Error');
            console.error(`Error Submit Response ${error.message}`);

            // put btn back to it s original state
            btn_submit.disabled = false;
        }
    }
});
