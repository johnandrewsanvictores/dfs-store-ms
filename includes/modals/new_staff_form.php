<section class="staff-form-wrapper">
    <div class="staff-form-container">
        <div class="staff-header-form">
            <h5>Add New Staff Account</h5>
            <i class="fa-solid fa-xmark" id="x-staff-form-btn"></i>
        </div>

        <form action="" method="POST" id="staff-form" enctype="multipart/form-data" novalidate>
            <div class="form-grid">

                <div class="profile-upload-div">
                    <label>Profile Picture<span>*</span></label>
                    <div class="profile-input-container">
                        <input type="file" name="profile_pic" id="profile_pic" accept="image/*">
                        <div class="upload-placeholder">
                            <div class="upload-icon">
                                <i class="fa-solid fa-user"></i>
                                <i class="fa-solid fa-plus"></i>
                            </div>
                            <p>Upload Photo</p>
                        </div>
                    </div>
                </div>

                <div class="form-fields-container">
                    <input type="hidden" name="staff-id" value="" />
                    <input type="hidden" name="old-img-src" id="old-img-src" value="">


                    <div class="input-group">
                        <div class="input-div">
                            <label for="name">Name<span>*</span></label>
                            <input type="text" name="name" id="name" placeholder="Enter the name">
                        </div>

                        <div class="input-div">
                            <label for="username">Username<span>*</span></label>
                            <input type="text" name="username" id="username" placeholder="Enter the username">
                        </div>
                    </div>

                    <div class="input-group">
                        <div class="input-div">
                            <label for="email">Email<span>*</span></label>
                            <input type="email" name="email" id="email" placeholder="Enter email address">
                        </div>

                        <div class="input-div">
                            <label for="pnumber">Phone number<span>*</span></label>
                            <input type="text" name="pnumber" id="pnumber" placeholder="09xxxxxxxxx" maxlength="11" minlength="11">
                        </div>
                    </div>

                    <div class="input-div">
                        <label for="address">Address<span>*</span></label>
                        <textarea name="address" id="address" placeholder="Enter complete address"></textarea>
                    </div>

                    <div class="input-div">
                        <label for="role">Role<span>*</span></label>
                        <select name="role" id="role">
                            <option value="" disabled selected>Select an option</option>
                            <option value="admin">Admin</option>
                            <option value="cashier">Cashier</option>
                        </select>
                    </div>

                    <div class="input-div">
                        <label for="status">Status<span>*</span></label>
                        <select name="status" id="status">
                            <option value="" disabled selected>Select an option</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>

                    <div class="password-group">
                        <p id="passw-note"><span>Note</span>: Leave the password blank if not changing!</p>
                        <div class="input-group">
                            <div class="input-div">
                                <label for="password">New Password<span>*</span></label>
                                <div class="password-input-div">
                                    <div class="password-field-wrapper">
                                        <input type="password" name="password" id="password" placeholder="Enter the password">
                                        <i class="fa-regular fa-eye show-pass-btn"></i>
                                    </div>
                                    <button type="button" id="generate-password-btn">Generate Password</button>
                                </div>
                            </div>

                            <div class="input-div confirm-password-div">
                                <label for="cpassword">Confirm Password<span>*</span></label>
                                <div class="password-input-div">
                                    <input type="password" name="cpassword" id="cpassword" placeholder="Re-enter the password">
                                    <i class="fa-regular fa-eye show-pass-btn"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-btn-container">
                <button id="reset-staff-form-btn" type="button">Reset</button>
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
        background-color: rgba(14, 12, 12, 0.2);
        backdrop-filter: blur(4px);
        z-index: 1000;
        transform: scale(0);
        opacity: 0;
        visibility: hidden;
    }

    .staff-form-container {
        background-color: var(--white-bg);
        padding: 2em;
        width: 100%;
        max-width: 50em;
        border-radius: 15px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        transform: scale(0);
        opacity: 0;
        visibility: hidden;
        transition: 0.3s all ease-out;
    }

    .staff-header-form {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 2em;
    }

    .staff-header-form h5 {
        color: var(--font-dark);
    }

    .staff-header-form i {
        color: var(--font-dark);
        font-size: 20px;
        cursor: pointer;
        transition: color 0.3s ease;
    }

    .staff-header-form i:hover {
        color: var(--primary);
    }

    #staff-form label span {
        color: var(--red);
    }

    #current-staff-id {
        color: var(--primary);
    }

    .form-grid {
        display: grid;
        grid-template-columns: auto 1fr;
        gap: 2em;
    }

    .profile-upload-div {
        width: 150px;
    }

    .profile-upload-div label {
        display: block;
        margin-bottom: 0.8em;
        color: var(--font-dark);
        font-size: var(--small);
    }

    .profile-input-container {
        position: relative;
        width: 150px;
        height: 150px;
        border: 2px dashed var(--stroke-grey);
        border-radius: 10px;
        overflow: hidden;
        transition: all 0.3s ease;
        cursor: pointer;
        background-color: var(--white-bg);
    }

    .profile-input-container:hover::after {
        content: 'Change Photo';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        color: white;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: var(--small);
    }

    .profile-input-container.has-image {
        border-style: solid;
    }

    .profile-input-container.has-image .upload-placeholder {
        display: none;
    }

    .profile-preview-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: none;
    }

    .profile-input-container.has-image .profile-preview-image {
        display: block;
    }

    .profile-input-container input[type="file"] {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        opacity: 0;
        cursor: pointer;
        z-index: 3;
    }

    .upload-placeholder {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
        width: 100%;
    }

    .upload-icon {
        position: relative;
        width: 50px;
        height: 50px;
        margin: 0 auto 8px;
    }

    .upload-icon .fa-user {
        font-size: 2em;
        color: var(--stroke-grey);
    }

    .upload-icon .fa-plus {
        position: absolute;
        bottom: -2px;
        right: -2px;
        font-size: 1em;
        background-color: var(--stroke-grey);
        color: var(--white-bg);
        padding: 4px;
        border-radius: 50%;
    }

    .profile-input-container:hover .upload-icon .fa-user,
    .profile-input-container:hover .upload-icon .fa-plus {
        color: var(--primary);
    }

    .profile-input-container:hover .upload-icon .fa-plus {
        background-color: var(--primary);
        color: var(--white-bg);
    }

    .upload-placeholder p {
        font-size: var(--small);
        color: var(--stroke-grey);
        margin-top: 0.5em;
    }

    .input-group {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1em;
    }

    .input-div {
        margin-bottom: 1.5em;
    }

    .input-div label {
        display: block;
        margin-bottom: 0.5em;
        color: var(--font-dark);
        font-size: var(--small);
    }

    .input-div input,
    .input-div textarea,
    .input-div select {
        width: 100%;
        padding: 0.8em 1em;
        border: 1px solid var(--input-bg-color);
        border-radius: 8px;
        background-color: var(--input-bg-color);
        font-size: var(--small);
        transition: all 0.3s ease;
    }

    .input-div input:focus,
    .input-div textarea:focus,
    .input-div select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px var(--tertiary);
    }

    textarea {
        min-height: 100px;
        resize: vertical;
    }

    .password-input-div {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .password-field-wrapper {
        position: relative;
        flex: 1;
    }

    .password-input-div input {
        width: 100%;
    }

    .password-input-div .show-pass-btn,
    .password-input-div .hide-pass-btn {
        position: absolute;
        right: 1em;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: var(--stroke-grey);
    }

    .confirm-password-div .password-input-div {
        position: relative;
    }

    .confirm-password-div .show-pass-btn,
    .confirm-password-div .hide-pass-btn {
        position: absolute;
        right: 1em;
        top: 50%;
        transform: translateY(-50%);
    }

    .form-btn-container {
        display: flex;
        justify-content: flex-end;
        gap: 1em;
    }

    .form-btn-container button {
        padding: 0.8em 2em;
        border-radius: 8px;
        font-size: var(--small);
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    #reset-staff-form-btn {
        background-color: var(--white-bg);
        border: 1px solid var(--stroke-grey);
        color: var(--font-dark);
    }

    #reset-staff-form-btn:hover {
        background-color: var(--input-bg-color);
    }

    #submit-staff-form-btn {
        background-color: var(--primary);
        border: none;
        color: var(--font-white);
    }

    #submit-staff-form-btn:hover {
        background-color: var(--primary-hover-color);
    }

    select {
        appearance: none;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 1em center;
        background-size: 1em;
    }

    .profile-input-container .error-message {
        position: absolute;
        bottom: -1.5em;
        left: 0;
        width: 100%;
    }

    #generate-password-btn {
        padding: 0.8em 1em;
        background-color: var(--primary);
        color: var(--font-white);
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: var(--small);
        white-space: nowrap;
        height: 100%;
    }

    #generate-password-btn:hover {
        background-color: var(--primary-hover-color);
    }

    .status-div select {
        color: var(--font-dark);
    }
</style>