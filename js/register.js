const Register_Form = (function() {
    const register_form = document.querySelector(".register-form-container form");
    const toggle_password_btns = document.querySelectorAll(".toggle-password");

    function add_events() {
        register_form.addEventListener('submit', submit_data);
        
        // Add password toggle events
        toggle_password_btns.forEach(btn => {
            btn.addEventListener('click', toggle_password_visibility);
        });
    }

    function toggle_password_visibility(e) {
        const password_input = e.target.previousElementSibling;
        const type = password_input.type === 'password' ? 'text' : 'password';
        password_input.type = type;
        e.target.classList.toggle('fa-eye');
        e.target.classList.toggle('fa-eye-slash');
    }

    function submit_data(e) {
        e.preventDefault();

        if(Form_Validation.validate_registration()){
            // For now, just show success message
            alert('Form is valid! Ready for backend integration.');
        }

        Form_Validation.rmv_error_msg_on_data_change();
    }

    return {
        add_events
    }
})();

const Form_Validation = (function() {
    function show_error(element, message) {
        remove_error(element);
        const error_div = document.createElement('div');
        error_div.className = 'error-message';
        error_div.style.color = 'red';
        error_div.style.fontSize = '10px';
        error_div.style.marginTop = '4px';
        error_div.textContent = message;
        
        element.parentNode.appendChild(error_div);
        element.style.borderColor = 'red';
    }

    function remove_error(element) {
        const error = element.parentNode.querySelector('.error-message');
        if (error) {
            error.remove();
            element.style.borderColor = '';
        }
    }

    function validate_registration() {
        let is_valid = true;

        // Clear previous errors
        document.querySelectorAll('.error-message').forEach(error => error.remove());

        // First Name validation
        const firstname = document.querySelector('#firstname');
        if (!firstname.value.trim()) {
            show_error(firstname, 'First name is required');
            is_valid = false;
        } else if (firstname.value.length < 2) {
            show_error(firstname, 'First name must be at least 2 characters');
            is_valid = false;
        } else if (!/^[a-zA-Z\s]*$/.test(firstname.value)) {
            show_error(firstname, 'First name can only contain letters');
            is_valid = false;
        }

        // Last Name validation
        const lastname = document.querySelector('#lastname');
        if (!lastname.value.trim()) {
            show_error(lastname, 'Last name is required');
            is_valid = false;
        } else if (lastname.value.length < 2) {
            show_error(lastname, 'Last name must be at least 2 characters');
            is_valid = false;
        } else if (!/^[a-zA-Z\s]*$/.test(lastname.value)) {
            show_error(lastname, 'Last name can only contain letters');
            is_valid = false;
        }

        // Email validation
        const email = document.querySelector('#email');
        const email_regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!email.value.trim()) {
            show_error(email, 'Email is required');
            is_valid = false;
        } else if (!email_regex.test(email.value)) {
            show_error(email, 'Please enter a valid email address');
            is_valid = false;
        }

        // Phone validation
        const phone = document.querySelector('#phone');
        const phone_regex = /^\d{10}$/;
        if (!phone.value.trim()) {
            show_error(phone, 'Phone number is required');
            is_valid = false;
        } else if (!phone_regex.test(phone.value)) {
            show_error(phone, 'Please enter a valid 10-digit phone number');
            is_valid = false;
        }

        // Password validation
        const password = document.querySelector('#password');
        if (!password.value) {
            show_error(password, 'Password is required');
            is_valid = false;
        } else if (password.value.length < 8) {
            show_error(password, 'Password must be at least 8 characters');
            is_valid = false;
        } else if (!/[A-Z]/.test(password.value)) {
            show_error(password, 'Password must contain at least one uppercase letter');
            is_valid = false;
        } else if (!/[a-z]/.test(password.value)) {
            show_error(password, 'Password must contain at least one lowercase letter');
            is_valid = false;
        } else if (!/[0-9]/.test(password.value)) {
            show_error(password, 'Password must contain at least one number');
            is_valid = false;
        } else if (!/[!@#$%^&*]/.test(password.value)) {
            show_error(password, 'Password must contain at least one special character (!@#$%^&*)');
            is_valid = false;
        }

        // Confirm Password validation
        const confirm_password = document.querySelector('#confirm_password');
        if (!confirm_password.value) {
            show_error(confirm_password, 'Please confirm your password');
            is_valid = false;
        } else if (confirm_password.value !== password.value) {
            show_error(confirm_password, 'Passwords do not match');
            is_valid = false;
        }

        return is_valid;
    }

    function rmv_error_msg_on_data_change() {
        const form_inputs = document.querySelectorAll('.register-form-container form input');
        
        form_inputs.forEach(input => {
            input.addEventListener('input', function() {
                remove_error(this);
            });
            
            // Special handling for terms checkbox
            if (input.type === 'checkbox') {
                input.addEventListener('change', function() {
                    remove_error(this);
                });
            }
        });
    }

    return {
        validate_registration,
        rmv_error_msg_on_data_change
    }
})();

// Initialize when DOM is loaded
document.addEventListener("DOMContentLoaded", function() {
    Register_Form.add_events();
});