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
                    <form method="POST" style="display:grid; grid-template-columns:repeat(3,auto); gap:10px;">
                        <input type="date" name="start" class="form-control">
                        <input type="date" name="end" class="form-control">
                        <button class="btn btn-primary" name="filter" type="submit" style="width:120px;">Submit</button>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <table id="datatablesSimple" class="table table-hover">
                                <?php if (isset($_POST['filter'])) { ?>
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
                                    <?php $no = 1;
                                    $start = $_POST['start'];
                                    $end = $_POST['end'];
                                    ?>
                                    <?php $sql = $koneksi->query("SELECT br.id,br.stok,br.nama_barang,br.satuan_id,st.id_satuan,st.nama_satuan,bk.barang_id,bk.tanggal_keluar,bk.jumlah_keluar,bm.barang_id,bm.tanggal_masuk,bm.jumlah_masuk
                                 FROM barang as br
                                 LEFT JOIN satuan as st ON st.id_satuan = br.satuan_id
                                 LEFT JOIN barang_keluar as bk ON bk.barang_id = br.id
                                 LEFT JOIN barang_masuk as bm ON bm.barang_id = br.id
                                 WHERE bk.tanggal_keluar BETWEEN '$start' AND '$end'
                                 OR bm.tanggal_masuk BETWEEN '$start' AND '$end'
                                 ");

                                    $sqlBm = $koneksi->query("SELECT SUM(jumlah_masuk) as jumlah_masuk FROM barang_masuk WHERE tanggal_masuk BETWEEN '$start' AND '$end'");
                                    $totalBm = $sqlBm->fetch_assoc();

                                    $sqlBk = $koneksi->query("SELECT SUM(jumlah_keluar) as jumlah_keluar FROM barang_keluar WHERE tanggal_keluar BETWEEN '$start' AND '$end'");
                                    $totalBk = $sqlBk->fetch_assoc();
                                    ?>
                                    <tbody>
                                        <?php while ($data = $sql->fetch_assoc()) : ?>
                                            <tr>
                                                <td><?= $no; ?></td>
                                                <td><?= $data['nama_barang']; ?></td>
                                                <td><?= $data['nama_satuan']; ?></td>
                                                <td><?= $data['stok']; ?></td>
                                                <td><?= $data['jumlah_masuk'] != null ? $data['jumlah_masuk'] : '-'; ?></td>
                                                <td><?= $data['tanggal_masuk'] != null ? date('d/m/Y H;i', strtotime($data['tanggal_masuk'])) : '-'; ?></td>
                                                <td><?= $data['jumlah_keluar'] != null ? $data['jumlah_keluar'] : '-'; ?></td>
                                                <td><?= $data['tanggal_keluar'] != null ? date('d/m/Y H;i', strtotime($data['tanggal_keluar'])) : '-' ?></td>
                                            </tr>
                                            <?php $no++; ?>
                                        <?php endwhile; ?>
                                        <tr style="justify-content: right;">
                                            <th colspan='2'>Total Barang Masuk</th>
                                            <td colspan="6"><?= $totalBm['jumlah_masuk']; ?></td>
                                        </tr>
                                        <tr style="justify-content: right;">
                                            <th colspan='2'>Total Barang Keluar</th>
                                            <td colspan="6"><?= $totalBk['jumlah_keluar']; ?></td>
                                        </tr>
                                    </tbody>

                                <?php  } else {
                                    echo "<td>No Data Selected</td>";
                                } ?>
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