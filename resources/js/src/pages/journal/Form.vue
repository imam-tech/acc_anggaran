<template>
    <div class="container-fluid">
        <div class="card">
            <div class="card-title">
                <h1 class="h3 mt-3 ml-3 text-gray-800 float-left">Journal Form</h1>
                <router-link to="/app/journal" class="btn btn-success float-right mt-3 mr-3">
                    <i class="fa fa-arrow-left"></i> Back
                </router-link>
            </div>
            <div class="card-body">
                <form>
                    <div class="row">
                        <div class="col-md-6 col-xl-4">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Transaction No</div>
                                </div>
                                <input type="text" class="form-control" v-model="formData.transaction_no" />
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-4">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Transaction Date</div>
                                </div>
                                <input type="datetime-local" class="form-control" v-model="formData.transaction_date" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="row mb-2">
                                <div class="col-12">
                                    <button type="button" @click="handleAddItem()" class="btn btn-warning float-right mt-3 mr-3">
                                        <i class="fa fa-plus"></i> Items
                                    </button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div v-for="(items, index) in formData.items" :key="index" class="row mr-2">
                                        <div class="col-md-4 col-xl-2">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Account</div>
                                                </div>
                                                <select class="form-control" v-model="formData.items[index].coa">
                                                    <option value="">--Select Coa--</option>
                                                    <option v-for="(coa, index) in coas" :key="index" :value="coa.id">{{ coa.account_code }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-xl-3">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Description</div>
                                                </div>
                                                <input type="text" class="form-control" v-model="formData.items[index].description" />
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-xl-2">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Debit</div>
                                                </div>
                                                <input type="number" class="form-control" v-model="formData.items[index].debit" />
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-xl-2">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Credit</div>
                                                </div>
                                                <input type="number" class="form-control" v-model="formData.items[index].credit" />
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-xl-2">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Cashflow</div>
                                                </div>
                                                <select class="form-control" v-model="formData.items[index].cashflow">
                                                    <option value="">--Select Cashflow--</option>
                                                    <option v-for="(cashflow, index) in cashflows" :key="index" :value="cashflow.id">{{ cashflow.name }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-xl-1 text-right">
                                            <button @click="handleDeleteItem(index)" type="button" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button type="button" @click="submitProcess()" class="btn btn-primary float-right mt-3 mr-3">
                                <i class="fa fa-save"></i> Submit
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        name:'Detail',
        data() {
            return {
                formData: {
                    id: "",
                    company_id: 5,
                    transaction_no: "",
                    transaction_date: "",
                    items: [{
                        coa: "",
                        description: "",
                        debit: 0,
                        credit: 0,
                        cashflow: ""
                    }]
                },
                coas: [],
                cashflows: [],
            }
        },

        mounted() {
            this.initiateData()
        },
        methods: {
            handleDeleteItem(index) {
                const itemLocals = this.formData.items.filter((x, i) => i !== index)
                this.formData.items = itemLocals
            },
            handleAddItem() {
                this.formData.id = "";
                this.formData.transaction_no = "";
                this.formData.transaction_date = "";
                this.formData.company_id = 5;
                const itemLocals = this.formData.items
                itemLocals.push({
                    coa: "",
                    debit: 0,
                    description: "",
                    credit: 0,
                    cashflow: ""
                })
            },

            async submitProcess() {
                try {
                    this.$vs.loading()
                    const respSave = await this.$axios.post('api/journal', this.formData)
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
                        Swal.fire({
                            position: 'top',
                            icon: 'success',
                            title: respSave.message,
                            showConfirmButton: false,
                            timer: 1500
                        }).then(()=>{
                            this.$router.push(`/app/journal/${respSave.data.id}/detail`);
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
            async initiateData() {
                try {
                    this.$vs.loading()
                    if (this.$route.params.id !== 'create') {
                        const detailData = await this.$axios.get(`api/journal/${this.$route.params.id}/detail`)
                        if (!detailData.status)  {
                            this.$vs.loading.close()
                            Swal.fire({
                                position: 'top-end',
                                icon: 'error',
                                title: detailData.message,
                                showConfirmButton: false,
                                timer: 1500
                            })
                            return
                        }
                        if (detailData.data.approved_at !== null || detailData.data.rejected_at !== null) {
                            this.$vs.loading.close()
                            Swal.fire({
                                position: 'top',
                                icon: 'error',
                                title: 'The status is not requested',
                                showConfirmButton: false,
                                timer: 3000
                            }).then(async ()=>{
                                this.$router.push('/app/journal')
                            })
                            return
                        }
                        this.formData.id = detailData.data.id;
                        this.formData.company_id = detailData.data.company_id;
                        this.formData.transaction_no = detailData.data.transaction_uid;
                        this.formData.transaction_date = detailData.data.transaction_date
                        const itemLocals = [];
                        detailData.data.journal_items.forEach((x) => {
                            itemLocals.push({
                                coa: x.account_id,
                                debit: parseFloat(x.debit),
                                description: x.description,
                                credit: parseFloat(x.credit),
                                cashflow: x.cashflow_id
                            })
                        })
                        this.formData.items = []
                        this.formData.items = itemLocals
                    }
                    this.coas = await this.$axios.get(`api/coa`)
                    this.cashflows = await this.$axios.get(`api/coa/cashflow`)
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
        }
    }
</script>
