<template>
    <div class="container-fluid">

        <div class="card shadow mb-4">
            <div class="card-title">
                <h1 class="h3 mt-3 ml-3 text-gray-800 float-left">Journal</h1>
                <router-link to="/app/report" class="btn btn-success float-right mt-3 mr-3">
                    <i class="fa fa-arrow-left"></i> Back
                </router-link>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-3">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">Status</span>
                            <select v-model="filter.status" class="form-control">
                                <option value="all">All</option>
                                <option value="approved">Approved</option>
                                <option value="rejected">Rejected</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon2">Start Date</span>
                            <input type="date" v-model="filter.start_date" class="form-control">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon2">End Date</span>
                            <input type="date" v-model="filter.end_date" class="form-control">
                        </div>
                    </div>
                    <div class="col">
                        <button type="button" class="btn btn-primary" @click="handleSubmit()">Filter</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button type="button" class="btn btn-success">Export</button>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-12">
                                <table class="table">
                                    <thead>
                                        <tr class="backgroup bg-light bg-gradient p-2 rounded">
                                            <th>Transaction UID</th>
                                            <th>Voucher NO</th>
                                            <th>Title</th>
                                            <th>Debit</th>
                                            <th>Credit</th>
                                            <th>Current Status</th>
                                            <th>Transaction Date</th>
                                            <th>Created At</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(cl, iC) in journals" :key="iC">
                                            <td>{{ cl.transaction_uid }}</td>
                                            <td>{{ cl.voucher_no }}</td>
                                            <td>{{ cl.title }}</td>
                                            <td>{{ cl.debit | formatPriceWithDecimal }}</td>
                                            <td>{{ cl.credit | formatPriceWithDecimal }}</td>
                                            <td>{{ cl.approved_at ? 'APPROVED' : (cl.rejected_at ? 'REJECTED' : "REQUESTED") }}</td>
                                            <td>{{ cl.transaction_date | formatDate }}</td>
                                            <td>{{ cl.created_at | formatDate }}</td>
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
                journals: [],
                filter: {
                    status: "",
                    start_date: "",
                    end_date: ""
                }
            }
        },
        methods: {
            handleSubmit() {
                console.log('filter', filter)
            },
            async handleSubmit(month) {
                try {
                    this.$vs.loading()
                    const respData = await this.$axios.get('api/journal/report/journal?status=' + this.filter.status + '&start_date=' + this.filter.start_date + '&end_date=' + this.filter.end_date)     
                    this.$vs.loading.close()
                    if (!respData.status) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: respData.message,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        return
                    }
                    this.journals = respData.data
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