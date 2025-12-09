<?php
session_start();
include 'koneksi.php';

// Pastikan user sudah login
if(!isset($_SESSION['id_user'])) {
    header("location:index.php");
    exit;
}

$id_user = $_SESSION['id_user'];

// PERBAIKAN 1: Mengambil ID dari URL. 
// Di URL browser tertulis '?id=1', jadi kita pakai $_GET['id']
$id_kandidat = $_GET['id']; 

// Validasi status vote
$cek = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT status_vote FROM users WHERE id='$id_user'"));

if ($cek['status_vote'] == 'belum') {
    // 1. Tambah suara kandidat
    mysqli_query($koneksi, "UPDATE kandidat SET jumlah_suara = jumlah_suara + 1 WHERE id='$id_kandidat'");
    
    // PERBAIKAN 2: Menghapus bagian 'waktu_vote=NOW()'
    // Karena kolom 'waktu_vote' tidak ada di database Anda.
    mysqli_query($koneksi, "UPDATE users SET status_vote='sudah' WHERE id='$id_user'");
}

header("location:dashboard.php");
?>