import { createRouter, createWebHistory } from "vue-router";

import PostsListComponent from '@/components/PostsListComponent.vue'

const routes = [
    {
        path: '/dashboard',
        name: 'post.index',
        component: PostsListComponent
    },
]

export default createRouter({
    history: createWebHistory(),
    routes
})
