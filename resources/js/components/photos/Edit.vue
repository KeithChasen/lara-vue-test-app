<template>
    <div>
        <form @submit.prevent="update">
            <div class="form-group">
                <img :src='`/storage/${photo.path}`' alt="">
            </div>
            <ul class="list-group">
                <template v-if="!users.length">
                    <li class="text-center list-group-item">No Users</li>
                </template>
                <template v-else>
                    <li class="text-center list-group-item" v-for="user in users" :key="user.id">
                        <td>
                            <input type="checkbox" :value="`${user.id}`" v-model="checked">
                            {{ user.name }}
                        </td>
                    </li>
                </template>
            </ul>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
        <div class="errors" v-if="errors">
            <ul>
                <li v-for="(fieldsError, fieldName) in errors" :key="fieldName">
                    <strong>{{ fieldName }}</strong> {{ fieldsError.join('\n') }}
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
    export default {
        name: "photo-edit",
        created() {
            axios.get(`/api/photos/${this.$route.params.id}`)
                .then((response) => {
                    this.checked = response.data.userIds;
                    this.photo = response.data.photo;
                    this.users = response.data.users
                });
        },
        data() {
            return {
                checked: [],
                photo: {

                },
                users: {

                },
                errors: null
            }
        },
        computed: {
            photos() {
                return this.$store.getters.photos;
            }
        },
        methods: {
            update() {
                axios.put(`/api/photos/${this.$route.params.id}`, {ids: this.checked})
                    .then((response) => {
                        this.$router.push('/admin/photos');
                    });
            }
        }
    }
</script>

<style scoped>
img {
    width: 100px;
    height: 100px;
}
</style>
