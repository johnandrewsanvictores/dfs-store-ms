document.addEventListener("DOMContentLoaded", function() {
    Form_Dom_Manipulate.add_events();
    Csf_form_functions.add_events();
})

const Form_Dom_Manipulate = (function() {
    const classification_select = document.querySelector("#classification-select");
    const material_container = document.querySelector(".material-container-form");
    const texture_container = document.querySelector(".texture-container-form");
    const color_form_container = document.querySelector(".color-form-container");
    const color_input_container = document.querySelector(".color-input");
    const color_input = color_input_container.querySelector("input");
    const color_input_field = document.querySelector(".color-form-container input");
    const texture_el = document.getElementById('texture');
    const material_el = document.getElementById('material');
    const color_el = document.getElementById('hexvalue');

    const form = document.querySelector("#product-property-form");

    function add_events() {
        classification_select.addEventListener('change', classification_change_event);
        color_input.addEventListener('change', set_hex);
        color_input_field.addEventListener('keyup', set_color);
    };

    function classification_change_event() {
        const error_msg_el = document.querySelector('.error-message');
        if (error_msg_el) {
            if (error_msg_el.className === 'error-message') {
                error_msg_el.remove();
            }
        }

        [texture_el, material_el, color_el].forEach(input => {
            input.style.border = '';
        });

        switch (classification_select.value) {
            case 'texture':
                hide_inputs();
                classification_select.value = "texture";
                texture_container.style.display = "flex";
                break;

            case 'material':
                hide_inputs();
                classification_select.value = "material";
                material_container.style.display = "flex";
                break;

            case 'color':
                hide_inputs();
                classification_select.value = "color";
                color_form_container.style.display = "flex";
                color_input_container.style.display = "flex";
                break;
        }
    }

    function hide_inputs() {
        form.reset()
        material_container.style.display = "none";
        texture_container.style.display = "none";
        color_form_container.style.display = "none";
        color_input_container.style.display = "none";

    }

    function set_hex() {
        color_input_field.value = color_input.value;
    }

    function set_color() {
        color_input.value = color_input_field.value;
    }

    return {
        add_events,
        hide_inputs
    }
})();

const Csf_form_functions = (function() {
    const csf_form_wrapper = document.querySelector(".csf-form-wrapper");
    const csf_form_container = document.querySelector(".csf-form-container");

    const x_form_btn = document.querySelector("#x-csf-form-btn");

    function add_events() {
        x_form_btn.addEventListener("click", cancel_form);
    }

    function cancel_form() {
        csf_form_container.style.opacity = '0';
        csf_form_container.style.visibility = 'hidden';
        csf_form_container.style.transform = 'scale(0)';

        csf_form_wrapper.style.opacity = '0';
        csf_form_wrapper.style.visibility = 'hidden';
        csf_form_wrapper.style.transform = 'scale(0)';

        Form_Dom_Manipulate.hide_inputs();
        Form_Validation.clear_error_msg();
    }

    function reset_form() {
        Form_Validation.clear_error_msg();
        Form_Dom_Manipulate.hide_inputs();
    }

    function show_csf_form() {
        csf_form_container.style.opacity = '1';
        csf_form_container.style.visibility = 'visible';
        csf_form_container.style.transform = 'scale(1)';

        csf_form_wrapper.style.opacity = '1';
        csf_form_wrapper.style.visibility = 'visible';
        csf_form_wrapper.style.transform = 'scale(1)';
    }

    return {
        cancel_form,
        show_csf_form,
        add_events,
        reset_form
    }

})();

const Form_Validation = (function() {
    const csf_select_el = document.getElementById('classification-select');
    const texture_el = document.getElementById('texture');
    const material_el = document.getElementById('material');
    const color_el = document.getElementById('hexvalue');
    const color_input = document.getElementById('color');

    function validate_csf() {
        const csf_select = csf_select_el.value.trim();
        const texture = texture_el.value.trim();
        const material = material_el.value.trim();
        const color = color_el.value.trim();

        let isValid = true;

        clear_error_msg();

        if (csf_select === '') {
            show_error('classification-select', 'Please select a classification.');
            isValid = false;
        }

        if (csf_select === 'texture' && texture === '') {
            show_error('texture', 'Please enter the texture.');
            isValid = false;
        }

        if (csf_select === 'material' && material === '') {
            show_error('material', 'Please enter the material.');
            isValid = false;
        }

        if (csf_select === 'color') {
            if (color === '') {
                show_error('hexvalue', 'Please enter a hex value or select a color.');
                isValid = false;
            } else if (!/^#[0-9A-F]{6}$/i.test(color)) {
                show_error('hexvalue', 'Please enter a valid color hex value.');
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

        const field = document.getElementById(elementId);
        field.style.border = '1px solid var(--red)';

        const form = document.getElementById('product-property-form');
        const formContent = form.querySelector('.form-content');
        form.insertBefore(errorElement, formContent.nextSibling);

        field.addEventListener('input', () => remove_error(field, errorElement));
        if (elementId === 'hexvalue') {
            color_input.addEventListener('change', () => remove_error(field, errorElement));
        }
    }

    function remove_error(field, errorElement) {
        field.style.border = '';
        if (errorElement && errorElement.className === 'error-message') {
            errorElement.remove();
        }
    }

    function clear_error_msg() {
        const errorMessages = document.querySelectorAll('.error-message');
        errorMessages.forEach(error => error.remove());
        [csf_select_el, texture_el, material_el, color_el].forEach(input => {
            input.style.border = '';
        });
    }

    function rmv_error_msg_on_data_change() {
        [material_el, texture_el, color_el].forEach(input => {
            input.addEventListener('keyup', () => remove_msg_error_el(input));
        });
        color_input.addEventListener('change', () => remove_msg_error_el(color_el));
    }

    function remove_msg_error_el(input) {
        input.style.border = '';
        const error_msg_el = input.parentElement.parentElement.querySelector('.error-message');
        if (error_msg_el && error_msg_el.className === 'error-message') {
            error_msg_el.remove();
        }
    }

    return {
        validate_csf,
        clear_error_msg,
        rmv_error_msg_on_data_change
    }
})();