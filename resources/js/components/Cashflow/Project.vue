<template>
    <div class="container">
        <div class="card shadow">
            <div class="card-header d-flex justify-content-between">
                <span>Cashflow Project</span>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-projcet-add">
                    New Project
                </button>
            </div>
            <div class="card-body">
                <table class="table table-sm table-striped">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Detail</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(item, index) of project.data.data" :key="index">
                        <td><a :href="'/cashflow/project/'+item.id" v-html="item.title"/></td>
                        <td>{{ item.detail }}</td>
                    </tr>
                    </tbody>
                </table>
                <pagination align="center" :data="project.data" @pagination-change-page="get_projects"></pagination>
            </div>
        </div>
        <div id="modal-projcet-add" class="modal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">New Project</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" v-model="project.field.name"/>
                            <label>Detail</label>
                            <textarea class="form-control" v-model="project.field.detail"/>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button @click="save_project" type="button" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import $ from 'jquery';

Vue.component('pagination', require('laravel-vue-pagination'));
export default {
    data() {
        return {
            project: {
                field: {
                    name: '',
                    detail: ''
                },
                data: {},
            }
        }
    },
    methods: {
        save_project() {
            axios.post('/cashflow/project', this.project.field).then(res => {
                if (res.data.code === 200) {
                    $("#modal-projcet-add").modal('hide')
                    this.project.field = {name: '', detail: ''}
                    this.get_projects()
                    this.$swal("Project successfully saved")
                } else {
                    this.$swal({
                        icon: 'error',
                        title: 'Error',
                        text: res.data.message
                    })
                }
            })
        },
        get_projects(page = 1) {
            axios.get('/cashflow/project?page=' + page).then(res => {
                this.project.data = res.data.data
            })
        }
    },
    mounted() {
        this.get_projects()
    }
}
</script>

<style scoped>

</style>
