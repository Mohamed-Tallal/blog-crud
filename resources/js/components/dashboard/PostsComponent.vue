<template>
  <header class="bg-white space-y-4 p-4 sm:px-8 sm:py-6 lg:p-4 xl:px-8 xl:py-6">
    <div class="flex items-center justify-between">
      <router-link class="font-semibold text-slate-900" :to="{ name: 'post.index' }">Blog</router-link>
      <router-link class="group flex items-center rounded-md text-blue-500 border border-blue-500 hover:border-blue-400 hover:bg-blue-50 text-sm font-medium px-3 py-2 shadow-sm" :to="{ name: 'user.post.create' }"> Create</router-link>
    </div>
</header>
<div  v-if="posts.length > 0">
  <table class="min-w-full border divide-y divide-gray-200">
    <thead>
    <tr>
        <th class="px-6 py-3 bg-gray-50">
            <span
                class="float-left text-xs font-medium tracking-wider leading-4 text-left text-gray-500">Title</span>
        </th>
        <th class="px-6 py-3 bg-gray-50">
            <span
                class="float-left text-xs font-medium tracking-wider leading-4 text-left text-gray-500">Number of comments </span>
        </th>
        <th class="px-6 py-3 bg-gray-50">
            <span
                class="float-left text-xs font-medium tracking-wider leading-4 text-left text-gray-500">Creation Date</span>
        </th>
        <th class="px-6 py-3 bg-gray-50">
          <span
              class="float-left text-xs font-medium tracking-wider leading-4 text-left text-gray-500">Actions</span>
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
                {{ item.comments }}
            </td>
            <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                {{ item.created_at }}
            </td>
            <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                <router-link :to="{ name: 'user.post.edit', params: { id: item.id } }"
                    class="mr-2 inline-flex items-center group flex items-center rounded-md text-green-500 border border-green-500 hover:border-green-400 hover:bg-green-50 text-sm font-medium px-3 py-2 shadow-sm">
                    Edit
                </router-link>
                <button @click="deleteMyPost(item.id)" class="inline-flex items-center group flex items-center rounded-md text-red-500 border border-red-500 hover:border-red-400 hover:bg-red-50 text-sm font-medium px-3 py-2 shadow-sm">
                    Delete
                </button>
            </td>
        </tr>
    </template>
    </tbody>
    
  </table>
</div>

<div v-else>
  <h2 class="text-center py-12 font-bold">No posts found.</h2>
</div>

</template>

<script>
import usePosts from "../../composables/posts";
import { onMounted } from "vue";

export default {
    setup() {
        const { posts, getPosts, deletePost } = usePosts()

        onMounted(getPosts)

        const deleteMyPost = async (id) => {
            if (!window.confirm('Are you sure?')) {
                return
            }

            await deletePost(id);
            await getPosts();
        }

        return {
            posts,
            deleteMyPost
        }
    }
}
</script>
