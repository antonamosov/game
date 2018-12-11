<template>
    <div id="friends">
        <span v-if="friends.length === 0">...</span><br>
        <div class="row">
            <div
                    class="col-md-4"
                    v-for="friend in friends"
            >
                <p><img :src="friend.image"></p>
                <p>{{ friend.name }}</p>
                <p>{{ friend.points }}</p>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapActions, mapState, mapMutations } from 'vuex';

    export default {
        mounted() {
            this.setPageName('My friends');
            this.setPageDescription('');
            this.fetchFriends();
        },
        computed: mapState(['friends']),
        methods: {

            ...mapActions(['fetchFriends']),

            ...mapMutations([
                'setPageName',
                'setPageDescription'
            ]),
        }
    }
</script>
