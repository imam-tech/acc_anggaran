<template>
    <div class="container-fluid">

        <div class="card shadow mb-4">
            <div class="card-title">
                <h1 class="h3 mt-3 ml-3 text-gray-800 float-left">User List</h1>
                <button v-if="$store.state.permissions.includes('user_create')" type="button" class="btn btn-primary float-right mr-3 mt-3" @click="showAddUser()">
                    <i class="fa fa-plus-circle"></i> User
                </button>
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
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Created At</th>
                            <th v-if="$store.state.permissions.includes('user_create')">#</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(user, index) in users" :key="index">
                            <td>{{ user.name }}</td>
                            <td>{{ user.email}}</td>
                            <td>
                                <button v-if="$store.state.permissions.includes('user_role')" type="button" class="btn btn-primary" @click="changeRole(user)">
                                    <i class="fa fa-repeat"></i>
                                </button>
                                {{ user.role ? user.role.title : 'No Role'}}
                            </td>
                            <td>{{ user.created_at | formatDate }}</td>
                            <td v-if="$store.state.permissions.includes('user_create')">
                                <button type="button" class="btn btn-warning" @click="showEditUser(user)">
                                    <i class="fa fa-pencil"></i>
                                </button>
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
        <div class="modal fade" id="addUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ labelModal }} User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <form>
                            <div class="form-group">
                                <label>Name<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                <input type="text" class="form-control" v-model="formData.name" placeholder="Name of User">
                            </div>
                            <div class="form-group">
                                <label>Email<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                <input type="email" class="form-control" v-model="formData.email" placeholder="Email of User">
                            </div>
                            <div v-if="!formData.id" class="form-group">
                                <label>Password<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                <input type="password" class="form-control" v-model="formData.password" placeholder="Password of User">
                            </div>
                            <div v-if="!formData.id" class="form-group">
                                <label>Password Confirmation<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                <input type="password" class="form-control" v-model="formData.password_confirmation" placeholder="Password of User">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer flex justify-content-between">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="submitUser()">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="changeRole" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Change Role</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <form>
                            <div class="form-group">
                                <label>Role<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                <select class="form-control" v-model="formRole.role_id">
                                    <option v-for="(role, index) in roles" :value="role.id" :key="index">{{ role.title }}</option>
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer flex justify-content-between">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="handleChangeRole()">Save changes</button>
                    </div>
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
                users: [],
                roles: [],
                labelModal: "Add",
                formData: {
                    id: "",
                    name: "",
                    email: "",
                    password: "",
                    password_confirmation: ""
                },
                formRole: {
                    role_id: "",
                    user_id: ""
                }
            }
        },
        created() {
            this.getData()
            this.getDataRole()
        },
        methods: {
            changeRole(user) {
                this.formRole.user_id = user.id
                this.formRole.role_id = user.role_id
                $("#changeRole").modal("show")
            },
            async getData() {
                try {
                    this.$vs.loading()
                    this.users = await this.$axios.get('api/user')
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
            async getDataRole() {
                try {
                    this.$vs.loading()
                    this.roles = await this.$axios.get('api/accounting/index-role')
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
            showEditUser(user) {
                this.labelModal = 'Edit'
                this.formData.id = user.id
                this.formData.name = user.name
                this.formData.email = user.email
                $("#addUser").modal("show")
            },
            showAddUser() {
                this.labelModal = 'Add'
                this.formData.id = ""
                this.formData.name = ""
                this.formData.password = ''
                this.formData.password_confirmation = ''
                this.formData.amount = ''
                $("#addUser").modal("show")
            },
            async handleChangeRole() {
                try {
                    this.$vs.loading()
                    const respSave = await this.$axios.post('api/accounting/change-role', this.formRole)
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
                        $("#changeRole").modal("hide")
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
            async submitUser() {
                try {
                    if (!this.formData.id) {
                        if (this.formData.password !== this.formData.password_confirmation) {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'error',
                                title: "Password is not same with password confirmation",
                                showConfirmButton: false,
                                timer: 1500
                            })
                            return
                        }
                    }
                    this.$vs.loading()
                    const respSave = await this.$axios.post('api/user', this.formData)
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
                        $("#addUser").modal("hide")
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
            async handleDelete(id) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Are You Sure Want To Delete This User?',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    showCloseButton: true,
                    showCancelButton: true,
                }).then((result)=>{
                    if(result.isConfirmed == true){
                        this.$vs.loading()
                        this.$axios.delete(`api/user/${id}/delete`).then((response)=>{
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
                                    text: "Failed To Delete User : " + response.message ,
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