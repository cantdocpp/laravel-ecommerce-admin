<template>
    <div class="product">
        <div class="product-create">
            <div class="product-create__main">
                <product-handle 
                    @main-image="setMainImage"
                    @other-image="setOtherImage"
                ></product-handle>
                <div class="product-create__form">
                    <div class="product-create__title">
                        General info
                    </div>
                    <label class="product-create__label">
                        Product name <br />
                        <input 
                            type="text" 
                            class="product-create__input" 
                            placeholder="Ex: Sabatier Precision 14-Piece Stainless-Steel Knife Block Set"
                            v-model="name"
                        >
                    </label>
                    <label class="product-create__label">
                        Description <br />
                        <textarea 
                            type="text" 
                            class="product-create__textarea" 
                            placeholder="Write a good description"
                            v-model="description"
                        ></textarea>
                    </label>
                    <label class="product-create__label">
                        Category <br />
                        <select name="categories" class="product-create__select" v-model="category">
                            <option value="">Choose category</option>
                            <option>Create category</option>
                            <option value="cat">Cat</option>
                            <option value="hamster">Hamster</option>
                            <option value="parrot">Parrot</option>
                            <option value="spider">Spider</option>
                            <option value="goldfish">Goldfish</option>
                        </select>
                        <input 
                            type="text" 
                            class="product-create__input" 
                            placeholder="New category name"
                            v-model="category"
                            v-if="newCategory"
                        >
                    </label>
                </div>
                <div class="product-create__form">
                    <div class="product-create__title">
                        Pricing
                    </div>
                    <label class="product-create__label">
                        Price (Rp) <br />
                        <input 
                            type="number" 
                            class="product-create__input__number" 
                            placeholder="Input your product price"
                            v-model="price"
                        >
                    </label>
                </div>
                <div class="product-create__form">
                    <div class="product-create__title">
                        Product management
                    </div>
                    <label class="product-create__label">
                        Stock <br />
                        <input 
                            type="number" 
                            class="product-create__input__number" 
                            placeholder="100"
                            v-model="stock"
                        >
                    </label>
                    <label class="product-create__label">
                        SKU (Stock Keeping Unit) <br />
                        <input 
                            type="text" 
                            class="product-create__input" 
                            placeholder="Input your product SKU"
                            v-model="sku"
                        >
                    </label>
                </div>
                <div class="product-create__form">
                    <div class="product-create__title">
                        Product details
                    </div>
                    <label class="product-create__label">
                        Weight (kg) <br />
                        <input 
                            type="number" 
                            class="product-create__input__number" 
                            placeholder="0.1 / 1"
                            v-model="weight"
                        >
                    </label>
                    <label class="product-create__label">
                        Dimensions <br />
                        <input 
                            type="number" 
                            class="product-create__input__number" 
                            placeholder="Long (cm)"
                            v-model="long"
                        >
                        <input 
                            type="number" 
                            class="product-create__input__number" 
                            placeholder="Width (cm)"
                            v-model="width"
                        >
                        <input 
                            type="number" 
                            class="product-create__input__number" 
                            placeholder="Height (cm)"
                            v-model="height"
                        >
                    </label>
                </div>
            </div>
            <div class="product-create__side">
                <div class="product-create__form product-create__form--side">
                    <div class="product-create__title">
                        Visibility
                    </div>
                    <div class="product-create__desc">
                        Set up product visibility for the customers.
                    </div>
                    <div class="product-create__toggle__wrapper">
                        <div class="product-create__toggle__text">Visible</div>
                        <div class="product-create__toggle" :class="{ toggle__active: visibility }" @click="toggleVisibility">
                            <div class="product-create__toggle__ball" :class="{ toggle__ball__active: visibility }"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button class="product-create__publish" @click="saveProduct">
            Publish
        </button>
    </div>
    
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            mainImage: '',
            otherImage: '',
            visibility: 1,
            name: '',
            description: '',
            category: '',
            newCategory: false,
            price: '',
            stock: '',
            sku: '',
            weight: '',
            long: '',
            width: '',
            height: ''
        }
    },
    methods: {
        setMainImage(imageUrl) {
            this.mainImage = imageUrl;
        },
        setOtherImage(imagesList) {
            this.otherImage = imagesList;
        },
        toggleVisibility() {
            (this.visibility === 1) ? this.visibility = 0 : this.visibility = 1;
        },
        generateFormData() {
            const formData = new FormData();
            const otherImageFile = [];
            for (let i = 0; i < this.otherImage.length ; i++) {
                if (this.otherImage[i].file) {
                    formData.append('other[]', this.otherImage[i].file);
                    otherImageFile.push(this.otherImage[i].file);
                }
            }
            formData.append('image', this.mainImage.file);
            formData.append('name', this.name);
            formData.append('description', this.description);
            formData.append('visibility', this.visibility);
            formData.append('category', this.category);
            formData.append('price', this.price);
            formData.append('stock', this.stock);
            formData.append('sku', this.sku);
            formData.append('weight', this.weight);
            formData.append('long', this.long);
            formData.append('width', this.width);
            formData.append('height', this.height);

            return formData;
        },
        saveProduct() {
            const route = `${process.env.MIX_SERVER_PORT_ADMIN}product/`;
            const formData = this.generateFormData();
            console.log(formData.get('other[]'));
            console.log(formData.get('image'));
            axios.post(route, formData)
                .then(res => {
                    console.log(res);
                })
                .catch(err => {
                    console.log(err.data);
                })
        }
    },
    watch: {
        category(val) {
            if (val === 'Create category') {
                this.newCategory = true;
            } else {
                this.newCategory = false;
            }
        }
    }
}
</script>

<style scoped>
    .product-create {
        display: flex;
        justify-content: space-between;
    }

    .product-create__main {
        width: 70%;
    }

    .product-create__side {
        width: 28%;
    }

    .product-create__form {
        margin-top: 30px;
        background: #fff;
        padding: 20px;
        border-radius: 4px;
    }

    .product-create__form--side {
        margin-top: 0;
    }

    .product-create__desc {
        margin-top: 10px;
    }

    .product-create__toggle__wrapper {
        margin-top: 20px;
        background: #F3F6FF;
        padding: 12px;
        box-sizing: border-box;
        width: 100%;
        border-radius: 6px;
        display: flex;
        align-items: center;
    }

    .product-create__toggle {
        height: 25px;
        width: 50px;
        background: #fff;
        border-radius: 20px;
        cursor: pointer;
        position: relative;
        transition: background .15s ease-in-out;
    }

    .toggle__active {
        background: #6B8EFC;
    }

    .product-create__toggle__ball {
        position: absolute;
        left: 0;
        height: 25px;
        width: 25px;
        border-radius: 50%;
        background: #fff;
        -webkit-box-shadow: 0.5px 1px 5px 0px rgba(0,0,0,0.75);
        -moz-box-shadow: 0.5px 1px 5px 0px rgba(0,0,0,0.75);
        box-shadow: 0.5px 1px 5px 0px rgba(0,0,0,0.75);
        transition: all 1s ease-in-out;
    }

    .toggle__ball__active {
        left: auto;
        right: 0;
        -webkit-box-shadow: unset;
        -moz-box-shadow: unset;
        box-shadow: unset;
    }

    .product-create__toggle__text {
        color: #6B8EFC;
        font-size: 16px;
        flex-grow: 1;
    }

    .product-create__title {
        font-size: 17px;
        font-weight: 600;
    }

    .product-create__label {
        margin-top: 20px;
        text-transform: capitalize;
        display: block;
    }

    .product-create__input {
        border: 1px solid #6B8EFC;
        border-radius: 4px;
        padding: 6px 8px;
        width: 100%;
        box-sizing: border-box;
        margin-top: 10px;
        outline: none;
    }

    .product-create__textarea {
        padding: 6px 8px;
        border-radius: 4px;
        border: 1px solid #6B8EFC;
        width: 100%;
        min-height: 200px;
        margin-top: 10px;
        outline: none;
        box-sizing: border-box;
        min-width: 100%;
        max-width: 100%;
    }

    .product-create__select {
        display: inline-block;
        margin-top: 10px;
        border: 1px solid #6B8EFC;
        background: #fff;
        padding: 3px;
        border-radius: 1px;
        outline: none;
    }

    .product-create__input__number {
        display: inline-block;
        margin-top: 10px;
        border: 1px solid #6B8EFC;
        padding: 5px;
        border-radius: 4px;
        outline: none;
    }

    input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button { 
    -webkit-appearance: none; 
    margin: 0; 
    }

    .product-create__publish {
        display: inline-block;
        cursor: pointer;
        padding: 10px 15px;
        background: #6B8EFC;
        color: #fff;
        border-radius: 4px;
        border: none;
        margin-top: 20px;
        margin-bottom: 20px;
        font-size: 14px;
    }
</style>
