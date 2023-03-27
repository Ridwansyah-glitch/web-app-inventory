<?php
require_once "../config/koneksi.php";
require_once "../config/newID.php";
require_once "../config/function.php";
$title = "Data Barang - Inventory";
require_once "../template/header.php";
require_once "../template/navbar.php";
require_once "../template/sidebar.php";

?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Laporan</h1>
            <!-- <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Home</li>
            </ol> -->
            <div class="row mb-4">
                <div class="col">
                    <form action="" style="display:grid; grid-template-columns:repeat(3,auto); gap:10px;">
                        <input type="date" name="" id="" class="form-control">
                        <input type="date" name="" id="" class="form-control">
                        <button class="btn btn-primary" name="" type="submit" style="width:120px;">Submit</button>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <table id="datatablesSimple" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Barang</th>
                                        <th>Satuan</th>
                                        <th>Stok</th>
                                        <th>Jumlah Masuk</th>
                                        <th>Tanggal Masuk</th>
                                        <th>Jumlah Keluar</th>
                                        <th>Tanggal Keluar</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php $sql = $koneksi->query("SELECT br.id,br.nama_barang,br.stok,br.satuan_id,st.id_satuan,st.nama_satuan,
                                    bm.barang_id,bm.jumlah_masuk,bm.tanggal_masuk,bk.barang_id,bk.jumlah_keluar,bk.tanggal_keluar
                                    FROM barang as br 
                                    JOIN satuan as st ON st.id_satuan=br.satuan_id 
                                    LEFT JOIN barang_masuk as bm ON bm.barang_id=br.id
                                    LEFT JOIN barang_keluar as bk ON bk.barang_id=br.id"); ?>
                                    <?php while ($data = $sql->fetch_assoc()) : ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $data['nama_barang'] ?></td>
                                            <td><?= $data['nama_satuan'] ?></td>
                                            <td><?= $data['stok'] ?></td>
                                            <td><?= $data['jumlah_masuk'] != null ? $data['jumlah_masuk'] : '-' ?></td>
                                            <td><?= $data['tanggal_masuk'] != null ? $data['tanggal_masuk'] : '-' ?></td>
                                            <td><?= $data['jumlah_keluar'] != null ? $data['jumlah_keluar'] : '-' ?></td>
                                            <td><?= $data['tanggal_keluar'] != null ? $data['tanggal_keluar'] : '-' ?></td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php
    require_once "../template/footer.php";
    ?>