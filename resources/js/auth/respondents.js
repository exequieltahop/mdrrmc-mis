import DataTable from 'datatables.net-dt';


document.addEventListener('DOMContentLoaded', async ()=>{
    let table = new DataTable('#respondents-table', {
        responsive: true
    });

    document.getElementById('form-add-respondent').onsubmit = async (e)=>{
        e.preventDefault();
        e.stopImmediatePropagation();

        const formData = new FormData(e.target);
        const url = `/admin/add-respondent`;
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


