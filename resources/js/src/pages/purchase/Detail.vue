<template>
    <div v-if="purchaseData !== null" class="container-fluid">
        <div class="card">
            <div class="card-title">
                <div class="row">
                    <div class="col-6">
                        <h1 class="h3 mt-3 ml-3 text-primary">Detail Purchase</h1>
                    </div>
                    <div class="col-6 text-right">
                        <button :disabled="purchaseData.bill_number !== 'DRAFT'" type="button" class="mr-3 mt-3 btn btn-primary" @click="handleApprove()">
                            <i class="fas fa-check-circle"></i> Approve
                        </button>
                        <router-link to="/app/purchase">
                            <button type="button" class="mr-3 mt-3 btn btn-success">
                                <i class="fa fa-arrow-left"></i> Back
                            </button>
                        </router-link>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 col-xl-8">
                        <table class="table table-striped">
                            <tbody>
                            <tr>
                                <th>Bill Number</th>
                                <td class="text-right">{{purchaseData.bill_number}}</td>
                            </tr>
                            <tr>
                                <th>Invoice Date</th>
                                <td class="text-right">{{purchaseData.invoice_date}}</td>
                            </tr>
                            <tr>
                                <th>Due Date</th>
                                <td class="text-right">{{purchaseData.invoice_date}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6 col-xl-4">
                        <table class="table table-striped">
                            <tbody>
                            <tr>
                                <th>Supplier Name</th>
                                <td class="text-right">{{purchaseData.supplier.name}}</td>
                            </tr>
                            <tr>
                                <th>Supplier Phone</th>
                                <td class="text-right">{{purchaseData.supplier.phone}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Type</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-center">Price per Unit</th>
                            <th class="text-center">Total</th>
                            <th class="text-center">#</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-show="purchaseData.purchase_items.length == 0">
                            <td colspan="6" class="text-center">
                                Items
                            </td>
                        </tr>
                        <tr v-for="(item, key) in purchaseData.purchase_items">
                            <td><strong>{{ key+1 }}</strong></td>
                            <td>{{ item.product_id ? "Product" : "Material" }}</td>
                            <td>{{ item.product_id ? item.product.product_name : item.material.name }}</td>
                            <td>{{ item.quantity }}</td>
                            <td class="text-right">Rp. {{ item.price_per_unit | formatPrice }}</td>
                            <td class="text-right">Rp. {{ item.amount_total | formatPrice }}</td>
                            <td>
                            </td>
                        </tr>
                        </tbody>
                    </table>
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
            async handleApprove() {
                Swal.fire({
                    icon: 'warning',
                    title: 'Are You Sure Want To Approve this Purchase?',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    showCloseButton: true,
                    showCancelButton: true,
                }).then(async (result)=>{
                    if(result.isConfirmed == true){
                        try {
                            this.$vs.loading()
                            const respDe = await this.$axios.get(`api/purchase/${this.$route.params.type}/approve`)
                            this.$vs.loading.close()

                            if (!respDe.status) {
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'error',
                                    title: respDe.message,
                                    showConfirmButton: false,
                                    timer: 1500
                                })
                            } else {
                                this.purchaseData = respDe.data
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

            async getData() {
                try {
                    this.$vs.loading()
                    const respDe = await this.$axios.get(`api/purchase/${this.$route.params.type}/detail`)
                    this.$vs.loading.close()
                    console.log("respDe", respDe)

                    if (!respDe.status) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: respDe.message,
                            showConfirmButton: false,
                            timer: 1500
                        })
                    } else {
                        this.purchaseData = respDe.data
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
            },
        }
    }
</script>
