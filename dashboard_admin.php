<?php
session_start();
include 'koneksi.php';

// Cek Role Admin
if(!isset($_SESSION['role']) || $_SESSION['role'] != "admin"){ 
    header("location:index.php"); 
    exit; 
}

// --- LOGIC HITUNG DATA ---
$total_user = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM users WHERE role='mahasiswa'"));
$sudah_milih = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM users WHERE status_vote='sudah'"));
$belum_milih = $total_user - $sudah_milih;

// --- DATA CHART ---
$nama_kandidat = [];
$suara_kandidat = [];
$warna_chart = ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b'];

$q_chart = mysqli_query($koneksi, "SELECT * FROM kandidat ORDER BY id ASC");
while($c = mysqli_fetch_assoc($q_chart)){
    $nama_kandidat[] = $c['nama_calon'];
    $suara_kandidat[] = $c['jumlah_suara'];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Dashboard Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
            <a class="nav-link active" href="dashboard_admin.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
            <a class="nav-link" href="users_admin.php"><i class="bi bi-people"></i> User Management</a>
            <a class="nav-link" href="kandidat_admin.php"><i class="bi bi-bar-chart-steps"></i> Manajemen Kandidat</a>
            <a class="nav-link text-danger mt-4" href="logout.php"><i class="bi bi-box-arrow-left"></i> Logout</a>
        </nav>
    </div>

    <div class="main-content">
        
        <div class="d-flex align-items-center justify-content-between d-md-none mb-4">
            <h4 class="fw-bold m-0">Dashboard</h4>
            <button class="btn btn-primary" onclick="toggleSidebar()">
                <i class="bi bi-list"></i> Menu
            </button>
        </div>

        <h3 class="fw-bold mb-4 d-none d-md-block">Hasil Pemilihan</h3>
        
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-4"> <div class="stat-card h-100">
                    <div>
                        <small class="text-muted" style="font-size: 0.8rem;">Total User</small>
                        <div class="stat-number fs-2"><?= $total_user ?></div>
                    </div>
                    <div class="icon-box bg-light text-primary d-none d-sm-flex"><i class="bi bi-people-fill"></i></div>
                </div>
            </div>
            <div class="col-6 col-md-4">
                <div class="stat-card h-100">
                    <div>
                        <small class="text-muted" style="font-size: 0.8rem;">Sudah Milih</small>
                        <div class="stat-number text-success fs-2"><?= $sudah_milih ?></div>
                    </div>
                    <div class="icon-box bg-success-subtle text-success d-none d-sm-flex"><i class="bi bi-check-lg"></i></div>
                </div>
            </div>
            <div class="col-12 col-md-4"> <div class="stat-card h-100">
                    <div>
                        <small class="text-muted" style="font-size: 0.8rem;">Belum Milih</small>
                        <div class="stat-number text-danger fs-2"><?= $belum_milih ?></div>
                    </div>
                    <div class="icon-box bg-danger-subtle text-danger d-none d-sm-flex"><i class="bi bi-x-lg"></i></div>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-md-8">
                <div class="card p-3 p-md-4 border-0 shadow-sm rounded-4 h-100">
                    <h5 class="fw-bold mb-4">Perolehan Suara</h5>
                    <div style="height: 250px; position: relative;">
                        <canvas id="barChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card p-3 p-md-4 border-0 shadow-sm rounded-4 h-100">
                    <h5 class="fw-bold mb-4">Persentase</h5>
                    <div style="height: 250px; display: flex; justify-content: center; position: relative;">
                        <canvas id="pieChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="card p-3 p-md-4 border-0 shadow-sm rounded-4">
            <h5 class="fw-bold mb-4">Detail Suara</h5>
            <?php 
            mysqli_data_seek($q_chart, 0); 
            while($k = mysqli_fetch_assoc($q_chart)) { 
                $persen = ($sudah_milih > 0) ? round(($k['jumlah_suara'] / $sudah_milih) * 100) : 0;
            ?>
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1 small">
                        <span class="fw-bold"><?= $k['nama_calon'] ?></span>
                        <span><?= $k['jumlah_suara'] ?> (<?= $persen ?>%)</span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-primary" style="width: <?= $persen ?>%"></div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function toggleSidebar() {
            document.getElementById('mySidebar').classList.toggle('active');
            document.querySelector('.overlay').classList.toggle('active');
        }
    </script>

    <script>
        const labels = <?= json_encode($nama_kandidat) ?>;
        const dataSuara = <?= json_encode($suara_kandidat) ?>;
        const backgroundColors = ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b'];

        const ctxBar = document.getElementById('barChart').getContext('2d');
        new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Suara',
                    data: dataSuara,
                    backgroundColor: '#4e73df',
                    borderRadius: 5,
                    barThickness: 30
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false, // PENTING AGAR TIDAK PENYET DI HP
                scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } },
                plugins: { legend: { display: false } }
            }
        });

        const ctxPie = document.getElementById('pieChart').getContext('2d');
        new Chart(ctxPie, {
            type: 'doughnut', 
            data: {
                labels: labels,
                datasets: [{
                    data: dataSuara,
                    backgroundColor: backgroundColors,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false, // PENTING AGAR TIDAK PENYET DI HP
                plugins: { legend: { position: 'bottom', labels: { boxWidth: 10, font: { size: 10 } } } }
            }
        });
    </script>

</body>
</html>