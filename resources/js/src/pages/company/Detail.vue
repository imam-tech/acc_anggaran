<template>
    <div class="container-fluid">
        <div class="card">
            <div class="card-title">
                <h1 class="h3 mt-3 ml-3 text-gray-800 float-left">Company Detail</h1>
                <router-link to="/app/company" class="btn btn-success float-right mt-3 mr-3">
                    <i class="fa fa-arrow-left"></i> Back
                </router-link>
                <button v-if="$store.state.permissions.includes('company_set_admin')" type="button" class="btn btn-primary  float-right mt-3 mr-3" @click="changeAdminApproval()">
                    <i class="fa fa-reply-all"></i> Change Admin Approval
                </button>
                <router-link :to="'/app/company/'+$route.params.id+'/admin'" v-if="$store.state.permissions.includes('transaction_push_plugin')" type="button" class="btn btn-success  float-right mt-3 mr-3" @click="changeAdminApproval()">
                    <i class="fa fa-eye"></i> View Transaction
                </router-link>
                <router-link :to="'/app/transaction/'+$route.params.id+'/form'" type="button" class="btn btn-warning  float-right mt-3 mr-3">
                    <i class="fa fa-plus-circle"></i> Add Transaction
                </router-link>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th colspan="2" class="text-center">Details</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th>Title</th>
                                <td>{{companyData.title}}</td>
                            </tr>
                            <tr>
                                <th>Type</th>
                                <td>{{companyData.type}}</td>
                            </tr>
                            <tr>
                                <th>Voucher Prefix</th>
                                <td>{{companyData.voucher_prefix}}</td>
                            </tr>
                            <tr>
                                <th>User Count</th>
                                <td>{{companyData.projects.length}} Projects</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-6">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th colspan="2" class="text-center">Admin Approval</th>
                                </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(companyAdmin, index) in companyData.company_admins" :key="index">
                                <th>
                                    <div v-if="companyAdmin.user">
                                        <div class="d-flex">
                                            <div>
                                            <span class="avatar">{{ companyAdmin.user.name | getShortName }}</span>
                                            </div>
                                            <div class="ml-2 d-flex flex-column">
                                                <span>{{ companyAdmin.user.name }}</span>
                                                <span>{{ companyAdmin.user.email }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div v-else>
                                        --Not Assign--
                                    </div>
                                </th>
                                <td class="text-right">{{ companyAdmin.title }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <h3 class="h3 text-gray-800 float-left">Project List</h3>
                        <button v-if="$store.state.permissions.includes('project_create')" type="button" class="btn btn-primary float-right mb-2" @click="showAddModal()">
                            <i class="fa fa-plus-circle"></i> Add Project
                        </button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Created At</th>
                            <th>#</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-show="companyData.projects.length == 0">
                            <td colspan="5" class="text-center">
                                Empty Project
                            </td>
                        </tr>
                        <tr v-for="(project, key) in companyData.projects" :key="key">
                            <td><strong>{{ key+1 }}</strong></td>
                            <td>{{ project.title }}</td>
                            <td>{{ project.description }}</td>
                            <td>{{ project.created_at | formatDate }}</td>
                            <td>
                                <router-link :to="'/app/project/'+project.id+'/detail'" class="btn btn-info">
                                    <i class="fa fa-eye"></i>
                                </router-link>
                                <button v-if="$store.state.permissions.includes('project_edit')" class="btn btn-warning" type="button" @click="showEditModal(project)">
                                    <i class="fa fa-pencil"></i>
                                </button>
                                <button v-if="$store.state.permissions.includes('project_delete')" class="btn btn-danger" type="button" @click="handleDelete(project.id)">
                                    <i class="fa fa-minus"></i>
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
                                <h5 class="modal-title" id="exampleModalLabel">{{ labelModal }} Project</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">

                                <form>
                                    <div class="form-group">
                                        <label>Title<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                        <input type="text" class="form-control" v-model="formData.title" placeholder="Title of Project">
                                    </div>
                                    <div class="form-group">
                                        <label>Description<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                        <input type="text" class="form-control" v-model="formData.description" placeholder="Description of Project">
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer flex justify-content-between">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" @click="submitProject()">Save changes</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="adminApproval" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Change Admin Approval</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">

                                <form>
                                    <div class="form-group">
                                        <label>Finance Manager<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                        <select class="form-control" v-model="formAdmin.finance_manager">
                                            <option v-for="(userData, index) in userNotStafs" :key="index" :value="userData.id">{{ userData.email }}</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Finance Staf<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                        <select class="form-control" v-model="formAdmin.finance_staf">
                                            <option v-for="(userData, index) in userNotStafs" :key="index" :value="userData.id">{{ userData.email }}</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Tax Admin<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                        <select class="form-control" v-model="formAdmin.tax_admin">
                                            <option v-for="(userData, index) in userNotStafs" :key="index" :value="userData.id">{{ userData.email }}</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Accounting Admin<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                        <select class="form-control" v-model="formAdmin.accounting_admin">
                                            <option v-for="(userData, index) in userNotStafs" :key="index" :value="userData.id">{{ userData.email }}</option>
                                        </select>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer flex justify-content-between">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" @click="handleAdminApproval()">Save changes</button>
                            </div>
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
                companyData: {},
                formData: {
                    id: "",
                    company_id: this.$route.params.id,
                    title: "",
                    description: ""
                },
                labelModal: "Add",
                formAdmin: {
                    finance_manager: "",
                    finance_staf: "",
                    tax_admin: "",
                    accounting_admin:""
                },
                userNotStafs: []
            }
        },

        mounted() {
            this.getData()
            this.getDataUserNotStaf()
        },
        methods: {
            changeAdminApproval() {
                this.formAdmin.finance_manager = this.companyData.company_admins.find(x => x.name === 'finance_manager') ? (this.companyData.company_admins.find(x => x.name === 'finance_manager')).user_id : ""
                this.formAdmin.finance_staf = this.companyData.company_admins.find(x => x.name === 'finance_staf') ? (this.companyData.company_admins.find(x => x.name === 'finance_staf')).user_id : ""
                this.formAdmin.tax_admin = this.companyData.company_admins.find(x => x.name === 'tax_admin') ? (this.companyData.company_admins.find(x => x.name === 'tax_admin')).user_id : ""
                this.formAdmin.accounting_admin = this.companyData.company_admins.find(x => x.name === 'accounting_admin') ? (this.companyData.company_admins.find(x => x.name === 'accounting_admin')).user_id : ""
                $("#adminApproval").modal("show")
            },

            async handleAdminApproval() {
                try {
                    this.$vs.loading()
                    const respSave = await this.$axios.post('api/company/admin-approval', {
                        company_id: this.companyData.id,
                        admins:this.formAdmin
                    })
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
                        $("#adminApproval").modal("hide")
                        Swal.fire({
                            position: 'top',
                            icon: 'success',
                            title: respSave.message,
                            showConfirmButton: false,
                            timer: 1500
                        }).then(async ()=>{
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
            async submitProject() {
                try {
                    this.$vs.loading()
                    const respSave = await this.$axios.post('api/project', this.formData)
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
            showEditModal(project) {
                this.labelModal = 'Edit'
                this.formData.id = project.id
                this.formData.title = project.title
                this.formData.description = project.description
                $("#addProject").modal("show")
            },
            showAddModal() {
                this.labelModal = 'Add'
                this.formData.id = ""
                this.formData.title = ""
                this.formData.description = ""
                $("#addProject").modal("show")
            },
            async getDataUserNotStaf() {
                try {
                    this.$vs.loading()
                    this.userNotStafs = await this.$axios.get(`api/user/not-staff`)
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
            async getData() {
                try {
                    this.$vs.loading()
                    const respDe = await this.$axios.get(`api/company/${this.$route.params.id}/detail`)
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
                        this.companyData = respDe.data
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
            async handleDelete(id) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Are You Sure Want To delete user from This Company?',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    showCloseButton: true,
                    showCancelButton: true,
                }).then((result)=>{
                    if(result.isConfirmed == true){
                        this.$vs.loading()
                        this.$axios.delete(`api/company/${id}/unassign`).then((response)=>{
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
                                    text: "Failed To Delete the user form this company : " + response.message ,
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
