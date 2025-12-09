-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql102.byetcluster.com
-- Waktu pembuatan: 08 Des 2025 pada 19.59
-- Versi server: 11.4.7-MariaDB
-- Versi PHP: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `if0_40558917_hmj`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `kandidat`
--

CREATE TABLE `kandidat` (
  `id` int(11) NOT NULL,
  `nama_calon` varchar(100) DEFAULT NULL,
  `angkatan` varchar(20) DEFAULT NULL,
  `foto` varchar(100) DEFAULT 'default.jpg',
  `visi` text DEFAULT NULL,
  `misi` text DEFAULT NULL,
  `jumlah_suara` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kandidat`
--

INSERT INTO `kandidat` (`id`, `nama_calon`, `angkatan`, `foto`, `visi`, `misi`, `jumlah_suara`) VALUES
(1, 'Calon 1 - Budi', '2022', '30112025113309_peran-orang-tua-dalam-kemampuan-anak-membaca-al-qu-1683355272.jpg', 'Memajukan HMJ', 'INI MISI SAYA', 2),
(2, 'Calon 2 - Yanto', '2023', '30112025113453_8ffa2c0de652b9ad1772c7e704262789.jpg', 'HMJ Kreatif', 'INI MISI SAYA', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nim` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL,
  `nama_lengkap` varchar(100) DEFAULT NULL,
  `role` enum('admin','mahasiswa') DEFAULT 'mahasiswa',
  `status_vote` enum('sudah','belum') DEFAULT 'belum'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `nim`, `password`, `nama_lengkap`, `role`, `status_vote`) VALUES
(1, 'admin', 'admin123', 'Administrator', 'admin', 'belum'),
(2, '059', '123', 'ANDI AHMAD ZULFA KAHFI', 'mahasiswa', 'sudah'),
(3, '060', '123', 'XENOMNIME', 'mahasiswa', 'sudah'),
(4, '061', '123', 'zulfa', 'mahasiswa', 'sudah'),
(5, '062', '123', 'ARYA', 'mahasiswa', 'belum');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `kandidat`
--
ALTER TABLE `kandidat`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nim` (`nim`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `kandidat`
--
ALTER TABLE `kandidat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
