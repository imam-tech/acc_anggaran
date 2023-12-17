<template>
    <div class="container-fluid">

        <div class="card shadow mb-4">
            <div class="card-title">
                <h1 class="h3 mt-3 ml-3 text-gray-800 float-left">Coa Category List</h1>
                <router-link to="/app/coa" class="btn btn-success float-right mt-3 mr-3">
                    <i class="fa fa-arrow-left"></i> Back
                </router-link>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div class="row mt-5" v-for="(category, index) in coaCategories" :key="index">
                        <div class="col-12">
                            <router-link :to="'/app/coa/category/' + category.id + '/detail'">{{ category.code }} - {{ category.name }}</router-link>
                        </div>
                        <div class="col-12 ml-5 d-flex flex-column" v-for="(childFirst, indexFirst) in category.childrens" :key="indexFirst">
                            <span>
                                <router-link :to="'/app/coa/category/' + category.id + '/detail'">{{ childFirst.code }} - {{ childFirst.name }}</router-link>
                            </span>
                            <div class="row ml-5" v-for="(childSecond, indexSecond) in childFirst.childrens" :key="indexSecond">
                                <div class="col-12">
                                    <router-link :to="'/app/coa/category/' + category.id + '/detail'">{{ childSecond.code }} - {{ childSecond.name }}</router-link>
                                </div>
                                <div class="col-12 ml-5 d-flex flex-column" v-for="(childThird, indexThird) in childSecond.childrens" :key="indexThird">
                                    <router-link :to="'/app/coa/category/' + category.id + '/detail'"><span>{{ childThird.code }} - {{ childThird.name }}</span></router-link>
                                </div>
                            </div>
                        </div>
                    </div>
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
                coaCategories: [],
            }
        },
        created() {
            this.getData()
        },
        methods: {
            async getData() {
                try {
                    this.$vs.loading()
                    this.coaCategories = await this.$axios.get('api/coa/category-list?flag=pt')
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
        }
    }
</script>