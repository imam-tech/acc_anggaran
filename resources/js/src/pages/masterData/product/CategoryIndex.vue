<template>
    <div class="container-fluid">

        <div class="card shadow mb-4">
            <div class="card-title">
                <div class="mt-3 d-flex justify-content-between">
                    <h1 class="h3 ml-3 text-gray-800 float-left">Category</h1>
                    <button @click="handleShowCrudModal()" type="button" class="btn btn-primary float-right mr-3">
                        <i class="fas fa-plus-circle"></i> Create New Category
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th class="text-dark"><b>Name</b></th>
                            <th class="text-dark"><b>Image</b></th>
                            <th class="text-center"><b>Is Archived?</b></th>
                            <th class="text-dark">#</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-if="categories.length == 0">
                            <td colspan="3" class="text-center">
                                Category Not Found
                            </td>
                        </tr>
                        <tr v-else v-for="(p, pI) in categories" :key="pI">
                            <td>{{ p.name }}</td>
                            <td>
                                <img v-if="p.image" :src="p.image" width="100" alt="" class="rounded">
                            </td>
                            <td class="text-center">
                                <span v-if="p.is_archive" class="badge badge-danger p-3">Yes</span>
                                <span v-else class="badge badge-primary p-3">No</span>
                            </td>
                            <td class="text-right">
                                <button @click="handleShowCrudModal(p)" class="btn btn-warning" type="button">
                                    <i class="fas fa-pencil-alt"></i>
                                </button>
                                <button v-if="p.product === null" @click="handleDelete(p.id)" class="btn btn-danger" type="button">
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
        <CategoryCrud :get-data="handleGetData" :form-data="formData" :label-modal="labelModal"></CategoryCrud>
    </div>
</template>

<script>
    import CategoryCrud from './components/CategoryCrud'

    export default {
        name: "CategoryIndex.vue",
        components: {CategoryCrud},
        data() {
            return {
                categories: [],
                labelModal: "Add",
                formData: {
                    'id': '',
                    'name': "",
                    'image': ""
                },
            }
        },
        created() {
            this.handleGetData()
        },
        methods: {
            async handleGetData() {
                try {
                    this.$vs.loading()
                    this.categories = await this.$axios.get(`api/master-data/product/category`)
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
            // async handleSubmit() {
            //     const unitCrudRef = this.$refs.unitCrud
            //     unitCrudRef.handleSubmit()
            // },
            handleShowCrudModal(p = null) {
                if (p === null) {
                    this.formData = {
                        'id': '',
                        'name': "",
                        'image': ""
                    }
                    this.labelModal = 'Add'
                } else {
                    this.formData = p
                    this.labelModal = 'Update'
                }
                console.log("thios", this.formData)
                $("#addProductCategory").modal('show')
            },

            async handleDelete(id) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Are You Sure Want To Delete This Category?',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    showCloseButton: true,
                    showCancelButton: true,
                }).then((result)=>{
                    if(result.isConfirmed == true){
                        this.$vs.loading()
                        this.$axios.delete(`api/master-data/product/category/${id}/delete`).then((response)=>{
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
                                    if(res.isConfirmed == true) await this.handleGetData()
                                })
                            }else{
                                Swal.fire({
                                    icon: "error",
                                    title: "Opps...",
                                    text: "Failed To Delete Category : " + response.message ,
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
                    title: `Are You Sure Want To ${p.is_archive ? 'Un Archive' : 'Archive'} This Category?`,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    showCloseButton: true,
                    showCancelButton: true,
                }).then((result)=>{
                    if(result.isConfirmed == true){
                        this.$vs.loading()
                        this.$axios.get(`api/master-data/product/category/${p.id}/archive`).then((response)=>{
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
                                    if(res.isConfirmed == true) await this.handleGetData()
                                })
                            }else{
                                Swal.fire({
                                    icon: "error",
                                    title: "Opps...",
                                    text: "Failed To Archive Category : " + response.message ,
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