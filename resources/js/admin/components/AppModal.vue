<template>
    <div class="modal modal-overlay">
        <div class="modal__card">
            <div class="modal__close" @click="closeModal">
                x
            </div>
            <div class="modal__text">
                <slot></slot>
            </div>
            <div class="modal__options">
                <div class="modal__option modal__option--close" @click="closeModal">No</div>
                <button class="modal__option modal__option--submit" :class="{ modal__option_submit: isSubmit }" @click="submit">Yes</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['isSubmit'],
    methods: {
        closeModal() {
            this.$emit('close');
        },
        submit() {
            this.$emit('submit');
        }
    }
}
</script>

<style lang="scss">
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 13;
        overflow: scroll;
        background-color: rgba(0,0,0,.8);
    }

    .modal__card {
        width: 540px;
        background: #fff;
        border-radius: 4px;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        padding: 20px;
        box-sizing: border-box;
    }

    .modal__text {
        font-size: 16px;
        margin-top: 20px;
    }

    .modal__options {
        margin-top: 30px;
        display: flex;
        justify-content: flex-end;
        align-items: center;
    }

    .modal__close {
        display: flex;
        justify-content: flex-end;
        font-size: 20px;
        opacity: .7;
        cursor: pointer;
        transition: opacity .15s ease-in-out;
    }

    .modal__close:hover {
        opacity: 1;
    }

    .modal__option {
        font-size: 16px;
        cursor: pointer;
    }

    .modal__option--submit {
        background: #4A74FF;
        color: #fff;
        padding: 10px 20px;
        border-radius: 5px;
        border: 0;
    }

    .modal__option--close {
        margin-right: 30px;
    }

    .modal__option_submit {
        cursor: progress;
    }
</style>
