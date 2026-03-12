<?php
session_start();
include 'koneksi.php';

/* ================= CRUD ================= */
if(isset($_POST['tambah'])){
  mysqli_query($conn,"INSERT INTO pakaian (nama_pakaian,harga,keterangan)
  VALUES ('$_POST[nama]','$_POST[harga]','$_POST[keterangan]')");
  header("location:pakaian.php");
  exit;
}

if(isset($_POST['edit'])){
  mysqli_query($conn,"UPDATE pakaian SET 
    nama_pakaian='$_POST[nama]',
    harga='$_POST[harga]',
    keterangan='$_POST[keterangan]'
    WHERE id='$_POST[id]'");
  header("location:pakaian.php");
  exit;
}

if(isset($_GET['hapus'])){
  mysqli_query($conn,"DELETE FROM pakaian WHERE id='$_GET[hapus]'");
  header("location:pakaian.php");
  exit;
}

$q = mysqli_query($conn,"SELECT * FROM pakaian ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Data Pakaian</title>
<style>
body{font-family:Arial;background:#f3f4f6;margin:0;padding:20px}
h2{margin-bottom:10px}
.card{background:white;padding:20px;border-radius:10px;margin-bottom:20px}
table{width:100%;border-collapse:collapse;margin-top:10px}
th,td{padding:10px;border-bottom:1px solid #e5e7eb;text-align:center}
th{background:#f9fafb}
.btn{padding:6px 10px;border-radius:6px;color:white;text-decoration:none;font-size:13px;border:none;cursor:pointer}
.btn-detail{background:#2563eb}
.btn-edit{background:#eab308}
.btn-hapus{background:#dc2626}
input,textarea{width:100%;padding:8px;margin-top:6px}
button{padding:8px 14px;border:none;border-radius:6px;background:#22c55e;color:white;cursor:pointer}
.search{padding:8px;width:300px;margin-bottom:10px}

/* tombol kembali */
.kembali{
  background:#3b82f6;
  margin-bottom:15px;
  display:inline-block;
}
.kembali:hover{
  background:#2563eb;
}

/* ===== MODAL ===== */
.modal{display:none;position:fixed;top:0;left:0;width:100%;height:100%;
background:rgba(0,0,0,.4)}
.modal-box{background:white;width:400px;margin:80px auto;padding:20px;border-radius:10px}
.close{float:right;cursor:pointer;color:red;font-weight:bold}
</style>
</head>
<body>

<!-- ===== TOMBOL KEMBALI ===== -->
<a href="dashboard.php" class="btn kembali">⬅ Kembali</a>

<h2>📦 Data Pakaian</h2>

<div class="card">
<input type="text" id="search" class="search" placeholder="Cari pakaian...">

<table id="tabel">
<tr>
<th>#</th>
<th>Nama</th>
<th>Harga</th>
<th>Aksi</th>
</tr>

<?php $no=1; while($p=mysqli_fetch_assoc($q)){ ?>
<tr>
<td><?= $no++ ?></td>
<td><?= $p['nama_pakaian'] ?></td>
<td>Rp <?= number_format($p['harga']) ?></td>
<td>
  <button class="btn btn-detail"
    onclick="detail(
      '<?= $p['nama_pakaian'] ?>',
      '<?= number_format($p['harga']) ?>',
      '<?= $p['keterangan'] ?>'
    )">
    Detail
  </button>
  <a href="#edit<?= $p['id'] ?>" class="btn btn-edit">Edit</a>
  <a href="?hapus=<?= $p['id'] ?>" class="btn btn-hapus"
     onclick="return confirm('Yakin hapus?')">Hapus</a>
</td>
</tr>
<?php } ?>
</table>
</div>

<!-- ================= TAMBAH ================= -->
<div class="card">
<h3>Tambah Pakaian</h3>
<form method="post">
<input type="text" name="nama" placeholder="Nama Pakaian" required>
<input type="number" name="harga" placeholder="Harga" required>
<textarea name="keterangan" placeholder="Keterangan"></textarea>
<button name="tambah">Simpan</button>
</form>
</div>

<!-- ================= EDIT ================= -->
<?php
$q2=mysqli_query($conn,"SELECT * FROM pakaian");
while($e=mysqli_fetch_assoc($q2)){ ?>
<div class="card" id="edit<?= $e['id'] ?>">
<h3>Edit: <?= $e['nama_pakaian'] ?></h3>
<form method="post">
<input type="hidden" name="id" value="<?= $e['id'] ?>">
<input type="text" name="nama" value="<?= $e['nama_pakaian'] ?>" required>
<input type="number" name="harga" value="<?= $e['harga'] ?>" required>
<textarea name="keterangan"><?= $e['keterangan'] ?></textarea>
<button name="edit">Update</button>
<a href="pakaian.php" class="btn kembali">Batal</a>
</form>
</div>
<?php } ?>

<!-- ================= MODAL DETAIL + PRINT ================= -->
<div class="modal" id="modal">
  <div class="modal-box" id="printArea">
    <span class="close" onclick="tutup()">X</span>
    <h3 id="dNama"></h3>
    <p><b>Harga:</b> Rp <span id="dHarga"></span></p>
    <p><b>Keterangan:</b></p>
    <p id="dKet"></p>

    <hr>
    <button onclick="printDetail()" style="
      background:#2563eb;
      color:white;
      border:none;
      padding:8px 14px;
      border-radius:6px;
      cursor:pointer;
      margin-top:10px
    ">
      🖨 Print Detail
    </button>
  </div>
</div>

<script>
// ===== DETAIL MODAL =====
function detail(n,h,k){
  dNama.innerText = n;
  dHarga.innerText = h;
  dKet.innerText = k || '-';
  modal.style.display = 'block';
}
function tutup(){
  modal.style.display = 'none';
}

// ===== SEARCH =====
document.getElementById("search").onkeyup = function(){
  let v = this.value.toLowerCase();
  document.querySelectorAll("#tabel tr").forEach((r,i)=>{
    if(i>0) r.style.display = r.innerText.toLowerCase().includes(v) ? '' : 'none';
  });
}

// ===== PRINT DETAIL =====
function printDetail(){
  let isi = document.getElementById("printArea").innerHTML;
  let win = window.open('', '', 'width=800,height=600');
  win.document.write(`
    <html>
    <head>
      <title>Detail Pakaian</title>
      <style>
        body{font-family:Arial;padding:20px}
        h3{text-align:center}
        hr{margin:15px 0}
      </style>
    </head>
    <body>${isi}</body>
    </html>
  `);
  win.document.close();
  win.focus();
  win.print();
  win.close();
}
</script>

</body>
</html>
