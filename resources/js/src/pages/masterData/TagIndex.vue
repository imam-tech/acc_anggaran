<template>
    <div class="container-fluid">

        <div class="card shadow mb-4">
            <div class="card-title">
                <div class="mt-3 d-flex justify-content-between">
                    <h1 class="h3 ml-3 text-gray-800 float-left">Tag</h1>
                    <button @click="handleShowCrudModal()" type="button" class="btn btn-primary float-right mr-3">
                        <i class="fas fa-plus-circle"></i> Create New Tag
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th class="text-center"><b>Name</b></th>
                            <th class="text-center"><b>Sales</b></th>
                            <th class="text-center"><b>Purchase</b></th>
                            <th class="text-center"><b>Is Archived?</b></th>
                            <th class="text-center"><b>#</b></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-if="tags.length == 0">
                            <td colspan="3" class="text-center">
                                Tag Not Found
                            </td>
                        </tr>
                        <tr v-else v-for="(p, pI) in tags" :key="pI">
                            <td>{{ p.name }}</td>
                            <td class="text-center">{{ p.sales_count }}</td>
                            <td class="text-center">{{ p.purchases_count }}</td>
                            <td class="text-center">
                                <span v-if="p.is_archive" class="badge badge-danger p-3">Yes</span>
                                <span v-else class="badge badge-primary p-3">No</span>
                            </td>
                            <td class="text-right">
                                <button @click="handleShowCrudModal(p)" class="btn btn-warning" type="button">
                                    <i class="fas fa-pencil-alt"></i>
                                </button>
                                <button v-if="p.sales_count === 0 && p.purchases_count === 0" @click="handleDelete(p.id)" class="btn btn-danger" type="button">
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
            <TagCrud ref="unitCrud" :get-data="handleGetData" :form-data="formData" :label-modal="labelModal"></TagCrud>
        </div>
    </div>
</template>

<script>
    import TagCrud from './product/components/TagCrud'

    export default {
        name: "TagIndex.vue",
        components: {TagCrud},
        data() {
            return {
                tags: [],
                labelModal: "Add",
                formData: {
                    'id': "",
                    'name': ""
                }
            }
        },
        created() {
            this.handleGetData()
        },
        methods: {
            async handleGetData() {
                try {
                    this.$vs.loading()
                    this.tags = await this.$axios.get(`api/master-data/tag`)
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

            handleShowCrudModal(p = null) {
                if (p === null) {
                    this.labelModal = 'Add'
                    this.formData = {
                        'id': "",
                        'name': ""
                    }
                } else {
                    this.labelModal = 'Edit'
                    this.formData = p
                }
                $("#addProductTag").modal('show')
            },

            async handleDelete(id) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Are You Sure Want To Delete This Tag?',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    showCloseButton: true,
                    showCancelButton: true,
                }).then((result)=>{
                    if(result.isConfirmed == true){
                        this.$vs.loading()
                        this.$axios.delete(`api/master-data/tag/${id}/delete`).then((response)=>{
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
                                    text: "Failed To Delete Tag : " + response.message ,
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
                    title: `Are You Sure Want To ${p.is_archive ? 'Un Archive' : 'Archive'} This Tag?`,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    showCloseButton: true,
                    showCancelButton: true,
                }).then((result)=>{
                    if(result.isConfirmed == true){
                        this.$vs.loading()
                        this.$axios.get(`api/master-data/tag/${p.id}/archive`).then((response)=>{
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
                                    text: "Failed To Archive Tag : " + response.message ,
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