<?php
include 'koneksi.php';
session_start();

$berat = $_POST['berat'];
$paket_id = $_POST['paket_id'];
$status_bayar = 'Sudah Bayar';
$kasir = $_SESSION['username'];

// ambil harga paket
$p = mysqli_fetch_assoc(mysqli_query($conn,
  "SELECT harga_per_kg FROM paket WHERE id='$paket_id'"
));

$total = $berat * $p['harga_per_kg'];

mysqli_query($conn,"
INSERT INTO transaksi
(berat, paket_id, total, status, status_bayar, kasir)
VALUES
('$berat','$paket_id','$total','Proses','$status_bayar','$kasir')
");

header("location:transaksi.php");