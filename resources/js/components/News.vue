<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div v-for="n in news" class="card card-widget">
                    <div class="card-header">
                        <div class="user-block">
                            <img class="img-circle" src="/user.png" alt="User Image">
                                <span class="username"><a href="#">{{n.author.name}}</a></span>
                            <span class="description">{{n.hr_created_at}}</span>
                        </div>
                        <div v-if="n.is_author" class="card-tools">
                            <router-link :to="{ name: 'NewsEdit', params: { id: n.id } }" type="button" class="btn btn-tool">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </router-link>
                            <button type="button" @click.prevent="removeNews(n.id)" class="btn btn-tool">
                                <i class="fa-solid fa-trash text-danger"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">

                        <img v-if="n.images.length" class="img-fluid pad mb-2" :src="n.images[0].image_url" alt="Photo">
                        <h5>{{ n.title }}</h5>
                        <p>{{ n.body }}</p>
                        <button v-if="n.is_liked" @click.prevent="unlike(n.id)" type="button" class="btn btn-default btn-sm text-primary"><i class="fa-solid fa-thumbs-up"></i> Like</button>
                        <button v-else @click.prevent="like(n.id)" type="button" class="btn btn-default btn-sm"><i class="fa-solid fa-thumbs-up"></i> Like</button>
                        <span class="float-right text-muted">{{ n.like_count }} likes - {{ n.comment_count }} comments</span>
                    </div>

                    <div v-if="n.comment_count" class="card-footer card-comments">
                        <div v-for="comment in n.comments.slice().reverse()" class="card-comment">
                            <img class="img-circle img-sm" src="/user.png" alt="User Image">
                            <div class="comment-text">
                                <span class="username">
                                    {{ comment.user.name }}
                                    <span class="text-muted float-right">{{ comment.hr_created_at }}</span>
                                </span>
                                {{ comment.body }}
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <form @submit.prevent="postComment">
                            <img class="img-fluid img-circle img-sm" src="/user.png" alt="Alt Text">

                            <div class="img-push">
                                <input type="hidden" name="news" :value="n.id">
                                <input type="text" name="comment" class="form-control form-control-sm" placeholder="Press enter to post comment">
                            </div>
                        </form>
                    </div>
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
                news: [],
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
            this.getNews();
        },
        methods: {
            getNews() {
                axios.get('http://localhost:8000/api/v1/news', {
                        headers: { Authorization: 'Bearer ' + this.$store.state.token }
                    })
                    .then((response) => {
                        this.news = response.data.data;
                        console.log(this.news)
                    });
            },
            like(newsId) {
                axios.post('http://localhost:8000/api/v1/news/' + newsId + '/like', [], {
                        headers: { Authorization: 'Bearer ' + this.$store.state.token }
                    })
                    .then((response) => {
                        this.getNews();
                    });
            },
            unlike(newsId) {
                axios.post('http://localhost:8000/api/v1/news/' + newsId + '/unlike', [], {
                        headers: { Authorization: 'Bearer ' + this.$store.state.token }
                    })
                    .then((response) => {
                        this.getNews();
                    });
            },
            postComment(e) {
                let comment = e.target.comment.value;
                let newsId = e.target.news.value;
                axios.post('http://localhost:8000/api/v1/news/' + newsId + '/comments', {'body': comment}, {
                        headers: { Authorization: 'Bearer ' + this.$store.state.token }
                    })
                    .then((response) => {
                        this.getNews();
                        e.target.comment.value = '';
                    });
            },
            removeNews(newsId) {
                if (confirm('Are you sure?')) {
                    axios.delete('http://localhost:8000/api/v1/news/' + newsId, {
                            headers: { Authorization: 'Bearer ' + this.$store.state.token }
                        })
                        .then((response) => {
                            this.getNews();
                        });
                }
            }
        }
    }
</script>
