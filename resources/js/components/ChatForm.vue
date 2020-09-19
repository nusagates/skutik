<template>
    <div>

    </div>
</template>

<script>
    export default {
        props: ['room_id'],
        data() {
            return {
                message_content: '',
                warning: '',
                processing: false
            }
        },
        methods: {
            sendMessage() {
                if (this.message_content === '') {
                    this.warning = 'Your message please...'
                } else {
                    this.processing = true
                    this.warning = 'processing...'
                    axios.post(`/room/${this.room_id}/chat `, {
                        message: this.message_content
                    })
                        .then(res => {
                            this.warning = 'Your message has been added successfully'
                            this.processing = false
                            this.data = res.data
                            this.message_content = ''
                        })
                        .catch(err => {
                            this.warning = 'an error occured'
                            this.processing = false
                        })
                }
            }
        }
    }
</script>
