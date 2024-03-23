import { ref } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'
 
export default function useBlog() {
    const post = ref([])
    const posts = ref([])

    const listPosts = async () => {
        let response = await axios.get('/api/blog')
        posts.value = response.data.data
        console.log(response.data.data);
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