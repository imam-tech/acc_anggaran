<template>
    <div v-if="salesData !== null" class="container-fluid">
        <div class="card">
            <div class="card-title">
                <div class="row">
                    <div class="col-6">
                        <h1 class="mt-3 ml-3 text-primary">
                            <div class="d-flex flex-column">
                                <h5>Sales</h5>
                                <h3 class="text-gray-700">
                                    {{ salesData.transaction_number }}
                                    <span :class="handleStatus(salesData).class">{{ handleStatus(salesData).label }}</span>
                                </h3>
                            </div>
                        </h1>
                    </div>
                    <div class="col-6 text-right d-flex align-items-center justify-content-end">
                        <div class="d-flex flex-column">
                            <div>
                                <router-link :to="'/app/sales/payment/'+salesData.id+'/form'">
                                    <button type="button" class="mr-3 mt-3 btn btn-primary">
                                        <i class="fa fa-dollar"></i> Receive Payment
                                    </button>
                                </router-link>
                                <router-link to="/app/sales">
                                    <button type="button" class="mr-3 mt-3 btn btn-success">
                                        <i class="fa fa-arrow-left"></i> Back
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
                                <th>Customer Name</th>
                                <td class="text-right">{{salesData.customer.name}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-lg-4">
                        <table class="table table-striped">
                            <tbody>
                            <tr>
                                <th>Customer Email</th>
                                <td class="text-right">{{salesData.customer_email}}</td>
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
                                <td class="text-right">{{salesData.billing_address}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-lg-8">
                        <table class="table table-striped">
                            <tbody>
                            <tr>
                                <th>Transaction Number</th>
                                <td class="text-right">{{salesData.transaction_number}}</td>
                            </tr>
                            <tr>
                                <th>Transaction Date</th>
                                <td class="text-right">{{salesData.transaction_date}}</td>
                            </tr>
                            <tr>
                                <th>Due Date</th>
                                <td class="text-right">{{salesData.due_date}}</td>
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
                        <tr v-show="salesData.sales_products.length == 0">
                            <td colspan="8" class="text-center">
                                Items
                            </td>
                        </tr>
                        <tr v-for="(item, key) in salesData.sales_products" :key="key">
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
                                <label>{{ salesData.message ?? '-' }}</label>
                            </div>
                            <div class="col-12">
                                <label>Attachment</label>
                                <table class="table table-striped">
                                    <tr v-for="(f, fI) in salesData.sales_attachments" :key="fI">
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
                                    {{ salesData.sub_total | formatPrice }}
                                </td>
                            </tr>
                            <tr>
                                <td>Discount ({{ salesData.discount_type }})</td>
                                <td class="text-danger text-right">
                                    ({{ salesData.discount_amount | formatPrice }})
                                </td>
                            </tr>
                            <tr>
                                <td>Tax Amount Total</td>
                                <td class="text-right">
                                    {{ salesData.tax_amount_total | formatPrice }}
                                </td>
                            </tr>
                            <tr>
                                <td>Grand Total</td>
                                <td class="text-right">
                                    {{ salesData.grand_total | formatPrice }}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="modal fade" id="showJournalEntry" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Journal Report {{ salesData.transaction_number }}</h5>
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
                                    <tr v-for="(sj, sjI) in salesData.sales_journals" :key="sjI">
                                        <td>{{ sj.coa.account_code }}</td>
                                        <td class="text-right">{{ sj.debit | formatPrice }}</td>
                                        <td class="text-right">{{ sj.credit | formatPrice }}</td>
                                    </tr>
                                    <tr>
                                        <td>Total</td>
                                        <td class="text-right">{{ handleTotal(salesData.sales_journals, 'debit')  | formatPrice}}</td>
                                        <td class="text-right">{{ handleTotal(salesData.sales_journals, 'credit') | formatPrice }}</td>
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
                salesData: null,
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

            handleStatus(s) {
                if (!s.paid_date) {
                    const dateNow = (new Date()).toISOString().split('T')[0]
                    if (s.due_date < dateNow) {
                        return {
                            "class": 'badge badge-danger rounded-pill',
                            "label": 'Overdue'
                        }
                    } else {
                        return {
                            "class": 'badge badge-warning rounded-pill',
                            "label": 'Open'
                        }
                    }
                } else {
                    return {
                        "class": 'badge badge-success rounded-pill',
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
                    const respDe = await this.$axios.get(`api/sales/${this.$route.params.type}/detail`)
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
                        this.salesData = respDe.data
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
        }
    }
</script>
