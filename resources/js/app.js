import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import { createApp } from "vue";
import router from '@/router/index.js'
import PostsListComponent from '@/components/PostsListComponent.vue'
import { i18nVue } from 'laravel-vue-i18n'; 

createApp({
  components: {
    PostsListComponent
  }
}).use(router).use(i18nVue, { 
  resolve: async lang => {
      const langs = import.meta.glob('../../lang/*.json');
      return await langs[`../../lang/${lang}.json`]();
  }
}).mount('#app')
