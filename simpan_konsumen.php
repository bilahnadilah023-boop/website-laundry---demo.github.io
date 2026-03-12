<?php
session_start();
include 'koneksi.php';

$id      = isset($_POST['id']) && $_POST['id'] !== '' ? intval($_POST['id']) : null;
$nama    = mysqli_real_escape_string($conn, $_POST['nama']);
$alamat  = mysqli_real_escape_string($conn, $_POST['alamat']);
$telepon = mysqli_real_escape_string($conn, $_POST['telepon']);

if ($id) {
  // UPDATE
  mysqli_query($conn, "
    UPDATE konsumen 
    SET nama='$nama', alamat='$alamat', telepon='$telepon'
    WHERE id='$id'
  ");
} else {
  // INSERT
  mysqli_query($conn, "
    INSERT INTO konsumen (nama, alamat, telepon) 
    VALUES ('$nama', '$alamat', '$telepon')
  ");
}

header("Location: konsumen.php");
exit;
