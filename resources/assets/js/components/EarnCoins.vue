<template>
    <div id="shop">
        <span v-if="products.length === 0">Loading....</span>
        <div
                class="notification"
                v-for="(info, key) in infos"
                :key="(key)"
        >{{ info }}</div>
        <table :class="{ products: products.length !== 0 }">
            <tr v-show="products.length !== 0">
                <th> Count of coins </th>
                <th> Price </th>
                <th> Buy </th>
            </tr>
            <tr
                    v-for="product in products"
                    :key="product.id"
            >
                <td> {{ product.coins }} </td>
                <td> ${{ product.price }} </td>
                <td>
                    <button @click="addToCart(product)"> Add to Cart </button>
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
            this.setPageName('Earn coins');
            this.setPageDescription('');
            this.fetchProducts();
        },
        computed: mapState(['products']),
        methods: {

            ...mapActions(['fetchProducts']),

            ...mapMutations([
                'setPageName',
                'setPageDescription'
            ]),

            addToCart(product) {
                this.$store.commit('addProductToCart', product);
                const info = product.coins + ' coins added to cart';
                this.infos.push(info);
                setTimeout(() => this.infos.splice(this.infos.indexOf(info), 1), 3000)
            }
        }
    }
</script>

<style>
    .products {
        border: 1px solid #ddd;
        margin: auto;
    }

    .products td,
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
