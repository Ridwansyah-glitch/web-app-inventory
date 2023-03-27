<?php
require_once "../config/koneksi.php";
require_once "../config/newID.php";
require_once "../config/function.php";
$title = "Data Barang - Inventory";
require_once "../template/header.php";
require_once "../template/navbar.php";
require_once "../template/sidebar.php";


if (isset($_POST['delete'])) {
    if (deleteBk($_POST) > 0) {
        echo "
            <script>
                alert('Data Berhasil Dihapus');
                document.location.href='data-barang-keluar.php';
            </script>
        ";
    }
}

?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Data Barang Keluar</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item "><a href="../index.php"> Home</a></li>
                <li class="breadcrumb-item active">Data Barang Keluar</li>
            </ol>
            <div class="card mb-4">
                <div class="card-header">
                    <a href="<?= $main_url ?>pages/add/tambah-data-bk.php" class="btn btn-primary btn-sm"> <i class="fa-solid fa-plus"></i> Tambah Data</a>
                </div>
                <div class="card-body">
                    <table id="datatablesSimple" class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Barang</th>
                                <th>Tanggal Keluar</th>
                                <th>Jumlah</th>
                                <th>Tujuan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php $sql = $koneksi->query("SELECT * FROM barang_keluar JOIN barang ON barang.id=barang_keluar.barang_id"); ?>
                            <?php while ($data = $sql->fetch_assoc()) : ?>
                                <?php $idb = $data['id_bk'] ?>
                                <?php $idbarang = $data['barang_id'] ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $data['nama_barang'] ?></td>
                                    <td><?= date('d/m/Y H:i', strtotime($data['tanggal_keluar'])) ?></td>
                                    <td><span class="badge text-bg-danger">- <?= $data['jumlah_keluar'] ?></span></td>
                                    <td><?= $data['tujuan'] ?></td>
                                    <td>
                                        <a href="<?= $main_url ?>pages/details/detail-data-bk.php?id=<?= $idbarang; ?>" class="btn btn-info btn-sm" title="Info"><i class="fa-sharp fa-solid fa-circle-info"></i></a>
                                        <form action="" method="POST" class="d-inline">
                                            <input type="hidden" value="<?= $idb ?>" name="id">
                                            <button class="btn btn-danger btn-sm" onclick="confirm('Apa Kamu yakin Hapus?');" name="delete"><i class="fa-solid fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>

                            <?php endwhile; ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </main>

    <script>
        $('#btn-edit').on('click', function() {
            $('#editBarang').modal('show');
        });
    </script>
    <?php
    require_once "../template/footer.php";
    ?>
    <!-- Modal -->
    <!-- <div class="modal fade" id="addSatuan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Satuan</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="mb-2">
                            <label for="nama_satuan" class="form-label">Nama Satuan</label>
                            <input type="text" class="form-control" name="nama_satuan" required>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" name="tambahSatuan">simpan</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div> -->