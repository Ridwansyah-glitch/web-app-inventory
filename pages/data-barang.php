<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: ../login.php");
    exit;
}

require_once "../config/function.php";
require_once "../config/koneksi.php";
require_once "../config/newID.php";
$title = "Data Barang - Inventory";
require_once "../template/header.php";
require_once "../template/navbar.php";
require_once "../template/sidebar.php";

if (isset($_POST['addBarang'])) {
    if (addBarang($_POST) > 0) {
        echo "
            <script>
                alert('Data Berhasil Ditambah');
                document.location.href='data-barang.php';
            </script>
        ";
    }
}

if (isset($_POST['editBarang'])) {
    if (editbarang($_POST) > 0) {
        echo "
        <script>
            alert('Data Berhasil Diubah');
            document.location.href='data-barang.php';
        </script>
    ";
    }
}

$sukses = "";
$error = "";
if (isset($_POST['delete'])) {
    if (deleteBarang($_POST) > 0) {
        echo "
            <script>
                alert('Data Berhasil Dihapus');
                document.location.href='data-barang.php';
            </script>
        ";
    }
}

?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Data Barang</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item "><a href="../index.php"> Home</a></li>
                <li class="breadcrumb-item active">Data Barang</li>
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
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addBarang"> <i class="fa-solid fa-plus"></i> Tambah Data</button>
                </div>
                <div class="card-body">
                    <table id="datatablesSimple" class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Id Barang</th>
                                <th>Nama Barang</th>
                                <th>Satuan</th>
                                <th>Stok</th>
                                <th>Created</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php $sql = $koneksi->query("SELECT * FROM barang  JOIN satuan ON satuan.id_satuan=barang.satuan_id"); ?>
                            <?php while ($data = $sql->fetch_assoc()) : ?>
                                <?php $idb = $data['id'] ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $data['id_barang'] ?></td>
                                    <td><?= $data['nama_barang'] ?></td>
                                    <td><?= $data['nama_satuan'] ?></td>
                                    <td><?= $data['stok'] ?></td>
                                    <td><?= date('d/m/Y H:i', strtotime($data['created_at'])) ?></td>
                                    <td>
                                        <a href="<?= $main_url ?>pages/details/detail-data-barang.php?id=<?= $idb ?>" class="btn btn-info btn-sm" title="Info"><i class="fa-sharp fa-solid fa-circle-info"></i></a>
                                        <button class="btn btn-primary btn-sm" id="btn-edit" data-bs-toggle="modal" data-bs-target="#editBarang<?= $idb; ?>" title="Edit"><i class="fa-solid fa-pen-to-square"></i></button>
                                        <form action="" method="POST" class="d-inline">
                                            <input type="hidden" value="<?= $idb ?>" name="id">
                                            <input type="hidden" value="<?= $data['foto_barang'] ?>" name="foto_barang">
                                            <button class="btn btn-danger btn-sm" onclick="confirm('Apa Kamu yakin Hapus?');" name="delete" title="Delete"><i class="fa-solid fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                <!-- Modal Edit -->
                                <div class="modal fade" id="editBarang<?= $idb ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Barang</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST" enctype="multipart/form-data">
                                                    <div class="mb-2">
                                                        <label for="id_barang" class="form-label">ID</label>
                                                        <input type="text" class="form-control" name="id_barang" value="<?= $data['id_barang'] ?>" readonly>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label for="nama_barang" class="form-label">Nama Barang</label>
                                                        <input type="text" class="form-control" name="nama_barang" value="<?= $data['nama_barang'] ?>">
                                                    </div>
                                                    <div class="mb-2">
                                                        <label for="stok" class="form-label">Satuan</label>
                                                        <select name="satuan" class="form-control">
                                                            <?php
                                                            $qry = $koneksi->query("SELECT * FROM satuan");
                                                            while ($stn = $qry->fetch_assoc()) : ?>
                                                                <option value="<?= $stn['id_satuan'] ?>" <?php if ($stn['id_satuan'] == $data['satuan_id']) {
                                                                                                                echo "selected";
                                                                                                            } ?>> <?= $stn['nama_satuan'] ?></option>
                                                            <?php endwhile; ?>
                                                        </select>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label for="stok" class="form-label">Foto Produk</label>
                                                        <input type="text" class="form-control" name="imgLama" value="<?= $data['foto_barang'] ?>">
                                                        <input type="file" class="form-control" name="imgBaru">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary" name="editBarang">simpan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end modal edit -->
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <?php
    require_once "../template/footer.php";
    ?>
    <!-- modal addBarang -->
    <div class="modal fade" id="addBarang" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Barang</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" enctype="multipart/form-data" class="myInput">
                        <div class="mb-2">
                            <label for="id_barang" class="form-label">ID</label>
                            <input type="text" class="form-control" name="id_barang" value="<?= $idBarang; ?>" readonly>
                        </div>
                        <div class="mb-2">
                            <label for="nama_barang" class="form-label">Nama Barang</label>
                            <input type="text" class="form-control" name="nama_barang" required>
                        </div>
                        <div class="mb-2">
                            <label for="satuan" class="form-label">Pilih Satuan</label>
                            <select name="satuan" id="" class="form-control">
                                <option value="">--Pilih Satuan ---</option>
                                <?php
                                $qry = $koneksi->query("SELECT * FROM satuan");
                                while ($data = $qry->fetch_assoc()) : ?>
                                    <option value="<?= $data['id_satuan'] ?>"><?= $data['nama_satuan'] ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label for="gambar" class="form-label">Upload Gambar</label>
                            <input type="file" class="form-control" name="gambar" required>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" name="addBarang">simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end modal addBarang -->