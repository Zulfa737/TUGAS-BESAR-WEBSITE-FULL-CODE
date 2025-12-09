<?php
session_start();
include 'koneksi.php';

// Cek Login
if(!isset($_SESSION['role']) || $_SESSION['role'] != "mahasiswa"){ 
    header("location:index.php"); 
    exit; 
}

$id_user = $_SESSION['id_user'];
$user = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM users WHERE id='$id_user'"));

// Jika sudah memilih, lempar ke halaman sukses
if($user['status_vote'] == 'sudah') {
    header("location:sukses.php");
    exit();
}

$kandidat = mysqli_query($koneksi, "SELECT * FROM kandidat ORDER BY id ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Dashboard Pemilihan HMJ</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

    <div class="hero-fullscreen">
        <div class="bubble bubble-1"></div>
        <div class="bubble bubble-2"></div>

        <div class="hero-content">
            <img src="https://cdn-icons-png.flaticon.com/512/2231/2231649.png" width="100" class="mb-4 bg-white rounded-circle p-2 shadow" style="animation: float 4s infinite;">
            
            <h1 class="fw-bold display-3 mb-3">PEMILIHAN KETUA<br>HMJ 2025/2026</h1>
            
            <p class="fs-4 opacity-75 mb-4">Suara Anda menentukan masa depan Himpunan.<br>Pilih dengan hati nurani.</p>
            <a href="#kandidat-list" class="btn-hero">Mulai Kenali Kandidat <i class="bi bi-arrow-down-circle ms-2"></i></a>
        </div>
    </div>

    <div class="container py-5" id="kandidat-list">
        
        <div class="text-center mb-5 reveal">
            <h2 class="fw-bold text-primary display-6">Aturan Voting</h2>
            <p class="text-muted">Pastikan Anda memahami aturan berikut sebelum melakukan pemilihan</p>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-md-3 reveal delay-100">
                <div class="rule-card">
                    <div class="icon-gradient"><i class="bi bi-check-circle-fill"></i></div>
                    <h5>Satu Suara</h5>
                    <p class="text-muted small mb-0">Setiap pemilih hanya bisa memilih 1 kali.</p>
                </div>
            </div>
            <div class="col-md-3 reveal delay-200">
                <div class="rule-card">
                    <div class="icon-gradient"><i class="bi bi-lock-fill"></i></div>
                    <h5>Final</h5>
                    <p class="text-muted small mb-0">Vote bersifat final dan tidak bisa diubah.</p>
                </div>
            </div>
            <div class="col-md-3 reveal delay-300">
                <div class="rule-card">
                    <div class="icon-gradient"><i class="bi bi-book-half"></i></div>
                    <h5>Baca Visi Misi</h5>
                    <p class="text-muted small mb-0">Pastikan membaca visi & misi setiap kandidat.</p>
                </div>
            </div>
            <div class="col-md-3 reveal delay-400">
                <div class="rule-card">
                    <div class="icon-gradient"><i class="bi bi-shield-lock-fill"></i></div>
                    <h5>Rahasia</h5>
                    <p class="text-muted small mb-0">Vote Anda bersifat rahasia dan disimpan otomatis.</p>
                </div>
            </div>
        </div>

        <hr class="my-5 opacity-25">

        <div class="text-center mb-5 reveal">
            <h2 class="fw-bold text-primary display-6">Pengenalan Kandidat</h2>
            <p class="text-muted">Kenali visi, misi, dan program kerja masing-masing kandidat</p>
        </div>

        <?php 
        $no = 1;
        while($row = mysqli_fetch_assoc($kandidat)) { 
            if($no % 2 != 0) { 
        ?>
            <div class="row align-items-center mb-5 reveal-left">
                <div class="col-lg-5 mb-4 mb-lg-0">
                    <div class="photo-card"> 
                        <img src="img/<?= $row['foto'] ?>" alt="Foto <?= $row['nama_calon'] ?>">
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="candidate-card"> 
                        <div class="d-flex align-items-center mb-4">
                            <div class="number-badge-box"><?= $no ?></div>
                            <div>
                                <h3 class="fw-bold text-primary m-0"><?= $row['nama_calon'] ?></h3>
                                <span class="badge bg-secondary opacity-75">Angkatan <?= $row['angkatan'] ?></span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-lightning-fill text-warning me-2 fs-5"></i>
                                <span class="label-visi">Visi</span>
                            </div>
                            <p class="text-muted ms-1"><?= $row['visi'] ?></p>
                        </div>
                        <div>
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-list-ul text-primary me-2 fs-5"></i>
                                <span class="label-misi">Misi</span>
                            </div>
                            <p class="text-muted ms-1" style="white-space: pre-line;"><?= $row['misi'] ?></p>
                        </div>
                    </div>
                </div>
            </div>

        <?php } else { ?>

            <div class="row align-items-center mb-5 reveal-right">
                <div class="col-lg-7 order-2 order-lg-1">
                    <div class="candidate-card"> 
                        <div class="d-flex align-items-center mb-4">
                            <div class="number-badge-box"><?= $no ?></div>
                            <div>
                                <h3 class="fw-bold text-primary m-0"><?= $row['nama_calon'] ?></h3>
                                <span class="badge bg-secondary opacity-75">Angkatan <?= $row['angkatan'] ?></span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-lightning-fill text-warning me-2 fs-5"></i>
                                <span class="label-visi">Visi</span>
                            </div>
                            <p class="text-muted ms-1"><?= $row['visi'] ?></p>
                        </div>
                        <div>
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-list-ul text-primary me-2 fs-5"></i>
                                <span class="label-misi">Misi</span>
                            </div>
                            <p class="text-muted ms-1" style="white-space: pre-line;"><?= $row['misi'] ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 order-1 order-lg-2 mb-4 mb-lg-0">
                    <div class="photo-card"> 
                        <img src="img/<?= $row['foto'] ?>" alt="Foto <?= $row['nama_calon'] ?>">
                    </div>
                </div>
            </div>

        <?php } $no++; } ?>

    </div>

    <div class="cta-section reveal">
        <div class="container text-center">
            <h2 class="fw-bold mb-3">Sudah Siap Memilih?</h2>
            <p class="mb-4 opacity-75 fs-5">Gunakan hak suara Anda untuk kemajuan HMJ.</p>
            <button class="btn btn-light text-primary fw-bold px-5 py-3 rounded-pill fs-5 shadow hover-scale" data-bs-toggle="modal" data-bs-target="#voteModal">
                Masuk ke Bilik Suara <i class="bi bi-arrow-right ms-2"></i>
            </button>
        </div>
    </div>

    <div class="modal fade" id="voteModal" tabindex="-1" data-bs-backdrop="static">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 p-4">
                <div class="modal-header border-0">
                    <div>
                        <h4 class="modal-title fw-bold text-primary">Kertas Suara Digital</h4>
                        <p class="text-muted mb-0 small">Klik tombol 'Pilih' pada kandidat pilihan Anda.</p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body bg-light rounded-4">
                    <div class="row g-4 justify-content-center">
                        <?php 
                        mysqli_data_seek($kandidat, 0); 
                        $nomor = 1;
                        while($k = mysqli_fetch_assoc($kandidat)) { 
                        ?>
                        <div class="col-md-4">
                            <div class="card h-100 border-0 shadow-sm rounded-4 text-center p-3" style="transition:0.3s;">
                                <div class="position-absolute top-0 start-0 m-3 badge bg-primary fs-5 rounded-3"><?= $nomor ?></div>
                                <img src="img/<?= $k['foto'] ?>" class="img-fluid rounded-3 mb-3 shadow-sm" style="height: 220px; object-fit: cover;">
                                <h5 class="fw-bold text-dark mb-1"><?= $k['nama_calon'] ?></h5>
                                <span class="badge bg-light text-secondary mb-3 border">Angkatan <?= $k['angkatan'] ?></span>
                                <a href="simpan.php?id=<?= $k['id'] ?>" class="btn btn-primary w-100 py-2 rounded-pill fw-bold" onclick="return confirm('Yakin memilih Paslon <?= $nomor ?>? Pilihan tidak bisa diubah.')">
                                    PILIH KANDIDAT
                                </a>
                            </div>
                        </div>
                        <?php $nomor++; } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/script.js"></script>
</body>
</html>