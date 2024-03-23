import { createRouter, createWebHistory } from "vue-router";

import PostsListComponent from '@/components/PostsListComponent.vue'
import PostsComponent from '@/components/dashboard/PostsComponent.vue'
import PostComponent from '@/components/PostComponent.vue'

const routes = [
    {
        path: '/dashboard',
        name: 'post.index',
        component: PostsListComponent
    },
    {
        path: '/dashboard/:id',
        name: 'post.show',
        component: PostComponent,
        props: true
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
