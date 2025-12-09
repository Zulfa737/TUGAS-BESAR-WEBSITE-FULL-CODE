<?php
session_start();

// 1. Hapus Semua Session
$_SESSION = [];
session_unset();
session_destroy();

// 2. Hapus Cookie (Caranya dengan set waktu ke masa lalu)
setcookie('id_user', '', time() - 3600);
setcookie('key', '', time() - 3600);

// 3. Lempar ke Login
header("location:index.php");
exit;
?>