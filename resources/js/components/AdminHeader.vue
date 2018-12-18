<template>
    <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
        <div class="container">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li>
                        <router-link to="/admin/users" class="nav-link">Users</router-link>
                    </li>
                    <li>
                        <router-link to="/admin/photos" class="nav-link">Photos</router-link>
                    </li>
                </ul>
            </div>
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
