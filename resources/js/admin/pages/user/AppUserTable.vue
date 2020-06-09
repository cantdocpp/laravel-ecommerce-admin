<template>
    <div class="user-page-content">
         <admin-modal v-show="dialogId" @close="closeModal" @submit="deleteUser()" :is-submit="isSubmit">
            Are you sure you want to delete this user ?
        </admin-modal>
        <div class="user-sort">
            <div class="user-sort__option">
                <select name="role" class="user-sort__role" @change="onChange($event)">
                    <option value="">Role</option>
                    <option value="user" :selected="pathRole === 'user'">User</option>
                    <option value="reseller" :selected="pathRole === 'reseller'">Reseller</option>
                    <option value="admin" :selected="pathRole === 'admin'">Admin</option>
                    <option value="owner" :selected="pathRole === 'owner'">Owner</option>
                </select>
            </div>

            <div class="user-sort__page">
                <div class="user-sort__view">
                    Viewing <span class="user-sort--bold"> {{ this.users.from }} </span> - <span class="user-sort--bold"> {{ this.users.to }} </span> of <span class="user-sort--bold"> {{ this.users.total }} </span>
                </div>
            </div>
        </div>

        <div class="user-table-wrapper">
            <table class="user-table">
                <thead> 
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Role</th>
                        <th>Date Created</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="data in userData" :key="data.id">
                        <td>
                            <input type="checkbox" name="usercheck" class="user-table-check">
                        </td>
                        <td>
                            <div class="user-table__name__email">
                                <div class="user-table__name"> {{ data.name }} </div>
                                <div class="user-table__email"> {{ data.email }} </div>
                                {{data.id}}
                            </div>
                        </td>
                        <td>
                            <div class="user-table__role">
                                <div class="user-table__role__item" v-if="data.role === 1">
                                    User
                                </div>
                                <div class="user-table__role__item" v-else-if="data.role === 2">
                                    Reseller
                                </div>
                                <div class="user-table__role__item" v-else-if="data.role === 3">
                                    Admin
                                </div>
                                <div class="user-table__role__item" v-else-if="data.role === 4">
                                    Owner
                                </div>
                            </div>
                        </td>
                        <td>Blue</td>
                        <td>
                            <div class="user-table__more">
                                <div class="user-table__options" @click="toggleOptions(data.id)">
                                    <div class="user-table__option"></div>
                                    <div class="user-table__option"></div>
                                    <div class="user-table__option"></div>
                                </div>
                                <div class="user-table__choose" v-show="activeOption === data.id">
                                    <div class="user-table__choose__item" @click="openDialog(data.id)">Delete</div>
                                    <div class="user-table__choose__item">Edit</div>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        props: ['users'],
        data() {
            return {
                userData: null,
                role: null,
                dialogId: null,
                activeOption: null,
                isSubmit: false,
                pathRole: null
            }
        },
        methods: {
            onChange(event) {
                this.role = event.target.value;
                window.location.href = `/admin/users/?role=${this.role}`;
            },
            openDialog(id) {
                this.dialogId = id;
            },
            toggleOptions(id) {
                this.activeOption = id;
            },
            closeModal() {
                this.dialogId = null;
            },
            deleteUser() {
                const id = this.dialogId;
                const route = `${process.env.MIX_SERVER_PORT_ADMIN}users/${id}`;
                this.isSubmit = true;
                axios.delete(route)
                    .then(response => {
                        if (response.data === 'success') {
                            this.dialogId = null;
                            const deleteItemIndex = this.userData.find(el => el.id === id);
                            this.userData.splice(deleteItemIndex, 1);
                            this.activeOption = null;
                        }
                    })
                    .catch(error => {
                        console.log(error);
                    })
                    .finally(() => {
                        this.isSubmit = false;
                    })
            },
            getPathRoles() {
                // Get full url path from our site
                const fullPath = window.location.href;

                // Split the path with ? to get query url on index 1
                const splitPathWithQuery = fullPath.split('?');


                // Get the query url in string
                const getQueryUrl = splitPathWithQuery.find(str => str.includes('role'));

                // Split all query string that we got into array
                const splitQuery = getQueryUrl.split('&');

                // Find array item that have 'role' string in it
                const getRoleQueryString = splitQuery.find(item => item.includes('role'));

                // Split the role query string that we got so we can get role at index 1
                const splitRoleQuery = getRoleQueryString.split('=');

                // Assign what we got the the component state
                this.pathRole = splitRoleQuery[1];
            }
        },
        mounted() {
            this.userData = this.users.data;
            this.getPathRoles();
            console.log(this.userData, '>>>>>>>>>>>>>')
        }
    }
</script>

<style lang="scss" scoped>
    .user-sort {
        display: block;
        margin-top: 30px;
        display: flex;
        align-items: center;
    }

    .user-sort__option {
        flex-grow: 1;
    }

    .user-sort__role {
        padding: 5px 10px;
        background: #fff;
        border: 1px solid #4A74FF;
        border-radius: 2px;
    }

    .user-sort__view {
        font-weight: 300;
    }

    .user-sort--bold {
        font-weight: 600;
    }

    .user-sort__page {
        display: flex;
        align-items: center;
    }

    .user-sort__link {
        display: flex;
    }

    .user-table-wrapper {
        margin-top: 20px;
    }

    .user-table {
        width: 100%;
        empty-cells: show;
        background: #fff;
        padding: 20px;
        box-sizing: border-box;
        border-radius: 4px;
    }

    .user-table-body {
        display: block;
        margin-top: 10px;
    }

    .user-table-check {
        vertical-align: middle;
    }

    th, td {
        padding: 10px;
        text-align: left;
    }

    .user-table__name__email {
        display: flex;
        flex-direction: column;
    }

    .user-table__name {
        font-weight: 600;
    }

    .user-table__email {
        font-weight: 300;
        margin-top: 6px;
    }

    .user-table__more {
        position: relative;
    }

    .user-table__options {
        display: flex;
        flex-direction: column;
        cursor: pointer;
    }

    .user-table__option {
        width: 4px;
        height: 4px;
        background: #000;
        border-radius: 50%;
        display: inline-block;
    }

    .user-table__option + .user-table__option {
        margin-top: 2px;
    }

    .user-table__choose {
        top: 0px;
        display: flex;
        flex-direction: column;
        position: absolute;
        right: 130%;
        box-shadow: 2px 2px 5px #919191;
        padding: 20px 30px;
        box-sizing: border-box;
        border: 0;
        border-radius: 4px;
    }

    .user-table__choose__item {
        cursor: pointer;
    }

    .user-table__choose__item + .user-table__choose__item {
        margin-top: 10px;
    }
</style>
