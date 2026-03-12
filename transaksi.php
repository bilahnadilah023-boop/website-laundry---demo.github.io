<?php
session_start();
include 'koneksi.php';

/* ================= SIMPAN ================= */
if(isset($_POST['simpan'])){
    $paket_id = intval($_POST['paket_id']);
    $berat = floatval($_POST['berat']);
    $total = floatval($_POST['total']);
    $diskon = floatval($_POST['diskon']);
    $tgl_masuk = $_POST['tgl_masuk'];

    if($paket_id && $berat > 0){
        $sql = "INSERT INTO transaksi (paket_id, berat, total, diskon, status, tgl_masuk)
                VALUES ('$paket_id','$berat','$total','$diskon','Diproses','$tgl_masuk')";
        mysqli_query($conn,$sql);
        header("location:transaksi.php");
        exit;
    }
}

/* ================= UPDATE ================= */
if(isset($_POST['update'])){
    $id = intval($_POST['id']);
    $paket_id = intval($_POST['paket_id']);
    $berat = floatval($_POST['berat']);
    $total = floatval($_POST['total']);
    $diskon = floatval($_POST['diskon']);
    $tgl_masuk = $_POST['tgl_masuk'];

    mysqli_query($conn,"UPDATE transaksi SET
        paket_id='$paket_id',
        berat='$berat',
        total='$total',
        diskon='$diskon',
        tgl_masuk='$tgl_masuk'
        WHERE id='$id'");

    header("location:transaksi.php");
    exit;
}

/* ================= HAPUS ================= */
if(isset($_GET['hapus'])){
    $id = intval($_GET['hapus']);
    mysqli_query($conn,"DELETE FROM transaksi WHERE id='$id'");
    header("location:transaksi.php");
    exit;
}

/* ================= EDIT ================= */
$edit = null;
if(isset($_GET['edit'])){
    $id = intval($_GET['edit']);
    $edit = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM transaksi WHERE id='$id'"));
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Transaksi Laundry</title>

<style>

body{
font-family:Arial;
background:#f3f4f6;
margin:0;
}

.navbar{
background:#2563eb;
padding:15px;
}

.navbar a{
color:white;
text-decoration:none;
font-weight:bold;
}

.container{
padding:20px;
}

.card{
background:white;
padding:20px;
border-radius:10px;
margin-bottom:20px;
}

input,select,button{
padding:10px;
margin-top:8px;
width:100%;
}

button{
background:#22c55e;
color:white;
border:none;
border-radius:6px;
cursor:pointer;
}

table{
width:100%;
border-collapse:collapse;
margin-top:20px;
}

th,td{
padding:10px;
border-bottom:1px solid #e5e7eb;
text-align:center;
}

th{
background:#f9fafb;
}

.badge{
padding:4px 8px;
border-radius:5px;
color:white;
font-size:12px;
}

.badge-proses{
background:#f59e0b;
}

.badge-selesai{
background:#16a34a;
}

.btn{
padding:6px 10px;
border-radius:5px;
color:white;
text-decoration:none;
font-size:13px;
}

.btn-edit{
background:#eab308;
}

.btn-hapus{
background:#dc2626;
}

.btn-cetak{
background:#2563eb;
}

.total{
font-weight:bold;
margin-top:10px;
}

</style>

</head>

<body onload="hitung()">

<div class="navbar">
<a href="dashboard.php">⬅ Kembali</a>
</div>

<div class="container">

<!-- FORM -->
<div class="card">

<h3><?= $edit ? "Edit Transaksi" : "Transaksi Laundry" ?></h3>

<form method="post" onsubmit="hitung()">

<input type="hidden" name="id" value="<?= $edit['id'] ?? '' ?>">

<label>Tanggal Masuk</label>
<input type="date" name="tgl_masuk"
value="<?= $edit['tgl_masuk'] ?? date('Y-m-d') ?>" required>

<label>Berat (Kg)</label>
<input type="number" step="0.1" name="berat" id="berat"
value="<?= $edit['berat'] ?? 0 ?>" required onkeyup="hitung()">

<label>Paket</label>
<select name="paket_id" id="paket" required onchange="hitung()">

<option value="">-- Pilih Paket --</option>

<?php
$p = mysqli_query($conn,"SELECT * FROM paket");
while($d=mysqli_fetch_assoc($p)){
$selected = ($edit && $edit['paket_id']==$d['id']) ? "selected" : "";
?>

<option value="<?= $d['id'] ?>" data-harga="<?= $d['harga_per_kg'] ?>" <?= $selected ?>>
<?= $d['nama_paket'] ?> (Rp <?= number_format($d['harga_per_kg']) ?>/kg)
</option>

<?php } ?>

</select>

<div class="total">Diskon: Rp <span id="diskonText"><?= $edit['diskon'] ?? 0 ?></span></div>

<div class="total">Total: Rp <span id="totalText"><?= $edit['total'] ?? 0 ?></span></div>

<input type="hidden" name="total" id="total" value="<?= $edit['total'] ?? 0 ?>">
<input type="hidden" name="diskon" id="diskon" value="<?= $edit['diskon'] ?? 0 ?>">

<?php if($edit){ ?>
<button type="submit" name="update">Update Transaksi</button>
<?php } else { ?>
<button type="submit" name="simpan">Proses Transaksi</button>
<?php } ?>

</form>

</div>


<!-- RIWAYAT -->
<div class="card">

<h3>Riwayat Transaksi</h3>

<table>

<tr>
<th>Tanggal Masuk</th>
<th>Paket</th>
<th>Berat</th>
<th>Total</th>
<th>Status</th>
<th>Aksi</th>
</tr>

<?php

$q = mysqli_query($conn,"
SELECT t.*,p.nama_paket 
FROM transaksi t
LEFT JOIN paket p ON t.paket_id=p.id
ORDER BY t.id DESC
");

while($t=mysqli_fetch_assoc($q)){
?>

<tr>

<td><?= $t['tgl_masuk'] ?></td>

<td><?= $t['nama_paket'] ?></td>

<td><?= $t['berat'] ?> Kg</td>

<td>Rp <?= number_format($t['total']) ?></td>

<td>
<span class="badge <?= $t['status']=='Selesai'?'badge-selesai':'badge-proses' ?>">
<?= $t['status'] ?>
</span>
</td>

<td>

<a href="?edit=<?= $t['id'] ?>" class="btn btn-edit">Edit</a>

<a href="?hapus=<?= $t['id'] ?>" class="btn btn-hapus"
onclick="return confirm('Yakin hapus?')">Hapus</a>

<button
onclick="cetakPDF(
<?= $t['id'] ?>,
'<?= $t['nama_paket'] ?>',
<?= $t['berat'] ?>,
<?= $t['total'] ?>,
'<?= $t['tgl_masuk'] ?>'
)"
class="btn btn-cetak">Cetak</button>

</td>

</tr>

<?php } ?>

</table>

</div>

</div>


<script>

const beratInput = document.getElementById("berat");
const paketSelect = document.getElementById("paket");
const diskonText = document.getElementById("diskonText");
const totalText = document.getElementById("totalText");
const totalInput = document.getElementById("total");
const diskonInput = document.getElementById("diskon");

function hitung(){

let berat = parseFloat(beratInput.value) || 0;

let harga = paketSelect.options[paketSelect.selectedIndex]?.dataset.harga || 0;

let subtotal = berat * harga;

let diskon = berat >= 5 ? subtotal * 0.1 : 0;

let total = subtotal - diskon;

diskonText.innerText = diskon.toLocaleString();

totalText.innerText = total.toLocaleString();

totalInput.value = total;

diskonInput.value = diskon;

}


function cetakPDF(id,paket,berat,total,tgl){

let isi = `
STRUK LAUNDRY
====================
ID : ${id}
Tanggal : ${tgl}
Paket : ${paket}
Berat : ${berat} Kg
Total : Rp ${total.toLocaleString()}
`;

let win = window.open('', '', 'width=800,height=600');

win.document.write('<pre>'+isi+'</pre>');

win.document.close();

win.print();

}

</script>

</body>
</html>
