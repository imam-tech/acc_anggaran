<template>
    <div class="container-fluid">

        <div class="card shadow mb-4">
            <div class="card-title">
                <h1 class="h3 mt-3 ml-3 text-gray-800 float-left">Project List</h1>
            </div>
            <div class="row ml-3">
                <!--<div class="col-md-3">-->
                    <!--<div class="input-group mb-2">-->
                        <!--<div class="input-group-prepend">-->
                            <!--<div class="input-group-text">Title</div>-->
                        <!--</div>-->
                        <!--<input type="text" class="form-control" id="title" placeholder="Title" v-model="sortVal.title">-->
                    <!--</div>-->
                <!--</div>-->
                <!--<div class="col-md-3">-->
                    <!--<div class="input-group mb-2">-->
                        <!--<div class="input-group-prepend">-->
                            <!--<div class="input-group-text">Status</div>-->
                        <!--</div>-->
                        <!--<select name="status" v-model="sortVal.status" class="form-control">-->
                            <!--<option value="active" :selected="sortVal.status== null ? true : false">All</option>-->
                            <!--<option value="active" :selected="sortVal.status== 'active' ? true : false">Active</option>-->
                            <!--<option value="not_active" :selected="sortVal.status== 'not_active' ? true : false">Not Active</option>-->
                        <!--</select>-->
                    <!--</div>-->
                <!--</div>-->
                <div class="col-md-3">
                    <!--<button class="btn btn-success mb-2" @click="sortValue()">Search</button>-->
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th class="text-center">Company</th>
                            <th class="text-center">Title</th>
                            <th class="text-center">Description</th>
                            <th class="text-center">User Count</th>
                            <th class="text-center">Created At</th>
                            <th class="text-center">#</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(project, index) in projects" :key="index">
                            <td>
                                <router-link :to="'/app/company/'+project.company_id+'/detail'">{{ project.company.title }}</router-link>
                            </td>
                            <td>{{ project.title }}</td>
                            <td>{{ project.description}}</td>
                            <td>{{ project.project_users.length }} member</td>
                            <td>{{ project.created_at | formatDate }}</td>
                            <td class="text-right">
                                <router-link :to="'/app/project/'+project.id+'/detail'" class="btn btn-info">
                                    <i class="fas fa-eye"></i>
                                </router-link>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <!--<div class="justify-content-center d-flex">-->
                        <!--<pagination v-model="page" :records="totalData" :per-page="perPage" @paginate="getData"/>-->
                    <!--</div>-->
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Index.vue",
        data() {
            return {
                projects: [],
            }
        },
        created() {
            this.getData()
        },
        methods: {
            async getData() {
                try {
                    this.$vs.loading()
                    this.projects = await this.$axios.get('api/project')
                    this.$vs.loading.close()
                } catch (e) {
                    this.$vs.loading.close()
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: e.message,
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
            }
        }
    }
</script>