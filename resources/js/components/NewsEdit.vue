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
                            <div v-if="error_msg" class="alert alert-danger">
                                {{ error_msg }}
                            </div>
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <Select2 v-model="form.category_id" :options="categories" class="form-control" />
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fa-solid fa-boxes-stacked"></span>
                                        </div>
                                    </div>
                                </div>
                                <span v-if="errors.category_id" class="text-danger">{{ errors.category_id[0] }}</span>
                            </div>
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="Title" v-model="form.title">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fa-solid fa-heading"></span>
                                        </div>
                                    </div>
                                </div>
                                <span v-if="errors.title" class="text-danger">{{ errors.title[0] }}</span>
                            </div>
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <input type="file" class="form-control" placeholder="Image" accept="image/*" v-on:change="onChangeFile">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <img v-if="form.image" :src="form.image" style="width: 20px">
                                            <span v-else class="fa-solid fa-image"></span>
                                        </div>
                                    </div>
                                </div>
                                <span v-if="errors.image" class="text-danger">{{ errors.image[0] }}</span>
                            </div>
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <textarea rows="9" class="form-control" placeholder="body" v-model="form.body"></textarea>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fa-solid fa-align-left"></span>
                                        </div>
                                    </div>
                                </div>
                                <span v-if="errors.body" class="text-danger">{{ errors.body[0] }}</span>
                            </div>
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="Tags (comma delimited)" v-model="form.tags">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-tags"></span>
                                        </div>
                                    </div>
                                </div>
                                <span v-if="errors.tags" class="text-danger">{{ errors.tags[0] }}</span>
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
                    image: '',
                    new_image: ''
                },
                categories: [],
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
                        this.$store.commit('setName', response.data.data.name);
                    }).catch((error) => {
                    this.$store.commit('clearToken');
                    this.$router.push({ name: 'Login' });
                });
            } else {
                this.$router.push({ name: 'Login' });
            }

            this.getCategories();
            this.getNews();
        },
        methods: {
            getNews() {
                axios.get('http://localhost:8000/api/v1/news/' + this.$route.params.id, {
                        headers: { Authorization: 'Bearer ' + this.$store.state.token }
                    })
                    .then((response) => {
                        let dt = response.data.data;
                        this.form.category_id = dt.category.id;
                        this.form.title = dt.title;
                        this.form.body = dt.body;
                        this.form.tags = dt.tags;

                        if (dt.images.length)
                            this.form.image = dt.images[0].image_url
                    });
            },
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
                let formData = new FormData();
                formData.append('category_id', this.form.category_id);
                formData.append('title', this.form.title);
                formData.append('body', this.form.body);
                formData.append('tags', this.form.tags);
                formData.append('image', this.form.new_image);
                formData.append('_method', 'PUT');
                axios.post('http://localhost:8000/api/v1/news/' + this.$route.params.id, formData, {
                        headers: {
                            Authorization: 'Bearer ' + this.$store.state.token,
                            'Content-Type': 'multipart/form-data'
                        }
                    })
                    .then((response) => {
                        console.log(response.data);
                        this.$router.push({ name: 'News' });
                    })
                    .catch((error) => {
                        this.error_msg = error.response.data.message;
                        if (error.response.data.errors)
                            this.errors = error.response.data.errors;

                        console.log(this.errors);
                    });
            },
            onChangeFile(e) {
                this.form.new_image = e.target.files[0];
            }
        }
    }
</script>
