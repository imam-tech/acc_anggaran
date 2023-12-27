<template>
    <div class="container-fluid">

        <div class="card shadow mb-4">
            <div class="card-title">
                <div class="mt-3 d-flex justify-content-between">
                    <h1 class="h3 ml-3 text-gray-800 float-left">Contact</h1>
                    <router-link to="/app/contact/create/form">
                        <button type="button" class="btn btn-primary float-right mr-3">
                            <i class="fas fa-plus-circle"></i> Create New Contact
                        </button>
                    </router-link>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th class="text-center"><b>Type</b></th>
                            <th class="text-center"><b>Name</b></th>
                            <th class="text-center"><b>Email</b></th>
                            <th class="text-center"><b>Phone</b></th>
                            <th class="text-center"><b>Identity Number</b></th>
                            <th class="text-center"><b>NPWP Number</b></th>
                            <th class="text-center"><b>Address</b></th>
                            <th class="text-center"><b>Is Archived?</b></th>
                            <th class="text-center">#</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-if="contacts.length == 0">
                            <td colspan="7" class="text-center">
                                Contact Not Found
                            </td>
                        </tr>
                        <tr v-else v-for="(c, cI) in contacts" :key="cI">
                            <td>
                                <span v-if="c.sale_account_id" class="badge badge-warning">Customer</span>
                                <span v-if="c.purchase_account_id" class="badge badge-primary">Vendor</span>
                            </td>
                            <td>{{ c.name }}</td>
                            <td>{{ c.email }}</td>
                            <td>{{ c.phone }}</td>
                            <td>{{ c.identity_number }}</td>
                            <td>{{ c.npwp_number }}</td>
                            <td>{{ c.address }}</td>
                            <td class="text-center">
                                <span v-if="c.is_archive" class="badge badge-danger p-3">Yes</span>
                                <span v-else class="badge badge-primary p-3">No</span>
                            </td>
                            <td class="text-right">

                                <router-link :to="'contact/' + c.id + '/form'">
                                    <button class="btn btn-warning" type="button">
                                        <i class="fas fa-pencil-alt"></i>
                                    </button>
                                </router-link>
                                <button v-if="c.sales.length === 0 && c.purchases.length === 0" class="btn btn-danger" type="button">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <button v-else @click="handleArchive(c)" class="btn btn-secondary" type="button">
                                    <i class="fas fa-archive"></i>
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
                contacts: []
            }
        },
        created() {
            this.getData()
        },
        methods: {
            async getData() {
                try {
                    this.$vs.loading()
                    this.contacts = await this.$axios.get(`api/contact`)
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

            async handleArchive(p) {
                Swal.fire({
                    icon: 'warning',
                    title: `Are You Sure Want To ${p.is_archive ? 'Un Archive' : 'Archive'} This Contact?`,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    showCloseButton: true,
                    showCancelButton: true,
                }).then((result)=>{
                    if(result.isConfirmed == true){
                        this.$vs.loading()
                        this.$axios.get(`api/contact/${p.id}/archive`).then((response)=>{
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
                                    text: "Failed To Archive Contact : " + response.message ,
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