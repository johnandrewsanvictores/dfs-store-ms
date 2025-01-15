

document.addEventListener("DOMContentLoaded", function() {
    Staff_form_functions.add_events()
})

const Staff_form_functions = (function() {
    const staff_form_wrapper = document.querySelector(".staff-form-wrapper");
    const staff_form_container = document.querySelector(".staff-form-container");

    const x_form_btn = document.querySelector("#x-staff-form-btn");
    const eye_btns = document.querySelectorAll('.show-pass-btn');

    const reset_form_btn = document.querySelector("#reset-staff-form-btn");

    function add_events() {
        x_form_btn.addEventListener("click", cancel_form);
        reset_form_btn.addEventListener("click", reset_form);

        eye_btns.forEach(btn => {
            btn.addEventListener("click", change_password_type_input)
        });
    }

    function cancel_form() {
        staff_form_container.style.opacity = '0';
        staff_form_container.style.visibility = 'hidden';
        staff_form_container.style.transform = 'scale(0)';

        staff_form_wrapper.style.opacity = '0';
        staff_form_wrapper.style.visibility = 'hidden';
        staff_form_wrapper.style.transform = 'scale(0)';

        document.querySelector('#staff-form').reset();
        eye_btns.forEach(eye_btn => {
            eye_btn.classList.replace("fa-eye-slash", "fa-eye");
            eye_btn.classList.replace("hide-pass-btn", "show-pass-btn")
        });

        Form_Validation.clear_error_msg();
    }

    function reset_form() {
        Form_Validation.clear_error_msg();
        document.querySelector('#staff-form').reset();
    }

    function show_staff_form() {
        staff_form_container.style.opacity = '1';
        staff_form_container.style.visibility = 'visible';
        staff_form_container.style.transform = 'scale(1)';

        staff_form_wrapper.style.opacity = '1';
        staff_form_wrapper.style.visibility = 'visible';
        staff_form_wrapper.style.transform = 'scale(1)';
    }

    function change_password_type_input(e) {
        const eye_btn = e.target;
        const input_field = eye_btn.parentElement.previousElementSibling;

        if (eye_btn.classList.contains("show-pass-btn")) {
            input_field.type = "text";
            eye_btn.classList.replace("fa-eye", "fa-eye-slash");
            eye_btn.classList.replace("show-pass-btn", "hide-pass-btn")
        } else if (eye_btn.classList.contains("hide-pass-btn")) {
            input_field.type = "password";
            eye_btn.classList.replace("fa-eye-slash", "fa-eye");
            eye_btn.classList.replace("hide-pass-btn", "show-pass-btn")
        }
    }

    return {
        cancel_form,
        show_staff_form,
        change_password_type_input,
        add_events
    }

})();

const Form_Validation = (function() {

    function validate_staff_information() {
        const name = document.getElementById('name').value.trim();
        const username = document.getElementById('username').value.trim();
        const phone_number = document.getElementById('pnumber').value.trim();
        const role = document.getElementById('role').value.trim();
        const password = document.getElementById('password').value.trim();
        const cpassword = document.getElementById('cpassword').value.trim();

        let isValid = true;

        clear_error_msg();

        if (name === '') {
            show_error('name', 'Please enter the full name.');
            isValid = false;
        }

        if (username === '') {
            show_error('username', 'Please enter the username.');
            isValid = false;
        }

        if (phone_number === '') {
            show_error('pnumber', 'Please enter the phone number.');
            isValid = false;
        } else if (!isValidMobileNumber(phone_number)) {
            show_error('pnumber', 'Please enter a valid phone number.');
            isValid = false;
        }

        if (role === '') {
            show_error('role', 'Please select a role.');
            isValid = false;
        }

        if (password === '') {
            show_error('password', 'Please enter a password.');
            isValid = false;
        }else if(password.length < 8) {
            show_error('password', 'Password must be 8 characters.');
        }else if(password !== cpassword) {
            show_error('cpassword', 'Password and confirm password doesn\'t match.');
            isValid = false;
        }
        

        return isValid;
    }

    function show_error(elementId, errorMessage) {
        const errorElement = document.createElement('p');
        errorElement.classList.add('error-message');
        errorElement.textContent = errorMessage;
        errorElement.style.color = 'var(--red)';
        errorElement.style.fontSize = 'var(--small)';
        // errorElement.style.marginTop = '0.5em';
    
        var field = document.getElementById(elementId);
        var parent = field.parentElement;

        switch(elementId) {
            case "password":
                parent = field.parentElement.parentElement;
                break;
            case "cpassword":
                parent = field.parentElement.parentElement.parentElement;
                errorElement.style.gridColumn = "1/3";
                break;
            case "role":
                parent = field.parentElement.parentElement.parentElement;
                break;
                
        }

        parent.appendChild(errorElement);
    }
    

    function clear_error_msg() {
        const errorMessages = document.querySelectorAll('.error-message');
        errorMessages.forEach(error => error.remove());
    }

    function isValidMobileNumber(number) {
        // Add your mobile number validation logic here
        // For example, you might check if the number matches a specific pattern
        if(number.match(/09[0-9]{9}/)){
            return true; // Change this based on your validation logic
        }else {
            return false;
        }
    }

    function rmv_error_msg_on_data_change() {
        const inputs = document.querySelectorAll('#staff-form > div > input');
        const password_el = document.querySelector("#password");
        const cpassword_el = document.querySelector("#cpassword");
        const role_select_el = document.querySelector("#role");

        inputs.forEach(input => {
            input.addEventListener('keyup', () => remove_msg_error_el(input.nextElementSibling));
        });

        password_el.addEventListener('keyup', () => remove_msg_error_el(password_el.parentElement.nextElementSibling));

        cpassword_el.addEventListener('keyup', () => remove_msg_error_el(cpassword_el.parentElement.parentElement.nextElementSibling));

        role_select_el.addEventListener('change', () => remove_msg_error_el(role_select_el.parentElement.parentElement.nextElementSibling));
    }

    function remove_msg_error_el(error_msg_el) {
        if(error_msg_el) {
            if(error_msg_el.className === 'error-message') {
                error_msg_el.remove();
            }
        }
        // validate_staff_information();
    }

    return {
        validate_staff_information,
        clear_error_msg,
        rmv_error_msg_on_data_change
    }

})();