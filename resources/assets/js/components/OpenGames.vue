<template>
    <div id="friends">
        <span v-if="games.length === 0">Loading....</span>
        <div
                class="row game"
                v-for="game in games"
                v-if="game.user_turn === visibleUserTurnGames"
                @click="showGame(game)"
        >
            <div class="col-md-3">
                <img :src="game.opponent_image">
            </div>
            <div class="col-md-8">
                <div class="row"><font size="3">{{ game.opponent_name }}</font></div>
                <div class="row"><font size="2">{{ game.category_name }}</font></div>
                <div class="row"><font size="1">{{ game.last_activity }}</font></div>
            </div>
        </div>
        <a href="#" :class="{ disabled: visibleUserTurnGames }" @click="showUserTurnGames">Your turn</a><br>
        <a href="#" :class="{ disabled: visibleOpponentTurnGames }" @click="showOpponentTurnGames">Their turn</a><br>
        <router-link to="/games/create/opponent"> Add game with friend </router-link><br>
        <router-link to="/trainings/create"> Add training game </router-link><br>
    </div>

</template>

<script>
    import { mapActions, mapState, mapMutations } from 'vuex';

    export default {
        data() {
            return {
                visibleUserTurnGames : true,
                visibleOpponentTurnGames : false
            }
        },
        mounted() {
            this.setPageName('Game Lobby');
            this.setPageDescription('');
            this.fetchGames();
        },
        computed: mapState(['games']),
        methods: {

            ...mapActions(['fetchGames']),

            ...mapMutations([
                'setPageName',
                'setPageDescription'
            ]),

            showUserTurnGames() {
                this.visibleUserTurnGames = true;
                this.visibleOpponentTurnGames = false;
            },

            showOpponentTurnGames() {
                this.visibleUserTurnGames = false;
                this.visibleOpponentTurnGames = true;
            },

            showGame(game) {
                this.$store.commit('setCurrentGameId', game.id);
                this.$router.push('/games/show');
            },
        }
    }
</script>


<style>
    .game {
        margin-bottom: 20px;
        cursor: pointer;
    }
    .game:hover {
        background: #e8e8e8;
    }
    a.disabled {
        pointer-events: none;
    }
</style>