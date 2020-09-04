<template>
    <div class="post-content">
        <div class="post-content mt-2 mb-2" v-html="model.post_content"/>
        <div class="text-center mt-4">
            <a class="btn btn-sm btn-outline-success my-1 mx-1" v-for="tag in model.tags" :href="tag.url">{{tag.name}}</a>
        </div>
        <hr>
    </div>
</template>

<script>
    export default {
        props: ['model']
    }
</script>

<style scoped>

</style>
