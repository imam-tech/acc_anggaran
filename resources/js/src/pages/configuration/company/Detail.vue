<template>
    <div v-if="companyData" class="container-fluid">
        <div class="card">
            <div class="card-title">
                <h1 class="h3 mt-3 ml-3 text-gray-800 float-left">Company Detail</h1>
                <router-link to="/app/configuration/company" class="btn btn-success float-right mt-3 mr-3">
                    <i class="fas fa-arrow-left"></i> Back
                </router-link>
                <button v-if="$store.state.permissions.includes('company_set_admin')" type="button" class="btn btn-primary  float-right mt-3 mr-3" @click="changeAdminApproval()">
                    <i class="fas fa-reply-all"></i> Change Admin Approval
                </button>
                <router-link :to="'/app/configuration/company/'+$route.params.id+'/admin'" v-if="$store.state.permissions.includes('transaction_push_plugin')" type="button" class="btn btn-success  float-right mt-3 mr-3">
                    <i class="fas fa-eye"></i> View Transaction
                </router-link>
                <router-link v-if="companyData.company_admins[0].user" :to="`/app/transaction/create/form?companyId=${$route.params.id}`" type="button" class="btn btn-warning  float-right mt-3 mr-3">
                    <i class="fas fa-plus-circle"></i> Add Transaction
                </router-link>

            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th colspan="2" class="text-center">Details</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th>Title</th>
                                <td class="text-right">{{companyData.title}}</td>
                            </tr>
                            <tr>
                                <th>Type</th>
                                <td class="text-right">{{companyData.type}}</td>
                            </tr>
                            <tr>
                                <th>Voucher Prefix</th>
                                <td class="text-right">{{companyData.voucher_prefix}}</td>
                            </tr>
                            <tr>
                                <th>User Count</th>
                                <td class="text-right">{{companyData.projects.length}} Projects</td>
                            </tr>
                            <tr>
                                <th>Setting Flip</th>
                                <td class="text-right d-flex flex-column">
                                    <span v-if="companyData.setting_flip">{{ companyData.setting_flip.flip_name }}</span>
                                    <span v-else> - </span>
                                    <button v-if="$store.state.permissions.includes('transaction_push_plugin')" type="button" class="btn btn-primary  float-right mt-3 mr-3" @click="handleChangeSettingFlip()">
                                        <i class="fas fa-gear"></i> Connect Flip
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-lg-6">
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
                            <i class="fas fa-plus-circle"></i> Add Project
                        </button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Title</th>
                            <th class="text-center">Description</th>
                            <th class="text-center">Created At</th>
                            <th class="text-center">#</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-show="companyData.projects.length == 0">
                            <td colspan="5" class="text-center">
                                Empty Project
                            </td>
                        </tr>
                        <tr v-for="(project, key) in companyData.projects" :key="key">
                            <td class="text-center"><strong>{{ key+1 }}</strong></td>
                            <td>{{ project.title }}</td>
                            <td>{{ project.description }}</td>
                            <td>{{ project.created_at | formatDate }}</td>
                            <td class="text-right">
                                <router-link :to="'/app/configuration/project/'+project.id+'/'+companyData.id+'/detail'" class="btn btn-info">
                                    <i class="fas fa-eye"></i>
                                </router-link>
                                <button v-if="$store.state.permissions.includes('project_edit')" class="btn btn-warning" type="button" @click="showEditModal(project)">
                                    <i class="fas fa-pencil-alt"></i>
                                </button>
                                <button v-if="$store.state.permissions.includes('project_delete')" class="btn btn-danger" type="button" @click="handleDelete(project.id)">
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
                            <form @submit.prevent="submitProject">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">{{ labelModal }} Project</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>Title<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                        <input type="text" class="form-control" v-model="formData.title" placeholder="Title of Project" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Description<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                        <input type="text" class="form-control" v-model="formData.description" placeholder="Description of Project" required>
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
                <div class="modal fade" id="adminApproval" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" >Change Admin Approval</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form @submit.prevent="handleAdminApproval">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>Finance Manager<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                        <select class="form-control" v-model="formAdmin.finance_manager" required>
                                            <option v-for="(userData, index) in userNotStafs" :key="index" :value="userData.id">{{ userData.email }}</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Finance Staff<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                        <select class="form-control" v-model="formAdmin.finance_staff" required>
                                            <option v-for="(userData, index) in userNotStafs" :key="index" :value="userData.id">{{ userData.email }}</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Tax Admin<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                        <select class="form-control" v-model="formAdmin.tax_admin" required>
                                            <option v-for="(userData, index) in userNotStafs" :key="index" :value="userData.id">{{ userData.email }}</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Accounting Admin<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                        <select class="form-control" v-model="formAdmin.accounting_admin" required>
                                            <option v-for="(userData, index) in userNotStafs" :key="index" :value="userData.id">{{ userData.email }}</option>
                                        </select>
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
                <div class="modal fade" id="changeSettingFlip" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Add Setting</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form @submit.prevent="handleSubmitChangeSettingFlip">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>Flip Account<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                        <select class="form-control" v-model="settingFlipId" required>
                                            <option v-for="(settingFlip, index) in settingFlips" :key="index" :value="settingFlip.id">{{ settingFlip.flip_name }}</option>
                                        </select>
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
                companyData: "",
                formData: {
                    id: "",
                    company_id: this.$route.params.id,
                    title: "",
                    description: ""
                },
                labelModal: "Add",
                formAdmin: {
                    finance_manager: "",
                    finance_staff: "",
                    tax_admin: "",
                    accounting_admin:""
                },
                userNotStafs: [],
                settingFlipId: "",
                settingFlips: []
            }
        },

        mounted() {
            this.getData()
            this.getDataUserNotStaf()
        },
        methods: {
            async handleSubmitChangeSettingFlip() {
                try {
                    this.$vs.loading()
                    const respSave = await this.$axios.get(`api/configuration/company/${this.$route.params.id}/change-setting-flip/${this.settingFlipId}`)
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
                        $("#changeSettingFlip").modal("hide")
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

            handleChangeSettingFlip() {
                $("#changeSettingFlip").modal("show")
            },

            changeAdminApproval() {
                this.formAdmin.finance_manager = this.companyData.company_admins.find(x => x.name === 'finance_manager') ? (this.companyData.company_admins.find(x => x.name === 'finance_manager')).user_id : ""
                this.formAdmin.finance_staff = this.companyData.company_admins.find(x => x.name === 'finance_staff') ? (this.companyData.company_admins.find(x => x.name === 'finance_staff')).user_id : ""
                this.formAdmin.tax_admin = this.companyData.company_admins.find(x => x.name === 'tax_admin') ? (this.companyData.company_admins.find(x => x.name === 'tax_admin')).user_id : ""
                this.formAdmin.accounting_admin = this.companyData.company_admins.find(x => x.name === 'accounting_admin') ? (this.companyData.company_admins.find(x => x.name === 'accounting_admin')).user_id : ""
                $("#adminApproval").modal("show")
            },

            async handleAdminApproval() {
                try {
                    this.$vs.loading()
                    const respSave = await this.$axios.post('api/configuration/company/admin-approval', {
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
                    this.userNotStafs = await this.$axios.get(`api/configuration/user/not-staff`)
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
                    const respDe = await this.$axios.get(`api/configuration/company/${this.$route.params.id}/detail`)
                    this.settingFlips = await this.$axios.get(`api/configuration/flip`)
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
                        this.$axios.delete(`api/configuration/company/${id}/unassign`).then((response)=>{
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
