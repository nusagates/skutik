<template>
    <div>
        <div class="card shadow">
            <div class="card-body">
                <div class="form-group" v-if="data.lists.length>0">
                    <div v-for="list of data.lists" class="checkbox">
                        <label>
                            <input :checked="list.status==='finished'" @click="update(list.id)" type="checkbox"
                                   :value="list.id">
                            <s v-if="list.status==='finished'" v-html="list.description"/>
                            <span v-else v-html="list.description"/>
                        </label>
                    </div>
                </div>
                <div class="form-group" v-else>Belum ada tugas pada Todo ini</div>
                <div class="form-group">
                    <textarea class="form-control" v-model="content"></textarea>
                </div>
                <div v-show="message!=''" class="form-group alert alert-warning" v-html="message"/>
                <div class="form-group">
                    <button :disabled="processing" @click="add" class="btn btn-success btn-sm">Tambah</button>
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
                    this.message = 'Silahkan isi deskripsi tugas terlebih dahulu'
                } else {
                    this.processing = true
                    this.message = 'memrosess'
                    axios.post(`/todo/${this.data.id}/list`, {
                        description: this.content
                    })
                        .then(res => {
                            this.message = 'Tugas berhasil ditambahkan'
                            this.processing = false
                            this.data = res.data
                            this.content = ''
                        })
                        .catch(err => {
                            this.message = 'terjadi kesalahan saat memroses data'
                            this.processing = false
                        })
                }
            },
            update(id) {
                axios.patch(`/todo/${this.data.id}/list/${id}`, {
                    list_id: id
                })
                    .then(res => {
                        this.message = 'Tugas berhasil diselesaikan'
                        this.processing = false
                        this.data = res.data
                        this.content = ''
                    })
                    .catch(err => {
                        this.message = 'terjadi kesalahan saat memroses data'
                        this.processing = false
                    })
            }
        }
    }
</script>
