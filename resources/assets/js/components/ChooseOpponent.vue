<template>
    <div id="chooseOpponent">
        <div class="row">
            <div
                    class="col-md-4 friend"
                    v-for="friend in friends"
                    @click="chooseFriend(friend.id)"
            >
                <p><img :src="friend.image"></p>
                <p>{{ friend.name }}</p>
                <p>{{ friend.points }}</p>
            </div>
        </div>
        <a
                class="link"
                @click="chooseRandomFriend()"
        >Choose Random Friend</a><br>
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
            this.fetchFriends();
        },
        computed: mapState(['friends']),
        methods: {

            ...mapActions(['fetchFriends']),

            ...mapMutations([
                'setPageName',
                'setPageDescription'
            ]),

            chooseFriend(friendId) {
                this.$store.commit('addFriendIdToCreatingGame', friendId);
                this.$router.push('/games/create/path');
            },

            chooseRandomFriend() {
                let randomFriend = this.friends[Math.floor(Math.random() * this.friends.length)];
                this.$store.commit('addFriendIdToCreatingGame', randomFriend.id);
                this.$router.push('/games/create/path');
            },
        }
    }
</script>


<style>
    .friend:hover {
        cursor: pointer;
        background: #e8e8e8;
    }
    .link {
        cursor: pointer;
    }
</style>