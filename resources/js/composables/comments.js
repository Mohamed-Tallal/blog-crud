import { ref } from 'vue'
import axios from "axios";
import { useRouter } from 'vue-router';

export default function useComments() {
    const comments = ref([])
    const router = useRouter()
    const errors = ref('')
    const comment = ref([])

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

    const getComment = async (id) => {
      let response = await axios.get('/api/comments/' + id )
      
      comment.value = response.data.data;
    }
    

    const deleteComment = async (id) => {
      try{
        console.log("response");

        const response = await axios.delete('/api/comments/' + id)
        console.log(response);
      }catch(e){
        console.log(e);
      }
    }

    const storeComment = async (data,id) => {
      errors.value = ''
      try {
          console.log(data);
          await axios.post('/api/comments', data)
          await router.push({name: 'post.show', params: { id: id }})
      } catch (e) {
          if (e.response.status === 422) {
              errors.value = e.response.data.errors
          }
      }
  }

  const updateComment = async (id , post_id) => {
      errors.value = ''
      try {
          await axios.put('/api/comments/' + id , comment.value)
          await router.push({name: 'post.show', params: { id: post_id }})
      } catch (e) {
          if (e.response.status === 422) {
             errors.value = e.response.data.errors
          }
      }
  }


    const deleteComments = async (ids) => {
        try {
          const response = await axios.delete('/api/comments/bulk-delete', {
            data: ids ,
          });
          console.log(response.data);
        } catch (error) {
          console.error(error);
        }
      };

      
    return {
        comments,
        errors,
        getComments,
        deleteComments,
        paginator,
        getComment,
        comment,
        deleteComment,
        storeComment,
        updateComment
    }
}
