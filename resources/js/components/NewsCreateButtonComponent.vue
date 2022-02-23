<template>
    <ol v-if="$route.name === 'News'" class="breadcrumb float-sm-right">
        <router-link :to="{ name: 'NewsCreate' }" type="button" class="btn btn-primary btn-sm">
            Create News
        </router-link>
    </ol>
    <ol v-else-if="$route.name === 'NewsCreate'" class="breadcrumb float-sm-right">
        <router-link :to="{ name: 'News' }" type="button" class="btn btn-danger btn-sm">
            Cancel
        </router-link>
    </ol>
</template>

<script>
    export default {

    }
</script>
