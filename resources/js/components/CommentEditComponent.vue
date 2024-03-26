<template>
  <div>
      <header class="bg-white space-y-4 p-4 sm:px-8 sm:py-6 lg:p-4 xl:px-8 xl:py-6">
          <div class="flex items-center justify-between">
            <h2 class="font-semibold text-slate-900">
              <router-link class ="font-semibold text-slate-900" :to="{ name: 'post.index' }">{{ $t('blog.posts') }}</router-link>
            </h2>
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
                <div v-if="post.user">
                  <p class="text-gray-900 font-semibold">{{post.user.name}}</p>
                  <p class="text-gray-600">{{post.user.email}}</p>
                </div>
              </div>
              <div v-if="post.comments && post.comments.length > 0">
                <h2 class="text-lg font-semibold mb-2">{{ $t('comments') }}</h2>
                <ul v-for="item in post.comments" :key="item.id">
                  <li class="mb-4">
                    <div class="flex items-center mb-2">
                      <div>
                        <div class="flex  justify-normal items-center ">
                          <p class="text-gray-900 font-semibold  mx-2" >{{item.user.name}}</p>

                        </div>
                        <p class="text-gray-600 mx-3 mb-2">{{item.created_at}}</p>

                        <p class="text-gray-600">{{item.description}}</p>
                        
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
            <div class="p-8">
              <form @submit.prevent="updateCommentData">
                <div class="w-full mb-4 border border-gray-200 rounded-lg bg-gray-50 dark:bg-white-700 dark:border-gray-600">
                  <div class="px-4 py-2 bg-white rounded-t-lg dark:bg-white-800">
                    <label for="comment" class="sr-only">{{ $t('your.comment') }}</label>
                    <textarea v-model="comment.description" id="comment" rows="6" class="w-full px-0 text-sm text-gray-900 bg-gray border-0 dark:bg-white-800 focus:ring-0 dark:text-gray dark:placeholder-gray-400" placeholder="Write a comment..." required></textarea>
                  </div>
                  <div class="flex items-center justify-between px-3 py-2 border-t dark:border-gray-600">
                    <button type="submit" class="inline-flex items-center py-2.5 px-4 group flex items-center rounded-md text-blue-500 border border-blue-500 hover:border-blue-400 hover:bg-blue-50 text-sm font-medium px-3 py-2 shadow-sm">
                      {{ $t('update.comment') }}
                    </button>
                  </div>
                </div>
              </form>
  
            </div>

          </div>
        </div>
      
        
  </div>
</template>

<script>
import useBlog from '@/composables/blog'
import { onMounted } from 'vue'
import useComments from '@/composables/comments'
import Swal from 'sweetalert2'
import { trans } from 'laravel-vue-i18n';
import {useRoute} from 'vue-router'

export default {

  setup() {
    const route = useRoute();

    const {post, showPost } = useBlog()
    const {comment, getComment, updateComment} = useComments()
      onMounted(()=>{
        showPost(route.params.id),
        getComment(route.params.comment)
      })

      const updateCommentData = async () => {
            await updateComment(route.params.comment , route.params.id )
            Swal.fire(trans("comment.updated"));
        }

      return {
        post,
        comment,
        updateCommentData
      }

  }
}
</script>