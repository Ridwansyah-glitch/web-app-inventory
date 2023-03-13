<?php
require_once "config/koneksi.php";
require_once "config/newID.php";
require_once "config/function.php";
$title = "Dashboard - Aplikasi Inventory";
require_once "template/header.php";
require_once "template/navbar.php";
require_once "template/sidebar.php";



$sqlBrg = $koneksi->query("SELECT * FROM barang");
$resultBarang = mysqli_num_rows($sqlBrg);

$sqlBrgM = $koneksi->query("SELECT * FROM barang_masuk");
$resultBarangM = $sqlBrgM->num_rows;

$sqlBrgk = $koneksi->query("SELECT * FROM barang_keluar");
$resultBarangK = $sqlBrgk->num_rows;

$sqlSupplier = $koneksi->query("SELECT * FROM supplier");
$resultSupplier = $sqlSupplier->num_rows;

?>

<div id="layoutSidenav_content">
    <main>

        <div class="container-fluid px-4">
            <h1 class="mt-4">Dashboard</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Home</li>
            </ol>
            <div class="row">
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <div class="card-body">Data Barang</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <h3><?= $resultBarang ?> Data</h3>
                            <div class="small text-white"><i class="fa-solid fa-boxes-stacked fa-2xl"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-warning text-white mb-4">
                        <div class="card-body">Barang Masuk</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <h3><?= $resultBarangM ?> Data</h3>
                            <div class="small text-white"><i class="fa-solid fa-cart-flatbed fa-2xl"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-danger text-white mb-4">
                        <div class="card-body">Barang Keluar</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <h3><?= $resultBarangK ?> Data</h3>
                            <div class="small text-white"><i class="fa-solid fa-truck-fast fa-2xl"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-success text-white mb-4">
                        <div class="card-body">Data Supplier</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <h3><?= $resultSupplier ?> Data</h3>
                            <div class="small text-white"><i class="fa-solid fa-users fa-2xl"></i></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4">
                    <div class="card mb-4">
                        <div class="card-header text-center">
                            History
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush history">
                                <?php
                                $sql = $koneksi->query("SELECT * FROM history JOIN barang ON barang.id=history.barang_id");
                                while ($data = $sql->fetch_assoc()) {
                                    if ($data['role'] == 'BM') {
                                        echo " <li class='list-group-item'>" . $data['nama_barang'] .
                                            "<span class='badge text-bg-success'>" . $data['jumlah'] . "</span></li>";
                                    } else {
                                        echo '<li class="list-group-item">An Item <span class="badge text-bg-danger">-3</span></li>';
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-pie me-1"></i>
                            Pie Chart Example
                        </div>
                        <div class="card-body"><canvas id="myPieChart" width="100%" height="50"></canvas></div>
                        <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php
    require_once "template/footer.php";
    ?>