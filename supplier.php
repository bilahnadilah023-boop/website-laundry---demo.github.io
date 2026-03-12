<?php
session_start();
include 'koneksi.php';

if(!isset($_SESSION['login'])){
    header("location:login.php");
    exit;
}

// TAMBAH SUPPLIER
if(isset($_POST['tambah'])){
    mysqli_query($conn,"INSERT INTO supplier 
    (nama_supplier,alamat,no_hp,email)
    VALUES 
    ('$_POST[nama]','$_POST[alamat]','$_POST[hp]','$_POST[email]')");
    header("location:supplier.php");
}

// HAPUS
if(isset($_GET['hapus'])){
    mysqli_query($conn,"DELETE FROM supplier WHERE id_supplier='$_GET[id]'");
    header("location:supplier.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Data Supplier</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<div class="container mt-4">

<h3>Data Supplier</h3>

<!-- FORM TAMBAH -->
<div class="card mb-3">
<div class="card-header">Tambah Supplier</div>
<div class="card-body">

<form method="post">
<div class="row">
<div class="col-md-3">
<input type="text" name="nama" class="form-control" placeholder="Nama Supplier" required>
</div>

<div class="col-md-3">
<input type="text" name="alamat" class="form-control" placeholder="Alamat">
</div>

<div class="col-md-2">
<input type="text" name="hp" class="form-control" placeholder="No HP">
</div>

<div class="col-md-3">
<input type="email" name="email" class="form-control" placeholder="Email">
</div>

<div class="col-md-1">
<button name="tambah" class="btn btn-primary">Simpan</button>
</div>
</div>
</form>

</div>
</div>

<!-- TABEL -->
<div class="card">
<div class="card-header">List Supplier</div>
<div class="card-body">

<table class="table table-bordered">
<tr>
<th>No</th>
<th>Nama</th>
<th>Alamat</th>
<th>No HP</th>
<th>Email</th>
<th>Aksi</th>
</tr>

<?php
$no=1;
$data = mysqli_query($conn,"SELECT * FROM supplier");
while($d = mysqli_fetch_array($data)){
?>

<tr>
<td><?= $no++; ?></td>
<td><?= $d['nama_supplier']; ?></td>
<td><?= $d['alamat']; ?></td>
<td><?= $d['no_hp']; ?></td>
<td><?= $d['email']; ?></td>
<td>
<a href="edit_supplier.php?id=<?= $d['id_supplier']; ?>" class="btn btn-warning btn-sm">Edit</a>
<a href="?hapus&id=<?= $d['id_supplier']; ?>" class="btn btn-danger btn-sm">Hapus</a>
</td>
</tr>

<?php } ?>

</table>

</div>
</div>

</div>
</body>
</html>