<template>
    <div>
        <div class="card shadow">
            <div class="card-body">
                <div class="text-center"><h4 v-html="data.title+' Tasks List'"/></div>
                <div class="form-group" v-if="data.lists.length>0">
                    <div class="text-center border-bottom">
                        <span v-html="this.done+' of '+data.lists.length"/>
                        <i class="fa"
                           v-bind:class="!processing?'text-success fa-check-circle':'fa-spin fa-spinner'"></i>
                    </div>
                    <ul class="fa-ul">
                        <li v-for="(list, index) of data.lists">
                            <div>
                                <div class="align-self-center">
                                    <i @click="update(list.id)"
                                       v-bind:class="{'text-success fa-check-circle':list.status==='finished', 'text-muted fa-circle':list.status!=='finished',}"
                                       class="fas fa-2x fa-li"></i>
                                    <label class="pt-2 align-middle"
                                           v-bind:class="show_index===index?'d-none':'d-block'"
                                           @click="edit(list.id, list.description, index)">
                                        <s v-if="list.status==='finished'" v-html="list.description"/>
                                        <span v-else v-html="list.description"/>
                                    </label>
                                    <transition name="fade" mode="out-in">
                                        <div v-bind:class="show_index===index?'d-block':'d-none'" class="form-group">
                                            <textarea-autosize input="update_html(this)"
                                                               placeholder="Task description..."
                                                               class="form-control edit-text"
                                                               v-model="content_edit"></textarea-autosize>
                                        </div>
                                    </transition>
                                </div>

                                <button v-show="show_index===index" @click="remove(list.id)"
                                        class="badge badge-danger">Remove
                                </button>
                                <button v-show="show_index===index" @click="cancel"
                                        class="badge badge-primary">Cancel
                                </button>
                                <button v-show="show_index===index" @click="update_list"
                                        class="badge badge-success">Update
                                </button>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="form-group" v-else>Belum ada tugas pada Todo ini</div>
                <hr>
                <div class="form-group">
                    <h5>Add Task</h5>
                    <textarea placeholder="Task description..." class="form-control" v-model="content"></textarea>
                </div>
                <div v-show="message!=''" class="form-group alert alert-warning" v-html="message"/>
                <div class="form-group">
                    <button v-show="!editing" :disabled="processing" @click="add" class="btn btn-success btn-sm">Add
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
                content_edit: '',
                message: '',
                processing: false,
                update_id: 0,
                show_index: -1,
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
                            this.cancel()
                        })
                        .catch(err => {
                            this.message = 'an error occured'
                            this.processing = false
                        })
                }
            },
            edit(id, content, index) {
                this.editing = true
                this.content_edit = content
                this.update_id = id
                this.show_index = index
            },
            update_html(element) {
                element.style.height = "5px";
                element.style.height = (element.scrollHeight) + "px";
            },
            update_list() {
                if (this.content_edit === '') {
                    this.message = 'Please describe your task'
                } else {
                    this.processing = true
                    this.message = 'processing...'
                    axios.patch(`/todo/${this.data.id}/list/${this.update_id}`, {
                        description: this.content_edit,
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
                this.content_edit = ''
                this.update_id = 0
                this.show_index = -1
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
