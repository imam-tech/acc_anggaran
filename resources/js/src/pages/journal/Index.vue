<template>
    <div class="container-fluid">

        <div class="card shadow mb-4">
            <div class="card-title">
                <h1 class="h3 mt-3 ml-3 text-gray-800 float-left">Journal List</h1>
            </div>
            <div class="row ml-3">
                <!--<div class="col-md-3">-->
                    <!--<div class="input-group mb-2">-->
                        <!--<div class="input-group-prepend">-->
                            <!--<div class="input-group-text">Title</div>-->
                        <!--</div>-->
                        <!--<input type="text" class="form-control" id="title" placeholder="Title" v-model="sortVal.title">-->
                    <!--</div>-->
                <!--</div>-->
                <!--<div class="col-md-3">-->
                    <!--<div class="input-group mb-2">-->
                        <!--<div class="input-group-prepend">-->
                            <!--<div class="input-group-text">Status</div>-->
                        <!--</div>-->
                        <!--<select name="status" v-model="sortVal.status" class="form-control">-->
                            <!--<option value="active" :selected="sortVal.status== null ? true : false">All</option>-->
                            <!--<option value="active" :selected="sortVal.status== 'active' ? true : false">Active</option>-->
                            <!--<option value="not_active" :selected="sortVal.status== 'not_active' ? true : false">Not Active</option>-->
                        <!--</select>-->
                    <!--</div>-->
                <!--</div>-->
                <div class="col-md-3">
                    <!--<button class="btn btn-success mb-2" @click="sortValue()">Search</button>-->
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>Transaction UID</th>
                            <th>Title</th>
                            <th>Voucher NO</th>
                            <th>Transaction Date</th>
                            <th>Created At</th>
                            <th>Status</th>
                            <th>Debit (IDR)</th>
                            <th>Credit (IDR)</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(journal, index) in journals" :key="index">
                            <td>
                                <a :href="'/app/journal/' + journal.id + '/detail'" target="_blank">
                                    {{ journal.transaction_uid }}
                                </a>
                            </td>
                            <td>{{ journal.title}}</td>
                            <td>{{ journal.voucher_no }}</td>
                            <td>{{ journal.transaction_date | formatDate }}</td>
                            <td>{{ journal.created_at | formatDate }}</td>
                            <td>{{ journal.approved_at ? 'Approved' : (journal.rejected_at ? 'Rejected' : 'Requested') }}</td>
                            <td>{{ showDebitAndCredit(journal.journal_items, 'debit') | formatPriceWithDecimal}}</td>
                            <td>{{ showDebitAndCredit(journal.journal_items, 'credit') | formatPriceWithDecimal }}</td>
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
                journals: [],
            }
        },
        created() {
            this.getData()
        },
        methods: {
            showDebitAndCredit(journalItems, type) {
                let debitLocal = 0
                let creditLocal = 0;
                if (type === 'debit') {
                    journalItems.forEach((x) => {
                        debitLocal = debitLocal + parseFloat(x.debit)
                    })
                }

                if (type === 'credit') {
                    journalItems.forEach((x) => {
                        creditLocal = creditLocal + parseFloat(x.credit)
                    })
                }

                return type === 'debit' ? debitLocal : creditLocal;
            },
            async getData() {
                try {
                    this.$vs.loading()
                    this.journals = await this.$axios.get(`api/journal`)
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