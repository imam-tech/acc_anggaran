<template>
    <div class="container-fluid">

        <div class="card shadow mb-4">
            <div class="card-title">
                <h1 class="h3 mt-3 ml-3 text-gray-800 float-left">Cashflow</h1>
                <router-link to="/app/output-data/report" class="btn btn-success float-right mt-3 mr-3">
                    <i class="fas fa-arrow-left"></i> Back
                </router-link>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 d-flex justify-content-end">
                        <div>
                            <select class="form-control" v-model="selectedYear" @change="changeYear">
                                <option value="2023">2023</option>
                                <option value="2024">2024</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-6 p-0">
                                <table class="table">
                                    <thead>
                                        <tr class="backgroup bg-light bg-gradient p-2 rounded">
                                            <th>Name</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class=" p-0">
                                                <table class="table table-borderless">
                                                    <tr v-for="(cl, iC) in coaList" :key="iC">
                                                        <td :class="cl.type === 'parent' ? 'font-weight-bold bg-light' : 'pl-4'">{{ cl.label }}</td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-6 p-0">
                                <table class="table table-responsive">
                                    <thead>
                                        <tr class="bg-gray-300 p-2 rounded">
                                            <th v-for="(month, iM) in months" :key="iM" v-if="iM < lastMonth">{{ month }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td v-for="(dataR, iR) in dataReports" :key="iR" class=" p-0">
                                                <table class="table table-borderless">
                                                    <tr v-for="(j, iJ) in dataR.data" :key="iJ">
                                                        <td :class="j.type === 'parent' ? 'bg-light' : ''">{{ j.balance | formatPriceWithDecimal}}</td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfooter>
                                        <tr class="bg-gray-300 p-2 rounded">
                                            <th v-for="(month, iM) in months" :key="iM" v-if="iM < lastMonth">{{ month }}</th>
                                        </tr>
                                    </tfooter>
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
                initialBalance: 0,
                lastMonth: 0,
                selectedYear: new Date().getFullYear()
            }
        },
        created() {
            const d = new Date();
            this.lastMonth =  d.getMonth() + 1
            this.initiateData()
            this.handleInitialBalance()
        },
        methods: {
            initiateData() {
                const d = new Date();
                this.lastMonth =  this.selectedYear < new Date().getFullYear() ? 12 : d.getMonth() + 1
                for (let i = 1; i <= this.lastMonth; i++) {
                    this.getData(i < 10 ? "0" + i : i)
                }
            },
            async handleInitialBalance() {
                try {
                    console.log('oke')
                    this.$vs.loading()
                    const respDataI = (await this.$axios.get('api/output-data/report/cashflow-initial-balance?year=' + this.selectedYear)).data
                    this.initialBalance = respDataI
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
                    const respData = (await this.$axios.get('api/output-data/report/cashflow?month=' + month + '&year=' + this.selectedYear)).data
                    const balances = [];
                    let totalBalance = 0;
                    respData.forEach((x) => {
                        if (month === '01') {
                            this.coaList.push({
                                "type": 'parent',
                                "label" : x.cash_label
                            })
                        }
                        balances.push({balance: x.total_balance, type: 'parent'})
                        x.children.map((child) => {
                            if (month === '01') {
                                this.coaList.push({
                                    "type": 'child',
                                    "label" : child.cash_name
                                })
                            }
                            balances.push({balance: child.balance, type: 'child'})
                        })
                        totalBalance = totalBalance + x.total_balance
                    })
                    balances.push({balance:totalBalance, type: 'parent'})
                    balances.push({balance:this.initialBalance, type: 'parent'})
                    balances.push({balance:this.initialBalance + totalBalance, type: 'parent'})
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
            },

            changeYear() {
                this.coaList = []
                const d = new Date();
                this.lastMonth =  d.getMonth() + 1
                this.initiateData()
            }
        }
    }
</script>