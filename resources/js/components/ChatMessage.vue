<template>
    <div class="col-md-12">
        <div class="text-center border-bottom mb-2 py-2 col-md-12">
            <h4 v-html="room.title"></h4>
            <button @click="fetch" class="btn btn-success btn-sm"><i v-show="processing"
                                                                     class="fa fa-spin fa-spinner"></i> Reload
            </button>
        </div>
        <div v-if="auth==='1'" class="col-md-12 mb-2">
            <div class="input-group">
                <input id="btn-input" type="text" name="message" class="form-control input-sm"
                       placeholder="Type your message here..." v-model="message_content" @keyup.enter="sendMessage">

                <span class="input-group-btn">
            <button :disabled="processing" class="btn btn-primary" id="btn-chat" @click="sendMessage">
                Send
            </button>
        </span>
            </div>
            <div v-show="warning!==''" class="form-group text-center mt-2">
                <p class="alert alert-warning"> <span v-html="warning"/></p>
            </div>
        </div>
        <div v-else class="col-md-12 mb-2 text-center"><a href="/login">Login</a> to join this conversation</div>
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-body">
                    <div v-for="item of message" class="chat-content">
                        <div class='lead d-flex justify-content-between'>
                            <div class="d-block d-flex justify-content-between">
                                <img alt="User Avatar" height="40" width="40" class="img rounded-circle"
                                     :src="item.user.avatar"/>
                                <div class="ml-2">
                                    <a :href="item.user.url">{{ item.user.name }}</a>
                                    <small class="text-muted d-block" v-html="item.created_date"/>
                                    <p v-html="item.message"/>
                                </div>

                            </div>
                            <div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['room', 'auth'],
        data() {
            return {
                message: this.room.chats,
                message_content: '',
                warning: '',
                processing: false
            }
        },
        methods: {
            fetch() {
                this.processing = true
                axios.get(`/room/${this.room.slug}`, {
                    message: this.message_content
                })
                    .then(res => {
                        this.message = res.data
                        this.processing = false
                    })
                    .catch(err => {
                        this.warning = 'an error occured'
                        this.processing = false
                    })
            },
            sendMessage() {
                if (this.message_content === '') {
                    this.warning = 'Your message please...'
                } else {
                    this.processing = true
                    this.warning = 'processing...'
                    axios.post(`/room/${this.room.id}/chat `, {
                        message: this.message_content
                    })
                        .then(res => {
                            this.warning = ''
                            this.processing = false
                            this.data = res.data
                            this.message_content = ''
                            this.fetch()
                        })
                        .catch(err => {
                            this.warning = 'an error occured'
                            this.processing = false
                        })
                }
            }
        },
        created() {
            Echo.private('chat')
                .listen('ChatSent', (e) => {
                    console.log(999)
                });

        }
    }
</script>
