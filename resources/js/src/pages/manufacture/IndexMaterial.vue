<template>
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-title">
                <div class="mt-3 d-flex justify-content-between">
                    <h1 class="h3 ml-3 text-gray-800 float-left">Material</h1>
                    <button @click="handleShowAddNewMaterial()" type="button" class="btn btn-success float-right mr-3">
                        <i class="fa fa-plus-circle"></i> Create New Material
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
                            <th class="text-center"><b>Stock</b></th>
                            <th class="text-center"><b>Unit</b></th>
                            <th class="text-center"><b>Last Price per Unit</b></th>
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
                            <td class="text-right">{{ p.stock }}</td>
                            <td>{{ p.unit }}</td>
                            <td class="text-right">Rp. {{ p.last_price_per_unit | formatPrice }}</td>
                            <td class="text-right">
                                <button @click="handleShowHistory(p)" type="button" class="btn btn-primary">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button @click="handleShowAddNewMaterial(p)" type="button" class="btn btn-warning">
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
                                <input type="text" class="form-control" v-model="formAdd.name" required>
                            </div>
                            <div class="form-group">
                                <label>Image<span v-if="formAdd.id === ''" style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                <input type="file" class="form-control" @change="handleChangeImage" :required="formAdd.id === ''">
                            </div>
                            <img :src="formAdd.image" width="100" alt="" class="rounded">

                            <div class="form-group">
                                <label>Unit<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>

                                <select v-model="formAdd.unit" class="form-control" required>
                                    <option v-for="(u, uI) in units" :key="uI" :value="u.title">{{ u.title }}</option>
                                </select>
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
        <div class="modal fade" id="showHistory" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">History of Material</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Type History</th>
                                <th>Stock</th>
                                <th>Note</th>
                                <th>Price per Unit</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-if="selectedMaterial.material_histories !== undefined" v-for="(h, hI) in selectedMaterial.material_histories" :key="hI">
                                <td>{{ h.type_history }}</td>
                                <td>{{ h.stock }} {{ selectedMaterial.unit }}</td>
                                <td>{{ h.note }}</td>
                                <td class="text-right">{{ h.price_per_unit | formatPrice }}</td>
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
</template>

<script>
    export default {
        name: "Index.vue",
        data() {
            return {
                formFilter: {
                    from_date: "",
                    to_date: "",
                    bill_number: "",
                    supplier: ""
                },
                formAdd: {
                    id: "",
                    name: "",
                    image: "",
                    unit: "",
                    stock: 0
                },
                materials: [],
                units: [],
                selectedMaterial: "",
                fileImage: ""
            }
        },
        created() {
            this.getData()
        },
        methods: {
            handleShowEdit(p) {

            },
            handleChangeImage(e) {
                this.fileImage = e.target.files[0]
            },

            handleShowHistory(p) {
                this.selectedMaterial = p
                $("#showHistory").modal("show")
            },

            async handleSubmitAddNew() {
                try {
                    const formData =  new FormData()
                    formData.append('id', this.formAdd.id)
                    formData.append('name', this.formAdd.name)
                    formData.append('unit', this.formAdd.unit)
                    formData.append('image', this.fileImage)
                    formData.append('unit', this.formAdd.unit)
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
                        position: 'top-end',
                        icon: 'error',
                        title: e.message,
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
            },

            async handleGetUnit() {
                try {
                    if (this.units.length === 0) {
                        this.$vs.loading()
                        this.units = await this.$axios.get(`api/product/unit`)
                        this.$vs.loading.close()
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
                        stock: 0
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