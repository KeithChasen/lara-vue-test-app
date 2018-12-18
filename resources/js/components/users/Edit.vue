<template>
    <div>
        <form @submit.prevent="update">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" class="form-control" v-model="user.name" value="">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" class="form-control" v-model="user.email" value="">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" class="form-control" v-model="user.password" value="">
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
        <div class="errors" v-if="errors">
            <ul>
                <li v-for="(fieldsError, fieldName) in errors" :key="fieldName">
                    <strong>{{ fieldName }}</strong> {{ fieldsError.join('\n')}}
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
    import validate from 'validate.js';

    export default {
        name: "user-edit",
        created() {
            if (this.users.length) {
                this.user = this.users.find((user) => user.id == this.$route.params.id);
            } else {
                axios.get(`/api/users/${this.$route.params.id}`)
                    .then((response) => {
                        this.user = response.data.user
                    });
            }
        },
        data() {
          return {
              user: {
                  name: '',
                  email: '',
                  password: null
              },
              errors: null
          }
        },
        computed: {
            users() {
                return this.$store.getters.users;
            }
        },
        methods: {
            update() {
                this.errors = null;

                const constraints = this.getConstraints();

                const errors = validate(this.user, constraints);

                if (errors) {
                    this.errors = errors;
                    return;
                }

                axios.put(`/api/users/${this.$route.params.id}`, this.user)
                    .then((response) => {
                        this.$router.push('/users');
                    });
            },
            getConstraints() {
                return {
                    name: {
                        presence: true,
                        length: {
                            minimum: 3,
                            message: 'Must be at least 3 characters long'
                        }
                    },
                    email: {
                        presence: true,
                        email: true
                    },
                    password: {
                        presence: false,
                        length: {
                            minimum: 3,
                            message: 'Must be at least 3 characters long'
                        }
                    },
                }
            }
        }
    }
</script>

<style scoped>
    .errors {
        background: lightcoral;
        border-radius: 5px;
        padding: 21px 0 2px 0;
        margin: 21px 0 2px 0;
    }
</style>
