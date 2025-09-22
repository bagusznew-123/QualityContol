<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WareStock - Sistem Manajemen Stok Gudang</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3f37c9;
            --success: #4cc9f0;
            --danger: #f72585;
            --warning: #f8961e;
            --info: #4895ef;
            --light: #f8f9fa;
            --dark: #212529;
            --gray: #6c757d;
            --light-gray: #e9ecef;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f5f7fb;
            color: var(--dark);
            line-height: 1.6;
        }

        .container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 250px;
            background: linear-gradient(180deg, var(--primary), var(--secondary));
            color: white;
            padding: 20px 0;
            transition: all 0.3s;
        }

        .logo {
            padding: 0 20px 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .logo h2 {
            font-size: 24px;
            margin-top: 10px;
        }

        .logo span {
            color: var(--success);
        }

        .menu {
            margin-top: 30px;
        }

        .menu-item {
            padding: 15px 20px;
            display: flex;
            align-items: center;
            transition: all 0.3s;
            cursor: pointer;
        }

        .menu-item:hover,
        .menu-item.active {
            background-color: rgba(255, 255, 255, 0.1);
            border-left: 4px solid var(--success);
        }

        .menu-item i {
            margin-right: 10px;
            font-size: 18px;
        }

        /* Main Content Styles */
        .main-content {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--light-gray);
        }

        .search-bar {
            display: flex;
            align-items: center;
            background: white;
            border-radius: 30px;
            padding: 8px 20px;
            width: 400px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .search-bar input {
            border: none;
            outline: none;
            padding: 8px;
            width: 100%;
            font-size: 16px;
        }

        .user-profile {
            display: flex;
            align-items: center;
        }

        .user-profile img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
            object-fit: cover;
        }

        /* Dashboard Cards */
        .dashboard-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .card-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
        }

        .bg-primary {
            background-color: var(--primary);
        }

        .bg-success {
            background-color: var(--success);
        }

        .bg-warning {
            background-color: var(--warning);
        }

        .bg-danger {
            background-color: var(--danger);
        }

        .card h3 {
            font-size: 28px;
            margin-bottom: 5px;
        }

        .card p {
            color: var(--gray);
            font-size: 14px;
        }

        /* Table Styles */
        .table-section {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .section-title {
            font-size: 20px;
            font-weight: 600;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s;
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--secondary);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid var(--light-gray);
        }

        th {
            font-weight: 600;
            color: var(--gray);
        }

        tr:hover {
            background-color: var(--light);
        }

        .status {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }

        .status-in {
            background-color: rgba(76, 201, 240, 0.1);
            color: var(--success);
        }

        .status-out {
            background-color: rgba(247, 37, 133, 0.1);
            color: var(--danger);
        }

        .action-btn {
            padding: 5px;
            margin-right: 5px;
            border-radius: 5px;
            cursor: pointer;
            color: white;
            border: none;
        }

        .edit-btn {
            background-color: var(--info);
        }

        .delete-btn {
            background-color: var(--danger);
        }

        /* Form Styles */
        .form-container {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid var(--light-gray);
            border-radius: 8px;
            font-size: 16px;
        }

        .form-row {
            display: flex;
            gap: 20px;
        }

        .form-row .form-group {
            flex: 1;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background: white;
            border-radius: 15px;
            padding: 25px;
            width: 500px;
            max-width: 90%;
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--light-gray);
        }

        .close {
            font-size: 24px;
            cursor: pointer;
        }

        /* Tabs */
        .tabs {
            display: flex;
            margin-bottom: 20px;
            border-bottom: 1px solid var(--light-gray);
        }

        .tab {
            padding: 10px 20px;
            cursor: pointer;
            border-bottom: 3px solid transparent;
        }

        .tab.active {
            border-bottom: 3px solid var(--primary);
            color: var(--primary);
            font-weight: 500;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .container {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                padding: 10px;
            }

            .dashboard-cards {
                grid-template-columns: repeat(2, 1fr);
            }

            .form-row {
                flex-direction: column;
                gap: 0;
            }
        }

        @media (max-width: 768px) {
            .dashboard-cards {
                grid-template-columns: 1fr;
            }

            .search-bar {
                width: 300px;
            }
        }

        @media (max-width: 576px) {
            .header {
                flex-direction: column;
                align-items: flex-start;
            }

            .search-bar {
                width: 100%;
                margin-bottom: 15px;
            }

            .section-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .section-header .btn {
                margin-top: 10px;
            }
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 15px;
            color: white;
            text-decoration: none;
            cursor: pointer;
        }

        .menu-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .menu-item i {
            min-width: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="logo">
                <h2>Ware<span>Stock</span></h2>
                <p>Manajemen Stok Gudang</p>
            </div>

            <div class="menu">
                <div class="menu-item active" data-tab="dashboard">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </div>
                <div class="menu-item" data-tab="inventory">
                    <i class="fas fa-boxes"></i>
                    <span>Inventory</span>
                </div>
                <div class="menu-item" data-tab="transaction-in">
                    <i class="fas fa-arrow-circle-down"></i>
                    <span>Barang Masuk</span>
                </div>
                <div class="menu-item" data-tab="transaction-out">
                    <i class="fas fa-arrow-circle-up"></i>
                    <span>Barang Keluar</span>
                </div>
                <div class="menu-item" data-tab="history">
                    <i class="fas fa-history"></i>
                    <span>Riwayat Transaksi</span>
                </div>
                <a href="Indexmenu.php" class="menu-item">
                    <i class="fas fa-arrow-left"></i>
                    <span>Kembali</span>
                </a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="header">
                <div class="search-bar">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Cari produk, kategori, atau lokasi...">
                </div>

                <div class="user-profile">
                    <img src="https://ui-avatars.com/api/?name=Admin+Gudang&background=4361ee&color=fff" alt="User">
                    <div>
                        <h4>Admin Gudang</h4>
                        <p>Super Admin</p>
                    </div>
                </div>
            </div>

            <!-- Dashboard Content -->
            <div id="dashboard" class="tab-content active">
                <!-- Dashboard Cards -->
                <div class="dashboard-cards">
                    <div class="card">
                        <div class="card-header">
                            <div>
                                <h3 id="total-products">0</h3>
                                <p>Total Produk</p>
                            </div>
                            <div class="card-icon bg-primary">
                                <i class="fas fa-box"></i>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <div>
                                <h3 id="out-of-stock">0</h3>
                                <p>Produk Habis</p>
                            </div>
                            <div class="card-icon bg-danger">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <div>
                                <h3 id="transactions-today">0</h3>
                                <p>Transaksi Hari Ini</p>
                            </div>
                            <div class="card-icon bg-success">
                                <i class="fas fa-arrow-up"></i>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <div>
                                <h3 id="low-stock">0</h3>
                                <p>Stok Hampir Habis</p>
                            </div>
                            <div class="card-icon bg-warning">
                                <i class="fas fa-tags"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Products Table -->
                <div class="table-section">
                    <div class="section-header">
                        <h2 class="section-title">Daftar Produk</h2>
                        <button class="btn btn-primary" onclick="showAddProductModal()">
                            <i class="fas fa-plus"></i> Tambah Produk
                        </button>
                    </div>

                    <table id="products-table">
                        <thead>
                            <tr>
                                <th>Nama Produk</th>
                                <th>Kategori</th>
                                <th>Stok</th>
                                <th>Lokasi Toko</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data akan diisi oleh JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Inventory Content -->
            <div id="inventory" class="tab-content">
                <div class="section-header">
                    <h2 class="section-title">Manajemen Inventory</h2>
                    <button class="btn btn-primary" onclick="showAddProductModal()">
                        <i class="fas fa-plus"></i> Tambah Produk
                    </button>
                </div>

                <div class="table-section">
                    <div class="search-bar" style="width: 100%; margin-bottom: 20px;">
                        <i class="fas fa-search"></i>
                        <input type="text" placeholder="Cari produk..." id="inventory-search">
                    </div>

                    <table id="inventory-table">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Nama Produk</th>
                                <th>Kategori</th>
                                <th>Stok</th>
                                <th>Lokasi Toko</th>
                                <th>Harga Pcs</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data akan diisi oleh JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Transaction In Content -->
            <div id="transaction-in" class="tab-content">
                <div class="section-header">
                    <h2 class="section-title">Barang Masuk</h2>
                </div>

                <div class="form-container">
                    <h3 style="margin-bottom: 20px;">Form Barang Masuk</h3>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="product-select">Pilih Produk</label>
                            <select id="product-select">
                                <option value="">-- Pilih Produk --</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="quantity-in">Jumlah</label>
                            <input type="number" id="quantity-in" min="1" placeholder="Jumlah barang masuk">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="supplier">Supplier</label>
                            <input type="text" id="supplier" placeholder="Nama supplier">
                        </div>
                        <div class="form-group">
                            <label for="date-in">Tanggal</label>
                            <input type="date" id="date-in">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="notes-in">Catatan</label>
                        <textarea id="notes-in" rows="3" placeholder="Catatan tambahan"></textarea>
                    </div>
                    <button class="btn btn-primary" onclick="addStock()">
                        <i class="fas fa-save"></i> Simpan Transaksi
                    </button>
                </div>

                <div class="table-section" style="margin-top: 30px;">
                    <h3 style="margin-bottom: 20px;">Riwayat Barang Masuk</h3>
                    <table id="transaction-in-table">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Produk</th>
                                <th>Jumlah</th>
                                <th>Supplier</th>
                                <th>Catatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data akan diisi oleh JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Transaction Out Content -->
            <div id="transaction-out" class="tab-content">
                <div class="section-header">
                    <h2 class="section-title">Barang Keluar</h2>
                </div>

                <div class="form-container">
                    <h3 style="margin-bottom: 20px;">Form Barang Keluar</h3>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="product-out-select">Pilih Produk</label>
                            <select id="product-out-select">
                                <option value="">-- Pilih Produk --</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="quantity-out">Jumlah</label>
                            <input type="number" id="quantity-out" min="1" placeholder="Jumlah barang keluar">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="customer">Penerima</label>
                            <input type="text" id="customer" placeholder="Nama penerima">
                        </div>
                        <div class="form-group">
                            <label for="date-out">Tanggal</label>
                            <input type="date" id="date-out">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="notes-out">Catatan</label>
                        <textarea id="notes-out" rows="3" placeholder="Catatan tambahan"></textarea>
                    </div>
                    <button class="btn btn-primary" onclick="reduceStock()">
                        <i class="fas fa-save"></i> Simpan Transaksi
                    </button>
                </div>

                <div class="table-section" style="margin-top: 30px;">
                    <h3 style="margin-bottom: 20px;">Riwayat Barang Keluar</h3>
                    <table id="transaction-out-table">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Produk</th>
                                <th>Jumlah</th>
                                <th>Penerima</th>
                                <th>Catatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data akan diisi oleh JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- History Content -->
            <div id="history" class="tab-content">
                <div class="section-header">
                    <h2 class="section-title">Riwayat Transaksi</h2>
                </div>

                <div class="tabs">
                    <div class="tab active" data-history-tab="all">Semua Transaksi</div>
                    <div class="tab" data-history-tab="in">Barang Masuk</div>
                    <div class="tab" data-history-tab="out">Barang Keluar</div>
                </div>

                <div class="table-section">
                    <div class="search-bar" style="width: 100%; margin-bottom: 20px;">
                        <i class="fas fa-search"></i>
                        <input type="text" placeholder="Cari transaksi..." id="history-search">
                    </div>
                    <table id="history-table">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Tipe</th>
                                <th>Produk</th>
                                <th>Jumlah</th>
                                <th>Pihak Terkait</th>
                                <th>Catatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data akan diisi oleh JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Product Modal -->
    <div id="addProductModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Tambah Produk Baru</h3>
                <span class="close" onclick="closeModal('addProductModal')">&times;</span>
            </div>
            <div class="form-group">
                <label for="product-name">Nama Produk</label>
                <input type="text" id="product-name" placeholder="Nama produk">
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="product-category">Kategori</label>
                    <select id="product-category">
                        <option value="">-- Pilih Kategori --</option>
                        <option value="Elektronik">Elektronik</option>
                        <option value="Furnitur">Furnitur</option>
                        <option value="Alat Tulis">Alat Tulis</option>
                        <option value="Perabotan">Perabotan</option>
                        <option value="Persediaan Umum">Persediaan Umum</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="initial-stock">Stok Awal</label>
                    <input type="number" id="initial-stock" min="0" placeholder="Jumlah stok">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="product-location">Lokasi</label>
                    <input type="text" id="product-location" placeholder="Lokasi penyimpanan">
                </div>
                <div class="form-group">
                    <label for="product-price">Harga (Rp)</label>
                    <input type="number" id="product-price" min="0" placeholder="Harga satuan">
                </div>
            </div>
            <button class="btn btn-primary" onclick="addProduct()" style="width: 100%;">
                <i class="fas fa-save"></i> Simpan Produk
            </button>
        </div>
    </div>

    <script>
        // Data contoh untuk aplikasi
        let products = JSON.parse(localStorage.getItem('products')) || [
            { id: 1, name: "Laptop Dell XPS 13", category: "Elektronik", stock: 24, location: "Rak A-01", price: 15000000 },
            { id: 2, name: "Kursi Kantor Ergonomis", category: "Furnitur", stock: 12, location: "Rak B-05", price: 1200000 },
            { id: 3, name: "Monitor Samsung 24\"", category: "Elektronik", stock: 0, location: "Rak A-03", price: 2500000 },
            { id: 4, name: "Meja Meeting Kayu", category: "Furnitur", stock: 5, location: "Rak C-12", price: 3500000 },
            { id: 5, name: "Smartphone iPhone 13", category: "Elektronik", stock: 8, location: "Rak A-10", price: 13000000 }
        ];

        let transactions = JSON.parse(localStorage.getItem('transactions')) || [
            { id: 1, type: "in", productId: 1, quantity: 10, date: "2023-10-15", party: "PT Elektronik Sukses", notes: "Pembelian kuartal pertama" },
            { id: 2, type: "out", productId: 1, quantity: 2, date: "2023-10-18", party: "Budi Santoso", notes: "Penjualan retail" },
            { id: 3, type: "in", productId: 2, quantity: 5, date: "2023-10-20", party: "CV Mebel Jaya", notes: "Tambahan stok" },
            { id: 4, type: "out", productId: 3, quantity: 3, date: "2023-10-22", party: "Ani Wijaya", notes: "Pesanan khusus" }
        ];

        // Inisialisasi aplikasi
        document.addEventListener('DOMContentLoaded', function () {
            // Simpan data awal jika belum ada
            if (!localStorage.getItem('products')) {
                localStorage.setItem('products', JSON.stringify(products));
            }
            if (!localStorage.getItem('transactions')) {
                localStorage.setItem('transactions', JSON.stringify(transactions));
            }

            // Load data terbaru
            products = JSON.parse(localStorage.getItem('products'));
            transactions = JSON.parse(localStorage.getItem('transactions'));

            // Setup menu navigation
            setupMenuNavigation();

            // Load data ke dashboard
            loadDashboard();

            // Load data ke inventory
            loadInventory();

            // Load data ke transaksi
            loadTransactionIn();
            loadTransactionOut();

            // Load data ke history
            loadHistory();

            // Set tanggal otomatis untuk form
            document.getElementById('date-in').valueAsDate = new Date();
            document.getElementById('date-out').valueAsDate = new Date();
        });

        // Setup menu navigation
        function setupMenuNavigation() {
            const menuItems = document.querySelectorAll('.menu-item[data-tab]');

            menuItems.forEach(item => {
                item.addEventListener('click', function () {
                    const tabId = this.getAttribute('data-tab');

                    // Update menu active state
                    menuItems.forEach(i => i.classList.remove('active'));
                    this.classList.add('active');

                    // Show corresponding tab content
                    const tabContents = document.querySelectorAll('.tab-content');
                    tabContents.forEach(tab => tab.classList.remove('active'));
                    document.getElementById(tabId).classList.add('active');
                    
                    // Load data for the active tab
                    if (tabId === 'dashboard') loadDashboard();
                    if (tabId === 'inventory') loadInventory();
                    if (tabId === 'transaction-in') loadTransactionIn();
                    if (tabId === 'transaction-out') loadTransactionOut();
                    if (tabId === 'history') loadHistory();
                });
            });

            // Setup history tabs
            const historyTabs = document.querySelectorAll('.tab[data-history-tab]');
            historyTabs.forEach(tab => {
                tab.addEventListener('click', function () {
                    historyTabs.forEach(t => t.classList.remove('active'));
                    this.classList.add('active');

                    // Filter history table based on tab
                    const tabType = this.getAttribute('data-history-tab');
                    filterHistoryTable(tabType);
                });
            });
        }

        // Load dashboard data
        function loadDashboard() {
            // Hitung statistik
            const totalProducts = products.length;
            const outOfStock = products.filter(p => p.stock === 0).length;

            // Transaksi hari ini
            const today = new Date().toISOString().split('T')[0];
            const transactionsToday = transactions.filter(t => t.date === today).length;

            // Stok hampir habis (kurang dari 5)
            const lowStock = products.filter(p => p.stock > 0 && p.stock < 5).length;

            // Update dashboard cards
            document.getElementById('total-products').textContent = totalProducts;
            document.getElementById('out-of-stock').textContent = outOfStock;
            document.getElementById('transactions-today').textContent = transactionsToday;
            document.getElementById('low-stock').textContent = lowStock;

            // Load products table
            const productsTable = document.getElementById('products-table').querySelector('tbody');
            productsTable.innerHTML = '';

            products.forEach(product => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${product.name}</td>
                    <td>${product.category}</td>
                    <td>${product.stock}</td>
                    <td>${product.location}</td>
                    <td><span class="status ${product.stock > 0 ? 'status-in' : 'status-out'}">${product.stock > 0 ? 'Tersedia' : 'Habis'}</span></td>
                    <td>
                        <button class="action-btn edit-btn" onclick="editProduct(${product.id})"><i class="fas fa-edit"></i></button>
                        <button class="action-btn delete-btn" onclick="deleteProduct(${product.id})"><i class="fas fa-trash"></i></button>
                    </td>
                `;
                productsTable.appendChild(row);
            });
        }

        // Load inventory data
        function loadInventory() {
            const inventoryTable = document.getElementById('inventory-table').querySelector('tbody');
            inventoryTable.innerHTML = '';

            products.forEach(product => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>PRD${product.id.toString().padStart(4, '0')}</td>
                    <td>${product.name}</td>
                    <td>${product.category}</td>
                    <td>${product.stock}</td>
                    <td>${product.location}</td>
                    <td>Rp ${product.price.toLocaleString('id-ID')}</td>
                    <td>
                        <button class="action-btn edit-btn" onclick="editProduct(${product.id})"><i class="fas fa-edit"></i></button>
                        <button class="action-btn delete-btn" onclick="deleteProduct(${product.id})"><i class="fas fa-trash"></i></button>
                    </td>
                `;
                inventoryTable.appendChild(row);
            });

            // Setup search functionality
            document.getElementById('inventory-search').addEventListener('input', function () {
                const searchTerm = this.value.toLowerCase();
                const rows = inventoryTable.querySelectorAll('tr');

                rows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    if (text.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        }

        // Load transaction in data
        function loadTransactionIn() {
            // Load product options
            const productSelect = document.getElementById('product-select');
            productSelect.innerHTML = '<option value="">-- Pilih Produk --</option>';

            products.forEach(product => {
                const option = document.createElement('option');
                option.value = product.id;
                option.textContent = `${product.name} (Stok: ${product.stock})`;
                productSelect.appendChild(option);
            });

            // Load transaction history
            const transactionInTable = document.getElementById('transaction-in-table').querySelector('tbody');
            if (transactionInTable) {
                transactionInTable.innerHTML = '';

                const inTransactions = transactions.filter(t => t.type === 'in');

                inTransactions.forEach(transaction => {
                    const product = products.find(p => p.id === transaction.productId);
                    if (product) {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${transaction.date}</td>
                            <td>${product.name}</td>
                            <td>${transaction.quantity}</td>
                            <td>${transaction.party}</td>
                            <td>${transaction.notes}</td>
                        `;
                        transactionInTable.appendChild(row);
                    }
                });
            }
        }

        // Load transaction out data
        function loadTransactionOut() {
            // Load product options
            const productSelect = document.getElementById('product-out-select');
            productSelect.innerHTML = '<option value="">-- Pilih Produk --</option>';

            products.forEach(product => {
                const option = document.createElement('option');
                option.value = product.id;
                option.textContent = `${product.name} (Stok: ${product.stock})`;
                productSelect.appendChild(option);
            });

            // Load transaction history
            const transactionOutTable = document.getElementById('transaction-out-table').querySelector('tbody');
            if (transactionOutTable) {
                transactionOutTable.innerHTML = '';

                const outTransactions = transactions.filter(t => t.type === 'out');

                outTransactions.forEach(transaction => {
                    const product = products.find(p => p.id === transaction.productId);
                    if (product) {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${transaction.date}</td>
                            <td>${product.name}</td>
                            <td>${transaction.quantity}</td>
                            <td>${transaction.party}</td>
                            <td>${transaction.notes}</td>
                        `;
                        transactionOutTable.appendChild(row);
                    }
                });
            }
        }

        // Load history data
        function loadHistory() {
            const historyTable = document.getElementById('history-table').querySelector('tbody');
            historyTable.innerHTML = '';

            transactions.forEach(transaction => {
                const product = products.find(p => p.id === transaction.productId);
                if (product) {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${transaction.date}</td>
                        <td><span class="status ${transaction.type === 'in' ? 'status-in' : 'status-out'}">${transaction.type === 'in' ? 'Masuk' : 'Keluar'}</span></td>
                        <td>${product.name}</td>
                        <td>${transaction.quantity}</td>
                        <td>${transaction.party}</td>
                        <td>${transaction.notes}</td>
                    `;
                    historyTable.appendChild(row);
                }
            });

            // Setup search functionality
            document.getElementById('history-search').addEventListener('input', function () {
                const searchTerm = this.value.toLowerCase();
                const rows = historyTable.querySelectorAll('tr');

                rows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    if (text.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        }

        // Filter history table based on type
        function filterHistoryTable(type) {
            const rows = document.getElementById('history-table').querySelectorAll('tbody tr');

            rows.forEach(row => {
                const typeCell = row.querySelector('td:nth-child(2)');
                if (typeCell) {
                    const rowType = typeCell.textContent.toLowerCase().includes('masuk') ? 'in' : 'out';

                    if (type === 'all' || type === rowType) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                }
            });
        }

        // Show add product modal
        function showAddProductModal() {
            document.getElementById('addProductModal').style.display = 'flex';
        }

        // Close modal
        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        // Add new product
        function addProduct() {
            const name = document.getElementById('product-name').value;
            const category = document.getElementById('product-category').value;
            const stock = parseInt(document.getElementById('initial-stock').value);
            const location = document.getElementById('product-location').value;
            const price = parseInt(document.getElementById('product-price').value);

            if (!name || !category || isNaN(stock) || !location || isNaN(price)) {
                alert('Harap isi semua field dengan benar!');
                return;
            }

            // Generate new ID
            const newId = products.length > 0 ? Math.max(...products.map(p => p.id)) + 1 : 1;

            // Add new product
            const newProduct = {
                id: newId,
                name,
                category,
                stock,
                location,
                price
            };

            products.push(newProduct);
            localStorage.setItem('products', JSON.stringify(products));

            // Reload data
            loadDashboard();
            loadInventory();
            loadTransactionIn();
            loadTransactionOut();

            // Close modal and reset form
            closeModal('addProductModal');
            document.getElementById('product-name').value = '';
            document.getElementById('product-category').value = '';
            document.getElementById('initial-stock').value = '';
            document.getElementById('product-location').value = '';
            document.getElementById('product-price').value = '';

            alert('Produk berhasil ditambahkan!');
        }

        // Edit product (placeholder)
        function editProduct(id) {
            alert(`Fitur edit produk ${id} akan segera hadir!`);
        }

        // Delete product
        function deleteProduct(id) {
            if (confirm('Apakah Anda yakin ingin menghapus produk ini?')) {
                products = products.filter(p => p.id !== id);
                localStorage.setItem('products', JSON.stringify(products));

                // Reload data
                loadDashboard();
                loadInventory();

                alert('Produk berhasil dihapus!');
            }
        }

        // Add stock (transaction in)
        function addStock() {
            const productId = parseInt(document.getElementById('product-select').value);
            const quantity = parseInt(document.getElementById('quantity-in').value);
            const supplier = document.getElementById('supplier').value;
            const date = document.getElementById('date-in').value;
            const notes = document.getElementById('notes-in').value;

            if (!productId || isNaN(quantity) || quantity <= 0 || !supplier || !date) {
                alert('Harap isi semua field dengan benar!');
                return;
            }

            // Find product
            const product = products.find(p => p.id === productId);
            if (!product) {
                alert('Produk tidak ditemukan!');
                return;
            }

            // Update stock
            product.stock += quantity;

            // Add transaction
            const newTransactionId = transactions.length > 0 ? Math.max(...transactions.map(t => t.id)) + 1 : 1;
            const newTransaction = {
                id: newTransactionId,
                type: 'in',
                productId,
                quantity,
                date,
                party: supplier,
                notes
            };

            transactions.push(newTransaction);

            // Update localStorage
            localStorage.setItem('products', JSON.stringify(products));
            localStorage.setItem('transactions', JSON.stringify(transactions));

            // Reload data
            loadDashboard();
            loadInventory();
            loadTransactionIn();
            loadHistory();

            // Reset form
            document.getElementById('product-select').value = '';
            document.getElementById('quantity-in').value = '';
            document.getElementById('supplier').value = '';
            document.getElementById('notes-in').value = '';
            document.getElementById('date-in').valueAsDate = new Date();

            alert('Stok berhasil ditambahkan!');
        }

        // Reduce stock (transaction out)
        function reduceStock() {
            const productId = parseInt(document.getElementById('product-out-select').value);
            const quantity = parseInt(document.getElementById('quantity-out').value);
            const customer = document.getElementById('customer').value;
            const date = document.getElementById('date-out').value;
            const notes = document.getElementById('notes-out').value;

            if (!productId || isNaN(quantity) || quantity <= 0 || !customer || !date) {
                alert('Harap isi semua field dengan benar!');
                return;
            }

            // Find product
            const product = products.find(p => p.id === productId);
            if (!product) {
                alert('Produk tidak ditemukan!');
                return;
            }

            // Check stock availability
            if (product.stock < quantity) {
                alert('Stok tidak mencukupi!');
                return;
            }

            // Update stock
            product.stock -= quantity;

            // Add transaction
            const newTransactionId = transactions.length > 0 ? Math.max(...transactions.map(t => t.id)) + 1 : 1;
            const newTransaction = {
                id: newTransactionId,
                type: 'out',
                productId,
                quantity,
                date,
                party: customer,
                notes
            };

            transactions.push(newTransaction);

            // Update localStorage
            localStorage.setItem('products', JSON.stringify(products));
            localStorage.setItem('transactions', JSON.stringify(transactions));

            // Reload data
            loadDashboard();
            loadInventory();
            loadTransactionOut();
            loadHistory();

            // Reset form
            document.getElementById('product-out-select').value = '';
            document.getElementById('quantity-out').value = '';
            document.getElementById('customer').value = '';
            document.getElementById('notes-out').value = '';
            document.getElementById('date-out').valueAsDate = new Date();

            alert('Stok berhasil dikurangi!');
        }
    </script>
</body>

</html>