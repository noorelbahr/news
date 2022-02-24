<template>
    <div class="hold-transition register-page">
        <div class="register-box">
            <div class="register-logo">
                <a class="h1"><b>News</b>APP</a>
            </div>
            <div class="card">
                <div class="card-body register-card-body">
                    <p class="login-box-msg">Register a new membership</p>
                    <div v-if="error_msg" class="alert alert-danger">{{ error_msg }}</div>
                    <form @submit.prevent="register">
                        <div class="form-group">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Full name" v-model="form.name">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-user"></span>
                                    </div>
                                </div>
                            </div>
                            <span v-if="errors.name" class="text-danger">{{ errors.name[0] }}</span>
                        </div>
                        <div class="form-group">
                            <div class="input-group mb-3">
                                <input type="email" class="form-control" placeholder="Email" v-model="form.email">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-envelope"></span>
                                    </div>
                                </div>
                            </div>
                            <span v-if="errors.email" class="text-danger">{{ errors.email[0] }}</span>
                        </div>
                        <div class="form-group">
                            <div class="input-group mb-3">
                                <input type="password" class="form-control" placeholder="Password" v-model="form.password">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-lock"></span>
                                    </div>
                                </div>
                            </div>
                            <span v-if="errors.password" class="text-danger">{{ errors.password[0] }}</span>
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" placeholder="Retype password" v-model="form.password_confirmation">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">Register</button>
                    </form>
                    <router-link :to="{ name: 'Login' }" class="text-center">I already have an account</router-link>
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
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: ''
                },
                error_msg: '',
                errors: []
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
            register(e) {
                axios.post('http://localhost:8000/api/v1/register', this.form)
                    .then((response) => {
                        console.log(response.data);
                        console.log(response.data.data.access_token);
                        this.$store.commit('setToken', response.data.data.access_token);
                        this.$router.push({ name: 'News' });
                    }).catch((error) => {
                        console.log(error);
                        this.error_msg = error.response.data.message;
                        if (error.response.data.errors)
                            this.errors = error.response.data.errors;
                    });
            }
        }
    }
</script>
