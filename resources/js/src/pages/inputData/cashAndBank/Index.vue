<template>
    <div class="container-fluid">

        <div class="card shadow mb-4">
            <div class="card-title">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex flex-column">
                        <span class="mt-3 ml-3 text-gray-800">Cash & Bank</span>
                        <h1 class="h3 ml-3 text-gray-800 float-left">Accounts</h1>
                    </div>
                    <router-link to="/app/input-data/cash-and-bank/create/form">
                        <button type="button" class="btn btn-primary float-right mr-3 mt-3">
                            <i class="fas fa-plus-circle"></i> Create New Account
                        </button>
                    </router-link>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 col-xl-3 mb-2" v-for="(rc, rcI) in resumeCharts" :key="rcI">
                        <div class="card">
                            <div class="card-body shadow-lg p-2">
                                <div class="d-flex justify-content-between">
                                    <span>{{ rc.label }}</span>
                                    <span class="bg-info rounded p-1 text-white">{{ rc.count }}</span>
                                </div>
                                <span class="align-content-center">
                                    Rp. {{ rc.sum }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th><b>Account Number</b></th>
                            <th><b>Account Name</b></th>
                            <th class="text-right"><b>Statement Balance</b></th>
                            <th class="text-right"><b>Balance in Jurnal</b></th>
                            <th>#</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                <span><b>111100</b></span>
                            </td>
                            <td>
                                <span>
                                    <router-link :to="'/app/coa/category/' + cashId + '/detail'"><b>Cash</b></router-link>
                                </span>
                            </td>
                            <td class="text-right"></td>
                            <td class="text-right"></td>
                            <td></td>
                        </tr>
                        <tr v-for="(ca, caI) in cashAndBanks.cash_and_bank.cash" :key="caI">
                            <td>
                                <i v-if="ca.is_locked" class="fas fa-lock"></i>
                                <i v-else class="fas fa-lock-open"></i>
                                <span class="ml-5">{{ ca.account_number }}</span>
                            </td>
                            <td>
                                <span class="ml-5">
                                    <router-link :to="'/app/coa/' + ca.id + '/detail'">{{ ca.account_name }}</router-link>
                                </span>
                            </td>
                            <td class="text-right">
                                <span>{{ ca.statement_balance }}</span>
                            </td>
                            <td class="text-right">
                                <span>{{ ca.balance_in_jurnal }}</span>
                            </td>
                            <td class="d-flex justify-content-end">
                                <router-link v-if="!ca.is_locked" :to="'/app/input-data/cash-and-bank/' + ca.cash_and_bank_id + '/form'">
                                    <button type="button" class="btn btn-warning">
                                        <i class="fas fa-pencil-alt"></i>
                                    </button>
                                </router-link>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span><b>111200</b></span>
                            </td>
                            <td>
                                <span>
                                    <router-link :to="'/app/coa/category/' + bankId + '/detail'"><b>Bank</b></router-link>
                                </span>
                            </td>
                            <td class="text-right"></td>
                            <td class="text-right"></td>
                            <td></td>
                        </tr>
                        <tr v-for="(ca, caI) in cashAndBanks.cash_and_bank.bank" :key="caI">
                            <td>
                                <i v-if="ca.is_locked" class="fas fa-lock"></i>
                                <i v-else class="fas fa-lock-open"></i>
                                <span class="ml-5">{{ ca.account_number }}</span>
                            </td>
                            <td>
                                <span class="ml-5">
                                    <router-link :to="'/app/coa/' + ca.id + '/detail'">{{ ca.account_name }}</router-link>
                                </span>
                            </td>
                            <td class="text-right">
                                <span>{{ ca.statement_balance }}</span>
                            </td>
                            <td class="text-right">
                                <span>{{ ca.balance_in_jurnal }}</span>
                            </td>
                            <td class="d-flex justify-content-end">
                                <router-link :to="'/app/cash-and-bank/' + ca.cash_and_bank_id + '/form'">
                                    <button type="button" class="btn btn-warning">
                                        <i class="fas fa-pencil-alt"></i>
                                    </button>
                                </router-link>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span><b>211500</b></span>
                            </td>
                            <td>
                                <span>
                                    <router-link :to="'/app/coa/category/' + creditCardId + '/detail'"><b>Credit Card</b></router-link>
                                </span>
                            </td>
                            <td class="text-right"></td>
                            <td class="text-right"></td>
                            <td></td>
                        </tr>
                        <tr v-for="(ca, caI) in cashAndBanks.credit_card" :key="caI">
                            <td>
                                <i v-if="ca.is_locked" class="fas fa-lock"></i>
                                <i v-else class="fas fa-lock-open"></i>
                                <span class="ml-5">{{ ca.account_number }}</span>
                            </td>
                            <td>
                                <span class="ml-5">
                                    <router-link :to="'/app/coa/' + ca.id + '/detail'">{{ ca.account_name }}</router-link>
                                </span>
                            </td>
                            <td class="text-right">
                                <span>{{ ca.statement_balance }}</span>
                            </td>
                            <td class="text-right">
                                <span>{{ ca.balance_in_jurnal }}</span>
                            </td>
                            <td class="d-flex justify-content-end">
                                <router-link :to="'/app/cash-and-bank/' + ca.cash_and_bank_id + '/form'">
                                    <button type="button" class="btn btn-warning">
                                        <i class="fas fa-pencil-alt"></i>
                                    </button>
                                </router-link>
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
        name: "Index.vue",
        data() {
            return {
                resumeCharts: [{
                    label: 'Next 30-Day Income (In IDR)',
                    count: 2,
                    sum: 10000
                },{
                    label: 'Next 30-Day Expense (In IDR)',
                    count: 2,
                    sum: 10000
                },{
                    label: 'Cash Balance (In IDR)',
                    count: 2,
                    sum: 10000
                },{
                    label: 'Credit Card Balance (In IDR)',
                    count: 2,
                    sum: 10000
                }],
                cashAndBanks: [],
                cashId: '',
                bankId: '',
                creditCardId: ''

            }
        },
        created() {
            this.getData()
        },
        methods: {
            async getData() {
                try {
                    this.$vs.loading()
                    this.cashAndBanks = await this.$axios.get(`api/input-data/cash-and-bank`)
                    this.cashId = this.cashAndBanks.cash_id
                    this.bankId = this.cashAndBanks.bank_id
                    this.creditCardId = this.cashAndBanks.credit_card_id
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