<template>
    <div class="container-fluid">

        <div class="card shadow mb-4">
            <div class="card-title">
                <h1 class="h3 mt-3 ml-3 text-gray-800 float-left">Coa Detail</h1>
                <router-link to="/app/coa/" class="btn btn-success float-right mt-3 mr-3">
                    <i class="fa fa-arrow-left"></i> Back
                </router-link>
            </div>
            <div class="row ml-3">
                <h3>{{ coas.coa_category.name }}</h3>
                <h4>{{ coas.coa_posting.name }}</h4>
                <span>({{ coas.account_number }}) {{ coas.account_name }}</span>
                <span>{{ coas.account_type }}</span>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>Transaction UID</th>
                            <th>Title</th>
                            <th>Transaction Date</th>
                            <th>Created At</th>
                            <th>Status</th>
                            <th>Debit (IDR)</th>
                            <th>Credit (IDR)</th>
                            <th>Current Balance (IDR)</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(t, index) in transactions" :key="index">
                            <td>{{ t.invoice }}</td>
                            <td>{{ t.description }}</td>
                            <td>{{ t.transction_date | formatDate}}</td>
                            <td>{{ t.created_at | formatDate }}</td>
                            <td><span :class="t.approved_at ? 'badge badge-primary' : (t.rejected_at ? 'badge badge-danger' : 'badge badge-warning')">{{ t.approved_at ? "Approved" : (t.rejected_at ? 'Rejected' : 'Requested') }}</span></td>
                            <td>{{ t.total_debit | formatPriceWithDecimal }}</td>
                            <td>{{ t.total_credit | formatPriceWithDecimal }}</td>
                            <td>{{ t.balance | formatPriceWithDecimal }}</td>
                        </tr>
                        </tbody>
                    </table>
                    <!--<div class="justify-content-center d-flex">-->
                        <!--<pagination v-model="page" :records="totalData" :per-page="perPage" @paginate="getData"/>-->
                    <!--</div>-->
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
                coas: "",
                transactions: []
            }
        },
        created() {
            this.getData()
        },
        methods: {
            async getData() {
                try {
                    this.$vs.loading()
                    const response = await this.$axios.post(`api/coa/journal-items`, {account: this.$route.params.id})
                    this.$vs.loading.close()
                    if (!response.status) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: response.message,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        return
                    }
                    this.coas = response.data.coa
                    this.transactions = response.data.transactions
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