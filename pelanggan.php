<?php
session_start();
include 'koneksi.php';
?>

<!DOCTYPE html>
<html>
<head>
  <title>Transaksi Laundry</title>
  <style>
    body { font-family: Arial, sans-serif; background:#f2f4f7; margin:0; padding:0; }
    .navbar { background:#1f2937; padding:15px; color:white; }
    .navbar a { color:white; text-decoration:none; margin-right:15px; }
    .container { padding:20px; }
    .card { background:white; padding:20px; border-radius:8px; box-shadow:0 2px 5px rgba(0,0,0,.1); max-width:600px; margin:auto; }
    input, select { width:100%; padding:8px; margin:5px 0 15px; border-radius:5px; border:1px solid #ccc; }
    button { background:#22c55e; color:white; padding:10px 15px; border:none; border-radius:5px; cursor:pointer; margin-right:10px; }
    button:hover { opacity:0.85; }
    label { font-weight:bold; }
  </style>
</head>
<body>

<div class="navbar">
  <a href="dashboard.php">Dashboard</a>
</div>

<div class="container">
  <div class="card">
    <h3>Transaksi Laundry</h3>
    <form method="post" action="simpan_transaksi.php" id="formTransaksi">

      <label>Pelanggan</label>
      <select name="pelanggan_id" required>
        <option value="">-- Pilih Pelanggan --</option>
        <?php
        $q = mysqli_query($conn,"SELECT * FROM pelanggan");
        while($p = mysqli_fetch_assoc($q)){
            echo "<option value='".$p['id']."'>".$p['nama']."</option>";
        }
        ?>
      </select>

      <label>Jenis Pakaian</label>
      <select name="jenis_pakaian" required>
        <option value="">-- Pilih Jenis Pakaian --</option>
        <option value="Baju">Baju</option>
        <option value="Celana">Celana</option>
        <option value="Selimut">Selimut</option>
      </select>

      <label>Paket Laundry</label>
      <select name="paket_id" id="paketSelect" required>
        <option value="">-- Pilih Paket --</option>
        <option value="1">Cuci Kering</option>
        <option value="2">Cuci Setrika</option>
        <option value="3">Express</option>
      </select>

      <label>Berat (Kg)</label>
      <input type="number" step="0.1" name="berat" id="beratInput" required>

      <label>Diskon (%)</label>
      <input type="number" name="diskon" id="diskonInput" value="0">

      <label>Tanggal Masuk</label>
      <input type="date" name="tgl_masuk" value="<?= date('Y-m-d') ?>" required>

      <label>Tanggal Selesai</label>
      <input type="date" name="tgl_selesai" required>

      <label>Total Harga</label>
      <input type="text" name="total" id="total" readonly>

      <p id="hargaPaket">Harga Paket: Rp 0</p>

      <button type="submit">Proses</button>
      <button type="reset">Reset</button>
    </form>
  </div>
</div>

<script>
// Harga paket
const paket = {1:20000, 2:30000, 3:50000};
const paketSelect = document.getElementById('paketSelect');
const beratInput = document.getElementById('beratInput');
const diskonInput = document.getElementById('diskonInput');
const totalInput = document.getElementById('total');
const hargaDisplay = document.getElementById('hargaPaket');

function hitungTotal() {
    const paketVal = parseInt(paketSelect.value) || 0;
    const berat = parseFloat(beratInput.value) || 0;
    const diskon = parseFloat(diskonInput.value) || 0;
    const harga = paket[paketVal] || 0;
    const total = (berat * harga) - ((berat * harga) * (diskon/100));
    totalInput.value = total > 0 ? total : 0;
    hargaDisplay.textContent = "Harga Paket: Rp " + harga;
}

// Event listeners
paketSelect.addEventListener('change', hitungTotal);
beratInput.addEventListener('input', hitungTotal);
diskonInput.addEventListener('input', hitungTotal);

// Validasi form
document.getElementById('formTransaksi').addEventListener('submit', function(e){
    if(!this.pelanggan_id.value || !this.jenis_pakaian.value || !this.paket_id.value || !this.berat.value){
        alert("Lengkapi semua form!");
        e.preventDefault();
    }
});
</script>

</body>
</html>
