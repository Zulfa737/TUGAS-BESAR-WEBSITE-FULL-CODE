<?php
session_start();
include 'koneksi.php';

if(!isset($_SESSION['role']) || $_SESSION['role'] != "admin"){ header("location:index.php"); exit; }

// FUNGSI TEXT KE BINER
function textToBinary($string) {
    $characters = str_split($string);
    $binary = [];
    foreach ($characters as $character) {
        $data = unpack('H*', $character);
        $binary[] = base_convert($data[1], 16, 2);
    }
    return implode(' ', $binary);    
}

// SETUP QR
$token_asli = "PEMILU-HMJ-" . date("Y"); 
$token_biner = textToBinary($token_asli); 

// --- GANTI IP INI DENGAN IP LAPTOP ANDA ---
$ip_server = "192.168.1.5"; // Sesuaikan IP Laptop Anda
// -----------------------------------------

$nama_folder = "PROYEKTUBES"; 
$link_qr = "http://" . $ip_server . "/" . $nama_folder . "/registrasi.php?code=" . urlencode($token_biner);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Mode QR Code</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    
    <style>
        /* Agar Card selalu di tengah layar (Vertikal & Horizontal) */
        .center-wrapper {
            min-height: 80vh; 
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        
        /* CSS KHUSUS UNTUK MEMASTIKAN QR DI TENGAH */
        #qrcode {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
        }
        
        /* CSS CETAK */
        @media print {
            body * { visibility: hidden; }
            #printableArea, #printableArea * { visibility: visible; }
            #printableArea { 
                position: absolute; left: 0; top: 0; width: 100%; margin: 0; padding: 20px;
                box-shadow: none !important; border: none !important; 
            }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>

    <div class="sidebar no-print">
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
        <div class="mb-2 no-print">
            <a href="users_admin.php" class="text-decoration-none text-muted small"><i class="bi bi-arrow-left"></i> Kembali</a>
        </div>

        <div class="center-wrapper">
            
            <div class="card p-5 border-0 shadow-lg rounded-5 bg-white text-center mx-auto" style="max-width: 650px; width: 100%;" id="printableArea">
                
                <h2 class="fw-bold text-dark mb-3">
                    <i class="bi bi-qr-code-scan text-success me-2"></i> Registrasi Mandiri
                </h2>
                <p class="text-muted mb-4 fs-5">
                    Scan QR Code di bawah ini untuk mendaftar akun Pemilu HMJ.
                </p>

                <div class="d-flex justify-content-center mb-4">
                    <div class="p-3 border rounded-4 bg-white d-inline-block shadow-sm">
                        <div id="qrcode"></div>
                    </div>
                </div>

                <p class="small text-muted mb-0 bg-light py-2 px-3 rounded-pill d-inline-block">
                    <i class="bi bi-wifi"></i> Pastikan perangkat Anda terhubung ke jaringan yang sama.
                </p>
            </div>

            <div class="text-center mt-5 no-print">
                <button onclick="window.print()" class="btn btn-primary px-5 py-3 rounded-pill fw-bold shadow hover-scale">
                    <i class="bi bi-printer-fill me-2"></i> Cetak QR Code
                </button>
            </div>

        </div>
    </div>

    <script>
        var urlTujuan = "<?= $link_qr ?>";
        // Generate QR Code (Ukuran diperbesar jadi 280 agar pas di kotak)
        new QRCode(document.getElementById("qrcode"), {
            text: urlTujuan,
            width: 280, 
            height: 280,
            colorDark : "#000000",
            colorLight : "#ffffff",
            correctLevel : QRCode.CorrectLevel.H
        });
    </script>
</body>
</html>