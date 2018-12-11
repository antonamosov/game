<template>
    <div id="notifications">
        <span v-if="notifications.length === 0">...</span>
        <div
                class="row invite"
                v-for="notification in notifications"
        >
            <div class="col-md-3">
                <img :src="notification.user_image">
            </div>
            <div class="col-md-9">
                <div class="row">
                    <span v-if="notification.status === 'waiting'">
                        {{ notification.user }} sent you new invite
                    </span>
                    <span v-else-if="notification.status === 'accepted'">
                        {{ notification.user }} available for {{ notification.category }}
                    </span>
                    <span v-else-if="notification.status === 'rejected'">
                        You unlocked a new {{ notification.category }}
                    </span>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        {{ notification.time }}
                    </div>
                    <div
                            v-if="notification.status === 'waiting'"
                            class="col-md-8"
                    >
                        <a class="btn btn-success btn-xs" @click="accept(notification)">Accept</a>
                        <a class="btn btn-success btn-xs" @click="reject(notification)">Reject</a>
                    </div>
                </div>
            </div>
        </div>

        <a @click="clearAll()"> Clear All </a><br>
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
            this.setPageName('Notifications');
            this.setPageDescription('');
            this.fetch();
        },
        computed: mapState(['notifications']),
        methods: {

            ...mapMutations([
                'setPageName',
                'setPageDescription',
                ]),

            ...mapActions({
                fetch: 'fetchNotifications',
                accept: 'acceptNotification',
                reject: 'rejectNotification',
                clearAll: 'clearAllNotifications',
            }),
        }
    }
</script>

<style>
    .invite {
        padding: 20px;
        border: solid grey 1px;
    }

    a {
        cursor: pointer;
    }

</style>


