<?php
session_start();
include 'koneksi.php';

// Cek Role Admin
if(!isset($_SESSION['role']) || $_SESSION['role'] != "admin"){ 
    header("location:index.php"); exit; 
}

// LOGIC HAPUS USER (Tetap ditaruh di sini agar bisa hapus dari tabel)
if(isset($_GET['hapus_user'])){
    $id = $_GET['hapus_user'];
    mysqli_query($koneksi, "DELETE FROM users WHERE id='$id'");
    echo "<script>window.location='users_admin.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>User Management</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

    <div class="overlay" onclick="toggleSidebar()"></div>

    <div class="sidebar" id="mySidebar">
        <div class="p-4 mb-3 d-flex align-items-center gap-2 justify-content-between">
            <div class="d-flex align-items-center gap-2">
                <img src="https://cdn-icons-png.flaticon.com/512/2231/2231649.png" width="30">
                <h5 class="fw-bold m-0">Pemilu HMJ</h5>
            </div>
            <button class="btn btn-sm btn-light d-md-none" onclick="toggleSidebar()"><i class="bi bi-x-lg"></i></button>
        </div>
        <nav class="nav flex-column">
            <a class="nav-link" href="dashboard_admin.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
            <a class="nav-link active" href="users_admin.php"><i class="bi bi-people"></i> User Management</a>
            <a class="nav-link" href="kandidat_admin.php"><i class="bi bi-bar-chart-steps"></i> Manajemen Kandidat</a>
            <a class="nav-link text-danger mt-4" href="logout.php"><i class="bi bi-box-arrow-left"></i> Logout</a>
        </nav>
    </div>

    <div class="main-content">
        
        <div class="d-flex align-items-center justify-content-between d-md-none mb-4">
            <h4 class="fw-bold m-0">User Mgmt</h4>
            <button class="btn btn-primary" onclick="toggleSidebar()"><i class="bi bi-list"></i> Menu</button>
        </div>

        <h3 class="fw-bold mb-4 d-none d-md-block">User Management</h3>
        
        <div class="row g-4 mb-5 justify-content-center">
            
            <div class="col-md-6 col-lg-5">
                <a href="users_manual.php" class="card p-4 border-0 shadow-sm rounded-4 text-decoration-none h-100 menu-card">
                    <div class="d-flex align-items-center gap-4">
                        <div class="icon-manual">
                            <i class="bi bi-keyboard"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold text-dark mb-1">Tambah Manual</h5>
                            <small class="text-muted">Input data via Komputer/Laptop.</small>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-6 col-lg-5">
                <a href="users_qr.php" class="card p-4 border-0 shadow-sm rounded-4 text-decoration-none h-100 menu-card">
                    <div class="d-flex align-items-center gap-4">
                        <div class="icon-qr">
                            <i class="bi bi-qr-code-scan"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold text-dark mb-1">Mode QR Code</h5>
                            <small class="text-muted">Scan via HP (Otomatis).</small>
                        </div>
                    </div>
                </a>
            </div>

        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-header bg-white p-4 border-0">
                <h5 class="fw-bold m-0">Daftar Mahasiswa Terdaftar</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-custom m-0 align-middle text-nowrap">
                    <thead class="bg-light">
                        <tr>
                            <th class="p-3 ps-4">NIM</th>
                            <th class="p-3">Nama</th>
                            <th class="p-3">Password</th>
                            <th class="p-3">Status</th>
                            <th class="p-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $users = mysqli_query($koneksi, "SELECT * FROM users WHERE role='mahasiswa' ORDER BY id DESC");
                        while($u = mysqli_fetch_assoc($users)) { 
                        ?>
                        <tr>
                            <td class="p-3 ps-4 fw-bold"><?= $u['nim'] ?></td>
                            <td class="p-3"><?= $u['nama_lengkap'] ?></td>
                            <td class="p-3 text-muted small"><?= $u['password'] ?></td>
                            <td class="p-3">
                                <?php if($u['status_vote']=='sudah') { ?>
                                    <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill">Sudah Memilih</span>
                                <?php } else { ?>
                                    <span class="badge bg-danger-subtle text-danger px-3 py-2 rounded-pill">Belum</span>
                                <?php } ?>
                            </td>
                            <td class="p-3">
                                <a href="users_admin.php?hapus_user=<?= $u['id'] ?>" class="btn btn-light text-danger btn-sm" onclick="return confirm('Hapus user ini?')"><i class="bi bi-trash-fill"></i></a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            document.getElementById('mySidebar').classList.toggle('active');
            document.querySelector('.overlay').classList.toggle('active');
        }
    </script>
</body>
</html>