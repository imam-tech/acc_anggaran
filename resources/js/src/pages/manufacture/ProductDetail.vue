<template>
    <div v-if="manufactureProduct !== null" class="container-fluid">
        <div class="card">
            <div class="card-title">
                <div class="row">
                    <div class="col-6">
                        <h1 class="h3 mt-3 ml-3 text-primary">Detail Finished Good</h1>
                    </div>
                    <div class="col-6 text-right">
                        <button :disabled="manufactureProduct.status !== 'DRAFT'" type="button" class="mr-3 mt-3 btn btn-primary" @click="handleApprove()">
                            <i class="fas fa-check-circle"></i> Approve
                        </button>
                        <router-link to="/app/manufacture/product">
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
                                <th>ID</th>
                                <td class="text-right">#{{manufactureProduct.id}}</td>
                            </tr>
                            <tr>
                                <th>Name</th>
                                <td class="text-right">{{manufactureProduct.name}}</td>
                            </tr>
                            <tr>
                                <th>Amount Total</th>
                                <td class="text-right">{{manufactureProduct.grand_total | formatPrice}}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td class="text-right">{{manufactureProduct.status}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="table-responsive">

                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <td class="text-center"><b>Semi Finished Goods Name</b></td>
                            <td class="text-center"><b>Semi Finished Goods Price Total</b></td>
                            <td class="text-center"><b>Material Name</b></td>
                            <td class="text-center"><b>Material Dose</b></td>
                            <td></td>
                            <td class="text-center"><b>Material Amount Total</b></td>
                        </tr>
                        </thead>
                        <tbody v-for="(p, pI) in manufactureProduct.manufacture_product_details">
                        <tr v-for="(sf, sfI) in p.manufacture_product_detail_items">
                            <td :rowspan="p.manufacture_product_detail_items.length" v-if="sfI === 0">{{ p.name }}</td>
                            <td :rowspan="p.manufacture_product_detail_items.length" v-if="sfI === 0" class="text-right">{{ p.price_total | formatPrice}}</td>
                            <td>{{ sf.name }}</td>
                            <td class="text-right">{{ sf.dose }}</td>
                            <td>/{{ sf.unit }}</td>
                            <td class="text-right">{{ sf.price_dose |formatPrice }}</td>
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
                manufactureProduct: null,
            }
        },

        mounted() {
            this.getData()
        },
        methods: {
            async handleApprove() {
                Swal.fire({
                    icon: 'warning',
                    title: 'Are You Sure Want To Approve this Finished Good?',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    showCloseButton: true,
                    showCancelButton: true,
                }).then(async (result)=>{
                    if(result.isConfirmed == true){
                        try {
                            this.$vs.loading()
                            const respDe = await this.$axios.get(`api/manufacture/product/${this.$route.params.type}/approve`)
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
                                this.manufactureProduct = respDe.data
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
                    const respDe = await this.$axios.get(`api/manufacture/product/${this.$route.params.type}/detail`)
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
                        this.manufactureProduct = respDe.data
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
