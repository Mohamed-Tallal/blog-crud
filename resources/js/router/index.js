import { createRouter, createWebHistory } from "vue-router";

import PostsListComponent from '@/components/PostsListComponent.vue'
import PostsComponent from '@/components/dashboard/PostsComponent.vue'
import PostComponent from '@/components/PostComponent.vue'
import PostCreateComponent from '@/components/dashboard/PostCreateComponent.vue'
import PostEditComponent from '@/components/dashboard/PostEditComponent.vue'
import CommantsComponent from '@/components/dashboard/CommantsComponent.vue'

import CommentEditComponent from '@/components/CommentEditComponent.vue'

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
        path: '/dashboard/:id/comment/:comment',
        name: 'post.edit.comment',
        component: CommentEditComponent,
        props: true
    },
    {
        path: '/dashboard/manage/posts',
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
    {
        path: '/dashboard/manage/post/:id/comments',
        name: 'user.post.comments',
        component: CommantsComponent,
        props: true
    },
]

export default createRouter({
    history: createWebHistory(),
    routes
})
