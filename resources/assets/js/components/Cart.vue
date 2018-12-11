<template>
    <div id="cart">
        <form id="form" action="https://www.sandbox.paypal.com/cgi-bin/websc" method="post">

            <ul>
                <li
                        v-for="item in cart"
                        :key="item.id"
                >
                    <span
                            v-if="item.type === 'pack'"
                            class="item-name"
                    >{{ item.name }}
                        <button @click="removeItemFromCart(item)">x</button>
                    </span>
                    <span
                            v-else=""
                            class="item-name"
                    >{{ item.coins }} coins
                        <button @click="removeItemFromCart(item)">x</button>
                    </span>
                    <span class="item-count"> x {{ item.count }}</span>
                    <span class="item-amount"> = {{ formatCurrency(item.price * item.count) }}</span>
                </li>
            </ul>
            <div v-if="cart.length === 0">
                <h2> No item :( </h2>
            </div>

            <div v-else>
                <div class="total-amount">Total: {{formatCurrency(totalAmount)}}</div>
                <a @click="clearCart"> Clear All </a><br>
                <a @click="checkout"> Checkout </a><br>
            </div>

            <input type="hidden" name="cmd" value="_xclick">
            <input type="hidden" name="business" :value="payPal.business">
            <input type="hidden" name="item_name" :value="payPalItemName">
            <input type="hidden" name="quantity" value="1">
            <input type="hidden" readonly="readonly" id="paypalAmmount" name="amount" :value="formatPrice(totalAmount)">
            <input type="hidden" name="no_shipping" value="1">
            <input type="hidden" name="item_number" :value="cartId">
            <input type="hidden" name="return" :value="payPal.returnUrl">
            <input type="hidden" name="notify_url" :value="payPal.notifyUrl">
            <input type="hidden" name="cancel_url" :value="payPal.cancelUrl">
            <input type="hidden" name="custom" :value="userId">
            <input type="hidden" name="currency_code" :value="payPal.currencyCode">
            <input type="hidden" name="lc" value="US">
            <input type="hidden" name="bn" value="PP-BuyNowBF">

        </form>

        <router-link to="/"> Profile </router-link><br>
        <router-link to="/shop"> Quizez </router-link><br>
        <router-link to="/coins/earn"> Earn Coins </router-link><br>
    </div>
</template>

<script>
    import { mapGetters, mapState, mapMutations, mapActions } from 'vuex';

    export default {
        data() {
            return {
                payPal : {
                    business : 'amosaa-facilitator@mail.ru',
                    currencyCode : 'RUB',
                    returnUrl : 'http://quizgame.ptz-team.ru/return',
                    notifyUrl : 'http://quizgame.ptz-team.ru/ipn',
                    cancelUrl : 'http://quizgame.ptz-team.ru/cancel'
                },
            }
        },
        mounted() {
            this.setPageName('Cart');
            this.setPageDescription('');
        },
        computed: {
            ...mapState([
                'cart',
                'cartId'
            ]),
            ...mapGetters([
                'totalAmount',
                'payPalItemName',
                'userId'
            ])
        },
        methods: {

            ...mapMutations([
                'deductItemCount',
                'removeItemFromCart',
                'clearCart',
                'setPageName',
                'setPageDescription'
            ]),

            ...mapActions(['createCart']),

            checkout() {
                this.createCart().then(() => {
                    this.clearCart();
                    this.submitForm();
                });
            },

            submitForm() {
                $('#form').submit();
            },

            formatCurrency(price) {
                return '$' + price.toFixed(2)
            },

            formatPrice(price) {
                return price.toFixed(2)
            },
        }
    }
</script>

<style>
    ul {
        list-style: none;
    }

    li {
        display: flex;
        max-width: 700px;
        margin: auto;
        margin-top: 10px;
    }

    .item-name {
        text-align: left;
        font-size: 18px;
        flex: 2;
    }

    .item-count {
        font-size: 25px;
        margin-left: 10px;
        flex: 2;
    }

    .item-amount {
        text-align: left;
        flex: 1;
    }

    .total-amount {
        border-top: 2px solid #333;
        border-bottom: 2px solid #333;
        padding: 10px 20% 10px 10px;
        margin: 10px;
        font-size: 29px;
        text-align: right;
    }

    button {
        border: none;
        cursor: pointer;
        padding: 5px 10px;
    }
</style>

