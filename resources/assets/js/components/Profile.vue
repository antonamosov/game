<template>
    <div id="profile">
        <div class="row">
            <img :src="user.image">
        </div>
        <p>{{ user.name }}</p>
        <p>{{ user.coins }} Coins</p>
        <p v-if="user.password">Password: {{ user.password }}</p>

        <router-link to="/shop"> Quizez </router-link><br>
        <router-link to="/games/open"> Open Games </router-link><br>
        <router-link to="/trainings"> Trainings </router-link><br>
        <router-link to="/friends"> My friends </router-link><br>
        <router-link to="/notifications"> Notifications </router-link><br>
        <router-link to="/coins/earn"> Earn Coins </router-link><br>
        <a @click="logout">Logout</a>
        <form id="logout-form"
              action="/logout"
              method="POST"
              style="display: none;"
        >
        </form>
    </div>
</template>

<script>
    import shop from './Shop.vue';
    import cart from './Cart.vue';
    import { mapActions, mapState, mapMutations } from 'vuex';


    export default {

        components: {
            shop,
            cart
        },

        computed: mapState(['user']),

        data() {
            return {
                msg: 'Shopping Cart',
            }
        },

        mounted() {
            this.setPageName('Side Menu-Dark');
            this.setPageDescription('');
            this.fetchUser();
        },

        methods: {
            ...mapActions(['fetchUser']),
            ...mapMutations([
                'setPageName',
                'setPageDescription'
            ]),
            logout(e) {
                e.preventDefault();
                document.getElementById('logout-form').submit()
            },
        }
    }
</script>