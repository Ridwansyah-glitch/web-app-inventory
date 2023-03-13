<?php
require_once "../../config/koneksi.php";
require_once "../../config/newID.php";
require_once "../../config/function.php";
$title = "Data Barang - Inventory";
require_once "../../template/header.php";
require_once "../../template/navbar.php";
require_once "../../template/sidebar.php";

$id = $_GET['id'];
$sql = $koneksi->query("SELECT * FROM barang JOIN satuan ON satuan.id_satuan=barang.satuan_id WHERE id='$id'");
$result = $sql->fetch_assoc();
?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Data Barang</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item "><a href="<?= $main_url ?>index.php"> Home</a></li>
                <li class="breadcrumb-item "><a href="<?= $main_url ?>pages/data-barang.php">Data Barang</a></li>
                <li class="breadcrumb-item active">Detail Data Barang</li>
            </ol>
            <div class="card mb-4">
                <div class="card-header">
                    <a href="javascript:history.back(-1);" class="btn btn-primary btn-sm"><i class="fa-solid fa-circle-chevron-left"></i> Kembali</a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <img src="<?= $main_url ?>assets/img/<?= $result['foto_barang'] ?>" alt="<?= $result['nama_barang'] ?>" width="400" height="300">
                        </div>
                        <div class="col">
                            <table class="table ">
                                <tr>
                                    <th>ID</th>
                                    <td>:</td>
                                    <td><?= $result['id_barang'] ?></td>
                                </tr>
                                <tr>
                                    <th>Nama Barang</th>
                                    <td>:</td>
                                    <td><?= $result['nama_barang'] ?></td>
                                </tr>
                                <tr>
                                    <th>Stok</th>
                                    <td>:</td>
                                    <td><?= $result['stok'] ?></td>
                                </tr>
                                <tr>
                                    <th>Satuan</th>
                                    <td>:</td>
                                    <td><?= $result['nama_satuan'] ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            require_once "../../template/footer.php";
            ?>