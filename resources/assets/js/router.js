import Vue from 'vue';
import Router from 'vue-router';

Vue.use(Router);

import shop from './components/Shop.vue';
import cart from './components/Cart.vue';
import profile from './components/Profile.vue';
import earnCoins from './components/EarnCoins.vue';
import friends from './components/Friends.vue';
import openGames from './components/OpenGames.vue';
import chooseOpponent from './components/ChooseOpponent.vue';
import choosePath from './components/ChoosePath.vue';
import notifications from './components/Notifications.vue';
import gameStats from './components/GameStats.vue';
import question from './components/Question.vue';
import finish from './components/GameFinish.vue';
import trainings from './components/Trainings';
import createTraining from './components/CreateTraining.vue';
import trainingStats from './components/TrainingStats.vue';
import trainingQuestion from './components/TrainingQuestion.vue';

export default new Router({
    mode: 'history',
    routes: [
        {
            component: profile,
            path: '/'
        },
        {
            component: shop,
            path: '/shop'
        },
        {
            component: cart,
            path: '/cart'
        },
        {
            component: earnCoins,
            path: '/coins/earn'
        },
        {
            component: friends,
            path: '/friends'
        },
        {
            component: openGames,
            path: '/games/open'
        },
        {
            component: gameStats,
            path: '/games/show'
        },
        {
            component: chooseOpponent,
            path: '/games/create/opponent'
        },
        {
            component: choosePath,
            path: '/games/create/path'
        },
        {
            component: trainings,
            path: '/trainings'
        },
        {
            component: createTraining,
            path: '/trainings/create'
        },
        {
            component: trainingStats,
            path: '/trainings/show'
        },
        {
            component: trainingQuestion,
            path: '/trainings/question'
        },
        {
            component: question,
            path: '/games/question'
        },
        {
            component: finish,
            path: '/games/finish'
        },
        {
            component: notifications,
            path: '/notifications'
        },
    ]
});
