<?php
    include 'navbar.php';
?>

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="../assets/dist/img/iNocAEP.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">iNocAEP</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="../assets/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <?php
                    if(!empty($_SESSION)){
                        if(!empty($_SESSION['user'])){
                ?>
                            <a href="#" class="d-block"><?php echo $_SESSION['user']['name']; ?></a>
                <?php
                        }
                    }
                ?>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <!-- <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div> -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                    with font-awesome or any other icon font library -->
                <li class="nav-item menu-open">
                    <a href="../dashboard/index.php" <?php if (basename($_SERVER['PHP_SELF']) == 'index.php') { ?> class="nav-link active" <?php } else { ?> class="nav-link" <?php } ?>>
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                            <!-- <i class="right fas fa-angle-left"></i> -->
                        </p>
                    </a>
                </li>
                
                <li <?php if (basename($_SERVER['PHP_SELF']) == 'flowAnalytics.php' || basename($_SERVER['PHP_SELF']) == 'sourceAnalytics.php') { ?> class="nav-item menu-is-opening menu-open" <?php } else { ?> class="nav-item" <?php } ?>>
                    <a href="#" <?php if (basename($_SERVER['PHP_SELF']) == 'flowAnalytics.php' || basename($_SERVER['PHP_SELF']) == 'sourceAnalytics.php') { ?> class="nav-link active" <?php } else { ?> class="nav-link" <?php } ?>>
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Analytics
                            <i class="fas fa-angle-left right"></i>
                            <!-- <span class="badge badge-info right">6</span> -->
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" <?php if (basename($_SERVER['PHP_SELF']) == 'flowAnalytics.php') { ?> class="nav-link active" <?php } else { ?> class="nav-link" <?php } ?>>
                                <i class="nav-icon fas fa-chart-pie"></i>
                                <p>Flow Analytics</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" <?php if (basename($_SERVER['PHP_SELF']) == 'sourceAnalytics.php') { ?> class="nav-link active" <?php } else { ?> class="nav-link" <?php } ?>>
                                <i class="far fa-circle nav-icon"></i>
                                <p>Source Analytics</p>
                            </a>
                        </li>
                    </ul>
                </li>
          
                <li <?php if (basename($_SERVER['PHP_SELF']) == 'dataIngestion.php') { ?> class="nav-item menu-is-opening menu-open" <?php } else { ?> class="nav-item" <?php } ?>>
                    <a href="#" <?php if (basename($_SERVER['PHP_SELF']) == 'dataIngestion.php') { ?> class="nav-link active" <?php } else { ?> class="nav-link" <?php } ?>>
                        <i class="nav-icon fas fa-file"></i>
                        <p>
                            Moniter
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" <?php if (basename($_SERVER['PHP_SELF']) == 'dataIngestion.php') { ?> class="nav-link active" <?php } else { ?> class="nav-link" <?php } ?>>
                                <i class="nav-icon fas fa-chart-bar"></i>
                                <p>Data Injestion</p>
                            </a>
                        </li>
                    </ul>
                </li>
          
                <li <?php if (basename($_SERVER['PHP_SELF']) == 'userSetting.php') { ?> class="nav-item menu-is-opening menu-open" <?php } else { ?> class="nav-item" <?php } ?>>
                    <a href="#" <?php if (basename($_SERVER['PHP_SELF']) == 'userSetting.php') { ?> class="nav-link active" <?php } else { ?> class="nav-link" <?php } ?>>
                        <i class="nav-icon fa fa-cog"></i>
                        <p>
                            Settings
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            
                            <a href="../settings/userSetting.php" <?php if (basename($_SERVER['PHP_SELF']) == 'userSetting.php') { ?> class="nav-link active" <?php } else { ?> class="nav-link" <?php } ?>>
                                <i class="nav-icon fas fa-book"></i>
                                <p>Adobe I/O Details</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../backend/RestAPI.php?type=logout" class="nav-link">
                                <i class="nav-icon fas fa-sign-out-alt"></i>
                                <p>Sign Out</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>