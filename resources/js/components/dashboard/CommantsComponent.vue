<template>
  <div>
    <header class="bg-white space-y-4 p-4 sm:px-8 sm:py-6 lg:p-4 xl:px-8 xl:py-6">
      <div class="flex items-center justify-between">
        <router-link class="font-semibold text-slate-900" :to="{ name: 'post.index' }">{{ $t('blog.posts') }}</router-link>
        <div class="group flex items-center">
          <button class="mx-2 rounded-md text-red-500 border border-red-500 hover:border-red-400 hover:bg-red-50 text-sm font-medium px-3 py-2 shadow-sm" @click="bulkDelete">{{ $t('bulk.delete') }}</button>
          <router-link class="rounded-md text-blue-500 border border-blue-500 hover:border-blue-400 hover:bg-blue-50 text-sm font-medium px-3 py-2 shadow-sm" :to="{ name: 'user.post.index' }">{{ $t('my.posts') }}</router-link>
        </div>
      </div>

    </header>

    <div v-if="comments.length > 0">
      <table class="min-w-full border divide-y divide-gray-200">
        <thead>
          <tr>
            <th class="px-6 py-3 bg-gray-50">
              <span class="text-xs font-medium tracking-wider leading-4 text-left text-gray-500">{{ $t('select.ids') }}</span>
            </th>
            <th class="px-6 py-3 bg-gray-50">
              <span class="text-xs font-medium tracking-wider leading-4 text-left text-gray-500">{{ $t('comment') }}</span>
            </th>
            <th class="px-6 py-3 bg-gray-50">
              <span class="text-xs font-medium tracking-wider leading-4 text-left text-gray-500">{{ $t('user.name') }}</span>
            </th>
            <th class="px-6 py-3 bg-gray-50">
              <span class="text-xs font-medium tracking-wider leading-4 text-left text-gray-500">{{ $t('creation.date') }}</span>
            </th>
          </tr>
        </thead>

        <tbody class="bg-white divide-y divide-gray-200 divide-solid">
          <template v-for="comment in comments" :key="comment.id">
            <tr class="bg-white">
              <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                <input type="checkbox" v-model="selectedIds" :value="comment.id">
              </td>
              <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">{{ comment.description }}</td>
              <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">{{ comment.user.name }}</td>
              <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">{{ comment.created_at }}</td>
            </tr>
          </template>
        </tbody>
      </table>

      <div class="my-5 text-center">
        <TailwindPagination :data="paginator" @pagination-change-page="handlePaginationChange"/>
      </div>
    </div>

    <div v-else>
      <h2 class="text-center py-12 font-bold">{{ $t('no_comment.found') }}</h2>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue'
import { useRouter } from 'vue-router'
import { TailwindPagination } from 'laravel-vue-pagination'
import useComments from "../../composables/comments"
import Swal from 'sweetalert2'
import { trans } from 'laravel-vue-i18n';

const { comments, getComments, deleteComments, paginator } = useComments()
const router = useRouter()

// Selected comment IDs
const selectedIds = ref([])

// Fetch comments on component mount
onMounted(() => {
  fetchComments()
})

// Watch for changes in pagination and post_id
watch([() => paginator.value.current_page, () => router.currentRoute.value.params.id], ([pageNumber, postId]) => {
  fetchComments(pageNumber, postId)
})

// Function to fetch comments
const fetchComments = (page = 1, postId = router.currentRoute.value.params.id) => {
  getComments({ page, post_id: postId })
}

// Handle pagination change
const handlePaginationChange = pageNumber => {
  paginator.value.current_page = pageNumber
  fetchComments(pageNumber)
}

// Function to log selected IDs on bulk delete
const bulkDelete = async () => {
  const confirmed = await Swal.fire({
    title:trans('are.you.sure') ,
    text:  trans('warning.comments'),
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    cancelButtonText: trans('cancel'),
    confirmButtonText: trans('yes.delete') ,
  });

  if (confirmed.isConfirmed) {
    await deleteComments({ ids: selectedIds.value });
    fetchComments();

    Swal.fire({
      title: trans('deleted'),
      text: trans('comments.have.been.deleted'),
      icon: trans('success'),
    });
  }
}

</script>

