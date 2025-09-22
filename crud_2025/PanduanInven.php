<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panduan Warehouse System Lengkap</title>
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
            font-family: 'Poppins', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: radial-gradient(circle at top left, #0f172a, #1e293b 60%, #0f172a);
            color: var(--text-primary);
            min-height: 100vh;
            padding: 20px;
            overflow-x: hidden;
        }

        /* Background floating shapes */
        .bg-3d-effect {
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: -1;
            overflow: hidden;
        }

        .floating-shape {
            position: absolute;
            border-radius: 50%;
            background: linear-gradient(45deg, var(--primary), var(--accent));
            opacity: 0.08;
            filter: blur(70px);
            animation: float 15s infinite ease-in-out;
        }

        .shape-1 {
            width: 400px;
            height: 400px;
            top: -100px;
            left: -100px;
        }

        .shape-2 {
            width: 300px;
            height: 300px;
            bottom: -50px;
            right: -50px;
            animation-delay: -5s;
        }

        .shape-3 {
            width: 250px;
            height: 250px;
            top: 40%;
            left: 60%;
            animation-delay: -10s;
        }

        @keyframes float {
            0%, 100% {
                transform: translate(0, 0) rotate(0deg);
            }
            33% {
                transform: translate(30px, 50px) rotate(120deg);
            }
            66% {
                transform: translate(-20px, 80px) rotate(240deg);
            }
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
            padding: 30px;
            background: rgba(30, 41, 59, 0.7);
            border-radius: 20px;
            backdrop-filter: blur(10px);
            border: 1px solid var(--dark-border);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            animation: fadeIn 1s ease;
        }

        .header h1 {
            font-weight: 800;
            font-size: 3rem;
            background: linear-gradient(45deg, var(--primary-glow), var(--accent-glow));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 15px;
            text-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .header p {
            color: var(--text-secondary);
            font-size: 1.3rem;
            max-width: 800px;
            margin: 0 auto;
            line-height: 1.6;
        }

        .table-container {
            background: rgba(30, 41, 59, 0.8);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
            margin-bottom: 40px;
            border: 1px solid var(--dark-border);
            backdrop-filter: blur(10px);
            animation: slideUp 1s ease;
        }

        .warehouse-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            color: var(--text-primary);
        }

        .warehouse-table th {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: white;
            padding: 18px 15px;
            text-align: center;
            font-weight: 600;
            font-size: 1rem;
            position: sticky;
            top: 0;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .warehouse-table td {
            padding: 18px 15px;
            border-bottom: 1px solid var(--dark-border);
            vertical-align: top;
            font-size: 1rem;
            background-color: rgba(30, 41, 59, 0.8);
            transition: all 0.3s ease;
        }

        .warehouse-table tr:last-child td {
            border-bottom: none;
        }

        .warehouse-table tr:hover td {
            background: rgba(99, 102, 241, 0.1);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .section-header {
            background-color: rgba(99, 102, 241, 0.2) !important;
            font-weight: 700;
            color: var(--primary-glow) !important;
            text-align: center;
            position: sticky;
            top: 60px;
            z-index: 10;
        }

        .section-header td {
            background: linear-gradient(90deg, rgba(99, 102, 241, 0.2), rgba(236, 72, 153, 0.2)) !important;
            text-align: center;
            font-size: 1.2rem;
            padding: 20px;
            letter-spacing: 1px;
            text-transform: uppercase;
            border: none !important;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .module-cell {
            font-weight: 600;
            color: var(--primary-glow);
            background: rgba(99, 102, 241, 0.1) !important;
            text-align: center;
            vertical-align: middle !important;
            font-size: 1.1rem;
        }

        .note {
            background: rgba(236, 72, 153, 0.1);
            border-left: 4px solid var(--accent);
            padding: 20px;
            margin: 30px 0;
            border-radius: 10px;
            font-size: 1rem;
            line-height: 1.6;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { box-shadow: 0 5px 15px rgba(236, 72, 153, 0.2); }
            50% { box-shadow: 0 5px 20px rgba(236, 72, 153, 0.4); }
            100% { box-shadow: 0 5px 15px rgba(236, 72, 153, 0.2); }
        }

        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 40px;
            flex-wrap: wrap;
        }

        .btn-download, .btn-back {
            padding: 15px 30px;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            position: relative;
            overflow: hidden;
        }

        .btn-download {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: white;
            border: none;
        }

        .btn-download:hover {
            box-shadow: 0 8px 25px rgba(236, 72, 153, 0.5);
            transform: translateY(-5px) scale(1.05);
        }

        .btn-download:before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(rgba(255,255,255,0.2), rgba(255,255,255,0));
            transform: rotate(45deg);
            transition: all 0.5s ease;
            opacity: 0;
        }

        .btn-download:hover:before {
            opacity: 1;
            animation: shine 1.5s ease;
        }

        @keyframes shine {
            0% { transform: translateX(-100%) rotate(45deg); }
            100% { transform: translateX(100%) rotate(45deg); }
        }

        .btn-back {
            background: rgba(30, 41, 59, 0.8);
            color: var(--text-primary);
            border: 1px solid var(--dark-border);
        }

        .btn-back:hover {
            background: rgba(99, 102, 241, 0.15);
            border-color: var(--primary);
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(99, 102, 241, 0.3);
        }

        .module-icon {
            margin-right: 8px;
            font-size: 1.2rem;
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .warehouse-table tr {
            animation: fadeInRow 0.5s ease;
            animation-fill-mode: both;
        }

        @keyframes fadeInRow {
            from { opacity: 0; transform: translateX(-20px); }
            to { opacity: 1; transform: translateX(0); }
        }

        /* Delay for staggered animation */
        .warehouse-table tr:nth-child(1) { animation-delay: 0.1s; }
        .warehouse-table tr:nth-child(2) { animation-delay: 0.2s; }
        .warehouse-table tr:nth-child(3) { animation-delay: 0.3s; }
        .warehouse-table tr:nth-child(4) { animation-delay: 0.4s; }
        .warehouse-table tr:nth-child(5) { animation-delay: 0.5s; }
        .warehouse-table tr:nth-child(6) { animation-delay: 0.6s; }
        .warehouse-table tr:nth-child(7) { animation-delay: 0.7s; }
        .warehouse-table tr:nth-child(8) { animation-delay: 0.8s; }
        .warehouse-table tr:nth-child(9) { animation-delay: 0.9s; }
        .warehouse-table tr:nth-child(10) { animation-delay: 1.0s; }

        @media (max-width: 992px) {
            .table-container {
                overflow-x: auto;
                border-radius: 15px;
            }
            
            .warehouse-table {
                min-width: 900px;
            }
            
            .header h1 {
                font-size: 2.2rem;
            }
            
            .header p {
                font-size: 1.1rem;
            }
            
            .action-buttons {
                flex-direction: column;
                align-items: center;
            }
            
            .btn-download, .btn-back {
                width: 100%;
                max-width: 300px;
                justify-content: center;
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
            
            .warehouse-table th {
                background: #f0f0f0 !important;
                color: black !important;
            }
            
            .action-buttons {
                display: none;
            }
            
            .bg-3d-effect {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="bg-3d-effect">
        <div class="floating-shape shape-1"></div>
        <div class="floating-shape shape-2"></div>
        <div class="floating-shape shape-3"></div>
    </div>

    <div class="container">
        <div class="header">
            <h1>Panduan Warehouse System Lengkap</h1>
            <p>Prosedur lengkap untuk semua proses Warehouse System - Didesain dengan antarmuka modern dan interaktif</p>
        </div>

        <div class="table-container">
            <table class="warehouse-table">
                <thead>
                    <tr>
                        <th width="5%">NO</th>
                        <th width="15%">Modul</th>
                        <th width="15%">Komponen</th>
                        <th width="65%">Deskripsi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- ========== INVENTORY SECTION ========== -->
                    <tr class="section-header">
                        <td colspan="4"><i class="bi bi-box-seam"></i> INVENTORY</td>
                    </tr>
                    
                    <tr>
                        <td>1</td>
                        <td rowspan="4" class="module-cell"><i class="bi bi-clipboard-data module-icon"></i> Inventory</td>
                        <td>Pengertian</td>
                        <td>Warehouse Inventory merupakan pengelolaan data system yang merujuk pada semua barang yang disimpan dalam suatu fasilitas gudang (Warehouse) dengan tujuan penggunaan didalam proses operasional. Ada banyak fitur di dalam Warehouse inventory serta fungsi setiap sheetnya.</td>
                    </tr>
                    
                    <tr>
                        <td>2</td>
                        <td>Sub Inventory</td>
                        <td>Di sheet ini berisi menu: tanggal masuk, sku, distributor, id barang, serial number/SN, nama barang, status, dan juga branch. Sheet ini juga dapat menampilkan barang ini keluar kemana dan untuk branch mana.</td>
                    </tr>
                    
                    <tr>
                        <td>3</td>
                        <td>Take Away</td>
                        <td>Sheet ini berada di dalam sheet dari Sub Inventory. Digunakan sebagai proses penginputan pengiriman barang ke semua branch. Disini juga terdapat pilihan data input seperti branch, Barang, IDPO (atau ID barang) dan juga berisi informasi mengenai sisa stock secara keseluruhan untuk setiap barang.</td>
                    </tr>
                    
                    <tr>
                        <td>4</td>
                        <td>Inventory</td>
                        <td>Merupakan menu Utama di Warehouse Inventory, di sheet ini digunakan untuk melihat nama barang, jenis barang, fungsi, serta jumlah stock awal dan stock akhir, di sheet ini juga digunakan untuk memantau pergerakan stock barang masuk dan keluar ke semua branch.</td>
                    </tr>
                    
                    <!-- ========== INVENTARIS SECTION ========== -->
                    <tr class="section-header">
                        <td colspan="4"><i class="bi bi-clipboard2-data"></i> INVENTARIS</td>
                    </tr>
                    
                    <tr>
                        <td>5</td>
                        <td rowspan="4" class="module-cell"><i class="bi bi-clipboard2-data module-icon"></i> Inventaris</td>
                        <td>Pengertian</td>
                        <td>Sheet Inventaris adalah lembar kerja yang digunakan untuk mencatat, mengatur, dan memantau seluruh barang persediaan di warehouse. Dalam konteks warehouse, sheet inventaris berfungsi sebagai sistem pencatatan manual maupun digital agar setiap barang persediaan yang masuk, tersimpan, maupun keluar dapat terkontrol secara rapi, transparan, dan mudah ditelusuri.</td>
                    </tr>
                    
                    <tr>
                        <td>6</td>
                        <td>Inventory PDM (Persediaan Barang Umum)</td>
                        <td>Sheet ini berfungsi sebagai database utama untuk menyimpan seluruh data stok barang yang tersedia di warehouse. Kolom yang digunakan: Nama Barang, Standar, Jumlah Stok, Harga Satuan, Modal Akhir, Jumlah Out, Jumlah Belanja, Nama Barang Belanja, Link Lokasi Toko Belanja, Nama Toko, Harga PCS, Total Harga Belanja. Tujuan dari sheet ini adalah memastikan stok selalu tersedia sesuai standar operasional, menjadi dasar pengecekan jika terjadi selisih antara stok fisik dan catatan, serta menyediakan data yang akurat untuk kebutuhan belanja dan perencanaan.</td>
                    </tr>
                    
                    <tr>
                        <td>7</td>
                        <td>RAB Belanja (Rencana Anggaran Belanja)</td>
                        <td>Sheet ini digunakan untuk merencanakan dan mengontrol biaya pengeluaran dalam pembelian barang. Kolom yang digunakan: Spesifikasi, Nama Barang, Stok Standar, Stok Akhir, Jumlah Beli, Harga Satuan, Total Harga. Tujuan dari sheet ini adalah mengontrol pengeluaran agar tidak melebihi anggaran, memberikan gambaran rencana belanja secara jelas dan terukur, serta menjadi acuan dalam proses persetujuan pembelian barang.</td>
                    </tr>
                    
                    <tr>
                        <td>8</td>
                        <td>SUP Barang Out (Surat Pengeluaran Barang)</td>
                        <td>Sheet ini berfungsi sebagai arsip resmi untuk mencatat seluruh barang yang keluar dari warehouse. Kolom yang digunakan: Tanggal, Periode, SKU (Stock Keeping Unit), Nama Barang, Qty (Quantity), Tujuan Out. Tujuan dari sheet ini adalah menjadi bukti resmi bahwa barang telah keluar dari gudang, menyediakan data arsip untuk keperluan audit maupun laporan bulanan, serta memastikan distribusi barang tercatat dengan baik dan tidak ada kehilangan.</td>
                    </tr>
                    
                    <!-- ========== LABELING SECTION ========== -->
                    <tr class="section-header">
                        <td colspan="4"><i class="bi bi-tags"></i> LABELING</td>
                    </tr>
                    
                    <tr>
                        <td>9</td>
                        <td rowspan="3" class="module-cell"><i class="bi bi-tag module-icon"></i> Labeling</td>
                        <td>Pengertian</td>
                        <td>Warehouse Labeling adalah proses di gudang (warehouse) untuk memberikan label identitas pada setiap barang yang disimpan atau diproses, dengan tujuan mempermudah pelacakan, pengelolaan stok, dan distribusi barang.</td>
                    </tr>
                    
                    <tr>
                        <td>10</td>
                        <td>Data Print</td>
                        <td>Adalah sebuah fitur yang melakukan pelabelan pada semua barang, yang telah selesai melalui proses alur kerja di warehouse sebelumnya.</td>
                    </tr>
                    
                    <tr>
                        <td>11</td>
                        <td>Labeling</td>
                        <td>Adalah fitur yang digunakan untuk menampilkan barang yang siap untuk proses pelabelan dan pencetakan. Fitur ini juga dilengkapi dengan barcode barang yang berguna untuk melacak ID barang secara akurat dan efisien.</td>
                    </tr>
                    
                    <!-- ========== QUALITY CONTROL SECTION ========== -->
                    <tr class="section-header">
                        <td colspan="4"><i class="bi bi-check-circle"></i> QUALITY CONTROL</td>
                    </tr>
                    
                    <tr>
                        <td>12</td>
                        <td rowspan="7" class="module-cell"><i class="bi bi-clipboard-check module-icon"></i> Quality Control</td>
                        <td>Pengertian</td>
                        <td>Warehouse Quality control adalah proses memastikan bahwa barang yang di simpan, di proses dan di kirim dari Gudang ke branch sudah memenuhi standar kualitas yang telah di tetapkan.</td>
                    </tr>
                    
                    <tr>
                        <td>13</td>
                        <td>Registrasi Barang</td>
                        <td>Sheet ini berada di dalam sheet dari Warehouse Quality Control, Di sheet registrasi barang digunakan untuk mendaftarkan barang agar IDPO tercatat dengan benar dalam sisem warehouse(sub inventory).</td>
                    </tr>
                    
                    <tr>
                        <td>14</td>
                        <td>Sheet Receiving</td>
                        <td>Berfungsi sebagai form validasi barang yang telah melewati proses pengadaan, penerimaan barang, dan quality control sebelum masuk ke warehouse inventory.</td>
                    </tr>
                    
                    <tr>
                        <td>15</td>
                        <td>Sheet QC Qty</td>
                        <td>Adalah sheet yang digunakan untuk melakukan quality control terhadap kuantitas/jumlah barang dengan tujuan memastikan apakah jumlah barang sesuai dengan pesanan.</td>
                    </tr>
                    
                    <tr>
                        <td>16</td>
                        <td>Sheet Quality Control Fisik</td>
                        <td>Sheet yang digunakan untuk memeriksa kualitas barang secara virtual dengan tujuan memastikan pengecekan terhadap kecacatan barang.</td>
                    </tr>
                    
                    <tr>
                        <td>17</td>
                        <td>Sheet QC Fungsional</td>
                        <td>Berfungsi sebagai pengecekan terhadap barang-barang, khususnya yang berkaitan dengan 'redaman' seperti Splitter PLC modul kecil, patchord outdoor atau indoor.</td>
                    </tr>
                    
                    <tr>
                        <td>18</td>
                        <td>Sheet QC Modem</td>
                        <td>Digunakan untuk pemeriksaan modem secara teliti yang mencakup pengecekan fungsi tombol/button, indikator, serta tingkat redaman.</td>
                    </tr>
                    
                    <!-- ========== ERP GRİYA SECTION ========== -->
                    <tr class="section-header">
                        <td colspan="4"><i class="bi bi-globe"></i> ERP GRİYA</td>
                    </tr>
                    
                    <tr>
                        <td>19</td>
                        <td rowspan="2" class="module-cell"><i class="bi bi-laptop module-icon"></i> ERP Griya</td>
                        <td>Pengertian</td>
                        <td>ERP Griya adalah sebuah situs web yang dirancang untuk mendukung proses operasional dan manajemen inventory. Digunakan untuk input SN modem Griya (Serial Number Modem) agar dapat masuk ke inventory branch.</td>
                    </tr>
                    
                    <tr>
                        <td>20</td>
                        <td>Submenu Belanja</td>
                        <td>Terdapat kode ref (kode unik untuk setiap pengiriman), supplier, total harga, brand, type, total item, pilihan branch tujuan, dan serial number modem.</td>
                    </tr>
                    
                    <!-- ========== SN WEB SECTION ========== -->
                    <tr class="section-header">
                        <td colspan="4"><i class="bi bi-list-check"></i> SN WEB</td>
                    </tr>
                    
                    <tr>
                        <td>21</td>
                        <td class="module-cell"><i class="bi bi-upc-scan module-icon"></i> SN WEB</td>
                        <td>Pengertian</td>
                        <td>SN Web adalah sebuah sheet yang berfungsi sebagai penampung utama Serial Number (SN) modem setelah modem melewati tahap Quality Control (QC). Sheet ini menjadi acuan untuk proses selanjutnya yaitu input inventory dan labeling modem.</td>
                    </tr>
                    
                    <!-- ========== DISTRIBUSI SECTION ========== -->
                    <tr class="section-header">
                        <td colspan="4"><i class="bi bi-truck"></i> DISTRIBUSI</td>
                    </tr>
                    
                    <tr>
                        <td>22</td>
                        <td rowspan="3" class="module-cell"><i class="bi bi-box-arrow-right module-icon"></i> Distribusi</td>
                        <td>Pengertian</td>
                        <td>Proses pengiriman barang dari warehouse ke berbagai branch dengan memperhatikan efisiensi waktu dan biaya.</td>
                    </tr>
                    
                    <tr>
                        <td>23</td>
                        <td>Proses Pengemasan</td>
                        <td>Barang dikemas dengan aman sesuai jenis dan karakteristiknya untuk mencegah kerusakan selama pengiriman.</td>
                    </tr>
                    
                    <tr>
                        <td>24</td>
                        <td>Tracking System</td>
                        <td>Setiap pengiriman dilengkapi dengan sistem pelacakan untuk memantau pergerakan barang hingga sampai di tujuan.</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="note">
            <strong><i class="bi bi-info-circle"></i> Catatan Penting:</strong> Semua prosedur di atas harus diikuti dengan ketat untuk memastikan kelancaran operasional warehouse dan menjaga kualitas produk. Pastikan untuk selalu memperbarui data secara real-time untuk akurasi inventory.
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
        // Fungsi untuk mengunduh panduan sebagai HTML
        document.getElementById('downloadBtn').addEventListener('click', function(e) {
            e.preventDefault();
            
            // Membuat elemen iframe untuk mencetak halaman
            const element = document.createElement('a');
            element.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(document.documentElement.outerHTML));
            element.setAttribute('download', 'Panduan_Warehouse_System.html');
            
            element.style.display = 'none';
            document.body.appendChild(element);
            
            element.click();
            
            document.body.removeChild(element);
            
            alert('Panduan telah berhasil diunduh!');
        });

        // Efek animasi saat scroll
        document.addEventListener('DOMContentLoaded', function() {
            const tableRows = document.querySelectorAll('.warehouse-table tr');
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.animationPlayState = 'running';
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.1 });
            
            tableRows.forEach(row => {
                observer.observe(row);
            });
        });
    </script>
</body>
</html>