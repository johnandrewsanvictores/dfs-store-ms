<div class="csf-form-wrapper">
    <div class="csf-form-container">
        <div class="csf-header-form">
            <h6 id="csf-form-title">Add New Product Property</h6>
            <i class="fa-solid fa-xmark" id="x-csf-form-btn"></i>
        </div>
        <form action="#" method="Post" id="product-property-form">
            <input type="hidden" name="id" id="hidden-id">
            <input type="hidden" name="classification" id="hidden-csf">
            <div class="form-content">
                <div class="classification-form-container">
                    <label for="role">Classification<span>*</span></label>
                    <div class="container">
                        <div class="select">
                            <select name="classification" id="classification-select">
                                <option value="" disabled selected>Select an option</option>
                                <option value="category">Category</option>
                                <option value="brand">Brand</option>
                                <option value="texture">Texture</option>
                                <option value="material">Material</option>
                                <option value="color">Color</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="property-name category-container-form">
                    <label for="category">Category Name<span>*</span></label>
                    <input type="text" name="category" value="" id="category" placeholder="Input category name">
                    <label for="category-type">Category Type<span>*</span></label>
                    <div class="container">
                        <div class="select">
                            <select name="category-type" id="category-type">
                                <option value="" disabled selected>Select a type</option>
                                <option value="physical">Physical</option>
                                <option value="online">Online</option>
                            </select>
                        </div>
                    </div>
                    <label for="category-image">Category Image<span>*</span></label>
                    <input type="file" name="category-image" id="category-image" accept="image/*">
                    <img id="category-image-preview" src="#" alt="Category Image Preview" style="display:none;" />
                </div>

                <div class="property-name brand-container-form">
                    <label for="category-select">Category<span>*</span></label>
                    <div class="container">
                        <div class="select">
                            <select name="category_id" id="category-select">
                                <option value="" disabled selected>Select a category</option>
                            </select>
                        </div>
                    </div>
                    <label for="brand">Brand Name<span>*</span></label>
                    <input type="text" name="brand" value="" id="brand" placeholder="Input brand name">
                    <label for="brand-image">Brand Image<span>*</span></label>
                    <input type="file" name="brand-image" id="brand-image" accept="image/*">
                    <img id="brand-image-preview" src="#" alt="Brand Image Preview" style="display:none;" />
                </div>

                <div class="property-name texture-container-form">
                    <label for="texture">Texture<span>*</span></label>
                    <input type="text" name="texture" value="" id="texture" placeholder="Input texture name">
                </div>

                <div class="property-name material-container-form">
                    <label for="material">Material<span>*</span></label>
                    <input type="text" name="material" value="" id="material" placeholder="Input material name">
                </div>

                <div class="color-form-container">
                    <label for="color">Hex Value<span>*</span></label>
                    <input type="text" name="hexvalue" value="" id="hexvalue" placeholder="Input hexvalue or select color">
                </div>

                <div class="color-input">
                    <label for="color">Select Color</label>
                    <input type="color" name="color" id="color">
                </div>

            </div>
            <button type="submit" id="classification-add-btn">Add</button>
        </form>
    </div>
</div>

<style>
    .csf-form-wrapper {
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

    .csf-form-container {
        background-color: var(--white-bg);
        padding: 0.5em;
        width: fit-content;
        border-radius: 20px;
        border: 5px solid #fff;
        box-shadow: 0px 0px 3px #b6b6b6;

        transform: scale(0);
        opacity: 0;
        visibility: hidden;
        transition: 0.3s all ease-out;
    }

    .csf-header-form {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1em;
        gap: 2em;
        padding-inline: 1em;

    }

    .csf-header-form h6 {
        color: var(--font-dark);
    }

    .csf-header-form i {
        color: var(--font-dark);
        font-size: 20px;
        cursor: pointer;
    }

    #product-property-form {
        display: flex;
        flex-direction: column;
        gap: 1em;
        padding: 1em;
        width: fit-content;
        border-radius: calc(1em - 20px);
    }

    #product-property h6 {
        color: var(--font-dark);
    }

    .form-content {
        display: flex;
        gap: 2em;
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

    .form-content .classification-form-container {
        display: flex;
        flex-direction: column;
        gap: 0.4em;
    }

    .color-input {
        margin-left: -1em;
        display: flex;
        gap: 0.5em;
    }

    .form-content>div>label {
        font-size: var(--small);
    }

    .form-content>div>label span {
        color: var(--red);
    }

    #product-property-form input[type="text"] {
        width: 100%;
        border-radius: 5px;
        background-color: var(--input-bg-color);
        outline: none;
        border: none;
        padding: 1em 1.5em;
        font-size: var(--small);
        color: inherit;
        height: 100%;
    }

    #product-property-form input[type="color"] {
        width: 4em;
        height: 100%;
        border-radius: 20px;
        outline: none;
        border: none;
    }

    #product-property-form input[type="file"] {
        border: 1px solid var(--stroke-grey);
        border-radius: 5px;
        padding: 0.5em;
        cursor: pointer;
    }

    #classification-add-btn {
        padding: 0.5em 1em;
        font-family: inherit;
        color: var(--font-white);
        border-radius: 5px;
        font-size: var(--body);
        border: none;
        outline: none;
        cursor: pointer;
        background-color: var(--primary);
        width: 10em;
    }

    #classification-add-btn:hover {
        background-color: var(--primary-hover-color);
    }

    .property-name,
    .color-form-container,
    .color-input,
    .category-container-form,
    .brand-container-form {
        display: none;
        flex-direction: column;
        gap: 0.4em;
    }

    .category-container-form img,
    .brand-container-form img {
        max-width: 100px;
        max-height: 100px;
        margin-top: 10px;
    }
</style>