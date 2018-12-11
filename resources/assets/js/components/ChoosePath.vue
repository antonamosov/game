<template>
    <div id="choosePath">
        <span v-if="categories.length === 0">Loading....</span>
        <div
                class="row"
                v-else=""
        >
            <div
                    class="col-md-4 category"
                    v-for="category in categories"
                    @click="chooseCategory(category.id)"
            >
                <p><img :src="category.image"></p>
                <p><font size="3">{{ category.name }}</font></p>
                <p><font size="2">{{ category.description }}</font></p>
            </div>
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
            this.setPageName('Quizes');
            this.setPageDescription('');
            this.fetchCategories();
        },
        computed: mapState(['categories']),
        methods: {

            ...mapActions([
                'fetchCategories',
                'createGame'
            ]),

            ...mapMutations([
                'setPageName',
                'setPageDescription'
            ]),

            chooseCategory(categoryId) {
                this.$store.commit('addCategoryIdToCreatingGame', categoryId);
                this.createGame();
                this.$router.push('/games/open');
            },
        }
    }
</script>


<style>
    .category:hover {
        cursor: pointer;
        background: #e8e8e8;
    }
</style>