
var table = null;

document.addEventListener("DOMContentLoaded", function() {
    table = Table.initDataTable();
    Table.addSelectEvent(table);

    Controls.add_events();

    Staff_Form_Main.add_events();
});


const Controls = (function() {
    const new_btn = document.querySelector("#staff-new-btn");
    const edit_btn = document.querySelector("#edit-btn");
    const remove_btn = document.querySelector("#remove-btn");
    const select_all = document.querySelector("#selectAll-btn");
    const deselect_all = document.querySelector("#deselect-btn");


    function add_events() {
        new_btn.addEventListener("click", Staff_form_functions.show_staff_form)
    }

    return {
        add_events
    }

})();

const Staff_Form_Main = (function() {
    const staff_form = document.getElementById("staff-form");
    const form_title = document.querySelector(".staff-header-form h5");

    function add_events() {
        console.log(staff_form);
        staff_form.addEventListener('submit', submit_data);
    }

    function submit_data(e) {
        e.preventDefault();

        if(Form_Validation.validate_staff_information()){
            if(form_title.textContent === "Add New Staff Account") {
                Request_Staff.add_data(staff_form);
            }
            // else if(form_title.textContent === "Update Staff Account") {
            //     Request_Staff.updateData();
            // }
        };

        
    }

    return {
        add_events
    }
})();


const Request_Staff = (function() {

    function add_data(form) {
        const formData = new FormData(form);
        formData.append('action', "add_data")


        const xhr = new XMLHttpRequest();
        xhr.open('POST', '/dfs-store-ms/api/staff_api.php', true);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        table.context[0].ajax.data = {'action' : "datatableDisplay"}
                        table.draw();
                        Popup1.show_message(response.message, 'success');
                        Staff_form_functions.reset_form();
                        Staff_form_functions.cancel_form();
                        Table.deselect_all_selected_row();
                    } else {
                        Popup1.show_message(response.message, 'error');
                    }
                } else {
                    console.error('Error:', xhr.status);
                }
            }
        };
        xhr.send(formData);
    }

    return {
        add_data
    }
})();


const Table = (function() {
    function initDataTable() {
        return new DataTable('#staff-table', {
            scrollX: true,
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: "../api/staff_api.php",
                type: "post",
                data: {'action' : "datatableDisplay"},
            },
            // ajax: "../../api/business_datatable_api.php",
            "columns": [
                { "data": "id", visible: false },
                { "data": "staff_id" },
                { "data": "name" },
                { "data": "username" },
                { "data": "phone_number" },
                { "data": "role" },
                { "data": "date_added" },
                { "data": "last_login" },
            ]
        });
    }


    function addSelectEvent(table) {
        table.on('click', 'tbody tr', function (e) {
            e.currentTarget.classList.toggle('selected');
        });
    }

    function getSelectedRow(table) {
        return table.rows('.selected').data()
    }

    function removeRow(table) {
        table.row('.selected').remove().draw(false);
    }

    function deselect_all_selected_row() {
        document.querySelectorAll('tbody tr.selected').forEach(el => el.classList.remove('selected'));
    }

    function select_all_rows() {
        document.querySelectorAll('tbody tr').forEach(row => row.classList.add('selected'));
    }


    return {
        initDataTable,
        addSelectEvent,
        getSelectedRow,
        removeRow,
        deselect_all_selected_row,
        select_all_rows
    }
})();


const Popup1 = (function() {
    function show_message(msg, icon) {
        Swal.fire({
            position: "top right",
            icon: icon,
            title: msg,
            showConfirmButton: false,
            timer: 1500
        });
    }

    function show_confirm_dialog(msg, callback) {
        Swal.fire({
            text: msg,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes"
        }).then((result) => {
            if (result.isConfirmed) {
                callback();
            }
        });
    }

    return {
        show_message,
        show_confirm_dialog
    }
})();