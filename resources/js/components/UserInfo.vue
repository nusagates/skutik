<template>
    <div class='lead d-flex justify-content-between'>
        <div class="d-block d-flex justify-content-between">
            <img alt="User Avatar" height="40" width="40" class="img rounded-circle"
                 :src="userdata.avatar"/>
            <div class="ml-2">
                <a :href="userdata.url">{{ userdata.name }}</a>
                <small class="text-muted d-block">{{ postDate }}</small>
            </div>
        </div>
        <div>
            <div class="text-muted d-block"><i
                class="fa fa-eye"></i> {{model.post_view}}
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['model', 'userdata'],
        computed: {
            postDate() {
                return this.model.created_date
            }
        }
    }
</script>

<style scoped>

</style>
