<template>

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
        }
    }
</script>

<style scoped>

</style>
