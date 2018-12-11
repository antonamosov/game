<template>
    <div id="question">

        <div class="row header text-center">
            {{ question.category }}
        </div>

        <div class="row header text-center">
            {{ training.answered_questions }} / {{ training.count_of_turns }}
        </div>

        <div class="row title text-center">
            {{ question.title }}
        </div>

        <div
                class="row variants text-center"
                :class="{disabled : disabled}"
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
                    v-if="question.type === 'text'"
                    class="btn btn-sm btn-primary"
                    :class="{disabled : disabled}"
                    @click="sendTextAnswer"
            >Submit</button>
        </div>

        <br>
        <router-link to="/trainings/show"> Training stats </router-link><br>
    </div>

</template>

<script>
    import { mapActions, mapState, mapMutations, mapGetters } from 'vuex';

    export default {
        data() {
            return {
                answer : '',
                disabled : false
            }
        },
        mounted() {
            if (this.trainingIsFinished()) {
                this.$router.push('/games/finish');
            }
            this.setPageName('Question');
            this.setPageDescription('');
            this.fetchQuestion();
        },
        computed: mapState(['question', 'training']),
        methods: {

            ...mapActions({
                fetchQuestion : 'fetchTrainingQuestion',
                answerToAQuestion : 'trainingAnswer',
                fetchTraining : 'fetchTraining'
            }),

            ...mapMutations([
                'setPageName',
                'setPageDescription',
                'incrementTrainingQuestionNumber'
            ]),

            ...mapGetters(['isVictory', 'trainingIsFinished']),

            sendSelectAnswer(answer) {
                this.disabled = true;
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
                this.fetchTraining().then(() => {
                    if (this.trainingIsFinished()) {
                        this.$router.push('/trainings/show');
                    }
                    else {
                        this.answer = '';
                        this.fetchQuestion();
                        this.disabled = false;
                    }
                });
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
    div.disabled {
        pointer-events: none;
    }
    button.disabled {
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