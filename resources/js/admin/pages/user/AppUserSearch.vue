<template>
    <div class="user__search">
        <input 
            type="text" 
            class="user__search__input" 
            placeholder="Search user by name"
            v-model="search"
            @input="startSearch"
        >
        <div class="user-search__result" v-if="isUserTyping">
            <div class="user-search__loading" v-if="loading"></div>
            <div class="user-search__items">
                <a :href="`users/${result.id}`" class="user-search__item" v-for="result in results" :key="result.id">
                    {{ result.name }}
                </a>
            </div>
        </div>
    </div>
</template>

<script>
import _ from 'lodash';

export default {
    data() {
        return {
            search: '',
            results: '',
            loading: false,
        }
    },
    computed: {
        isUserTyping() {
            return this.search;
        }
    },
    methods: {
        startSearch() {
            this.loading = false;
            const start = _.debounce(() => {
                this.searchUser()
            }, 2000)
            start();
        },
        searchUser() {
            this.loading = true;
            const route = `${process.env.MIX_SERVER_PORT_ADMIN}users/search?search=${this.search}`;
            axios.get(route)
                .then(response => {
                    this.results = response.data;
                    this.loading = false;
                })
                .catch(error => {
                    console.log(error)
                })
        }
    }
}
</script>

<style lang="scss">
    .user__search {
        position: relative;
    }

    .user-search__loading {
        display: inline-block;
        border: 3px solid rgba(0, 0, 0, 0.1);
        border-left-color: #4A74FF;
        border-radius: 50%;
        width: 16px;
        height: 16px;
        animation: donut-spin 1.2s linear infinite;
        position: absolute;
        left: 50%;
        top: 50%;
    }

    .user-search__result {
        width: 400px;
        padding: 20px;
        box-sizing: border-box;
        border-radius: 4px;
        background: #fff;
        position: absolute;
        top: 99%;
        height: 220px;
        min-height: 100px;
        overflow: scroll;
        -webkit-box-shadow: 4px 2px 5px 0px rgba(199,199,199,1);
        -moz-box-shadow: 4px 2px 5px 0px rgba(199,199,199,1);
        box-shadow: 4px 2px 5px 0px rgba(199,199,199,1);
    }

    .user-search__item {
        padding: 10px;
        font-size: 17px;
        text-decoration: none;
        display: block;
        color: #000;
        transition: background .25s ease-in-out, color .25s ease-in-out;
        border-radius: 5px;
    }

    .user-search__item:hover {
        background: #4A74FF;
        color: #fff;
    }

    .user-search__item + .user-search__item {
        margin-top: 5px;
    }

    @keyframes donut-spin {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }
</style>
