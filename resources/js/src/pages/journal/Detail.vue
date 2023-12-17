<template>
    <div class="container-fluid">
        <div class="card">
            <div class="card-title">
                <h1 class="h3 mt-3 ml-3 text-gray-800 float-left">Journal Detail</h1>
                <router-link to="/app/journal" class="btn btn-success float-right mt-3 mr-3">
                    <i class="fa fa-arrow-left"></i> Back
                </router-link>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-4">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th colspan="2" class="text-center">Details</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th>Transaction UID</th>
                                <td class="text-right">{{journal.transaction_uid}}</td>
                            </tr>
                            <tr>
                                <th>Voucher NO</th>
                                <td class="text-right">{{journal.voucher_no}}</td>
                            </tr>
                            <tr>
                                <th>Title</th>
                                <td class="text-right">{{journal.title}}</td>
                            </tr>
                            <tr>
                                <th>Transaction Date</th>
                                <td class="text-right">{{journal.transaction_date}}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td class="text-right">
                                    <span :class="(journal.approved_at ? 'approved' : (journal.rejected_at ? 'rejected' : 'requested')) | labelByStatus">
                                        {{ (journal.approved_at ? 'Approved' : (journal.rejected_at ? 'Rejected' : 'Requested')) }}
                                    </span>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-lg-8 table-responsive">
                        <table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th class="text-center">Account Number</th>
                                <th class="text-center">Account</th>
                                <th class="text-center">Cashflow</th>
                                <th class="text-center">Description</th>
                                <th class="text-center">Debit (IDR)</th>
                                <th class="text-center">Credit (IDR)</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-show="journal.journal_items.length == 0">
                                <td colspan="6" class="text-center">
                                    Empty Items
                                </td>
                            </tr>
                            <tr v-for="(item, key) in journal.journal_items">
                                <td>{{ item.account.account_number }}</td>
                                <td>{{ item.account.account_name }}</td>
                                <td>{{ item.cashflow_id ? item.cashflow.name : '-' }}</td>
                                <td>{{ item.description }}</td>
                                <td class="text-right">{{ item.debit | formatPriceWithDecimal }}</td>
                                <td class="text-right">{{ item.credit | formatPriceWithDecimal }}</td>
                            </tr>
                            <tr>
                                <td colspan="4"></td>
                                <td class="text-right">
                                    <div class="d-flex flex-column">
                                        <span><b>Total Debit</b></span>
                                        <span><b>{{ showDebitAndCredit(journal.journal_items, 'debit') | formatPriceWithDecimal}}</b></span>
                                    </div>
                                </td>
                                <td class="text-right">
                                    <div class="d-flex flex-column">
                                        <span><b>Total Credit</b></span>
                                        <span><b>{{ showDebitAndCredit(journal.journal_items, 'credit') | formatPriceWithDecimal}}</b></span>
                                    </div>
                                </td>
                            </tr>
                            <tr v-if="journal.approved_at === null && journal.rejected_at === null && $store.state.permissions.includes('transaction_edit_coa')">
                                <td colspan="6" class="text-right">
                                    <button @click="handleApproveReject('approved')" type="button" class="btn btn-primary">
                                        <i class="fa fa-check"></i> Approved
                                    </button>
                                    <button type="button" @click="handleRejectShow()" class="btn btn-danger">
                                        <i class="fa fa-times"></i> Rejected
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="rejectedModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Reject Approval</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form @submit.prevent="handleApproveReject('rejected')">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Rejected Note<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                    <input type="text" class="form-control" v-model="rejectedNote" required />
                                </div>
                            </div>
                            <div class="modal-footer flex justify-content-between">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">
                                    <i class="fas fa-times"></i> Close
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Save
                                </button>
                            </div>
                        </form>
                    </div>
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
                journal: {},
                rejectedNote: ""
            }
        },

        mounted() {
            this.getData()
        },
        methods: {
            handleRejectShow() {
                $("#rejectedModal").modal("show")
            },
            async handleApproveReject(type) {
                const rejectedNoteLocal = this.rejectedNote
                if (type == 'rejected') {
                    $("#rejectedModal").modal("hide")
                }
                Swal.fire({
                    position: 'top',
                    icon: 'warning',
                    title: "Are you sure?",
                    showConfirmButton: true,
                    showCancelButton: true,
                    confirmButtonText: 'Yes, I am sure!',
                    cancelButtonText: "No, cancel it!",
                }).then(async (isConfirm) => {
                    if (isConfirm.isConfirmed) {
                        try {
                            this.$vs.loading()
                            const respSave = await this.$axios.post(`api/journal/${this.$route.params.id}/approval`, {
                                status: type,
                                note: rejectedNoteLocal
                            })
                            this.$vs.loading.close()
                            if (!respSave.status) {
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'error',
                                    title: respSave.message,
                                    showConfirmButton: false,
                                    timer: 1500
                                })
                            } else {
                                $("#addCompany").modal("hide")
                                Swal.fire({
                                    position: 'top',
                                    icon: 'success',
                                    title: respSave.message,
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(async ()=>{
                                    await this.getData()
                                })
                            }
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
                })
            },
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
                    const respDe = await this.$axios.get(`api/journal/${this.$route.params.id}/detail`)
                    this.$vs.loading.close()
                    if (!respDe.status) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: respDe.message,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        return
                    }
                    this.journal = respDe.data
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
