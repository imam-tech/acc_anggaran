<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 text-center">
                Welcome to accounting and finance system
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</template>

<script>
    export default {
        name: "Index.vue",
        data() {
            return {
                companies: []
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