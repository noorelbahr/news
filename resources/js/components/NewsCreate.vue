<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card card-widget">
                    <form @submit.prevent="postNews">
                        <div class="card-header">
                            <h5 class="mb-0">Create News</h5>
                        </div>
                        <div class="card-body">
                            <div class="input-group mb-3">
                                <Select2 v-model="form.category_id" :options="categories" class="form-control" />
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fa-solid fa-boxes-stacked"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Title" v-model="form.title">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fa-solid fa-heading"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <textarea rows="9" class="form-control" placeholder="body" v-model="form.body"></textarea>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fa-solid fa-align-left"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Tags (comma delimited)" v-model="form.tags">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-tags"></span>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary btn-block">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    import Select2 from 'v-select2-component';

    export default {
        components: { Select2 },
        data() {
            return {
                form: {
                    category_id: '',
                    title: '',
                    body: '',
                    tags: '',
                },
                categories: [],
            }
        },
        mounted() {
            if (this.$store.state.token !== '') {
                axios.get('http://localhost:8000/api/v1/profile', {
                        headers: { Authorization: 'Bearer ' + this.$store.state.token }
                    })
                    .then((response) => {
                        this.$store.commit('setName', response.data.data.name);
                    }).catch((error) => {
                    this.$store.commit('clearToken');
                    this.$router.push({ name: 'Login' });
                });
            } else {
                this.$router.push({ name: 'Login' });
            }

            this.getCategories();
        },
        methods: {
            getCategories() {
                axios.get('http://localhost:8000/api/v1/categories?limit=100', {
                    headers: { Authorization: 'Bearer ' + this.$store.state.token }
                })
                    .then((response) => {
                        this.categories = response.data.data.map((category) => {
                            return {id: category.id, text: category.name}
                        });
                    });
            },
            postNews(e) {
                axios.post('http://localhost:8000/api/v1/news', this.form, {
                        headers: { Authorization: 'Bearer ' + this.$store.state.token }
                    })
                    .then((response) => {
                        this.$router.push({ name: 'News' });
                    });
            }
        }
    }
</script>
