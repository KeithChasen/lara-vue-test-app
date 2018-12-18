import {getLocalUser} from "./auth";

const user = getLocalUser();

export default {
    state: {
        currentUser: user,
        isLoggedIn: !!user,
        loading: false,
        auth_error: null,
        isAdmin: user ? user.role.role === 'admin' : false,
        users: [],
        photos: []
    },
    getters: {
        isLoggedIn: state => state.isLoggedIn,
        currentUser: state => state.currentUser,
        authError: state => state.auth_error,
        users: state => state.users,
        photos: state => state.photos,
        isAdmin: state => state.isAdmin
    },
    mutations: {
        login: state => {
            state.loading = true;
            state.auth_error = null;
        },
        loginSuccess: (state, payload) => {
            state.auth_error = null;
            state.isLoggedIn = true;
            state.loading = false;
            state.currentUser = Object.assign(
                {},
                payload.user,
                {token: payload.access_token}
            );

            localStorage.setItem('user', JSON.stringify(state.currentUser));
        },
        loginFailed: (state, payload) => {
            state.loading = false;
            state.auth_error = payload.error;
        },
        logout: state => {
            localStorage.removeItem('user');
            state.isLoggedIn = false;
            state.currentUser = null;
            state.isAdmin = false;
        },
        updateUsers: (state, payload) => {
            state.isAdmin = true;
            state.users = payload
        },
        deleteUser: (state, user) => {
            state.isAdmin = true;
            let index = state.users.indexOf(user);
            state.users.splice(index, 1);
        }
},
    actions: {
        login: context => context.commit('login'),

        getUsers: context => axios.get('/api/users')
            .then((response) => {
                if (response.status === 200) {
                    context.commit('updateUsers', response.data.users)
                }
            })
            .catch((error) => { context.commit('logout') }),

        removeUser: (context, user) =>
            axios.delete(`/api/users/${user.id}`)
            .then((response) => {
                if (response.status === 200) {
                     context.commit('deleteUser', user)
                }
            })
            .catch((error) => { context.commit('logout') }),
    }
}
