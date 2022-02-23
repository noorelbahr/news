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
    let config = {
        headers: { Authorization: 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI5NWE4ZTg2Yy1kNmJkLTQ3YmQtOTg2OS1mMTkyZmEyYTVjNjciLCJqdGkiOiI2NGZhYzNhZGRiZTQ4Zjg2OGQ0ODUzZWU4ZjAyMWE4ZGY1MGFlZGY5ZGJlNWI3OGE5NjY4NjQ1N2I5YzMxY2VhYzViODI3ZDg1OGRiYmQ4MyIsImlhdCI6MTY0NTUyNjkzNywibmJmIjoxNjQ1NTI2OTM3LCJleHAiOjE2NzcwNjI5MzcsInN1YiI6IjQzMzRhY2NiLWQyOWEtNDM0MC04YzU0LTZhZmE0NDE3ODVlZSIsInNjb3BlcyI6W119.Xetl9nT3ygNlHVDYwCeD0rSltRRPsIZY8IQQSnyeT5exqgRBqkhW94KcDB9mk0a1I9omtk43MrhxvSSMCsyVzAkAOeLMg8MQsoyDuaqtYirNloCFgIRJ5SCtkrRYGj4UDHlWTeoUpW0ikAdYth7A8zUqpHouybQEELARcPluSpCXCDTnaYemt0cFFTW5Bc-yCZRYqNperb1PEMEgVPzvKg6n3z2Uvehq3afgm-isRMPDXkdQny6_nlF82u-lzyscAREDE95jFf6AdlmqWOXcxJiPIaqQsRnWw9L2oJrANpHQO2hmRetrz0oAWTSxN9vvQAKV0Mz6PYDy-8dWD6kcPQq7Vfp9ut_Gcrhs7IdAQ66b0HRCGKn9DszNwfASTFpSeOxE8UyEO39nCyTw8XdWJ1Y8LtBVleuUZQSfva3zHrRV0Q6rC4CZRJZhjVWCot5l48dcSPCoBi8c4BIs3Vk1xZbBqgnRXGEnjHor_xVWw3Ahq0BBpcfqO3WpqtYp3rOSxccgEEmZ5_1aWlJbHbxitJBtN44f9u_3g5v8_fwqoOWGl_7oFLZIz7B-iodrNE773h4S5QXK1YCMOuZJuumQV5CGWL7EFdYYb0Oh5AETTTAK1TPMTQ4OzW5jJJzzO-XFZysewk9vyJObkun7eCJ2l4m_DeiveqN3EjRqePKCdCs' }
    };

    export default {
        data() {
            return {
                news: [],
            }
        },
        mounted() {
            this.getNews();
            console.log('Component mounted.')
        },
        methods: {
            getNews() {
                axios.get('http://localhost:8000/api/v1/news', config)
                    .then((response) => {
                        this.news = response.data.data;
                        console.log(this.news)
                    });
            },
            like(newsId) {
                axios.post('http://localhost:8000/api/v1/news/' + newsId + '/like', [], config)
                    .then((response) => {
                        this.getNews();
                    });
            },
            unlike(newsId) {
                axios.post('http://localhost:8000/api/v1/news/' + newsId + '/unlike', [], config)
                    .then((response) => {
                        this.getNews();
                    });
            },
            postComment(e) {
                let comment = e.target.comment.value;
                let newsId = e.target.news.value;
                axios.post('http://localhost:8000/api/v1/news/' + newsId + '/comments', {'body': comment}, config)
                    .then((response) => {
                        this.getNews();
                        e.target.comment.value = '';
                    });
            }
        }
    }
</script>
