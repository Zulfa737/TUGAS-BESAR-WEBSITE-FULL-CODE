<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_hmj"; // <--- SUDAH DIGANTI KE DB_HMJ

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    die("Gagal connect database: " . mysqli_connect_error());
}
?>