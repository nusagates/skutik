<template>
    <div>
        <div class="form-group">
            <label>Pertanyaan</label>
            <div class="form-group">
                <div v-for="(quiz, index) of quizes">
                    <div v-html="quiz.question"/>
                    <div v-for="q of quiz.choices" class="input-group">

                        <div class="radio">
                            <label class="w-100">
                                <input :checked="q.correct==1" readonly  :value="q.key" name="options[]"
                                        type="radio"> <span class="d-inline" v-html="q.answer"/>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <ckeditor :editor="editor" v-model="question" :config="editorConfig"></ckeditor>
        </div>
        <div class="form-group">
            <div v-for="(answer, index) of answers" class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <input v-model="correct" type="radio" name="correct[]" :value="index">
                    </div>
                </div>
                <ckeditor :editor="editor" v-model="answers[index]" :config="editorConfig"></ckeditor>
            </div>
        </div>
        <div class="form-group">
            <p v-if="message!=''" class="alert alert-warning">{{message}}</p>
        </div>
        <div class="form-group">
            <button :disabled="processing" @click="submit" class="btn btn-outline-success">Tambahkan Pertanyaan</button>
        </div>

    </div>
</template>

<script>
    import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
    export default {
        props: ['challenge'],
        data() {
            return {
                editor: ClassicEditor,
                processing: false,
                message: '',
                question: '',
                answers: {
                    1: '',
                    2: '',
                    3: '',
                    4: '',
                    5: '',
                },
                correct: 0,
                quizes: this.challenge.quizes,
                editorConfig: {
                    ckfinder: {
                        // Upload the images to the server using the CKFinder QuickUpload command.
                        uploadUrl: '/media/image/upload'
                    },
                    heading: {
                        options: [
                            { model: 'normal', view: 'span', title: 'Normal', class: 'ck-heading_paragraph' },
                            { model: 'paragraph', view:'span', title: 'Paragraph', class: 'ck-heading_paragraph' },
                            { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                            { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                            { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' }
                        ]
                    }
                }
            }
        },
        methods: {
            submit() {
                if (this.question === '') {
                    this.message = "Silahkan isi pertanyaan terlebih dahulu"
                } else if (this.correct === 0) {
                    this.message = "Silahkan pilih jawaban yang benar"
                } else if (this.answers[this.correct] === '') {
                    this.message = "Jawaban benar tidak boleh kosong"
                } else {
                    this.processing = true
                    this.message = 'memroses...'
                    axios.post(`/challenge/${this.challenge.id}/quiz `, {
                        question: this.question,
                        answer: this.answers,
                        correct: this.correct
                    })
                        .then(res => {
                            if (res.data.code === 200) {
                                this.quizes = res.data.quiz
                                this.message = 'Pertanyaan berhasil ditambahkan'
                                this.clear()
                                this.processing = false
                            }

                        }).catch(err => {
                        this.message = 'ada kesalahan teknis saat memroses data'
                        this.processing = false
                    });
                }
            },
            clear() {
                this.question = ''
                this.correct = 0
                for (let i = 1; i < Object.keys(this.answers).length+1; i++) {
                    this.answers[i] = ''
                }
            }
        },
    }
</script>

