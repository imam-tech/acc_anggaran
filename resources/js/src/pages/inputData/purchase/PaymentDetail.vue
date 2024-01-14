<template>
    <div v-if="purchasePaymentData !== null" class="container-fluid">
        <div class="card">
            <div class="card-title">
                <div class="row">
                    <div class="col-6">
                        <h1 class="mt-3 ml-3 text-primary">
                            <div class="d-flex flex-column">
                                <h5>Purchase</h5>
                                <h3 class="text-gray-700">
                                    Purchase Payment #{{ purchasePaymentData.id }}
                                    <span v-if="purchasePaymentData.status" class="badge badge-success rounded-pill">Paid</span>
                                    <span v-else class="badge badge-warning rounded-pill">DRAFT</span>
                                </h3>
                            </div>
                        </h1>
                    </div>
                    <div class="col-6 text-right d-flex align-items-center justify-content-end">
                        <div class="d-flex flex-column">
                            <div>
                                <button v-if="!purchasePaymentData.status" type="button" @click="handleApprove(purchasePaymentData.id)" class="btn btn-primary mt-3 ">
                                    <i class="fas fa-check-circle"></i> Approve
                                </button>
                                <router-link v-if="!purchasePaymentData.status" :to="'/app/input-data/purchase/payment/'+purchasePaymentData.purchase_id+'/'+purchasePaymentData.id+'/form'">
                                    <button type="button" class="mt-3 btn btn-warning">
                                        <i class="fas fa-pencil-alt"></i> Edit
                                    </button>
                                </router-link>
                                <button v-if="!purchasePaymentData.status" type="button" @click="handleDelete(purchasePaymentData.id)" class="btn btn-danger mt-3 ">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                                <router-link :to="'/app/input-data/purchase/'+purchasePaymentData.purchase_id+'/detail'">
                                    <button type="button" class="mr-3 mt-3 btn btn-success">
                                        <i class="fas fa-arrow-left"></i> Back
                                    </button>
                                </router-link>
                            </div>
                            <a href="@" @click.prevent="handleShowJournalEntry()" class="mr-3 mt-2">View Journal Entry</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-4">
                        <table class="table table-striped">
                            <tbody>
                            <tr>
                                <th>Supplier Name</th>
                                <td class="text-right">{{purchasePaymentData.purchase.contact.name}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-lg-4">
                        <table class="table table-striped">
                            <tbody>
                            <tr>
                                <th>Pay From</th>
                                <td class="text-right">{{purchasePaymentData.coa.account_name}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8">
                        <table class="table table-striped">
                            <tbody>
                            <tr>
                                <th>Payment Method</th>
                                <td class="text-right">{{purchasePaymentData.payment_method ? purchasePaymentData.payment_method.name : ''}}</td>
                            </tr>
                            <tr>
                                <th>Transaction Date</th>
                                <td class="text-right">{{purchasePaymentData.payment_date}}</td>
                            </tr>
                            <tr>
                                <th>Due Date</th>
                                <td class="text-right">{{purchasePaymentData.due_date}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th class="text-center">Number</th>
                            <th class="text-center">Description</th>
                            <th class="text-center">Payment Amount (IDR)</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>{{ purchasePaymentData.purchase.transaction_number }}</td>
                            <td>{{ purchasePaymentData.description }}</td>
                            <td class="text-right">Rp. {{ purchasePaymentData.payment_amount | formatPrice }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-xl-6">
                        <div class="row">
                            <div class="col-12 d-flex justify-content-between">
                                <label>Message</label>
                                <label>{{ purchasePaymentData.memo ?? '-' }}</label>
                            </div>
                            <div class="col-12">
                                <label>Attachment</label>
                                <table class="table table-striped">
                                    <tr v-for="(f, fI) in purchasePaymentData.purchase_payment_attachments" :key="fI">
                                        <td>
                                            <i :class="handleShowIconFile(f.type)"></i>
                                        </td>
                                        <td>
                                            <span class="d-flex flex-column">
                                                <span class="text-primary">{{ f.name }}</span>
                                                <span>{{ handleSizeFile(f.size) }}</span>
                                            </span>
                                        </td>
                                        <td>
                                            <a :href="f.url">
                                                <i class="fas fa-link"></i>
                                            </a>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <table class="table">
                            <tr>
                                <td>Total</td>
                                <td class="text-right">
                                    {{ purchasePaymentData.payment_amount | formatPrice }}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="modal fade" id="showJournalEntry" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Journal Payment Report #{{ purchasePaymentData.id }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th class="text-center">Account</th>
                                        <th class="text-center">Debit</th>
                                        <th class="text-center">Credit</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(sj, sjI) in purchasePaymentData.purchase_payment_journals" :key="sjI">
                                        <td>{{ sj.coa.account_code }}</td>
                                        <td class="text-right">{{ sj.debit | formatPrice }}</td>
                                        <td class="text-right">{{ sj.credit | formatPrice }}</td>
                                    </tr>
                                    <tr>
                                        <td>Total</td>
                                        <td class="text-right">{{ handleTotal(purchasePaymentData.purchase_payment_journals, 'debit')  | formatPrice}}</td>
                                        <td class="text-right">{{ handleTotal(purchasePaymentData.purchase_payment_journals, 'credit') | formatPrice }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="modal-footer flex justify-content-between">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">
                                    <i class="fas fa-times"></i> Close
                                </button>
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
        name:'Detail',
        data() {
            return {
                purchasePaymentData: null,
            }
        },

        mounted() {
            this.getData()
        },
        methods: {
            handleTotal(journals, type) {
                let total = 0;
                journals.forEach((x) => {
                    total = total + parseFloat(type === 'debit' ? x.debit : x.credit)
                })
                return total
            },

            handleShowJournalEntry() {
                $("#showJournalEntry").modal('show')
            },

            handleShowIconFile(type) {
                if (type === 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') return 'fas fa-file-word-o';
                if (type === 'application/pdf') return 'fas fa-file-pdf-o';
                if (type === 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') return 'fas fa-file-excel-o'
                if (['image/jpg', 'image/jpeg'].includes(type)) return 'fas fa-file-image-o'
                if (type === 'image/png') return 'fa-picture-o'
            },

            handleSizeFile(size) {
                if (size < 1000000)  {
                    return parseFloat(size/1000).toFixed(0) + ' Kb'
                } else {
                    return parseFloat(size / 1000000).toFixed(2) + ' Mb'
                }
            },

            async getData() {
                try {
                    this.$vs.loading()
                    const respDe = await this.$axios.get(`api/input-data/purchase/payment/${this.$route.params.type}/detail`)
                    this.$vs.loading.close()

                    if (!respDe.status) {
                        Swal.fire({
                            position: 'top',
                            icon: 'error',
                            title: respDe.message,
                            showConfirmButton: false,
                            timer: 2500
                        })
                    } else {
                        this.purchasePaymentData = respDe.data
                    }
                } catch (e) {
                    this.$vs.loading.close()
                    Swal.fire({
                        position: 'top',
                        icon: 'error',
                        title: e.message,
                        showConfirmButton: false,
                        timer: 2500
                    })
                }
            },

            async handleDelete(id) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Are You Sure Want To Delete This Payment?',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    showCloseButton: true,
                    showCancelButton: true,
                }).then((result)=>{
                    if(result.isConfirmed == true){
                        this.$vs.loading()
                        this.$axios.delete(`api/input-data/purchase/payment/${id}/${this.purchasePaymentData.purchase_id}/delete`).then((response)=>{
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
                                    text: "Failed To Delete payment : " + response.message ,
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    allowEnterKey: false,
                                });
                            }
                        });
                    }
                })
            },

            async handleApprove(id) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Are You Sure Want To Approve This Payment? this action can\'t be undo',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    showCloseButton: true,
                    showCancelButton: true,
                }).then((result)=>{
                    if(result.isConfirmed == true){
                        this.$vs.loading()
                        this.$axios.get(`api/input-data/purchase/payment/${id}/approve`).then((response)=>{
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
                                    text: "Failed To approve payment : " + response.message ,
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
