<template>
    <div v-if="purchaseData !== null" class="container-fluid">
        <div class="card">
            <div class="card-title">
                <div class="row">
                    <div class="col-6">
                        <h1 class="mt-3 ml-3 text-primary">
                            <div class="d-flex flex-column">
                                <h5>Purchase</h5>
                                <h3 class="text-gray-700">
                                    {{ purchaseData.transaction_number }}
                                    <span :class="handleStatus(purchaseData).class">{{ handleStatus(purchaseData).label }}</span>
                                </h3>
                            </div>
                        </h1>
                    </div>
                    <div class="col-6 text-right">
                        <div class="d-flex flex-column">
                            <div>
                                <router-link v-if="handleStatus(purchaseData).label !== 'Paid'" :to="'../' + purchaseData.id + '/form'">
                                    <button type="button" class="btn btn-warning mt-3">
                                        <i class="fas fa-pencil-alt"></i> Edit
                                    </button>
                                </router-link>
                                <button v-if="handleStatus(purchaseData).label === 'Open'" type="button" @click="handleDeletePurchase()" class="btn btn-danger mt-3">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                                <router-link v-if="handleStatus(purchaseData).label !== 'Paid'" :to="'/app/input-data/purchase/payment/'+purchaseData.id+'/create/form'">
                                    <button type="button" class="mt-3 btn btn-primary">
                                        <i class="fas fa-dollar"></i> Receive Payment
                                    </button>
                                </router-link>
                                <router-link to="/app/input-data/purchase">
                                    <button type="button" class="mr-3 mt-3 btn btn-success">
                                        <i class="fas fa-arrow-left"></i> Back
                                    </button>
                                </router-link>
                            </div>
                            <h4 class="mr-3 mt-2">Balance Due Rp. {{ handleShowBalanceDue(purchaseData) | formatPrice }}</h4>
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
                                <th>Vendor Name</th>
                                <td class="text-right">{{purchaseData.contact.name}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-lg-4">
                        <table class="table table-striped">
                            <tbody>
                            <tr>
                                <th>vendor Email</th>
                                <td class="text-right">{{purchaseData.contact_email}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <table class="table table-striped">
                            <tbody>
                            <tr>
                                <th>Billing Address</th>
                                <td class="text-right">{{purchaseData.billing_address}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-lg-8">
                        <table class="table table-striped">
                            <tbody>
                            <tr>
                                <th>Transaction Number</th>
                                <td class="text-right">{{purchaseData.transaction_number}}</td>
                            </tr>
                            <tr>
                                <th>Transaction Date</th>
                                <td class="text-right">{{purchaseData.transaction_date}}</td>
                            </tr>
                            <tr>
                                <th>Due Date</th>
                                <td class="text-right">{{purchaseData.due_date}}</td>
                            </tr>
                            <tr>
                                <th>Tag</th>
                                <td class="text-right">
                                    {{ showTagLable(purchaseData.tag_details) }}
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th class="text-center">Name</th>
                            <th class="text-center">Description</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-center">Unit</th>
                            <th class="text-center">Unit Price</th>
                            <th class="text-center">Sub Total</th>
                            <th class="text-center">Tax</th>
                            <th class="text-center">Tax Amount</th>
                            <th class="text-center">Grand Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-show="purchaseData.purchase_products.length == 0">
                            <td colspan="8" class="text-center">
                                Items
                            </td>
                        </tr>
                        <tr v-for="(item, key) in purchaseData.purchase_products" :key="key">
                            <td>{{ item.product.name }}</td>
                            <td>{{ item.description }}</td>
                            <td>{{ item.quantity }}</td>
                            <td>{{ item.unit }}</td>
                            <td class="text-right">Rp. {{ item.unit_price | formatPrice }}</td>
                            <td class="text-right">Rp. {{ item.sub_total | formatPrice }}</td>
                            <td>{{ item.tax ? item.tax.title : '-' }}</td>
                            <td class="text-right">Rp. {{ item.tax_amount | formatPrice }}</td>
                            <td class="text-right">Rp. {{ item.grand_total | formatPrice }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-xl-6">
                        <div class="row">
                            <div class="col-12 d-flex justify-content-between">
                                <label>Message</label>
                                <label>{{ purchaseData.message ?? '-' }}</label>
                            </div>
                            <div class="col-12">
                                <label>Attachment</label>
                                <table class="table table-striped">
                                    <tr v-for="(f, fI) in purchaseData.purchase_attachments" :key="fI">
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
                                <td>Sub Total</td>
                                <td class="text-right">
                                    {{ purchaseData.sub_total | formatPrice }}
                                </td>
                            </tr>
                            <tr>
                                <td>Tax Amount Total</td>
                                <td class="text-right">
                                    {{ purchaseData.tax_amount_total | formatPrice }}
                                </td>
                            </tr>
                            <tr>
                                <td>Grand Total</td>
                                <td class="text-right">
                                    {{ purchaseData.grand_total | formatPrice }}
                                </td>
                            </tr>
                            <tr v-if="purchaseData.payment_amount_total > 0">
                                <td>Payment Paid</td>
                                <td class="text-right">
                                    {{ purchaseData.payment_amount_total | formatPrice }}
                                </td>
                            </tr>
                            <tr v-if="purchaseData.payment_amount_total > 0">
                                <td>Balance Due</td>
                                <td class="text-right">
                                    {{ handleShowBalanceDue(purchaseData) | formatPrice }}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div v-if="purchaseData.purchase_payments.length > 0" class="row">
                    <div class="col-12">
                        <h3>Payment</h3>
                    </div>
                    <div class="col-12 table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th class="text-center">Date</th>
                                <th class="text-center">Number</th>
                                <th class="text-center">Pay From</th>
                                <th class="text-center">Payment Method</th>
                                <th class="text-center">Payment Status</th>
                                <th class="text-center">Amount</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(sp, spI) in purchaseData.purchase_payments" :key="spI">
                                <td>{{ sp.payment_date }}</td>
                                <td>
                                    <router-link :to="'/app/input-data/purchase/payment/' + sp.id + '/detail'">Purchase Payment #{{ sp.id }}</router-link></td>
                                <td>{{ sp.coa.account_name }}</td>
                                <td>{{ sp.payment_method ? sp.payment_method.name : '' }}</td>
                                <td>{{ sp.status ? 'Paid' : '-' }}</td>
                                <td class="text-right">{{ sp.payment_amount | formatPrice }}</td>
                                <td class="text-right">
                                    <router-link :to="'/app/input-data/purchase/payment/' + sp.id + '/detail'">
                                        <button type="button" class="btn btn-primary">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </router-link>
                                    <router-link v-if="!sp.status" :to="'/app/input-data/purchase/payment/'+sp.purchase_id+'/'+sp.id+'/form'">
                                        <button type="button" class="btn btn-warning">
                                            <i class="fas fa-pencil-alt"></i>
                                        </button>
                                    </router-link>
                                    <button v-if="!sp.status" type="button" @click="handleDelete(sp.id)" class="btn btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal fade" id="showJournalEntry" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Journal Report {{ purchaseData.transaction_number }}</h5>
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
                                    <tr v-for="(sj, sjI) in purchaseData.purchase_journals" :key="sjI">
                                        <td>{{ sj.coa.account_code }}</td>
                                        <td class="text-right">{{ sj.debit | formatPrice }}</td>
                                        <td class="text-right">{{ sj.credit | formatPrice }}</td>
                                    </tr>
                                    <tr>
                                        <td>Total</td>
                                        <td class="text-right">{{ handleTotal(purchaseData.purchase_journals, 'debit')  | formatPrice}}</td>
                                        <td class="text-right">{{ handleTotal(purchaseData.purchase_journals, 'credit') | formatPrice }}</td>
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
                purchaseData: null,
            }
        },

        mounted() {
            this.getData()
        },
        methods: {
            showTagLable(tagDetails) {
                console.log('show')
                if (tagDetails.length > 0) {
                    let tagName = [];
                    tagDetails.forEach((x) => {
                        if (x.tag) {
                            tagName.push(x.tag.name)
                        }
                    })
                    return tagName.join(',')
                }
                return ''
            },

            handleShowBalanceDue(s) {
                if (parseFloat(s.payment_amount_total) >= parseFloat(s.grand_total)) {
                    return 0
                }
                return parseFloat(s.grand_total) - parseFloat(s.payment_amount_total);
            },

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

            handleStatus(s) {
                if (parseFloat(s.payment_amount_total) < parseFloat(s.grand_total)) {
                    const dateNow = (new Date()).toISOString().split('T')[0]
                    if (s.due_date < dateNow) {
                        return {
                            "class": 'badge badge-danger',
                            "label": 'Overdue'
                        }
                    } else {
                        if (parseFloat(s.payment_amount_total) === 0) {
                            return {
                                "class": 'badge badge-warning',
                                "label": 'Open'
                            }
                        } else {
                            return {
                                "class": 'badge badge-warning',
                                "label": 'Partial'
                            }
                        }
                    }
                } else {
                    return {
                        "class": 'badge badge-success',
                        "label": 'Paid'
                    }
                }
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
                    const respDe = await this.$axios.get(`api/input-data/purchase/${this.$route.params.type}/detail`)
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
                        this.purchaseData = respDe.data
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
                        this.$axios.delete(`api/input-data/purchase/payment/${id}/${this.purchaseData.id}/delete`).then((response)=>{
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

            async handleDeletePurchase() {
                Swal.fire({
                    icon: 'warning',
                    title: 'Are You Sure Want To Delete This Purchase?',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    showCloseButton: true,
                    showCancelButton: true,
                }).then((result)=>{
                    if(result.isConfirmed == true){
                        this.$vs.loading()
                        this.$axios.delete(`api/input-data/purchase/${this.purchaseData.id}/delete`).then((response)=>{
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
                                    if(res.isConfirmed == true) this.$router.push('/app/input-data/purchase')
                                })
                            }else{
                                Swal.fire({
                                    icon: "error",
                                    title: "Opps...",
                                    text: "Failed To Delete Purchase : " + response.message ,
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
