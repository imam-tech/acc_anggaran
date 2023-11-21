<template>
    <div v-if="transactionData !== null" class="container-fluid">
        <div class="card">
            <div class="card-title">
                <div class="row">
                    <div class="col-6">
                        <h1 class="h3 mt-3 ml-3 text-primary">{{ transactionData.company.title }}</h1>
                        <p class="ml-3">Team/Project: {{ transactionData.project.title }}</p>
                        <p class="ml-3 text-success">{{ transactionData.current_status.toUpperCase()  }}</p>
                    </div>
                    <div class="col-6 text-right">
                        <router-link to="/app/transaction" class="btn btn-success mt-3 mr-3">
                            <i class="fa fa-arrow-left"></i> Back
                        </router-link>
                        <button v-if="transactionData.current_status === 'requested'" @click="handlePublish()" class="btn btn-primary mt-3 mr-3">
                            <i class="fa fa-check"></i> Publish
                        </button>
                        <p class="mr-3 mt-2">Transaction #{{ transactionData.transaction_number }}</p>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <table class="table table-striped">
                            <tbody>
                            <tr>
                                <th>Created By</th>
                                <td class="text-right">{{transactionData.user_created_by.name}}</td>
                            </tr>
                            <tr>
                                <th>Created At</th>
                                <td class="text-right">{{transactionData.created_at | formatDate}}</td>
                            </tr>
                            <tr>
                                <th>Transaction Date</th>
                                <td class="text-right">{{transactionData.transaction_date ? (transactionData.transaction_date | formatDate) : "-"}}</td>
                            </tr>
                            <tr>
                                <th>Title</th>
                                <td class="text-right">{{transactionData.title}}</td>
                            </tr>
                            <tr>
                                <th>Bank</th>
                                <td class="text-right">{{transactionData.bank}}</td>
                            </tr>
                            <tr>
                                <th>Account Holder</th>
                                <td class="text-right">{{transactionData.account_holder}}</td>
                            </tr>
                            <tr>
                                <th>Account Name</th>
                                <td class="text-right">{{transactionData.account_number}}</td>
                            </tr>
                            <tr>
                                <th>PPn</th>
                                <td class="text-right">Rp. {{transactionData.ppn | formatPriceWithDecimal}}</td>
                            </tr>
                            <tr>
                                <th>PPh</th>
                                <td class="text-right">Rp. {{transactionData.pph | formatPriceWithDecimal}}</td>
                            </tr>
                            <tr>
                                <th>DPP</th>
                                <td class="text-right">Rp. {{transactionData.dpp | formatPriceWithDecimal}}</td>
                            </tr>
                            <tr>
                                <th>TOTAL</th>
                                <td class="text-right">Rp. {{transactionData.total_amount | formatPriceWithDecimal}}</td>
                            </tr>
                            <tr>
                                <th>Transaction Method</th>
                                <td class="text-right">
                                    {{ transactionData.method }} - {{ transactionData.transaction_date }}</span>
                                    <button type="button" @click="handleShowMethod()" class="btn-success"  v-if="$store.state.permissions.includes('transaction_cancel_approval')">
                                        <i class="fas fa-pen-alt"></i>
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Title</th>
                            <th>Attachment</th>
                            <th>Input Total</th>
                            <th>Total</th>
                            <th>#</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-show="transactionData.transaction_items.length == 0">
                            <td colspan="6" class="text-center">
                                Items
                            </td>
                        </tr>
                        <tr v-for="(item, key) in transactionData.transaction_items">
                            <td><strong>{{ key+1 }}</strong></td>
                            <td>{{ item.title }}</td>
                            <td>Attachment</td>
                            <td>Rp. {{ item.input_amount | formatPriceWithDecimal }}</td>
                            <td>Rp. {{ item.total_amount | formatPriceWithDecimal }}</td>
                            <td>
                                <button :disabled="!handleCheckSet(transactionData, 'transaction_edit_tax')" type="button" class="btn btn-info" @click="handleSetTax(item)">
                                    Set Tax
                                </button>
                                <button :disabled="!handleCheckSet(transactionData, 'transaction_edit_coa')"  type="button" class="btn btn-primary" @click="handleSetCoa(item)">
                                    Set Coa
                                </button>
                                <button type="button" class="btn btn-success" @click="handleSetCoa(item, 'view')">
                                    Detail
                                </button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <div class="row" v-if="transactionData.current_status !== 'requested'">
                    <div class="col-12">
                        <table class="table table-striped">
                            <tbody>
                            <tr v-for="(item, index) in transactionData.transaction_approvals" :key="index">
                                <th>
                                    <div class="d-flex">
                                        <span class="avatar align-content-center">{{ item.user.name | getShortName }}</span>
                                        <div class="ml-2">
                                            <label>{{ item.user.name }}</label>
                                            <br>
                                            <label>{{ item.title }}</label>
                                        </div>
                                    </div>
                                </th>
                                <td class="text-right">
                                    <label v-if="transactionData.current_status === 'rejected'">Transaction Rejected</label>
                                    <label v-else>
                                        <button v-if="handleCheckApproval(transactionData, item)" @click="handleApproval(1, item.id)" class="btn btn-primary mt-3 mr-3">
                                            <i class="fa fa-check"></i> Approve
                                        </button>
                                        <button v-if="handleCheckApproval(transactionData, item, 'transaction_edit_tax')" @click="handleApproval(0, item.id)" class="btn btn-danger mt-3 mr-3">
                                            <i class="fa fa-times"></i> Reject
                                        </button>
                                        {{ item.approved_at ? 'Approved at ' + (item.approved_at) : (item.rejected_at ? 'Transaction rejected' : (transactionData.current_status === 'published' && item.user.email === $store.state.email ? "" : 'Waiting Action')) }}
                                    </label>
                                </td>
                            </tr>
                            <tr v-if="$store.state.permissions.includes('transaction_cancel_approval') && transactionData === 'published'">
                                <td colspan="2" class="text-right align-content-center" @click="handleForcedStatus()">
                                    <button class="btn btn-info mt-3 mr-3">
                                        Forced Status
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal fade" id="setMethodModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Change Transaction Method</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">

                                <form>
                                    <div class="row mt-3">
                                        <div class="col-4">
                                            <label>Transaction Method<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                        </div>
                                        <div class="col-8">
                                            <select v-model="formDataMethod.method" class="form-control">
                                                <option value="" selected>--Select Method--</option>
                                                <option value="flip">Flip</option>
                                                <option value="manual">Manual</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mt-3" v-if="formDataMethod.method === 'manual'">
                                        <div class="col-4">
                                            <label>Transaction Date<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                        </div>
                                        <div class="col-8">
                                            <input type="date" class="form-control" v-model="formDataMethod.transaction_date" />
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer flex justify-content-between">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" @click="handleSubmitEditMethod()">Save changes</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="setTaxModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                    <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Edit Item</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">

                                <form>
                                    <div class="row">
                                        <div class="col-4">
                                            <label>Title</label>
                                        </div>
                                        <div class="col-8">
                                            <label>{{ formData.title }}</label>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-4">
                                            <label>Tax Type<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                        </div>
                                        <div class="col-8">
                                            <select v-model="formData.tax_type" class="form-control" @change="handleCalculate">
                                                <option value="" selected>--Select Tax Type--</option>
                                                <option value="ppn_gross">Include PPN gross up pph</option>
                                                <option value="ppn_reduce">Include PPN reduce pph</option>
                                                <option value="exclude">Exclude</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-4">
                                            <label>PPN Type<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                        </div>
                                        <div class="col-8">
                                            <select v-model="formData.ppn" class="form-control" @change="handleCalculate">
                                                <option value="" selected>--No PPN--</option>
                                                <option v-for="(ppn, index) in ppns" :key="index" :value="{label: ppn.title, value: ppn.amount}">{{ ppn.title }} - {{ ppn.amount }}%</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-4">
                                            <label>PPH Type<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                        </div>
                                        <div class="col-8">
                                            <select v-model="formData.pph" class="form-control" @change="handleCalculate">
                                                <option value="" selected>--No PPH--</option>
                                                <option v-for="(pph, index) in pphs" :key="index" :value="{label: pph.title, value: pph.amount}">{{ pph.title }} - {{ pph.amount }}%</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-4">
                                            <label>Input Amount<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                        </div>
                                        <div class="col-8">
                                            <div class="row">
                                                <div class="col-6">
                                                    Rp. {{ formData.input_tax | formatPriceWithDecimal }}
                                                </div>
                                                <div class="col-6">
                                                    <input type="text" class="form-control" v-model="formData.input" @keyup="handleCalculate">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-4">
                                            <label>Attachment</label>
                                        </div>
                                        <div class="col-8">
                                            Attachment
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-4">
                                            <label>Note</label>
                                        </div>
                                        <div class="col-8">
                                            {{ formData.note }}
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-4">
                                            <label>PPN</label>
                                        </div>
                                        <div class="col-8">
                                            {{ formData.ppn_value }}
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-4">
                                            <label>PPH</label>
                                        </div>
                                        <div class="col-8">
                                            {{ formData.pph_value }}
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-4">
                                            <label>DPP</label>
                                        </div>
                                        <div class="col-8">
                                            {{ formData.dpp_value }}
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-4">
                                            <label>TOTAL</label>
                                        </div>
                                        <div class="col-8">
                                            {{ formData.total_value }}
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer flex justify-content-between">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" @click="handleSubmitEditTax()">Save changes</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="setCoaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                    <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel"> {{ formDataCoa.type === 'edit' ? "Edit" : "View" }} Item</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">

                                <form>
                                    <div class="row">
                                        <div class="col-4">
                                            <label>Title</label>
                                        </div>
                                        <div class="col-8">
                                            <label>{{ formDataCoa.title }}</label>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-4">
                                            <label>Tax Type</label>
                                        </div>
                                        <div class="col-8">
                                            <label>{{ formDataCoa.tax_type }}</label>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-4">
                                            <label>PPN Type</label>
                                        </div>
                                        <div class="col-8">
                                            <label>{{ formDataCoa.ppn_type }}</label>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-4">
                                            <label>PPH Type</label>
                                        </div>
                                        <div class="col-8">
                                            <label>{{ formDataCoa.pph_type }}</label>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-4">
                                            <label>Input Amount</label>
                                        </div>
                                        <div class="col-8">
                                            <label>Rp.  {{ formDataCoa.input_amount | formatPriceWithDecimal }}</label>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-4">
                                            <label>Attachment</label>
                                        </div>
                                        <div class="col-8">
                                            Attachment
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-4">
                                            <label>Note</label>
                                        </div>
                                        <div class="col-8">
                                            {{ formDataCoa.note }}
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-4">
                                            <label>PPN</label>
                                        </div>
                                        <div class="col-8">
                                            Rp. {{ formDataCoa.ppn_value | formatPriceWithDecimal }}
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-4">
                                            <label>PPH</label>
                                        </div>
                                        <div class="col-8">
                                            Rp. {{ formDataCoa.pph_value | formatPriceWithDecimal }}
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-4">
                                            <label>DPP</label>
                                        </div>
                                        <div class="col-8">
                                            Rp. {{ formDataCoa.dpp_value | formatPriceWithDecimal }}
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-4">
                                            <label>TOTAL</label>
                                        </div>
                                        <div class="col-8">
                                            Rp. {{ formDataCoa.total_amount | formatPriceWithDecimal }}
                                        </div>
                                    </div>

                                    <hr>
                                    <div class="row">
                                        <div class="col-12 text-center">
                                            Journal Entries
                                        </div>
                                    </div>
                                    <hr>
                                    <div v-for="(coaItem, index) in formDataCoa.coa_items" :key="index" class="row mt-3">
                                        <div class="col-3">
                                            <label for="">Account</label>
                                            <select :disabled="formDataCoa.type !== 'edit'" class="form-control" v-model="formDataCoa.coa_items[index].coa">
                                                <option value="">--Select Coa--</option>
                                                <option v-for="(coa, index) in coas" :key="index" :value="coa.id">{{ coa.account_code }}</option>
                                            </select>
                                        </div>
                                        <div class="col-2">
                                            <label for="">Debit</label>
                                            <input :disabled="formDataCoa.type !== 'edit'" type="number" class="form-control" v-model="formDataCoa.coa_items[index].debit" />
                                        </div>
                                        <div class="col-2">
                                            <label for="">Credit</label>
                                            <input :disabled="formDataCoa.type !== 'edit'" type="number" class="form-control" v-model="formDataCoa.coa_items[index].credit" />
                                        </div>
                                        <div class="col-4">
                                            <label for="">Cashflow</label>
                                            <select :disabled="formDataCoa.type !== 'edit'" class="form-control" v-model="formDataCoa.coa_items[index].cashflow">
                                                <option value="">--Select Cashflow--</option>
                                                <option v-for="(cashflow, index) in cashflows" :key="index" :value="cashflow.id">{{ cashflow.name }}</option>
                                            </select>
                                        </div>
                                        <div v-if="formDataCoa.type === 'edit'" class="col-1 align-content-center">
                                            <button @click="handleDeleteCoaItem(index)" type="button" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                        </div>
                                    </div>

                                    <button v-if="formDataCoa.type === 'edit'" type="button" class="btn btn-primary" @click="handleAddCoaItem()">Add Item</button>
                                </form>
                            </div>
                            <div class="modal-footer flex justify-content-between">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" v-if="formDataCoa.type === 'edit'"  class="btn btn-primary" @click="handleSubmitEditCoa()">Save changes</button>
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
                transactionData: null,
                formData: {
                    id: "",
                    title: "",
                    tax_type: "",
                    ppn: {label: "", value: 0},
                    pph: {label: "", value: 0},
                    input_tax: 0,
                    input: 0,
                    note: '',
                    ppn_value: 0,
                    pph_value: 0,
                    dpp_value: 0,
                    total_value: 0
                },
                formDataCoa: {
                    id: "",
                    title: "",
                    tax_type: "",
                    ppn_type: "",
                    pph_type: "",
                    note: '',
                    ppn_value: 0,
                    pph_value: 0,
                    dpp_value: 0,
                    total_amount: 0,
                    coa_items: []

                },
                ppns: [],
                pphs: [],
                coas: [],
                cashflows: [],
                formDataMethod: {
                    method: "",
                    transaction_date: ""
                }
            }
        },

        mounted() {
            this.getData()
            this.getTax()
            this.getDataCoa()
        },
        methods: {
            handleShowMethod() {
                $("#setMethodModal").modal("show")
            },
            async handleForcedStatus() {
                try {
                    this.$vs.loading()
                    const respDe = await this.$axios.get(`api/transaction/${this.$route.params.id}/forced-status`)
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
                        await this.getData()
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
            handleCheckSet(transactionData, permission) {
                if (['rejected', 'requested'].includes(transactionData.current_status)) {
                    return false
                }
                if (this.$store.state.permissions.includes(permission)) {
                    const approvalStatus = transactionData.transaction_approvals.find(x => x.title === (permission === 'transaction_edit_tax' ? 'Tax Admin' : 'Accounting Admin'))
                    if (approvalStatus.approved_at || approvalStatus.rejected_at) {
                        return false
                    }
                    return true
                }
                return false
            },
            handleCheckApproval(transactionData, item) {
                console.log("oke")
                if (!this.$store.state.permissions.includes('transaction_approval')) {
                    return false
                }
                
                let type = "";
                if (item.title === 'Accounting Admin') {
                    type = 'transaction_edit_coa'
                }
                if (item.title === 'Tax Admin') {
                    type = 'transaction_edit_tax'
                }
                if (type !== '') {
                    if (!this.$store.state.permissions.includes(type)) {
                        return false
                    }
                }
                
                if (transactionData.current_status === 'published' && item.user.email === this.$store.state.email && !item.approved_at && !item.rejected_at) {
                    return true
                }
                return false
            },
            handleAddCoaItem() {
                const coaItems = this.formDataCoa.coa_items
                coaItems.push({coa: '', debit: 0, credit: 0, cashflow: ""})
                this.formDataCoa.coa_items = coaItems
            },
            handleDeleteCoaItem(index) {
                const coaItems = this.formDataCoa.coa_items.filter((x, i) => i !== index)
                this.formDataCoa.coa_items = coaItems
            },
            async getDataCoa() {
                try {
                    this.$vs.loading()
                    this.coas = await this.$axios.get('api/coa?is_active=1')
                    this.cashflows = await this.$axios.get('api/coa/cashflow')
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
            async handleSubmitEditMethod() {
                try {
                    this.$vs.loading()
                    const respDe = await this.$axios.post(`api/transaction/${this.$route.params.id}/set-method`, this.formDataMethod)
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
                        $("#setMethodModal").modal("hide")
                        Swal.fire({
                            position: 'top',
                            icon: 'success',
                            title: respDe.message,
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
            async handleSubmitEditTax() {
                const paramSave = {
                    input_amount : this.formData.input_tax,
                    pph_amount: this.formData.pph.value,
                    pph_label: this.formData.pph.label + " " + parseFloat(this.formData.pph.value) + "%",
                    ppn_amount: this.formData.ppn.value,
                    ppn_label: this.formData.ppn.label + " " + parseFloat(this.formData.ppn.value) + "%",
                    tax_amount: this.formData.input,
                    tax_type: this.formData.tax_type
                }
                try {
                    this.$vs.loading()
                    const respDe = await this.$axios.post(`api/transaction/${this.$route.params.id}/set-tax/${this.formData.id}`, paramSave)
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
                        $("#setTaxModal").modal("hide")
                        Swal.fire({
                            position: 'top',
                            icon: 'success',
                            title: respDe.message,
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
            async handleSubmitEditCoa() {
                try {
                    this.$vs.loading()
                    const respDe = await this.$axios.post(`api/transaction/${this.$route.params.id}/set-coa/${this.formDataCoa.id}`, this.formDataCoa.coa_items)
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
                        $("#setCoaModal").modal("hide")

                        Swal.fire({
                            position: 'top',
                            icon: 'success',
                            title: respDe.message,
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
            handleCalculate() {
                let dpp = 0;
                let ppn = 0;
                let pph = 0;
                let total = parseFloat(this.formData.input)
                if (this.formData.tax_type === 'ppn_gross') {
                    const taxPercentage = parseFloat("1"+this.formData.ppn.value) - parseFloat(this.formData.pph.value)
                    if (this.formData.ppn.value > 0 && this.formData.pph.value > 0) {
                        dpp = (100 / taxPercentage) * parseFloat(this.formData.input)
                    } else {
                        dpp = parseFloat(this.formData.input)
                    }
                    ppn = dpp * (this.formData.ppn.value / 100)
                    pph = dpp * (this.formData.pph.value / 100)
                    total = ppn + dpp - pph
                } else if (this.formData.tax_type === 'ppn_reduce') {
                    const taxPercentage = parseFloat("1"+this.formData.ppn.value)
                    if (this.formData.ppn.value > 0 && this.formData.pph.value > 0) {
                        dpp = (100 / taxPercentage) * parseFloat(this.formData.input)
                    } else {
                        dpp = parseFloat(this.formData.input)
                    }
                    ppn = dpp * (this.formData.ppn.value / 100)
                    pph = dpp * (this.formData.pph.value / 100)
                    total = ppn + dpp - pph
                } else if (this.formData.tax_type === 'exclude') {
                    dpp = parseFloat(this.formData.input)
                    ppn = dpp * (this.formData.ppn.value / 100)
                    pph = dpp * (this.formData.pph.value / 100)
                    if (parseFloat(this.formData.input_tax) < parseFloat(this.formData.input)) {
                        total = ppn + dpp - pph + parseFloat(this.formData.input)
                    } else {
                        total = ppn + dpp - pph
                    }
                }
                this.formData.ppn_value = parseFloat(ppn).toFixed(0)
                this.formData.pph_value = parseFloat(pph).toFixed(0)
                this.formData.dpp_value = parseFloat(dpp).toFixed(0)
                this.formData.total_value = parseFloat(total).toFixed(0)
            },
            handleSetTax(item) {
                this.formData = {
                    id: item.id,
                    title: item.title,
                    tax_type: "",
                    ppn: {label: "", value: 0},
                    pph: {label: "", value: 0},
                    input_tax: item.input_amount,
                    input: item.input_amount,
                    note: item.note,
                    ppn_value: 0,
                    pph_value: 0,
                    dpp_value: 0,
                    total_value: 0
                }
                $("#setTaxModal").modal("show")
            },
            handleSetCoa(item, type = 'edit') {
                let coaItems = [
                    {coa: '', debit: item.total_amount, credit: 0, cashflow: ""},
                    {coa: '', debit: 0, credit: item.total_amount, cashflow: ""}
                ];
                if (item.transaction_item_coas.length > 0) {
                    coaItems = [];
                    item.transaction_item_coas.forEach((itemCoa, index) => {
                        coaItems.push({coa: parseInt(itemCoa.account_id), debit: itemCoa.debit, credit: itemCoa.credit, cashflow: itemCoa.cashflow_id ? parseInt(itemCoa.cashflow_id) : ""})
                    })
                }
                this.formDataCoa = {
                    id: item.id,
                    title:item.title,
                    tax_type: item.tax_type,
                    ppn_type: item.ppn_label,
                    pph_type: item.pph_label,
                    total_amount: item.total_amount,
                    note: item.note,
                    ppn_value: item.ppn,
                    pph_value: item.pph,
                    dpp_value: item.dpp,
                    coa_items: coaItems,
                    type: type
                }
                $("#setCoaModal").modal("show")
            },
            async handleApproval(type, itemId) {
                try {
                    this.$vs.loading()
                    const status = type === 1 ? 'approved' : 'rejected'
                    const respDe = await this.$axios.get(`api/transaction/${this.$route.params.id}/${status}/approval/${itemId}`)
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
                        Swal.fire({
                            position: 'top',
                            icon: 'success',
                            title: respDe.message,
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
            async handlePublish() {
                try {
                    this.$vs.loading()
                    const respDe = await this.$axios.get(`api/transaction/${this.$route.params.id}/publish`)
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
                        await this.getData()
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
            async getData() {
                try {
                    this.$vs.loading()
                    const respDe = await this.$axios.get(`api/transaction/${this.$route.params.id}/detail`)
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
                        this.transactionData = respDe.data
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
            async getTax() {
                try {
                    this.$vs.loading()
                    const respDe = await this.$axios.get(`api/tax`)
                    this.$vs.loading.close()
                    this.pphs = respDe.filter(x => x.type === 'pph')
                    this.ppns = respDe.filter(x => x.type === 'ppn')
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
