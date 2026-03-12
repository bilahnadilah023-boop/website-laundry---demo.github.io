<?php
session_start();
include 'koneksi.php';

/* ================= AMBIL DATA EDIT ================= */
$e = [];
if(isset($_GET['edit'])){
  $id = $_GET['edit'];
  $result = mysqli_query($conn,"SELECT * FROM jenis WHERE id='$id'");
  $e = mysqli_fetch_assoc($result);
}

/* ================= TAMBAH ================= */
if(isset($_POST['tambah'])){
  mysqli_query($conn,"INSERT INTO jenis 
  (nama_jenis,keterangan)
  VALUES 
  ('$_POST[nama]','$_POST[keterangan]')");
  header("location:jenis.php");
  exit;
}

/* ================= UPDATE ================= */
if(isset($_POST['update'])){
  mysqli_query($conn,"UPDATE jenis SET
  nama_jenis='$_POST[nama]',
  keterangan='$_POST[keterangan]'
  WHERE id='$_POST[id]'");
  header("location:jenis.php");
  exit;
}

/* ================= HAPUS ================= */
if(isset($_GET['hapus'])){
  mysqli_query($conn,"DELETE FROM jenis WHERE id='$_GET[hapus]'");
  header("location:jenis.php");
  exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Data Jenis</title>
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

<h2>DATA JENIS LAUNDRY</h2>

<!-- FORM -->
<div class="card">
<form method="POST">

<input type="hidden" name="id" value="<?= @$e['id'] ?>">

<input type="text" name="nama" 
value="<?= @$e['nama_jenis'] ?>" 
placeholder="Nama Jenis (Reguler / Express / Dry Clean)" required>

<textarea name="keterangan" 
placeholder="Keterangan"><?= @$e['keterangan'] ?></textarea>

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
<th>Nama Jenis</th>
<th>Keterangan</th>
<th>Aksi</th>
</tr>

<?php
$no=1;
$q=mysqli_query($conn,"SELECT * FROM jenis ORDER BY id DESC");
while($d=mysqli_fetch_assoc($q)){
?>

<tr>
<td><?= $no++ ?></td>
<td><?= $d['nama_jenis'] ?></td>
<td><?= $d['keterangan'] ?></td>
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
