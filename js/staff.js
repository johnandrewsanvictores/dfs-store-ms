var table = null;
const selected_role = document.querySelector("#role-filter");
const selected_status = document.querySelector("#status-filter");

document.addEventListener("DOMContentLoaded", function () {
    table = Table.initDataTable();
    Table.addSelectEvent(table);

    Controls.add_events();

    Staff_Form_Main.add_events();
});


const Controls = (function () {
    const new_btn = document.querySelector("#staff-new-btn");
    const edit_btn = document.querySelector("#edit-btn");
    const view_btn = document.querySelector("#view-btn");
    const select_all = document.querySelector("#selectAll-btn");
    const deselect_all = document.querySelector("#deselect-btn");


    function add_events() {
        new_btn.addEventListener("click", Staff_Form_Main.add_data_event);
        edit_btn.addEventListener("click", Staff_Form_Main.edit_data_event);
        view_btn.addEventListener("click", Staff_Form_Main.view_data_event);
        select_all.addEventListener("click", Table.select_all_rows);
        deselect_all.addEventListener("click", Table.deselect_all_selected_row);
        selected_role.addEventListener("change", select_filter_change_event);
        selected_status.addEventListener("change", select_filter_change_event);    
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

    function select_filter_change_event() {
        table.context[0].ajax.data = {'action' : "datatableDisplay", "selected_role" : selected_role.value, "selected_status" : selected_status.value}
        table.draw();
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
        const status_select_el = document.querySelector('#staff-form select[name="status"]');
        const staff_id = document.querySelector('input[name="staff-id"]');
        const current_staff_id = document.querySelector('#current-staff-id');
        const address = document.querySelector('#address');
        const email = document.querySelector('#email');
        const profileContainer = document.querySelector('.profile-input-container');
        const profilePreview = document.querySelector('.profile-preview-image') || new Image();
        const old_img_src = document.querySelector('input[name="old-img-src"]');

        // Fill text inputs and selects
        name.value = data.name;
        username.value = data.username;
        phone_number.value = data.phone_number;
        role_select_el.value = data.role;
        status_select_el.value = data.status;
        staff_id.value = data.staff_id;
        current_staff_id.textContent = data.staff_id;
        address.value = data.address;
        email.value = data.email;
        old_img_src.value = data.image_path;

        // Handle profile image
        if (data.image_path) {
            profilePreview.classList.add('profile-preview-image');
            profilePreview.src = "../" + data.image_path;
            if (!profilePreview.parentElement) {
                profileContainer.appendChild(profilePreview);
            }
            profileContainer.classList.add('has-image');
        } else {
            profileContainer.classList.remove('has-image');
            if (profilePreview.parentElement) {
                profilePreview.remove();
            }
        }
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

    async function view_data_event(e) {
        const selected_rows = Table.getSelectedRow(table);

        if (selected_rows.length != 1) {
            Popup1.show_message('Please ensure only one row is selected.', 'warning');
            Table.deselect_all_selected_row();
            return;
        }

        const data = await Request_Staff.get_specific_staff_acc_data(selected_rows[0].id);
        show_staff_view_modal(data[0]);
        Table.deselect_all_selected_row();
    }

    function show_staff_view_modal(data) {
        // Format dates
        const dateAdded = formatDateTime(data.date_added);
        const lastLogin = data.last_login ? formatDateTime(data.last_login) : 'Never';

        const modal = document.createElement('div');
        modal.className = 'staff-view-modal';
        
        modal.innerHTML = `
            <div class="staff-view-content">
                <div class="staff-view-header">
                    <h2>Staff Profile</h2>
                    <button class="close-btn">&times;</button>
                </div>
                <div class="staff-view-body">
                    <div class="profile-section">
                        <div class="profile-image">
                            <img src="../${data.image_path || 'assets/images/default_profile.png'}" alt="Profile Picture">
                        </div>
                        <div class="profile-info">
                            <h3>${data.name}</h3>
                            <p class="role">${data.role.toUpperCase()}</p>
                            <p class="status ${data.status.toLowerCase()}">${data.status}</p>
                        </div>
                    </div>
                    <div class="info-section">
                        <div class="info-group">
                            <h4>Contact Information</h4>
                            <div class="info-item">
                                <i class="fas fa-envelope"></i>
                                <span>${data.email || 'N/A'}</span>
                            </div>
                            <div class="info-item">
                                <i class="fas fa-phone"></i>
                                <span>${data.phone_number || 'N/A'}</span>
                            </div>
                            <div class="info-item">
                                <i class="fas fa-location-dot"></i>
                                <span>${data.address || 'N/A'}</span>
                            </div>
                        </div>
                        <div class="info-group">
                            <h4>Account Details</h4>
                            <div class="info-item">
                                <i class="fas fa-id-card"></i>
                                <span>Staff ID: ${data.staff_id}</span>
                            </div>
                            <div class="info-item">
                                <i class="fas fa-user"></i>
                                <span>Username: ${data.username}</span>
                            </div>
                            <div class="info-item">
                                <i class="fas fa-calendar"></i>
                                <span>Date Added: ${dateAdded}</span>
                            </div>
                            <div class="info-item">
                                <i class="fas fa-clock"></i>
                                <span>Last Login: ${lastLogin}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;

        document.body.appendChild(modal);

        // Update close button functionality
        const closeBtn = modal.querySelector('.close-btn');
        closeBtn.addEventListener('click', () => {
            closeModalWithAnimation(modal);
        });

        // Update outside click functionality
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                closeModalWithAnimation(modal);
            }
        });
    }

    function closeModalWithAnimation(modal) {
        modal.classList.add('closing');
        setTimeout(() => {
            modal.remove();
        }, 300); // Match animation duration
    }

    function formatDateTime(dateString) {
        const date = new Date(dateString);
        
        // Format date
        const formattedDate = date.toLocaleDateString('en-US', {
            month: 'long',
            day: 'numeric',
            year: 'numeric'
        });

        // Format time
        const formattedTime = date.toLocaleTimeString('en-US', {
            hour: 'numeric',
            minute: 'numeric',
            hour12: true
        });

        return `${formattedDate} at ${formattedTime}`;
    }

    return {
        add_events,
        add_data_event,
        edit_data_event,
        view_data_event,
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
                        table.context[0].ajax.data = {'action' : "datatableDisplay", "selected_role" : selected_role.value, "selected_status" : selected_status.value}
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
                        table.context[0].ajax.data = {'action' : "datatableDisplay", "selected_role" : selected_role.value, "selected_status" : selected_status.value}
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
                data: { 'action': "datatableDisplay", "selected_role" : selected_role.value, "selected_status" : selected_status.value },
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
                { "data": "status" }
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


