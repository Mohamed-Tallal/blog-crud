import { ref } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'
 
export default function useBlog() {
    const post = ref([])
    const posts = ref([])
    const paginator = ref({
      current_page: 1,
      last_page: 1,
      total: 0,
      per_page: 15
    })
    const isLoading = ref(true);

    const listPosts = async ({ page, search }) => {
      try {
        const response = await axios.get('/api/blog', {
          params: {
            page: page,
            search: search
          }
        })
        const responseData = response.data.data;
        posts.value = responseData.list;
        paginator.value = responseData.paginator;
        isLoading.value = false

      } catch (error) {
        console.error(error)
      }
  }

    const showPost = async (id) => {
        let response = await axios.get(`/api/blog/${id}`)
        post.value = response.data.data
        isLoading.value = false
    }

 
    return {
        post,
        posts,
        listPosts,
        showPost,
        paginator,
        isLoading

    }
}