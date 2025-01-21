document.addEventListener("DOMContentLoaded", function() {
    Form.add_events();
})

const Form = (function () {
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
        switch(classification_select.value) {
            case 'texture':
                hide_inputs();
                texture_container.style.display = "flex";
                break;

            case 'material':
                hide_inputs();
                material_container.style.display = "flex";
                break;
            
            case 'color':
                hide_inputs();
                color_form_container.style.display = "flex";
                color_input_container.style.display = "flex";
                break;
        }
    }

    function hide_inputs () {
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
        add_events
    }
})();
