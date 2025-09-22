<?php
session_start();
if (empty($_SESSION['username'])) {
  header("Location: ../Login_Warehouse/index.php");
  exit;
}

// Ambil username dari session
$user = $_SESSION['username'];

// Mapping username ke sapaan
$sapaan = [
  "222" => "Selamat Datang Tim Inventaris",
  "333" => "Selamat Datang Mas Dion",
  "444" => "Selamat Datang Magang Warehouse",
  "111" => "Selamat Datang Mas Acil",
  "555" => "Selamat Datang Tim Distribusi"
];

$welcome_text = $sapaan[$user] ?? "Selamat Datang Warehouse";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard Modem</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: radial-gradient(circle at top left, #0f172a, #1e293b 60%, #0f172a);
      color: var(--text-primary);
      min-height: 100vh;
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

      0%,
      100% {
        transform: translate(0, 0) rotate(0deg);
      }

      33% {
        transform: translate(30px, 50px) rotate(120deg);
      }

      66% {
        transform: translate(-20px, 80px) rotate(240deg);
      }
    }

    /* Sidebar */
    .sidebar {
      height: 100vh;
      background: rgba(30, 41, 59, 0.9);
      backdrop-filter: blur(10px);
      padding: 25px 0;
      color: var(--text-primary);
      box-shadow: 5px 0 30px rgba(99, 102, 241, 0.2);
      position: fixed;
      width: 280px;
      z-index: 1000;
      border-right: 1px solid var(--dark-border);
      transition: all 0.3s ease;
    }

    .sidebar-header {
      text-align: center;
      padding: 0 20px 20px;
      margin-bottom: 25px;
      border-bottom: 1px solid var(--dark-border);
    }

    .sidebar-header img {
      width: 140px;
      margin-bottom: 15px;
      filter: brightness(0) invert(1);
    }

    .sidebar-header h4 {
      font-weight: 600;
      font-size: 1.2rem;
    }

    .nav-container {
      padding: 0 15px;
    }

    .nav-item {
      margin-bottom: 8px;
    }

    .nav-link {
      display: flex;
      align-items: center;
      color: var(--text-secondary);
      text-decoration: none;
      padding: 14px 20px;
      border-radius: 12px;
      transition: all 0.4s ease;
      font-weight: 500;
    }

    .nav-link i {
      margin-right: 12px;
      font-size: 1.2rem;
      width: 24px;
      text-align: center;
      transition: transform 0.4s;
    }

    .nav-link:hover,
    .nav-link.active {
      background: rgba(99, 102, 241, 0.15);
      color: var(--text-primary);
      box-shadow: inset 0 0 15px rgba(99, 102, 241, 0.3);
      transform: translateX(8px) scale(1.02);
    }

    .nav-link:hover i {
      transform: scale(1.2) rotate(10deg);
    }

    .sub-menu {
      padding-left: 30px;
      margin-top: 5px;
    }

    .sub-menu .nav-link {
      padding: 10px 15px;
      font-size: 0.9rem;
    }

    .sidebar-footer {
      position: absolute;
      bottom: 20px;
      width: 100%;
      padding: 0 20px;
    }

    /* Main Content */
    .main-content {
      margin-left: 280px;
      padding: 30px;
      min-height: 100vh;
    }

    /* Welcome card */
    .welcome-card {
      background: rgba(30, 41, 59, 0.8);
      border: 1px solid var(--dark-border);
      border-radius: 20px;
      padding: 30px;
      margin-bottom: 40px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
      overflow: hidden;
      opacity: 0;
      transform: translateY(30px);
      animation: fadeInUp 0.8s ease forwards;
    }

    .welcome-content h2 {
      font-weight: 700;
      font-size: 2rem;
      background: linear-gradient(45deg, var(--text-primary), var(--primary-glow));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    .welcome-content p {
      color: var(--text-secondary);
    }

    /* Logo 3D */
    .logo-container {
      text-align: center;
      margin: 40px 0;
    }

    .logo-3d {
      width: 220px;
      height: 220px;
      animation: float-3d 6s ease-in-out infinite;
      border-radius: 20px;
      background: linear-gradient(135deg, var(--dark-card), var(--dark-border));
      border: 2px solid rgba(99, 102, 241, 0.3);
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: 2.5rem;
      font-weight: bold;
      color: var(--text-primary);
      position: relative;
      overflow: hidden;
      filter: drop-shadow(0 0 20px rgba(99, 102, 241, 0.4)) drop-shadow(0 0 30px rgba(236, 72, 153, 0.3));
      opacity: 0;
      transform: translateY(30px);
      animation: fadeInUp 0.8s ease forwards;
      animation-delay: 0.3s;
    }

    @keyframes float-3d {

      0%,
      100% {
        transform: translateY(0) rotateY(0deg) rotateX(5deg);
      }

      50% {
        transform: translateY(-15px) rotateY(180deg) rotateX(5deg);
      }
    }

    /* Features */
    .features-section {
      margin-top: 40px;
    }

    .section-title {
      font-weight: 600;
      margin-bottom: 25px;
      text-align: center;
      color: var(--text-primary);
    }

    .section-title::after {
      content: '';
      display: block;
      width: 60px;
      height: 4px;
      margin: 8px auto 0;
      border-radius: 2px;
      background: linear-gradient(to right, var(--primary), var(--accent));
    }

    .feature-card {
      background: rgba(30, 41, 59, 0.8);
      border: 1px solid rgba(99, 102, 241, 0.3);
      border-radius: 20px;
      padding: 30px 25px;
      transition: all 0.4s ease;
      text-align: center;
      opacity: 0;
      transform: translateY(30px);
      animation: fadeInUp 0.8s ease forwards;
    }

    .feature-card:nth-child(1) {
      animation-delay: 0.5s;
    }

    .feature-card:nth-child(2) {
      animation-delay: 0.7s;
    }

    .feature-card:nth-child(3) {
      animation-delay: 0.9s;
    }

    .feature-card:hover {
      transform: translateY(-12px) scale(1.03);
      box-shadow: 0 15px 40px rgba(99, 102, 241, 0.25), 0 0 25px rgba(236, 72, 153, 0.2);
    }

    .icon-container {
      width: 80px;
      height: 80px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 20px;
      font-size: 2rem;
      color: #fff;
      background: linear-gradient(135deg, var(--primary), var(--accent));
      transition: transform 0.4s ease, box-shadow 0.4s ease;
    }

    .feature-card:hover .icon-container {
      transform: rotate(15deg) scale(1.1);
      box-shadow: 0 0 25px rgba(236, 72, 153, 0.6);
    }

    .btn-action {
      border: none;
      border-radius: 50px;
      padding: 10px 25px;
      background: linear-gradient(135deg, #6366f1, #ec4899);
      color: white;
      font-weight: 500;
      transition: all 0.3s ease;
      box-shadow: 0 5px 15px rgba(99, 102, 241, 0.4);
    }

    .btn-action:hover {
      box-shadow: 0 8px 25px rgba(236, 72, 153, 0.6), 0 0 20px rgba(99, 102, 241, 0.6);
      transform: translateY(-3px) scale(1.05);
    }

    /* Panduan Section */
    .panduan-section {
      margin-bottom: 40px;
    }
    
    .panduan-row {
      display: flex;
      flex-wrap: wrap;
      margin: 0 -15px;
    }
    
    .panduan-col {
      flex: 1;
      min-width: 300px;
      padding: 0 15px;
      margin-bottom: 30px;
    }

    /* Mobile */
    .menu-toggle {
      display: none;
      position: fixed;
      top: 20px;
      left: 20px;
      z-index: 1100;
      background: linear-gradient(135deg, var(--primary), var(--accent));
      color: #fff;
      border: none;
      border-radius: 50%;
      width: 50px;
      height: 50px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
      align-items: center;
      justify-content: center;
    }

    @media(max-width:992px) {
      .sidebar {
        transform: translateX(-100%);
        width: 260px;
      }

      .sidebar.active {
        transform: translateX(0);
      }

      .main-content {
        margin-left: 0;
      }

      .menu-toggle {
        display: flex;
      }
      
      .panduan-col {
        flex: 100%;
      }
    }

    @keyframes fadeInUp {
      to {
        opacity: 1;
        transform: translateY(0);
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

  <button class="menu-toggle" id="menuToggle"><i class="bi bi-list"></i></button>

  <div class="sidebar" id="sidebar">
    <div class="sidebar-header">
      <img src="Logo.png" alt="Logo">
      <h4>Warehouse System</h4>
    </div>
    <div class="nav-container">
      <div class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#qcMenu"><i class="bi bi-hdd-network"></i><span>ONT</span><i
            class="bi bi-chevron-down ms-auto"></i></a>
        <div class="collapse sub-menu" id="qcMenu">
          <a href="GriyaNet.php" class="nav-link"><i class="bi bi-dot"></i>GriyaNet</a>
          <a href="Dasarata.php" class="nav-link"><i class="bi bi-dot"></i>Dasarata</a>
          <a href="KiosNet.php" class="nav-link"><i class="bi bi-dot"></i>KiosNet</a>
        </div>
      </div>
      <div class="nav-item"><a href="Monitoring.php" class="nav-link"><i class="bi bi-diagram-3"></i>Inventory PDM</a></div>
      <div class="nav-item"><a href="Tiangwarehouse.php" class="nav-link"><i class="bi bi-diagram-3"></i>Tiang
          Backbone</a></div>
      <div class="nav-item sidebar-footer"><a href="logout.php" class="nav-link"><i
            class="bi bi-box-arrow-right"></i>Logout</a></div>
    </div>
  </div>

  <div class="main-content">
    <div class="welcome-card">
      <div class="welcome-content">
        <h2><?php echo $welcome_text; ?></h2>
        <p>Pilih menu untuk mengelola QC Modem</p>
      </div>
    </div>

  
    <!-- Panduan Section - QC, Inventaris, dan Distribusi dalam satu baris -->
    <div class="panduan-section">
      <h3 class="section-title">Panduan Sistem</h3>
      <div class="panduan-row">
        <!-- Panduan QC -->
        <div class="panduan-col">
          <div class="feature-card">
            <div class="icon-container"><i class="bi bi-file-earmark-text"></i></div>
            <h5>Panduan Quality Control</h5>
            <p>Tata cara panduan QC dengan baik dan benar sesuai dengan SOP</p>
            <a href="PanduanQC.php" class="btn btn-action">Masuk</a>
          </div>
        </div>
        
        <!-- Panduan Inventaris -->
        <div class="panduan-col">
          <div class="feature-card">
            <div class="icon-container"><i class="bi bi-clipboard-data"></i></div>
            <h5>Panduan Inventaris</h5>
            <p>Tata cara panduan Inventaris dengan baik dan benar sesuai dengan SOP</p>
            <a href="PanduanInven.php" class="btn btn-action">Masuk</a>
          </div>
        </div>
        
        <!-- Panduan Distribusi -->
        <div class="panduan-col">
          <div class="feature-card">
            <div class="icon-container"><i class="bi bi-truck"></i></div>
            <h5>Panduan Distribusi</h5>
            <p>Tata cara panduan Distribusi dengan baik dan benar sesuai dengan SOP</p>
            <a href="PanduanDistri.php" class="btn btn-action">Masuk</a>
          </div>
        </div>
      </div>
    </div>


    <div class="features-section">
      <h3 class="section-title">QC Modem Settings</h3>
      <div class="row">
        <div class="col-lg-4 col-md-6 mb-4">
          <div class="feature-card">
            <div class="icon-container"><i class="bi bi-hdd-network"></i></div>
            <h5>QC Modem GriyaNet</h5>
            <p>Kelola pengaturan dan quality control untuk modem GriyaNet</p>
            <a href="GriyaNet.php" class="btn btn-action">Masuk</a>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-4">
          <div class="feature-card">
            <div class="icon-container"><i class="bi bi-hdd-rack"></i></div>
            <h5>QC Modem Dasarata</h5>
            <p>Kelola pengaturan dan quality control untuk modem Dasarata</p>
            <a href="Dasarata.php" class="btn btn-action">Masuk</a>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-4">
          <div class="feature-card">
            <div class="icon-container"><i class="bi bi-hdd-stack"></i></div>
            <h5>QC Modem KiosNet</h5>
            <p>Kelola pengaturan dan quality control untuk modem KiosNet</p>
            <a href="KiosNet.php" class="btn btn-action">Masuk</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.getElementById('menuToggle').addEventListener('click', () => {
      document.getElementById('sidebar').classList.toggle('active');
    });
    document.addEventListener('click', function (e) {
      const sidebar = document.getElementById('sidebar');
      const toggleBtn = document.getElementById('menuToggle');
      if (window.innerWidth < 992 && !sidebar.contains(e.target) && e.target !== toggleBtn && !toggleBtn.contains(e.target)) {
        sidebar.classList.remove('active');
      }
    });
  </script>
</body>

</html>