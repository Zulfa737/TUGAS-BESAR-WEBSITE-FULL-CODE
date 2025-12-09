<?php
session_start();
include 'koneksi.php';

// Cek Keamanan
if(!isset($_SESSION['role']) || $_SESSION['role'] != "admin"){ 
    header("location:index.php"); 
    exit; 
}

$aksi = $_GET['aksi'];

// --- 1. LOGIC TAMBAH DATA ---
if($aksi == "tambah") {
    $nama     = $_POST['nama'];
    $angkatan = $_POST['angkatan']; // <-- TAMBAHAN
    $visi     = $_POST['visi'];
    $misi     = $_POST['misi'];

    $foto = $_FILES['foto']['name'];
    $tmp  = $_FILES['foto']['tmp_name'];
    $newFoto = date('dmYHis')."_".$foto;
    $path = "img/".$newFoto;

    if(move_uploaded_file($tmp, $path)){
        // Query disesuaikan dengan kolom database Anda
        $query = "INSERT INTO kandidat (nama_calon, angkatan, visi, misi, foto, jumlah_suara) 
                  VALUES ('$nama', '$angkatan', '$visi', '$misi', '$newFoto', 0)";
        
        if(mysqli_query($koneksi, $query)){
            echo "<script>alert('Berhasil tambah kandidat!'); window.location='kandidat_admin.php';</script>";
        } else {
            echo "<script>alert('Gagal simpan ke database!'); window.location='kandidat_admin.php';</script>";
        }
    } else {
        echo "<script>alert('Gagal upload foto!'); window.location='kandidat_admin.php';</script>";
    }
}

// --- 2. LOGIC UPDATE DATA ---
elseif($aksi == "update") {
    $id       = $_POST['id'];
    $nama     = $_POST['nama'];
    $angkatan = $_POST['angkatan']; // <-- TAMBAHAN
    $visi     = $_POST['visi'];
    $misi     = $_POST['misi'];
    $fotoLama = $_POST['foto_lama'];

    $foto = $_FILES['foto']['name'];
    $tmp  = $_FILES['foto']['tmp_name'];

    // Jika ganti foto
    if($foto != "") {
        $newFoto = date('dmYHis')."_".$foto;
        $path = "img/".$newFoto;

        // Hapus foto lama
        if(file_exists("img/".$fotoLama)) unlink("img/".$fotoLama);
        
        // Upload foto baru
        move_uploaded_file($tmp, $path);

        $query = "UPDATE kandidat SET 
                  nama_calon='$nama', 
                  angkatan='$angkatan', 
                  visi='$visi', 
                  misi='$misi', 
                  foto='$newFoto' 
                  WHERE id='$id'";
    } else {
        // Jika tidak ganti foto
        $query = "UPDATE kandidat SET 
                  nama_calon='$nama', 
                  angkatan='$angkatan', 
                  visi='$visi', 
                  misi='$misi' 
                  WHERE id='$id'";
    }

    if(mysqli_query($koneksi, $query)){
        echo "<script>alert('Data berhasil diupdate!'); window.location='kandidat_admin.php';</script>";
    } else {
        echo "<script>alert('Gagal update database!'); window.location='kandidat_admin.php';</script>";
    }
}

// --- 3. LOGIC HAPUS DATA ---
elseif($aksi == "hapus") {
    $id = $_GET['id'];
    
    // Ambil info foto dulu
    $data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT foto FROM kandidat WHERE id='$id'"));
    
    // Hapus fisik file
    if(file_exists("img/".$data['foto'])) unlink("img/".$data['foto']);

    // Hapus data di database
    mysqli_query($koneksi, "DELETE FROM kandidat WHERE id='$id'");
    echo "<script>alert('Data dihapus!'); window.location='kandidat_admin.php';</script>";
}
?>