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
    const color_input_field = document.querySelector(".color-form-container input")

    const form = document.querySelector("#product-property-form");

    function add_events() {
        classification_select.addEventListener('change', classification_change_event);
        color_input.addEventListener('change', set_hex);
        color_input_field.addEventListener('keyup', set_color);
    };

    function classification_change_event() {
        console.log(classification_select.value);
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

        // Form_Validation.clear_error_msg();
    }

    function reset_form() {
        // Form_Validation.clear_error_msg();
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