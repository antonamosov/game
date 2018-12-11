<template>
    <div id="shop">
        <span v-if="packs.length === 0">Loading....</span>
        <div
                class="notification"
                v-for="(info, key) in infos"
                :key="(key)"
        >{{ info }}</div>
        <table :class="{ packs: packs.length !== 0 }">
            <tr v-show="packs.length !== 0">
                <th> Pack Image </th>
                <th> Pack Name </th>
                <th> Categories </th>
                <th> Price (coins) </th>
                <th> Price ($) </th>
                <th> Buy </th>
                <th> Add to cart </th>
            </tr>
            <tr
                    v-for="pack in packs"
                    :key="pack.id"
            >
                <td><img :src="pack.image"></td>
                <td> {{ pack.name }} </td>
                <td>
                    <p v-for="category in pack.categories">
                        {{ category.name }}
                    </p>
                </td>
                <td> {{ pack.coins_price }} </td>
                <td> {{ pack.price }} </td>
                <td>
                    <button @click="buyPack(pack)"> Buy by coins </button>
                </td>
                <td>
                    <button @click="addToCart(pack)"> Add to cart </button>
                </td>
            </tr>
        </table>
        <router-link to="/"> Profile </router-link><br>
        <router-link to="/cart"> Cart </router-link><br>
    </div>
</template>

<script>
    import { mapActions, mapState, mapMutations } from 'vuex';

    export default {
        data() {
            return {
                infos: []
            }
        },
        mounted() {
            this.setPageName('QUIZES');
            this.setPageDescription('Choose Your Path');
            this.fetchPacks();
        },
        computed: mapState([
            'packs',
            'errorMessage',
        ]),
        methods: {

            ...mapActions([
                'fetchPacks',
                'buyPackByCoins',
            ]),

            ...mapMutations([
                'setPageName',
                'setPageDescription',
            ]),

            addToCart(pack) {
                this.$store.commit('addPackToCart', pack);
                const info = pack.name + ' added to cart';
                this.infos.push(info);
                setTimeout(() => this.infos.splice(this.infos.indexOf(info), 1), 3000)
            },

            buyPack(pack) {
                this.buyPackByCoins(pack.id).then(() => {
                    if (this.errorMessage) {
                        this.infos.push(this.errorMessage);
                        setTimeout(() => this.infos.splice(this.infos.indexOf(this.errorMessage), 1), 3000);
                    }
                    else {
                        const info = pack.name + ' was bought';
                        this.infos.push(info);
                        setTimeout(() => this.infos.splice(this.infos.indexOf(info), 1), 3000);
                    }
                });
            }
        }
    }
</script>

<style>
    .packs {
        border: 1px solid #ddd;
        margin: auto;
    }

    .packs td,
    th {
        border: 1px solid #ddd;
        padding: 10px;
    }

    .notification {
        position: fixed;
        background-color: #ddd;
        padding: 20px;
        width: 200px;
        top: 20vh;
        right: 10vh;
    }

    button {
        border: none;
        cursor: pointer;
        padding: 5px 10px;
    }
</style>
