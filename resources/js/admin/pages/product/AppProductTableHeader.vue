<template>
    <div class="products__head__wrapper">
        <div class="products__head">
            Products
        </div>
        <div class="products__head__options">
            <div class="products__head__option">
                <select name="product-cat" id="" class="products__head__select">
                    <option value="">Category</option>
                    <option value="1">User</option>
                </select>
            </div>
        </div>
        <div class="products__head__links">
            <a href="/admin/products/create" class="products__head__link">Add product</a>
        </div>
    </div>
</template>

<style>
    .products__head__wrapper {
        display: flex;
        align-items: center;
    }

    .products__head {
        font-weight: 600;
        font-size: 25px;
    }

    .products__head__option {
        margin-left: 50px;
        display: flex;
        flex-direction: column;
    }

    .products__head__label {
        font-size: 12px;
    }

    .products__head__select {
        background: #fff;
        border: 1px solid #4A74FF;
        font-size: 14px;
        border-radius: 3px;
        padding: 3px;
        outline: none;
    }

    .products__head__links {
        margin-left: auto;
    }

    .products__head__link {
        text-decoration: none;
        background: #4A74FF;
        color: #fff;
        border: 1px solid #4A74FF;
        border-radius: 5px;
        padding: 8px 6px;
        text-transform: capitalize;
    }
</style>
