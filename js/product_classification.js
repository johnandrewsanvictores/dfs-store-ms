document.addEventListener("DOMContentLoaded", function() {
    ProductClassification.init();
    Controls.add_events();
    Csf_form_main.add_events();
});

const ProductClassification = (function() {
    function init() {
        load_classifications('category');
        setup_filter_tabs();
        setup_remove_selected_btn();
    }

    function load_classifications(classification, categoryId = null, categoryName = '') {
        let url = `../api/classification_api.php?action=get_all_${classification}s`;
        if (classification === 'brand' && categoryId) {
            url = `../api/classification_api.php?action=get_brands_by_category&category_id=${categoryId}`;
        }

        const xhr = new XMLHttpRequest();
        xhr.open('GET', url, true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                try {
                    const data = JSON.parse(xhr.responseText);
                    const cardContainer = document.getElementById('card-container');
                    cardContainer.innerHTML = '';
                    if (data.success && data[`${classification}s`].length > 0) {
                        data[`${classification}s`].forEach(item => {
                            const card = create_card(item, classification);
                            cardContainer.appendChild(card);
                        });
                    } else {
                        cardContainer.innerHTML = `<p class="no-data-message">No ${classification}s available.</p>`;
                    }
                    if (classification === 'brand' && categoryName) {
                        document.getElementById('list-title').textContent = `List of ${categoryName} Brands`;
                    } else {
                        document.getElementById('list-title').textContent = `List of ${classification.charAt(0).toUpperCase() + classification.slice(1)}s`;
                    }
                    reset_remove_selected_btn();
                } catch (e) {
                    console.error('Error parsing JSON:', e);
                }
            } else {
                console.error(`Error fetching ${classification}s:`, xhr.statusText);
            }
        };
        xhr.onerror = function() {
            console.error('Request error...');
        };
        xhr.send();
    }

    function create_card(item, classification) {
        const card = document.createElement('div');
        card.classList.add('card');
        let cardContent = `
            <div class="checkbox-container">
                <input type="checkbox" class="select-checkbox" data-id="${classification}-${item.id}">
            </div>
        `;

        if (classification === 'color') {
            cardContent += `<h3>${item.hex_value}</h3>`;
        } else {
            cardContent += `<h3 class="${classification === 'category' ? 'category-name' : ''}">${item[`${classification}_name`]}</h3>`;
        }

        if (classification === 'category' || classification === 'brand') {
            cardContent += `<img src="../${item.image_path}" alt="${item[`${classification}_name`]}" class="card-image">`;
        }

        cardContent += `
            <div class="card-color-info"><div class="actions">
                <button class="edit-btn" id="${classification}-${item.id}"><i class="fas fa-edit"></i></button>
                <button class="delete-btn" id="${classification}-${item.id}"><i class="fas fa-trash-alt"></i></button>
            </div>
        `;

        if (classification === 'color') {
            cardContent += `<div class="color-preview" style="background-color: ${item.hex_value};"></div></div>`;
        }

        card.innerHTML = cardContent;

        if (classification === 'category') {
            const categoryNameElement = card.querySelector('.category-name');
            categoryNameElement.addEventListener('click', function() {
                load_classifications('brand', item.id, item.category_name);
            });
        }

        const deleteBtn = card.querySelector('.delete-btn');
        deleteBtn.addEventListener('click', function() {
            const [classification, id] = this.id.split('-');
            let message = `Are you sure you want to delete this ${classification}?`;
            if (classification === 'category') {
                message += ` This will also delete all brands under this category.`;
            }
            Popup1.show_confirm_dialog(message, function() {
                delete_items(classification, [id]);
            });
        });

        const edit_btn = card.querySelector('.edit-btn');
        edit_btn.addEventListener('click', Csf_form_main.update_data_event)

        return card;
    }

    function setup_filter_tabs() {
        const filterTabs = document.querySelectorAll('.filter-tab');
        filterTabs.forEach(tab => {
            tab.addEventListener('click', function() {
                filterTabs.forEach(t => t.classList.remove('active'));
                this.classList.add('active');
                const classification = this.getAttribute('data-filter');
                load_classifications(classification);
            });
        });
    }

    function setup_remove_selected_btn() {
        const removeSelectedBtn = document.getElementById('remove-selected-btn');
        const cardContainer = document.getElementById('card-container');

        cardContainer.addEventListener('change', function() {
            const selectedCheckboxes = cardContainer.querySelectorAll('.select-checkbox:checked');
            removeSelectedBtn.textContent = `Remove selected (${selectedCheckboxes.length})`;
            removeSelectedBtn.disabled = selectedCheckboxes.length === 0;
        });

        removeSelectedBtn.addEventListener('click', function() {
            const selectedCheckboxes = cardContainer.querySelectorAll('.select-checkbox:checked');
            const ids = Array.from(selectedCheckboxes).map(checkbox => checkbox.getAttribute('data-id'));
            if (ids.length === 0) {
                return;
            }
            let message = `Are you sure you want to delete the selected items?`;
            Popup1.show_confirm_dialog(message, function() {
                const classification = ids[0].split('-')[0];
                delete_items(classification, ids.map(id => id.split('-')[1]));
            });
        });
    }

    function reset_remove_selected_btn() {
        const removeSelectedBtn = document.getElementById('remove-selected-btn');
        removeSelectedBtn.textContent = `Remove selected (0)`;
        removeSelectedBtn.disabled = true;
    }

    function delete_items(classification, ids) {
        console.log('Deleting items:', classification, );
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '/dfs-store-ms/api/classification_api.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.success) {
                    Popup1.show_message(response.message, 'success');
                    load_classifications(classification);
                } else {
                    Popup1.show_message(response.message, 'error');
                }
            } else {
                console.error('Error:', xhr.status);
            }
        };
        xhr.send(`action=delete_data&classification=${classification}&ids=${ids.join(',')}`);
    }

    return {
        init,
        load_classifications
    };
})();

const Controls = (function() {
    const new_btn = document.querySelector("#csf-new-btn");

    function add_events() {
        new_btn.addEventListener("click", Csf_form_main.add_data_event);
    }

    return {
        add_events
    };
})();

const Csf_form_main = (function() {
    const form_title = document.querySelector("#csf-form-title");
    const csf_form = document.querySelector("#product-property-form");
    const submit_btn = document.querySelector("#classification-add-btn");

    function add_events() {
        csf_form.addEventListener('submit', submit_data);
        Form_Validation.rmv_error_msg_on_data_change();
    }

    function add_data_event() {
        form_title.textContent = "Add New Product Property";
        submit_btn.textContent = "Add";
        // Get the initial classification value
        const classification_select = document.querySelector("#classification-select");
        Form_Dom_Manipulate.classification_change_event(classification_select.value);
        Csf_form_functions.show_csf_form();
    }

    async function update_data_event(e) {
        if (!e) {
            const id = document.querySelector("#hidden-id").value;
            const classification = document.querySelector("#hidden-csf").value;
            Request_Csf.update_data(csf_form);
            return;
        }

        let target = e.target;
        if (target.tagName.toLowerCase() === 'i') {
            target = target.parentElement;
        }
        const [classification, id] = target.id.split('-');
        form_title.textContent = "Update Product Property";
        submit_btn.textContent = "Update";
        const data = await Request_Csf.get_specific_csf_data(classification, id);

        Form_Dom_Manipulate.classification_change_event(classification);
        Csf_form_functions.show_csf_form();

        Form_Dom_Manipulate.fill_form(data);
    }

    function submit_data(e) {
        e.preventDefault();

        const classification_select = document.querySelector("#classification-select");
        const hidden_csf = document.querySelector("#hidden-csf");
        hidden_csf.value = classification_select.value;

        if (Form_Validation.validate_csf()) {
            if (form_title.textContent === "Add New Product Property") {
                Request_Csf.add_data(csf_form);
            } else if (form_title.textContent === "Update Product Property") {
                update_data_event();
            }
        }
    }

    return {
        add_events,
        update_data_event,
        add_data_event
    };
})();

const Request_Csf = (function() {
    function add_data(form) {
        const formData = new FormData(form);
        formData.append('action', "add_data");
        const classification = formData.get('classification');
        console.log(classification);

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
                        ProductClassification.load_classifications(classification);
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
        const formData = new FormData(form);
        formData.append('action', 'update_data');
        
        // Only add old_img_src for brand or category
        const classification = formData.get('classification');
        if (classification === 'brand' || classification === 'category') {
            const old_img = document.querySelector(`#${classification}-image-preview`).src.split('/dfs-store-ms/')[1];
            formData.append('old_img_src', old_img);
        }

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
                        ProductClassification.load_classifications(formData.get('classification'));
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

    function get_specific_csf_data(classification, id) {
        return new Promise((resolve, reject) => {
            const xhr = new XMLHttpRequest();
            const url = `/dfs-store-ms/api/classification_api.php?action=get_specific_data&id=${id}&classification=${classification}`;
            xhr.open('GET', url, true);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        const response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            resolve(response.data);
                        } else {
                            reject(response.message || 'An error occurred');
                        }
                    } else {
                        reject('Error occurred while processing your request');
                    }
                }
            };
            xhr.send();
        });
    }

    return {
        add_data,
        update_data,
        get_specific_csf_data,
        delete_items: ProductClassification.delete_items
    };
})();
