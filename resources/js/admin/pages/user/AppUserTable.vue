<template>
    <div class="user-page-content">
         <admin-modal v-show="dialogId" @close="closeModal" @submit="deleteUser()" :is-submit="isSubmit">
            Are you sure you want to delete this user ?
        </admin-modal>
        <admin-modal v-show="bulkDelete" @close="closeModal" @submit="bulkDeleteUser()" :is-submit="isSubmit">
            Are you sure you want to delete all choosed users ?
        </admin-modal>
        <div class="user-sort">
            <div class="user-sort__option">
                <select name="role" class="user-sort__role" @change="onChange($event)">
                    <option value="">Role</option>
                    <option value="1" :selected="pathRole === '1'">User</option>
                    <option value="2" :selected="pathRole === '2'">Reseller</option>
                    <option value="3" :selected="pathRole === '3'">Admin</option>
                    <option value="4" :selected="pathRole === '4'">Owner</option>
                </select>
            </div>

            <div class="user-sort__page">
                <div class="user-sort__view">
                    Viewing <span class="user-sort--bold"> {{ this.users.from }} </span> - <span class="user-sort--bold"> {{ this.users.to }} </span> of <span class="user-sort--bold"> {{ this.users.total }} </span>
                </div>
            </div>
        </div>

        <div class="user-table-wrapper">
            <table class="user-table" cellspacing="0" cellpadding="0">
                <thead> 
                    <tr v-if="checkedItemLength > 0">
                        <th colspan="2">
                            <div class="user-table__action">
                                <div class="user-action__choosed">
                                    {{ checkedItemLength }}/15 User Choosed
                                </div>
                                <button class="user-action__delete" @click="openBulkDeleteDialog">
                                    Delete
                                </button>
                            </div>
                        </th>
                    </tr>
                    <tr>
                        <th>
                            <input 
                                type="checkbox" 
                                class="user-table-check" 
                                v-model="checkAll" 
                                @change="bulkCheck"
                            >
                        </th>
                        <th>Name</th>
                        <th>Role</th>
                        <th>Date Created</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr 
                        v-for="(data, i) in userData" 
                        :key="i" 
                        :class="{row__checked: data.check}"
                        class="user-table__row"
                    >
                        <td>
                            <input 
                                type="checkbox" 
                                class="user-table-check" 
                                @change="rowCheck(i)"
                                :checked="data.check">
                        </td>
                        <td>
                            <div class="user-table__name__email">
                                <div class="user-table__name"> {{ data.name }} </div>
                                <div class="user-table__email"> {{ data.email }} </div>
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
                        <td>
                            {{ getUserCreatedDate(data.created_at) }}
                        </td>
                        <td>
                            <div class="user-table__more">
                                <div class="user-table__options" @click="toggleOptions(data.id)">
                                    <div class="user-table__option"></div>
                                    <div class="user-table__option"></div>
                                    <div class="user-table__option"></div>
                                </div>
                                <div class="user-table__choose" v-show="activeOption === data.id">
                                    <div class="user-table__choose__item" @click="openDialog(data.id)">Delete</div>
                                    <a :href="`users/${data.id}`" class="user-table__choose__item">Edit</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="user-table__paging">
                <a :href="page.first_page_url" class="user-table-page__paging__first">
                    <div class="user-table__paging__arrow user-table__paging__arrow--before"></div>
                    <div class="user-table__paging__arrow user-table__paging__arrow--before user-table__paging__arrow--last"></div>
                </a>
                <div class="user-table__paging__before">
                    <a :href="page.prev_page_url" class="user-table__paging__arrow user-table__paging__arrow--before"></a>
                </div>
                <div class="user-table__paging__number">
                    <a :href="page.prev_page_url" class="user-table__paging__page" v-if="page.prev_page_url">
                        {{ page.current_page - 1 }}
                    </a>
                    <a href="" class="user-table__paging__page user__paging_active">
                        {{ page.current_page }}
                    </a>
                    <a :href="page.next_page_url" class="user-table__paging__page" v-if="page.next_page_url">
                        {{ page.current_page + 1 }}
                    </a>
                    <span class="user-table__paging__page" v-if="page.current_page < page.last_page && page.current_page + 1 < page.last_page">
                        ...
                    </span>
                    <a :href="page.last_page_url" class="user-table__paging__page" v-if="page.current_page < page.last_page && page.current_page + 1 < page.last_page">
                        {{ page.last_page }}
                    </a>
                    <!-- <a 
                        :href="getPageUrl(page.current_page + item - 1)" 
                        class="user-table__paging__page"
                        :class="{ 'user__paging_active': pageActive(page.current_page + item - 1) }"
                        v-for="item in page.current_page + 3" 
                        :key="item"
                    >
                        <span v-if="page.current_page + item <= page.last_page + 1">
                            {{ page.current_page + item - 1 }} 
                        </span>
                    </a>
                    <span class="user-table__paging__page" v-if="page.current_page + 4 < page.last_page">
                        ...
                    </span> -->

                    <!-- <a href="#" class="user-table__paging__page" v-if="page.current_page + 4 < page.last_page" style="font-size: 14px">
                        {{ page.last_page }}
                    </a> -->
                </div>
                <a :href="page.next_page_url" class="user-table__paging__next"  v-if="page.current_page !== page.last_page">
                    <div class="user-table__paging__arrow user-table__paging__arrow--next"></div>
                </a>
                <a :href="page.last_page_url" class="user-table__paging__last" v-if="page.current_page !== page.last_page">
                    <div class="user-table__paging__arrow user-table__paging__arrow--next user-table__paging__arrow--end"></div>
                    <div class="user-table__paging__arrow user-table__paging__arrow--next"></div>
                </a>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    import ClickOutside from 'vue-click-outside'

    export default {
        props: ['users'],
        data() {
            return {
                userData: null,
                role: null,
                dialogId: null,
                activeOption: null,
                isSubmit: false,
                pathRole: null,
                bulkDelete: false,
                checkAll: false,
                checkedItem: [],
                page: {
                    current_page: null,
                    last_page: null,
                    first_page_url: null,
                    prev_page_url: null,
                    next_page_url: null,
                    last_page_url: null
                }
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
            openBulkDeleteDialog() {
                this.bulkDelete = this.checkedItem;
            },
            toggleOptions(id) {
                this.activeOption ? this.activeOption = null : this.activeOption = id;
            },
            closeModal() {
                this.dialogId = null;
                this.bulkDelete = false;
            },
            bulkDeleteUser() {
                this.bulkDelete = true;
                this.isSubmit = true;
                const route = `${process.env.MIX_SERVER_PORT_ADMIN}users/`;
                axios.delete(route, {data: { user: this.checkedItem }})
                    .then(response => {
                        this.checkedItem.forEach(item => {
                            const itemIndex = this.userData.findIndex(data => data.id === item);
                            this.userData.splice(itemIndex, 1);
                        })

                        this.userData.forEach(data => {
                            this.$set(data, 'check', false);
                        })

                        this.checkedItem = [];
                    })
                    .catch(error => {
                        console.log(error);
                    })
                    .finally(() => {
                        this.bulkDelete = false;
                        this.isSubmit = false;
                    })
            },
            deleteUser() {
                const id = this.dialogId;
                const route = `${process.env.MIX_SERVER_PORT_ADMIN}users/${id}`;
                this.isSubmit = true;
                axios.delete(route)
                    .then(response => {
                        if (response.data === 'success') {
                            this.dialogId = null;
                            const deleteItemIndex = this.userData.findIndex(el => el.id === id);
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

                if (!getQueryUrl) return;

                // Split all query string that we got into array
                const splitQuery = getQueryUrl.split('&');

                // Find array item that have 'role' string in it
                const getRoleQueryString = splitQuery.find(item => item.includes('role'));

                // Split the role query string that we got so we can get role at index 1
                const splitRoleQuery = getRoleQueryString.split('=');

                // Assign what we got the the component state
                this.pathRole = splitRoleQuery[1];
            },
            pageActive(current) {
                return current === this.page.current_page;
            },
            getUserCreatedDate(date) {
                const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                const newDate = new Date(date);
                const day = newDate.getDay();
                const month = months[newDate.getMonth()];
                const year = newDate.getFullYear();
                return `${day} ${month} ${year}`;
            },
            getPageData() {
                this.page.current_page = this.users.current_page;
                this.page.last_page = this.users.last_page;
                this.page.first_page_url = this.users.first_page_url;
                this.page.prev_page_url = this.users.prev_page_url;
                this.page.next_page_url = this.users.next_page_url;
                this.page.last_page_url = this.users.last_page_url;
            },
            rowCheck(index) {
                const checkedItem = this.userData[index].check
                const userId = this.userData[index].id;

                // https://vuejs.org/v2/guide/reactivity.html#Change-Detection-Caveats
                if (checkedItem) {
                    this.$set(this.userData[index], 'check', false);
                    const checkedIdIndex = this.checkedItem.findIndex(item => item === userId);
                    this.checkedItem.splice(checkedIdIndex, 1);
                } else {
                    this.$set(this.userData[index], 'check', true);
                    this.checkedItem.push(userId);
                }
            },
            bulkCheck() {
                if (!this.checkAll) {
                    this.userData.forEach((data, i) => {
                        this.$set(data, 'check', false);
                    });
                    this.checkedItem = [];
                } else {
                    this.userData.forEach((data, i) => {
                        if (!data.check) {
                            this.checkedItem.push(data.id);
                        }
                        this.$set(data, 'check', true);
                    });
                }
            }
        },
        computed: {
            checkedItemLength() {
                return this.checkedItem.length;
            }
        },
        mounted() {
            this.userData = this.users.data;
            this.getPathRoles();
            this.getPageData();
            console.log(this.users, '>>>>>>>>>>>>>')
            console.log(window.location)
        },
        directives: {
            ClickOutside
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

    .user-table__row {
        margin-top: 10px;
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
        background: #fff;
        padding: 20px;
        border-radius: 4px;
        box-sizing: border-box;
    }

    .user-table {
        width: 100%;
        empty-cells: show;
        box-sizing: border-box;
        border-collapse:separate;
        border-spacing:0 10px;
    }

    .user-table__action {
        display: flex;
        align-items: center;
    }

    .user-action__choosed {
        font-weight: 400;
    }

    .user-action__delete {
        background: #ff4a4a;
        padding: 7px 12px;
        color: #fff;
        border: 0;
        border-radius: 6px;
        margin-left: 20px;
        cursor: pointer;
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

    .row__checked {
        background: #bfccf2;
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
        color: #000;
        text-decoration: none;
    }

    .user-table__choose__item + .user-table__choose__item {
        margin-top: 10px;
    }

    .user-table__paging {
        display: flex;
        align-items: center;
        margin-top: 30px;
        margin-left: 20px;
    }

    .user-table-page__paging__first {
        display: flex;
    }

    .user-table__paging__arrow {
        width: 10px;
        height: 10px;
        border-left: 2px solid #ddd;
        border-bottom: 2px solid #ddd;
    }

    .user-table__paging__before {
        display: flex;
        margin-left: 10px;
    }

    .user-table__paging__next {
        display: flex;
        align-items: center;
        margin-left: 20px;
    }

    .user-table__paging__arrow--next {
        border-left: 2px solid #4A74FF;
        border-bottom: 2px solid #4A74FF;
        display: inline-flex;
        transform: rotate(-135deg);
    }

    .user-table__paging__arrow--before {
        transform: rotate(45deg);
    }

    .user-table__paging__arrow--last {
        margin-left: -5px;
    }

    .user-table__paging__last {
        display: flex;
        align-items: center;
    }

    .user-table__paging__arrow--end {
        margin-right: -5px;
        margin-left: 10px;
    }

    .user-table__paging__number {
        display: inline-flex;
        align-items: center;
        margin-left: 20px;
    }

    .user-table__paging__page {
        color: #4A74FF;
        text-decoration: none;
        font-size: 16px;
        display: inline-flex;
    }

    .user-table__paging__page + .user-table__paging__page {
        margin-left: 15px;
    }

    .user__paging_active {
        padding: 2px 7px;
        border: 1px solid #4A74FF;
        border-radius: 4px;
    }
</style>
