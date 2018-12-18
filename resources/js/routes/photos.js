
import PhotosList from '../components/photos/List'
import NewPhoto from '../components/photos/New'
import Photo from '../components/photos/View'

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
        path: ':id',
        component: Photo
    }
]
