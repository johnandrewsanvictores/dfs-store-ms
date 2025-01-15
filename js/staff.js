
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

    function add_events() {
        console.log(staff_form);
        staff_form.addEventListener('submit', submit_data);
        Form_Validation.rmv_error_msg_on_data_change();
    }

    function submit_data(e) {
        e.preventDefault();
        Form_Validation.validate_staff_information();
    }

    return {
        add_events
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