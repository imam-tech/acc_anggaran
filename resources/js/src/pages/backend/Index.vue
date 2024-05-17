<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 text-center">
                <h2>Welcome to FAT Admin Site</h2>
                <h4>Hai {{$store.state.admin_email}}</h4>
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
        }
    }
</script>

<style>
    .cardx {
        margin: 15px
    }
</style>