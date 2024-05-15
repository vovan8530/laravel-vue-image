import { createRouter, createWebHistory } from "vue-router";



const routes = [
    {path: '/posts', component: () => import('./components/Posts/IndexComponent.vue'), name: 'posts.index'},
    {path: '/posts/store', component: () => import('./components/Posts/StoreComponent.vue'), name: 'posts.store'},
    {path: '/posts/:id/edit', component: () => import('./components/Posts/EditComponent.vue'), name: 'posts.edit'},
    {path: '/posts/:id', component: () => import('./components/Posts/ShowComponent.vue'), name: 'posts.show'},
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

export default router
