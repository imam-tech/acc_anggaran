<template>
    <div class="container-fluid">

        <div class="card shadow mb-4">
            <div class="card-title">
                <div class="mt-3 d-flex justify-content-between">
                    <h1 class="h3 ml-3 text-gray-800 float-left">Unit Of Measurement</h1>
                    <button @click="handleShowCrudModal()" type="button" class="btn btn-success float-right mr-3">
                        <i class="fa fa-plus-circle"></i> Create New Unit
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th><b>Unit Name</b></th>
                            <th>#</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-if="units.length == 0">
                            <td colspan="3" class="text-center">
                                Product Unit Not Found
                            </td>
                        </tr>
                        <tr v-else v-for="(p, pI) in units" :key="pI">
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
        <div class="modal fade" id="addProductCategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form @submit.prevent="handleSubmit()">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">{{ labelModal }} Category</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Unit<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                <input type="text" class="form-control" v-model="formData.title" required>
                            </div>
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
                units: [],
                labelModal: "Add",
                formData: {
                    'id': "",
                    'title': ""
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
                    this.units = await this.$axios.get(`api/product/unit`)
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
                    const resp = await this.$axios.post(`api/product/unit`, this.formData)
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
                        'id': "",
                        'title': ""
                    }
                } else {
                    this.formData = p
                }
                $("#addProductCategory").modal('show')
            },

            async handleDelete(id) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Are You Sure Want To Delete This Product Unit?',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    showCloseButton: true,
                    showCancelButton: true,
                }).then((result)=>{
                    if(result.isConfirmed == true){
                        this.$vs.loading()
                        this.$axios.delete(`api/product/unit/${id}/delete`).then((response)=>{
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
                                    text: "Failed To Delete Product Unit : " + response.message ,
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