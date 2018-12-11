<template>
    <div id="gameStats">
        <span v-if="training.length === 0">...</span>

        <div class="row">{{ training.category }}</div>

        <div class="row header">
            {{ training.answered_questions }} / {{ training.count_of_turns }}
        </div>

        <div class="row round">
            <button
                    v-for="turn in training.turns"
                    class="btn btn-sm"
                    :class="turnColorClass(turn)"
            >
            </button>
        </div>

        <br>
        <router-link v-show="!trainingIsFinished() &&  training.length !== 0" to="/trainings/question"> Continue game </router-link><br>
        <router-link to="/trainings/create"> Add training game </router-link><br>
        <router-link to="/trainings"> Trainings </router-link>

    </div>

</template>

<script>
    import { mapActions, mapState, mapMutations, mapGetters } from 'vuex';

    export default {
        data() {
            return {
                turnColor : {
                    'btn-danger' : true,
                },
                interval : null,
            }
        },
        mounted() {
            this.setPageName('Training Stats');
            this.setPageDescription('');
            this.fetchTraining().then(() => {
                this.setCurrentTrainingId(this.training.id);
            });
        },
        computed: mapState(['training']),
        methods: {

            ...mapActions(['fetchTraining']),

            ...mapMutations([
                'setPageName',
                'setPageDescription',
                'setCurrentTrainingId'
            ]),

            ...mapGetters(['trainingIsFinished']),

            turnColorClass(turn) {
                return {
                    'btn-basic' : turn.status === 'empty',
                    'btn-success' : turn.status === 'right',
                    'btn-danger' : turn.status === 'wrong'
                }
            },
        },

        beforeDestroy: function() {
            clearInterval(this.interval);
        },
    }
</script>


<style>
    .header {
        text-align: center;
    }
    .round {
        padding: 20px;
        margin: 20px;
        border: 1px solid #e8e8e8;
        border-radius: 20px;
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
</style>