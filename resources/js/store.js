import {getLocalUser} from "./auth";

const user = getLocalUser();

export default {
    state: {
        currentUser: user,
        isLoggedIn: !!user,
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
        login: state => state.auth_error = null,

        loginSuccess: (state, payload) => {
            state.auth_error = null;
            state.isLoggedIn = true;
            state.currentUser = Object.assign(
                {},
                payload.user,
                {token: payload.access_token}
            );

            localStorage.setItem('user', JSON.stringify(state.currentUser));
        },

        loginFailed: (state, payload) => state.auth_error = payload.error,

        logout: state => {
            localStorage.removeItem('user');
            state.isLoggedIn = false;
            state.currentUser = null;
        },

        updateUsers: (state, payload) => state.users = payload,

        updatePhotos: (state, payload) => state.photos = payload,

        deleteUser: (state, user) => {
            let index = state.users.indexOf(user);
            state.users.splice(index, 1);
        },

        deletePhoto: (state, photo) => {
            let index = state.photos.indexOf(photo);
            state.photos.splice(index, 1);
        },
},
    actions: {
        login: context => context.commit('login'),

        getUsers: context => axios.get('/api/users')
            .then((response) => {
                if (response.status === 200) {
                    context.commit('updateUsers', response.data.users)
                }
            })
            .catch((error) => {  }),

        removeUser: (context, user) =>
            axios.delete(`/api/users/${user.id}`)
            .then((response) => {
                if (response.status === 200) {
                     context.commit('deleteUser', user)
                }
            })
            .catch((error) => {  }),

        getPhotos: context => axios.get('/api/photos')
            .then((response) => {
                if (response.status === 200) {
                    context.commit('updatePhotos', response.data.photos)
                }
            })
            .catch((error) => {  }),

        removePhoto: (context, photo) =>
            axios.delete(`/api/photos/${photo.id}`)
                .then((response) => {
                    if (response.status === 200) {
                        context.commit('deletePhoto', photo)
                    }
                })
                .catch((error) => {  }),
    }
}
