<template>
    <div class="container">
        <div class="w-50 m-3">
            <h4>Show post</h4>
            <div v-if="post">
                <h4>{{ post.title }}</h4>
                <div v-for="image in post.images" class="mb-3">
                    <img :src="image.url" alt="" class="mb-3">
                    <img :src="image.thumb_url" alt="" class="mb-3">
                </div>
                <div class="ql-editor" v-html="post.content"></div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    name: 'Show',

    data() {
        return {
            post: null
        }
    },
    mounted() {
        this.getPost()
    },

    methods: {
        getPost() {
            let id = this.$route.params.id
            return axios.get(`/api/posts/${id}`).then(
                response => {
                    console.log(response.data)
                    this.post = response.data.data
                }
            )
        },
    }
}
</script>

