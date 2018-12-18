
import Home from '../components/Home';
import Login from '../components/auth/Login'
import AdminMain from '../components/AdminMain'
import {admin} from "./admin";

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
        path: '/admin',
        component: AdminMain,
        meta: {
            requiresAuth: true
        },
        children: admin
    }
];
