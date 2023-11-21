<template>
    <ul class="navbar-nav bg-gradient-success sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-laugh-wink"></i>
            </div>
            <div class="sidebar-brand-text mx-3">Acc Anggaran</div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item">
            <router-link class="nav-link" to="/app">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </router-link>
        </li>
        <li class="nav-item">
            <router-link class="nav-link" to="/app/transaction">
                <i class="fas fa-exchange-alt"></i>
                <span>Transaction</span>
            </router-link>
        </li>
        <li class="nav-item">
            <router-link class="nav-link" to="/app/company">
                <i class="fas fa-building"></i>
                <span>Company</span>
            </router-link>
        </li>
        <li v-if="$store.state.permissions.includes('transaction_push_plugin')" class="nav-item">
            <router-link class="nav-link" to="/app/setting">
                <i class="fas fa-gear"></i>
                <span>Setting</span>
            </router-link>
        </li>
        <li class="nav-item">
            <router-link class="nav-link" to="/app/project">
                <i class="fas fa-project-diagram"></i>
                <span>Project</span>
            </router-link>
        </li>
        <li class="nav-item">
            <router-link class="nav-link" to="/app/user">
                <i class="fas fa-user"></i>
                <span>User</span>
            </router-link>
        </li>
        <li class="nav-item">
            <router-link class="nav-link" to="/app/tax">
                <i class="fas fa-money"></i>
                <span>Tax</span>
            </router-link>
        </li>
        <li class="nav-item">
            <router-link class="nav-link" to="/app/coa">
                <i class="fas fa-chart-area"></i>
                <span>Coa</span>
            </router-link>
        </li>
        <li class="nav-item">
            <router-link class="nav-link" to="/app/journal">
                <i class="fas fa-journal-whills"></i>
                <span>Journal</span>
            </router-link>
        </li>
        <li class="nav-item">
            <router-link class="nav-link" to="/app/report">
                <i class="fas fa-newspaper"></i>
                <span>Report</span>
            </router-link>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

    </ul>
</template>