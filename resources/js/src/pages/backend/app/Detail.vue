<template>
    <div v-if="companyData" class="container-fluid">
        <div class="card">
            <div class="card-title">
                <h1 class="h3 mt-3 ml-3 text-gray-800 float-left">Company Detail</h1>
                <router-link to="/backend/app" class="btn btn-success float-right mt-3 mr-3">
                    <i class="fas fa-arrow-left"></i> Back
                </router-link>

            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th colspan="2" class="text-center">Details</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th>Is Whitelist</th>
                                <td class="text-right">{{companyData.is_whitelist ? 'Yes' : 'No'}}</td>
                            </tr>
                            <tr>
                                <th>Is Multiple Company</th>
                                <td class="text-right">
                                    {{companyData.is_multiple_company ? 'Yes' : 'No'}}
                                    {{ companyData.is_multiple_company ? '(' + maxCompany + ' companies)' : "" }}
                                    <button v-if="companyData.is_multiple_company" @click="handleShowMaxCompany()" type="button" class="btn btn-secondary">
                                        <i class="fas fa-pencil-alt"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <th>Domain</th>
                                <td class="text-right">{{companyData.domain}}</td>
                            </tr>
                            <tr>
                                <th>Setting View</th>
                                <td class="text-right">
                                    {{ handleShowSettingView() }}
                                    <button @click="handleShowSetting()" type="button" class="btn btn-primary">
                                        <i class="fas fa-gear"></i>
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-lg-6">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">Name</th>
                                    <th class="text-center">Email</th>
                                </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(companyAdmin, index) in companyData.users" :key="index">
                                <td>{{ companyAdmin.name }}</td>
                                <td>{{ companyAdmin.email }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="maxCompanyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form @submit.prevent="handleSubmitMaxCompany()">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Form</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Max Company</label>
                                <input type="number" class="form-control" v-model="maxCompany">
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
        <div class="modal fade" id="settingView" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form @submit.prevent="handleSubmit()">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Form Setting</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div v-for="(sd, sdI) in settingData" class="form-check" :key="sdI">
                                <input class="form-check-input" type="checkbox" :value="sd" v-model="sd.is_show"
                                       @click="settingData[sdI].is_show = settingData[sdI].is_show === 1 ? 0 : 1">
                                <label class="form-check-label">
                                    {{ sd.label }}
                                </label>
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
        name:'Detail',
        data() {
            return {
                companyData: "",
                settingData: [
                    {"label": "transaction", "is_show": 0},
                    {"label": "output-data", "is_show": 0},
                    {"label": "input-data-cash-and-bank-index", "is_show": 0},
                    {"label": "input-data-sales-index", "is_show": 0},
                    {"label": "input-data-purchase-index", "is_show": 0},
                    {"label": "input-data-journal-index", "is_show": 0},
                    {"label": "manufacture", "is_show": 0}
                ],
                maxCompany: 0
            }
        },

        mounted() {
            this.getData()
        },
        methods: {
            async handleSubmitMaxCompany() {
                try {
                    this.$vs.loading()
                    const respDe = await this.$axios.post(`api/configuration/set-general`, {
                        id: this.$route.params.id,
                        label: "max_company",
                        label_value: this.maxCompany
                    })
                    this.$vs.loading.close()

                    $("#maxCompanyModal").modal('hide')
                    if (!respDe.status) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: respDe.message,
                            showConfirmButton: false,
                            timer: 1500
                        })
                    } else {
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

            handleShowMaxCompany() {
                $("#maxCompanyModal").modal('show')
            },

            handleShowSettingView() {
                const labelLocal = []
                this.companyData.setting_views.forEach((x) => {
                    if (x.is_show) {
                        labelLocal.push(x.label)
                    }
                })
                return labelLocal.join(", ")
            },

            async getData() {
                try {
                    this.$vs.loading()
                    const respDe = await this.$axios.get(`api/backend/app/${this.$route.params.id}/detail`)
                    this.$vs.loading.close()

                    $("#settingView").modal('hide')
                    if (!respDe.status) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: respDe.message,
                            showConfirmButton: false,
                            timer: 1500
                        })
                    } else {
                        this.companyData = respDe.data
                        if (this.companyData.setting_views.length > 0) {
                            const settingDataViews = []
                            this.companyData.setting_views.forEach((x) => {
                                settingDataViews.push({
                                    "label": x.label,
                                    "is_show": x.is_show
                                })
                            })
                            this.settingData = settingDataViews
                        }
                        if (this.companyData.max_company) {
                            this.maxCompany = this.companyData.max_company.label_value
                        }
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

            handleShowSetting() {
                $("#settingView").modal('show')
            },

            async handleSubmit() {
                try {
                    this.$vs.loading()
                    const respDe = await this.$axios.post(`api/configuration/view`, {
                        id: this.$route.params.id,
                        setting_view: this.settingData
                    })
                    this.$vs.loading.close()

                    if (!respDe.status) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: respDe.message,
                            showConfirmButton: false,
                            timer: 1500
                        })
                    } else {
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
            }
        }
    }
</script>
