<template>
    <div>
        <header class="bg-white space-y-4 p-4 sm:px-8 sm:py-6 lg:p-4 xl:px-8 xl:py-6">
            <div class="flex items-center justify-between">
              <h2 class="font-semibold text-slate-900">
                Manage Your Posts</h2>

              <router-link class="group flex items-center rounded-md text-blue-500 border border-blue-500 hover:border-blue-400 hover:bg-blue-50 text-sm font-medium px-3 py-2 shadow-sm" :to="{ name: 'user.post.index' }"> Dashboard</router-link>
            </div>
        </header>
          <div>
            <div class="mx-auto bg-white rounded-xl shadow-md overflow-hidden">
              <img v-if="post.image == null" class="h-48 w-full object-cover" src="https://via.placeholder.com/1000x800" alt="Example Post">
              <img v-else class="h-48 w-full object-cover" :src="post.image" alt="Example Post">
              <div class="p-8">
                <div class="flex justify-between items-center mb-2">
                  <h1 class="text-2xl font-bold">{{ post.title }}</h1>
                  <p class="text-gray-600">{{post.created_at}}</p>
                </div>
                <p class="text-gray-500 text-sm mb-4">
                  {{post.body}}
                </p>
                <div class="flex items-center mb-4">
                  <div>
                    <p class="text-gray-900 font-semibold">{{post.user.name}}</p>
                    <p class="text-gray-600">{{post.user.email}}</p>
                  </div>
                </div>
                <div v-if="post.comments.length > 0">
                  <h2 class="text-lg font-semibold mb-2">Comments</h2>
                  <ul v-for="item in post.comments" :key="item.id">
                    <li class="mb-4">
                      <div class="flex items-center mb-2">
                        <div>
                          <div class="flex justify-between items-center mb-2">
                            <p class="text-gray-900 font-semibold">{{item.user.name}}</p>
                            <p class="text-gray-600 ml-auto">{{item.created_at}}</p>
                          </div>
                          <p class="text-gray-600">{{item.description}}</p>
                        </div>
                      </div>
                    </li>
                  </ul>
                </div>
              </div>
              <div class="p-8">
                <form>
                  <div class="w-full mb-4 border border-gray-200 rounded-lg bg-gray-50 dark:bg-white-700 dark:border-gray-600">
                      <div class="px-4 py-2 bg-white rounded-t-lg dark:bg-white-800">
                          <label for="comment" class="sr-only">Your comment</label>
                          <textarea id="comment" rows="6" class="w-full px-0 text-sm text-gray-900 bg-gray border-0 dark:bg-white-800 focus:ring-0 dark:text-gray dark:placeholder-gray-400" placeholder="Write a comment..." required></textarea>
                        </div>
                      <div class="flex items-center justify-between px-3 py-2 border-t dark:border-gray-600">
                          <button type="submit" class="inline-flex items-center py-2.5 px-4 group flex items-center rounded-md text-blue-500 border border-blue-500 hover:border-blue-400 hover:bg-blue-50 text-sm font-medium px-3 py-2 shadow-sm">
                              Post comment
                          </button>

                      </div>
                  </div>
                </form>
                <p class="ms-auto text-xs text-gray-500 dark:text-gray-400">Remember, contributions to this topic should follow our .</p>
    
              </div>

            </div>
          </div>
        
          
    </div>
</template>

<script>
import useBlog from '@/composables/blog'
import { onMounted } from 'vue'

export default {
    props: {
        id: {
            required: true,
            type: String
        }
    },

    setup(props) {
      const {post, showPost } = useBlog()
        onMounted(showPost(props.id))
        return {
          post,
        }
    }
}
</script>