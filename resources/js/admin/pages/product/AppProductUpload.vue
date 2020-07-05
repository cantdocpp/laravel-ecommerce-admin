<template>
    <div class="product">
        <div class="product-create">
            <div class="product-create__main">
                <product-handle 
                    @main-image="setMainImage"
                    @other-image="setOtherImage"
                ></product-handle>
            </div>
            <div class="product-create__side"></div>
        </div>
        <button class="product-create__publish">
            Publish
        </button>
    </div>
    
</template>

<script>
export default {
    data() {
        return {
            mainImage: '',
            otherImage: ''
        }
    },
    methods: {
        setMainImage(imageUrl) {
            this.mainImage = imageUrl;
            console.log(imageUrl)
        },
        setOtherImage(imagesList) {
            this.otherImage = imagesList;
        }
    }
}
</script>

<style>
    .product-create {
        display: flex;
        justify-content: space-between;
    }

    .product-create__main {
        width: 70%;
    }

    .product-create__side {
        width: 25%;
    }
</style>
