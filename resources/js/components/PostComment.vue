<template>
    <div>
        <ckeditor :editor="editor" v-model="editorData" :config="editorConfig"></ckeditor>
        <input type="hidden" name="post_content" v-model="editorData">
        <div id="word-count"></div>
    </div>
</template>

<script>
    import * as ClassicEditor from '@ckeditor/ckeditor5-build-classic';


    export default {
        props: ['content'],
        data() {
            return {

                editor: ClassicEditor,
                editorData: this.content,
                editorConfig: {
                    ckfinder: {
                        // Upload the images to the server using the CKFinder QuickUpload command.
                        uploadUrl: 'https://example.com/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images&responseType=json'
                    }
                },


            };
        },

        mounted() {

        },
        methods: {
            emptyEditor() {
                this.editorData = '';
            }
        }

    }
</script>
