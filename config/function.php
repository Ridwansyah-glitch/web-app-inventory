<?php

//url induk
$main_url = "http://localhost/inventory2/";

//login
function loginFunction($data)
{
    global $koneksi;

    $username = $data['username'];
    $password = $data['password'];

    $qry = $koneksi->query("SELECT * FROM users WHERE username='$username' AND password='$password'");
    $result = $qry->num_rows;

    if ($result > 0) {
        $session = $qry->fetch_assoc();
        $_SESSION['login'] = $session;
    } else {
        echo "
        <script>
            alert('Username Atau Password Salah');
            document.location.href='login.php';
        </script>
    ";
    }

    return mysqli_affected_rows($koneksi);
}

//Function Barang
function addBarang($data)
{
    global $koneksi;
    global $main_url;

    $id = htmlspecialchars($data['id_barang']);
    $nama_barang = htmlspecialchars($data['nama_barang']);
    // $stok = $data['stok'];
    $satuan = $data['satuan'];
    //fungsi upload gambar
    $namaFile = $_FILES['gambar']['name'];
    // $ukuran = $_FILES['gambar']['size'];
    // $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];

    //cek file yg di upload
    $validExtension = ['jpg', 'jpeg', 'png'];
    $fileExtension = explode('.', $namaFile);
    $fileExtension = strtolower(end($fileExtension));

    if (!in_array($fileExtension, $validExtension)) {
        echo "
            <script>
            alert('Ekstensi File Tidak Valid');
            document.location.href='data-barang.php';
            </script>
        ";
        die;
    }

    //generate nama file gambar
    $namaFileBaru = uniqid() . '-' . $namaFile;
    move_uploaded_file($tmpName, '../assets/img/' . $namaFileBaru);

    $koneksi->query("INSERT INTO barang(id_barang,nama_barang,satuan_id,foto_barang,created_at) VALUES('$id','$nama_barang','$satuan','$namaFileBaru',NOW())");
    return mysqli_affected_rows($koneksi);
}

function editBarang($data)
{

    global $koneksi;
    global $main_url;
    $id = htmlspecialchars($data['id_barang']);
    $nama_barang = htmlspecialchars($data['nama_barang']);
    $satuan = $data['satuan'];

    $oldImg = $data['imgLama'];

    $newImg = $_FILES['imgBaru']['name'];
    $tmpName = $_FILES['imgBaru']['tmp_name'];

    //cek file yg di upload
    $validExtension = ['jpg', 'jpeg', 'png'];
    $fileExtension = explode('.', $newImg);
    $fileExtension = strtolower(end($fileExtension));


    if (!in_array($fileExtension, $validExtension)) {
        echo "
             <script>
             alert('Ekstensi File Tidak Valid');
            document.location.href='data-barang.php';
            </script>
        ";
    }

    //generate nama file gambar
    $namaFileBaru = uniqid() . '-' . $newImg;
    if (!empty($tmpName)) {

        move_uploaded_file($tmpName, '../assets/img/' . $namaFileBaru);
        unlink('../assets/img/' . $oldImg);
        $koneksi->query("UPDATE barang SET nama_barang='$nama_barang',satuan_id='$satuan', foto_barang='$namaFileBaru' WHERE id_barang='$id'");
    } else {
        $koneksi->query("UPDATE barang SET nama_barang='$nama_barang',satuan_id='$satuan' WHERE id_barang='$id'");
    }
    return mysqli_affected_rows($koneksi);
}


function deleteBarang($data)
{
    global $koneksi;
    $id = $data['id'];
    $foto = $data['foto_barang'];
    unlink('../assets/img/' . $foto);

    $koneksi->query("DELETE FROM barang WHERE id='$id'");
    return mysqli_affected_rows($koneksi);
}

//Fungsi Data Satuan
function addSatuan($data)
{
    global $koneksi;

    $nama_satuan = $data['nama_satuan'];

    $koneksi->query("INSERT INTO satuan(nama_satuan,update_at) VALUES('$nama_satuan',NOW())");
    return mysqli_affected_rows($koneksi);
}

function editSatuan($data)
{
    global $koneksi;

    $id_satuan = $data['id_satuan'];
    $nama_satuan = $data['nama_satuan'];

    $koneksi->query("UPDATE satuan SET nama_satuan='$nama_satuan',update_at=NOW() WHERE id_satuan='$id_satuan'");
    return mysqli_affected_rows($koneksi);
}
function deleteSatuan($id)
{
    global $koneksi;

    $id = $id['id'];
    $koneksi->query("DELETE FROM satuan WHERE id_satuan='$id'");
    return mysqli_affected_rows($koneksi);
}


//Fungsi Data Supplier

function addSupplier($data)
{
    global $koneksi;

    $nama_supplier = htmlspecialchars($data['nama_supplier']);
    $tlp = htmlspecialchars($data['telepon_supplier']);
    $alamat = htmlspecialchars($data['alamat']);

    $koneksi->query("INSERT INTO supplier(nama_supplier,telepon_supplier,alamat,update_at) VALUES('$nama_supplier','$tlp','$alamat',NOW())");
    return mysqli_affected_rows($koneksi);
}

function editSupplier($data)
{
    global $koneksi;

    $id_supplier = htmlspecialchars($data['id_supplier']);
    $nama_supplier = htmlspecialchars($data['nama_supplier']);
    $tlp = htmlspecialchars($data['telepon_supplier']);
    $alamat = htmlspecialchars($data['alamat']);

    $koneksi->query("UPDATE supplier SET nama_supplier='$nama_supplier',telepon_supplier='$tlp',alamat='$alamat',update_at=NOW() WHERE id_supplier='$id_supplier'");
    return mysqli_affected_rows($koneksi);
}

function deleteSupplier($id)
{
    global $koneksi;
    $id = $id['id'];
    $koneksi->query("DELETE FROM supplier WHERE id_supplier='$id'");
    return mysqli_affected_rows($koneksi);
}


//Barang Masuk

function addBarangMasuk($data)
{
    global $koneksi;

    $id_barang = $data['id'];
    $supplier = $data['supplier'];
    $jumlah = htmlspecialchars($data['jumlah_masuk']);

    $koneksi->query("INSERT INTO barang_masuk(barang_id,supplier_id,jumlah_masuk,tanggal_masuk)
     VALUES('$id_barang','$supplier','$jumlah',NOW())");

    $idBarang = $koneksi->insert_id;
    $koneksi->query("UPDATE barang SET stok=stok+$jumlah WHERE id='$id_barang'");
    $koneksi->query("INSERT INTO history(id,barang_id,role,jumlah,tgl) VALUES(NULL,'$idBarang','BM','$jumlah',NOW())");
    return mysqli_affected_rows($koneksi);
}

function deleteBm($data)
{
    global $koneksi;
    $id = $data['id'];
    $koneksi->query("DELETE FROM barang_masuk WHERE barang_id='$id'");
    return mysqli_affected_rows($koneksi);
}

//Barang Keluar
function addBarangKeluar($data)
{
    global $koneksi;
    $id_barang = $data['id'];
    $tujuan = htmlspecialchars($data['tujuan']);
    $jumlah = htmlspecialchars($data['jumlah_keluar']);

    //jika stok barang kurang
    $sql = $koneksi->query("SELECT * FROM barang WHERE id='$id_barang'");
    $result = $sql->fetch_assoc();

    if ($jumlah > $result['stok']) {
        echo "<script>alert('Jumlah Barang Kurang dari Jumlah Keluar,silahkan masukan kembali');
        document.location.href='../data-barang-keluar.php';
  </script>";
    } else {
        $koneksi->query("INSERT INTO barang_keluar(barang_id,tanggal_keluar,tujuan,jumlah_keluar) 
            VALUES('$id_barang',NOW(),'$tujuan','$jumlah')");
        $idBarang = $koneksi->insert_id;
        $koneksi->query("UPDATE barang SET stok=stok-$jumlah WHERE id='$id_barang'");
    }

    return mysqli_affected_rows($koneksi);
}


function deleteBk($data)
{
    global $koneksi;
    $id = $data['id'];
    $koneksi->query("DELETE FROM barang_keluar WHERE id_bk='$id'");
    return mysqli_affected_rows($koneksi);
}
