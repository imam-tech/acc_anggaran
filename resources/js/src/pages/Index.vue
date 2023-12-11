<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 text-center">
                <h2>Welcome to Finance, Accounting and Tax System</h2>
                <h4>Hai {{$store.state.email}}</h4>
                <h1>What activity do you want to do?</h1>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-xl-2"></div>
            <div class="col-lg-12 col-xl-8">
                <div class="row">
                    <div class="col-xl-4 mb-2"  v-for="(f, i) in features" :key="i">
                        <router-link :to="f.link">
                            <div class="card">
                                <div class="card-body shadow-lg">
                                    <span class="card-title">{{ f.label }}</span>
                                </div>
                            </div>
                        </router-link>
                    </div>
                </div>
            </div>
            <div class="col-xl-2"></div>
        </div>
    </div>
    <!-- /.container-fluid -->
</template>

<script>
    export default {
        name: "Index.vue",
        data() {
            return {
                companies: [],
                features: [{
                    link: '',
                    label: 'Create Sales Invoices',
                    image: ''
                },{
                    link: '',
                    label: 'Create Purchase Invoice',
                    image: ''
                },{
                    link: '',
                    label: 'Add New Product',
                    image: ''
                }]
            }
        },
        created() {
            console.log("role", this.$store.state)
        }
    }
</script>

<style>
    .cardx {
        margin: 15px
    }
</style>