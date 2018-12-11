<template>
    <div id="finish">

        <div class="row image">
            <img :src="game.user_image">
        </div>

        <div class="row text">
            <h1>Congrats!</h1>
            <p>You won a game & earned +{{ game.earned_coins }} free coins!</p>
        </div>

        <div class="row">
            <router-link to="/games/show"> Share results </router-link><br>
            <router-link to="/games/create/opponent"> Take new Quiz </router-link>
        </div>

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
            this.setPageName('Finish');
            this.setPageDescription('');
            this.fetchGame();
        },
        computed: mapState(['game']),
        methods: {

            ...mapActions(['fetchGame']),

            ...mapMutations([
                'setPageName',
                'setPageDescription'
            ]),
        }
    }
</script>


<style>

</style>