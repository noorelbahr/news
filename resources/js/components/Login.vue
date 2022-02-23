<template>
    <div class="hold-transition login-page">
        <div class="login-box">

            <div class="card card-outline card-primary">
                <div class="card-header text-center">
                    <a class="h1"><b>News</b>APP</a>
                </div>
                <div class="card-body">
                    <p class="login-box-msg">Sign in to get your token</p>
                    <div v-if="error_msg" class="alert alert-danger">{{ error_msg }}</div>
                    <form @submit.prevent="login">
                        <div class="input-group mb-3">
                            <input type="email" class="form-control" placeholder="Email" v-model="form.email">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" placeholder="Password" v-model="form.password">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>

                        <div class="social-auth-links text-center mt-2 mb-3">
                            <button type="submit" class="btn btn-block btn-primary">
                                Login
                            </button>
                        </div>
                    </form>

                    <p class="mb-0">
                        <router-link :to="{ name: 'Register' }" class="text-center">Register a new membership</router-link>
                    </p>
                </div>

            </div>

        </div>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        data() {
            return {
                form: {
                    email: '',
                    password: ''
                },
                error_msg: ''
            }
        },
        mounted() {
            if (this.$store.state.token !== '') {
                axios.get('http://localhost:8000/api/v1/profile', {
                        headers: { Authorization: 'Bearer ' + this.$store.state.token }
                    })
                    .then((response) => {
                        this.$router.push({ name: 'News' });
                    }).catch((error) => {
                        this.$store.commit('clearToken');
                    });
            }
        },
        methods: {
            login(e) {
                axios.post('http://localhost:8000/api/v1/login', this.form)
                    .then((response) => {
                        this.$store.commit('setToken', response.data.data.access_token);
                        this.$router.push({ name: 'News' });
                    }).catch((error) => {
                        console.log(error.response);
                        this.error_msg = error.response.data.message;
                        this.form.password = '';
                    });
            }
        }
    }
</script>
