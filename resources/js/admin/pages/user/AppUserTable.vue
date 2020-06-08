<template>
    <h1>user table</h1>
</template>

<script>
    import axios from 'axios';

    export default {
        data() {
            return {
                tes: 'hello'
            }
        },
        created() {
            const api = process.env.MIX_SERVER_PORT_ADMIN + 'users'
            axios.get(api)
                .then(response => {
                    console.log(response);
                })
                .catch(error => {
                    console.log(error);
                })
        }
    }
</script>

<style lang="sass" scoped>

</style>
