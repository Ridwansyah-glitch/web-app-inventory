<?php
require_once "koneksi.php";
$qryIdBarang = $koneksi->query("SELECT MAX(id_barang) FROM barang");
$resultBarang = $qryIdBarang->fetch_array();
$empty = $resultBarang[0];
$num = (int)substr($empty, 4);
$num++;
$car = "BRG-";
$idBarang = sprintf("%s%04s", $car, $num);
