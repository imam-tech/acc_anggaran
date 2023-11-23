<template>
    <div class="container-fluid">

        <div class="card shadow mb-4">
            <div class="card-title">
                <h1 class="h3 mt-3 ml-3 text-gray-800 float-left">Balance Sheet</h1>
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
                            <div class="col-6 p-0">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr class="backgroup bg-light bg-gradient p-2 rounded">
                                            <th>Account</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="p-0">
                                                <table class="table table-borderless">
                                                    <tr v-for="(cl, iC) in coaList" :key="iC">
                                                        <td :class="cl.type === 'bold' ? 'font-weight-bold bg-light' : 'pl-4'">{{ cl.label }}</td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr class="backgroup bg-light bg-gradient p-2 rounded">
                                            <th>Account</th>
                                        </tr>
                                    </thead>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-6 p-0">
                                <table class="table table-bordered table-responsive">
                                    <thead>
                                        <tr class="bg-gray-300 p-2 rounded">
                                            <th v-for="(month, iM) in months" :key="iM" v-if="iM < lastMonth">{{ month }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td v-for="(dataR, iR) in dataReports" :key="iR" class="p-0">
                                                <table class="table table-borderless">
                                                    <tr v-for="(j, iJ) in dataR.data" :key="iJ">
                                                        <td :class="j.type === 'parent' ? 'bg-light' : ''">{{ j.balance | formatPriceWithDecimal}}</td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr class="bg-gray-300 p-2 rounded">
                                            <th v-for="(month, iM) in months" :key="iM" v-if="iM < lastMonth">{{ month }}</th>
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
                lastMonth: 0
            }
        },
        created() {
            const d = new Date();
            this.lastMonth =  d.getMonth() + 1
            this.initiateData()
        },
        methods: {
            initiateData() {
                for (let i = 1; i <= this.lastMonth; i++) {
                    this.getData(i < 10 ? "0" + i : i)
                }
            },
            async getData(month) {
                try {
                    this.$vs.loading()
                    const respData = (await this.$axios.get('api/journal/report/balance-profit?month=' + month + '&year=2023&type=balance_sheet')).data
                    const balances = [];
                    respData.accounts.forEach((x) => {
                        let type = 'parent';
                        if (x.account_name !== null) {
                            type = 'child'
                        }
                        if (month == "01") {
                            let respCl = {}
                            if (x.account_name !== null) {
                                respCl = {
                                    "type": '',
                                    "label" : x.account_code + "-" + x.account_name
                                }
                            } else {
                                respCl = {
                                    "type": 'bold',
                                    "label" :  x.name
                                }
                            }
                            this.coaList.push(respCl)
                        }
                        balances.push({balance: x.balance, type: type})
                    })
                    respData.posting.forEach((x) => {
                        let type = 'parent'
                        if (month == "01") {
                            const respCl = {
                                "type": 'bold',
                                "label" :  x.name
                            }
                            this.coaList.push(respCl)
                        }
                        balances.push({balance: x.balance, type: type})
                    })
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