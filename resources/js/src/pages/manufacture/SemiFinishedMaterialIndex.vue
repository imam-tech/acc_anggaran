<template>
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-title">
                <div class="mt-3 d-flex justify-content-between">
                    <h1 class="h3 ml-3 text-gray-800 float-left">Semi Finished Goods</h1>
                    <button @click="handleShowAddNewMaterial()" type="button" class="btn btn-primary float-right mr-3">
                        <i class="fas fa-plus-circle"></i> Create New Semi Finished Goods
                    </button>
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
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <td class="text-center"><b>ID</b></td>
                            <td class="text-center"><b>Name</b></td>
                            <td class="text-center"><b>Price Total</b></td>
                            <td class="text-center"><b>Material Name</b></td>
                            <td class="text-center"><b>Material Image</b></td>
                            <td class="text-center"><b>Material Dose</b></td>
                            <td></td>
                            <td class="text-center"><b>Material Price per Unit</b></td>
                            <td></td>
                            <td class="text-center"><b>Price Dose</b></td>
                            <td class="text-center"><b>Is Archive?</b></td>
                            <td class="text-center"><b>#</b></td>
                        </tr>
                        </thead>
                        <tbody v-for="(p, pI) in semiFinishedMaterials">
                        <tr v-for="(sf, sfI) in p.semi_finished_material_items">
                            <td :rowspan="p.semi_finished_material_items.length" v-if="sfI === 0">{{ (pI+1) }}</td>
                            <td :rowspan="p.semi_finished_material_items.length" v-if="sfI === 0">{{ p.name }}</td>
                            <td :rowspan="p.semi_finished_material_items.length" v-if="sfI === 0" class="text-right">{{ p.price_total | formatPrice }}</td>
                            <td>{{ sf.material ? sf.material.name : '-' }}</td>
                            <td>
                                <img v-if="sf.material" :src="sf.material.image" width="100" />
                            </td>
                            <td class="text-right">{{ sf.dose }}</td>
                            <td>{{  sf.material ? sf.material.unit : '-' }}</td>
                            <td class="text-right"><span v-if="sf.material">{{ sf.material.price_per_unit | formatPrice }}</span></td>
                            <td>/{{  sf.material ? sf.material.unit : '-' }}</td>
                            <td class="text-right">{{ sf.price | formatPrice }}</td>
                            <td :rowspan="p.semi_finished_material_items.length" v-if="sfI === 0" class="text-center">
                                <span v-if="p.is_archive" class="badge badge-danger p-2">Yes</span>
                                <span v-else class="badge badge-primary p-2 rounded-pill">No</span>
                            </td>
                            <td :rowspan="p.semi_finished_material_items.length" v-if="sfI === 0" class="text-right">
                                <button class="btn btn-warning" type="button" @click="handleShowAddNewMaterial(p)">
                                    <i class="fas fa-pencil-alt"></i>
                                </button>
                                <button v-if="p.manufacture_product_details.length == 0" @click="handleDelete(p.id)" class="btn btn-danger" type="button">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <button v-else @click="handleArchive(p)" class="btn btn-secondary" type="button">
                                    <i class="fas fa-archive"></i>
                                </button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <SemiFinishedMaterialCrud ref="semiFinishedMaterialCrud" :get-data="getData" :materials="materials" :form-data="formAdd" :label-modal="labelModal"></SemiFinishedMaterialCrud>
        </div>
    </div>
</template>

<script>
    import SemiFinishedMaterialCrud from './components/SemiFinishedMaterialCrud'

    export default {
        name: "Index.vue",
        components: {SemiFinishedMaterialCrud},
        data() {
            return {
                semiFinishedMaterials: [],
                formFilter: {
                    from_date: "",
                    to_date: "",
                    bill_number: "",
                    supplier: ""
                },
                formAdd: {
                    id: "",
                    name: "",
                    items: []
                },
                materials: [],
                selectedMaterial: '',
                labelModal: "Add",
            }
        },
        created() {
            this.getData()
        },
        methods: {

            async handleSubmitAddNew() {
                const semiFinishedMaterialRef = this.$refs.semiFinishedMaterial
                semiFinishedMaterialRef.handleSubmit()
            },

            async handleShowAddNewMaterial(sf = null) {
                console.log("oke")
                await this.handleGetMaterial()
                if (sf !== null) {
                    this.labelModal = "Edit"
                    this.formAdd.id = sf.id
                    this.formAdd.name = sf.name
                    this.formAdd.items = []
                    sf.semi_finished_material_items.forEach((x) => {
                        this.selectedMaterial = x.material
                        this.selectedMaterial.dose = parseFloat(x.dose)
                        this.handleChangeMaterial()
                    })
                } else {
                    this.labelModal = "Add"
                    this.formAdd = {
                        id: "",
                        name: "",
                        items: []
                    }
                }
                $("#addNewMaterial").modal("show")
            },

            handleChangeMaterial() {
                let isInsert = false;
                this.formAdd.items.forEach((x) => {
                    if (x.id === this.selectedMaterial.id) {
                        isInsert = true
                    }
                })

                if (!isInsert) {
                    this.formAdd.items.push(this.selectedMaterial)
                }
            },

            async handleGetMaterial() {
                try {
                    if (this.materials.length === 0) {
                        this.$vs.loading()
                        this.materials = await this.$axios.get(`api/manufacture/material?is_archive=no`)
                        this.$vs.loading.close()
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

            async getData() {
                try {
                    this.$vs.loading()
                    this.semiFinishedMaterials = await this.$axios.get(`api/manufacture/semi-finished-material`)
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
                    title: 'Are You Sure Want To Delete This Semi Finished Goods?',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    showCloseButton: true,
                    showCancelButton: true,
                }).then((result)=>{
                    if(result.isConfirmed == true){
                        this.$vs.loading()
                        this.$axios.delete(`api/manufacture/semi-finished-material/${id}/delete`).then((response)=>{
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
                                    text: "Failed To Delete Semi Finished Goods : " + response.message ,
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    allowEnterKey: false,
                                });
                            }
                        });
                    }
                })
            },

            async handleArchive(p) {
                Swal.fire({
                    icon: 'warning',
                    title: `Are You Sure Want To ${p.is_archive ? 'Un Archive' : 'Archive'} This Semi Finished Goods?`,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    showCloseButton: true,
                    showCancelButton: true,
                }).then((result)=>{
                    if(result.isConfirmed == true){
                        this.$vs.loading()
                        this.$axios.get(`api/manufacture/semi-finished-material/${p.id}/archive`).then((response)=>{
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
                                    text: "Failed To Archive Semi Finished Goods : " + response.message ,
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