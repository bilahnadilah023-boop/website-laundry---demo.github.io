<?php
session_start();
include 'koneksi.php';

/* =====================
   MODE EDIT
===================== */
$edit = null;
if (isset($_GET['edit'])) {
  $id = intval($_GET['edit']);
  $qe = mysqli_query($conn, "SELECT * FROM konsumen WHERE id='$id'");
  $edit = mysqli_fetch_assoc($qe);
}

/* =====================
   SIMPAN (TAMBAH / UPDATE)
===================== */
if (isset($_POST['simpan'])) {
  $id      = $_POST['id'] !== '' ? intval($_POST['id']) : null;
  $nama    = mysqli_real_escape_string($conn, $_POST['nama']);
  $alamat  = mysqli_real_escape_string($conn, $_POST['alamat']);
  $telepon = mysqli_real_escape_string($conn, $_POST['telepon']);

  if ($id) {
    mysqli_query($conn, "
      UPDATE konsumen 
      SET nama='$nama', alamat='$alamat', telepon='$telepon'
      WHERE id='$id'
    ");
  } else {
    mysqli_query($conn, "
      INSERT INTO konsumen (nama, alamat, telepon)
      VALUES ('$nama', '$alamat', '$telepon')
    ");
  }

  header("Location: konsumen.php");
  exit;
}

/* =====================
   HAPUS
===================== */
if (isset($_GET['hapus'])) {
  $id = intval($_GET['hapus']);
  mysqli_query($conn, "DELETE FROM konsumen WHERE id='$id'");
  header("Location: konsumen.php");
  exit;
}

/* =====================
   DATA TABEL
===================== */
$q = mysqli_query($conn, "SELECT * FROM konsumen ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Data Konsumen</title>
<style>
body { font-family: Arial; margin:0; background:#f2f4f7; }
.container { padding:20px; }
table { width:100%; border-collapse:collapse; margin-top:15px; }
th, td { padding:10px; border:1px solid #ddd; }
th { background:#f9fafb; }

.btn { padding:6px 12px; border-radius:5px; color:#fff; text-decoration:none; display:inline-block; }
.btn-tambah { background:#2563eb; }
.btn-edit { background:#22c55e; }
.btn-hapus { background:#ef4444; }

form { background:#fff; padding:15px; border-radius:8px; margin-bottom:20px; }
input, textarea { width:100%; padding:6px; margin-bottom:10px; }

/* tombol kembali */
.kembali {
  background:#3b82f6;
  margin-bottom:15px;
}
.kembali:hover {
  background:#2563eb;
}
</style>
</head>
<body>

<div class="container">

<!-- TOMBOL KEMBALI -->
<a href="dashboard.php" class="btn kembali">⬅ Kembali</a>

<h2>Data Konsumen</h2>

<!-- FORM -->
<form method="post">
  <input type="hidden" name="id" value="<?= $edit['id'] ?? '' ?>">

  <label>Nama</label>
  <input type="text" name="nama" value="<?= $edit['nama'] ?? '' ?>" required>

  <label>Alamat</label>
  <textarea name="alamat"><?= $edit['alamat'] ?? '' ?></textarea>

  <label>Telepon</label>
  <input type="text" name="telepon" value="<?= $edit['telepon'] ?? '' ?>">

  <button type="submit" name="simpan" class="btn btn-tambah">
    <?= $edit ? 'Update' : 'Tambah' ?>
  </button>

  <?php if($edit){ ?>
    <a href="konsumen.php" class="btn kembali">Batal</a>
  <?php } ?>
</form>

<!-- TABEL -->
<table>
<tr>
  <th>#</th>
  <th>Nama</th>
  <th>Alamat</th>
  <th>Telepon</th>
  <th>Aksi</th>
</tr>
<?php $no=1; while($k=mysqli_fetch_assoc($q)){ ?>
<tr>
  <td><?= $no++ ?></td>
  <td><?= $k['nama'] ?></td>
  <td><?= $k['alamat'] ?></td>
  <td><?= $k['telepon'] ?></td>
  <td>
    <a href="konsumen.php?edit=<?= $k['id'] ?>" class="btn btn-edit">Edit</a>
    <a href="konsumen.php?hapus=<?= $k['id'] ?>" 
       class="btn btn-hapus"
       onclick="return confirm('Yakin ingin hapus?')">Hapus</a>
  </td>
</tr>
<?php } ?>
</table>

</div>
</body>
</html>
