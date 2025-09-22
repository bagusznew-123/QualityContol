<?php
session_start();
include "koneksi.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Ganti tb_user jadi tblogin, dan sesuaikan nama kolom
    $query = mysqli_query($koneksi, "SELECT * FROM tblogin WHERE User='$username' LIMIT 1");
    $user = mysqli_fetch_assoc($query);

    if ($user && $password === $user['Password']) {
        // Simpan session
        $_SESSION['username'] = $user['User'];
        $_SESSION['role']     = $user['role'] ?? 'user'; // kalau ada kolom role

        header("Location: indexmenu.php");
        exit;
    } else {
        echo "<script>alert('Username atau password salah!'); window.location='index.php';</script>";
    }
}
?>

