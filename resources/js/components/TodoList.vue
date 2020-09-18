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
                        <li v-for="list of data.lists">
                            <div class="d-block">
                                <div @click="update(list.id)">
                                    <i v-bind:class="{'text-success fa-check-circle':list.status==='finished', 'text-muted fa-square':list.status!=='finished',}"
                                       class="fa fa-li"></i>
                                    <label class="checkbox-inline">
                                        <s v-if="list.status==='finished'" v-html="list.description"/>
                                        <span v-else v-html="list.description"/>
                                    </label>
                                </div>
                                <div>
                                    <button @click="edit(list.id, list.description)" class="badge badge-success"><i
                                        class="fa fa-pencil-alt"></i></button>
                                    <button @click="remove(list.id)" class="badge badge-danger"><i
                                        class="fa fa-times"></i></button>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="form-group" v-else>Belum ada tugas pada Todo ini</div>
                <div class="form-group">
                    <textarea placeholder="Task description..." class="form-control" v-model="content"></textarea>
                </div>
                <div v-show="message!=''" class="form-group alert alert-warning" v-html="message"/>
                <div class="form-group">
                    <button v-show="!editing" :disabled="processing" @click="add" class="btn btn-success btn-sm">Add
                    </button>
                    <button v-show="editing" :disabled="processing" @click="cancel"
                            class="btn btn-primary btn-sm">
                        Cancel
                    </button>
                    <button v-show="editing" :disabled="processing" @click="update_list" class="btn btn-success btn-sm">
                        Update
                    </button>
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
                editing: false,
                content: '',
                message: '',
                processing: false,
                update_id: 0,
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
                this.processing = true
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
            },
            remove(id) {
                if (confirm('Apakah kamu ingin menghapus tugas ini?')) {
                    axios.delete(`/todo/${this.data.id}/list/` + id, {
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
            edit(id, content) {
                this.editing = true
                this.content = content
                this.update_id = id
            },
            update_list() {
                if (this.content === '') {
                    this.message = 'Please describe your task'
                } else {
                    this.processing = true
                    this.message = 'processing...'
                    axios.patch(`/todo/${this.data.id}/list/${this.update_id}`, {
                        description: this.content,
                        list_id: this.update_id,
                        update: true
                    })
                        .then(res => {
                            this.message = 'Task has been updated successfully'
                            this.processing = false
                            this.data = res.data
                            this.content = ''
                            this.cancel()
                        })
                        .catch(err => {
                            this.message = 'an error occured'
                            this.processing = false
                        })
                }
            },
            cancel() {
                this.editing = false
                this.content = ''
                this.update_id = 0
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
