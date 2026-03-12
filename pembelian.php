<?php
session_start();
include 'koneksi.php';

// Tambah Pembelian
if(isset($_POST['tambah'])){
    $supplier   = $_POST['supplier'];
    $tanggal    = $_POST['tanggal'];
    $total      = $_POST['total'];
    $keterangan = $_POST['keterangan'];

    mysqli_query($conn,"INSERT INTO pembelian (nama_supplier, tanggal, total, keterangan) 
                        VALUES ('$supplier','$tanggal','$total','$keterangan')");
    header('location:pembelian.php');
}

// Hapus Pembelian
if(isset($_GET['hapus'])){
    $id = $_GET['hapus'];
    mysqli_query($conn,"DELETE FROM pembelian WHERE id='$id'");
    header('location:pembelian.php');
}

// Edit Pembelian
if(isset($_POST['edit'])){
    $id         = $_POST['id'];
    $supplier   = $_POST['supplier'];
    $tanggal    = $_POST['tanggal'];
    $total      = $_POST['total'];
    $keterangan = $_POST['keterangan'];

    mysqli_query($conn,"UPDATE pembelian 
        SET nama_supplier='$supplier', tanggal='$tanggal', total='$total', keterangan='$keterangan' 
        WHERE id='$id'");
    header('location:pembelian.php');
}

// Ambil semua data pembelian
$q = mysqli_query($conn,"SELECT * FROM pembelian ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Pembelian</title>
<style>
body { font-family: Arial,sans-serif; margin:20px; background:#f2f4f7; }
h2 { color:#111827; }
table { width:100%; border-collapse: collapse; margin-top:15px; }
th, td { padding:10px; border:1px solid #ddd; text-align:left; }
th { background:#f9fafb; }

a { text-decoration:none; padding:6px 12px; border-radius:5px; color:white; display:inline-block; }
.add { background:#22c55e; }
.edit { background:#2563eb; }
.delete { background:#ef4444; }

form { margin-top:15px; background:white; padding:20px; border-radius:8px; }
input, textarea { width:100%; padding:8px; margin:5px 0 10px; border:1px solid #ccc; border-radius:5px; }
button { padding:8px 15px; border:none; border-radius:5px; background:#22c55e; color:white; cursor:pointer; }
button:hover { opacity:0.85; }

/* tombol kembali */
.kembali{
  background:#3b82f6;
  margin-bottom:15px;
}
.kembali:hover{
  background:#2563eb;
}
</style>
</head>
<body>

<!-- TOMBOL KEMBALI -->
<a href="dashboard.php" class="kembali">⬅ Kembali</a>

<h2>Daftar Pembelian</h2>
<a href="#tambah" class="add">+ Tambah Pembelian</a>

<table>
<tr>
<th>#</th>
<th>Supplier</th>
<th>Tanggal</th>
<th>Total</th>
<th>Keterangan</th>
<th>Aksi</th>
</tr>

<?php $no=1; while($p = mysqli_fetch_assoc($q)){ ?>
<tr>
<td><?= $no++ ?></td>
<td><?= $p['nama_supplier'] ?></td>
<td><?= $p['tanggal'] ?></td>
<td>Rp <?= number_format($p['total']) ?></td>
<td><?= $p['keterangan'] ?></td>
<td>
    <a href="#edit<?= $p['id'] ?>" class="edit">Edit</a>
    <a href="pembelian.php?hapus=<?= $p['id'] ?>" 
       class="delete"
       onclick="return confirm('Yakin ingin hapus?')">Hapus</a>
</td>
</tr>
<?php } ?>
</table>

<!-- FORM TAMBAH PEMBELIAN -->
<h3 id="tambah">Tambah Pembelian</h3>
<form method="POST">
<input type="text" name="supplier" placeholder="Nama Supplier" required>
<input type="date" name="tanggal" required>
<input type="number" name="total" placeholder="Total" required>
<textarea name="keterangan" placeholder="Keterangan"></textarea>
<button type="submit" name="tambah">Simpan</button>
</form>

<!-- FORM EDIT PEMBELIAN -->
<?php
$q2 = mysqli_query($conn,"SELECT * FROM pembelian ORDER BY id DESC");
while($p2 = mysqli_fetch_assoc($q2)){ ?>
<h3 id="edit<?= $p2['id'] ?>">Edit: <?= $p2['nama_supplier'] ?></h3>
<form method="POST">
<input type="hidden" name="id" value="<?= $p2['id'] ?>">
<input type="text" name="supplier" value="<?= $p2['nama_supplier'] ?>" required>
<input type="date" name="tanggal" value="<?= $p2['tanggal'] ?>" required>
<input type="number" name="total" value="<?= $p2['total'] ?>" required>
<textarea name="keterangan"><?= $p2['keterangan'] ?></textarea>
<button type="submit" name="edit">Update</button>
<a href="pembelian.php" class="kembali">Batal</a>
</form>
<?php } ?>

</body>
</html>
