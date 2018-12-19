<template>
    <div class="container">
        <template v-if="!photos.length">
            <div class="text-center">No photos</div>
        </template>
        <template v-else>
            <div class="grid-container">
                <div class="grid-item" v-for="photo in photos" :key="photo.id">
                    <img :src='`/storage/${photo.path}`' alt="">
                </div>
            </div>
        </template>
    </div>
</template>

<script>
    export default {
        name: "home",
        mounted() {
            this.$store.dispatch('getPhotos');
        },
        computed: {
            photos() {
                return this.$store.getters.photos;
            },
            isAdmin() {
                return this.$store.getters.isAdmin
            }
        },
    }
</script>

<style scoped>
    .grid-container {
        display: grid;
        grid-column-gap: 50px;
        grid-template-columns: auto auto auto;
        padding: 10px;
    }

    .grid-item {
        padding: 20px;
        font-size: 30px;
        text-align: center;
    }

    img {
        max-width: 200px;
        max-height: 200px;
    }
</style>
