import { createRouter, createWebHistory } from "vue-router";

import PostsListComponent from '@/components/PostsListComponent.vue'
import PostsComponent from '@/components/dashboard/PostsComponent.vue'
import PostComponent from '@/components/PostComponent.vue'
import PostCreateComponent from '@/components/dashboard/PostCreateComponent.vue'
import PostEditComponent from '@/components/dashboard/PostEditComponent.vue'

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
    {
        path: '/dashboard/manage/post/create',
        name: 'user.post.create',
        component: PostCreateComponent
    },
    {
        path: '/dashboard/manage/post/:id/edit',
        name: 'user.post.edit',
        component: PostEditComponent,
        props: true
    },
]

export default createRouter({
    history: createWebHistory(),
    routes
})
