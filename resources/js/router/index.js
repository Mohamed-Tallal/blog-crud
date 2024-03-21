import { createRouter, createWebHistory } from "vue-router";

import PostsListComponent from '@/components/PostsListComponent.vue'
import PostsComponent from '@/components/dashboard/PostsComponent.vue'

const routes = [
    {
        path: '/dashboard',
        name: 'post.index',
        component: PostsListComponent
    },

    {
        path: '/dashboard/manage/post',
        name: 'user.post.index',
        component: PostsComponent
    },
]

export default createRouter({
    history: createWebHistory(),
    routes
})
