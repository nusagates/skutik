<template>
    <div>
        <div class="card shadow">
            <div class="card-body">
                <h4 v-html="data.title+' Tasks List'"/>
                <div class="form-group" v-if="data.lists.length>0">
                    <span v-html="this.done+' of '+data.lists.length"/>
                    <i class="fa"
                       v-bind:class="!processing?'text-success fa-check-circle':'fa-spin fa-spinner'"></i>
                    <ul class="fa-ul">
                        <li @click="update(list.id)" v-for="list of data.lists">
                            <i v-bind:class="{'text-success fa-check-circle':list.status==='finished', 'text-muted fa-square':list.status!=='finished',}"
                               class="fa fa-li"></i>
                            <label class="checkbox-inline">
                                <s v-if="list.status==='finished'" v-html="list.description"/>
                                <span v-else v-html="list.description"/>
                            </label>
                        </li>
                    </ul>
                </div>
                <div class="form-group" v-else>Belum ada tugas pada Todo ini</div>
                <div class="form-group">
                    <textarea placeholder="Task description..." class="form-control" v-model="content"></textarea>
                </div>
                <div v-show="message!=''" class="form-group alert alert-warning" v-html="message"/>
                <div class="form-group">
                    <button :disabled="processing" @click="add" class="btn btn-success btn-sm">Add</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['todo'],
        data() {
            return {
                data: this.todo,
                content: '',
                message: '',
                processing: false,
            }
        },
        methods: {
            add() {
                if (this.content === '') {
                    this.message = 'Please describe your task'
                } else {
                    this.processing = true
                    this.message = 'processing...'
                    axios.post(`/todo/${this.data.id}/list`, {
                        description: this.content
                    })
                        .then(res => {
                            this.message = 'Task has been added successfully'
                            this.processing = false
                            this.data = res.data
                            this.content = ''
                        })
                        .catch(err => {
                            this.message = 'an error occured'
                            this.processing = false
                        })
                }
            },
            update(id) {
                this.message = 'processing...'
                this.processing=true
                axios.patch(`/todo/${this.data.id}/list/${id}`, {
                    list_id: id
                })
                    .then(res => {
                        this.message = ''
                        this.processing = false
                        this.data = res.data
                        this.content = ''
                    })
                    .catch(err => {
                        this.message = 'an error occured'
                        this.processing = false
                    })
            }
        },
        computed: {
            done() {
                var d = 0;
                var list = this.data.lists;
                for (var i = 0; i < list.length; i++) {
                    if (list[i].status === "finished") {
                        d++
                    }
                }
                return d
            }
        }

    }
</script>
