<template>
    <div>
        <div class="btn-wrapper">
            <router-link :to="`/admin/photos/new`" class="btn btn-primary btn-sm">New</router-link>
        </div>
        <table class="table">
            <thead>
            <th>Photo</th>
            <th>Size</th>
            <th>Extension</th>
            </thead>
            <tbody>
            <template v-if="!photos.length">
                <td colspan="3" class="text-center">No photos</td>
            </template>
            <template v-else>
                <tr v-for="photo in photos" :key="photo.id">
                    <td>
                        <img :src='`/storage/${photo.path}`' alt="">
                    </td>
                    <td>{{ photo.size }}</td>
                    <td>{{ photo.extension }}</td>
                    <router-link :to="`/admin/photos/edit/${photo.id}`" class="crud-button btn btn-info btn-sm">E</router-link>
                    <button class="crud-button btn btn-danger btn-sm" v-on:click="removePhoto(photo)">D</button>
                </tr>
            </template>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        name: "photos-list",
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
        methods: {
            removePhoto(photo) {
                this.$store.dispatch('removePhoto', photo);
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
        margin-top: 10px;
        margin-right: 5px;
    }
    img {
        width: 50px;
        height: 50px;
    }
</style>
