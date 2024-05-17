<template>
    <div id="wrapper">
        <Navbar />
        <div id="content-wrapper" class="d-flex flex-column">

            <nav class="navbar navbar-expand navbar-light bg-white topbar static-top shadow ">

                <!-- Sidebar Toggle (Topbar) -->
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle">
                    <i class="fas fa-bars"></i>
                </button>


                <!-- Topbar Navbar -->
                <ul class="navbar-nav ml-auto">

                    <!-- Nav Item - User Information -->
                    <li class="nav-item dropdown no-arrow m-3">
                        <LogoutBar/>
                    </li>

                </ul>

            </nav>
            <!-- Main Content -->
            <div class="mb-lg-5 pb-5">

                <!-- Topbar -->
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="p-5 mb-5 min-vh-100">
                    <router-view/>
                </div>
                <!-- /.container-fluid -->
            </div>
            <div class="mt-5"></div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="bg-white">
                <div class="row">
                    <div class="col-10">
                        <div class="container my-auto">
                            <div class="copyright p-2 font-weight-bold">
                                <span class=" text-muted sm:h5 h8">Copyright &copy; (Backend) Finance Accounting and Tax System {{ new Date().getFullYear() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">

                    <div class="col-2" style="
                        text-align: right;
                        padding-right: 34px;
                    ">
                        <div class="product-buttons  fixed-bottom" style="
                            margin-right: 20px;
                            margin-bottom: 20px;
                        ">
                            <!--<a :href="`https://api.whatsapp.com/send?phone=${$store.state.auth.phone}&text=Halo kak saya tertarik ingin belajar di akademi`">-->
                            <!--<i class="fa fa-whatsapp" style="font-size:70px;color:green"></i>-->
                            <!--</a>-->
                        </div>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->
        </div>
    </div>
</template>
<script>
    import Navbar from '../components/backends/Navbar.vue'
    import LogoutBar from '../components/backends/LogoutBar.vue'

    export default {
        name: "ParentLayout",
        components: {
            Navbar, LogoutBar
        }
    }
</script>