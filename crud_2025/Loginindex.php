<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Warehouse</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    :root {
      --bg-image: url(''); /* Ganti background */
      --bg-opacity: 0.1;
      --bg-size: 40%;

      --logo-size: 100px;     /* Ukuran lingkaran logo */
      --logo-img-size: 80%;   /* Ukuran gambar di dalam logo */
      --form-width: 450px;    /* Lebar form login */
    }

    body {
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(135deg, rgba(223, 144, 55, 0.9), rgba(59, 101, 216, 0.9), rgba(36, 36, 62, 0.9)),
                  var(--bg-image) center/var(--bg-size) no-repeat;
      position: relative;
      overflow: hidden;
    }

    .overlay {
      position: absolute;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: rgba(0,0,0,var(--bg-opacity));
      z-index: 0;
    }

    .login-container {
      position: relative;
      max-width: var(--form-width);
      width: 100%;
      padding: 20px;
      z-index: 2;
    }

    .login-card {
      background: rgba(255,255,255,0.08);
      backdrop-filter: blur(14px);
      border-radius: 20px;
      padding: 45px 35px;
      box-shadow: 0 15px 40px rgba(0,0,0,0.4);
      border: 1px solid rgba(255,255,255,0.15);
      position: relative;
      overflow: hidden;
      transition: 0.3s ease;
    }

    .login-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 20px 50px rgba(0,0,0,0.5);
    }

    .login-card::before {
      content: '';
      position: absolute;
      top: -50%; left: -50%;
      width: 200%; height: 200%;
      background: linear-gradient(45deg, transparent, rgba(255,255,255,0.15), transparent);
      transform: rotate(45deg);
      animation: shine 4s infinite linear;
      z-index: 0;
    }

    @keyframes shine {
      0% { transform: rotate(45deg) translateX(-100%); }
      100% { transform: rotate(45deg) translateX(100%); }
    }

    .login-content { position: relative; z-index: 1; }
    .logo-container { text-align: center; margin-bottom: 30px; }

    .logo {
      width: var(--logo-size);
      height: var(--logo-size);
      border-radius: 50%;
      background: linear-gradient(145deg, #6a11cb, #2575fc);
      margin: 10px auto;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 8px 20px rgba(106,17,203,0.5);
      overflow: hidden;
    }

    .logo img {
      width: var(--logo-img-size);
      height: var(--logo-img-size);
      object-fit: contain;
    }

    .logo-text { color: white; font-size: 28px; font-weight: 700; letter-spacing: 1px; }
    .logo-subtext { color: rgba(255,255,255,0.7); font-size: 14px; }

    .form-group { position: relative; margin-bottom: 25px; }

    .form-control {
      background: rgba(255,255,255,0.1);
      border: 1px solid rgba(255,255,255,0.2);
      border-radius: 12px;
      padding: 15px 15px 15px 50px;
      color: white;
      font-size: 16px;
    }

    .form-control:focus {
      background: rgba(255,255,255,0.15);
      border-color: rgba(255,255,255,0.4);
      box-shadow: 0 0 15px rgba(106,17,203,0.4);
      color: white;
    }

    .form-control::placeholder { color: rgba(255,255,255,0.6); }

    .input-icon {
      position: absolute;
      left: 15px; top: 50%;
      transform: translateY(-50%);
      color: rgba(255,255,255,0.7);
      font-size: 20px;
    }

    .login-btn {
      background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
      border: none; border-radius: 12px;
      padding: 16px; color: white; font-weight: 600; width: 100%;
      box-shadow: 0 8px 20px rgba(37,117,252,0.3);
      letter-spacing: 1px; font-size: 16px;
      position: relative; overflow: hidden;
    }

    .login-btn:hover {
      transform: translateY(-3px);
      box-shadow: 0 12px 30px rgba(37,117,252,0.5);
    }

    .login-footer { text-align: center; margin-top: 25px; color: rgba(255,255,255,0.7); font-size: 14px; }

    /* Responsive */
    @media (max-width: 576px) {
      :root {
        --logo-size: 70px;
        --logo-img-size: 60%;
        --form-width: 90%;
      }
      .login-card { padding: 30px 20px; }
      .logo-text { font-size: 24px; }
    }
  </style>
</head>
<body>
  <div class="overlay"></div>

  <div class="login-container">
    <div class="login-card">
      <div class="login-content">
        <div class="logo-container">
          <div class="logo">
            <img src="logo.png" alt="Logo">
          </div>
          <div class="logo-text">Warehouse Login</div>
          <div class="logo-subtext">Access your management dashboard</div>
        </div>

        <form action="login_proses.php" method="POST">
          <div class="form-group">
            <i class="bi bi-person-fill input-icon"></i>
            <input type="text" class="form-control" name="username" placeholder="Username" required>
          </div>

          <div class="form-group">
            <i class="bi bi-lock-fill input-icon"></i>
            <input type="password" class="form-control" name="password" placeholder="Password" required>
          </div>

          <button type="submit" class="login-btn">Sign In</button>
        </form>

        <div class="login-footer">&copy; 2025 Warehouse Management System</div>
      </div>
    </div>
  </div>
</body>
</html>
