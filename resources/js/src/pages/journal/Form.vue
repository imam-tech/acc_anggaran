<template>
    <div class="container-fluid">
        <div class="card">
            <div class="card-title">
                <h1 class="h3 mt-3 ml-3 text-gray-800 float-left">Journal Form</h1>
                <router-link to="/app/journal" class="btn btn-success float-right mt-3 mr-3">
                    <i class="fas fa-arrow-left"></i> Back
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
                        <div class="col-md-6 col-xl-4">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Project</div>
                                </div>
                                <select class="form-control" v-model="formData.project_id">
                                    <option v-for="(p, pI) in projects" :value="p.id" :key="pI">{{ p.title }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="row mb-2">
                                <div class="col-12">
                                    <button type="button" @click="handleAddItem()" class="btn btn-warning float-right mt-3 mr-3">
                                        <i class="fas fa-plus"></i> Items
                                    </button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div v-for="(items, index) in formData.items" :key="index" class="row mr-2 mt-2">
                                        <div class="col-md-4 col-xl-2">
                                            <label>Account</label>
                                            <v-select v-model="formData.items[index].coa" :options="coas" :reduce="p => p.id" style="width: 100%" label="account_code">
                                                <template #search="{attributes, events}">
                                                    <input
                                                            class="vs__search"
                                                            :required="!formData.items[index].coa"
                                                            v-bind="attributes"
                                                            v-on="events"
                                                    />
                                                </template>
                                                <span slot="no-options">Account not found</span>
                                            </v-select>
                                        </div>
                                        <div class="col-md-4 col-xl-3">
                                            <label>Description</label>
                                            <input type="text" class="form-control" v-model="formData.items[index].description" />
                                        </div>
                                        <div class="col-md-4 col-xl-2">
                                            <label>Debit</label>
                                            <input type="number" class="form-control" v-model="formData.items[index].debit" />
                                        </div>
                                        <div class="col-md-4 col-xl-2">
                                            <label>Credit</label>
                                            <input type="number" class="form-control" v-model="formData.items[index].credit" />
                                        </div>
                                        <div class="col-md-4 col-xl-2">
                                            <label>Cashflow</label>
                                            <v-select v-model="formData.items[index].cashflow" :options="cashflows" :reduce="p => p.id" style="width: 100%" label="name">
                                                <span slot="no-options">Cashflow not found</span>
                                            </v-select>
                                        </div>
                                        <div class="col-md-4 col-xl-1 d-flex align-items-end justify-content-end">
                                            <button @click="handleDeleteItem(index)" type="button" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button type="button" @click="submitProcess()" class="btn btn-primary float-right mt-3 mr-3">
                                <i class="fas fa-save"></i> Submit
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import Cookies from 'js-cookie'

    export default {
        name:'Detail',
        data() {
            return {
                formData: {
                    id: "",
                    company_id: Cookies.get('current_company_fat'),
                    project_id: "",
                    transaction_no: "",
                    transaction_date: "",
                    items: [{
                        coa: "",
                        description: "",
                        debit: 0,
                        credit: 0,
                        cashflow: ""
                    },{
                        coa: "",
                        description: "",
                        debit: 0,
                        credit: 0,
                        cashflow: ""
                    }]
                },
                coas: [],
                cashflows: [],
                projects: []
            }
        },

        mounted() {
            this.initiateData()
            this.getData()
        },
        methods: {
            async getData() {
                try {
                    this.$vs.loading()
                    this.projects.push({id: '', title: "--Choose Project--"})
                    const projLocals = await this.$axios.get('api/project')
                    projLocals.forEach((x) => this.projects.push(x))
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
                        this.formData.project_id = detailData.data.project_id;
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
