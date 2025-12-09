<?php
session_start();
include 'koneksi.php';

// FUNGSI DECODE BINER
function binaryToText($binary) {
    $binaries = explode(' ', $binary);
    $string = null;
    foreach ($binaries as $binary) {
        $string .= pack('H*', base_convert($binary, 2, 16));
    }
    return $string;
}

$code_biner = isset($_GET['code']) ? $_GET['code'] : '';
$token_asli = binaryToText($code_biner); 
$valid_token = (strpos($token_asli, 'PEMILU-HMJ') !== false);

if(isset($_POST['daftar'])) {
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $pass = $_POST['pass'];

    $cek = mysqli_query($koneksi, "SELECT * FROM users WHERE nim='$nim'");
    if(mysqli_num_rows($cek) > 0) {
        $error = "NIM sudah terdaftar!";
    } else {
        $query = "INSERT INTO users (nim, password, nama_lengkap, role) VALUES ('$nim', '$pass', '$nama', 'mahasiswa')";
        if(mysqli_query($koneksi, $query)) {
            echo "<script>alert('Registrasi Berhasil! Silakan Login.'); window.location='index.php';</script>";
        } else {
            $error = "Gagal mendaftar.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Registrasi Mahasiswa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body class="login-body">
    <div class="card-login text-center" style="border-top: 5px solid #2563eb;">
        <?php if($valid_token): ?>
            <div class="mb-4">
                <h4 class="fw-bold mb-1 text-primary">Registrasi Mandiri</h4>
                <p class="text-muted small">Silakan isi data diri Anda</p>
            </div>
            <?php if(isset($error)) { echo "<div class='alert alert-danger py-2 small'>$error</div>"; } ?>
            <form method="POST">
                <div class="text-start mb-3">
                    <label class="small fw-bold text-muted">NIM</label>
                    <input type="text" name="nim" class="form-control form-control-custom" required>
                </div>
                <div class="text-start mb-3">
                    <label class="small fw-bold text-muted">Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control form-control-custom" required>
                </div>
                <div class="text-start mb-4">
                    <label class="small fw-bold text-muted">Password</label>
                    <input type="text" name="pass" class="form-control form-control-custom" required>
                </div>
                <button type="submit" name="daftar" class="btn btn-primary w-100 py-2 rounded-pill fw-bold">Daftar</button>
            </form>
        <?php else: ?>
            <div class="py-5">
                <h4 class="fw-bold text-danger">Akses Ditolak!</h4>
                <p class="text-muted small">Anda harus scan QR Code dari Admin.</p>
                <a href="index.php" class="btn btn-secondary btn-sm mt-3">Kembali</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>