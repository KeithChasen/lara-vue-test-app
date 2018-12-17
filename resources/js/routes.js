
import Home from './components/Home';
import Login from './components/auth/Login'

import UsersMain from './components/users/Main'
import UsersList from './components/users/List'
import NewUser from './components/users/New'
import User from './components/users/View'

import PhotosMain from './components/photos/Main'
import PhotosList from './components/photos/List'
import NewPhoto from './components/photos/New'
import Photo from './components/photos/View'

export const routes = [
    {
        path: '/',
        component: Home,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/login',
        component: Login
    },
    {
        path: '/users',
        component: UsersMain,
        meta: {
            requiresAuth: true
        },
        children: [
            {
                path: '/',
                component: UsersList
            },
            {
                path: 'new',
                component: NewUser
            },
            {
                path: ':id',
                component: User
            }
        ]
    },

    {
        path: '/photos',
        component: PhotosMain,
        meta: {
            requiresAuth: true
        },
        children: [
            {
                path: '/',
                component: PhotosList
            },
            {
                path: 'new',
                component: NewPhoto
            },
            {
                path: ':id',
                component: Photo
            }
        ]
    }
];
