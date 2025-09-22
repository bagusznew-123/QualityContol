<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../Login%20Warehouse/index.php");
    exit;
}

// Aktifkan debug
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Koneksi Database
$koneksi = mysqli_connect("localhost", "root", "", "dbcrud2025");
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Variabel form
$vPeriode = $vTanggal = $vSerial = $vRedamanModem = $vRedamanOPM = $vSelisih = $vSettingan = $vValidator = "";
$id_edit = "";
$mode_edit = false;

// Fungsi untuk mengirim data ke Google Apps Script Web App
function sendToGoogleSheet($data) {
    $url = "https://script.google.com/macros/s/AKfycbyCdZgALniMNy0Hxw17kjr4m20mgLgQa_OngEEozdpqyfNloa0_RRVzt4Y1CUxVr1gr/exec";
    
    // Pastikan urutan parameter sesuai dengan yang diharapkan Google Apps Script
    $params = array(
        'action' => $data['action'],
        'Periode_Modem' => isset($data['Periode_Modem']) ? $data['Periode_Modem'] : '',
        'Tanggal' => isset($data['Tanggal']) ? $data['Tanggal'] : '',
        'SerialModem' => isset($data['SerialModem']) ? $data['SerialModem'] : '',
        'RedamanModem' => isset($data['RedamanModem']) ? $data['RedamanModem'] : '',
        'RedamanOPM' => isset($data['RedamanOPM']) ? $data['RedamanOPM'] : '',
        'SelisihRedaman' => isset($data['SelisihRedaman']) ? $data['SelisihRedaman'] : '',
        'Settingan' => isset($data['Settingan']) ? $data['Settingan'] : '',
        'Validator' => isset($data['Validator']) ? $data['Validator'] : ''
    );

    $options = array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($params),
            'ignore_errors' => true,
            'timeout' => 10 // Timeout 10 detik
        )
    );

    $context = stream_context_create($options);
    
    // Log data yang dikirim
    error_log("Mengirim data ke Google Sheet: " . print_r($params, true));
    
    $result = @file_get_contents($url, false, $context);

    if ($result === FALSE) {
        $error = error_get_last();
        error_log("Gagal mengirim data ke Google Sheet: " . $error['message']);
        return false;
    }

    error_log("Response dari Google Sheet: " . $result);
    
    $decoded = json_decode($result, true);
    return isset($decoded["status"]) && $decoded["status"] === "success";
}

// === EDIT MODE - Ambil data untuk diedit ===
if (isset($_GET['hal']) && $_GET['hal'] == "edit" && isset($_GET['id'])) {
    $id_edit = $_GET['id'];
    $query_edit = mysqli_query($koneksi, "SELECT * FROM tbarang WHERE id_barang='$id_edit'");
    
    if ($query_edit && mysqli_num_rows($query_edit) > 0) {
        $data_edit = mysqli_fetch_array($query_edit);
        $vPeriode = $data_edit['Periode_Modem'];
        $vTanggal = $data_edit['Tanggal'];
        $vSerial = $data_edit['SerialModem'];
        $vRedamanModem = $data_edit['RedamanModem'];
        $vRedamanOPM = $data_edit['RedamanOPM'];
        $vSelisih = $data_edit['SelisihRedaman'];
        $vSettingan = $data_edit['Settingan'];
        $vValidator = $data_edit['Validator'];
        $mode_edit = true;
    }
}

// === SIMPAN / UPDATE ===
if (isset($_POST['bsimpan'])) {
    // Bersihkan dan validasi input
    $vPeriode = mysqli_real_escape_string($koneksi, $_POST['tperiode']);
    $vTanggal = mysqli_real_escape_string($koneksi, $_POST['ttanggal']);
    $vSerial = mysqli_real_escape_string($koneksi, $_POST['tserial']);
    $vRedamanModem = (float)$_POST['tredamanmodem'];
    $vRedamanOPM = (float)$_POST['tredamanopm'];
    $vSelisih = round($vRedamanModem - $vRedamanOPM, 2);
    $vSettingan = mysqli_real_escape_string($koneksi, $_POST['tsettingan']);
    $vValidator = mysqli_real_escape_string($koneksi, $_POST['tvalidator']);

    if (isset($_GET['hal']) && $_GET['hal'] == "edit" && isset($_GET['id'])) {
        // Update data
        $id_edit = $_GET['id'];
        $ubah = mysqli_query($koneksi, "UPDATE tbarang SET
                                        Periode_Modem='$vPeriode',
                                        Tanggal='$vTanggal',
                                        SerialModem='$vSerial',
                                        RedamanModem='$vRedamanModem',
                                        RedamanOPM='$vRedamanOPM',
                                        SelisihRedaman='$vSelisih',
                                        Settingan='$vSettingan',
                                        Validator='$vValidator'
                                        WHERE id_barang='$id_edit' ");
        if ($ubah) {
            // Data untuk dikirim ke Google Sheet
            $sheetData = array(
                'action' => 'update',
                'Periode_Modem' => $vPeriode,
                'Tanggal' => $vTanggal,
                'SerialModem' => $vSerial,
                'RedamanModem' => $vRedamanModem,
                'RedamanOPM' => $vRedamanOPM,
                'SelisihRedaman' => $vSelisih,
                'Settingan' => $vSettingan,
                'Validator' => $vValidator
            );
            
            // Kirim ke Google Sheet
            $sheetResult = sendToGoogleSheet($sheetData);
            
            if ($sheetResult) {
                echo "<script>alert('✏️ Data berhasil diubah dan disinkronisasi ke spreadsheet!');document.location='GriyaNet.php';</script>";
            } else {
                echo "<script>alert('✏️ Data berhasil diubah di database lokal, tetapi gagal disinkronisasi ke spreadsheet.');document.location='GriyaNet.php';</script>";
            }
        } else {
            echo "<script>alert('❌ Gagal mengubah data!');</script>";
        }
    } else {
        // Insert data baru
        $simpan = mysqli_query($koneksi, "INSERT INTO tbarang 
            (Periode_Modem, Tanggal, SerialModem, RedamanModem, RedamanOPM, SelisihRedaman, Settingan, Validator)
            VALUES (
                '$vPeriode',
                '$vTanggal',
                '$vSerial',
                '$vRedamanModem',
                '$vRedamanOPM',
                '$vSelisih',
                '$vSettingan',
                '$vValidator'
            )");

        if ($simpan) {
            // Data untuk dikirim ke Google Sheet
            $sheetData = array(
                'action' => 'insert',
                'Periode_Modem' => $vPeriode,
                'Tanggal' => $vTanggal,
                'SerialModem' => $vSerial,
                'RedamanModem' => $vRedamanModem,
                'RedamanOPM' => $vRedamanOPM,
                'SelisihRedaman' => $vSelisih,
                'Settingan' => $vSettingan,
                'Validator' => $vValidator
            );
            
            // Kirim ke Google Sheet
            $sheetResult = sendToGoogleSheet($sheetData);
            
            if ($sheetResult) {
                echo "<script>alert('✅ Data berhasil disimpan dan disinkronisasi ke spreadsheet!');document.location='GriyaNet.php';</script>";
            } else {
                echo "<script>alert('✅ Data berhasil disimpan di database lokal, tetapi gagal disinkronisasi ke spreadsheet.');document.location='GriyaNet.php';</script>";
            }
        } else {
            echo "<script>alert('❌ Gagal menyimpan data!');</script>";
        }
    }
}

// === HAPUS ===
if (isset($_GET['hal']) && $_GET['hal'] == "hapus") {
    $id_hapus = $_GET['id'];
    
    // Ambil data sebelum dihapus untuk dikirim ke spreadsheet
    $query_hapus_data = mysqli_query($koneksi, "SELECT * FROM tbarang WHERE id_barang='$id_hapus'");
    $data_hapus = mysqli_fetch_array($query_hapus_data);
    
    $hapus = mysqli_query($koneksi, "DELETE FROM tbarang WHERE id_barang='$id_hapus' ");
    if ($hapus) {
        // Data untuk dikirim ke Google Sheet
        $sheetData = array(
            'action' => 'delete',
            'Periode_Modem' => $data_hapus['Periode_Modem'],
            'Tanggal' => $data_hapus['Tanggal'],
            'SerialModem' => $data_hapus['SerialModem'],
            'RedamanModem' => $data_hapus['RedamanModem'],
            'RedamanOPM' => $data_hapus['RedamanOPM'],
            'SelisihRedaman' => $data_hapus['SelisihRedaman'],
            'Settingan' => $data_hapus['Settingan'],
            'Validator' => $data_hapus['Validator']
        );
        
        // Kirim ke Google Sheet
        $sheetResult = sendToGoogleSheet($sheetData);
        
        if ($sheetResult) {
            echo "<script>alert('🗑️ Data berhasil dihapus dan disinkronisasi ke spreadsheet!');document.location='GriyaNet.php';</script>";
        } else {
            echo "<script>alert('🗑️ Data berhasil dihapus dari database lokal, tetapi gagal disinkronisasi ke spreadsheet.');document.location='GriyaNet.php';</script>";
        }
    }
}

// Query data
$tampil_data = mysqli_query($koneksi, "SELECT * FROM tbarang ORDER BY id_barang DESC");
$jumlah_data = mysqli_num_rows($tampil_data);
?>

<?php
// ... (kode PHP tetap sama seperti sebelumnya)
?>

<?php
// ... (kode PHP tetap sama seperti sebelumnya)
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Warehouse Modem - GriyaNet Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root {
      --primary-color: #3a5ec7;
      --secondary-color: #4e73df;
      --accent-color: #6f42c1;
      --light-bg: #f8f9fa;
      --card-shadow: 0 4px 20px rgba(0,0,0,0.08);
      --gradient-start: #4e73df;
      --gradient-end: #224abe;
    }
    
    body {
      background-color: #f5f7fb;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      color: #444;
    }
    
    .main-container {
      padding: 20px;
      min-height: 100vh;
    }
    
    .header {
      background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
      color: white;
      padding: 15px 25px;
      border-radius: 12px;
      margin-bottom: 25px;
      box-shadow: var(--card-shadow);
    }
    
    .content-wrapper {
      display: grid;
      grid-template-columns: 1fr 2fr;
      gap: 25px;
    }
    
    .form-section {
      background: white;
      border-radius: 12px;
      padding: 20px;
      box-shadow: var(--card-shadow);
      height: fit-content;
    }
    
    .table-section {
      background: white;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: var(--card-shadow);
    }
    
    .form-title {
      color: var(--primary-color);
      padding-bottom: 12px;
      margin-bottom: 20px;
      font-size: 1.2rem;
      font-weight: 600;
      display: flex;
      align-items: center;
      border-bottom: 2px solid #e3e6f0;
    }
    
    .badge-count {
      background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
      color: white;
      padding: 5px 12px;
      border-radius: 50px;
      font-size: 0.85rem;
      font-weight: 500;
    }
    
    .action-buttons {
      display: flex;
      gap: 6px;
      justify-content: center;
    }
    
    .form-control, .form-select {
      border-radius: 8px;
      padding: 10px 15px;
      border: 1px solid #d1d3e2;
      font-size: 0.9rem;
    }
    
    .form-control:focus {
      border-color: var(--accent-color);
      box-shadow: 0 0 0 0.25rem rgba(78, 115, 223, 0.25);
    }
    
    .btn {
      border-radius: 8px;
      padding: 10px 15px;
      font-weight: 500;
      transition: all 0.2s ease;
    }
    
    .btn-success {
      background: linear-gradient(135deg, #1cc88a, #17a673);
      border: none;
    }
    
    .btn-success:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(28, 200, 138, 0.3);
    }
    
    .btn-secondary {
      background: linear-gradient(135deg, #858796, #60616f);
      border: none;
    }
    
    .btn-danger {
      background: linear-gradient(135deg, #e74a3b, #be2617);
      border: none;
    }
    
    .table th {
      background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
      color: white;
      font-weight: 500;
      padding: 12px 15px;
      font-size: 0.9rem;
    }
    
    .table td {
      padding: 12px 15px;
      vertical-align: middle;
    }
    
    .table-hover tbody tr:hover {
      background-color: rgba(78, 115, 223, 0.05);
    }
    
    .card-header {
      background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
      color: white;
      font-weight: 600;
      padding: 15px 20px;
    }
    
    @media (max-width: 992px) {
      .content-wrapper {
        grid-template-columns: 1fr;
      }
    }
    
    /* Animasi untuk form */
    .form-box {
      transition: all 0.3s ease;
    }
    
    /* Styling untuk input fields */
    .input-group {
      margin-bottom: 18px;
    }
    
    .input-group label {
      font-weight: 500;
      margin-bottom: 6px;
      color: #5a5c69;
      font-size: 0.9rem;
    }
    
    /* Custom scrollbar untuk tabel */
    .table-responsive::-webkit-scrollbar {
      height: 8px;
    }
    
    .table-responsive::-webkit-scrollbar-track {
      background: #f1f1f1;
      border-radius: 10px;
    }
    
    .table-responsive::-webkit-scrollbar-thumb {
      background: var(--secondary-color);
      border-radius: 10px;
    }
    
    /* Efek hover pada card */
    .form-section, .table-section {
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .form-section:hover, .table-section:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }
    
    /* Status indicator */
    .status-indicator {
      display: inline-block;
      width: 10px;
      height: 10px;
      border-radius: 50%;
      margin-right: 5px;
    }
    
    .status-active {
      background-color: #1cc88a;
    }
    
    /* Icon styling */
    .icon-container {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background: rgba(78, 115, 223, 0.1);
      display: flex;
      align-items: center;
      justify-content: center;
      margin-right: 10px;
    }
    
    .icon-container i {
      color: var(--primary-color);
    }
  </style>
</head>
<body>
<div class="main-container">
  <div class="header d-flex justify-content-between align-items-center">
    <div class="d-flex align-items-center">
      <div class="icon-container">
        <i class="fas fa-network-wired"></i>
      </div>
      <div>
        <h3 class="mb-0">GriyaNet Dashboard</h3>
        <p class="mb-0 opacity-75">Management Data Modem</p>
      </div>
    </div>
    <div class="d-flex align-items-center">
      <span class="badge-count me-3"><i class="fas fa-database me-1"></i> Total Data: <?php echo $jumlah_data; ?></span>
      <a href="indexmenu.php" class="btn btn-light btn-sm">
        <i class="fas fa-arrow-left me-2"></i>Kembali ke Menu
      </a>
    </div>
  </div>

  <div class="content-wrapper">
    <!-- Form Section (kiri) -->
    <div class="form-section">
      <h5 class="form-title">
        <i class="fas <?php echo $mode_edit ? 'fa-edit' : 'fa-plus'; ?> me-2"></i>
        <?php echo $mode_edit ? 'Edit Data Modem' : 'Tambah Data Baru'; ?>
      </h5>
      <form method="post" id="formInput">
        <div class="mb-3">
          <label class="form-label">Periode Modem</label>
          <input type="text" name="tperiode" value="<?= $vPeriode ?>" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Tanggal</label>
          <input type="date" name="ttanggal" 
                 value="<?= $vTanggal ?: date('Y-m-d') ?>" 
                 class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Serial Modem</label>
          <input type="text" name="tserial" value="<?= $vSerial ?>" class="form-control" required>
        </div>
        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label">Redaman Modem</label>
            <input type="number" step="0.01" name="tredamanmodem" value="<?= $vRedamanModem ?>" class="form-control" required>
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label">Redaman OPM</label>
            <input type="number" step="0.01" name="tredamanopm" value="<?= $vRedamanOPM ?>" class="form-control" required>
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label">Settingan</label>
          <input type="text" name="tsettingan" value="<?= $vSettingan ?>" class="form-control">
        </div>
        <div class="mb-3">
          <label class="form-label">Validator</label>
          <input type="text" name="tvalidator" value="<?= $vValidator ?>" class="form-control">
        </div>
        <div class="mt-4 d-grid gap-2">
          <button type="submit" class="btn btn-success" name="bsimpan">
            <i class="fas fa-save me-2"></i><?php echo $mode_edit ? 'Update Data' : 'Simpan Data'; ?>
          </button>
          <button type="button" class="btn btn-secondary" onclick="resetForm()">
            <i class="fas fa-times me-2"></i>Batalkan
          </button>
        </div>
      </form>
    </div>

    <!-- Table Section (kanan) -->
    <div class="table-section">
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <span><i class="fas fa-table me-2"></i>Data Tersimpan</span>
          <span class="badge bg-light text-dark"><?php echo $jumlah_data; ?> records</span>
        </div>
        <div class="card-body">
          <div class="table-responsive" style="max-height: 600px; overflow-y: auto;">
            <table class="table table-hover">
              <thead style="position: sticky; top: 0; z-index: 1;">
                <tr class="text-center">
                  <th>No</th>
                  <th>Periode</th>
                  <th>Tanggal</th>
                  <th>Serial</th>
                  <th>R. Modem</th>
                  <th>R. OPM</th>
                  <th>Selisih</th>
                  <th>Settingan</th>
                  <th>Validator</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if ($jumlah_data > 0) {
                  $no = 1;
                  while ($data = mysqli_fetch_array($tampil_data)) :
                ?>
                <tr>
                  <td class="text-center"><?= $no++ ?></td>
                  <td><?= $data['Periode_Modem'] ?></td>
                  <td><?= date('d M Y', strtotime($data['Tanggal'])) ?></td>
                  <td><span class="badge bg-light text-dark"><?= $data['SerialModem'] ?></span></td>
                  <td class="text-center"><?= $data['RedamanModem'] ?></td>
                  <td class="text-center"><?= $data['RedamanOPM'] ?></td>
                  <td class="text-center fw-bold" style="color: <?= ($data['SelisihRedaman'] > 0) ? '#1cc88a' : '#e74a3b' ?>">
                    <?= $data['SelisihRedaman'] ?>
                  </td>
                  <td><?= $data['Settingan'] ?></td>
                  <td><?= $data['Validator'] ?></td>
                  <td class="text-center">
                    <div class="action-buttons">
                      <a href="GriyaNet.php?hal=edit&id=<?= $data['id_barang'] ?>" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i>
                      </a>
                      <a href="GriyaNet.php?hal=hapus&id=<?= $data['id_barang'] ?>" 
                         onclick="return confirm('Yakin mau hapus data ini?')" 
                         class="btn btn-danger btn-sm">
                        <i class="fas fa-trash"></i>
                      </a>
                    </div>
                  </td>
                </tr>
                <?php 
                  endwhile;
                } else {
                ?>
                <tr>
                  <td colspan="10" class="text-center py-5">
                    <i class="fas fa-inbox fs-1 text-muted mb-3 d-block"></i>
                    <p class="text-muted">Tidak ada data ditemukan</p>
                    <a href="#" class="btn btn-primary btn-sm" onclick="document.getElementById('formInput').scrollIntoView()">
                      <i class="fas fa-plus me-1"></i>Tambah Data
                    </a>
                  </td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
function resetForm() {
  document.getElementById("formInput").reset();
}

// Animasi untuk elemen form
document.addEventListener('DOMContentLoaded', function() {
  const formSection = document.querySelector('.form-section');
  formSection.style.transform = 'translateY(20px)';
  formSection.style.opacity = '0';
  
  setTimeout(() => {
    formSection.style.transition = 'transform 0.5s ease, opacity 0.5s ease';
    formSection.style.transform = 'translateY(0)';
    formSection.style.opacity = '1';
  }, 100);
});
</script>
</body>
</html>