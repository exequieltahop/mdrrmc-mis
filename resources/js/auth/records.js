import DataTable from 'datatables.net-dt';
import Swal from 'sweetalert2'

document.addEventListener('DOMContentLoaded', async ()=>{
    // MAKE DATATABLE
    let table = new DataTable('#records-list', {
        responsive: false
    });

    // DELETE BTN INIT
    delete_btn_init();

});
function delete_btn_init(){
    const delete_action_btn = document.querySelectorAll('.delete-action-btn');

    Array.from(delete_action_btn).forEach(item => {

        item.onclick = (e)=>{
            e.stopImmediatePropagation();

            const id = e.currentTarget.getAttribute('data-id');

            Swal.fire({
              title: "Are you sure?",
              text: `You won't be able to revert this!`,
              icon: "warning",
              showCancelButton: true,
              confirmButtonColor: "#3085d6",
              cancelButtonColor: "#d33",
              confirmButtonText: "Yes, delete it!"
            }).then(async (result) => {
              if (result.isConfirmed) {

                // DELETE DATA IN DATABASE
                try {
                    const uri = ``;

                    const response = await fetch(uri, {
                        method : 'DELETE',
                        headers : {
                            'X-CSRF-TOKEN' : token
                        }
                    });

                } catch (error) {

                }

                // Swal.fire({
                //   title: "Deleted!",
                //   text: "Your file has been deleted.",
                //   icon: "success"
                // });
              }
            });

        };
    });
}
