<template>
    <div>
        <div v-for="item of quiz.choices" class="form-group">
            <div class="input-group">
                <div class="radio">
                    <label class="w-100">
                        <input :disabled="processing" @click="submit(item.key)" :value="item.key" name="options[]"
                               v-model="selected" type="radio"> {{item.answer }}
                    </label>
                </div>
            </div>
            <hr/>
        </div>
        <div class="form-group">
            <p class="alert alert-warning" v-show="message!=''">{{message}}</p>
        </div>
        <div v-show="error" class="text-center my-2">
            <button :disabled="processing" @click="resubmit" class="btn btn-success btn-block">Kirim Ulang</button>
        </div>
        <div v-show="next==''" class="text-center">
            <button @click="finish" class="btn btn-success btn-block">Selesaikan Tantangan</button>
        </div>
        <div class="d-flex justify-content-between">
            <button v-show="next!=''" @click="prevEvt" :disabled="selected==0||prev==''||processing"
                    class="btn btn-outline-success">Sebelumnya
            </button>
            <button v-show="next!=''" @click="nextEvt" :disabled="selected==0||next==''||processing"
                    class="btn btn-outline-success">Selanjutnya
            </button>
        </div>
    </div>
</template>
<script>
    export default {
        props: ['quiz', 'next', 'prev'],
        data() {
            return {
                selected: 0,
                challenge_id: this.quiz.challenge_id,
                quiz_id: this.quiz.id,
                message: '',
                answer: '',
                processing: false,
                error: false
            }
        },
        methods: {
            submit(key) {
                this.message = 'memroses...'
                this.processing = true
                axios.post(`/challenge/quiz/answer`, {
                    challenge_id: this.challenge_id,
                    key: key,
                    quiz_id: this.quiz_id,
                })
                    .then(res => {
                        if (res.data.code === 200) {
                            this.message = 'Jawaban berhasil disimpan'
                            this.answer = res.data.answer
                            this.error = false
                        } else {
                            this.message = 'ada kesalahan teknis'
                            this.error = true
                        }
                        this.processing = false
                    })
                    .catch(err => {
                        this.message = 'ada kesalahan teknis'
                        this.error = true
                        this.processing = false
                    })
            },
            finish(key) {
                this.message = 'memroses...'
                if (this.selected == 0) {
                    this.message = "Silahkan pilih jawaban terlebih dahulu"
                } else if (this.answer == '') {
                    this.message = 'Belum bisa menyelesaikan tantangan. SIlahkan pilih jawaban sekali lagi'
                } else {
                    axios.post(`/challenge/${this.challenge_id}/finish `, {
                        challenge_id: this.challenge_id,
                        key: key,
                        quiz_id: this.quiz_id,
                        answer_id: this.answer.id
                    })
                        .then(res => {
                            console.log(res.data)
                            this.message = 'Jawaban berhasil disimpan'
                            console.log(res.data.url)
                            if (res.data.code == 200) {
                                location.href = res.data.url
                            }

                        })
                        .catch(err => {
                            console.log("Kesalahan")
                        })
                }
            },
            resubmit() {
                this.submit(this.selected)
            },
            prevEvt() {
                location.href = this.prev
            },
            nextEvt() {
                location.href = this.next
            }
        }
    }


</script>
