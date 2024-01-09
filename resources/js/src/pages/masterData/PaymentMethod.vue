<template>
    <div class="container-fluid">

        <div class="card shadow mb-4">
            <div class="card-title">
                <h1 class="h3 mt-3 ml-3 text-gray-800 float-left">Payment Methods</h1>
                <button  type="button" class="btn btn-primary float-right mr-3 mt-3" @click="showAddSetting()">
                    <i class="fas fa-plus-circle"></i> Create New Payment Methods
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th class="text-center">Name</th>
                            <th class="text-center"><b>Is Archived?</b></th>
                            <th class="text-center">Created At</th>
                            <th v-if="$store.state.permissions.includes('transaction_push_plugin')" class="text-center">#</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(pM, index) in paymentMethods" :key="index">
                            <td>{{ pM.name }}</td>
                            <td class="text-center">
                                <span v-if="pM.is_archive" class="badge badge-danger p-3">Yes</span>
                                <span v-else class="badge badge-primary p-3">No</span>
                            </td>
                            <td>{{ pM.created_at | formatDate }}</td>
                            <td v-if="$store.state.permissions.includes('transaction_push_plugin')" class="text-right">
                                <button type="button" class="btn btn-warning" @click="showEditSetting(pM)">
                                    <i class="fas fa-pencil-alt"></i>
                                </button>
                                <button v-if="pM.sales_payment === null && pM.purchase_payment === null"
                                        class="btn btn-danger" type="button" @click="handleDelete(pM.id)">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <button v-else @click="handleArchive(pM)" class="btn btn-secondary" type="button">
                                    <i class="fas fa-archive"></i>
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
        <div class="modal fade" id="addSetting" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ labelModal }} Payment Method</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="submitSetting">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Name<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                <input type="text" class="form-control" v-model="formData.name" required>
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
                paymentMethods: [],
                labelModal: "Add",
                formData: {
                    id: "",
                    name: "",
                },
            }
        },
        created() {
            // if (!this.$store.state.permissions.includes('transaction_push_plugin')) {
            //     Swal.fire({
            //         position: 'top',
            //         icon: 'error',
            //         title: 'You don\'t have an access this page',
            //         showConfirmButton: false,
            //         timer: 3000
            //     }).then(async ()=>{
            //         this.$router.push('/app/')
            //     })
            //     return
            // }
            this.getData()
        },
        methods: {
            async getData() {
                try {
                    this.$vs.loading()
                    this.paymentMethods = await this.$axios.get('api/master-data/payment-method')
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
            showEditSetting(tax) {
                this.labelModal = 'Edit'
                this.formData.id = tax.id
                this.formData.name = tax.name
                $("#addSetting").modal("show")
            },
            showAddSetting() {
                this.labelModal = 'Add'
                this.formData.id = ""
                this.formData.name = ""
                $("#addSetting").modal("show")
            },
            async submitSetting() {
                try {
                    this.$vs.loading()
                    const respSave = await this.$axios.post('api/master-data/payment-method', this.formData)
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
                        $("#addSetting").modal("hide")
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
                    title: 'Are You Sure Want To Delete This Payment Method?',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    showCloseButton: true,
                    showCancelButton: true,
                }).then((result)=>{
                    if(result.isConfirmed == true){
                        this.$vs.loading()
                        this.$axios.delete(`api/master-data/payment-method/${id}/delete`).then((response)=>{
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
                                    text: "Failed To Delete Payment Method : " + response.message ,
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    allowEnterKey: false,
                                });
                            }
                        });
                    }
                })
            },

            async handleArchive(p) {
                Swal.fire({
                    icon: 'warning',
                    title: `Are You Sure Want To ${p.is_archive ? 'Un Archive' : 'Archive'} This Payment Method?`,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    showCloseButton: true,
                    showCancelButton: true,
                }).then((result)=>{
                    if(result.isConfirmed == true){
                        this.$vs.loading()
                        this.$axios.get(`api/master-data/payment-method/${p.id}/archive`).then((response)=>{
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
                                    text: "Failed To Archive Payment Method : " + response.message ,
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