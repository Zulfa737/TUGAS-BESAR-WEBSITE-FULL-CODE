<?php
session_start();
include 'koneksi.php';

// Cek apakah user sudah login
if(!isset($_SESSION['id_user'])) { header("location:index.php"); exit; }

$id = $_SESSION['id_user'];
$user = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM users WHERE id='$id'"));

// Kalau belum milih tapi coba buka halaman ini, tendang balik
if($user['status_vote'] == 'belum') { header("location:dashboard.php"); exit; }
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Vote Berhasil</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body class="bg-success-light" style="height: 100vh; display: flex; align-items: center; justify-content: center;">

    <div class="success-card">
        
        <div class="success-icon-box">
            <i class="bi bi-check-lg"></i>
        </div>

        <h1 class="fw-bold text-success mb-2">Vote Berhasil!</h1>
        
        <p class="text-muted mb-4 fs-5">
            Terima kasih telah berpartisipasi.<br>
            Suara Anda telah tercatat dan tidak dapat diubah.
        </p>

        <div class="user-info-box">
            <i class="bi bi-person-circle me-2"></i>
            Pemilih: <?= $user['nama_lengkap'] ?>
        </div>
        
        <div>
            <a href="logout.php" class="btn btn-back text-decoration-none">
                <i class="bi bi-arrow-left me-2"></i> Kembali ke Beranda
            </a>
        </div>

        <div style="position: absolute; top: 20px; left: 20px; width: 20px; height: 20px; background: #FFD700; border-radius: 50%; opacity: 0.5;"></div>
        <div style="position: absolute; bottom: 30px; right: 30px; width: 30px; height: 30px; background: #3b82f6; border-radius: 50%; opacity: 0.2;"></div>
    </div>

</body>
</html>