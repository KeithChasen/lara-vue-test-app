<template>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
        <div class="container">
            <router-link class="navbar-brand" to="/admin/users">
                Admin Panel
            </router-link>
                <ul class="navbar-nav ml-auto">
                    <li>
                        <router-link to="/admin/users" class="nav-link">Users</router-link>
                    </li>
                    <li>
                        <router-link to="/admin/photos" class="nav-link">Photos</router-link>
                    </li>
                </ul>
        </div>
    </nav>
</template>

<script>
    export default {
        name: "admin-header"
    }
</script>

<style scoped>

</style>
