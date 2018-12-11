<template>
    <div id="question">

        <div class="row header text-center">
            {{ question.category }}
        </div>

        <div class="row title text-center">
            {{ question.title }}
        </div>

        <div
                class="row variants text-center"
                v-if="question.type === 'select'"
                v-for="answer in question.answers"
                @click="sendSelectAnswer(answer.title)"
        >
            {{ answer.title }}
        </div>

        <div
                class="row text-answer text-center"
                v-if="question.type === 'text'"
        >
            <textarea
                    v-model="answer"
                    placeholder="Enter your answer"
            >

            </textarea>
        </div>

        <div class="row text-center">
            <button
                    class="btn btn-sm btn-primary"
                    @click="sendTextAnswer"
            >Submit</button>
        </div>

    </div>

</template>

<script>
    import { mapActions, mapState, mapMutations, mapGetters } from 'vuex';

    export default {
        data() {
            return {
                answer : '',
            }
        },
        mounted() {
            if (this.gameIsFinished()) {
                this.$router.push('/games/finish');
            }
            this.setPageName('Question');
            this.setPageDescription('');
            this.fetchQuestion();
        },
        computed: mapState(['question']),
        methods: {

            ...mapActions({
                fetchQuestion : 'fetchQuestion',
                answerToAQuestion : 'answer'
            }),

            ...mapMutations([
                'setPageName',
                'setPageDescription'
            ]),

            ...mapGetters(['gameIsFinished', 'isVictory']),

            sendSelectAnswer(answer) {
                this.answerToAQuestion(answer).then(() => {
                    this.nextPage();
                });
            },

            sendTextAnswer() {
                this.answerToAQuestion(this.answer).then(() => {
                    this.nextPage();
                });
            },

            nextPage() {
                if (! this.gameIsFinished()) {
                    this.$router.push('/games/show');
                }
                else if (this.isVictory()) {
                    this.$router.push('/games/finish');
                }
                else {
                    this.$router.push('/games/show');
                }
            },
        }
    }
</script>


<style>
    .header {
        text-align: center;
    }
    a.disabled {
        pointer-events: none;
    }
    button {
        min-width: 50px;
        min-height: 35px;
        margin-left: 10px;
    }
    .variants {
        margin: 20px;
        padding: 20px;
        min-width: 90%;
        border: 1px solid #e8e8e8;
        border-radius: 20px;
    }
    .variants:hover {
        background-color: #e8e8e8;
        cursor: pointer;
    }
</style>