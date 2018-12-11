<template>
    <div id="createTraining">
        <span v-if="categories.length === 0">....</span>
        <div
                class="row"
                v-else=""
        >
            <div
                    class="col-md-4 category"
                    v-for="category in categories"
                    @click="chooseCategory(category)"
            >
                <p><img :src="category.image"></p>
                <p><font size="3">{{ category.name }}</font></p>
                <p><font size="2">{{ category.description }}</font></p>
                <p><font size="1">{{ category.price }}</font></p>
                <p v-if="category.disabled"><font size="1"><a @click="unLock(category)">Unlock</a></font></p>
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
        computed: mapState({
            categories : 'categories',
            training : 'training'
        }),
        methods: {

            ...mapActions({
                fetchCategories : 'fetchCategories',
                createGame : 'createTraining',
                fetchTraining : 'fetchTraining'
            }),

            ...mapMutations([
                'setPageName',
                'setPageDescription'
            ]),

            chooseCategory(category) {
                if (! category.disabled) {
                    this.$store.commit('addCategoryIdToCreatingGame', category.id);
                    this.createGame().then(() => {
                        this.fetchTraining().then(() => {
                            this.$router.push('/trainings/question');
                        });
                    });
                }
                else {
                    console.log('Category is disabled.');
                }
            },

            unLock(category) {
                this.$router.push('/shop');
            }
        }
    }
</script>


<style>
    .category:hover {
        cursor: pointer;
        background: #e8e8e8;
    }
</style>