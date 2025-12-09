<?php
session_start();
include 'koneksi.php';

// Cek Admin
if(!isset($_SESSION['role']) || $_SESSION['role'] != "admin"){ 
    header("location:index.php"); exit; 
}

// Ambil Data Berdasarkan ID
$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM kandidat WHERE id='$id'"));
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Edit Kandidat</title>
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
            <h4 class="fw-bold m-0">Edit Data</h4>
            <button class="btn btn-primary" onclick="toggleSidebar()">
                <i class="bi bi-list"></i> Menu
            </button>
        </div>

        <div class="card border-0 shadow-sm rounded-4 p-4 mx-auto" style="max-width: 900px;">
            <div class="d-flex align-items-center gap-2 mb-4 border-bottom pb-3">
                <i class="bi bi-pencil-square fs-3 text-primary"></i>
                <h4 class="fw-bold m-0">Edit Data Kandidat</h4>
            </div>

            <form action="kandidat_proses.php?aksi=update" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $data['id'] ?>">
                <input type="hidden" name="foto_lama" value="<?= $data['foto'] ?>">

                <div class="row g-4"> <div class="col-lg-8 order-2 order-lg-1">
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label class="form-label fw-bold">Nama Kandidat</label>
                                <input type="text" name="nama" class="form-control bg-light" value="<?= $data['nama_calon'] ?>" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Angkatan</label>
                                <input type="number" name="angkatan" class="form-control bg-light" value="<?= $data['angkatan'] ?>" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Visi</label>
                            <textarea name="visi" class="form-control bg-light" rows="3" required><?= $data['visi'] ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Misi</label>
                            <textarea name="misi" class="form-control bg-light" rows="5" required><?= $data['misi'] ?></textarea>
                        </div>
                    </div>

                    <div class="col-lg-4 text-center order-1 order-lg-2 mb-4 mb-lg-0">
                        <div class="p-3 border rounded-3 bg-light h-100 d-flex flex-column justify-content-center">
                            <label class="form-label fw-bold d-block text-center mb-3">Foto Saat Ini</label>
                            
                            <div style="height: 200px; width: 100%; overflow: hidden; border-radius: 10px;" class="mb-3 border bg-white mx-auto">
                                <img src="img/<?= $data['foto'] ?>" class="w-100 h-100 object-fit-cover">
                            </div>
                            
                            <label class="btn btn-outline-primary w-100 mt-auto" for="uploadFoto">
                                <i class="bi bi-camera"></i> Ganti Foto
                            </label>
                            <input type="file" name="foto" id="uploadFoto" class="d-none" onchange="previewImage(this)">
                            <small class="text-muted d-block mt-2" id="fileName">Biarkan jika tidak ganti</small>
                        </div>
                    </div>
                </div>

                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary px-4 fw-bold w-100 w-md-auto">
                        <i class="bi bi-save"></i> Simpan Perubahan
                    </button>
                    <a href="kandidat_admin.php" class="btn btn-light border px-4 fw-bold w-100 w-md-auto">Batal</a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function toggleSidebar() {
            document.getElementById('mySidebar').classList.toggle('active');
            document.querySelector('.overlay').classList.toggle('active');
        }

        function previewImage(input) {
            if (input.files && input.files[0]) {
                document.getElementById('fileName').innerText = "File dipilih: " + input.files[0].name;
            }
        }
    </script>

</body>
</html>