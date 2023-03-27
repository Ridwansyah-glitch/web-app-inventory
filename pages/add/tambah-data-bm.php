<?php
require_once "../../config/koneksi.php";
require_once "../../config/newID.php";
require_once "../../config/function.php";
$title = "Tambah Data - Inventory";
require_once "../../template/header.php";
require_once "../../template/navbar.php";
require_once "../../template/sidebar.php";


if (isset($_POST['tambahBarangMasuk'])) {
    if (addBarangMasuk($_POST) > 0) {
        echo "
            <script>
                alert('Data Berhasil Ditambah');
                document.location.href='../data-barang-masuk.php';
            </script>
        ";
    }
}


?>


<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Data Barang Masuk</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item "><a href="<?= $main_url ?>index.php"> Home</a></li>
                <li class="breadcrumb-item active">Tambah Data
                </li>
            </ol>

            <div class="card mb-4">
                <div class="card-header">
                    <form method="POST">
                        <select class="select2 js-states form-control" name="barang" onchange="this.form.submit()">
                            <option value="AL">--Pilih Barang--</option>
                            <?php $qry = $koneksi->query("SELECT * FROM barang") ?>
                            <?php while ($data = $qry->fetch_assoc()) { ?>
                                <option value="<?= $data['id_barang'] ?>"><?= $data['nama_barang'] ?></option>
                            <?php } ?>
                        </select>
                    </form>

                </div>
                <?php if (isset($_POST['barang'])) :
                    $sql = $koneksi->query("SELECT * FROM barang JOIN satuan ON satuan.id_satuan=barang.satuan_id WHERE id_barang='$_POST[barang]'");
                    $result = $sql->fetch_assoc();
                ?>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <form action="" method="POST">
                                    <div class="mb-2">
                                        <label for="">Nama Barang</label>
                                        <input type="hidden" name="id" value="<?= $result['id'] ?>">
                                        <input type="text" class="form-control" name="barang" value="<?= $result['nama_barang'] ?>" readonly>
                                    </div>
                                    <div class="mb-2">
                                        <label for="">Nama Supplier</label>
                                        <select class="select2 js-states form-control" name="supplier" required>
                                            <option value="AL">--Pilih Salah Satu--</option>
                                            <?php $qry = $koneksi->query("SELECT * FROM supplier") ?>
                                            <?php while ($data = $qry->fetch_assoc()) { ?>
                                                <option value="<?= $data['id_supplier'] ?>"><?= $data['nama_supplier'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="mb-2">
                                        <label for="">Jumlah</label>
                                        <input type="number" class="form-control" name="jumlah_masuk" min="1" required>
                                    </div>
                                    <button class="btn btn-primary" name="tambahBarangMasuk">Submit</button>
                                </form>
                            </div>
                            <div class="col">
                                <img src="<?= $main_url ?>assets/img/<?= $result['foto_barang'] ?>" alt="" style="width:320px; height: 230px;">
                                <div class="row">
                                    <div class="col">
                                        <label for="">Satuan</label>
                                        <input type="text" class="form-control" value="<?= $result['nama_satuan'] ?>" readonly>
                                    </div>
                                    <div class="col">
                                        <label for="">Stok Saat Ini</label>
                                        <input type="text" class="form-control" value="<?= $result['stok'] ?>" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
    <?php
    require_once "../../template/footer.php";
    ?>