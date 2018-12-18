<template>
    <div>
        <AdminHeader/>
        <router-view></router-view>
    </div>
</template>

<script>
    import AdminHeader from './AdminHeader'
    export default {
        name: "admin-main",
        components: {AdminHeader},
        computed: {
            currentUser() {
                return this.$store.getters.currentUser
            }
        }
    }
</script>

<style scoped>

</style>
