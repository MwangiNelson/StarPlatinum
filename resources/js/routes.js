import Landing from './screens/Landing.vue'
import ItemView from './screens/ItemView.vue'

const routes = [
    {
        path: '/',
        name: 'home',
        component: Landing
    },
    {
        path: '/todos/:id',
        name: 'todos',
        component: ItemView
    }
]

export default routes