-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 18 Des 2025 pada 08.33
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `elcharm`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `db_admin`
--

CREATE TABLE `db_admin` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `db_admin`
--

INSERT INTO `db_admin` (`id`, `nama`, `username`, `password`, `created_at`) VALUES
(1, 'lita1246', 'lita1246', '118afce37e39c20b9bb268f406ef49cf', '2025-12-18 05:06:51'),
(2, 'dea1246', 'dea1246', 'a8db445f74ee50f927bf0224982fd0a7', '2025-12-18 07:20:47');

-- --------------------------------------------------------

--
-- Struktur dari tabel `db_pesanan`
--

CREATE TABLE `db_pesanan` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nama_pembeli` varchar(100) NOT NULL,
  `no_hp` varchar(20) NOT NULL,
  `alamat` text NOT NULL,
  `pembayaran` varchar(50) NOT NULL,
  `total` int(11) NOT NULL,
  `status` enum('Menunggu','Diproses','Dikirim','Selesai') DEFAULT 'Menunggu',
  `tanggal` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `db_pesanan`
--

INSERT INTO `db_pesanan` (`id`, `id_user`, `nama_pembeli`, `no_hp`, `alamat`, `pembayaran`, `total`, `status`, `tanggal`) VALUES
(1, 2, 'ytre', '1234567', 'iuytr', 'Transfer Bank', 438270, 'Menunggu', '2025-12-18 14:23:56');

-- --------------------------------------------------------

--
-- Struktur dari tabel `db_pesanan_detail`
--

CREATE TABLE `db_pesanan_detail` (
  `id` int(11) NOT NULL,
  `id_pesanan` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `db_pesanan_detail`
--

INSERT INTO `db_pesanan_detail` (`id`, `id_pesanan`, `id_produk`, `qty`, `harga`, `subtotal`) VALUES
(1, 1, 3, 5, 87654, 438270);

-- --------------------------------------------------------

--
-- Struktur dari tabel `db_produk`
--

CREATE TABLE `db_produk` (
  `id` int(11) NOT NULL,
  `nama_produk` varchar(150) NOT NULL,
  `harga` int(11) NOT NULL,
  `stok` int(11) NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `db_produk`
--

INSERT INTO `db_produk` (`id`, `nama_produk`, `harga`, `stok`, `gambar`, `deskripsi`, `created_at`) VALUES
(2, 'popmart cherry', 300000, 10, 'Crybaby Crying For Love Series - Vinyl Plush Hanging Card (Love You Cherry Much).jpeg', 'lucu', '2025-12-18 05:13:07'),
(3, 'cappuccino', 87654, 16, 'Crybaby x Powerpuff Girls Series - Vinyl Face Plush Blind Box Action Toys Figure Birthday Gift Kid Toy.jpeg', 'ugfds', '2025-12-18 07:21:42');

-- --------------------------------------------------------

--
-- Struktur dari tabel `db_users`
--

CREATE TABLE `db_users` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `db_users`
--

INSERT INTO `db_users` (`id`, `nama`, `email`, `password`, `created_at`) VALUES
(1, 'taehyung1246', 'taehyung1246@gmail.com', '71840a9f2c7981b3f61c88e1718f03f1', '2025-12-18 05:36:36'),
(2, 'ell1246', 'ell1246@gmail.com', 'b713d430925d872bb0e4c89e2bc3e5ee', '2025-12-18 06:06:45');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `db_admin`
--
ALTER TABLE `db_admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `db_pesanan`
--
ALTER TABLE `db_pesanan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `db_pesanan_detail`
--
ALTER TABLE `db_pesanan_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pesanan` (`id_pesanan`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indeks untuk tabel `db_produk`
--
ALTER TABLE `db_produk`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `db_users`
--
ALTER TABLE `db_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `db_admin`
--
ALTER TABLE `db_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `db_pesanan`
--
ALTER TABLE `db_pesanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `db_pesanan_detail`
--
ALTER TABLE `db_pesanan_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `db_produk`
--
ALTER TABLE `db_produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `db_users`
--
ALTER TABLE `db_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `db_pesanan`
--
ALTER TABLE `db_pesanan`
  ADD CONSTRAINT `db_pesanan_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `db_users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `db_pesanan_detail`
--
ALTER TABLE `db_pesanan_detail`
  ADD CONSTRAINT `db_pesanan_detail_ibfk_1` FOREIGN KEY (`id_pesanan`) REFERENCES `db_pesanan` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `db_pesanan_detail_ibfk_2` FOREIGN KEY (`id_produk`) REFERENCES `db_produk` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
