<template>
    <div>
        <header class="bg-white space-y-4 p-4 sm:px-8 sm:py-6 lg:p-4 xl:px-8 xl:py-6">
            <div class="flex items-center justify-between">
              <h2 class="font-semibold text-slate-900">
                Manage Your Posts</h2>

              <router-link class="group flex items-center rounded-md text-blue-500 border border-blue-500 hover:border-blue-400 hover:bg-blue-50 text-sm font-medium px-3 py-2 shadow-sm" :to="{ name: 'user.post.index' }"> Dashboard</router-link>
            </div>
            <form class="group relative">
              <svg width="20" height="20" fill="currentColor" class="absolute left-3 top-1/2 -mt-2.5 text-slate-400 pointer-events-none group-focus-within:text-blue-500" aria-hidden="true">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" />
              </svg>
              <input class="focus:ring-2 focus:ring-blue-500 focus:outline-none appearance-none w-full text-sm leading-6 text-slate-900 placeholder-slate-400 rounded-md py-2 pl-10 ring-1 ring-slate-200 shadow-sm" type="text" aria-label="Filter projects" placeholder="Filter projects...">
            </form>
        </header>
        <div v-if="posts.length > 0">
          <div class="pt-10 pb-1 px-1" v-for="item in posts" :key="item.id">
              <!--Card 1-->
              <div class=" w-full lg:max-w-full lg:flex">
                <div class="h-48 lg:h-auto lg:w-48 flex-none bg-cover rounded-t lg:rounded-t-none lg:rounded-l text-center overflow-hidden" style="background-image: url('https://th.bing.com/th/id/R.61a9938407c44d0259447347c1c8de08?rik=c4aPFE24miQgvQ')" title="Mountain">
                </div>
                <div class="lg:w-2000 border-r border-b border-l border-gray-400 lg:border-l-0 lg:border-t lg:border-gray-400 bg-white rounded-b lg:rounded-b-none lg:rounded-r p-4 flex flex-col justify-between leading-normal">
                  <div class="mb-8">
                    <router-link  class="text-gray-900 font-bold text-xl mb-2" :to="{ name: 'post.show', params: { id: item.id } }">{{item.title}}</router-link>
                    <p class="text-gray-700 text-base">{{ truncateString(item.body, 240) }}</p>
                  </div>
                  <div class="flex items-center">
                    <img class="w-10 h-10 rounded-full mr-4" src="https://th.bing.com/th/id/OIP.kvqAQyyE52fzwMZZ_g99LAHaE8?rs=1&pid=ImgDetMain" alt="Avatar of Writer">
                    <div class="text-sm">
                      <p class="text-gray-900 leading-none">{{item.user.name}}</p>
                      <p class="text-gray-600">{{item.created_at}}</p>
                    </div>
                  </div>
                </div>
              </div>
          </div>
        </div>
        <div v-else>
          <h2 class="text-center py-12 font-bold">No posts found.</h2>
        </div>
    </div>
</template>

<script setup>
  import useBlog from '@/composables/blog'
  import { onMounted } from 'vue'

  const { posts, listPosts } = useBlog()
  
  onMounted(listPosts)

  function truncateString(str, num) {
    if (str.length <= num) {
      return str;
    }
    return str.slice(0, num) + '.....';
  }

</script>
