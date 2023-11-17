<template>
    <div class="container-fluid">

        <div class="card shadow mb-4">
            <div class="card-title">
                <h1 class="h3 mt-3 ml-3 text-gray-800 float-left">Company List</h1>
                <button v-if="$store.state.permissions.includes('company_create')" type="button" class="btn btn-primary float-right mr-3 mt-3" @click="showAddCompany()">
                    <i class="fa fa-plus-circle"></i> Company
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
                <div class="row">
                    <div class="col-4" v-for="(company, index) in companies" :key="index">
                        <router-link :to="'/app/company/'+company.id+'/detail'">
                            <div class="card">
                                <div class="card-body shadow-lg">
                                    <h5 class="card-title">{{ company.title }}</h5>
                                    <div class="d-flex">
                                        <span class="avatar">
                                            <i class="fas fa-user"></i>
                                        </span>
                                        <span class="align-content-center ml-2">
                                            {{ company.projects.length }} Project
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </router-link>
                    </div>
                </div>
                <div class="table-responsive">
                    <!--<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">-->
                        <!--<thead>-->
                        <!--<tr>-->
                            <!--<th>Title</th>-->
                            <!--<th>Type</th>-->
                            <!--<th>Voucher Prefix</th>-->
                            <!--<th>Project Count</th>-->
                            <!--<th>Created At</th>-->
                            <!--<th>#</th>-->
                        <!--</tr>-->
                        <!--</thead>-->
                        <!--<tbody>-->
                        <!--<tr v-for="(company, index) in companies" :key="index">-->
                            <!--<td>{{ company.title }}</td>-->
                            <!--<td>{{ company.type === 'pt' ? 'PT' : 'Yayasan' }}</td>-->
                            <!--<td>{{ company.voucher_prefix }}</td>-->
                            <!--<td>{{ company.projects.length }} Project</td>-->
                            <!--<td>{{ company.created_at | formatDate }}</td>-->
                            <!--<td>-->
                                <!--<router-link :to="'/app/company/'+company.id+'/detail'" class="btn btn-info">-->
                                    <!--<i class="fa fa-eye"></i>-->
                                <!--</router-link>-->
                                <!--<button v-if="$store.state.permissions.includes('company_edit')" type="button" class="btn btn-warning" @click="showEditCompany(company)">-->
                                    <!--<i class="fa fa-pencil"></i>-->
                                <!--</button>-->
                                <!--<button v-if="$store.state.permissions.includes('company_delete')" class="btn btn-danger" type="button" @click="handleDelete(company.id)">-->
                                    <!--<i class="fa fa-minus"></i>-->
                                <!--</button>-->
                            <!--</td>-->
                        <!--</tr>-->
                        <!--</tbody>-->
                    <!--</table>-->
                    <!--<div class="justify-content-center d-flex">-->
                        <!--<pagination v-model="page" :records="totalData" :per-page="perPage" @paginate="getData"/>-->
                    <!--</div>-->
                </div>
            </div>
        </div>
    <!-- /.container-fluid -->
        <div class="modal fade" id="addCompany" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ labelModal }} Company</h5>
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
                                <input type="text" class="form-control" v-model="formData.title" placeholder="Title of Company">
                            </div>
                            <div class="form-group">
                                <label>Type<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                <select v-model="formData.type" class="form-control">
                                    <option value="" selected>--Select type of company--</option>
                                    <option value="pt">PT</option>
                                    <option value="yayasan">Yayasan</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Voucher Prefix<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                <input type="text" class="form-control" v-model="formData.voucherPrefix" placeholder="Example: PTA">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer flex justify-content-between">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="submitCompany()">Save changes</button>
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
                companies: [],
                labelModal: "Add",
                formData: {
                    id: "",
                    title: "",
                    voucherPrefix: "",
                    type: ""
                }
            }
        },
        created() {
            this.getData()
        },
        methods: {
            async getData() {
                try {
                    this.$vs.loading()
                    this.companies = await this.$axios.get('api/company')
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
            showEditCompany(company) {
                this.labelModal = 'Edit'
                this.formData.id = company.id
                this.formData.title = company.title
                this.formData.type = company.type
                this.formData.voucherPrefix = company.voucher_prefix
                $("#addCompany").modal("show")
            },
            showAddCompany() {
                this.labelModal = 'Add'
                this.formData.id = ""
                this.formData.title = ""
                this.formData.type = ''
                this.formData.voucherPrefix = ''
                $("#addCompany").modal("show")
            },
            async submitCompany() {
                try {
                    this.$vs.loading()
                    const respSave = await this.$axios.post('api/company', this.formData)
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
                        $("#addCompany").modal("hide")
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
                    title: 'Are You Sure Want To Delete This Company?',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    showCloseButton: true,
                    showCancelButton: true,
                }).then((result)=>{
                    if(result.isConfirmed == true){
                        this.$vs.loading()
                        this.$axios.delete(`api/company/${id}/delete`).then((response)=>{
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
                                    text: "Failed To Delete company : " + response.message ,
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