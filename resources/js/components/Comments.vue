<script>
    export default {
        props: ['comment'],
        data() {
            return {
                editing: false,
                comment_content: this.comment.comment_content,
                id: this.comment.id,
                post_id: this.comment.post_id,
                content_cache: null
            }
        },
        methods: {
            edit() {
                this.content_cache = this.comment_content
                this.editing = true
            },
            cancel() {
                this.comment_content = this.content_cache
                this.editing = false
            },
            update() {
                axios.patch(`/post/${this.post_id}/comment/${this.id}`, {
                    comment_content: this.comment_content
                })
                    .then(res => {
                        console.log(res.data.comment_content)
                        this.comment_content = res.data.comment_content
                        this.editing = false

                    })
                    .catch(err => {
                        console.log("Kesalahan")
                    })
            },
            store() {
                axios.post(`post/${post_id}/comment `, {
                    comment_content: this.comment_content
                })
                    .then(res => {
                        console.log(res.data.comment_content)
                        this.comment_content = res.data.comment_content
                        this.editing = false

                    })
                    .catch(err => {
                        console.log("Kesalahan")
                    })
            }
        },
        computed: {
            isInvalid() {
                return this.comment_content.length < 10
            }
        }
    }
</script>
