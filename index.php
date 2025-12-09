<?php
session_start();
include 'koneksi.php';

// 1. CEK COOKIE
if(isset($_COOKIE['id_user']) && isset($_COOKIE['key'])) {
    $id = $_COOKIE['id_user'];
    $key = $_COOKIE['key'];
    $result = mysqli_query($koneksi, "SELECT nim, role, nama_lengkap FROM users WHERE id = '$id'");
    $row = mysqli_fetch_assoc($result);
    if($key === hash('sha256', $row['nim'])) {
        $_SESSION['status'] = "login";
        $_SESSION['role'] = $row['role'];
        $_SESSION['id_user'] = $id;
        $_SESSION['nama'] = $row['nama_lengkap'];
    }
}

// 2. CEK SESSION
if(isset($_SESSION['status'])) {
    if($_SESSION['role'] == "admin"){ header("location:dashboard_admin.php"); exit; } 
    else { header("location:dashboard.php"); exit; }
}

// 3. LOGIC LOGIN
if (isset($_POST['login'])) {
    $nim = $_POST['nim'];
    $password = $_POST['password']; 
    
    $query = mysqli_query($koneksi, "SELECT * FROM users WHERE nim='$nim' AND password='$password'");
    
    if (mysqli_num_rows($query) > 0) {
        $data = mysqli_fetch_assoc($query);
        $_SESSION['status'] = "login";
        $_SESSION['role'] = $data['role'];
        $_SESSION['id_user'] = $data['id'];
        $_SESSION['nama'] = $data['nama_lengkap'];

        // CEK REMEMBER ME
        if(isset($_POST['remember'])) {
            setcookie('id_user', $data['id'], time() + 3600);
            setcookie('key', hash('sha256', $data['nim']), time() + 3600); 
        }

        if($data['role'] == "admin"){ header("location:dashboard_admin.php"); } 
        else { header("location:dashboard.php"); }
    } else {
        $error = "NIM atau Password Salah!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login Pemira</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="assets/style.css">
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
</head>
<body class="login-body">

    <div class="card-login text-center">
        <div class="mb-4">
            <img src="img/logo.png" width="80" alt="Logo" onerror="this.style.display='none'"> 
        </div>

        <h4 class="fw-bold mb-1">Welcome Back!</h4>
        <p class="text-muted small mb-4">Login untuk memilih kandidat terbaik</p>

        <?php if(isset($error)) { echo "<div class='alert alert-danger py-2 small'>$error</div>"; } ?>
        
        <form method="POST">
            <div class="text-start mb-3">
                <input type="text" name="nim" class="form-control form-control-custom" placeholder="Masukkan NIM / Username" required>
            </div>
            
            <div class="input-group mb-4">
                <input type="password" name="password" id="passInput" class="form-control form-control-custom mb-0" placeholder="Masukkan Password" style="border-right: 0;" required>
                <span class="input-group-text bg-white border-start-0 form-control-custom mb-0" style="cursor: pointer;" onclick="togglePassword()">
                    <i class="bi bi-eye-slash" id="toggleIcon"></i>
                </span>
            </div>
            <div class="mb-3 form-check text-start">
                 <input type="checkbox" class="form-check-input" id="remember" name="remember">
                 <label class="form-check-label text-muted small" for="remember">Ingat Saya (Remember Me)</label>
            </div>
            <button type="submit" name="login" class="btn btn-gradient">Sign In</button>
        </form>
        
        <div class="mt-4 pt-3 border-top">
            <p class="text-muted small mb-2">Belum punya akun?</p>
            <button type="button" class="btn btn-outline-primary w-100 rounded-pill btn-sm fw-bold" data-bs-toggle="modal" data-bs-target="#scanModal">
                <i class="bi bi-qr-code-scan me-1"></i> Scan QR untuk Daftar
            </button>
        </div>

        <div class="mt-4">
            <small class="text-muted">© 2025 Created by You</small>
        </div>
    </div>

    <div class="modal fade" id="scanModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold fs-6"><i class="bi bi-camera-video me-2"></i>Scan QR Code Admin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <div id="reader" style="width: 100%; border-radius: 10px; overflow: hidden;"></div>
                    <p class="small text-muted mt-3 mb-0">Izinkan akses kamera browser Anda.</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // 1. TOGGLE PASSWORD (YANG LAMA)
        function togglePassword() {
            var input = document.getElementById("passInput");
            var icon = document.getElementById("toggleIcon");

            if (input.type === "password") {
                input.type = "text"; 
                icon.classList.remove("bi-eye-slash"); 
                icon.classList.add("bi-eye"); 
            } else {
                input.type = "password"; 
                icon.classList.remove("bi-eye");
                icon.classList.add("bi-eye-slash");
            }
        }

        // 2. LOGIC SCANNER QR CODE (BARU)
        let html5QrcodeScanner;

        const scanModal = document.getElementById('scanModal');
        
        // Saat modal dibuka -> Nyalakan Kamera
        scanModal.addEventListener('shown.bs.modal', function () {
            // Hapus scanner lama jika ada error
            if(html5QrcodeScanner) { html5QrcodeScanner.clear(); }

            html5QrcodeScanner = new Html5QrcodeScanner(
                "reader", 
                { fps: 10, qrbox: 250 }, 
                /* verbose= */ false
            );
            
            html5QrcodeScanner.render(onScanSuccess, onScanFailure);
        });

        // Saat modal ditutup -> Matikan Kamera
        scanModal.addEventListener('hidden.bs.modal', function () {
            if(html5QrcodeScanner) {
                html5QrcodeScanner.clear().catch(error => {
                    console.error("Failed to clear html5QrcodeScanner. ", error);
                });
            }
        });

        function onScanSuccess(decodedText, decodedResult) {
            // Matikan scanner
            html5QrcodeScanner.clear();
            
            // Redirect user ke Link yang ada di QR
            // Link tersebut berisi registrasi.php?code=BINER
            window.location.href = decodedText;
        }

        function onScanFailure(error) {
            // Biarkan kosong agar tidak mengganggu console
        }
    </script>

</body>
</html>