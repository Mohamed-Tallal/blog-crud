import { ref } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'
 
export default function useBlog() {
    const post = ref([])
    const posts = ref([])


    const listPosts = async (searchTerm) => {
        try {
          const response = await axios.get('/api/blog', {
            params: {
              search: searchTerm
            }
          })
          posts.value = response.data.data
          console.log('getPosts')
        } catch (error) {
          console.error(error)
        }
      }

    const showPost = async (id) => {
        let response = await axios.get(`/api/blog/${id}`)
        post.value = response.data.data
        console.log(response.data.data);

    }

 
    return {
        post,
        posts,
        listPosts,
        showPost,
    }
}