<template>
<div class="row justify-content-center">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">Login</div>
            <div class="card-body">
                <form @submit.prevent="authenticate">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" class="form-control" v-model="form.email">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" class="form-control" v-model="form.password">
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Login">
                    </div>
                    <div class="form-group" v-if="authError">
                        <p class="error">
                            {{ authError }}
                        </p>
                    </div>
            </form>
            </div>
        </div>
    </div>
</div>
</template>

<script>
    import {login} from "../../auth";

    export default {
        name: "login",
        data() {
            return {
                form: {
                    email: '',
                    password:''
                },
                error: null
            }
        },
        methods: {
            authenticate() {
                this.$store.dispatch('login');

                login(this.$data.form)
                    .then((res) => {
                        this.$store.commit('loginSuccess', res);
                        this.$router.push({path: '/'});
                })
                .catch((error) => {
                    this.$store.commit('loginFailed', {error});
                });
            }
        },
        computed: {
            authError() {
                return this.$store.getters.authError;
            }
        }
    }
</script>

<style scoped>
    .error {
        text-align: center;
        color: red;
    }
</style>
