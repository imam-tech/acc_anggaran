<template>
    <div class="container-fluid">

        <div class="card shadow mb-4">
            <div class="card-title">
                <h1 class="h3 mt-3 ml-3 text-gray-800 float-left">Taxes List</h1>
                <button v-if="$store.state.permissions.includes('tax_create')" type="button" class="btn btn-primary float-right mr-3 mt-3" @click="showAddTax()">
                    <i class="fas fa-plus-circle"></i> Tax
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
                    <table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th class="text-center">Title</th>
                            <th class="text-center">Type</th>
                            <th class="text-center">Amount</th>
                            <th class="text-center">Sell Account</th>
                            <th class="text-center">Buy Account</th>
                            <th class="text-center">Created At</th>
                            <th class="text-center"><b>Is Archived?</b></th>
                            <th v-if="$store.state.permissions.includes('tax_create')" class="text-center">#</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(tax, index) in taxes" :key="index">
                            <td>{{ tax.title }}</td>
                            <td>{{ tax.type}}</td>
                            <td class="text-right">{{ tax.amount }}</td>
                            <td>{{ tax.sell_coa ? tax.sell_coa.account_code : "-"}}</td>
                            <td>{{ tax.buy_coa ? tax.buy_coa.account_code : "-"}}</td>
                            <td>{{ tax.created_at | formatDate }}</td>
                            <td class="text-center">
                                <span v-if="tax.is_archive" class="badge badge-danger p-3">Yes</span>
                                <span v-else class="badge badge-primary p-3">No</span>
                            </td>
                            <td v-if="$store.state.permissions.includes('tax_edit')" class="text-right">
                                <button type="button" class="btn btn-warning" @click="showEditTax(tax)">
                                    <i class="fas fa-pencil-alt"></i>
                                </button>
                                <button v-if="tax.sale_product === null && tax.purchase_product === null" class="btn btn-danger" type="button" @click="handleDelete(tax.id)">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <button v-else @click="handleArchive(tax)" class="btn btn-secondary" type="button">
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
        <div class="modal fade" id="addTax" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ labelModal }} Tax</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="submitTax">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Title<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                <input type="text" class="form-control" v-model="formData.title" placeholder="Example: PPN 11" required>
                            </div>
                            <div class="form-group">
                                <label>Type<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                <select v-model="formData.type" class="form-control" required>
                                    <option value="" selected>--Select type of tax--</option>
                                    <option value="ppn">PPn</option>
                                    <option value="pph">PPh</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Amount (in %)<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                <input type="text" class="form-control" v-model="formData.amount" placeholder="Example: 2.8" required>
                            </div>
                            <div class="form-group">
                                <label>Sell Tax Account</label>
                                <v-select v-model="formData.sell_account_id" :options="sellCoas" :reduce="p => p.id" style="width: 100%" label="account_code">
                                    <template #search="{attributes, events}">
                                        <input
                                                class="vs__search"
                                                :required="!formData.sell_account_id"
                                                v-bind="attributes"
                                                v-on="events"
                                        />
                                    </template>
                                    <span slot="no-options">Account not found</span>
                                </v-select>
                            </div>
                            <div class="form-group">
                                <label>Buy Tax Account</label>
                                <v-select v-model="formData.buy_account_id" :options="buyCoas" :reduce="p => p.id" style="width: 100%" label="account_code">
                                    <template #search="{attributes, events}">
                                        <input
                                                class="vs__search"
                                                :required="!formData.buy_account_id"
                                                v-bind="attributes"
                                                v-on="events"
                                        />
                                    </template>
                                    <span slot="no-options">Account not found</span>
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
</template>

<script>
    export default {
        name: "Index.vue",
        data() {
            return {
                taxes: [],
                labelModal: "Add",
                formData: {
                    id: "",
                    title: "",
                    amount: "",
                    type: "",
                    sell_account_id: '',
                    buy_account_id: ''
                },
                sellCoas: [],
                buyCoas: []
            }
        },
        created() {
            this.getData()
        },
        methods: {
            async handleGetAccount() {
                this.$vs.loading()
                this.sellCoas = await this.$axios.get(`api/master-data/coa?is_active=1&coa_name=HUTANG PAJAK`)
                this.buyCoas = await this.$axios.get(`api/master-data/coa?is_active=1&coa_name=PAJAK DIBAYAR DIMUKA`)
                this.$vs.loading.close()
            },

            async getData() {
                try {
                    this.$vs.loading()
                    this.taxes = await this.$axios.get('api/master-data/taxes')
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
            showEditTax(tax) {
                if (this.sellCoas.length === 0) {
                    this.handleGetAccount()
                }
                this.labelModal = 'Edit'
                this.formData = tax
                $("#addTax").modal("show")
            },
            showAddTax() {
                if (this.sellCoas.length === 0) {
                    this.handleGetAccount()
                }
                this.labelModal = 'Add'
                this.formData.id = ""
                this.formData.title = ""
                this.formData.type = ''
                this.formData.amount = ''
                $("#addTax").modal("show")
            },
            async submitTax() {
                try {
                    this.$vs.loading()
                    const respSave = await this.$axios.post('api/master-data/taxes', this.formData)
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
                        $("#addTax").modal("hide")
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
                    title: 'Are You Sure Want To Delete This Tax?',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    showCloseButton: true,
                    showCancelButton: true,
                }).then((result)=>{
                    if(result.isConfirmed == true){
                        this.$vs.loading()
                        this.$axios.delete(`api/master-data/taxes/${id}/delete`).then((response)=>{
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
                                    text: "Failed To Delete Tax : " + response.message ,
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
                    title: `Are You Sure Want To ${p.is_archive ? 'Un Archive' : 'Archive'} This Tax?`,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    showCloseButton: true,
                    showCancelButton: true,
                }).then((result)=>{
                    if(result.isConfirmed == true){
                        this.$vs.loading()
                        this.$axios.get(`api/master-data/taxes/${p.id}/archive`).then((response)=>{
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
                                    text: "Failed To Archive Tax : " + response.message ,
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