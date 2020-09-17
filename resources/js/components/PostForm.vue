<template>
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h3>Terbaru</h3>
            <a class="btn btn-outline-info" href="/">Semua Artikel</a>
        </div>
        <div class="card-body">
            <form method="post">
                <div class="form-group">
                    <label for="post_title">Judul</label>
                    <input autocomplete="off" v-model="post_title" type="text" class="form-control" name="post_title">
                </div>
                <div class="form-group">
                    <label for="post_content">Artikel</label>
                    <ckeditor :editor="editor" v-model="post_content" :config="editorConfig"
                              @blur="autosave"></ckeditor>
                </div>
                <div class="form-group">
                    <label for="post_tags">Tag</label>
                    <input v-model="tags" type="text" class="form-control" name="post_tags"/>
                    <p><small>Pisahkan tag dengan koma</small></p>
                </div>
                <div class="form-group text-center">
                    <p class="alert alert-success" v-if="status!=''">{{status}}</p>
                </div>
                <div class="form-group d-flex justify-content-between">
                    <button @click.prevent="publish" class="btn btn-outline-success">Terbitkan <i
                        v-show="is_processing" class="fa fa-spin fa-spinner"></i></button>
                    <button @click.prevent="draft"
                            class="btn btn-outline-primary">Simpan Draft <i class="fa fa-spin fa-spinner"
                                                                            v-show="is_processing"></i></button>
                </div>
            </form>
        </div>
    </div>
</template>
<script>
    import * as ClassicEditor from '@ckeditor/ckeditor5-build-classic';

    export default {
        props: ['post'],
        data() {
            return {
                data: this.post == undefined ? "" : this.post,
                editing: false,
                post_content: this.post == undefined ? "" : this.post.post_content,
                id: this.post == undefined ? null : this.post.id,
                post_title: this.post == undefined ? "" : this.post.post_title,
                tags: this.post == undefined ? "" : this.post.all_tags,
                content_cache: null,
                editor: ClassicEditor,
                status: '',
                post_status: this.post.post_status,
                is_error: true,
                is_processing: false,
                editorConfig: {
                    ckfinder: {
                        // Upload the images to the server using the CKFinder QuickUpload command.
                        uploadUrl: '/media/image/upload'
                    }
                }
            }
        },
        mounted() {
            if (!(this.id == null || this.id == undefined || this.id == "")) {
                setInterval(this.autosave, 30000)
            }
        },
        methods: {
            publish() {
                this.status = ''
                this.is_error = this.post == undefined ? true : false
                this.is_processing = true
                if (this.post_title == undefined || this.post_title.length < 1) {
                    this.status = "Judul artikel tidak boleh kosong"
                    this.is_processing = false
                } else if (this.post_content == undefined || this.post_content.length < 1) {
                    this.status = "Isi artikel tidak boleh kosong"
                    this.is_processing = false
                } else if (this.id == undefined) {
                    this.save('publish')
                } else {
                    this.update('publish')
                }
            },
            draft() {
                this.status = ''
                this.is_error = true
                this.is_processing = true
                if (this.post_title == undefined || this.post_title.length < 1) {
                    this.status = "Judul artikel tidak boleh kosong"
                    this.is_processing = false
                } else if (this.post_content == undefined || this.post_content.length < 1) {
                    this.status = "Isi artikel tidak boleh kosong"
                    this.is_processing = false
                } else if (this.id == undefined) {
                    this.save('draft')
                } else {
                    this.update('draft')
                }
            },
            save(status) {
                axios.post('/post', {
                    post_status: status,
                    post_title: this.post_title,
                    post_content: this.post_content,
                    post_tags: this.tags
                })
                    .then(res => {
                        this.id = res.data.data.id
                        this.data = res.data.data
                        this.editing = false
                        this.status = 'Artikel berhasil diterbitkan dengan status ' + this.data.post_status
                        this.is_error = false
                        this.is_processing = false
                        location.href = '/post/' + res.data.data.id + "/edit"

                    })
                    .catch(err => {
                        console.log(err.data.message)
                        if (err.code == 422) {
                            console.log(err.response.data)
                        }
                    })
            },
            update(status) {
                this.is_processing = true
                this.status = "memroses data..."
                axios.patch(`/post/${this.id} `, {
                    post_title: this.post_title,
                    post_content: this.post_content,
                    post_tags: this.tags,
                    post_status: status
                })
                    .then(res => {
                        this.data = res.data.data
                        this.editing = false
                        this.status = 'Artikel berhasil diperbarui dengan status ' + this.data.post_status
                        this.is_error = false
                        this.is_processing = false
                    })
                    .catch(err => {
                        console.log(err)
                        if (err.code == 422) {
                            console.log(err.response.data)
                        }
                    })
            },
            autosave() {
                if (this.post_status == 'publish') {
                    this.update('publish')
                } else {
                    this.update('draft')
                }
            }
        },
        computed: {}
    }
</script>
