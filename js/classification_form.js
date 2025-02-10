document.addEventListener("DOMContentLoaded", function() {
    Form_Dom_Manipulate.add_events();
    Csf_form_functions.add_events();
})

const Form_Dom_Manipulate = (function() {
    const classification_select = document.querySelector("#classification-select");
    const material_container = document.querySelector(".material-container-form");
    const texture_container = document.querySelector(".texture-container-form");
    const color_form_container = document.querySelector(".color-main-container");
    const color_input_container = document.querySelector(".color-input");
    const color_input = color_input_container.querySelector("input");
    const color_input_field = document.querySelector(".color-form-container input");
    const color_name = document.getElementById("color-name");
    
    const texture_el = document.getElementById('texture');
    const material_el = document.getElementById('material');
    const color_el = document.getElementById('hexvalue');
    const category_el = document.getElementById('category');
    const brand_el = document.getElementById('brand');
    const category_image_el = document.getElementById('category-image');
    const brand_image_el = document.getElementById('brand-image');
    const category_select_el = document.getElementById('category-select');


    const category_container = document.querySelector(".category-container-form");
    const brand_container = document.querySelector(".brand-container-form");
    const category_image_input = document.getElementById('category-image');
    const category_image_preview = document.getElementById('category-image-preview');
    const brand_image_input = document.getElementById('brand-image');
    const brand_image_preview = document.getElementById('brand-image-preview');

    const hidden_id = document.querySelector("#hidden-id");
    const hidden_csf = document.querySelector("#hidden-csf");



    const form = document.querySelector("#product-property-form");

    function add_events() {
        classification_select.addEventListener('change', classification_change_event);
        color_input.addEventListener('change', set_hex);
        color_input_field.addEventListener('keyup', set_color);
        category_image_input.addEventListener('change', preview_image.bind(null, category_image_preview));
        brand_image_input.addEventListener('change', preview_image.bind(null, brand_image_preview));
    }

    function classification_change_event(classification) {
        const error_msg_el = document.querySelector('.error-message');
        const classification_v = classification.type === "change"  ?  classification_select.value : classification;
        console.log(classification_v);
        if (error_msg_el) {
            if (error_msg_el.className === 'error-message') {
                error_msg_el.remove();
            }
        }

        [texture_el, material_el, color_el, category_el, brand_el, category_image_el, brand_image_el].forEach(input => {
            input.style.border = '';
        });

        switch (classification_v) {
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
                break;

            case 'category':
                hide_inputs();
                classification_select.value = "category";
                category_container.style.display = "flex";
                break;

            case 'brand':
                hide_inputs();
                classification_select.value = "brand";
                brand_container.style.display = "flex";
                populate_category_select();
                break;
        }
    }

    function hide_inputs() {
        form.reset()
        hidden_id.value = "";
        hidden_csf.value = "";
        material_container.style.display = "none";
        texture_container.style.display = "none";
        color_form_container.style.display = "none";
        category_container.style.display = "none";
        brand_container.style.display = "none";
        category_image_preview.style.display = "none";
        brand_image_preview.style.display = "none";
    }

    function set_hex() {
        color_input_field.value = color_input.value;
    }

    function set_color() {
        color_input.value = color_input_field.value;
    }

    function preview_image(previewElement, event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewElement.src = e.target.result;
                previewElement.style.display = 'block';
            }
            reader.readAsDataURL(file);
        }
    }

    function populate_category_select() {
        return fetch('../api/classification_api.php?action=get_all_categorys')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    category_select_el.innerHTML = '<option value="" disabled>Select a category</option>';
                    data.categorys.forEach(category => {
                        const option = document.createElement('option');
                        option.value = category.id;
                        option.textContent = category.category_name;
                        category_select_el.appendChild(option);
                    });
                }
            })
            .catch(error => console.error('Error fetching categories:', error));
    }

    function fill_form(data) {
        var data = data[0];
        switch (classification_select.value) {
            case 'texture':
                texture_el.value = data.texture_name;
                break;

            case 'material':
                material_el.value = data.material_name;
                break;

            case 'color':
                color_el.value = data.hex_value;
                color_input_field.value = data.hex_value;
                color_name.value = data.color_name;
                break;

            case 'category':
                category_el.value = data.category_name;
                category_image_preview.src = "../" + data.image_path;
                category_image_preview.style.display = 'block';
                document.getElementById('category-type').value = data.category_type;
                break;

            case 'brand':
                brand_el.value = data.brand_name;
                brand_image_preview.src = "../" + data.image_path;
                brand_image_preview.style.display = 'block';
                
                populate_category_select().then(() => {
                    category_select_el.value = data.category_id;
                });
                break;
        }

        classification_select.disabled = true;
        hidden_id.value = data.id;
        hidden_csf.value = classification_select.value;
    }

    return {
        add_events,
        classification_change_event,
        hide_inputs,
        fill_form
    }
})();

const Csf_form_functions = (function() {
    const classification_select = document.querySelector("#classification-select");
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

        classification_select.disabled = false;

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
    const color_name_el = document.getElementById('color-name')


    const category_el = document.getElementById('category');
    const category_image_el = document.getElementById('category-image');
    const brand_el = document.getElementById('brand');
    const brand_image_el = document.getElementById('brand-image');

    const category_select_el = document.getElementById('category-select')
    const category_type_el = document.getElementById('category-type');

    const submit_btn = document.querySelector('#classification-add-btn');

    function validate_csf() {
        const csf_select = csf_select_el.value.trim();
        const texture = texture_el.value.trim();
        const material = material_el.value.trim();
        const color = color_el.value.trim();
        const color_name = color_name_el.value.trim();

        const category = category_el.value.trim();
        const category_image = category_image_el.value;
        const brand = brand_el.value.trim();
        const brand_image = brand_image_el.value;
        const category_select = category_select_el.value.trim();

        const category_type = category_type_el.value.trim();

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
            } else if (color_name == "") {
                show_error('color-name', "Please enter a color name");
            }
        }

        if (csf_select === 'category') {
            if (category === '') {
                show_error('category', 'Please enter the category name.');
                isValid = false;
            }else if (category_image === '' && submit_btn.textContent === 'Add') {
                show_error('category-image', 'Please select a category image.');
                isValid = false;
            }else if(category_type === '') {
                show_error('category-type', 'Please select a category type');
                isValid = false;``
            }
        }

        if (csf_select === 'brand') {
            if (category_select === '') {
                show_error('category-select', 'Please select a category.');
                isValid = false;
            }else if (brand === '') {
                show_error('brand', 'Please enter the brand name.');
                isValid = false;
            }else if (brand_image === '' && submit_btn.textContent === 'Add') {
                show_error('brand-image', 'Please select a brand image.');
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
        [csf_select_el, texture_el, material_el, color_el, category_el, category_image_el, brand_el, brand_image_el, category_select_el].forEach(input => {
            input.style.border = '';
        });
    }

    function rmv_error_msg_on_data_change() {
        [material_el, texture_el, color_el, category_el, category_image_el, brand_el, brand_image_el].forEach(input => {
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