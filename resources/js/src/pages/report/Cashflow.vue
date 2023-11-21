<template>
    <div class="container-fluid">

        <div class="card shadow mb-4">
            <div class="card-title">
                <h1 class="h3 mt-3 ml-3 text-gray-800 float-left">Cashflow</h1>
                <router-link to="/app/report" class="btn btn-success float-right mt-3 mr-3">
                    <i class="fa fa-arrow-left"></i> Back
                </router-link>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <button type="button" class="btn btn-success">Export</button>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-6">
                                <table class="table table-responsive">
                                    <thead>
                                        <tr class="backgroup bg-light bg-gradient p-2 rounded">
                                            <th>Name</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <table class="table table-borderless">
                                                    <tr v-for="(cl, iC) in coaList" :key="iC">
                                                        <td :class="cl.type === 'parent' ? 'font-weight-bold' : 'pl-4'">{{ cl.label }}</td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-6">
                                <table class="table table-responsive">
                                    <thead>
                                        <tr class="bg-gray-300 p-2 rounded">
                                            <th v-for="(month, iM) in months" :key="iM">{{ month }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr :class="iM % 2 == 1 ? 'bg-gray' : ''">
                                            <td v-for="(dataR, iR) in dataReports" :key="iR">
                                                <table class="table table-borderless">
                                                    <tr v-for="(j, iJ) in dataR.data" :key="iJ">
                                                        <td>{{ j | formatPriceWithDecimal}}</td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
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
        name: "BalanceSheet.vue",
        data() {
            return {
                months: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "Desember"],
                coaList: [],
                dataReports: [],
                initialBalance: 0
            }
        },
        created() {
            this.initiateData()
            this.initialBalance()
        },
        methods: {
            initiateData() {
                for (let i = 1; i <= 12; i++) {
                    this.getData(i < 10 ? "0" + i : i)
                }
            },
            async initialBalance() {
                try {
                    console.log('oke')
                    this.$vs.loading()
                    const respData = (await this.$axios.get('api/journal/report/cashflow-initial-balance?year=2023')).data
                    this.initialBalance = respData
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
            async getData(month) {
                try {
                    console.log('oke')
                    this.$vs.loading()
                    const respData = (await this.$axios.get('api/journal/report/cashflow?month=' + month + '&year=2023')).data
                    const balances = [];
                    let totalBalance = 0;
                    respData.forEach((x) => {
                        if (month === '01') {
                            this.coaList.push({
                                "type": 'parent',
                                "label" : x.cash_label
                            })
                        }
                        balances.push(x.total_balance)
                        x.children.map((child) => {
                            if (month === '01') {
                                this.coaList.push({
                                    "type": 'child',
                                    "label" : child.cash_name
                                })
                            }
                            balances.push(child.balance)
                        })
                        totalBalance = totalBalance + x.total_balance
                    })
                    balances.push(totalBalance)
                    balances.push(this.initialBalance)
                    balances.push(this.initialBalance + totalBalance)
                    if (month === '01') {
                        this.coaList.push({
                            "type": 'parent',
                            "label" : "KENAIKAN/(PENURUNAN) BERSIH KAS DAN BANK"
                        })
                        this.coaList.push({
                            "type": 'parent',
                            "label" : "KAS DAN BANK AWAL TAHUN"
                        })
                        this.coaList.push({
                            "type": 'parent',
                            "label" : "KAS DAN BANK AKHIR TAHUN"
                        })
                    }
                    this.dataReports.push({
                        'month' : month,
                        'data' : balances
                    })
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
            }
        }
    }
</script>