import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex);

export default new Vuex.Store({

    state : {
        cart: [],
        packs: [],
        products: [],
        user : {},
        friends : [],
        games : [],
        pageName : '',
        pageDescription : '',
        creatingGame : {
            friendId : false,
            categoryId : false
        },
        categories : [],
        notifications : [],
        game : {},
        currentGameId : false,
        question : {},
        trainings : [],
        training : {},
        currentTrainingId : false,
        cartId : false,
        errorMessage : false,
    },

    mutations: {

        setPageName(state, name) {
            state.pageName = name;
        },

        setPageDescription(state, description) {
            state.pageDescription = description;
        },

        setPacks(state, packs) {
            state.packs = packs;
        },

        setProducts(state, products) {
            state.products = products;
        },

        setUser(state, user) {
            state.user = user;
        },

        setFriends(state, friends) {
            state.friends = friends;
        },

        setGames(state, games) {
            state.games = games;
        },

        setTrainings(state, trainings) {
            state.trainings = trainings;
        },

        setCategories(state, categories) {
            state.categories = categories;
        },

        addPackToCart({ cart, packs }, pack) {
            const itemIndex = cart.findIndex(item => item.id === pack.id);
            console.log(itemIndex);

            if (itemIndex === -1) {
                console.log('push');
                cart.push({ ...pack, count: 1, type: 'pack' });
            } else {
                cart[itemIndex].count++;
                console.log('count');
            }
        },

        addProductToCart({ cart, products }, product) {
            const itemIndex = cart.findIndex(item => item.id === product.id);

            if (itemIndex === -1) {
                cart.push({ ...product, count: 1, type: 'product' });
            } else {
                cart[itemIndex].count++;
            }
        },

        removeItemFromCart({ cart }, pack) {
            const itemIndex = cart.findIndex(item => item.id === pack.id);

            cart.splice(itemIndex, 1);
        },

        clearCart(state) {
            state.cart = [];
        },

        addFriendIdToCreatingGame({ creatingGame }, friendId) {
            creatingGame.friendId = friendId;
        },

        addCategoryIdToCreatingGame({ creatingGame }, categoryId) {
            creatingGame.categoryId = categoryId;
        },

        setNotifications(state, notifications) {
            state.notifications = notifications;
        },

        acceptNotification(state, notification) {
            const itemIndex = state.notifications.findIndex(item => item.id === notification.id);
            state.notifications[itemIndex].status = 'accepted';
        },

        rejectNotification(state, notification) {
            const itemIndex = state.notifications.findIndex(item => item.id === notification.id);
            state.notifications[itemIndex].status = 'rejected';
        },

        clearAllNotifications(state) {
            state.notifications = [];
        },

        setGame(state, game) {
            state.game = game;
        },

        setTraining(state, training) {
            state.training = training;
        },

        setCurrentGameId(state, gameId) {
            state.currentGameId = gameId;
        },

        setCurrentTrainingId(state, trainingId) {
            state.currentTrainingId = trainingId;
        },

        setQuestion(state, question) {
              state.question = question;
        },

        updateGame({ game }, rightAnswer) {
            game.user_turn = false;
            const roundIndex = game.rounds.findIndex(round => round.number === game.round_number);
            const turnIndex = game.rounds[roundIndex].user_turns.findIndex(turn => turn.number === game.turn_number);
            if (rightAnswer) {
                game.user_glasses = game.user_glasses + 1;
                game.rounds[roundIndex].user_turns[turnIndex].status = 'right';
            }
            else {
                game.rounds[roundIndex].user_turns[turnIndex].status = 'wrong';
            }
        },

        setCartId(state, cartId) {
            state.cartId = cartId;
        },

        setErrorMessage(state, error) {
            state.errorMessage = error;
        },
    },

    actions: {

        fetchPacks({ commit }) {
            axios.get(`/api/packs`)
                .then(response => {
                    commit('setPacks', response.data.data);
                });
        },

        fetchUser({ commit }) {
            axios.get(`/api/profile`)
                .then(response => {
                    commit('setUser', response.data.data);
                });
        },

        fetchProducts({ commit }) {
            axios.get(`/api/products`)
                .then(response => {
                    commit('setProducts', response.data.data);
                });
        },

        fetchFriends({ commit }) {
            axios.get(`/api/friends`)
                .then(response => {
                    commit('setFriends', response.data.data);
                });
        },

        fetchGames({ commit }) {
            axios.get(`/api/games`)
                .then(response => {
                    commit('setGames', response.data.data);
                });
        },

        fetchTrainings({ commit }) {
            axios.get(`/api/trainings`)
                .then(response => {
                    commit('setTrainings', response.data.data);
                });
        },

        fetchCategories({ commit }) {
            axios.get(`/api/categories`)
                .then(response => {
                    commit('setCategories', response.data.data);
                });
        },

        createGame({ state }) {
            axios.post(`/api/games`, {
                opponent_id : state.creatingGame.friendId,
                category_id : state.creatingGame.categoryId
            });
        },

        createTraining(context) {
            return new Promise ((resolve, reject) => {
                axios.post(`/api/trainings`, {
                    category_id : context.state.creatingGame.categoryId
                }).then(response => {
                    context.commit('setCurrentTrainingId', response.data.data.id);
                    resolve();
                });
            });
        },

        fetchNotifications({ commit }) {
            axios.get(`/api/notifications`)
                .then(response => {
                    commit('setNotifications', response.data.data);
                });
        },

        acceptNotification({ commit }, notification) {
            axios.put(`/api/notifications/` + notification.id + `/accept`)
                .then(response => {
                    commit('acceptNotification', notification);
                })
        },

        rejectNotification({ commit }, notification) {
            axios.put(`/api/notifications/` + notification.id + `/reject`)
                .then(response => {
                    commit('rejectNotification', notification);
                });
        },

        clearAllNotifications({ commit }) {
            axios.delete(`/api/notifications`)
                .then(response => {
                    commit('clearAllNotifications');
                });
        },

        fetchGame(context) {
            return new Promise ((resolve, reject) => {
                axios.get(`/api/games/` + context.state.currentGameId)
                    .then(response => {
                        context.commit('setGame', response.data.data);
                        resolve();
                    });
            });
        },

        fetchTraining(context) {
            return new Promise ((resolve, reject) => {
                axios.get(`/api/trainings/` + context.state.currentTrainingId)
                    .then(response => {
                        context.commit('setTraining', response.data.data);
                        resolve();
                    });
            });
        },

        fetchQuestion(context) {
            axios.get(`/api/games/` + context.state.currentGameId + `/question/get`)
                .then(response => {
                    context.commit('setQuestion', response.data.data);
                });
        },

        fetchTrainingQuestion(context) {
            return new Promise ((resolve, reject) => {
                axios.get(`/api/games/` + context.state.currentTrainingId + `/question/get`)
                    .then(response => {
                        context.commit('setQuestion', response.data.data);
                        resolve();
                    });
            });
        },

        answer(context, answer) {
            return new Promise ((resolve, reject) => {
                axios.post(`/api/games/` + context.state.currentGameId + `/answer/check`, { answer: answer })
                    .then(response => {
                        context.dispatch('fetchGame').then(() => {
                            resolve();
                        });
                    });
            });
        },

        trainingAnswer(context, answer) {
            return new Promise ((resolve, reject) => {
                axios.post(`/api/games/` + context.state.currentTrainingId + `/answer/check`, { answer: answer })
                    .then(response => {
                        resolve();
                    });
            });
        },

        createCart(context) {
            return new Promise ((resolve, reject) => {
                axios.post(`/api/cart`, { cart: JSON.stringify(context.state.cart) })
                    .then(response => {
                        context.commit('setCartId', response.data.data.id);
                        resolve();
                    });
            });
        },

        buyPackByCoins(context, packId) {
            return new Promise ((resolve, reject) => {
                context.commit('setErrorMessage', false);
                axios.post(`/api/packs/` + packId + `/buy`)
                    .then(response => {
                        if (! response.data.success) {
                            context.commit('setErrorMessage', response.data.error);
                        }
                        resolve();
                    });
            });
        },
    },

    getters: {

        totalAmount: state => {
            let amount = 0;

            state.cart.forEach(item => (amount += item.price * item.count));

            return amount;
        },

        gameIsFinished: state => {

            return state.game.status === 'finished';
        },

        gameIsActive: state => {

            return state.game.status === 'active';
        },

        isUserTurn: state => {

            return state.game.user_turn;
        },

        isVictory: state => {

            return state.game.victory
        },

        trainingIsFinished: state => {

            return state.training.status === 'finished';
        },

        payPalItemName: state => {
            let name = '';

            state.cart.forEach(item => (name += item.name + '+'));

            return name;
        },

        userId: state => {
            return state.user.id;
        },
    }
})
