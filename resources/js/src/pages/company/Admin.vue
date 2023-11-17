<template>
    <div class="container-fluid">
        <div class="card">
            <div class="card-title">
                <h1 class="h3 mt-3 ml-3 text-gray-800 float-left">Company Admin Page</h1>
                <router-link to="/app/company" class="btn btn-success float-right mt-3 mr-3">
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
                            <div class="col-4">
                                <div class="card">
                                    <div class="card-body shadow-lg">
                                        <h5 class="card-title">Total Manual Transfer</h5>
                                        <div class="d-flex flex-column">
                                            <span>
                                                Rp. 0
                                            </span>
                                            <span>
                                                0 Transaction
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="card">
                                    <div class="card-body shadow-lg">
                                        <h5 class="card-title">Total By Plugin Flip</h5>
                                        <div class="d-flex flex-column">
                                            <span>
                                                Rp. 0
                                            </span>
                                            <span>
                                                0 Transaction
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
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
                <h3 class="h3 text-gray-800 float-left mt-3">Transaction Data</h3>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th><input type="checkbox" v-model="checkAllStatus" @click="checkBoxAll()" /></th>
                            <th>Transaction Number</th>
                            <th>Author</th>
                            <th>Company</th>
                            <th>Method</th>
                            <th>Project</th>
                            <th>Title</th>
                            <th>Last Status</th>
                            <th>Total</th>
                            <th>Created At</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-show="transactions.length == 0">
                            <td colspan="10" class="text-center">
                                Empty Transactions
                            </td>
                        </tr>
                        <tr v-for="(transaction, key) in transactions">
                            <td>
                                <input type="checkbox" @click="handleCheckItem(key)" :checked="transaction.is_selected === undefined ? false : transaction.is_selected " />
                            </td>
                            <td>
                                <router-link :to="'/app/transaction/'+transaction.id+'/detail'">
                                    {{ transaction.transaction_number }}
                                </router-link>
                            </td>
                            <td>{{ transaction.user_created_by.name }}</td>
                            <td>{{ transaction.project.company.title }}</td>
                            <td>
                                <span class="badge  rounded-pill text-bg-primary">{{ transaction.method ?? "-" }}</span>
                            </td>
                            <td><span class="badge  rounded-pill text-bg-warning">{{ transaction.project.title }}</span></td>
                            <td>{{ transaction.title }}</td>
                            <td><span class="badge  rounded-pill text-bg-primary">{{ transaction.current_status}}</span></td>
                            <td>Rp. {{ transaction.total_amount | formatPriceWithDecimal }}</td>
                            <td>{{ transaction.created_at | formatDate }}</td>
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
                checkAllStatus: false
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
                    const respDe = await this.$axios.get(`api/transaction?company_id=${this.$route.params.id}`)
                    this.$vs.loading.close()
                    this.transactions = respDe
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
