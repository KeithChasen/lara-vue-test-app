<template>
    <div>
        <div class="btn-wrapper">
            <router-link :to="`/users/new`" class="btn btn-primary btn-sm">New</router-link>
        </div>
        <table class="table">
            <thead>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
            </thead>
            <tbody>
                <template v-if="!users.length">
                    <td colspan="3" class="text-center">No Users</td>
                </template>
                <template v-else>
                    <tr v-for="user in users" :key="user.id">
                        <td>{{ user.name }}</td>
                        <td>{{ user.email }}</td>
                        <td>{{ user.role.role }}</td>
                        <router-link :to="`/users/edit/${user.id}`" class="crud-button btn btn-info btn-sm">E</router-link>
                        <button class="crud-button btn btn-danger btn-sm" v-on:click="removeUser(user)">D</button>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        name: "users-list",
        mounted() {
            this.$store.dispatch('getUsers');
        },
        computed: {
            users() {
                return this.$store.getters.users;
            },
            isAdmin() {
                return this.$store.getters.isAdmin
            }
        },
        methods: {
            removeUser(user) {
                this.$store.dispatch('removeUser', user);
            }
        }
    }
</script>

<style scoped>
    .btn-wrapper {
        text-align: right;
        margin-bottom: 20px;
    }
    .crud-button {
        margin-top: 5px;
        margin-right: 5px;
    }
</style>
