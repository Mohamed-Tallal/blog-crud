import { ref } from 'vue'
import axios from "axios";
import { useRouter } from 'vue-router';

export default function usePosts() {
    const posts = ref([])
    const post = ref([])
    const router = useRouter()
    const errors = ref('')
    const paginator = ref({
        current_page: 1,
        last_page: 1,
        total: 0,
        per_page: 10 // Adjust per_page value as needed
    })
    const isLoading = ref(true);

    const getPosts = async (page = 1) => {
        try {
            const response = await axios.get('/api/posts', {
                params: {
                    page: page
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

    const getPost = async (id) => {
        let response = await axios.get('/api/posts/' + id )
        post.value = response.data.data;
        isLoading.value = false

    }

    const storePost = async (formData) => {
        errors.value = ''
        try {
          await axios.post('/api/posts', formData, {
            headers: {
              'Content-Type': 'multipart/form-data', // Set Content-Type as multipart/form-data
            }
          });
          await router.push({name: 'user.post.index'});
        } catch (e) {
          if (e.response.status === 422) {
            errors.value = e.response.data.errors
          }
        }
      }

      const updatePost = async (id, formData) => {
        errors.value = ''
        try {
            await axios.post(`/api/posts/${id}`, formData);
            await router.push({name: 'user.post.index'});
        } catch (e) {
            if (e.response.status === 422) {
               errors.value = e.response.data.errors
            }
        }
    }


    const deletePost = async (id) => {
        await axios.delete('/api/posts/' + id)
        isLoading.value = false
    }


    return {
        posts,
        post,
        errors,
        getPosts,
        getPost,
        storePost,
        updatePost,
        deletePost,
        paginator,
        isLoading
    }
}
