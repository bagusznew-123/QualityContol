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
    $query_edit = mysqli_query($koneksi, "SELECT * FROM qc_kiosnet WHERE id_barang='$id_edit'");
    
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
        $ubah = mysqli_query($koneksi, "UPDATE qc_kiosnet SET
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
                echo "<script>alert('✏️ Data berhasil diubah dan disinkronisasi ke spreadsheet!');document.location='KiosNet.php';</script>";
            } else {
                echo "<script>alert('✏️ Data berhasil diubah di database lokal, tetapi gagal disinkronisasi ke spreadsheet.');document.location='KiosNet.php';</script>";
            }
        } else {
            echo "<script>alert('❌ Gagal mengubah data!');</script>";
        }
    } else {
        // Insert data baru
        $simpan = mysqli_query($koneksi, "INSERT INTO qc_kiosnet 
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
                echo "<script>alert('✅ Data berhasil disimpan dan disinkronisasi ke spreadsheet!');document.location='KiosNet.php';</script>";
            } else {
                echo "<script>alert('✅ Data berhasil disimpan di database lokal, tetapi gagal disinkronisasi ke spreadsheet.');document.location='KiosNet.php';</script>";
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
    $query_hapus_data = mysqli_query($koneksi, "SELECT * FROM qc_kiosnet WHERE id_barang='$id_hapus'");
    $data_hapus = mysqli_fetch_array($query_hapus_data);
    
    $hapus = mysqli_query($koneksi, "DELETE FROM qc_kiosnet WHERE id_barang='$id_hapus' ");
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
            echo "<script>alert('🗑️ Data berhasil dihapus dan disinkronisasi ke spreadsheet!');document.location='KiosNet.php';</script>";
        } else {
            echo "<script>alert('🗑️ Data berhasil dihapus dari database lokal, tetapi gagal disinkronisasi ke spreadsheet.');document.location='KiosNet.php';</script>";
        }
    }
}

// Query data
$tampil_data = mysqli_query($koneksi, "SELECT * FROM qc_kiosnet ORDER BY id_barang DESC");
$jumlah_data = mysqli_num_rows($tampil_data);
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Warehouse Modem - KiosNet Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root {
      --primary-color: #2c3e50;
      --secondary-color: #34495e;
      --accent-color: #3498db;
      --success-color: #2ecc71;
      --warning-color: #f39c12;
      --danger-color: #e74c3c;
      --light-color: #ecf0f1;
      --dark-color: #2c3e50;
    }
    
    body {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: #333;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      min-height: 100vh;
      padding: 20px;
    }
    
    .main-container {
      background: rgba(255, 255, 255, 0.95);
      border-radius: 20px;
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
      overflow: hidden;
      backdrop-filter: blur(10px);
    }
    
    .header {
      background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
      color: white;
      padding: 25px;
      text-align: center;
      border-bottom: 5px solid var(--accent-color);
    }
    
    .header h3 {
      margin: 0;
      font-weight: 700;
      letter-spacing: 1px;
      text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
    }
    
    .content-wrapper {
      display: flex;
      padding: 0;
    }
    
    .form-section {
      background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
      padding: 25px;
      border-right: 2px dashed var(--accent-color);
      width: 350px;
      flex-shrink: 0;
    }
    
    .form-box {
      background: white;
      padding: 25px;
      border-radius: 15px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }
    
    .form-title {
      color: var(--primary-color);
      font-weight: 600;
      margin-bottom: 20px;
      text-align: center;
      border-bottom: 2px solid var(--accent-color);
      padding-bottom: 10px;
    }
    
    .form-label {
      font-weight: 600;
      color: var(--secondary-color);
      margin-bottom: 5px;
    }
    
    .form-control {
      border: 2px solid #ddd;
      border-radius: 8px;
      padding: 10px 15px;
      transition: all 0.3s;
    }
    
    .form-control:focus {
      border-color: var(--accent-color);
      box-shadow: 0 0 0 0.25rem rgba(52, 152, 219, 0.25);
    }
    
    .btn {
      border-radius: 8px;
      padding: 10px 15px;
      font-weight: 600;
      transition: all 0.3s;
      border: none;
    }
    
    .btn-success {
      background: linear-gradient(to right, var(--success-color), #27ae60);
    }
    
    .btn-secondary {
      background: linear-gradient(to right, #95a5a6, #7f8c8d);
    }
    
    .btn-danger {
      background: linear-gradient(to right, var(--danger-color), #c0392b);
    }
    
    .btn-warning {
      background: linear-gradient(to right, var(--warning-color), #e67e22);
    }
    
    .btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }
    
    .table-section {
      flex: 1;
      padding: 25px;
      overflow: auto;
    }
    
    .card {
      border: none;
      border-radius: 15px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
      overflow: hidden;
    }
    
    .card-header {
      background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
      color: white;
      font-weight: 600;
      padding: 15px 20px;
      border-bottom: 3px solid var(--accent-color);
    }
    
    .table {
      border-collapse: separate;
      border-spacing: 0;
      width: 100%;
    }
    
    .table th {
      background-color: var(--light-color);
      color: var(--dark-color);
      font-weight: 600;
      padding: 15px;
      border-bottom: 2px solid var(--accent-color);
    }
    
    .table td {
      padding: 15px;
      border-bottom: 1px solid #eee;
      vertical-align: middle;
    }
    
    .table tr:nth-child(even) {
      background-color: #f8f9fa;
    }
    
    .table tr:hover {
      background-color: #e8f4fc;
      transition: background-color 0.3s;
    }
    
    .action-buttons {
      display: flex;
      gap: 8px;
    }
    
    .btn-sm {
      padding: 6px 12px;
      font-size: 0.875rem;
    }
    
    .badge-count {
      background: var(--accent-color);
      color: white;
      border-radius: 50%;
      width: 30px;
      height: 30px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      margin-left: 10px;
    }
    
    @media (max-width: 992px) {
      .content-wrapper {
        flex-direction: column;
      }
      
      .form-section {
        width: 100%;
        border-right: none;
        border-bottom: 2px dashed var(--accent-color);
      }
    }
  </style>
</head>
<body>

<div class="main-container">
  <div class="header">
    <h3><i class="fas fa-store me-2"></i>KiosNet Dashboard</h3>
  </div>

  <div class="content-wrapper">
    <!-- Form Section -->
    <div class="form-section">
      <div class="form-box">
        <h5 class="form-title"><?php echo $mode_edit ? 'Edit Data' : 'Tambah Data Baru'; ?></h5>
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
          <div class="mb-3">
            <label class="form-label">Redaman Modem</label>
            <input type="number" step="0.01" name="tredamanmodem" value="<?= $vRedamanModem ?>" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Redaman OPM</label>
            <input type="number" step="0.01" name="tredamanopm" value="<?= $vRedamanOPM ?>" class="form-control" required>
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
              <i class="fas fa-save me-2"></i><?php echo $mode_edit ? 'Update' : 'Simpan'; ?>
            </button>
            <button type="button" class="btn btn-secondary" onclick="resetForm()">
              <i class="fas fa-times me-2"></i>Batalkan
            </button>
            <a href="indexmenu.php" class="btn btn-danger">
              <i class="fas fa-arrow-left me-2"></i>Kembali ke Menu
            </a>
          </div>
        </form>
      </div>
    </div>

    <!-- Table Section -->
    <div class="table-section">
      <div class="card">
        <div class="card-header">
          <i class="fas fa-table me-2"></i>Data Tersimpan
          <span class="badge-count"><?php echo $jumlah_data; ?></span>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr class="text-center">
                  <th>No</th>
                  <th>Periode Modem</th>
                  <th>Tanggal</th>
                  <th>Serial</th>
                  <th>Redaman Modem</th>
                  <th>Redaman OPM</th>
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
                  mysqli_data_seek($tampil_data, 0); // Reset pointer
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
                      <a href="KiosNet.php?hal=edit&id=<?= $data['id_barang'] ?>" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i>
                      </a>
                      <a href="KiosNet.php?hal=hapus&id=<?= $data['id_barang'] ?>" 
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
function resetForm() {
  <?php if ($mode_edit): ?>
    window.location.href = "KiosNet.php";
  <?php else: ?>
    document.getElementById("formInput").reset();
  <?php endif; ?>
}
</script>

</body>
</html>