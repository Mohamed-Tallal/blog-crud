<template>
  <header class="bg-white space-y-4 p-4 sm:px-8 sm:py-6 lg:p-4 xl:px-8 xl:py-6">
    <div class="flex items-center justify-between">
      <router-link class="font-semibold text-slate-900" :to="{ name: 'post.index' }">Blog</router-link>
      <router-link class="group flex items-center rounded-md text-blue-500 border border-blue-500 hover:border-blue-400 hover:bg-blue-50 text-sm font-medium px-3 py-2 shadow-sm" :to="{ name: 'user.post.index' }"> My Posts</router-link>
    </div>
</header>
<form v-on:submit.prevent="saveMyPost">
  <div class="space-y-12">
    <div class="border-b border-gray-900/10 pb-12">
      <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
        <div class="col-span-full">
          <label for="street-address" class="block text-sm font-medium leading-6 text-gray-900">Arabic Title</label>
          <div class="mt-2">
            <input type="text" name="street-address"  class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" v-model="form.title_ar">
          </div>
        </div>
        
        <div class="col-span-full">
          <label for="street-address" class="block text-sm font-medium leading-6 text-gray-900">English Title</label>
          <div class="mt-2">
            <input type="text" name="street-address" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" v-model="form.title_en">
          </div>
        </div>
        <div class="col-span-full">
          <label for="about" class="block text-sm font-medium leading-6 text-gray-900">Arabic Description</label>
          <div class="mt-2">
            <textarea id="about" name="about" rows="3" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"  v-model="form.body_ar"></textarea>
          </div>
        </div>
  
        <div class="col-span-full">
          <label for="about" class="block text-sm font-medium leading-6 text-gray-900">English Description</label>
          <div class="mt-2">
            <textarea id="about" name="about" rows="3" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"  v-model="form.body_en"></textarea>
          </div>
        </div>
  
  
      </div>
    </div>
    <button type="submit" class="items-center rounded-md text-blue-500 border border-blue-500 hover:border-blue-400 hover:bg-blue-50 text-sm font-medium px-3 py-2 shadow-sm">
      Save
    </button> 
  </div>
  
  </form>

</template>

<script>
import { reactive } from "vue";
import usePosts from "../../composables/posts";

export default {
    setup() {
        const form = reactive({
            'title_ar': '',
            'body_ar': '',
            'title_en': '',
            'body_en': '',
        })

        const { errors, storePost } = usePosts()

        const saveMyPost = async () => {
            await storePost({...form});
        }

        return {
            form,
            errors,
            saveMyPost
        }
    }
}
</script>