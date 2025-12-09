<?php
session_start();
include 'koneksi.php';

if(!isset($_SESSION['role']) || $_SESSION['role'] != "admin"){ header("location:index.php"); exit; }

// LOGIC SIMPAN
if(isset($_POST['simpan'])){
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $pass = $_POST['pass'];
    
    $query = "INSERT INTO users (nim, password, nama_lengkap, role) VALUES ('$nim', '$pass', '$nama', 'mahasiswa')";
    
    if(mysqli_query($koneksi, $query)){
        echo "<script>alert('Berhasil!'); window.location='users_admin.php';</script>";
    } else {
        echo "<script>alert('Gagal! NIM sudah ada.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Tambah Manual</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

    <div class="sidebar">
        <div class="p-4 mb-3 d-flex align-items-center gap-2">
            <img src="https://cdn-icons-png.flaticon.com/512/2231/2231649.png" width="30">
            <h5 class="fw-bold m-0">Pemilu HMJ</h5>
        </div>
        <nav class="nav flex-column">
            <a class="nav-link" href="dashboard_admin.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
            <a class="nav-link active" href="users_admin.php"><i class="bi bi-people"></i> User Management</a>
            <a class="nav-link" href="kandidat_admin.php"><i class="bi bi-bar-chart-steps"></i> Manajemen Kandidat</a>
            <a class="nav-link text-danger mt-4" href="logout.php"><i class="bi bi-box-arrow-left"></i> Logout</a>
        </nav>
    </div>

    <div class="main-content">
        <div class="card border-0 shadow-sm rounded-4 p-4 mx-auto" style="max-width: 600px;">
            <div class="mb-4">
                <a href="users_admin.php" class="text-decoration-none text-muted small"><i class="bi bi-arrow-left"></i> Kembali</a>
                <h4 class="fw-bold mt-2">Tambah User Manual</h4>
            </div>

            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">NIM</label>
                    <input type="text" name="nim" class="form-control bg-light" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control bg-light" required>
                </div>
                <div class="mb-4">
                    <label class="form-label">Password</label>
                    <input type="text" name="pass" class="form-control bg-light" required>
                </div>
                <button type="submit" name="simpan" class="btn btn-primary w-100 fw-bold">Simpan Data</button>
            </form>
        </div>
    </div>

</body>
</html>