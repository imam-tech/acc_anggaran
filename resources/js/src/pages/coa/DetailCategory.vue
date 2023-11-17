<template>
    <div class="container-fluid">
        <div class="card">
            <div class="card-title">
                <h1 class="h3 mt-3 ml-3 text-gray-800 float-left">Coa Category Detail</h1>
                <router-link to="/app/coa/category/" class="btn btn-success float-right mt-3 mr-3">
                    <i class="fa fa-arrow-left"></i> Back
                </router-link>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th colspan="2" class="text-center">Details</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th>Name</th>
                                <td>{{coaCategory.name}}</td>
                            </tr>
                            <tr>
                                <th>Code</th>
                                <td>{{coaCategory.code}}</td>
                            </tr>
                            <tr>
                                <th>Label</th>
                                <td>{{coaCategory.label}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <h3 class="h3 text-gray-800 float-left">Chart of Account List</h3>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>Account Code</th>
                            <th>Account Name</th>
                            <th>Description</th>
                            <th>Type</th>
                            <th>Posting Lable</th>
                            <th>Balance (IDR)</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr v-show="coas.length == 0">
                                <td colspan="7" class="text-center">
                                    Empty Chart of Account
                                </td>
                            </tr>
                            <tr v-for="(coa, key) in coas" :key="key">
                                <td>{{ coa.account_number }}</td>
                                <td>{{ coa.account_name }}</td>
                                <td>{{ coa.description }}</td>
                                <td>{{ coa.account_type }}</td>
                                <td>{{ coa.posting_label }}</td>
                                <td>{{ coa.balance | formatPriceWithDecimal }}</td>
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
        name:'Detail',
        data() {
            return {
                coaCategory: {},
                coas: []
            }
        },

        mounted() {
            this.getData()
            this.getCoaByCategoryId()
        },
        methods: {
            async getCoaByCategoryId() {
                try {
                    this.$vs.loading()
                    const respD = await this.$axios.get(`api/coa/${this.$route.params.id}/detail-all`)
                    this.$vs.loading.close()
                    if (!respD.status) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: respD.message,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        return
                    }
                    this.coas = respD.data
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
            async getData() {
                try {
                    this.$vs.loading()
                    const respDe = await this.$axios.get(`api/coa/category/${this.$route.params.id}/detail`)
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
                        this.coaCategory = respDe.data
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
