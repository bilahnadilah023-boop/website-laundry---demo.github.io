<?php
session_start();
include 'koneksi.php';

/* ================= AMBIL DATA EDIT ================= */
$e = [];
if(isset($_GET['edit'])){
  $id = $_GET['edit'];
  $result = mysqli_query($conn,"SELECT * FROM karyawan WHERE id='$id'");
  $e = mysqli_fetch_assoc($result);
}

/* ================= TAMBAH ================= */
if(isset($_POST['tambah'])){
  mysqli_query($conn,"INSERT INTO karyawan 
  (nama_karyawan,jabatan,no_hp,alamat,tanggal_masuk,gaji)
  VALUES 
  ('$_POST[nama]','$_POST[jabatan]','$_POST[hp]',
   '$_POST[alamat]','$_POST[tanggal]','$_POST[gaji]')");
  header("location:karyawan.php");
  exit;
}

/* ================= UPDATE ================= */
if(isset($_POST['update'])){
  mysqli_query($conn,"UPDATE karyawan SET
  nama_karyawan='$_POST[nama]',
  jabatan='$_POST[jabatan]',
  no_hp='$_POST[hp]',
  alamat='$_POST[alamat]',
  tanggal_masuk='$_POST[tanggal]',
  gaji='$_POST[gaji]'
  WHERE id='$_POST[id]'");
  header("location:karyawan.php");
  exit;
}

/* ================= HAPUS ================= */
if(isset($_GET['hapus'])){
  mysqli_query($conn,"DELETE FROM karyawan WHERE id='$_GET[hapus]'");
  header("location:karyawan.php");
  exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Data Karyawan</title>
<style>
body{font-family:Arial;background:#f3f4f6;padding:20px}
.card{background:white;padding:20px;border-radius:8px;
box-shadow:0 2px 5px rgba(0,0,0,.1);margin-bottom:20px}

h2{margin-bottom:10px}

input,textarea{
width:100%;
padding:8px;
margin-bottom:10px;
border:1px solid #ddd;
border-radius:5px;
}

button{
background:#2563eb;
color:white;
padding:8px 15px;
border:none;
border-radius:5px;
cursor:pointer;
}

button:hover{opacity:0.85}

table{
width:100%;
border-collapse:collapse;
margin-top:10px
}

th,td{
padding:10px;
border-bottom:1px solid #ddd;
}

th{background:#f9fafb}

a.btn{
padding:6px 10px;
border-radius:5px;
color:white;
text-decoration:none;
font-size:13px;
}

.edit{background:orange}
.hapus{background:red}
.kembali{background:#6b7280}
.kembali:hover{opacity:0.85}
</style>
</head>
<body>

<!-- TOMBOL KEMBALI -->
<a href="dashboard.php" class="btn kembali">⬅ Kembali ke Dashboard</a>

<h2>DATA KARYAWAN</h2>

<!-- FORM -->
<div class="card">
<form method="POST">

<input type="hidden" name="id" value="<?= @$e['id'] ?>">

<input type="text" name="nama" 
value="<?= @$e['nama_karyawan'] ?>" 
placeholder="Nama Karyawan" required>

<input type="text" name="jabatan" 
value="<?= @$e['jabatan'] ?>" 
placeholder="Jabatan" required>

<input type="text" name="hp" 
value="<?= @$e['no_hp'] ?>" 
placeholder="No HP">

<textarea name="alamat" 
placeholder="Alamat"><?= @$e['alamat'] ?></textarea>

<input type="date" name="tanggal" 
value="<?= @$e['tanggal_masuk'] ?>">

<input type="number" name="gaji" 
value="<?= @$e['gaji'] ?>" 
placeholder="Gaji">

<?php if(isset($_GET['edit'])){ ?>
  <button name="update">Update</button>
<?php } else { ?>
  <button name="tambah">Tambah</button>
<?php } ?>

</form>
</div>

<!-- TABEL DATA -->
<div class="card">
<table>
<tr>
<th>No</th>
<th>Nama</th>
<th>Jabatan</th>
<th>No HP</th>
<th>Gaji</th>
<th>Aksi</th>
</tr>

<?php
$no=1;
$q=mysqli_query($conn,"SELECT * FROM karyawan ORDER BY id DESC");
while($d=mysqli_fetch_assoc($q)){
?>

<tr>
<td><?= $no++ ?></td>
<td><?= $d['nama_karyawan'] ?></td>
<td><?= $d['jabatan'] ?></td>
<td><?= $d['no_hp'] ?></td>
<td>Rp <?= number_format($d['gaji']) ?></td>
<td>
<a href="?edit=<?= $d['id'] ?>" class="btn edit">Edit</a>
<a href="?hapus=<?= $d['id'] ?>" 
   onclick="return confirm('Yakin hapus?')" 
   class="btn hapus">Hapus</a>
</td>
</tr>

<?php } ?>

</table>
</div>

<!-- TOMBOL KEMBALI BAWAH -->
<a href="dashboard.php" class="btn kembali">⬅ Kembali ke Dashboard</a>

</body>
</html>
