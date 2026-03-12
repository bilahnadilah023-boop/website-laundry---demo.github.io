<?php
include 'koneksi.php';

$id = $_GET['id'];

// ambil status sekarang
$q = mysqli_query($conn, "SELECT status FROM transaksi WHERE id='$id'");
$data = mysqli_fetch_assoc($q);

if ($data['status'] == 'Proses') {
    $status_baru = 'Selesai';
} else {
    $status_baru = 'Proses';
}

// update status
mysqli_query($conn, "UPDATE transaksi SET status='$status_baru' WHERE id='$id'");

// balik ke dashboard
header("Location: dashboard.php");
exit;
