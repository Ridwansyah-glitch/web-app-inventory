<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: ../login.php");
    exit;
}
require_once "../config/koneksi.php";
require_once "../config/newID.php";
require_once "../config/function.php";
$title = "Data Barang - Inventory";
require_once "../template/header.php";
require_once "../template/navbar.php";
require_once "../template/sidebar.php";

if (isset($_POST['tambahSatuan'])) {
    if (addSatuan($_POST) > 0) {
        echo "
            <script>
                alert('Data Berhasil Ditambah');
                document.location.href='data-satuan.php';
            </script>
        ";
    }
}

if (isset($_POST['editSatuan'])) {
    if (editSatuan($_POST) > 0) {
        echo "
        <script>
            alert('Data Berhasil Diubah');
            document.location.href='data-satuan.php';
        </script>
    ";
    }
}

$sukses = "";
$error = "";
if (isset($_POST['delete'])) {
    if (deleteSatuan($_POST) > 0) {
        echo "
            <script>
                alert('Data Berhasil Dihapus');
                document.location.href='data-satuan.php';
            </script>
        ";
    }
}

?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Data satuan</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item "><a href="../index.php"> Home</a></li>
                <li class="breadcrumb-item active">Data satuan</li>
            </ol>
            <?php if ($error) : ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <?= $error ?>
                </div>
            <?php endif; ?>
            <?php if ($sukses) : ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <?= $sukses ?>

                </div>
            <?php endif; ?>
            <div class="card mb-4">
                <div class="card-header">
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addSatuan"> <i class="fa-solid fa-plus"></i> Tambah Data</button>
                </div>
                <div class="card-body">
                    <table id="datatablesSimple" class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama satuan</th>
                                <th>Latest Update</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php $sql = $koneksi->query("SELECT * FROM satuan"); ?>
                            <?php while ($data = $sql->fetch_assoc()) : ?>
                                <?php $idb = $data['id_satuan'] ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $data['nama_satuan'] ?></td>
                                    <td><?= date('d/m/Y H:i', strtotime($data['update_at'])) ?></td>
                                    <td>
                                        <button class="btn btn-primary btn-sm" id="btn-edit" data-bs-toggle="modal" data-bs-target="#editsatuan<?= $idb; ?>"><i class="fa-solid fa-pen-to-square"></i></button>
                                        <form action="" method="POST" class="d-inline">
                                            <input type="hidden" value="<?= $idb ?>" name="id">
                                            <button class="btn btn-danger btn-sm" onclick="confirm('Apa Kamu yakin Hapus?');" name="delete"><i class="fa-solid fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                <!-- Modal Edit -->
                                <div class="modal fade" id="editsatuan<?= $idb ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit satuan</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST" enctype="multipart/form-data">
                                                    <div class="mb-2">
                                                        <input type="hidden" class="form-control" name="id_satuan" value="<?= $data['id_satuan'] ?>">
                                                    </div>
                                                    <div class="mb-2">
                                                        <label for="nama_satuan" class="form-label">Nama satuan</label>
                                                        <input type="text" class="form-control" name="nama_satuan" value="<?= $data['nama_satuan'] ?>">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary" name="editSatuan">simpan</button>
                                                    </div>
                                                </form>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </main>
    <!-- Modal -->
    <div class="modal fade" id="addSatuan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
    </div>
    <script>
        $('#btn-edit').on('click', function() {
            $('#editBarang').modal('show');
        });
    </script>
    <?php
    require_once "../template/footer.php";
    ?>