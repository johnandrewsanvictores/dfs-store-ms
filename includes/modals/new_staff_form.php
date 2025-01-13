<section class="staff-form-wrapper">
    <div class="staff-form-container">
        <div class="staff-header-form">
            <h5>Add New Staff Account</h5>
            <i class="fa-solid fa-xmark" id="x-staff-form-btn"></i>
        </div>

        <form action="" method="POST" id="staff-form">
            <div class="input-div">
                <label for="name">Name<span>*</span></label>
                <input type="text" name="name" id="name">
            </div>

            <div class="input-div">
                <label for="username">Username<span>*</span></label>
                <input type="text" name="username" id="username">
            </div>

            <div class="input-div">
                <label for="pnumber">Phone number<span>*</span></label>
                <input type="text" name="pnumber" id="pnumber">
            </div>

            <div class="input-div">
                <label for="role">Role<span>*</span></label>
                <div class="container">
                    <div class="select">
                        <select>
                            <option value="" disabled selected>Select an option</option>
                            <option value="admin">Admin</option>
                            <option value="cashier">Cashier</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="password-container">
                <div class="input-div">
                    <label for="password">Password<span>*</span></label>
                    <div class="password-input-div">
                        <input type="password" name="password" id="password">
                        <div>
                            <i class="fa-regular fa-eye show-pass-btn" id=""></i>
                            <!-- <i class="fa-regular fa-eye-slash"></i> -->
                        </div>
                    </div>
                </div>

                <div class="input-div">
                    <label for="cpassword">Confirm Password<span>*</span></label>
                    <div class="password-input-div">
                        <input type="password" name="cpassword" id="cpassword">
                        <div>
                            <i class="fa-regular fa-eye show-pass-btn" id=""></i>
                            <!-- <i class="fa-regular fa-eye-slash" id="hide-pass-btn"></i> -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-btn-container">
                <button id="cancel-staff-form-btn" type="button">Cancel</button>
                <button id="submit-staff-form-btn" type="submit" name="submit">Submit</button>
            </div>
        </form>
    </div>
</section>


<style>
    .staff-form-wrapper {
        position: fixed;
        width: 100vw;
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        top: 0;
        left: 0;
        background-color: #0e0c0c49;
        z-index: 1000;

        transform: scale(0);
        opacity: 0;
        visibility: hidden;
    }

    .staff-form-container {
        background-color: var(--white-bg);
        padding: 1em;
        width: 100%;
        max-width: 30em;
        border-radius: 20px;
        border: 10px solid #fff;

        transform: scale(0);
        opacity: 0;
        visibility: hidden;
        transition: 0.3s all ease-out;
    }

    .staff-header-form {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1em;

    }

    .staff-header-form h5 {
        color: var(--font-dark);
    }

    .staff-header-form i {
        color: var(--font-dark);
        font-size: 20px;
        cursor: pointer;
    }

    .staff-form-container form {
        width: 100%;
        display: flex;
        flex-direction: column;
        gap: 1em;
    }

    .staff-form-container .input-div {
        width: 100%;
        display: flex;
        flex-direction: column;
        gap: 0.5em;
    }

    .staff-form-container .input-div label {
        font-size: var(--small);
    }

    .staff-form-container .input-div label span {
        color: var(--red);
    }

    .staff-form-container .input-div input {
        width: 100%;
        border-radius: 5px;
        background-color: var(--input-bg-color);
        outline: none;
        border: none;
        padding: 1em 1.5em;
        font-size: var(--small);
        color: inherit;
    }

    .staff-form-container .input-div input:not(.password-input-div input):focus,
    .password-input-div:focus-within {
        -webkit-box-shadow: inset 0px 0px 0px 1px var(--stroke-grey);
        -moz-box-shadow: inset 0px 0px 0px 1px var(--stroke-grey);
        box-shadow: inset 0px 0px 0px 1px var(--stroke-grey);
    }


    .password-container {
        display: flex;
        gap: 1em;
    }

    .password-input-div {
        display: flex;
        align-items: center;
        border-radius: 5px;
        gap: 0.5em;
        background-color: var(--input-bg-color);
        padding: 3px 0.5em;
    }

    .password-input-div i {
        font-size: 16px;
        color: var(--font-dark);
        cursor: pointer;
    }

    .staff-form-container .form-btn-container {
        align-self: flex-end;
        display: flex;
        gap: 0.5em;
    }

    .staff-form-container .form-btn-container button {
        padding: 0.5em 1em;
        font-family: inherit;
        color: var(--font-white);
        border-radius: 5px;
        font-size: var(--body);
        border: none;
        outline: none;
        cursor: pointer;
    }

    #cancel-staff-form-btn {
        background-color: var(--white-bg);
        border: 1px solid var(--stroke-grey);
        color: var(--font-dark);
    }

    #submit-staff-form-btn {
        background-color: var(--primary);
    }

    #submit-staff-form-btn:hover {
        background-color: var(--primary-hover-color);
    }


    select {
        /* Reset Select */
        appearance: none;
        outline: 10px red;
        border: 0;
        box-shadow: none;
        /* Personalize */
        flex: 1;
        padding: 0 1em;
        color: var(--font-dark);
        background-color: var(--white-bg);
        border: 1px solid var(--stroke-grey);
        background-image: none;
        cursor: pointer;
        border-radius: 5px;
    }

    /* Remove IE arrow */
    select::-ms-expand {
        display: none;
    }

    /* Custom Select wrapper */
    .select {
        position: relative;
        display: flex;
        width: 13em;
        height: 3em;
        border-radius: .25em;
        overflow: hidden;
    }

    /* Arrow */
    .select::after {
        content: '\25BC';
        position: absolute;
        top: -5px;
        right: 0;
        padding: 1em;
        color: var(--font-white);
        background-color: var(--font-dark);
        transition: .25s all ease;
        pointer-events: none;
    }

    /* Transition */
    .select:hover::after {
        color: var(--secondary);
    }
</style>


<script>
    const staff_form_wrapper = document.querySelector(".staff-form-wrapper");
    const staff_form_container = document.querySelector(".staff-form-container");

    const x_form_btn = document.querySelector("#x-staff-form-btn");
    const eye_btns = document.querySelectorAll('.show-pass-btn');
    const hide_pass_btn = document.querySelector('#hide-pass-btn');

    const cancel_form_btn = document.querySelector("#cancel-staff-form-btn");
    const submit_form_btn = document.querySelector("#submit-staff-form-btn");

    document.addEventListener("DOMContentLoaded", function() {
        x_form_btn.addEventListener("click", Staff_form_functions.cancel_form);
        cancel_form_btn.addEventListener("click", Staff_form_functions.cancel_form);

        eye_btns.forEach(btn => {
            btn.addEventListener("click", Staff_form_functions.change_password_type_input)
        });
    })

    const Staff_form_functions = (function() {

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
            const eye_btn_container = eye_btn.parentElement;



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
            change_password_type_input
        }

    })();
</script>