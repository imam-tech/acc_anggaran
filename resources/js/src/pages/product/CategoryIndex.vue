<template>
    <div class="container-fluid">

        <div class="card shadow mb-4">
            <div class="card-title">
                <div class="mt-3 d-flex justify-content-between">
                    <h1 class="h3 ml-3 text-gray-800 float-left">Category</h1>
                    <button @click="handleShowCrudModal()" type="button" class="btn btn-primary float-right mr-3">
                        <i class="fa fa-plus-circle"></i> Create New Category
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
                            <td class="text-right">
                                <button @click="handleShowCrudModal(p)" class="btn btn-warning" type="button">
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
        <div class="modal fade" id="addProductCategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form @submit.prevent="handleSubmit">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">{{ labelModal }} Category</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Name<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                <input type="text" class="form-control" v-model="formData.name" required>
                            </div>
                            <div class="form-group">
                                <label>Image</label>
                                <input type="file" class="form-control" @change="handleChangeImage">
                            </div>
                            <img :src="formData.image" width="100" alt="" class="rounded">
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
        name: "CategoryIndex.vue",
        data() {
            return {
                categories: [],
                labelModal: "Add",
                formData: {
                    'id': '',
                    'name': "",
                    'image': "'"
                },
                fileImage: ""
            }
        },
        created() {
            this.handleGetData()
        },
        methods: {
            handleChangeImage(e) {
                this.fileImage = e.target.files[0]
            },
            async handleGetData() {
                try {
                    this.$vs.loading()
                    this.categories = await this.$axios.get(`api/product/category`)
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
            async handleSubmit() {
                try {
                    const formData = new FormData()
                    formData.append('id', this.formData.id)
                    formData.append('name', this.formData.name)
                    formData.append('image', this.fileImage)

                    this.$vs.loading()
                    const resp = await this.$axios.post(`api/product/category`,
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
                        $("#addProductCategory").modal('hide')
                        this.handleGetData()
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
                        this.$axios.delete(`api/product/category/${id}/delete`).then((response)=>{
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
            }
        }
    }
</script>