<template>
  <header class="bg-white space-y-4 p-4 sm:px-8 sm:py-6 lg:p-4 xl:px-8 xl:py-6">
    <div class="flex items-center justify-between">
      <router-link class="font-semibold text-slate-900" :to="{ name: 'post.index' }">Blog</router-link>
      <router-link class="group flex items-center rounded-md text-blue-500 border border-blue-500 hover:border-blue-400 hover:bg-blue-50 text-sm font-medium px-3 py-2 shadow-sm" :to="{ name: 'user.post.index' }"> My Posts</router-link>
    </div>
  </header>
  <div v-if="errors">
    <div v-for="(v, k) in errors" :key="k" class="bg-red-500 text-white rounded font-bold mb-4 shadow-lg py-2 px-4 pr-0">
      <p v-for="error in v" :key="error" class="text-sm">{{ error }}</p>
    </div>
  </div>

  <form v-on:submit.prevent="updatePostData">
    <div class="space-y-12">
      <div class="border-b border-gray-900/10 pb-12">
        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
          <div class="col-span-full">
            <label for="street-address" class="block text-sm font-medium leading-6 text-gray-900">Arabic Title</label>
            <div class="mt-2">
              <input type="text" name="street-address" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" v-model="post.title_ar">
            </div>
          </div>
          
          <div class="col-span-full">
            <label for="street-address" class="block text-sm font-medium leading-6 text-gray-900">English Title</label>
            <div class="mt-2">
              <input type="text" name="street-address" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" v-model="post.title_en">
            </div>
          </div>

          <div class="col-span-full">
            <label for="image" class="block text-sm font-medium leading-6 text-gray-900">Image</label>
            <input type="file" name="image" accept="image/*" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" v-on:change="handleImageChange">
          </div>

          <div class="col-span-full">
            <label for="about" class="block text-sm font-medium leading-6 text-gray-900">Arabic Description</label>
            <div class="mt-2">
              <textarea id="about" name="about" rows="3" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" v-model="post.body_ar"></textarea>
            </div>
          </div>

          <div class="col-span-full">
            <label for="about" class="block text-sm font-medium leading-6 text-gray-900">English Description</label>
            <div class="mt-2">
              <textarea id="about" name="about" rows="3" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" v-model="post.body_en"></textarea>
            </div>
          </div>
        </div>
      </div>
      <button type="submit" class="items-center rounded-md text-green-500 border border-green-500 hover:border-green-400 hover:bg-green-50 text-sm font-medium px-3 py-2 shadow-sm">Update</button> 
    </div>
  </form>
</template>

<script>

import usePosts from "../../composables/posts";
import { onMounted } from "vue";
import Swal from 'sweetalert2'
import { reactive } from "vue";

export default {
    props: {
        id: {
            required: true,
            type: String
        }
    },

    setup(props) {
      const { errors, post, getPost, updatePost } = usePosts();

        const reactivePost = reactive({
            image: null,
        });

        onMounted(() => {
            getPost(props.id);
            console.log(post);
        });

    const updatePostData = async () => {
        const formData = new FormData();
        
        if(reactivePost.image != null){
          formData.append('image',  reactivePost.image);
        }

        formData.append('title_ar', post.value.title_ar);
        formData.append('title_en', post.value.title_en);
        formData.append('body_ar', post.value.body_ar);
        formData.append('body_en', post.value.body_en);
        formData.append('_method', "PATCH");
        await updatePost(props.id, formData); 
        Swal.fire("Post Updated successfully");
    };

    const handleImageChange = (event) => {
        reactivePost.image = event.target.files[0];
    };

    return {
        errors,
        post, // Return reactivePost instead of post
        updatePostData,
        handleImageChange,
        reactivePost
    };
    
    }
}
</script>
