
import PhotosList from '../components/photos/List'
import NewPhoto from '../components/photos/New'
import EditPhoto from '../components/photos/Edit'

export const photos = [
    {
        path: '/',
        component: PhotosList
    },
    {
        path: 'new',
        component: NewPhoto
    },
    {
        path: 'edit/:id',
        component: EditPhoto
    }
]
