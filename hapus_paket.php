<?php
include 'koneksi.php';
mysqli_query($conn,"DELETE FROM paket WHERE id='$_GET[id]'");
header("location:paket.php");
