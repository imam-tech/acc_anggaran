<template>
    <div class="container-fluid">

        <div class="card shadow mb-4">
            <div class="card-title">
                <h1 class="h3 mt-3 ml-3 text-gray-800 float-left">Coa List</h1>
                <router-link to="/app/master-data/coa/category">
                    <button type="button" class="btn btn-success float-right mr-3 mt-3">
                        <i class="fas fa-address-book"></i> Coa Category
                    </button>
                </router-link>
                <button type="button" class="btn btn-warning float-right mr-3 mt-3" @click="handleShowUploadCoaBulk()">
                    <i class="fas fa-upload"></i> Bulk Coa
                </button>
                <button v-if="$store.state.permissions.includes('coa_create_edit')" type="button" class="btn btn-primary float-right mr-3 mt-3" @click="showAddCoa()">
                    <i class="fas fa-plus-circle"></i> Coa
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th class="text-center">Account Code</th>
                            <th class="text-center">Account Name</th>
                            <th class="text-center">Category</th>
                            <th class="text-center">Account Type</th>
                            <th class="text-center">Description</th>
                            <th class="text-center">Initial Balance</th>
                            <th class="text-center">Is Active</th>
                            <th v-if="$store.state.permissions.includes('coa_create_edit')" class="text-center">#</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-if="coas.length == 0">
                            <td colspan="8" class="text-center">
                                COA Not Found
                            </td>
                        </tr>
                        <tr v-else v-for="(coa, index) in coas" :key="index">
                            <td>{{ coa.account_number }}</td>
                            <td>
                                <router-link :to="'/app/master-data/coa/' + coa.id + '/detail'">
                                    {{ coa.account_name }}
                                </router-link>
                            </td>
                            <td>{{ coa.coa_category.name }} </td>
                            <td>{{ coa.account_type }}</td>
                            <td>{{ coa.description }}</td>
                            <div class="text-right">
                                <span v-if="coa.initial_balance !== null">{{ coa.initial_balance.debit | formatPriceWithDecimal }}</span>
                                <span v-else>0</span>
                            </div>
                            <td class="text-center">
                                <span :class="coa.is_active === 1 ? 'badge badge-primary' : 'badge badge-danger'">{{ coa.is_active === 1 ? 'Active' : "In Active" }}</span>
                            </td>
                            <td v-if="$store.state.permissions.includes('coa_create_edit')" class="text-right">
                                <button type="button" class="btn btn-warning" @click="showEditCoa(coa)">
                                    <i class="fas fa-pencil-alt"></i>
                                </button>
                                <button v-if="coa.journal_item === null" type="button" class="btn btn-danger" @click="handleDelete(coa.id)">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <button v-if="coa.coa_category.label === 'balance_sheet'" type="button" class="btn btn-success" @click="handleInitialBalance(coa)">
                                    <i class="fas fa-dollar"></i>
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
        <div class="modal fade" id="uploadCoaBulk" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Input Initial Balance</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="handleUploadCoaBulk">
                        <div class="modal-body">
                            <div class="form-group">
                                <label  class="text-danger font-weight-bold font-italic">Template Upload File</label>
                                <label for="">
                                    <a href="https://stage-accounting.sgp1.cdn.digitaloceanspaces.com/Coa%20bulk.xlsx">
                                        <i class="fas fa-link"></i>
                                    </a>
                                </label>
                            </div>
                            <div class="form-group">
                                <label>File COA<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                <input type="file" ref="file" class="form-control" @change="uploadFile" required>
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
        <div class="modal fade" id="addInitialBalance" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Input Initial Balance</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <form>
                            <div class="form-group">
                                <label>Amount<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                <input type="number" class="form-control" v-model="formInitialBalance.amount">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer flex justify-content-between">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="submitInitialBalance()">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="addCoa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ labelModal }} Coa</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="submitCoa">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Category<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                <v-select v-model="formData.category" :options="categories" :reduce="category => category.id" label="label" style="width: 100%">
                                    <template #search="{attributes, events}">
                                        <input
                                            class="vs__search"
                                            :required="!formData.category"
                                            v-bind="attributes"
                                            v-on="events"
                                        />
                                    </template>
                                </v-select>
                            </div>
                            <div class="form-group">
                                <label>Posting<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                <select v-model="formData.posting" class="form-control" required>
                                    <option value="">--Select Posting--</option>
                                    <option v-for="(posting, index) in postings" :key="index" :value="posting.id">{{ posting.name }}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Account Number<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                <input type="text" class="form-control" v-model="formData.account_number" required>
                            </div>
                            <div class="form-group">
                                <label>Account Name<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                <input type="text" class="form-control" v-model="formData.account_name" required>
                            </div>
                            <div class="form-group">
                                <label>Account Type<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                <select v-model="formData.account_type" class="form-control" required>
                                    <option value="" selected>--Select Account Type--</option>
                                    <option value="Debit">Debit</option>
                                    <option value="Credit">Credit</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Is Active?<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                <select v-model="formData.is_active" class="form-control" required>
                                    <option value="1">Active</option>
                                    <option value="0">In Active</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control" v-model="formData.description"></textarea>
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
                coas: [],
                labelModal: "Add",
                formData: {
                    id: "",
                    category: "",
                    posting: "",
                    account_number: "",
                    account_name: "",
                    account_type: "",
                    description: "",
                    is_active: 1
                },
                categories: [],
                postings: [],
                formInitialBalance: {
                    id: "",
                    amount: 0
                },
                excelData: ""
            }
        },
        created() {
            this.getData()
            this.getDataCategory()
        },
        methods: {
            async handleUploadCoaBulk() {
                try {
                    console.log("c", this.excelData)
                    this.$vs.loading()
                    let formDataCoa = new FormData();
                    const config = { headers: {'content-type' : 'multipart/form-data'}}
                    formDataCoa.append('file_excel', this.excelData);
                    const resp = await this.$axios.post(`api/master-data/coa/upload-bulk`, formDataCoa, config)
                    this.$vs.loading.close()
                    if (!resp['status']) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: resp.message,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        return
                    }
                    $('#uploadCoaBulk').modal("hide")
                    this.getData();
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
            uploadFile() {
                this.excelData = this.$refs.file.files[0];
            },
            handleShowUploadCoaBulk() {
                $("#uploadCoaBulk").modal('show')
            },
            handleInitialBalance(coa) {
                this.formInitialBalance.id = coa.id
                if (coa.initial_balance) {
                    this.formInitialBalance.amount = coa.initial_balance.debit
                }
                $("#addInitialBalance").modal("show")
            },
            async submitInitialBalance() {
                try {
                    this.$vs.loading()
                    const resp = await this.$axios.get(`api/master-data/coa/${this.formInitialBalance.id}/set-initial-balance/${this.formInitialBalance.amount}`)
                    this.$vs.loading.close()
                    if (!resp['status']) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: resp.message,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        return
                    }
                    $('#addInitialBalance').modal("hide")
                    this.getData();
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
                    this.coas = await this.$axios.get('api/master-data/coa')
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
            async getDataCategory() {
                try {
                    this.$vs.loading()
                    const cats = await this.$axios.get('api/master-data/coa/category')
                    cats.forEach((x) => {
                        this.categories.push({
                            id: x.id,
                            label: x.code + '-' + x.name
                        })
                    })
                    this.postings = await this.$axios.get('api/master-data/coa/posting')
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
            showEditCoa(coa) {
                this.labelModal = 'Edit'
                this.formData = {
                    id: coa.id,
                    category: coa.category_id,
                    posting: coa.posting_id,
                    account_code: coa.account_code,
                    account_number: coa.account_number,
                    account_name: coa.account_name,
                    account_type: coa.account_type,
                    description: coa.description,
                    is_active: coa.is_active
                }
                $("#addCoa").modal("show")
            },
            showAddCoa() {
                this.labelModal = 'Add'
                this.formData = {
                    id: "",
                    category: "",
                    posting: "",
                    account_number: "",
                    account_name: "",
                    account_type: "",
                    description: "",
                    is_active: 1
                }
                $("#addCoa").modal("show")
            },
            async submitCoa() {
                try {
                    this.$vs.loading()
                    const respSave = await this.$axios.post('api/master-data/coa', this.formData)
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
                        $("#addCoa").modal("hide")
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
                    title: 'Are You Sure Want To Delete This Coa?',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    showCloseButton: true,
                    showCancelButton: true,
                }).then((result)=>{
                    if(result.isConfirmed == true){
                        this.$vs.loading()
                        this.$axios.delete(`api/master-data/coa/${id}/delete`).then((response)=>{
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
                                    text: "Failed To Delete Coa : " + response.message ,
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