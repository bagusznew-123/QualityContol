<?php
session_start();
session_destroy(); // hapus semua session
header("Location: index.php"); // arahkan balik ke halaman login
exit;
?>
