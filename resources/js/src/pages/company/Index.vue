<template>
    <div class="container-fluid">

        <div class="card shadow mb-4">
            <div class="card-title">
                <h1 class="h3 mt-3 ml-3 text-gray-800 float-left">Company List</h1>
                <button v-if="$store.state.permissions.includes('company_create')" type="button" class="btn btn-primary float-right mr-3 mt-3" @click="showAddCompany()">
                    <i class="fa fa-plus-circle"></i> Company
                </button>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-4 mb-3" v-for="(company, index) in companies" :key="index">
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
                    <form @submit.prevent="submitCompany">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Title<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                <input type="text" class="form-control" v-model="formData.title" placeholder="Title of Company" required>
                            </div>
                            <div class="form-group">
                                <label>Type<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                <select v-model="formData.type" class="form-control" required>
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
                                <input type="text" class="form-control" v-model="formData.voucherPrefix" placeholder="Example: PTA" required>
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
                    if (this.companies.length === 0) {
                        if (this.$route.query.show_create !==  undefined && this.$store.state.roles === 'administrator') {
                            $("#addCompany").modal("show")
                        }
                    }
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
                    if (this.formData.voucherPrefix.length > 3) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: "Maximum character of Voucher Prefix is 4",
                            showConfirmButton: false,
                            timer: 1500
                        })
                        return
                    }
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