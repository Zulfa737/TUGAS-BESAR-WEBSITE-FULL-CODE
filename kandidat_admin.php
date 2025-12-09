<?php
session_start();
include 'koneksi.php';

// Cek Admin
if(!isset($_SESSION['role']) || $_SESSION['role'] != "admin"){ 
    header("location:index.php"); exit; 
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Manajemen Kandidat</title>
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
            <button class="btn btn-sm btn-light d-md-none" onclick="toggleSidebar()">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <nav class="nav flex-column">
            <a class="nav-link" href="dashboard_admin.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
            <a class="nav-link" href="users_admin.php"><i class="bi bi-people"></i> User Management</a>
            <a class="nav-link active" href="kandidat_admin.php"><i class="bi bi-bar-chart-steps"></i> Manajemen Kandidat</a>
            <a class="nav-link text-danger mt-4" href="logout.php"><i class="bi bi-box-arrow-left"></i> Logout</a>
        </nav>
    </div>

    <div class="main-content">
        
        <div class="d-flex align-items-center justify-content-between d-md-none mb-4">
            <h4 class="fw-bold m-0">Kandidat</h4>
            <button class="btn btn-primary" onclick="toggleSidebar()">
                <i class="bi bi-list"></i> Menu
            </button>
        </div>

        <div class="mb-4 d-none d-md-block">
            <h2 class="fw-bold">Manajemen Kandidat</h2>
            <p class="text-muted">Kelola data kandidat dengan mudah</p>
        </div>

        <div class="row g-4">
            
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <h5 class="fw-bold mb-3"><i class="bi bi-plus-circle text-primary"></i> Tambah Kandidat</h5>
                    
                    <form action="kandidat_proses.php?aksi=tambah" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Nama Kandidat</label>
                            <input type="text" name="nama" class="form-control bg-light" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Angkatan</label>
                            <input type="number" name="angkatan" class="form-control bg-light" placeholder="Contoh: 2023" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Visi</label>
                            <textarea name="visi" class="form-control bg-light" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Misi</label>
                            <textarea name="misi" class="form-control bg-light" rows="4" required></textarea>
                        </div>
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted">Foto</label>
                            <input type="file" name="foto" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 fw-bold">Simpan</button>
                    </form>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <h5 class="fw-bold mb-4">Daftar Kandidat</h5>
                    
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-3" style="min-width: 80px;">Foto</th>
                                    <th style="min-width: 200px;">Info Kandidat</th>
                                    <th class="text-end pe-3" style="min-width: 120px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $kandidat = mysqli_query($koneksi, "SELECT * FROM kandidat ORDER BY id ASC");
                                while($row = mysqli_fetch_assoc($kandidat)) { 
                                ?>
                                <tr>
                                    <td class="ps-3">
                                        <img src="img/<?= $row['foto'] ?>" width="60" height="60" class="rounded-3 object-fit-cover border">
                                    </td>
                                    <td>
                                        <h6 class="fw-bold mb-1"><?= $row['nama_calon'] ?></h6>
                                        <span class="badge bg-primary-subtle text-primary mb-2">Angkatan <?= $row['angkatan'] ?></span>
                                        
                                        <small class="text-muted d-block text-truncate" style="max-width: 200px;">
                                            <?= $row['visi'] ?>
                                        </small>
                                    </td>
                                    <td class="text-end pe-3">
                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="kandidat_edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm text-white">
                                                <i class="bi bi-pencil-fill"></i>
                                            </a>
                                            <a href="kandidat_proses.php?aksi=hapus&id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus permanen?')">
                                                <i class="bi bi-trash-fill"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
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