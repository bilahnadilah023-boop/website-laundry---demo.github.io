<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html>
<head>
  <title>Paket Laundry</title>
  <style>
    body{font-family:Arial;background:#f3f4f6;margin:0}
    .navbar{background:#2563eb;padding:15px}
    .navbar a{color:white;text-decoration:none;font-weight:bold}
    .container{padding:20px}
    .card{background:white;padding:20px;border-radius:8px}
    table{width:100%;border-collapse:collapse;margin-top:15px}
    th,td{padding:10px;border-bottom:1px solid #e5e7eb}
    th{background:#f9fafb}
    .btn{padding:6px 12px;border-radius:5px;text-decoration:none;font-size:13px}
    .btn-add{background:#22c55e;color:white}
    .btn-edit{background:#f59e0b;color:white}
    .btn-del{background:#ef4444;color:white}
    input{padding:8px;width:100%;margin-top:5px}
  </style>
</head>
<body>

<div class="navbar">
  <a href="dashboard.php">⬅ Dashboard</a>
</div>

<div class="container">

  <!-- TAMBAH PAKET -->
  <div class="card">
    <h3>Tambah Paket</h3>
    <form method="post">
      <input type="text" name="nama" placeholder="Nama Paket" required>
      <input type="number" name="harga" placeholder="Harga / Kg" required>
      <input type="number" name="durasi" placeholder="Durasi (hari)" required>
      <button class="btn btn-add" name="tambah">Tambah Paket</button>
    </form>
  </div>

  <br>

  <!-- DATA PAKET -->
  <div class="card">
    <h3>Data Paket</h3>

    <input type="text" id="search" placeholder="Cari paket..." onkeyup="cariPaket()">

    <table id="tabelPaket">
      <tr>
        <th>Nama</th>
        <th>Harga / Kg</th>
        <th>Durasi</th>
        <th>Aksi</th>
      </tr>

      <?php
      if(isset($_POST['tambah'])){
        mysqli_query($conn,"INSERT INTO paket VALUES(
          NULL,'$_POST[nama]','$_POST[harga]','$_POST[durasi]'
        )");
        echo "<script>location='paket.php'</script>";
      }

      $q = mysqli_query($conn,"SELECT * FROM paket");
      while($d=mysqli_fetch_assoc($q)){
      ?>
      <tr>
        <td><?= $d['nama_paket'] ?></td>
        <td>Rp <?= number_format($d['harga_per_kg']) ?></td>
        <td><?= $d['durasi_hari'] ?> hari</td>
        <td>
          <a href="edit_paket.php?id=<?= $d['id'] ?>" class="btn btn-edit">Edit</a>
          <a href="hapus_paket.php?id=<?= $d['id'] ?>" 
             class="btn btn-del"
             onclick="return confirm('Hapus paket?')">
             Hapus
          </a>
        </td>
      </tr>
      <?php } ?>
    </table>
  </div>
</div>

<script>
function cariPaket(){
  let input = document.getElementById("search").value.toLowerCase();
  let rows = document.querySelectorAll("#tabelPaket tr");

  for(let i=1;i<rows.length;i++){
    let text = rows[i].innerText.toLowerCase();
    rows[i].style.display = text.includes(input) ? "" : "none";
  }
}
</script>

</body>
</html>
