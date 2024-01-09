<template>
    <div class="container-fluid">
        <div class="card">
            <div class="card-title">
                <h1 class="h3 mt-3 ml-3 text-gray-800 float-left">Payment Form</h1>
                <router-link :to="'/app/input-data/sales/'+$route.params.id+'/detail'" class="btn btn-success float-right mt-3 mr-3">
                    <i class="fas fa-arrow-left"></i> Back
                </router-link>
            </div>
            <div class="card-body">
                <form @submit.prevent="handleSubmit">
                    <div class="row">
                        <div class="col-lg-6 col-xl-3">
                            <div class="form-group">
                                <label>Customer<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                <v-select :disabled="true" v-model="salesData.contact_id" :options="customers" :reduce="p => p.id" style="width: 100%" label="name">
                                    <template #search="{attributes, events}">
                                        <input
                                                class="vs__search"
                                                :required="!salesData.contact_id"
                                                v-bind="attributes"
                                                v-on="events"
                                        />
                                    </template>
                                    <span slot="no-options">Customer not found</span>
                                </v-select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-3">
                            <div class="form-group">
                                <label>Deposit To<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                <v-select v-model="formData.deposit_to" :options="depositTo" :reduce="p => p.id" style="width: 100%" label="account_code">
                                    <template #search="{attributes, events}">
                                        <input
                                                class="vs__search"
                                                :required="!formData.deposit_to"
                                                v-bind="attributes"
                                                v-on="events"
                                        />
                                    </template>
                                    <span slot="no-options">Deposit not found</span>
                                </v-select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-xl-3">
                            <div class="form-group">
                                <label>Payment Method</label>
                                <div class="d-flex justify-content-between">
                                    <v-select v-model="formData.payment_method" :options="paymentMethods" :reduce="p => p.id" style="width: 100%" label="name">
                                        <span slot="no-options">Payment Method not found</span>
                                    </v-select>
                                    <button class="btn btn-warning ml-2" type="button" @click="handleShowAddModalPaymentMethod()">
                                        <i class="fas fa-plus-circle"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-3">
                            <div class="form-group">
                                <label>Payment date<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                <input type="date" class="form-control" v-model="formData.payment_date" required>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-3">
                            <div class="form-group">
                                <label>Due date</label>
                                <input type="date" class="form-control" v-model="formData.due_date">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>Transaction Number</th>
                                    <th>Description</th>
                                    <th>Due Date</th>
                                    <th>Total</th>
                                    <th>Balance Due</th>
                                    <th>Payment Amount</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>{{ salesData.transaction_number }}</td>
                                    <td>{{ salesData.description }}</td>
                                    <td>{{ salesData.due_date }}</td>
                                    <td>{{ salesData.total | formatPrice }}</td>
                                    <td>{{ salesData.balance_due | formatPrice }}</td>
                                    <td><input type="number" class="form-control" v-model="formData.payment_amount" required></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label>Message</label>
                                <textarea v-model="formData.memo" class="form-control" cols="30" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Attachment</label>
                                <table class="table table-striped">
                                    <tr v-for="(f, fI) in fileImages" :key="fI">
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
                                            <button @click="handleDeleteAttachment(fI)" type="button" class="btn btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </table>
                                <div v-if="fileImages.length < 5">
                                    <input type="file" class="form-control" @change="handleChangeImage" />
                                    <span>Files can be Excel, Word, PDF, JPG, or PNG (maximum 5 files and 5 MB per file).</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Save
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal fade" id="addNewPaymentMethod" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form @submit.prevent="handleSubmitAddNewPaymentMethod">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Add New Payment Method</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Name<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                            <input type="text" class="form-control" v-model="formAddPaymentMethod.name" required>
                                        </div>
                                    </div>
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
                salesData: {
                    id: "",
                    contact_id: "",
                    due_date: "",
                    transaction_number: '',
                    description: '',
                    total: 0,
                    balance_due: 0
                },
                formData: {
                    id: "",
                    contact_id: "",
                    deposit_to: "",
                    payment_method: "",
                    payment_date: (new Date()).toISOString().split('T')[0],
                    due_date: "",
                    payment_amount: 0,
                    memo: ""
                },
                depositTo: [],
                paymentMethods: [],
                formAddPaymentMethod: {
                    id: "",
                    name: "",
                },

                selectedProduct: "",
                customers: [],
                products: [],
                subTotal: 0,
                discountAmount: 0,
                taxAmountTotal: 0,
                grandTotal: 0,
                fileImages: [],
            }
        },

        mounted() {
            this.getDataOther()
            this.handleGet()
            if (this.$route.params.type !== 'create') {
                this.handleGetPayment()
            }
        },
        methods: {
            handleShowBalanceDue(s) {
                if (parseFloat(s.payment_amount_total) >= parseFloat(s.grand_total)) {
                    return 0
                }
                return parseFloat(s.grand_total) - parseFloat(s.payment_amount_total);
            },

            async getDataOther() {
                try {
                    this.$vs.loading()
                    this.customers = await this.$axios.get(`api/master-data/contact?type=sale`)
                    this.depositTo = await this.$axios.get(`api/master-data/coa?is_active=1&coa_name=KAS`)
                    const bankDeposits = await this.$axios.get(`api/master-data/coa?is_active=1&coa_name=BANK`)
                    bankDeposits.forEach((x) => this.depositTo.push(x))
                    this.paymentMethods = await this.$axios.get(`api/master-data/payment-method?is_archive=no`)
                    this.$vs.loading.close()
                } catch (e) {
                    this.$vs.loading.close()
                    Swal.fire({
                        position: 'top',
                        icon: 'error',
                        title: e.message,
                        showConfirmButton: false,
                        timer: 2000
                    })
                }
            },

            handleShowAddModalPaymentMethod() {
                $("#addNewPaymentMethod").modal('show')
            },

            async handleSubmitAddNewPaymentMethod() {
                try {
                    this.$vs.loading()
                    const resp = await this.$axios.post(`api/master-data/payment-method`, this.formAddPaymentMethod)
                    this.$vs.loading.close()
                    if (!resp.status)  {
                        Swal.fire({
                            position: 'top',
                            icon: 'error',
                            title: resp.message,
                            showConfirmButton: false,
                            timer: 2500
                        })
                        return
                    } else {
                        Swal.fire({
                            position: 'top',
                            icon: 'success',
                            title: resp.message,
                            showConfirmButton: false,
                            timer: 2500
                        })
                        $("#addNewPaymentMethod").modal('hide')
                        this.paymentMethods = await this.$axios.get(`api/master-data/payment-method`)
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

            async handleGet() {
                try {
                    this.$vs.loading()
                    const salesLocal = await this.$axios.get(`api/input-data/sales/${this.$route.params.id}/detail`)
                    this.$vs.loading.close()
                    if (!salesLocal.status) {
                        Swal.fire({
                            position: 'top',
                            icon: 'error',
                            title: salesLocal.message,
                            showConfirmButton: false,
                            timer: 2500
                        })
                        return
                    }
                    this.salesData.id = salesLocal.data.id
                    this.salesData.transaction_number = salesLocal.data.transaction_number
                    this.salesData.description = salesLocal.data.description
                    this.salesData.contact_id = salesLocal.data.contact_id
                    this.salesData.due_date = salesLocal.data.due_date
                    this.salesData.total = salesLocal.data.grand_total
                    this.salesData.balance_due = this.handleShowBalanceDue(salesLocal.data)
                    this.formData.payment_amount = this.handleShowBalanceDue(salesLocal.data)
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

            async handleGetPayment() {
                try {
                    this.$vs.loading()

                    const paymentLocal = await this.$axios.get(`api/input-data/sales/payment/${this.$route.params.type}/detail`)
                    this.$vs.loading.close()
                    if (paymentLocal.status) {
                        if (paymentLocal.data.status) {
                            Swal.fire({
                                position: 'top',
                                icon: 'error',
                                title: 'The payment is not editable because the status is approved',
                                showConfirmButton: false,
                                timer: 3000
                            }).then(async ()=>{
                                this.$router.push('/app/input-data/sales/'+this.$route.params.id+'/detail')
                            })
                            return
                        }
                        this.formData.id = paymentLocal.data.id
                        this.formData.deposit_to = paymentLocal.data.deposit_to
                        this.formData.payment_method = paymentLocal.data.payment_method ? paymentLocal.data.payment_method.id : ''
                        this.formData.contact_id = paymentLocal.data.sales.contact_id
                        this.formData.payment_date = paymentLocal.data.payment_date
                        this.formData.due_date = paymentLocal.data.due_date ?? ''
                        this.formData.payment_amount = paymentLocal.data.payment_amount
                        this.formData.memo = paymentLocal.data.memo ?? ''
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


            handleDeleteAttachment(index) {
                this.fileImages = this.fileImages.filter((item, ind) => ind !== index)
            },

            async handleSubmit() {
                const formData = new FormData()
                formData.append('id', this.formData.id)
                formData.append('sales_id', this.salesData.id)
                formData.append('deposit_to', this.formData.deposit_to)
                formData.append('payment_method', this.formData.payment_method)
                formData.append('payment_date', this.formData.payment_date)
                formData.append('due_date', this.formData.due_date)
                formData.append('payment_amount', this.formData.payment_amount)
                formData.append('memo', this.formData.memo)
                this.fileImages.forEach((x, i) => {
                    formData.append(`attachment${i}`, x.ori)
                })

                try {
                    this.$vs.loading()
                    const resp = await this.$axios.post(`api/input-data/sales/payment`,
                        formData, {
                            headers: {
                                "Content-Type": "multipart/form-data"
                            }
                        })
                    this.$vs.loading.close()
                    if (!resp.status)  {
                        Swal.fire({
                            position: 'top',
                            icon: 'error',
                            title: resp.message,
                            showConfirmButton: false,
                            timer: 2500
                        })
                        return
                    } else {
                        Swal.fire({
                            position: 'top',
                            icon: 'success',
                            title: resp.message,
                            showConfirmButton: false,
                            timer: 2500
                        })
                        this.$router.push(`/app/input-data/sales/payment/${resp.data.id}/detail`)
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

            handleSizeFile(size) {
                if (size < 1000000)  {
                    return parseFloat(size/1000).toFixed(0) + ' Kb'
                } else {
                    return parseFloat(size / 1000000).toFixed(2) + ' Mb'
                }
            },

            handleShowIconFile(type) {
                if (type === 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') return 'fas fa-file-word-o';
                if (type === 'application/pdf') return 'fas fa-file-pdf-o';
                if (type === 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') return 'fas fa-file-excel-o'
                if (['image/jpg', 'image/jpeg'].includes(type)) return 'fas fa-file-image-o'
                if (type === 'image/png') return 'fa-picture-o'
            },

            handleChangeImage(e) {
                const fileSel = e.target.files[0]
                if (fileSel.size > 5000000) {
                    Swal.fire({
                        position: 'top',
                        icon: 'error',
                        title: "Maximum size of file is 5 Mb",
                        showConfirmButton: false,
                        timer: 2000
                    })
                    return
                }
                const types = ['application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/pdf',
                    'image/jpg', 'image/jpeg', 'image/png'];
                if (!types.includes(fileSel.type)) {
                    Swal.fire({
                        position: 'top',
                        icon: 'error',
                        title: "Please input the type of file from Excel, Word, PDF, JPG, or PNG",
                        showConfirmButton: false,
                        timer: 2000
                    })
                    return
                }
                this.fileImages.push({
                    name: fileSel.name,
                    type: fileSel.type,
                    size: fileSel.size,
                    ori: fileSel
                })
            },
        }
    }
</script>
