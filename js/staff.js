
var table = null;

document.addEventListener("DOMContentLoaded", function() {
    table = Table.initDataTable();
    Table.addSelectEvent(table);

});



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