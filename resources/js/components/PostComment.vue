<template>
    <div>
        <ckeditor :editor="editor" v-model="editorData" :config="editorConfig"></ckeditor>
        <input type="hidden" name="post_content" v-model="editorData">
        <div id="word-count"></div>
    </div>
</template>

<script>
    import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

    export default {
        props: ['content'],
        data() {
            return {

                editor: ClassicEditor,
                editorData: this.content,
                editorConfig: {
                    // The configuration of the editor.
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
