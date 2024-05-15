<script setup>

</script>

<template>
    <RouterLink :to="{name: 'posts.store'}">Add</RouterLink>
    <h4>Posts</h4>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Title</th>
            <th scope="col">Image</th>
            <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody>
        <tr v-if="posts" v-for="post in posts">
            <th scope="row">{{ post.id }}</th>
            <td>{{ post.title }}</td>
            <td >
                <img v-if="post.main_image" :src="post.main_image.url" alt="" class="mb-3" width="100" height="100">
            </td>
            <td>
                <RouterLink class="btn m-1 btn-warning" :to="{name: 'posts.edit', params: {id: post.id}}">Edit
                </RouterLink>
                <a @click.prevent="" class="btn m-1 btn-outline-danger">Delete</a>
            </td>
        </tr>
        </tbody>
    </table>

</template>

<style scoped>

</style>

<script>

export default {
    name: 'Index',

    data() {
        return {
            posts: null
        }
    },

    mounted() {
        this.getPosts()
    },

    methods: {
        getPosts() {
            axios.get('/api/posts').then(
                response => {
                    this.posts = response.data.data
                }
            ).catch(
                error => error
            )
        }
    }
}

</script>
