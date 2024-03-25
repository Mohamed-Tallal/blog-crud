<template>
  <header class="bg-white space-y-4 p-4 sm:px-8 sm:py-6 lg:p-4 xl:px-8 xl:py-6">
    <div class="flex items-center justify-between">
      <router-link class="font-semibold text-slate-900" :to="{ name: 'post.index' }">{{ $t('blog.posts') }}</router-link>
      <router-link class="group flex items-center rounded-md text-blue-500 border border-blue-500 hover:border-blue-400 hover:bg-blue-50 text-sm font-medium px-3 py-2 shadow-sm" :to="{ name: 'user.post.create' }">{{ $t('create') }} </router-link>
    </div>
</header>
<div  v-if="posts.length > 0">
  <table class="min-w-full border divide-y divide-gray-200">
    <thead>
    <tr>
        <th class="px-6 py-3 bg-gray-50">
            <span
                class="float-left text-xs font-medium tracking-wider leading-4 text-left text-gray-500">{{ $t('title') }}</span>
        </th>
        <th class="px-6 py-3 bg-gray-50">
            <span
                class="float-left text-xs font-medium tracking-wider leading-4 text-left text-gray-500">{{ $t('number.of.comments') }} </span>
        </th>
        <th class="px-6 py-3 bg-gray-50">
            <span
                class="float-left text-xs font-medium tracking-wider leading-4 text-left text-gray-500">{{ $t('creation.date') }}</span>
        </th>
        <th class="px-6 py-3 bg-gray-50">
          <span
              class="float-left text-xs font-medium tracking-wider leading-4 text-left text-gray-500">{{ $t('actions') }}</span>
      </th>
    </tr>
    </thead>
  
    <tbody class="bg-white divide-y divide-gray-200 divide-solid">
    <template v-for="item in posts" :key="item.id">
        <tr class="bg-white">
            <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                {{ item.title }}
            </td>
            <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
              <router-link :to="{ name: 'user.post.comments', params: { id: item.id } }" style="color: blue; text-decoration: underline;">
                {{ item.comments }}
              </router-link>
            </td>
            <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                  {{ item.created_at }}
            </td>
            <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                <router-link :to="{ name: 'user.post.edit', params: { id: item.id } }"
                    class="mr-2 inline-flex items-center group flex items-center rounded-md text-green-500 border border-green-500 hover:border-green-400 hover:bg-green-50 text-sm font-medium px-3 py-2 shadow-sm">
                    {{ $t('edit') }}
                </router-link>
                <button @click="deleteMyPost(item.id)" class="inline-flex items-center group flex items-center rounded-md text-red-500 border border-red-500 hover:border-red-400 hover:bg-red-50 text-sm font-medium px-3 py-2 shadow-sm">
                    {{ $t('delete') }}
                </button>
            </td>
        </tr>
    </template>

    </tbody>
    
  </table>

  <div class="my-5 text-center">
    <TailwindPagination :data="paginator" @pagination-change-page="handlePaginationChange"/>
  </div>


</div>

<div v-else>
  <h2 class="text-center py-12 font-bold">{{ $t('no_posts.found') }}</h2>
</div>

</template>

<script setup>
import { ref, watchEffect } from 'vue'
import usePosts from "../../composables/posts";
import { onMounted } from "vue";
import { TailwindPagination } from 'laravel-vue-pagination';
import Swal from 'sweetalert2'
import { trans } from 'laravel-vue-i18n';

const { posts, getPosts, deletePost, paginator } = usePosts()

// Initialize current page
const currentPage = ref(1);

// Fetch posts on component mount
onMounted(getPosts)

// Watch for changes in current page
watchEffect(() => {
  getPosts(currentPage.value);
})

// Handler for pagination change
function handlePaginationChange(pageNumber) {
  currentPage.value = pageNumber;
}

// Function to calculate paginated posts
function calculatePaginatedPosts() {
  const startIndex = (currentPage.value - 1) * paginator.value.per_page;
  const endIndex = startIndex + paginator.value.per_page;
  return posts.value.slice(startIndex, endIndex);
}

// Computed property for paginated posts
const paginatedPosts = calculatePaginatedPosts();

// Delete post function
const deleteMyPost = async (id) => {
  Swal.fire({
    title: trans('are.you.sure') ,
    text:  trans('warning.post') ,
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    cancelButtonText: trans('cancel'),
    confirmButtonText: trans('yes.delete') ,
    }).then(async (result) => {
    if (result.isConfirmed) {
      await deletePost(id);
      Swal.fire({
      title: trans('deleted'),
      text: trans('post.have.been.deleted'),
      icon: trans('success'),
      });
    }
  });
}
</script>