document.addEventListener("DOMContentLoaded", function () {
    Staff_form_functions.add_events()
    Form_Validation.rmv_error_msg_on_data_change();
})

const Staff_form_functions = (function () {
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

        const generatePasswordBtn = document.getElementById('generate-password-btn');
        if (generatePasswordBtn) {
            generatePasswordBtn.addEventListener('click', generate_password);
        }

        // Add image preview functionality
        const profileInput = document.getElementById('profile_pic');
        if (profileInput) {
            profileInput.addEventListener('change', preview_image);
        }
    }

    function cancel_form() {
        staff_form_container.style.opacity = '0';
        staff_form_container.style.visibility = 'hidden';
        staff_form_container.style.transform = 'scale(0)';

        staff_form_wrapper.style.opacity = '0';
        staff_form_wrapper.style.visibility = 'hidden';
        staff_form_wrapper.style.transform = 'scale(0)';

        // Reset form and image preview
        const container = document.querySelector('.profile-input-container');
        const previewImg = container.querySelector('.profile-preview-image');
        if (previewImg) {
            previewImg.remove();
        }
        container.classList.remove('has-image');

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
        
        // Reset image preview
        const container = document.querySelector('.profile-input-container');
        const previewImg = container.querySelector('.profile-preview-image');
        if (previewImg) {
            previewImg.remove();
        }
        container.classList.remove('has-image');
    }

    function show_staff_form(isUpdate = false) {
        staff_form_container.style.opacity = '1';
        staff_form_container.style.visibility = 'visible';
        staff_form_container.style.transform = 'scale(1)';

        staff_form_wrapper.style.opacity = '1';
        staff_form_wrapper.style.visibility = 'visible';
        staff_form_wrapper.style.transform = 'scale(1)';

        // Toggle elements based on form mode
        const confirmPasswordDiv = document.querySelector('.confirm-password-div');
        const passwordNote = document.querySelector('#passw-note');
        const passwordInputDiv = document.querySelector('.password-group .input-div');
        const generatePasswordBtn = document.getElementById('generate-password-btn');
        const passwordLabel = document.querySelector('label[for="password"] span');

        if (isUpdate) {
            confirmPasswordDiv.style.display = 'none';
            passwordNote.style.display = 'block';
            passwordInputDiv.style.gridColumn = '1/3'; // Make password field span full width
            generatePasswordBtn.style.display = 'block'; // Show generate button for updates
            passwordLabel.style.display = 'none'; // Hide asterisk for update mode
        } else {
            confirmPasswordDiv.style.display = 'block';
            passwordNote.style.display = 'none';
            passwordInputDiv.style.gridColumn = 'auto'; // Reset to default grid column
            generatePasswordBtn.style.display = 'none'; // Hide generate button for new staff
            passwordLabel.style.display = 'inline'; // Show asterisk for add mode
        }
    }

    function change_password_type_input(e) {
        const eye_btn = e.target;
        const input_field = eye_btn.parentElement.querySelector('input');

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

    function generate_password() {
        // Generate a random password (8-12 characters)
        const chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*';
        const length = Math.floor(Math.random() * (12 - 8 + 1)) + 8;
        let password = '';

        for (let i = 0; i < length; i++) {
            password += chars.charAt(Math.floor(Math.random() * chars.length));
        }

        document.getElementById('password').value = password;
        // Show the generated password
        document.getElementById('password').type = 'text';
        setTimeout(() => {
            document.getElementById('password').type = 'password';
        }, 3000); // Hide after 3 seconds
    }

    function preview_image(e) {
        const file = e.target.files[0];
        if (file) {
            const container = document.querySelector('.profile-input-container');
            const previewImg = container.querySelector('.profile-preview-image') || document.createElement('img');
            
            if (!previewImg.classList.contains('profile-preview-image')) {
                previewImg.classList.add('profile-preview-image');
                container.appendChild(previewImg);
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                container.classList.add('has-image');
            }
            reader.readAsDataURL(file);
        }
    }

    return {
        cancel_form,
        show_staff_form,
        change_password_type_input,
        add_events,
        reset_form
    }

})();

const Form_Validation = (function () {

    function validate_staff_information() {
        const name = document.getElementById('name').value.trim();
        const username = document.getElementById('username').value.trim();
        const phone_number = document.getElementById('pnumber').value.trim();
        const role = document.getElementById('role').value.trim();
        const status = document.getElementById('status').value.trim();
        const password = document.getElementById('password').value.trim();
        const cpassword = document.getElementById('cpassword').value.trim();
        const image_input = document.getElementById('profile_pic');
        const email = document.getElementById('email').value.trim();
        const address = document.getElementById('address').value.trim();

        const form_title = document.querySelector(".staff-header-form h5").textContent;
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

        if (status === '') {
            show_error('status', 'Please select a status.');
            isValid = false;
        }

        if (email === '') {
            show_error('email', 'Please enter the email address.');
            isValid = false;
        } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            show_error('email', 'Please enter a valid email address.');
            isValid = false;
        }

        if (address === '') {
            show_error('address', 'Please enter the address.');
            isValid = false;
        } else if (address.length < 10) {
            show_error('address', 'Please enter a complete address.');
            isValid = false;
        }

        if (form_title.includes("Update Staff Account")) {
            // Password validation for update (optional)
            if (password !== '') {
                if (password.length < 8) {
                    show_error('password', 'Password must be at least 8 characters.');
                    isValid = false;
                }
            }

        } else {
            // Password is required for new accounts
            if (password === '') {
                show_error('password', 'Please enter a password.');
                isValid = false;
            } else if (password.length < 8) {
                show_error('password', 'Password must be at least 8 characters.');
                isValid = false;
            } else if (password !== cpassword) {
                show_error('cpassword', 'Password and confirm password don\'t match.');
                isValid = false;
            }

            if (image_input.files.length === 0) {
                show_error('profile_pic', 'Please upload a profile picture.');
                isValid = false;
            }
        }

        return isValid;
    }

    function show_error(elementId, errorMessage) {
        const errorElement = document.createElement('p');
        errorElement.classList.add('error-message');
        errorElement.textContent = errorMessage;
        errorElement.style.color = 'var(--red)';
        errorElement.style.fontSize = 'var(--small)';

        var field = document.getElementById(elementId);
        var parent = field.parentElement;

        // Add red border to the input field
        field.style.borderColor = 'var(--red)';
        field.style.backgroundColor = '#fff';

        switch (elementId) {
            case "password":
                parent = field.parentElement.parentElement.parentElement;
                errorElement.style.gridColumn = "1/3";
                break;
            case "cpassword":
                parent = field.parentElement.parentElement;
                errorElement.style.gridColumn = "1/3";
                break;
            case "profile_pic":
                parent = field.parentElement.parentElement;
                errorElement.style.gridColumn = "1/3";
                // Add red border to the upload container
                field.parentElement.style.borderColor = 'var(--red)';
                break;
        }

        parent.appendChild(errorElement);
    }


    function clear_error_msg() {
        const errorMessages = document.querySelectorAll('.error-message');
        const allInputs = document.querySelectorAll('#staff-form input, #staff-form select, #staff-form textarea');

        // Remove all error messages
        errorMessages.forEach(error => error.remove());

        // Reset all input styles
        allInputs.forEach(input => {
            input.style.borderColor = '';
            input.style.backgroundColor = '';
            if (input.type === 'file') {
                input.parentElement.style.borderColor = '';
            }
        });
    }

    function isValidMobileNumber(number) {
        // Add your mobile number validation logic here
        // For example, you might check if the number matches a specific pattern
        if (number.match(/09[0-9]{9}/)) {
            return true; // Change this based on your validation logic
        } else {
            return false;
        }
    }

    function rmv_error_msg_on_data_change() {
        const form = document.getElementById('staff-form');
        const allInputs = form.querySelectorAll('input, select, textarea');

        allInputs.forEach(input => {
            const eventType = input.type === 'file' || input.tagName === 'SELECT' ? 'change' : 'input';

            input.addEventListener(eventType, () => {
                // Remove error styling
                input.style.borderColor = '';
                input.style.backgroundColor = '';

                // For file input, also reset the container border
                if (input.type === 'file') {
                    input.parentElement.style.borderColor = '';
                }

                // Find and remove error message
                let parent = input.parentElement;
                if (input.id === 'password' || input.id === 'cpassword') {
                    parent = input.parentElement.parentElement.parentElement;
                } else if (input.id === 'profile_pic') {
                    parent = input.parentElement.parentElement;
                }

                const errorMsg = parent.querySelector('.error-message');
                if (errorMsg) {
                    errorMsg.remove();
                }
            });
        });
    }

    return {
        validate_staff_information,
        clear_error_msg,
        rmv_error_msg_on_data_change
    }

})();