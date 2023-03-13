<?php
require_once "../../config/koneksi.php";
require_once "../../config/newID.php";
require_once "../../config/function.php";
$title = "Data Barang - Inventory";
require_once "../../template/header.php";
require_once "../../template/navbar.php";
require_once "../../template/sidebar.php";

$id = $_GET['id'];
$sql = $koneksi->query("SELECT * FROM barang_masuk as bm JOIN barang as b ON bm.barang_id=b.id 
                        JOIN supplier as sp ON bm.supplier_id=sp.id_supplier WHERE id='$id'");
$result = $sql->fetch_assoc();

$sql2 = $koneksi->query("SELECT * FROM barang as b JOIN satuan as s ON b.satuan_id=s.id_satuan  WHERE id='$id'");
$data = $sql2->fetch_assoc();
?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Data Barang Masuk</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item "><a href="<?= $main_url ?>index.php"> Home</a></li>
                <li class="breadcrumb-item "><a href="<?= $main_url ?>pages/data-barang.php">Data Barang Masuk</a></li>
                <li class="breadcrumb-item active">Detail Data Barang Masuk</li>
            </ol>
            <div class="card mb-4">
                <div class="card-header">
                    <a href="javascript:history.back(-1);" class="btn btn-primary btn-sm"><i class="fa-solid fa-circle-chevron-left"></i> Kembali</a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <table class="table ">
                                <tr>
                                    <th>Nama Barang</th>
                                    <td>:</td>
                                    <td><?= $result['nama_barang'] ?></td>
                                </tr>
                                <tr>
                                    <th>Supplier</th>
                                    <td>:</td>
                                    <td><?= $result['nama_supplier'] ?></td>
                                </tr>
                                <tr>
                                    <th>Stok</th>
                                    <td>:</td>
                                    <td><?= $result['stok'] ?> <?= $data['nama_satuan'] ?></td>
                                </tr>
                                <tr>
                                    <th>Jumlah Masuk</th>
                                    <td>:</td>
                                    <td><?= $result['jumlah'] ?> <?= $data['nama_satuan'] ?></td>
                                </tr>
                                <tr>
                                    <th>Tanggal Masuk</th>
                                    <td>:</td>
                                    <td><?= $result['tanggal_masuk'] ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col">
                            <img src="<?= $main_url ?>assets/img/<?= $result['foto_barang'] ?>" alt="<?= $result['nama_barang'] ?>" width="400" height="300">
                        </div>
                    </div>
                </div>
            </div>
            <?php
            require_once "../../template/footer.php";
            ?>