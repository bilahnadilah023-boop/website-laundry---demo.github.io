<?php
session_start();
include 'koneksi.php';

$berat        = $_POST['berat'];
$paket_id     = $_POST['paket_id'];
$total        = $_POST['total'];
$metode_bayar = $_POST['metode_bayar'];

$tgl_masuk = date('Y-m-d H:i:s');
$status    = 'Diproses';

// VALIDASI
if($berat=="" || $paket_id=="" || $total==""){
    echo "Data tidak lengkap";
    exit;
}

// SIMPAN KE DATABASE
mysqli_query($conn,"INSERT INTO transaksi 
  (paket_id, berat, total, metode_bayar, status, tgl_masuk)
  VALUES
  ('$paket_id','$berat','$total','$metode_bayar','$status','$tgl_masuk')
");

// KEMBALI KE HALAMAN TRANSAKSI
header("Location: transaksi.php");
