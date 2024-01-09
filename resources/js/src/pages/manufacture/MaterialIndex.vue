<template>
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-title">
                <div class="mt-3 d-flex justify-content-between">
                    <h1 class="h3 ml-3 text-gray-800 float-left">Material</h1>
                    <button @click="handleShowAddNewMaterial()" type="button" class="btn btn-primary float-right mr-3">
                        <i class="fas fa-plus-circle"></i> Create New Material
                    </button>
                </div>
            </div>
            <div class="card-body">
                <!--<div class="row mb-2">
                    <div class="col-lg-6 col-xl-3">
                        <div class="form-group">
                            <label>From Date<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                            <input type="date" class="form-control" v-model="formFilter.from_date">
                        </div>
                    </div>
                    <div class="col-lg-6 col-xl-3">
                        <div class="form-group">
                            <label>To Date<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                            <input type="date" class="form-control" v-model="formFilter.to_date">
                        </div>
                    </div>
                    <div class="col-lg-6 col-xl-3">
                        <div class="form-group">
                            <label>Bill Number<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                            <input type="text" class="form-control" v-model="formFilter.bill_number">
                        </div>
                    </div>
                    <div class="col-lg-6 col-xl-2">
                        <div class="form-group">
                            <label>Supplier<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                            <select class="form-control" v-model="formFilter.supplier">

                            </select>
                        </div>
                    </div>
                    <div class="col-lg-12 col-xl-1 d-flex align-items-center justify-content-end">
                        <button type="button" class="btn btn-primary"><i class="fas fa-search"></i></button>
                    </div>
                </div>-->
                <div class="table-responsive">
                    <table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th class="text-center"><b>Name</b></th>
                            <th class="text-center"><b>Image</b></th>
                            <th class="text-center"><b>Unit</b></th>
                            <th class="text-center"><b>Price per Unit</b></th>
                            <th class="text-center"><b>Is Archived?</b></th>
                            <th class="text-center">#</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-if="materials.length == 0">
                            <td colspan="6" class="text-center">
                                Material Not Found
                            </td>
                        </tr>
                        <tr v-else v-for="(p, pI) in materials" :key="pI">
                            <td>{{ p.name }}</td>
                            <td>
                                <img :src="p.image" width="100">
                            </td>
                            <td>{{ p.unit }}</td>
                            <td class="text-right">Rp. {{ p.price_per_unit | formatPrice }}</td>
                            <td class="text-center">
                                <span v-if="p.is_archive" class="badge badge-danger p-3">Yes</span>
                                <span v-else class="badge badge-primary p-3">No</span>
                            </td>
                            <td class="text-right">
                                <button @click="handleShowAddNewMaterial(p)" type="button" class="btn btn-warning">
                                    <i class="fas fa-pencil-alt"></i>
                                </button>
                                <button v-if="p.semi_finished_material_items.length == 0" @click="handleDelete(p.id)" class="btn btn-danger" type="button">
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
        </div>
        <div class="modal fade" id="addNewMaterial" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form @submit.prevent="handleSubmitAddNew">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add New a Material</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Material Name<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                <input type="text" class="form-control" v-model="formAdd.name" placeholder="Example: egg, flour" required>
                            </div>
                            <div class="form-group">
                                <label>Unit</label>
                                <div class="d-flex justify-content-between">
                                    <v-select v-model="formAdd.unit" :options="units" :reduce="p => p.name" style="width: 100%" label="name">
                                        <span slot="no-options">Unit not found, use + to add</span>
                                    </v-select>
                                    <button @click="handleShowAddNewUnit()" class="btn btn-warning ml-2" type="button">
                                        <i class="fas fa-plus-circle"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Price / {{ formAdd.unit }}</label>
                                <input type="text" class="form-control" v-model="formAdd.price_per_unit" placeholder="Example: 10000">
                            </div>
                            <div class="form-group">
                                <label>Image</label>
                                <input type="file" class="form-control" @change="handleChangeImage">
                            </div>
                            <img :src="formAdd.image" width="100" alt="" class="rounded">

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
        <UnitCrud :get-data="handleCallbackUnit" :form-data="formData" :label-modal="labelModal"></UnitCrud>
    </div>
</template>

<script>
    import UnitCrud from '../masterData/product/components/UnitCrud'
    export default {
        name: "Index.vue",
        components: {UnitCrud},
        data() {
            return {
                labelModal: "Add",
                formAdd: {
                    id: "",
                    name: "",
                    image: "",
                    unit: "",
                    price_per_unit: ""
                },
                materials: [],
                units: [],
                fileImage: "",
                formData: {
                    'id': "",
                    'name': ""
                }
            }
        },
        created() {
            this.getData()
        },
        methods: {
            handleCallbackUnit() {
                $("#addNewMaterial").modal("show")
                $("#addProductUnit").modal("hide")
                this.handleGetUnit(true)
            },

            async handleShowAddNewUnit() {
                this.formData = {
                    'id': "",
                    'name': ""
                }
                $("#addNewMaterial").modal("hide")
                $("#addProductUnit").modal("show")
            },

            handleChangeImage(e) {
                this.fileImage = e.target.files[0]
            },

            async handleSubmitAddNew() {
                try {
                    const formData =  new FormData()
                    formData.append('id', this.formAdd.id)
                    formData.append('name', this.formAdd.name)
                    formData.append('unit', this.formAdd.unit ?? '')
                    formData.append('image', this.fileImage)
                    formData.append('price_per_unit', this.formAdd.price_per_unit)
                    this.$vs.loading()
                    const resp = await this.$axios.post(`api/manufacture/material`,
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
                        $("#addNewMaterial").modal('hide')
                        this.getData()
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

            async handleGetUnit(isNew = false) {
                try {
                    if (isNew) {
                        this.units = []
                    }
                    if (this.units.length === 0) {
                        this.$vs.loading()
                        this.units = await this.$axios.get(`api/master-data/unit`)
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

            async handleShowAddNewMaterial(p = null) {
                await this.handleGetUnit()
                if (p !== null) {
                    this.formAdd = p
                } else {
                    this.formAdd = {
                        id: "",
                        name: "",
                        image: "",
                        unit: "",
                        price_per_unit: ""
                    }
                }
                $("#addNewMaterial").modal("show")
            },

            async getData() {
                try {
                    this.$vs.loading()
                    this.materials = await this.$axios.get(`api/manufacture/material`)
                    this.$vs.loading.close()
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
                    title: 'Are You Sure Want To Delete This Material?',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    showCloseButton: true,
                    showCancelButton: true,
                }).then((result)=>{
                    if(result.isConfirmed == true){
                        this.$vs.loading()
                        this.$axios.delete(`api/manufacture/material/${id}/delete`).then((response)=>{
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
                                    text: "Failed To Delete Material : " + response.message ,
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
                    title: `Are You Sure Want To ${p.is_archive ? 'Un Archive' : 'Archive'} This Material?`,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    showCloseButton: true,
                    showCancelButton: true,
                }).then((result)=>{
                    if(result.isConfirmed == true){
                        this.$vs.loading()
                        this.$axios.get(`api/manufacture/material/${p.id}/archive`).then((response)=>{
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
                                    text: "Failed To Archive Material : " + response.message ,
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