document.addEventListener("DOMContentLoaded", function() {
    Controls.add_events();
    Csf_form_main.add_events();
})


const Controls = (function() {
    const new_btn = document.querySelector("#csf-new-btn");

    function add_events() {
        new_btn.addEventListener("click", show_form);
    }

    function show_form(){
        Csf_form_functions.show_csf_form();
    }

    return {
        add_events
    }
})();

const Csf_form_main = (function() {
    const form_title = document.querySelector("#csf-form-title");
    const csf_form = document.querySelector("#product-property-form");

    function add_events() {
        csf_form.addEventListener('submit', submit_data);
    }

    function submit_data(e) {
        e.preventDefault();

        if(form_title.textContent === "Add New Product Property") {
            Request_Csf.add_data(csf_form);
        }

        // if(Form_Validation.validate_staff_information()){
        //     if(form_title.textContent === "Add New Product Property") {
        //         Request_Csf.add_data(staff_form);
        //     }
        //     else if(form_title.textContent === "Update Product Property") {
        //         Request_Csf.update_data(staff_form);
        //     }
        // }
    }

    return {
        add_events
    }
})();

const Request_Csf = (function() {

    function add_data(form) {
        const formData = new FormData(form);
        formData.append('action', "add_data")


        const xhr = new XMLHttpRequest();
        xhr.open('POST', '/dfs-store-ms/api/classification_api.php', true);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        Popup1.show_message(response.message, 'success');
                        Csf_form_functions.reset_form();
                        Csf_form_functions.cancel_form();
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

    }

    function remove_data(ids) {

    }

    function get_specific_staff_acc_data(id) {

    }

    return {
        add_data,
        update_data,
        remove_data,
        get_specific_staff_acc_data
    }
})();