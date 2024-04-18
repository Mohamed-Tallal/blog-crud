<template>
  <header class="bg-white space-y-4 p-4 sm:px-8 sm:py-6 lg:p-4 xl:px-8 xl:py-6">
    <div class="flex items-center justify-between">
      <router-link class="font-semibold text-slate-900" :to="{ name: 'post.index' }">{{ $t('blog.posts') }}</router-link>
      <router-link class="group flex items-center rounded-md text-blue-500 border border-blue-500 hover:border-blue-400 hover:bg-blue-50 text-sm font-medium px-3 py-2 shadow-sm" :to="{ name: 'user.post.index' }">{{ $t('my.posts') }}</router-link>
    </div>
</header>
<div v-if="errors">
  <div v-for="(v, k) in errors" :key="k" class="bg-red-500 text-white rounded font-bold mb-4 shadow-lg py-2 px-4 pr-0">
    <p v-for="error in v" :key="error" class="text-sm">
      {{ error }}
    </p>
  </div>
</div>

<form v-on:submit.prevent="saveMyPost">
  <div class="space-y-12">
    <div class="border-b border-gray-900/10 pb-12">
      <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
        <div class="col-span-full">
          <label for="street-address" class="block text-sm font-medium leading-6 text-gray-900">{{ $t('title.ar') }}</label>
          <div class="mt-2">
            <input type="text" name="street-address"  class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" v-model="form.title_ar">
          </div>
        </div>
        
        <div class="col-span-full">
          <label for="street-address" class="block text-sm font-medium leading-6 text-gray-900">{{ $t('title.en') }}</label>
          <div class="mt-2">
            <input type="text" name="street-address" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" v-model="form.title_en">
          </div>
        </div>
        <div class="col-span-full">
          <label for="image" class="block text-sm font-medium leading-6 text-gray-900">{{ $t('image') }}</label>
          <input type="file" name="image" accept="image/*" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" v-on:change="handleImageChange">
        </div>


        <div class="col-span-full">
          <label for="about" class="block text-sm font-medium leading-6 text-gray-900">{{ $t('description.ar') }}</label>
          <div class="mt-2">
            <textarea id="about" name="about" rows="3" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"  v-model="form.body_ar"></textarea>
          </div>
        </div>
        <!-- Input for uploading an image -->

        <div class="col-span-full">
          <label for="about" class="block text-sm font-medium leading-6 text-gray-900">{{ $t('description.en') }}</label>
          <div class="mt-2">
            <textarea id="about" name="about" rows="3" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"  v-model="form.body_en"></textarea>
          </div>
        </div>
  
  
      </div>
    </div>
    <button type="submit" class="items-center rounded-md text-blue-500 border border-blue-500 hover:border-blue-400 hover:bg-blue-50 text-sm font-medium px-3 py-2 shadow-sm">
      {{ $t('save') }}

    </button> 
  </div>
  
  </form>

</template>

<script>
import { reactive } from "vue";
import usePosts from "../../composables/posts";
import Swal from 'sweetalert2';
import { trans } from 'laravel-vue-i18n';

export default {
    setup() {
        const form = reactive({
            'title_ar': '',
            'body_ar': '',
            'title_en': '',
            'body_en': '',
            'image' : null  ,
        })

      const { errors, storePost } = usePosts()

      const saveMyPost = async () => {
        const formData = new FormData();
        //formData.append('image', form.image); // Append the image file to FormData
        if (form.image !== null) {
          formData.append('image', form.image);
        }
        formData.append('title_ar', form.title_ar);
        formData.append('body_ar', form.body_ar);
        formData.append('title_en', form.title_en);
        formData.append('body_en', form.body_en);

        await storePost(formData);
        if(errors.value.length  == []){
          Swal.fire(trans("post.created"));

        }
      }

      const handleImageChange = (event) => {
           form.image = event.target.files[0]; // Update form.image with the selected file
      }


        return {
            form,
            errors,
            saveMyPost,
            handleImageChange
        }
    }
}
</script>