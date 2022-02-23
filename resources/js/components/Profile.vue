<template>
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            <img src="/user.png" class="img-circle elevation-2">
        </div>
        <div class="info">
            <a href="#" class="d-block">{{ name }}</a>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                name: this.$store.state.name,
                errors: []
            }
        }
    }
</script>
