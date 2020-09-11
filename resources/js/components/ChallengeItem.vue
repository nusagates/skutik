<template>
    <div>
        <div class="form-group">
            <label>Pertanyaan</label>
            <div class="form-group">
                <div v-for="(quiz, index) of quizes">
                    <div>{{quiz.question}}</div>
                    <div v-for="q of quiz.choices" class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <input :checked="q.correct==1" readonly type="radio"
                                       aria-label="Radio button for following text input">
                            </div>
                        </div>
                        <input readonly type="text" class="form-control" :value="q.answer">
                    </div>
                </div>
            </div>
            <textarea placeholder="Detail pertanyaan" class="form-control" v-model="question"></textarea>
        </div>
        <div class="form-group">
            <div v-for="(answer, index) of answers" class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <input v-model="correct" type="radio" name="correct[]" :value="index">
                    </div>
                </div>
                <input v-model="answers[index]" placeholder="jawaban..." type="text" class="form-control">
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
    export default {
        props: ['challenge'],
        data() {
            return {
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
                quizes: this.challenge.quizes
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
        }
    }
</script>

