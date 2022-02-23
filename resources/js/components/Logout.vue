<template>

</template>

<script>
    export default {
        mounted() {
            this.$store.commit('clearToken');
            this.$router.push({ name: 'Login' });
        }
    }
</script>
