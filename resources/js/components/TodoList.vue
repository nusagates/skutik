<template>
    <div class="card shadow">
        <div class="card-body">
            <div class="text-center"><h4 v-html="Todo.Data.title+' Tasks List'"/></div>
            <div class="text-center border-bottom">
                <span v-html="this.done+' of '+Todo.List.data.length"/>
                <i class="fa"
                   v-bind:class="!processing?'text-success fa-check-circle':'fa-spin fa-spinner'"></i>
            </div>
            <div class="form-group mt-2">
                <textarea placeholder="Task description..." class="form-control" v-model="content"></textarea>
            </div>
            <div v-show="message!=''" class="form-group alert alert-warning" v-html="message"/>
            <div class="form-group text-center">
                <button :disabled="processing" @click="add" class="btn btn-block btn-success btn-sm"><span
                    v-if="processing"><i class="fa fa-spin fa-spinner"></i> processing...</span><span
                    v-else>Add Task</span>
                </button>

            </div>
            <div class="form-group" v-if="Todo.List.data.length>0">
                <ul class="fa-ul">
                    <li v-for="(list, index) of Todo.List.data">
                        <div>
                            <div class="align-self-center">
                                <i @click="update(list.id)"
                                   v-bind:class="{'text-success fa-check-circle':list.status==='finished', 'text-muted fa-circle':list.status!=='finished',}"
                                   class="fas fa-2x fa-li"></i>
                                <div class="d-flex justify-content-between align-items-center">
                                    <label :disabled="list.status==='finished'" class="pt-2 align-middle"
                                           v-bind:class="show_index===index?'d-none':'d-block'"
                                           @click="edit(list.id, list.description, index)">
                                        <s v-if="list.status==='finished'" v-html="list.description"/>
                                        <span v-else v-html="list.description"/>
                                    </label>
                                    <span v-show="show_index!=index" @click="add_sub(list.id)" class="badge badge-primary badge-pill"
                                          v-html="list.children.length+' subtask'"/>
                                </div>
                                <ul v-show="show_index!=index && list.status==='assigned'" class="list-group">
                                    <li v-for="child of list.children"
                                        v-bind:class="{'list-group-item-success': child.status==='finished'}"
                                        class="list-group-item d-flex justify-content-between align-items-center">
                                      <div>  <label>
                                          <input @click="update_child_status(child.id)" :checked="child.status==='finished'" type="checkbox"
                                                 :value="child.id" name="child"/> {{ child.description }}</label></div>
                                        <button @click="remove_child(child.id)" class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>
                                    </li>
                                </ul>
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
            <div class="form-group text-center" v-else>There are no tasks in this project yet</div>
            <pagination align="center" :data="Todo.List" @pagination-change-page="get_todo"></pagination>
        </div>
    </div>
</template>

<script>
Vue.component('pagination', require('laravel-vue-pagination'));
export default {
    props: ['slug'],
    data() {
        return {
            Todo: {
                List: {
                    data: []
                },
                Data: {
                    title: '',
                    lists: []
                }
            },
            data: {},
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
        get_todo(page=1) {
            axios.get('/todo/' + this.slug+'?page='+page).then(res => {
                this.Todo.List = res.data.data.list
                this.Todo.Data = res.data.data.todo
            })
        },
        add() {
            if (this.content === '') {
                this.message = 'Please describe your task'
            } else {
                this.processing = true
                this.message = ''
                axios.post(`/todo/${this.Todo.Data.id}/list`, {
                    description: this.content
                })
                    .then(res => {
                        this.message = ''
                        this.processing = false
                        this.Todo.Data = res.data
                        this.content = ''
                        this.get_todo()
                    })
                    .catch(err => {
                        this.message = 'an error occured'
                        this.processing = false
                    })
            }
        },
        update(id) {
            this.processing = true
            axios.patch(`/todo/${this.Todo.Data.id}/list/${id}`, {
                list_id: id
            })
                .then(res => {
                    this.get_todo()
                    this.processing = false
                })
                .catch(err => {
                    this.message = 'an error occured'
                    this.processing = false
                })
        },
        remove(id) {
            if (confirm('Apakah kamu ingin menghapus tugas ini?')) {
                this.processing = true
                axios.delete(`/todo/${this.Todo.Data.id}/list/` + id, {
                    list_id: id
                })
                    .then(res => {
                        this.processing = false
                        this.get_todo()
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
                axios.patch(`/todo/${this.data.id}/list/${this.update_id}`, {
                    description: this.content_edit,
                    list_id: this.update_id,
                    update: true
                })
                    .then(res => {
                        this.message = ''
                        this.processing = false
                        this.data = res.data
                        this.content = ''
                        this.cancel()
                        this.get_todo()
                    })
                    .catch(err => {
                        this.message = 'an error occured'
                        this.processing = false
                    })
            }
        },
        add_sub(list_id) {
            Vue.swal({
                title: 'Add Subtask',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Save',
                input: 'textarea',
                inputPlaceholder: 'subtask label or description',
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post('/todo/list/children', {'list_id': list_id, text: result.value}).then(res => {
                        this.get_todo()
                    })
                }
            })
        },
        update_child_status(child_id) {
            axios.post('/todo/list/children/update', {'child_id': child_id}).then(res => {
                this.get_todo()
            })
        },
        remove_child(child_id) {
            Vue.swal({
                title: 'Warning',
                text: 'Are you sure want to delete this sub task?',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Delete',
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post('/todo/list/children/remove', {'child_id': child_id}).then(res => {
                        this.get_todo()
                    })
                }
            })
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
            var list = this.Todo.List.data;
            for (var i = 0; i < this.Todo.List.data.length; i++) {
                if (list[i].status === "finished") {
                    d++
                }
            }
            return d
        }
    },
    mounted() {
        this.get_todo()
    }

}
</script>
