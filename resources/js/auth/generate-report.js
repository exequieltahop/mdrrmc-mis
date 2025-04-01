window.onload = async ()=>{
    // filter report
    filter_report();

    // generate report
    generate_report();
}

// filter report
function filter_report(){
    const form = document.getElementById('form-filter-report');

    form.onsubmit = async (e)=>{
        e.preventDefault();

        const submit_btn = document.getElementById('submit-btn-filter-report');

        const formData = new FormData(e.target);

        const year = formData.get('filter_year');

        window.location.href = `/generate-report/${year}`;
    };
}

// generate report
function generate_report(){
    const btn = document.getElementById('generate-report-btn');

    btn.onclick = async (e)=>{
        e.preventDefault();
        e.stopImmediatePropagation();

        const year = document.getElementById('filter-year').value;

        window.open(`/view-report/${year}`, '_blank');
    };
}