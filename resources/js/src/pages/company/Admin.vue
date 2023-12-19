<template>
    <div class="container-fluid">
        <div class="card">
            <div class="card-title">
                <h1 class="h3 mt-3 ml-3 text-gray-800 float-left">Company Admin Page</h1>
                <router-link :to="'/app/company/'+$route.params.id+'/detail'" class="btn btn-success float-right mt-3 mr-3">
                    <i class="fa fa-arrow-left"></i> Back
                </router-link>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                    </div>
                    <div class="col-6">
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-xl-4">
                                <div class="card">
                                    <div class="card-body shadow-lg">
                                        <h5 class="card-title">Total Manual Transfer</h5>
                                        <div class="d-flex flex-column">
                                            <span>
                                                Rp. {{ manualTransfer.amount | formatPriceWithDecimal }}
                                            </span>
                                            <span>
                                                {{ manualTransfer.transaction }} Transaction
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 mt-2 mt-xl-0">
                                <div class="card">
                                    <div class="card-body shadow-lg">
                                        <h5 class="card-title">Total By Plugin Flip</h5>
                                        <div class="d-flex flex-column">
                                            <span>
                                                Rp. {{ flipTransfer.amount | formatPriceWithDecimal }}
                                            </span>
                                            <span>
                                                {{ flipTransfer.transaction }} Transaction
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 mt-2 mt-xl-0">
                                <div class="card">
                                    <div class="card-body shadow-lg">
                                        <h5 class="card-title">Flip Balance</h5>
                                        <div class="d-flex flex-column">
                                            <span>
                                                Rp. 0
                                            </span>
                                            <span>
                                                Plugin
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-row mt-5 justify-content-between">
                    <h3 class="h3 text-gray-800 float-left mt-3">Transaction Data</h3>
                    <button v-if="transactions.length > 0" type="button" class="btn btn-warning" @click="handlePushPlugin()">Approve</button>
                </div>
                <div class="table-responsive mt-3">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th class="text-center"><input type="checkbox" v-model="checkAllStatus" @click="checkBoxAll()" /></th>
                            <th class="text-center">Transaction Number</th>
                            <th class="text-center">Author</th>
                            <th class="text-center">Company</th>
                            <th class="text-center">Method</th>
                            <th class="text-center">Title</th>
                            <th class="text-center">Total</th>
                            <th class="text-center">Bank</th>
                            <th class="text-center">Bank Account</th>
                            <th class="text-center">Created At</th>
                            <th class="text-center">#</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-show="transactions.length == 0">
                            <td colspan="10" class="text-center">
                                Empty Transactions
                            </td>
                        </tr>
                        <tr v-for="(transaction, key) in transactions" :key="key">
                            <td class="text-center">
                                <input type="checkbox" @click="handleCheckItem(key)" :checked="transaction.is_selected === undefined ? false : transaction.is_selected " />
                            </td>
                            <td>
                                <router-link :to="'/app/transaction/'+transaction.id+'/detail'">
                                    {{ transaction.transaction_number }}
                                </router-link>
                            </td>
                            <td>{{ transaction.user_created_by.name }} <br> <span class="badge  rounded-pill text-bg-warning">{{ transaction.project.title }}</span></td>
                            <td>{{ transaction.project.company.title }}</td>
                            <td>
                                <span class="badge  rounded-pill text-bg-primary">{{ transaction.method ?? "-" }}</span>
                            </td>
                            <td>{{ transaction.title }}</td>
                            <td class="text-right">Rp. {{ transaction.total_amount | formatPriceWithDecimal }}</td>
                            <td>{{ transaction.bank }}</td>
                            <td>{{ transaction.account_holder }} <br>{{ transaction.account_number }}</td>
                            <td>{{ transaction.created_at | formatDate }}</td>
                            <td class="text-right">
                                <button type="button" class="btn btn-danger">
                                    <i class="fas fa-times"></i> Reject
                                </button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
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
                transactions: {},
                checkAllStatus: false,
                manualTransfer: {
                    amount: 0,
                    transaction: 0
                },
                flipTransfer: {
                    amount: 0,
                    transaction: 0
                }
            }
        },

        mounted() {
            if (!this.$store.state.permissions.includes('transaction_push_plugin')) {
                Swal.fire({
                    position: 'top',
                    icon: 'error',
                    title: 'You don\'t have an access this page',
                    showConfirmButton: false,
                    timer: 3000
                }).then(async ()=>{
                    this.$router.push('/app/company/' + this.$route.params.id + '/detail')
                })
                return
            }
            this.getData()
        },
        methods: {
            handlePushPlugin() {
                const params = [];
                this.transactions.forEach((x) => {
                    if (x.is_selected !== undefined) {
                        params.push(x.id)
                    }
                })

                if (params.length === 0) {
                    Swal.fire({
                        icon: "error",
                        title: "Opps...",
                        text: "Please check the transaction at least one transaction",
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        allowEnterKey: false,
                    });
                    return
                }

                Swal.fire({
                    icon: 'warning',
                    title: 'Are You Sure Want To Push?',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    showCloseButton: true,
                    showCancelButton: true,
                }).then((result)=>{
                    if(result.isConfirmed == true){
                        this.$vs.loading()
                        this.$axios.post(`api/company/${this.$route.params.id}/push-plugin`, params).then((response)=>{
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
            },
            handleCheckItem(key) {
                const transactionLocals = []
                this.transactions.forEach((x, i) => {
                    transactionLocals.push(x)
                    if (key === i) {
                        transactionLocals[i].is_selected = x.is_selected === undefined ? true : (!x.is_selected)
                    }
                })
                this.transactions = transactionLocals
                console.log("trans", this.transactions)
                this.checkAllStatus = false
            },
            checkBoxAll() {
                const transactionLocals = []
                this.transactions.forEach((x, i) => {
                    transactionLocals.push(x)
                    transactionLocals[i].is_selected = !this.checkAllStatus
                })
                this.transactions = transactionLocals
                console.log("trans", this.transactions)
            },
            async getData() {
                try {
                    this.$vs.loading()
                    const respDe = await this.$axios.get(`api/transaction?company_id=${this.$route.params.id}&status=approved&all=1`)
                    this.$vs.loading.close()
                    this.transactions = respDe
                    const manualTransfers = respDe.filter((x) => x.method === 'manual')
                    const manualTotal = manualTransfers.reduce((acc, obj) => {
                        return acc + obj['total_amount']
                    }, 0)
                    this.manualTransfer.amount = manualTotal
                    this.manualTransfer.transaction = manualTransfers.length

                    const flipTransfers = respDe.filter((x) => x.method === 'flip')
                    const flipTotal = flipTransfers.reduce((acc, obj) => {
                        return acc + obj['total_amount']
                    }, 0)
                    this.flipTransfer.amount = flipTotal
                    this.flipTransfer.transaction = flipTransfers.length

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
