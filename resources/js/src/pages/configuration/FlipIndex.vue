<template>
    <div class="container-fluid">

        <div class="card shadow mb-4">
            <div class="card-title">
                <h1 class="h3 mt-3 ml-3 text-gray-800 float-left">Flip List</h1>
                <button v-if="$store.state.permissions.includes('transaction_push_plugin')" type="button" class="btn btn-primary float-right mr-3 mt-3" @click="showAddSetting()">
                    <i class="fas fa-plus-circle"></i> Setting
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th class="text-center">Flip Name</th>
                            <th class="text-center">Flip Key</th>
                            <th class="text-center">Is Active</th>
                            <th class="text-center">Created At</th>
                            <th v-if="$store.state.permissions.includes('transaction_push_plugin')" class="text-center">#</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(flip, index) in flips" :key="index">
                            <td>{{ flip.flip_name }}</td>
                            <td>***********</td>
                            <td>{{ flip.is_active ? 'Active' : 'In Active' }}</td>
                            <td>{{ flip.created_at | formatDate }}</td>
                            <td v-if="$store.state.permissions.includes('transaction_push_plugin')" class="text-right">
                                <button type="button" class="btn btn-warning" @click="showEditSetting(flip)">
                                    <i class="fas fa-pencil-alt"></i>
                                </button>
                                <button class="btn btn-danger" type="button" @click="handleDelete(flip.id)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <!--<div class="justify-content-center d-flex">-->
                        <!--<pagination v-model="page" :records="totalData" :per-page="perPage" @paginate="getData"/>-->
                    <!--</div>-->
                </div>
            </div>
        </div>
        <div class="modal fade" id="addSetting" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ labelModal }} Setting</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="submitSetting">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Title<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                <input type="text" class="form-control" v-model="formData.flip_name" placeholder="Ex: imamflip30" required>
                            </div>
                            <div class="form-group">
                                <label>Flip Key<span v-if="formData.id === ''" style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                <input type="password" class="form-control" v-model="formData.flip_key" placeholder="Your secret key, please paste it" :required="formData.id == ''">
                            </div>
                            <div class="form-group">
                                <label>Is Active<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                <select class="form-control" v-model="formData.is_active" required>
                                    <option value="1">Active</option>
                                    <option value="0">In Active</option>
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
    </div>
</template>

<script>
    export default {
        name: "Index.vue",
        data() {
            return {
                flips: [],
                labelModal: "Add",
                formData: {
                    id: "",
                    flip_name: "",
                    flip_key: "",
                    is_active: 1
                },
            }
        },
        created() {
            if (!this.$store.state.permissions.includes('transaction_push_plugin')) {
                Swal.fire({
                    position: 'top',
                    icon: 'error',
                    title: 'You don\'t have an access this page',
                    showConfirmButton: false,
                    timer: 3000
                }).then(async ()=>{
                    this.$router.push('/app/')
                })
                return
            }
            this.getData()
        },
        methods: {
            async getData() {
                try {
                    this.$vs.loading()
                    this.flips = await this.$axios.get('api/configuration/flip')
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
            showEditSetting(tax) {
                this.labelModal = 'Edit'
                this.formData.id = tax.id
                this.formData.flip_name = tax.flip_name
                this.formData.flip_key = ""
                this.formData.is_active = tax.is_active
                $("#addSetting").modal("show")
            },
            showAddSetting() {
                this.labelModal = 'Add'
                this.formData.id = ""
                this.formData.flip_name = ""
                this.formData.flip_key = ''
                this.formData.is_active = 1
                $("#addSetting").modal("show")
            },
            async submitSetting() {
                try {
                    this.$vs.loading()
                    const respSave = await this.$axios.post('api/configuration/flip', this.formData)
                    this.$vs.loading.close()
                    if (!respSave.status) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: respSave.message,
                            showConfirmButton: false,
                            timer: 1500
                        })
                    } else {
                        $("#addSetting").modal("hide")
                        Swal.fire({
                            position: 'top',
                            icon: 'success',
                            title: respSave.message,
                            showConfirmButton: false,
                            timer: 1500
                        }).then(async ()=>{
                            await this.getData()
                        })
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
            async handleDelete(id) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Are You Sure Want To Delete This Setting?',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    showCloseButton: true,
                    showCancelButton: true,
                }).then((result)=>{
                    if(result.isConfirmed == true){
                        this.$vs.loading()
                        this.$axios.delete(`api/setting/flip/${id}/delete`).then((response)=>{
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
                                    text: "Failed To Delete Setting : " + response.message ,
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