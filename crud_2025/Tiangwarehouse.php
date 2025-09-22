<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../Login Warehouse/index.php");
    exit;
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Koneksi DB
$koneksi = mysqli_connect("localhost", "root", "", "dbcrud2025");
if (!$koneksi) { die("Koneksi gagal: " . mysqli_connect_error()); }

$tanggal = $jenis_tiang = $keterangan = $jumlah = $jenis_keperluan = "";
$stok_akhir = 0;

// Simpan Data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tanggal = $_POST['tanggal'];
    $jenis_tiang = $_POST['jenis_tiang'];
    $keterangan = $_POST['keterangan'];
    $jumlah = (int)$_POST['jumlah'];
    $jenis_keperluan = $_POST['jenis_keperluan'];

    // Ambil stok terakhir
    $qStok = mysqli_query($koneksi, "SELECT stock_akhir FROM tb_tiang WHERE jenis_tiang='$jenis_tiang' ORDER BY id DESC LIMIT 1");
    $stok_akhir = 0;
    if ($qStok && mysqli_num_rows($qStok) > 0) {
        $row = mysqli_fetch_assoc($qStok);
        $stok_akhir = (int)$row['stock_akhir'];
    }

    // Update stok
    if ($jenis_keperluan == "Masuk") { $stok_akhir += $jumlah; } else { $stok_akhir -= $jumlah; }

    // Simpan transaksi
    $sql = "INSERT INTO tb_tiang (tanggal, jenis_tiang, keterangan, jumlah, jenis_keperluan, stock_akhir) 
            VALUES ('$tanggal','$jenis_tiang','$keterangan','$jumlah','$jenis_keperluan','$stok_akhir')";
    mysqli_query($koneksi, $sql);
}
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Manajemen Tiang Warehouse</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <style>
    body {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        font-family: 'Segoe UI', sans-serif;
        min-height: 100vh;
    }
    h2 { font-weight: bold; color: #fff; text-shadow: 2px 2px 8px rgba(0,0,0,0.5); }

    /* Stock Box */
    .stock-box {
        border-radius: 20px;
        padding: 25px;
        text-align: center;
        color: #fff;
        margin-bottom: 20px;
        backdrop-filter: blur(10px);
        background: rgba(255,255,255,0.1);
        border: 1px solid rgba(255,255,255,0.3);
        transition: all 0.3s;
    }
    .stock-box:hover { transform: translateY(-8px) scale(1.05); box-shadow: 0 10px 25px rgba(0,0,0,0.4); }
    .stock-box h4 { font-size: 22px; margin-bottom: 10px; }
    .stock-box p { font-size: 20px; font-weight: 600; }

    /* Form */
    .card {
        border-radius: 20px;
        background: rgba(255,255,255,0.95);
        box-shadow: 0 8px 25px rgba(0,0,0,0.2);
    }
    .form-control, .form-select { border-radius: 12px; }
    .btn-success {
        border-radius: 30px; font-weight: bold; padding: 10px 25px;
        transition: all 0.3s;
    }
    .btn-success:hover { transform: scale(1.05); }

    /* Table */
    thead { background: #2c3e50; color: #fff; }
    tbody tr:hover { background: #f8f9fa; transform: scale(1.01); transition: 0.2s; }

    /* Search */
    .search-box { margin-bottom: 15px; }
  </style>
</head>
<body>
<div class="container-fluid py-4">

  <!-- Header -->
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fa-solid fa-warehouse me-2"></i>Manajemen Tiang Warehouse</h2>
    <a href="indexmenu.php" class="btn btn-dark shadow-lg"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
  </div>

  <!-- Stock -->
  <div class="row mb-4">
    <?php
    $jenisList = ["7M 4D","7M 3D","9M 4D"];
    $icons = ["7M 4D"=>"fa-ruler-combined","7M 3D"=>"fa-ruler","9M 4D"=>"fa-building"];
    foreach ($jenisList as $j) {
        $qStok = mysqli_query($koneksi, "SELECT stock_akhir FROM tb_tiang WHERE jenis_tiang='$j' ORDER BY id DESC LIMIT 1");
        $stok = 0;
        if ($qStok && mysqli_num_rows($qStok) > 0) { $r = mysqli_fetch_assoc($qStok); $stok = $r['stock_akhir']; }
        echo "
        <div class='col-md-4'>
          <div class='stock-box'>
            <i class='fa-solid {$icons[$j]} fa-2x mb-2'></i>
            <h4>$j</h4>
            <p>Stok: $stok</p>
          </div>
        </div>";
    }
    ?>
  </div>

  <!-- Form Input -->
  <div class="card shadow-lg mb-4">
    <div class="card-header bg-primary text-white rounded-top"><i class="fa-solid fa-pen-to-square me-2"></i>Input Transaksi Tiang</div>
    <div class="card-body">
      <form method="post">
        <div class="row mb-3">
          <div class="col-md-4">
            <label class="form-label">Tanggal</label>
            <input type="date" name="tanggal" class="form-control" required>
          </div>
          <div class="col-md-4">
            <label class="form-label">Jenis Tiang</label>
            <select name="jenis_tiang" class="form-select" required>
              <option value=""></option>
              <option value="7M 4D">7M 4D</option>
              <option value="7M 3D">7M 3D</option>
              <option value="9M 4D">9M 4D</option>
            </select>
          </div>
          <div class="col-md-4">
            <label class="form-label">Jumlah</label>
            <input type="number" name="jumlah" class="form-control" required>
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-md-6">
            <label class="form-label">Jenis Keperluan</label>
            <select id="jenis_keperluan" name="jenis_keperluan" class="form-select" required onchange="updateKeterangan()">
              <option value=""></option>
              <option value="Masuk">Masuk</option>
              <option value="Keluar">Keluar</option>
            </select>
          </div>
          <div class="col-md-6">
            <label class="form-label">Keterangan</label>
            <select id="keterangan" name="keterangan" class="form-select" required>
              <option value=""></option>
            </select>
          </div>
        </div>
        <div class="text-end">
          <button type="submit" class="btn btn-success shadow-lg"><i class="fa-solid fa-save me-2"></i>Simpan</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Riwayat -->
  <div class="card shadow-lg">
    <div class="card-header bg-dark text-white rounded-top"><i class="fa-solid fa-clock-rotate-left me-2"></i>Riwayat Transaksi</div>
    <div class="card-body">
      <!-- Search -->
      <div class="search-box d-flex justify-content-end">
        <input type="text" id="searchInput" class="form-control w-25" placeholder="🔎 Cari transaksi...">
      </div>
      <div class="table-responsive">
        <table class="table table-bordered table-hover text-center">
          <thead>
            <tr>
              <th>Tanggal</th>
              <th>Jenis Tiang</th>
              <th>Jenis Keperluan</th>
              <th>Keterangan</th>
              <th>Jumlah</th>
              <th>Stok Akhir</th>
            </tr>
          </thead>
          <tbody>
          <?php
          $qRiwayat = mysqli_query($koneksi, "SELECT * FROM tb_tiang ORDER BY id DESC");
          if ($qRiwayat && mysqli_num_rows($qRiwayat) > 0) {
              while ($row = mysqli_fetch_assoc($qRiwayat)) {
                  echo "<tr>
                          <td>{$row['tanggal']}</td>
                          <td>{$row['jenis_tiang']}</td>
                          <td>{$row['jenis_keperluan']}</td>
                          <td>{$row['keterangan']}</td>
                          <td>{$row['jumlah']}</td>
                          <td>{$row['stock_akhir']}</td>
                        </tr>";
              }
          } else {
              echo "<tr><td colspan='6'>Belum ada transaksi</td></tr>";
          }
          ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script>
function updateKeterangan() {
    let jenis = document.getElementById("jenis_keperluan").value;
    let keterangan = document.getElementById("keterangan");
    keterangan.innerHTML = "";
    if (jenis === "Masuk") {
        let opt = document.createElement("option");
        opt.value = "Bengkel Sabar"; opt.text = "Bengkel Sabar"; keterangan.add(opt);
    } else if (jenis === "Keluar") {
        let lokasi = ["Bumiaji","Temas","Junrejo","Ambarawa","Sabililah","Pakis","Pasuruan"];
        lokasi.forEach(function(l){ let opt=document.createElement("option"); opt.value=l; opt.text=l; keterangan.add(opt); });
    }
}

// Filter Search
document.getElementById("searchInput").addEventListener("keyup", function() {
  let filter = this.value.toLowerCase();
  let rows = document.querySelectorAll("tbody tr");
  rows.forEach(row => {
    let text = row.innerText.toLowerCase();
    row.style.display = text.includes(filter) ? "" : "none";
  });
});
</script>
</body>
</html>
