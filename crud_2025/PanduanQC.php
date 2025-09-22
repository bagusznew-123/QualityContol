<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panduan QC Modem Lengkap</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --dark-bg: #0f172a;
            --dark-card: #1e293b;
            --dark-border: #334155;
            --primary: #6366f1;
            --primary-glow: #818cf8;
            --accent: #ec4899;
            --accent-glow: #f472b6;
            --text-primary: #f1f5f9;
            --text-secondary: #cbd5e1;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: radial-gradient(circle at top left, #0f172a, #1e293b 60%, #0f172a);
            color: var(--text-primary);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            padding: 20px;
        }

        .header h1 {
            font-weight: 700;
            font-size: 2.5rem;
            background: linear-gradient(45deg, var(--text-primary), var(--primary-glow));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 10px;
        }

        .header p {
            color: var(--text-secondary);
            font-size: 1.2rem;
        }

        .table-container {
            background: rgba(30, 41, 59, 0.8);
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            margin-bottom: 30px;
            border: 1px solid var(--dark-border);
        }

        .qc-table {
            width: 100%;
            border-collapse: collapse;
            color: var(--text-primary);
        }

        .qc-table th {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: white;
            padding: 16px 12px;
            text-align: center;
            font-weight: 600;
            font-size: 0.9rem;
            position: sticky;
            top: 0;
        }

        .qc-table td {
            padding: 14px 12px;
            border-bottom: 1px solid var(--dark-border);
            vertical-align: top;
            font-size: 0.9rem;
            background-color: rgba(30, 41, 59, 0.8);
        }

        .qc-table tr:last-child td {
            border-bottom: none;
        }

        .section-header {
            background-color: rgba(99, 102, 241, 0.15) !important;
            font-weight: 600;
            color: var(--primary-glow) !important;
            text-align: center;
        }

        .section-header td {
            background-color: rgba(99, 102, 241, 0.15) !important;
            text-align: center;
            font-size: 1.1rem;
            padding: 15px;
        }

        .brand-cell {
            font-weight: 500;
            color: var(--primary-glow);
        }

        .note {
            background: rgba(236, 72, 153, 0.1);
            border-left: 4px solid var(--accent);
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
            font-size: 0.9rem;
        }

        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 30px;
        }

        .btn-download, .btn-back {
            padding: 12px 25px;
            border-radius: 50px;
            font-weight: 500;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }

        .btn-download {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: white;
            box-shadow: 0 5px 15px rgba(99, 102, 241, 0.4);
        }

        .btn-download:hover {
            box-shadow: 0 8px 25px rgba(236, 72, 153, 0.6);
            transform: translateY(-3px);
        }

        .btn-back {
            background: rgba(30, 41, 59, 0.8);
            color: var(--text-primary);
            border: 1px solid var(--dark-border);
        }

        .btn-back:hover {
            background: rgba(99, 102, 241, 0.1);
            border-color: var(--primary);
        }

        @media (max-width: 992px) {
            .table-container {
                overflow-x: auto;
            }
            
            .qc-table {
                min-width: 1000px;
            }
            
            .header h1 {
                font-size: 2rem;
            }
        }

        @media print {
            body {
                background: white;
                color: black;
            }
            
            .table-container {
                box-shadow: none;
                border: 1px solid #ddd;
            }
            
            .qc-table th {
                background: #f0f0f0 !important;
                color: black !important;
            }
            
            .action-buttons {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Panduan Quality Control Modem</h1>
            <p>Prosedur lengkap untuk proses Quality Control modem</p>
        </div>

        <div class="table-container">
            <table class="qc-table">
                <thead>
                    <tr>
                        <th width="4%">NO</th>
                        <th width="8%">Bagian</th>
                        <th width="10%">Brand</th>
                        <th width="12%">Aktivitas</th>
                        <th width="12%">Indikator</th>
                        <th width="12%">Kriteria</th>
                        <th width="42%">Prosedur</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- ========== SET UP SECTION ========== -->
                    <tr class="section-header">
                        <td colspan="7">SET UP</td>
                    </tr>
                    
                    <tr>
                        <td>1</td>
                        <td rowspan="5">Set Up</td>
                        <td class="brand-cell" rowspan="3">Modem GriyaNet, Dasarata, & KiosNet</td>
                        <td>Pembersihan Modem</td>
                        <td>Pembersihan modem menggunakan H2o2</td>
                        <td>Modem yang sudah menguning</td>
                        <td>Modem dioles H2o2 menggunakan kuas dan wajib menggunakan sarung tangan plastik, setelah di oleskan modem dimasukkan kedalam kresek dan didiamkan dalam kresek minimal selama 4 jam jika cuaca sedang panas. Pembersihan dilakukan ke seluruh bagian modem terkecuali merk dan SN</td>
                    </tr>
                    
                    <tr>
                        <td>2</td>
                        <td>Indikator dan Button Modem</td>
                        <td>Indikator modem</td>
                        <td>Lampu indikator modem</td>
                        <td>Dalam menghidupkan modem dipastikan semua lampu indikator menyala</td>
                    </tr>
                    
                    <tr>
                        <td>3</td>
                        <td></td>
                        <td>Button</td>
                        <td>Tombol modem</td>
                        <td>Button modem dicek dengan cara menekan tombol wifi dan wps</td>
                    </tr>
                    
                    <tr>
                        <td>4</td>
                        <td class="brand-cell">Modem GriyaNet</td>
                        <td>Koneksi Lan</td>
                        <td>Pengecekan Indikator Lan</td>
                        <td></td>
                        <td>Hubungkan modem to modem menggunakan kabel LAN untuk mengetahui apakah LAN berfungsi atau tidak, pengecekan dilakukan mulai dari LAN 4 hingga LAN 1</td>
                    </tr>
                    
                    <tr>
                        <td>5</td>
                        <td class="brand-cell" rowspan="2">Modem GriyaNet, Dasarata, & KiosNet</td>
                        <td>Reset Modem</td>
                        <td>Hard Reset</td>
                        <td></td>
                        <td>Modem direset dengan cara manual yaitu menekan tombol reset di modem menggunakan jarum</td>
                    </tr>
                    
                    <tr>
                        <td>6</td>
                        <td>Set Up</td>
                        <td></td>
                        <td>Reset Sistem</td>
                        <td></td>
                        <td>Modem direset dengan cara masuk ke dalam settingan modem (192.168.1.1) lalu pilih menu Management & Diagnosis lalu pilih System Management lalu pilih Factory Reset</td>
                    </tr>
                    
                    <!-- ========== SETTING SECTION ========== -->
                    <tr class="section-header">
                        <td colspan="7">SETTING</td>
                    </tr>
                    
                    <tr>
                        <td>7</td>
                        <td rowspan="12">Setting</td>
                        <td class="brand-cell" rowspan="2">Modem GriyaNet</td>
                        <td>Hubungkan Modem ke Laptop/PC</td>
                        <td>Menggunakan Kabel LAN</td>
                        <td></td>
                        <td>Hubungkan satu sisi Kabel LAN ke modem dan satu sisinya hubungkan ke Laptop/PC</td>
                    </tr>
                    
                    <tr>
                        <td>8</td>
                        <td></td>
                        <td>Menggunakan WIFI</td>
                        <td></td>
                        <td>Hubungkan wifi modem ke laptop dengan SSID dan Password bisa dilihat di belakang modem</td>
                    </tr>
                    
                    <tr>
                        <td>9</td>
                        <td class="brand-cell" rowspan="2">Modem GriyaNet</td>
                        <td>Serial Number Modem</td>
                        <td>Cek Fisik</td>
                        <td></td>
                        <td>Serial Number Modem dilihat di belakang modem yang bertuliskan GPON SN</td>
                    </tr>
                    
                    <tr>
                        <td>10</td>
                        <td></td>
                        <td>Cek dalam setinggan modem</td>
                        <td></td>
                        <td>Masuk kedalam setinggan modem (192.168.1.1) lalu pilih menu Management & Diagnosis lalu pilih Status lalu lihat Device Serial No. (Pastikan sama dengan GPON SN di belakang modem)</td>
                    </tr>
                    
                    <tr>
                        <td>11</td>
                        <td class="brand-cell" rowspan="2">Modem GriyaNet</td>
                        <td>Cek redaman modem</td>
                        <td>Cek dalam setinggan modem</td>
                        <td>Modem F670L (V5)</td>
                        <td>Masuk kedalam setinggan modem (192.168.1.1) lalu pilih menu Internet dan redaman dilihat di Optical Module Input Power(dBm) dipastikan tidak sampai up ataupun down 1 dan juga pastikan redaman Optical Module Output Power(dBm) di angka 2</td>
                    </tr>
                    
                    <tr>
                        <td>12</td>
                        <td></td>
                        <td></td>
                        <td>Modem F670 (V3)</td>
                        <td>Masuk kedalam setinggan modem (192.168.1.1) lalu pilih menu Device Information lalu pilih Networking Interface lalu pilih PON Information dan redaman dilihat di Optical Module Input Power(dBm). dan juga pastikan redaman Optical Module Output Power(dBm) di angka 2</td>
                    </tr>
                    
                    <tr>
                        <td>13</td>
                        <td class="brand-cell" rowspan="2">Modem GriyaNet</td>
                        <td>WAN</td>
                        <td>Pastikan WAN hanya terisi TR069</td>
                        <td>Modem F670L (V5)</td>
                        <td>Masuk kedalam setinggan modem (192.168.1.1) lalu pilih menu Internet pilih WAN</td>
                    </tr>
                    
                    <tr>
                        <td>14</td>
                        <td></td>
                        <td></td>
                        <td>Modem F670 (V3)</td>
                        <td>Masuk kedalam setinggan modem (192.168.1.1) lalu pilih menu Device Information lalu pilih Networking Interface lalu pilih WAN Connection</td>
                    </tr>
                    
                    <tr>
                        <td>15</td>
                        <td class="brand-cell" rowspan="2">Modem GriyaNet</td>
                        <td>Ganti SSID Wifi</td>
                        <td></td>
                        <td>Modem F670L (V5)</td>
                        <td>Masuk kedalam setinggan modem (192.168.1.1) lalu pilih menu Network pilih WLAN untuk mengganti nama dan password wifi pilih WLAN SSID Configuration dan pastikan Encryption Type terpilih WPA/WPA2-PSK-TKIP/AES lalu ganti nama wifi dengan GriyaNet dan password diganti 12345678 tambahan untuk SSID 4 diganti menjadi no password</td>
                    </tr>
                    
                    <tr>
                        <td>16</td>
                        <td></td>
                        <td></td>
                        <td>Modem F670 (V3)</td>
                        <td>Masuk kedalam setinggan modem (192.168.1.1) lalu pilih menu Network pilih Wlan untuk mengganti nama wifi pilih SSID Settings ganti nama wifi di SSID Name diganti dengan GriyaNet, dan untuk mengganti Password Wifi pilih Security dan dipastikan Authentication Type terpilih di WPA/WPA2-PSK lalu WPA Passphrase diganti dengan 12345678</td>
                    </tr>
                    
                    <tr>
                        <td>17</td>
                        <td class="brand-cell">Modem Dasarata & KiosNet</td>
                        <td>Cek redaman modem</td>
                        <td>Cek dalam setinggan modem</td>
                        <td>Modem F670L (V5)</td>
                        <td>Masuk kedalam setinggan modem (192.168.1.1) lalu pilih menu Internet dan redaman dilihat di Optical Module Input Power(dBm) dipastikan tidak sampai up ataupun down 1,2 dan juga pastikan redaman Optical Module Output Power(dBm) di angka 2</td>
                    </tr>
                    
                    <tr>
                        <td>18</td>
                        <td class="brand-cell">Modem Dasarata & KiosNet</td>
                        <td>WAN</td>
                        <td>Pastikan WAN kosong</td>
                        <td>Modem F670L (V5)</td>
                        <td>Masuk kedalam setinggan modem (192.168.1.1) lalu pilih menu Internet pilih WAN kemudian hapus yang ada di dalamnya</td>
                    </tr>
                    
                    <tr>
                        <td>19</td>
                        <td>Setting</td>
                        <td class="brand-cell">Modem Dasarata & KiosNet</td>
                        <td>LAN</td>
                        <td>LAN 4, SSID 4 dan 5 (Internet)</td>
                        <td></td>
                        <td>Masuk kedalam settingan modem (192.168.1.1) lalu pilih Management & Diagnosis pilih bagian LAN untuk setting sesuai dengan kriteria</td>
                    </tr>
                    
                    <!-- ========== FINISHING SECTION ========== -->
                    <tr class="section-header">
                        <td colspan="7">FINISHING</td>
                    </tr>
                    
                    <tr>
                        <td>20</td>
                        <td rowspan="3">Finishing</td>
                        <td class="brand-cell" rowspan="3">Modem GriyaNet, Dasarata, & KiosNet</td>
                        <td>Pembersihan Modem</td>
                        <td>Pembersihan modem menggunakan Thiner</td>
                        <td>Modem yang kotor dan tidak menguning</td>
                        <td>Bersihkan modem menggunakan kain yang sudah dibasahi dengan thiner, dan digosok dengan metode satu arah. (Pembersihan dilakukan ke seluruh bagian modem terkecuali merk dan SN)</td>
                    </tr>
                    
                    <tr>
                        <td>21</td>
                        <td>Pelabelan</td>
                        <td>Pelabelan stiker sesuai brand</td>
                        <td></td>
                        <td>Memberikan stiker sesuai dengan brand dengan posisi di tengah modem</td>
                    </tr>
                    
                    <tr>
                        <td>22</td>
                        <td>Penginputan serta pelabelan ID</td>
                        <td></td>
                        <td></td>
                        <td>Penempelan ID barang yang dilakukan setelah selesai melakukan proses salin tempel Serial Number yang di ambil di database</td>
                    </tr>
                    
                    <!-- ========== INPUT DATA SECTION ========== -->
                    <tr class="section-header">
                        <td colspan="7">INPUT DATA</td>
                    </tr>
                    
                    <tr>
                        <td>23</td>
                        <td colspan="2">Input Data</td>
                        <td>Input data modem di web</td>
                        <td></td>
                        <td></td>
                        <td>Waktu QC modem ada bagian yang perlu diperhatikan yaitu redaman dan SN (Serial Number), untuk redaman dan SN disalin dan di tempel di web untuk melengkapi data sebelum melakukan penginputan data</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="action-buttons">
            <a href="#" class="btn-download" id="downloadBtn">  
                <i class="bi bi-download me-2"></i>Download Panduan
            </a>
            <a href="indexmenu.php" class="btn-back">
                <i class="bi bi-arrow-left me-2"></i>Kembali ke Dashboard
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Fungsi untuk mengunduh panduan sebagai PDF
        document.getElementById('downloadBtn').addEventListener('click', function(e) {
            e.preventDefault();
            
            // Membuat elemen iframe untuk mencetak halaman
            const element = document.createElement('a');
            element.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(document.documentElement.outerHTML));
            element.setAttribute('download', 'Panduan_QC_Modem.html');
            
            element.style.display = 'none';
            document.body.appendChild(element);
            
            element.click();
            
            document.body.removeChild(element);
            
            alert('Panduan telah berhasil diunduh!');
        });
    </script>
</body>
</html>