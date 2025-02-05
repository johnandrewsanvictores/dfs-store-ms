
var table = null;

document.addEventListener("DOMContentLoaded", function () {
    table = Table.initDataTable();
    Table.addSelectEvent(table);

    Controls.add_events();

    Staff_Form_Main.add_events();
});


const Controls = (function () {
    const new_btn = document.querySelector("#staff-new-btn");
    const edit_btn = document.querySelector("#edit-btn");
    const remove_btn = document.querySelector("#remove-btn");
    const select_all = document.querySelector("#selectAll-btn");
    const deselect_all = document.querySelector("#deselect-btn");


    function add_events() {
        new_btn.addEventListener("click", Staff_Form_Main.add_data_event);
        edit_btn.addEventListener("click", Staff_Form_Main.edit_data_event);
        remove_btn.addEventListener("click", remove_data_event);
        select_all.addEventListener("click", Table.select_all_rows);
        deselect_all.addEventListener("click", Table.deselect_all_selected_row);

    }

    function get_selected_ids() {
        var datas = Table.getSelectedRow(table);
        var ids = [];
        for (let i = 0; i < datas.length; i++) {
            ids.push(datas[i].id);
        }

        return ids;
    }

    function remove_data_event() {
        const selected_rows = Table.getSelectedRow(table);

        if (selected_rows.length < 1) {
            Popup1.show_message('Please ensure at least one row is selected.', 'warning');
            return;
        }

        const ids = get_selected_ids();
        Popup1.show_confirm_dialog(`Are you sure you want to delete ${selected_rows.length} account/s?`, () => Request_Staff.remove_data(ids));
    }

    return {
        add_events
    }

})();

const Staff_Form_Main = (function () {
    const staff_form = document.getElementById("staff-form");
    const form_title = document.querySelector(".staff-header-form h5");
    const password_note = document.getElementById("passw-note");

    function add_events() {
        staff_form.addEventListener('submit', submit_data);
    }

    function submit_data(e) {
        e.preventDefault();

        if (Form_Validation.validate_staff_information()) {
            if (form_title.textContent === "Add New Staff Account") {
                Request_Staff.add_data(staff_form);
            }
            else if (form_title.textContent.includes("Update Staff Account")) {
                Request_Staff.update_data(staff_form);
            }
        };

        Form_Validation.rmv_error_msg_on_data_change();
    }

    function add_data_event(e) {
        Staff_form_functions.show_staff_form();
        Table.deselect_all_selected_row();
        form_title.textContent = "Add New Staff Account"
        password_note.style.display = "none";
    }

    function fill_info(response) {
        var data = response[0];
        const name = document.querySelector('#name');
        const username = document.querySelector('#username');
        const phone_number = document.querySelector('#pnumber');
        const role_select_el = document.querySelector('#staff-form select[name="role"]');

        const staff_id = document.querySelector('input[name="staff-id"]');
        const current_staff_id = document.querySelector('#current-staff-id');
        const address = document.querySelector('#address');
        const email = document.querySelector('#email');

        name.value = data.name;
        username.value = data.username;
        phone_number.value = data.phone_number;
        role_select_el.value = data.role;
        staff_id.value = data.staff_id;
        current_staff_id.textContent = data.staff_id;

    }

    async function edit_data_event(e) {
        const selected_rows = Table.getSelectedRow(table);
        form_title.innerHTML = "Update Staff Account for <span id='current-staff-id'>STF1111</span>";
        password_note.style.display = "block";

        if (selected_rows.length != 1) {
            Popup1.show_message('Please ensure only one row is selected.', 'warning');
            Table.deselect_all_selected_row();
            return;
        }

        const data = await Request_Staff.get_specific_staff_acc_data(selected_rows[0].id);
        Staff_Form_Main.fill_info(data);

        Table.deselect_all_selected_row();
        Staff_form_functions.show_staff_form(true);
    }

    return {
        add_events,
        add_data_event,
        edit_data_event,
        fill_info
    }
})();


const Request_Staff = (function () {

    function add_data(form) {
        const formData = new FormData(form);
        formData.append('action', "add_data")


        const xhr = new XMLHttpRequest();
        xhr.open('POST', '/dfs-store-ms/api/staff_api.php', true);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        table.context[0].ajax.data = { 'action': "datatableDisplay" }
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

    function update_data(form) {
        const formData = new FormData(form);
        formData.append('action', 'update_data');

        const xhr = new XMLHttpRequest();
        xhr.open('POST', '/dfs-store-ms/api/staff_api.php', true);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        table.context[0].ajax.data = { 'action': "datatableDisplay" }
                        table.draw();
                        Staff_form_functions.reset_form();
                        Staff_form_functions.cancel_form();
                        Table.deselect_all_selected_row();
                        Popup1.show_message(response.message, 'success');
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

    function remove_data(ids) {
        const xhr = new XMLHttpRequest();

        const requestBody = 'ids=' + JSON.stringify(ids) + `&action=remove_data`;
        xhr.open('POST', '/dfs-store-ms/api/staff_api.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        Table.deselect_all_selected_row();
                        table.row('.selected').remove().draw(false);
                        Popup1.show_message(response.message, 'success');
                    } else {
                        Popup1.show_message(response.message, 'error');
                    }
                } else {
                    PopUp.showMessage('Error occurred while processing your request.', 'error');
                }
            }
        };
        xhr.send(requestBody);
    }

    function get_specific_staff_acc_data(id) {
        return new Promise((resolve, reject) => {
            const xhr = new XMLHttpRequest();

            const requestBody = 'id=' + id + '&action=get_specific_data'; // Serialize array to JSON string
            xhr.open('POST', '/dfs-store-ms/api/staff_api.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        const response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            resolve(response.data);
                        } else {
                            reject(response.message || 'An error occurred');
                        }
                    } else {
                        reject('Error occurred while processing your request');
                    }
                }
            };

            xhr.send(requestBody);
        });
    }

    return {
        add_data,
        update_data,
        remove_data,
        get_specific_staff_acc_data
    }
})();


const Table = (function () {
    function initDataTable() {
        return new DataTable('#staff-table', {
            scrollX: true,
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: "../api/staff_api.php",
                type: "post",
                data: { 'action': "datatableDisplay" },
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


