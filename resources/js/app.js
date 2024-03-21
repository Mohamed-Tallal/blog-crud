import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import { createApp } from "vue";
import router from '@/router/index.js'
import PostsListComponent from '@/components/PostsListComponent.vue'

createApp({
    components: {
        PostsListComponent
    }
}).use(router).mount('#app')
