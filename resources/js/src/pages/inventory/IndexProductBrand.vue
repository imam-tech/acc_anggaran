<template>
    <div class="container-fluid">

        <div class="card shadow mb-4">
            <div class="card-title">
                <div class="mt-3 d-flex justify-content-between">
                    <h1 class="h3 ml-3 text-gray-800 float-left">Product Brand</h1>
                    <button @click="handleShowCrudModal()" type="button" class="btn btn-success float-right mr-3">
                        <i class="fa fa-plus-circle"></i> Create New Product Brand
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th><b>Image</b></th>
                            <th><b>Brand Name</b></th>
                            <th>#</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-if="productBrands.length == 0">
                            <td colspan="3" class="text-center">
                                Product Brand Not Found
                            </td>
                        </tr>
                        <tr v-else v-for="(p, pI) in productBrands" :key="pI">
                            <td>
                                <img :src="p.image" width="100" alt="" class="rounded">
                            </td>
                            <td>{{ p.title }}</td>
                            <td>
                                <button @click="handleShowCrudModal(p)" class="btn btn-success" type="button">
                                    <i class="fas fa-pencil-alt"></i>
                                </button>
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
        <div class="modal fade" id="addProductBrand" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form @submit.prevent="handleSubmit">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">{{ labelModal }} Brand</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Brand Name<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                <input type="text" class="form-control" v-model="formData.title" required>
                            </div>
                            <div class="form-group">
                                <label>Image<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                <input type="file" class="form-control" @change="handleUploadImage">
                            </div>
                            <img :src="formData.image" width="100" alt="" class="rounded">
                        </div>
                        <div class="modal-footer flex justify-content-between">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
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
                productBrands: [],
                labelModal: "Add",
                formData: {
                    'id': '',
                    'title': "",
                    'image': "'"
                }
            }
        },
        created() {
            this.getData()
        },
        methods: {
            handleUploadImage(e) {
                this.file = e.target.files[0]
                var form_data = new FormData()

                form_data.append('files', this.file)
                form_data.append('folder', 'product-unit')
                this.$vs.loading()
                this.$axios.post('/api/transaction/upload-image',
                    form_data,
                    {
                        headers: {
                            "Content-Type": "multipart/form-data"
                        }
                    }
                ).then((res) => {
                    this.$vs.loading.close()
                    if (res.status == false) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: res.message,
                            showConfirmButton: false,
                            timer: 1500
                        })
                    } else {
                        this.formData.image = res.data
                        console.log(res.data)
                    }

                }).catch((e) => {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: e.message,
                        showConfirmButton: false,
                        timer: 1500
                    })
                })
            },
            async getData() {
                try {
                    this.$vs.loading()
                    this.productBrands = await this.$axios.get(`api/product/brand`)
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
            async handleSubmit() {
                try {
                    this.$vs.loading()
                    const resp = await this.$axios.post(`api/product/brand`, this.formData)
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
                        $("#addProductBrand").modal('hide')
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
            handleShowCrudModal(p = null) {
                if (p === null) {
                    this.formData = {
                        'id': '',
                        'title': "",
                        'image': "'"
                    }
                    this.labelModal = 'Add'
                } else {
                    this.formData = p
                    this.labelModal = 'Update'
                }
                $("#addProductBrand").modal('show')
            },

            async handleDelete(id) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Are You Sure Want To Delete This Product Brand?',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    showCloseButton: true,
                    showCancelButton: true,
                }).then((result)=>{
                    if(result.isConfirmed == true){
                        this.$vs.loading()
                        this.$axios.delete(`api/product/brand/${id}/delete`).then((response)=>{
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
                                    text: "Failed To Delete Product Brand : " + response.message ,
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