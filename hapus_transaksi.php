<?php
include 'koneksi.php';
mysqli_query($conn,"DELETE FROM transaksi WHERE id='$_GET[id]'");
header("location:transaksi.php");
