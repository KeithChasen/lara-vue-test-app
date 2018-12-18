import UsersMain from '../components/users/Main'
import {users} from "./users";
import PhotosMain from '../components/photos/Main'
import {photos} from "./photos";

export const admin = [
    {
        path: 'users',
        component: UsersMain,
        meta: {
            requiresAuth: true
        },
        children: users
    },
    {
        path: 'photos',
        component: PhotosMain,
        meta: {
            requiresAuth: true
        },
        children: photos
    }
];
