<template>
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-title">
                <div class="mt-3 d-flex justify-content-between">
                    <h1 class="h3 ml-3 text-gray-800 float-left">Semi Finished Material</h1>
                    <button @click="handleShowAddNewMaterial()" type="button" class="btn btn-primary float-right mr-3">
                        <i class="fa fa-plus-circle"></i> Create New Semi Finished Material
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
                            <td class="text-center"><b>Semi Finished Material Name</b></td>
                            <td class="text-center"><b>Material Name</b></td>
                            <td class="text-center"><b>Material Image</b></td>
                            <td class="text-center"><b>Material Dose</b></td>
                            <td></td>
                            <td class="text-center"><b>Material Real Stock</b></td>
                            <td></td>
                            <td class="text-center"><b>#</b></td>
                        </tr>
                        </thead>
                        <tbody v-for="(p, pI) in semiFinishedMaterials">
                        <tr v-for="(sf, sfI) in p.semi_finished_material_items">
                            <td :rowspan="p.semi_finished_material_items.length" v-if="sfI === 0">{{ p.id }}</td>
                            <td :rowspan="p.semi_finished_material_items.length" v-if="sfI === 0">{{ p.name }}</td>
                            <td>{{ sf.material.name }}</td>
                            <td>
                                <img :src="sf.material.image" width="100" />
                            </td>
                            <td class="text-right">{{ sf.dose }}</td>
                            <td>{{ sf.material.unit }}</td>
                            <td class="text-right">{{ sf.material.stock }}</td>
                            <td>{{ sf.material.unit }}</td>
                            <td :rowspan="p.semi_finished_material_items.length" v-if="sfI === 0" class="text-right">
                                <button class="btn btn-warning" type="button" @click="handleShowAddNewMaterial(p)">
                                    <i class="fas fa-pencil-alt"></i>
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
                            <h5 class="modal-title" id="exampleModalLabel">{{ formAdd === '' ? 'Add New' : "Update" }} a Semi Finished Material</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Semi Finished Material Name<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                <input type="text" class="form-control" v-model="formAdd.name" required>
                            </div>
                            <div class="form-group">
                                <label>Material<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                <v-select v-model="selectedMaterial" :options="materials" :reduce="p => p" style="width: 100%" label="name" @input="handleChangeMaterial">
                                    <span slot="no-options">Material Not Found</span>
                                </v-select>
                            </div>
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Dose</th>
                                    <th>Stock</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(m, mI) in formAdd.items" :key="mI">
                                    <td>{{ m.name }}</td>
                                    <td class="d-flex flex-row justify-content-between align-items-center">
                                        <input type="number" class="form-control" v-model="formAdd.items[mI].dose" :max="m.stock" step="0.1" required> <span>{{ m.unit }}</span>
                                    </td>
                                    <td>{{ m.stock }} {{ m.unit }}</td>
                                </tr>
                                </tbody>
                            </table>
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
</template>

<script>
    export default {
        name: "Index.vue",
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
            }
        },
        created() {
            this.getData()
        },
        methods: {

            async handleSubmitAddNew() {
                try {
                    this.$vs.loading()
                    const resp = await this.$axios.post(`api/manufacture/semi-finished-material`, this.formAdd)
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
                        position: 'top-end',
                        icon: 'error',
                        title: e.message,
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
            },

            async handleShowAddNewMaterial(sf = null) {
                await this.handleGetMaterial()
                console.log("sf", sf)
                if (sf !== null) {
                    this.formAdd.id = sf.id
                    this.formAdd.name = sf.name
                    this.formAdd.items = []
                    sf.semi_finished_material_items.forEach((x) => {
                        this.selectedMaterial = x.material
                        this.selectedMaterial.dose = parseFloat(x.dose)
                        this.handleChangeMaterial()
                    })
                } else {
                    this.formAdd = {
                        id: "",
                        name: "",
                        items: []
                    }
                    this.selectedMaterial = ''
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
                        this.materials = await this.$axios.get(`api/manufacture/material`)
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
        }
    }
</script>