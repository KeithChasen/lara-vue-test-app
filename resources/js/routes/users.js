import UsersList from '../components/users/List'
import NewUser from '../components/users/New'
import UserEdit from '../components/users/Edit'

export const users = [
    {
        path: '/',
        component: UsersList
    },
    {
        path: 'new',
        component: NewUser
    },
    {
        path: 'edit/:id',
        component: UserEdit
    }
];
