<template>
    <div id="gameStats">
        <span v-if="game.length === 0">...</span>

        <div class="row">{{ game.category }}</div>

        <div class="row header">
            <div class="col-md-4">
                <div class="row">
                    <img :src="game.user_image">
                </div>
                <div class="row">
                    {{ game.user_name }}
                </div>
            </div>
            <div class="col-md-4">
                {{ game.user_glasses }} - {{ game.opponent_glasses }}
            </div>
            <div class="col-md-4">
                <div class="row">
                    <img :src="game.opponent_image">
                </div>
                <div class="row">
                    {{ game.opponent_name }}
                </div>
            </div>
        </div>

        <div
                class="row round"
                v-for="round in game.rounds"
        >
            <div class="col-md-5">
                <button
                        v-for="turn in round.user_turns"
                        class="btn btn-sm"
                        :class="turnColorClass(turn)"
                >
                </button>
            </div>
            <div class="col-md-2">
                Round {{ round.number }}
            </div>
            <div class="col-md-5">
                <button
                        v-for="turn in round.opponent_turns"
                        class="btn btn-sm"
                        :class="turnColorClass(turn)"
                >
                </button>
            </div>
        </div>

        <router-link v-if="isUserTurn() && gameIsActive()" to="/games/question"> Continue game </router-link>
        <p v-else-if="gameIsActive()">Waiting for an opponent turn...</p>
        <p v-else-if="gameIsFinished()">Game is finished.</p><br>
        <router-link to="/games/open"> Open Games </router-link><br>
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
            this.setPageName('Game Stats');
            this.setPageDescription('');
            this.fetchGame();
            if (! this.gameIsFinished()) {
                this.interval = setInterval(function () {
                    this.fetchGame().then(() => {
                        if (this.gameIsFinished() && this.isVictory()) {
                            this.$router.push('/games/finish');
                        }
                    });
                }.bind(this), 15000);
            }
        },
        computed: mapState(['game']),
        methods: {

            ...mapActions(['fetchGame']),

            ...mapMutations([
                'setPageName',
                'setPageDescription'
            ]),

            ...mapGetters([
                'gameIsFinished',
                'gameIsActive',
                'isUserTurn',
                'isVictory'
            ]),

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