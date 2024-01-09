<template>
    <div class="container-fluid">
        <div class="card">
            <div class="card-title">
                <h1 class="h3 mt-3 ml-3 text-gray-800 float-left">Project Detail</h1>
                <router-link :to="'/app/configuration/company/'+$route.params.companyId+'/detail'" class="btn btn-success float-right mt-3 mr-3">
                    <i class="fas fa-arrow-left"></i> Back
                </router-link>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <tbody>
                    <tr>
                        <th>Company</th>
                        <td>{{projectData.company.title}}</td>
                    </tr>
                    <tr>
                        <th>Title</th>
                        <td>{{projectData.title}}</td>
                    </tr>
                    <tr>
                        <th>Description</th>
                        <td>{{projectData.description}}</td>
                    </tr>
                    <tr>
                        <th>User Count</th>
                        <td>{{projectData.project_users.length}} Member</td>
                    </tr>
                    </tbody>
                </table>

                <div class="row">
                    <div class="col-lg-12">
                        <h3 class="h3 text-gray-800 float-left">User List</h3>
                        <button v-if="$store.state.permissions.includes('project_add_user')" type="button" class="btn btn-primary float-right mb-2" @click="showAssignModal()">
                            <i class="fas fa-plus-circle"></i> Add User
                        </button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Email</th>
                            <th>Created At</th>
                            <th>#</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-show="projectData.project_users.length == 0">
                            <td colspan="4" class="text-center">
                                Empty Project
                            </td>
                        </tr>
                        <tr v-for="(project, key) in projectData.project_users">
                            <td><strong>{{ key+1 }}</strong></td>
                            <td>{{ project.user.email }}</td>
                            <td>{{ project.created_at | formatDate }}</td>
                            <td>
                                <button v-if="$store.state.permissions.includes('project_add_user')" class="btn btn-danger" type="button" @click="handleDelete(project.id)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal fade" id="addProject" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">{{ labelModal }} User to this Project</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form @submit.prevent="assignUser()">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>Title<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                        <v-select v-model="formData.user_id" :options="users" :reduce="p => p.id" style="width: 100%" label="email" multiple>
                                            <template #search="{attributes, events}">
                                                <input
                                                        class="vs__search"
                                                        :required="formData.user_id.length === 0"
                                                        v-bind="attributes"
                                                        v-on="events"
                                                />
                                            </template>
                                            <span slot="no-options">User not found</span>
                                        </v-select>
                                    </div>
                                </div>
                                <div class="modal-footer flex justify-content-between">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">
                                        <i class="fas fa-times"></i> Close
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Save
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        name:'Detail',
        data() {
            return {
                projectData: {},
                formData: {
                    project_id: this.$route.params.id,
                    user_id: []
                },
                users: [],
                labelModal: "Add"
            }
        },

        mounted() {
            this.getData()
            this.getDataUser()
        },
        methods: {
            async assignUser() {
                try {
                    this.$vs.loading()
                    const respSave = await this.$axios.post('api/project/assign-user-to-project', this.formData)
                    this.$vs.loading.close()
                    if (!respSave.status) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: respSave.message,
                            showConfirmButton: false,
                            timer: 1500
                        })
                    } else {
                        $("#addProject").modal("hide")
                        Swal.fire({
                            position: 'top',
                            icon: 'success',
                            title: respSave.message,
                            showConfirmButton: false,
                            timer: 1500
                        }).then(async ()=>{
                            this.user_id = []
                            await this.getData()
                        })
                    }
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
            },
            showAssignModal() {
                $("#addProject").modal("show")
            },
            async getData() {
                try {
                    this.$vs.loading()
                    const respDe = await this.$axios.get(`api/project/${this.$route.params.id}/detail`)
                    this.$vs.loading.close()

                    if (!respDe.status) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: respDe.message,
                            showConfirmButton: false,
                            timer: 1500
                        })
                    } else {
                        this.projectData = respDe.data
                    }
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
            },
            async getDataUser() {
                try {
                    this.$vs.loading()
                    this.users = await this.$axios.get(`api/configuration/user/not-admin`)
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
            },
            async handleDelete(id) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Are You Sure Want To delete user from This Project?',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    showCloseButton: true,
                    showCancelButton: true,
                }).then((result)=>{
                    if(result.isConfirmed == true){
                        this.$vs.loading()
                        this.$axios.delete(`api/project/${id}/unassign`).then((response)=>{
                            this.$vs.loading.close()
                            if(response.status){
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: response.message,
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    allowEnterKey: false
                                }).then(async (res)=>{
                                    if(res.isConfirmed == true) await this.getData()
                                })
                            }else{
                                Swal.fire({
                                    icon: "error",
                                    title: "Opps...",
                                    text: "Failed To Delete the user form this project : " + response.message ,
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    allowEnterKey: false,
                                });
                            }
                        });
                    }
                })
            }
        }
    }
</script>
