<template>
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-title">
                <div class="mt-3 d-flex justify-content-between">
                    <h1 class="h3 ml-3 text-gray-800 float-left">Finished Good</h1>
                    <router-link to="/app/manufacture/product/create/form">
                        <button type="button" class="btn btn-primary float-right mr-3">
                            <i class="fas fa-plus-circle"></i> Create New Finished Good
                        </button>
                    </router-link>
                </div>
            </div>
            <div class="card-body">
                <!--<div class="row mb-2">-->
                    <!--<div class="col-lg-6 col-xl-3">-->
                        <!--<div class="form-group">-->
                            <!--<label>From Date<span style="-->
                                    <!--color: red;-->
                                    <!--font-weight: bold;-->
                                    <!--font-style: italic;-->
                                <!--">*) required</span></label>-->
                            <!--<input type="date" class="form-control" v-model="formFilter.from_date">-->
                        <!--</div>-->
                    <!--</div>-->
                    <!--<div class="col-lg-6 col-xl-3">-->
                        <!--<div class="form-group">-->
                            <!--<label>To Date<span style="-->
                                    <!--color: red;-->
                                    <!--font-weight: bold;-->
                                    <!--font-style: italic;-->
                                <!--">*) required</span></label>-->
                            <!--<input type="date" class="form-control" v-model="formFilter.to_date">-->
                        <!--</div>-->
                    <!--</div>-->
                    <!--<div class="col-lg-6 col-xl-3">-->
                        <!--<div class="form-group">-->
                            <!--<label>Bill Number<span style="-->
                                    <!--color: red;-->
                                    <!--font-weight: bold;-->
                                    <!--font-style: italic;-->
                                <!--">*) required</span></label>-->
                            <!--<input type="text" class="form-control" v-model="formFilter.bill_number">-->
                        <!--</div>-->
                    <!--</div>-->
                    <!--<div class="col-lg-6 col-xl-2">-->
                        <!--<div class="form-group">-->
                            <!--<label>Supplier<span style="-->
                                    <!--color: red;-->
                                    <!--font-weight: bold;-->
                                    <!--font-style: italic;-->
                                <!--">*) required</span></label>-->
                            <!--<select class="form-control" v-model="formFilter.supplier">-->

                            <!--</select>-->
                        <!--</div>-->
                    <!--</div>-->
                    <!--<div class="col-lg-12 col-xl-1 d-flex align-items-center justify-content-end">-->
                        <!--<button type="button" class="btn btn-primary"><i class="fas fa-search"></i></button>-->
                    <!--</div>-->
                <!--</div>-->
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th class="text-center"><b>ID</b></th>
                            <th class="text-center"><b>Status</b></th>
                            <th class="text-center"><b>Name</b></th>
                            <th class="text-center"><b>Grand Total</b></th>
                            <th class="text-center"><b>Description</b></th>
                            <th class="text-center"><b>Semi Finished Goods</b></th>
                            <th class="text-center">#</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-if="manufactureProducts.length == 0">
                            <td colspan="7" class="text-center">
                                Finished Good Not Found
                            </td>
                        </tr>
                        <tr v-else v-for="(p, pI) in manufactureProducts" :key="pI">
                            <td>{{ pI + 1 }}</td>
                            <td>{{ p.status }}</td>
                            <td>{{ p.name }}</td>
                            <td class="text-right">{{ p.grand_total |formatPrice }}</td>
                            <td>{{ p.description }}</td>
                            <td>
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th class="text-center"><b>Name</b></th>
                                        <th class="text-center"><b>Amount Total</b></th>
                                        <th class="text-center"><b>Material Name</b></th>
                                        <th class="text-center"><b>Material Dose</b></th>
                                        <th class="text-center"><b></b></th>
                                        <th class="text-center"><b>Material Amount Total</b></th>
                                    </tr>
                                    </thead>
                                    <tbody v-for="(d, dI) in p.manufacture_product_details" :key="dI">
                                    <tr v-for="(di, diI) in d.manufacture_product_detail_items" :key="diI">
                                        <td :rowspan="d.manufacture_product_detail_items.length" v-if="diI === 0">{{ d.name }}</td>
                                        <td :rowspan="d.manufacture_product_detail_items.length" v-if="diI === 0" class="text-right">{{ d.price_total | formatPrice }}</td>
                                        <td>{{ di.name }}</td>
                                        <td class="text-right">{{ di.dose }}</td>
                                        <td>/{{ di.unit }}</td>
                                        <td class="text-right">{{ di.price_dose |formatPrice }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                            <td class="text-right">
                                <router-link :to="'/app/manufacture/product/'+p.id+'/form'">
                                        <button type="button" :disabled="p.status !== 'DRAFT'" class="btn btn-warning">
                                            <i class="fas fa-pencil-alt"></i>
                                        </button>
                                </router-link>
                                <router-link :to="'/app/manufacture/product/'+p.id+'/detail'">
                                    <button type="button" class="btn btn-primary">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </router-link>
                                <button @click="handleDelete(p.id)" class="btn btn-danger" type="button">
                                    <i class="fas fa-trash"></i>
                                </button>
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
        name: "Index.vue",
        data() {
            return {
                manufactureProducts: [],
                formFilter: {
                    from_date: "",
                    to_date: "",
                    bill_number: "",
                    supplier: ""
                }
            }
        },
        created() {
            this.getData()
        },
        methods: {
            async getData() {
                try {
                    this.$vs.loading()
                    this.manufactureProducts = await this.$axios.get(`api/manufacture/product`)
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
                    title: 'Are You Sure Want To Delete This Product?',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    showCloseButton: true,
                    showCancelButton: true,
                }).then((result)=>{
                    if(result.isConfirmed == true){
                        this.$vs.loading()
                        this.$axios.delete(`api/manufacture/product/${id}/delete`).then((response)=>{
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
                                    text: "Failed To Delete Product : " + response.message ,
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