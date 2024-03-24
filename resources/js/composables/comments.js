import { ref } from 'vue'
import axios from "axios";
import { useRouter } from 'vue-router';

export default function useComments() {
    const comments = ref([])
    const router = useRouter()
    const errors = ref('')
    const paginator = ref({
        current_page: 1,
        last_page: 1,
        total: 0,
        per_page: 10 // Adjust per_page value as needed
    })

    const getComments = async ({ page, post_id }) => {
        try {
            const response = await axios.get('/api/comments', {
                params: {
                    page: page,
                    post_id: post_id
                }
            })
            const responseData = response.data.data;
            comments.value = responseData.list;
            paginator.value = responseData.paginator;
        } catch (error) {
        }
    }

    const deleteComments = async (ids) => {
        try {
          const response = await axios.delete('/api/comments/bulk-delete', {
            data: ids ,
          });
          // Handle response if needed
          console.log(response.data);
        } catch (error) {
          // Handle error
          console.error(error);
        }
      };

    return {
        comments,
        errors,
        getComments,
        deleteComments,
        paginator
    }
}
