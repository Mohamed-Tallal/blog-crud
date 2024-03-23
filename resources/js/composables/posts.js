import { ref } from 'vue'
import axios from "axios";
import { useRouter } from 'vue-router';

export default function usePosts() {
    const posts = ref([])
    const post = ref([])
    const router = useRouter()
    const errors = ref('')

    const getPosts = async () => {
        let response = await axios.get('/api/posts')
        posts.value = response.data.data;
    }

    const getPost = async (id) => {
        let response = await axios.get('/api/posts/' + id )
        post.value = response.data.data;
        console.log(response.data);
    }

    const storePost = async (data) => {
        errors.value = ''
        try {
            console.log(data);
            await axios.post('/api/posts', data)
            await router.push({name: 'user.post.index'})
        } catch (e) {
            if (e.response.status === 422) {
                errors.value = e.response.data.errors
            }
        }
    }

    const updatePost = async (id) => {
        errors.value = ''
        try {
            await axios.put('/api/posts/' + id , post.value)
            await router.push({name: 'user.post.index'})
        } catch (e) {
            if (e.response.status === 422) {
               errors.value = e.response.data.errors
            }
        }
    }

    const deletePost = async (id) => {
        await axios.delete('/api/posts/' + id)
    }


    return {
        posts,
        post,
        errors,
        getPosts,
        getPost,
        storePost,
        updatePost,
        deletePost
    }
}
