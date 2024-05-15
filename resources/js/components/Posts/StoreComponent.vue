<script setup>

</script>

<template>

    <div class="container">
        <div class="w-50 m-3">
            <h4>Create post</h4>
            <input v-model="title" class=" form-control m-3" placeholder="title">
            <div ref="dropzone" class="p-3 m-3 d-block btn bg-dark text-center text-light">
                Upload
            </div>
            <div class="m-3">
                <vue-editor useCustomImageHandler @imageAdded="handleImageAdded" v-model="content"/>
            </div>
            <input @click.prevent="store" class="m-3 btn bg-primary" type="submit" value="Add">
        </div>
    </div>

</template>

<style>
.dz-success-mark, .dz-error-mark {
    display: none;
}

</style>

<script>

import {Dropzone} from 'dropzone'
import {VueEditor} from 'vue3-editor'

export default {
    name: 'Store',
    components: {VueEditor},

    data() {
        return {
            dropzone: null,
            title: '',
            post: null,
            content: null
        }
    },
    mounted() {
        this.dropzone = new Dropzone(this.$refs.dropzone, {
            url: '/api/posts',
            autoProcessQueue: false,
            addRemoveLinks: true
        })
    },

    methods: {
        store() {
            const data = new FormData()
            const files = this.dropzone.getAcceptedFiles()

            files.forEach(
                file => {
                    data.append('images[]', file)
                }
            )

            data.append('title', this.title)
            data.append('content', this.content)

            axios.post('/api/posts', data,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then(response => {
                this.post = response.data.data
                this.dropzone.removeAllFiles()
                this.title = ''
                this.content = ''
                this.$router.push({name: 'posts.show', params: {id: this.post.id}})
            })
                .catch(error => {

                });
        },
        handleImageAdded(file, Editor, cursorLocation, resetUploader) {
            const formData = new FormData()
            formData.append("image", file)

            axios.post('/api/posts/images', formData)
                .then(result => {
                    const url = result.data.url; // Get url from response
                    Editor.insertEmbed(cursorLocation, "image", url);
                    resetUploader();
                })
                .catch(err => {
                    console.log(err);
                });
        },
    }
}
</script>

