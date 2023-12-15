<template>
    <div class="container-fluid">

        <div class="card shadow mb-4">
            <div class="card-title">
                <div class="row m-3">
                    <div class="col-6">
                        <h1 class="h3 text-gray-800 float-left">Journal List</h1>
                    </div>
                    <div class="col-6 text-right">
                        <router-link to="/app/journal/form/create">
                            <button type="button" class="btn btn-primary">
                                <i class="fas fa-plus-circle"></i> Journal
                            </button>
                        </router-link>
                    </div>
                </div>
            </div>
            <div class="row m-3">
                <div class="col-xl-2 col-md-6">
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text">Start Date</div>
                        </div>
                        <input type="date" class="form-control" v-model="filter.start_date" placeholder="Title">
                    </div>
                </div>
                <div class="col-xl-2 col-md-6">
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text">End Date</div>
                        </div>
                        <input type="date" class="form-control" v-model="filter.end_date">
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text">Transaction UID</div>
                        </div>
                        <input type="text" class="form-control" v-model="filter.transaction_uid">
                    </div>
                </div>
                <div class="col-xl-2 col-md-6">
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text">Title</div>
                        </div>
                        <input type="text" class="form-control" v-model="filter.title">
                    </div>
                </div>
                <div class="col-xl-2 col-md-6">
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text">Status</div>
                        </div>
                        <select name="status" class="form-control" v-model="filter.status">
                            <option value="all">All</option>
                            <option value="approved">Approved</option>
                            <option value="requested">Requested</option>
                            <option value="rejected">Rejected</option>
                        </select>
                    </div>
                </div>
                <div class="col-xl-1 col-md-6 text-right">
                    <button class="btn btn-success mb-2" @click="getData()">
                        <i class="fas fa-search"></i> Search
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th class="text-center">Transaction UID</th>
                            <th class="text-center">Title</th>
                            <th class="text-center">Voucher NO</th>
                            <th class="text-center">Transaction Date</th>
                            <th class="text-center">Created At</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Debit (IDR)</th>
                            <th class="text-center">Credit (IDR)</th>
                            <th class="text-center">#</th>
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
                            <td>
                                <span :class="(journal.approved_at ? 'approved' : (journal.rejected_at ? 'rejected' : 'requested')) | labelByStatus">
                                    {{ (journal.approved_at ? 'Approved' : (journal.rejected_at ? 'Rejected' : 'Requested')) }}
                                </span>
                            </td>
                            <td class="text-right">{{ showDebitAndCredit(journal.journal_items, 'debit') | formatPriceWithDecimal}}</td>
                            <td class="text-right">{{ showDebitAndCredit(journal.journal_items, 'credit') | formatPriceWithDecimal }}</td>
                            <td class="text-right">
                                <router-link :to="'/app/journal/' + journal.id + '/detail'" target="_blank">
                                    <button type="button" class="btn btn-primary">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </router-link>
                                <router-link v-if="journal.approved_at === null && journal.rejected_at === null" :to="'/app/journal/form/' + journal.id">
                                    <button type="button" class="btn btn-warning">
                                        <i class="fa fa-pencil"></i>
                                    </button>
                                </router-link>

                                <button @click="handleDelete(journal.id)" v-if="journal.approved_at === null && journal.rejected_at === null" type="button" class="btn btn-danger">
                                    <i class="fa fa-remove"></i>
                                </button>
                            </td>
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
                filter: {
                    start_date: "",
                    end_date: "",
                    transaction_uid: "",
                    title: "",
                    status: ""
                }
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
                    this.journals = await this.$axios.get(`api/journal?start_date=${this.filter.start_date}&end_date=${this.filter.end_date}
                    &transaction_uid=${this.filter.transaction_uid}&title=${this.filter.title}&status=${this.filter.status}`)
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
            async handleDelete(id) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Are You Sure Want To Delete This Journal?',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    showCloseButton: true,
                    showCancelButton: true,
                }).then((result)=>{
                    if(result.isConfirmed == true){
                        this.$vs.loading()
                        this.$axios.delete(`api/journal/${id}/delete`).then((response)=>{
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
                                    text: "Failed To Delete Journal : " + response.message ,
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    allowEnterKey: false,
                                });
                            }
                        });
                    }
                })
            }
        }
    }
</script>