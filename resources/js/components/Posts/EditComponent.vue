<script setup>

</script>

<template>

    <div class="container">
        <div class="w-50 m-3">
            <h4>Update post</h4>
            <input v-model="title" class=" form-control m-3" placeholder="title">
            <div ref="dropzone" class="p-3 m-3 d-block btn bg-dark text-center text-light">
                Upload
            </div>
            <div class="m-3">
                <vue-editor useCustomImageHandler @imageRemoved="handleImageRemoved" @imageAdded="handleImageAdded" v-model="content"/>
            </div>
            <input @click.prevent="update" class="m-3 btn bg-primary" type="submit" value="Update">

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
    name: 'Edit',
    components: {VueEditor},

    data() {
        return {
            dropzone: null,
            title: '',
            post: null,
            content: null,
            imageIdsForDelete: [],
            imageUrlsForDelete: [],
        }
    },
    mounted() {
        this.dropzone = new Dropzone(this.$refs.dropzone, {
            url: '/api/posts',
            autoProcessQueue: false,
            addRemoveLinks: true
        })

        this.dropzone.on('removedfile', (file) => {
            this.imageIdsForDelete.push(file.id)
        })

        this.getPost()
    },

    methods: {
        getPost() {
            let id = this.$route.params.id
            return axios.get(`/api/posts/${id}`).then(
                response => {
                    this.post = response.data.data
                    this.title = this.post.title
                    this.content = this.post.content

                    this.post.images.forEach(
                        image => {
                            let file = {id: image.id, name: image.name, size: image.size};
                            this.dropzone.displayExistingFile(file, image.url);
                        }
                    )
                }
            )
        },
        update() {

            console.log(this.imageIdsForDelete)

            const data = new FormData()
            const files = this.dropzone.getAcceptedFiles()

            files.forEach(
                file => {
                    data.append('images[]', file)
                }
            )

            this.imageIdsForDelete.forEach(
                id => {
                    data.append('image_ids_delete[]', id)
                }
            )

            this.imageUrlsForDelete.forEach(
                url => {
                    data.append('image_urls_delete[]', url)
                }
            )

            data.append('title', this.title)
            data.append('content', this.content)
            data.append('_method', 'PATCH')

            axios.post(`/api/posts/${this.post.id}`, data,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then(response => {
                this.post = response.data.data

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
        handleImageRemoved(url) {
            this.imageUrlsForDelete.push(url)
        }
    }
}
</script>

