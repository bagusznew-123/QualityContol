<?php
session_start();
session_destroy();

// balik ke halaman menu utama
header("Location: indexmenu.php");
exit;
?>
