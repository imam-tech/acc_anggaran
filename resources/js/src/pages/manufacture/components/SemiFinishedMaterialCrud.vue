<template>
    <div class="modal fade" id="addNewMaterial" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form @submit.prevent="handleSubmit">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ formData === '' ? 'Add New' : "Update" }} a Semi Finished Good</h5>
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
                            <label>Material<span  v-if="formData.items.length === 0 ? !selectedMaterial : false" style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                            <v-select v-model="selectedMaterial" :options="materials" :reduce="p => p" style="width: 100%" label="name" @input="handleChangeMaterial">
                                <template #search="{attributes, events}">
                                    <input
                                            class="vs__search"
                                            :required="formData.items.length === 0 ? !selectedMaterial : false"
                                            v-bind="attributes"
                                            v-on="events"
                                    />
                                </template>
                                <span slot="no-options">Material Not Found</span>
                            </v-select>
                        </div>
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Dose</th>
                                <th>Unit</th>
                                <th>#</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(m, mI) in formData.items" :key="mI">
                                <td>{{ m.name }}</td>
                                <td class="d-flex flex-row justify-content-between align-items-center">
                                    <input type="number" class="form-control" v-model="formData.items[mI].dose" :max="m.stock" step="0.1" required>
                                </td>
                                <td>{{ m.unit }}</td>
                                <td class="text-right">
                                    <button class="btn btn-danger" @click="handleDeleteProduct(mI)" type="button">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
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
</template>

<script>
    export default {
        name: 'UnitCrud',
        props: [
            "formData",'labelModal', 'getData', 'materials'
        ],
        methods: {
            async handleSubmit() {
                try {
                    this.$vs.loading()
                    const resp = await this.$axios.post(`api/manufacture/semi-finished-material`, this.formData)
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

            handleChangeMaterial() {
                let isInsert = false;
                this.formData.items.forEach((x) => {
                    if (x.id === this.selectedMaterial.id) {
                        isInsert = true
                    }
                })

                if (!isInsert) {
                    this.formData.items.push(this.selectedMaterial)
                }
            },

            handleDeleteProduct(index) {
                this.formData.items = this.formData.items.filter((item, ind) => ind !== index)
                if (this.formData.items.length === 0) {
                    this.selectedMaterial = '';
                }
            },
        }
    }
</script>