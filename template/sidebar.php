<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <a class="nav-link" href="<?= $main_url ?>index.php">
                        <div class="sb-nav-link-icon "><i class="fas fa-tachometer-alt"></i></div>
                        Dashboard
                    </a>
                    <hr class="mb-0">
                    <a class="nav-link" id="barang" href="<?= $main_url ?>pages/data-barang.php">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-boxes-stacked"></i></div>
                        Data Barang
                    </a>
                    <a class="nav-link" href="<?= $main_url ?>pages/data-satuan.php">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-box-open"></i></div>
                        Data Satuan
                    </a>
                    <a class="nav-link" href="<?= $main_url ?>pages/data-supplier.php">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-users"></i></div>
                        Data Supplier
                    </a>
                    <hr class="mb-0">
                    <div class="sb-sidenav-menu-heading">Data</div>
                    <a class="nav-link" href="<?= $main_url ?>pages/data-barang-masuk.php">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-cart-flatbed"></i></div>
                        Data Barang Masuk
                    </a>
                    <a class="nav-link" href="<?= $main_url ?>pages/data-barang-keluar.php">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-truck-fast"></i></div>
                        Data Barang Keluar
                    </a>
                    <hr class="mb-0">
                    <a class="nav-link" href="<?= $main_url ?>pages/report.php">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-chart-pie"></i></div>
                        Laporan
                    </a>
                </div>
            </div>
            <div class="sb-sidenav-footer">
                <div class="small">Logged in as:</div>
                <?= $_SESSION['login']['nama']; ?>
            </div>
        </nav>
    </div>