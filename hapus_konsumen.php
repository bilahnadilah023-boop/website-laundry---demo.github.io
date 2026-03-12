<?php
session_start();
include 'koneksi.php';

$id = intval($_GET['id']);
mysqli_query($conn, "DELETE FROM konsumen WHERE id='$id'");

header("Location: konsumen.php");
exit;
