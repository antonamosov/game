<template>
    <div id="friends">
        <span v-if="trainings.length === 0">....</span>
        <div class="row">
            <div
                    class="col-md-2 game"
                    v-for="training in trainings"
                    @click="showGame(training)"
            >
                <div class="row"><font size="3"><img :src="training.category_image"></font></div>
                <div class="row"><font size="2">{{ training.category_name }}</font></div>
                <div class="row"><font size="1">{{ training.last_activity }}</font></div>
            </div>
        </div>

        <br>
        <router-link to="/trainings/create"> Add training game </router-link><br>
    </div>

</template>

<script>
    import { mapActions, mapState, mapMutations } from 'vuex';

    export default {
        data() {
            return {

            }
        },
        mounted() {
            this.setPageName('Trainings');
            this.setPageDescription('');
            this.fetchTrainings();
        },
        computed: mapState(['trainings']),
        methods: {

            ...mapActions(['fetchTrainings']),

            ...mapMutations([
                'setPageName',
                'setPageDescription'
            ]),

            showGame(training) {
                this.$store.commit('setCurrentTrainingId', training.id);
                this.$router.push('/trainings/show');
            },
        }
    }
</script>


<style>
    .game {
        margin: 20px;
        cursor: pointer;
    }
    .game:hover {
        background: #e8e8e8;
    }
    a.disabled {
        pointer-events: none;
    }
</style>