<template>
    <div>
        <div v-for="item of quiz.choices" class="form-group">
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <input @click="submit(item.key)" :value="item.key" name="options[]" v-model="selected"
                               type="radio">
                    </div>
                </div>
                <input readonly :value="item.answer" type="text"
                       class="form-control">
            </div>
        </div>
        <div class="form-group">
            <p class="alert alert-warning" v-show="message!=''">{{message}}</p>
        </div>
        <div v-show="next==''" class="text-center">
            <button @click="finish" class="btn btn-success btn-block">Selesaikan Tantangan</button>
        </div>
        <div class="d-flex justify-content-between">
            <button v-show="next!=''" @click="prevEvt" :disabled="selected==0||prev==''"
                    class="btn btn-outline-success">Sebelumnya
            </button>
            <button v-show="next!=''" @click="nextEvt" :disabled="selected==0||next==''"
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
                message: ''
            }
        },
        methods: {
            submit(key) {
                this.message = 'memroses...'
                axios.post(`/challenge/quiz/answer`, {
                    challenge_id: this.challenge_id,
                    key: key,
                    quiz_id: this.quiz_id,
                })
                    .then(res => {
                        console.log(res.data)
                        this.message = 'Jawaban berhasil disimpan'

                    })
                    .catch(err => {
                        console.log("Kesalahan")
                    })
            },
            finish(key) {
                this.message = 'memroses...'
                if (this.selected == 0) {
                    this.message = "Silahkan pilih jawaban terlebih dahulu"
                } else {
                    axios.post(`/challenge/${this.challenge_id}/finish `, {
                        challenge_id: this.challenge_id,
                        key: key,
                        quiz_id: this.quiz_id,
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
            prevEvt() {
                location.href = this.prev
            },
            nextEvt() {
                location.href = this.next
            }
        }
    }


</script>
