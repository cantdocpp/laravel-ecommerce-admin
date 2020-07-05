<template>
    <div class="product-create__upload">
        <div class="product-create__upload__main">
            <div class="product-create__upload__area product-create__upload__area--main">
                <div class="product-create__upload__delete" v-if="mainImage.length > 0" @click="deleteMainImage">x</div>
                <img
                    v-if="mainImage.length > 0"
                    :src="mainImage"
                    class="product-create__upload__image product-create__upload__image--main"
                    ref="main"
                />
                <span class="product-create__upload__plus" v-if="mainImage.length === 0">+</span>
                <input
                    accept="image/x-png,image/png,image/jpg,image/jpeg" 
                    type="file" 
                    autocomplete="off" 
                    class="product-create__upload__input" 
                    @click="checkInputIndex($event, 0)"
                    @change="mainFileChange($event.target.files, 0)"
                    v-if="mainImage.length === 0"
                >
            </div>
        </div>
        <draggable v-model="uploadedImage" class="product-create__upload__other" @end="dragEnd">
            <div class="product-create__upload__area" v-for="(image, n) in uploadedImage" :key="image.index">
                <div class="product-create__upload__delete" v-if="image.url.length > 0" @click="deleteOtherImage(n)">x</div>
                <img
                    class="product-create__upload__image"
                    ref="img"
                    v-if="image.url.length > 0"
                    :src="image.url"
                />
                <span class="product-create__upload__plus" v-if="image.url.length === 0">+</span>
                <input
                    accept="image/x-png,image/png,image/jpg,image/jpeg" 
                    type="file" 
                    multiple 
                    autocomplete="off" 
                    class="product-create__upload__input" 
                    @click="checkInputIndex($event, n)"
                    @change="fileChange($event.target.files, n)"
                    v-if="image.url.length === 0"
                >
            </div>
        </draggable>
    </div>
</template>

<script>
import draggable from 'vuedraggable'

export default {
    data() {
        return {
            uploadedImage: [
                {
                    url: '',
                    index: 1
                },
                {
                    url: '',
                    index: 2
                },
                {
                    url: '',
                    index: 3
                },
                {
                    url: '',
                    index: 4
                },
                {
                    url: '',
                    index: 5
                },
                {
                    url: '',
                    index: 6
                },
                {
                    url: '',
                    index: 7
                },
                {
                    url: '',
                    index: 8
                }
            ],
            mainImage: '',
        }
    },
    methods: {
        countImage() {
            let imgLength = 0;
            this.uploadedImage.forEach(img => {
                if (img.url.length > 0) {
                    imgLength++;
                }
            });
            return imgLength;
        },
        dragEnd() {
            this.$emit('other-image', this.uploadedImage);
        },
        checkInputIndex(event, index) {
            const imgLength = this.countImage();
            if (index !== imgLength && index !== 0) event.preventDefault();
        },
        fileChange(files, index) {
            const uploadedImageTotal = files.length;
            for (let i = 0; i < uploadedImageTotal; i++) {
                this.getImageUrl(files[i], i + index);
            }
            this.$emit('other-image', this.uploadedImage);
        },
        mainFileChange(files, index) {
            this.getMainImageUrl(files[0], index);
        },
        getImageUrl(file, index) {
            const reader = new FileReader();
            reader.onload = e => {
                const url = e.target.result;
                this.uploadedImage[index].url = url;
                return url;
            };
            reader.readAsDataURL(file);
        },
        getMainImageUrl(file, index) {
            const reader = new FileReader();
            reader.onload = e => {
                const url = e.target.result;
                this.mainImage = url;
                this.$emit('main-image', this.mainImage);
            };
            reader.readAsDataURL(file);
        },
        deleteMainImage() {
            this.mainImage = '';
            this.$emit('main-image', this.mainImage);
        },
        deleteOtherImage(index) {
            this.uploadedImage[index].url = '';
            const imageLength = this.countImage();
            for (let i = index; i < imageLength; i++) {
                const nextImage = this.uploadedImage[i + 1].url;
                if (nextImage.length > 0) {
                    this.uploadedImage[i].url = nextImage;
                    this.uploadedImage[i + 1].url = '';
                }
            }
            this.$emit('other-image', this.uploadedImage);
        }
    },
    components: {
        draggable
    }
}
</script>

<style scoped>
    .product-create__upload__area {
        background: #F3F6FF;
    }

    .product-create__upload {
        display: flex;
        background: #fff;
        padding: 20px;
        box-sizing: border-box;
        border-radius: 5px;
    }

    .product-create__upload__area {
        width: 120px;
        height: 120px;
        border: 2px dashed #6B8EFC;
        border-radius: 4px;
        position: relative;
    }

    .product-create__upload__area--main {
        width: 220px;
        height: 250px;
    }

    .product-create__upload__other {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        grid-gap: 5px 10px;
        margin-left: 10px;
    }

    .product-create__upload__input {
        opacity: 0;
        position: absolute;
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
        width: 100%;
        cursor: pointer;
    }

    .product-create__upload__plus {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 30px;
        color: #6B8EFC;
    }

    .product-create__upload__image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        cursor: grab;
        position: absolute;
    }

    .product-create__upload__image--main {
        cursor: pointer;
    }

    .product-create__upload__delete {
        position: absolute;
        right: -10px;
        top: -10px;
        background: #fff;
        padding: 5px 10px;
        border-radius: 50%;
        z-index: 10;
        background: #6B8EFC;
        color: #fff;
        cursor: pointer;
    }
</style>
