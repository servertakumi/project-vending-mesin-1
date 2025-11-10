-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 10 Nov 2025 pada 11.30
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `takumivm`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(25) NOT NULL,
  `nama` varchar(25) NOT NULL,
  `password` varchar(250) NOT NULL,
  `email` varchar(25) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `upload_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `logged_in_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id`, `username`, `nama`, `password`, `email`, `created_at`, `upload_at`, `logged_in_at`) VALUES
(22, 'fasya', 'fasya', '$2y$10$Kjytx5ZJfzgvf5eh3b5iP.E9C5f8eUqeN8/CQuEFhIWQwSyqUWD2G', 'fasya@gmail.com', '2025-11-01 11:17:06', '2025-11-01 11:17:06', '2025-11-10 01:16:36'),
(26, 'rizky', 'rizky', '$2y$10$tjPwbHHclusJOtEIDEG0DuzQOpZf3g.uYqw3RwwwgGTFNE3KlaHyC', 'rizky@gmail.com', '2025-11-07 09:19:10', '2025-11-07 09:19:10', '2025-11-07 09:19:10');

-- --------------------------------------------------------

--
-- Struktur dari tabel `gudang`
--

CREATE TABLE `gudang` (
  `id` int(11) NOT NULL,
  `nama_produk` varchar(100) NOT NULL,
  `keterangan_produk` varchar(100) NOT NULL,
  `jumlah_stock` int(250) NOT NULL,
  `lokasi_gudang` varchar(250) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `gudang`
--

INSERT INTO `gudang` (`id`, `nama_produk`, `keterangan_produk`, `jumlah_stock`, `lokasi_gudang`, `created_at`, `updated_at`) VALUES
(2, 'Teh Hijau', 'Teh hijau celup 25 sachei', 1000, 'Gudang 1', '2025-10-31 09:15:30', '2025-11-10 09:33:31'),
(3, 'Susu Murni', 'Susu sapi segar botol 1L', 1000, 'Gudang 1', '2025-10-31 09:15:30', '2025-11-10 09:33:38'),
(4, 'Roti Gandum', 'Roti gandum utuh 10 pack', 1000, 'Gudang 1', '2025-10-31 09:15:30', '2025-11-10 09:33:45'),
(5, 'Bengbeng', 'Varian Coklat 30g', 1000, 'Gudang 1', '2025-10-31 09:15:30', '2025-11-10 09:33:51'),
(6, 'Coklat Bubuk', 'Bubuk coklat premium 500g', 1000, 'Gudang 2', '2025-10-31 09:15:30', '2025-11-10 09:33:58'),
(7, 'Aqua', '600ml', 1000, 'Gudang 2', '2025-10-31 09:15:30', '2025-11-10 09:34:07'),
(8, 'Popmie', 'varian soto ayam 75g', 1000, 'Gudang 2', '2025-10-31 09:15:30', '2025-11-10 09:34:13'),
(9, 'Good Day', 'Varian cappuccino 240ml', 1000, 'Gudang 2', '2025-10-31 09:15:30', '2025-11-10 09:34:21'),
(84, 'Ultra Milk Cokelat', 'Varian Cokelat 200ml', 1000, 'Gudang 3', '2025-11-10 07:34:55', '2025-11-10 09:34:28'),
(85, 'Ultra Milk Strawberry', 'Varian Strawberry 200ml', 1000, 'Gudang 3', '2025-11-10 07:37:08', '2025-11-10 09:34:35'),
(86, 'Lays', 'Balado 68g', 1000, 'Gudang 3', '2025-11-10 07:37:58', '2025-11-10 09:34:56'),
(87, 'Chitato', 'Varian Keju 68g', 1000, 'Gudang 3', '2025-11-10 07:38:31', '2025-11-10 09:35:05');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mesin`
--

CREATE TABLE `mesin` (
  `id` int(11) NOT NULL,
  `nama` varchar(25) NOT NULL,
  `keterangan` varchar(25) NOT NULL,
  `lokasi` varchar(25) NOT NULL,
  `status` varchar(25) NOT NULL,
  `kapasitas` int(11) NOT NULL,
  `jumlah_roll` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `mesin`
--

INSERT INTO `mesin` (`id`, `nama`, `keterangan`, `lokasi`, `status`, `kapasitas`, `jumlah_roll`, `created_at`, `updated_at`) VALUES
(3, 'Mesin 1', 'Makanan & Minuman', 'Minori', 'hidup', 300, 60, '2025-10-31 09:24:54', '2025-11-10 09:25:17'),
(4, 'Mesin 2', 'Makanan & Minuman', 'Minori', 'hidup', 300, 60, '2025-10-31 09:24:54', '2025-11-10 09:26:15'),
(5, 'Mesin 3', 'Makanan & Minuman', 'Nagomi', 'hidup', 300, 60, '2025-10-31 09:24:54', '2025-11-10 09:26:55'),
(6, 'Mesin 4', 'Makanan & Minuman', 'Nagomi', 'hidup', 300, 60, '2025-10-31 09:24:54', '2025-11-10 09:28:44'),
(7, 'Mesin 5', 'Makanan & Minuman', 'Ayumi', 'hidup', 300, 60, '2025-10-31 09:24:54', '2025-11-10 09:29:13'),
(8, 'Mesin 6', 'Makanan & Minuman', 'Ayumi', 'hidup', 300, 60, '2025-10-31 09:24:54', '2025-11-10 09:30:41'),
(22, 'Mesin 7', 'Makanan & Minuman', 'Takumi', 'hidup', 300, 60, '2025-11-07 13:17:01', '2025-11-10 09:31:27');

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk`
--

CREATE TABLE `produk` (
  `id` int(11) NOT NULL,
  `code` varchar(25) NOT NULL,
  `gambar` text NOT NULL,
  `gudang_id` varchar(100) NOT NULL,
  `harga_produk` int(100) NOT NULL,
  `deskripsi_produk` varchar(25) NOT NULL,
  `expire` varchar(25) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `produk`
--

INSERT INTO `produk` (`id`, `code`, `gambar`, `gudang_id`, `harga_produk`, `deskripsi_produk`, `expire`, `created_at`, `updated_at`) VALUES
(50, 'A1', 'https://th.bing.com/th/id/OIP.9tS27dpBg8KjK3YiM9WW7QHaD7?w=201&h=108&c=7&qlt=92&bgcl=f0d5fb&r=0&o=6&cb=ucfimg1&pid=13.1&ucfimg=1', '5', 4000, 'Makanan', '2025-11-10', '2025-11-10 07:40:38', '2025-11-10 07:42:15'),
(51, 'A2', 'https://image.makewebeasy.net/makeweb/0/aDHlzCExY/DefaultData/5D7A94CE_02D5_4FDB_8AEC_FB86D0762D89.jpeg', '2', 10000, 'Minuman', '2025-11-10', '2025-11-10 07:43:43', '2025-11-10 07:43:43'),
(52, 'A3', 'https://down-id.img.susercontent.com/file/d6a57383e1c02f4e4063737a383265d0', '3', 10000, 'Minuman', '2025-11-10', '2025-11-10 07:44:55', '2025-11-10 07:44:55'),
(53, 'B1', 'https://bosara.sultraprov.go.id/asset/foto_produk/Sari_Roti_Gandum.jpg', '4', 15000, 'Makanan', '2025-11-11', '2025-11-10 07:46:11', '2025-11-10 07:46:11'),
(54, 'B2', 'https://down-id.img.susercontent.com/file/id-11134207-7r98w-lpdxwoz1px1v8b', '6', 20000, 'Minuman', '2025-11-10', '2025-11-10 07:51:01', '2025-11-10 07:51:01'),
(55, 'B3', 'https://th.bing.com/th/id/OIP.GVhnvCvuVQ9KkA8Ii4uL5QHaHa?w=174&h=180&c=7&r=0&o=7&cb=ucfimg2&pid=1.7&rm=3&ucfimg=1', '7', 5000, 'Minuman', '2025-11-10', '2025-11-10 07:55:29', '2025-11-10 07:55:29'),
(56, 'C1', 'https://th.bing.com/th/id/OIP.DWx2ZliXnofdO544AG5EaAHaHa?w=188&h=188&c=7&r=0&o=7&cb=ucfimg2&pid=1.7&rm=3&ucfimg=1', '8', 5000, 'Makanan', '2025-11-11', '2025-11-10 07:56:42', '2025-11-10 07:56:57'),
(57, 'C2', 'data:image/webp;base64,UklGRiANAABXRUJQVlA4IBQNAABQOACdASrDAMMAPp1MoEwlpCMiJZjZQLATiWNu4XSa0PPbNHwccvcZeUXUz7XG3g8z3mzdDl1QHoAdLP/c8ly235DPfso1wJ1LO5t/XgBPI/C37Hf3NWLw75q3pN/xfC8++f832AP0L6GGeP6r9gry0fX9+3vsn/saPzifUvVBIJR0EldE6W4dxn860zLLPipr2jcxE4FIJR0ENQ8bPUfLi6xfm750zc59A3IyJfXhwnE/IKw84sjjlG1a6yO1NYLJSLFvVSrZNrOQqLHwLhGnXYUzFOYwpoGPVI3KgtZ7pQNRaRzpgIdAQdWPhsIYmhB0BJYfgHT03vqkEBG5vrltgoKU+NoZtU8gcJpZRn7hftFE/HTQJR0ENGX1grbNT1bvEgS3XOF88iDE/XQEkYGCwYbEGp6ILhOJ23ZVU9QyVaILitoKafqRwjQvHxcyDOqrOxznVic4Rn9Sj4AgJiHddUkldBXLudA7O6dHOIOJSeK8WQnE/H/XW0Z8+9/sVMEhu4XW7oseFTyemQlhZ7yY4n5ERzGrN72iWa9JW4g29D9W3oFyKXNF7LNRjk2kX3bROQgJIgo0vS8inVxdHGa8CJVwZCAksTnCbIAA/v9npAWrFrtTCyNH/FifKzuHg3Kgak8v8W/vySwMmisvXe/zMHGGUUuyosDuPImdPUQuKf5QeqbV5t2GRyQ+2MF66f/cywoJUieJJaRTwOX+veCZZrNmtmX8yQt3V90NNie3w9PYSxbU3JqZZt+qIi+2wS////Jt5QvHwTtrnuO/wZhe4HqEEC3ER7bHxmr/Mbd2b64fSN+Qt+xtjpHfAOjIefa9QkNakr2bccjwUw56tWZL9RxZmBeM9cs5Go/v4jcK3MSIP8zJLgt+ihn7ONDBwULZ+SKpAAd9rrzvkryl3zLum8nppJQlZFseTRrIT33cD8cd9iuyDz9QVHd0NYKbJxTFhVHX7fWey5mk0JOj7+cB6+YVtGUv4mYN83lCcbTydqL3+N1aEY7jE58zlRQBJKj8z7YgWSVDI5Fzbd7N+SUuDJOgKie79Y81StGfAbWbmuOshl976deSAgNMnZ3D91Rv6M5DzjwPO6W0sx/xGNis1V7eMCqCW+tUzO2zd/z+04bFeRcP0wxsoNv+s1TDsUQ0eRr1mRLs4xFvydGfZrIvjWHsRSd9weFHoGUjEjNn8voFqHaeJIm1mk/NFQZqkhxBpxz8AcFPvLlvI1Xx0mIHmTfP3VgN2DXAezvOIi1mZmr1Yj2qP5z7NIgKCao+uVsSklCaboC5Qg+DslwkcWI0z06b+yX0w4RzCBFN7rmi7uaamfYLWpJk6v/ihXPQ+60Sn9YSwAkBn09hNeLMD1S28u1OdExV1pxFjPQ4HkIglLVQpIn1U08NGZB6vd1HNOZ6ZT/4oj9i1HwR96tqdfDfFyHsqOWnCfAk5WTIsMi3yv5J6D1qgNnjnQ2XvQp1CqTPMX1vK7VoVnT5m0L+n+CdBT6sS3oyKdVDPB3ZrsbC+snrXnl2rBKmn29CGG8dZrCzfHqTMMbY2VeuKMiAFaXNrG3Et+hpiXSZrOECOGdbIWZVXCRATXua9cU1f4UFfmhOPEdYQHdtoDBxDaTOmrgMnYC0x4EZpJ3OCQxnm9K0uEYpjO4WllKNcxnwjWEFkPRCOWd0ikVbT9pp5K/V1qnRbtJWPzyciu9jblkJ09o6DgB8Ys6o+/QswFVPvdVWWndLqe4FkQZMlELe/rNyfw3oVVHGRq0epp99FoMAPJG9rOuxSZHkN+TEHTtZKRO//6Dqr/IAi6KgzyuG2EnuOjtBnbo3+VKjz6+nP6k//daYl/hU1tQWAp4z+4n/TCOX+CzoN/q8b88NcTfmHKO0D7XH4aB76iE/DSteJWdF4RgMwYLAHEYG6HBNKQotn4QHq2a6sDwo4+P2OJocWH37dcnciExQJjqF5PxpUvNfV1xXXASmB5zRIfMXx3P/0Xya0EsOni9O8AFFx95PXsGkDTrtOVvK8n24ootXF5c1zUETfdjm5nSjVc21R3/5R27opG4FQzNJDP6Nx0vjrqRcvigxF+N0i1XxvpG7hMh8H2YHRhKZ9+v/zIwpSzAWra9YdlCm+n7SOBXUogsq+BdOxWKzvO5M/IL9ogkzR22FNszquBz67pV+os/5aVXE1O1ZX3hvsFOp1Rgqn4Kz4Bp287qft8O30er5lDUhkNDI1cns3abzVX1y0CCR4ktEGCGIgNtvfZwJAyJcqujYzdhXruAJeif4HsO6tEtNDWtlqKZwXEYnsRVwTyw/nOszxV4gRDDPxcmDyIFolNXAqxwqWwkh0DHGoDM+mDAZv2x5aE2I70mhEvpy++dJDAn3N029ZG2OVRq093pRExgeqDDWewA+JocM8FL2LegOWyoeolFrmGPo2C5j5rNaN/MoJlm5M32SCmgPrPHqX2UZzWZ7cX0RdQ8i53OTFqxSC/+aH/Ol8CSvc4/AGB4zFp5AnMo4eSAuAcPjukXv8PdP+hcfwTww25sfCfV1cgoxioQT+CplHB77zJpBnzjUF7fdRQwHQAlif25zdKGN4eI53RUdoDsPeOSrZCZLdEg1D44aUncfqaySWyegq7sFdgvGbWW39Gb9tnSTBoPwIHBuNi0ADM48W4rTwyJqVD+YkypzJzlaSH1rAJY1C9Bk1iX//4PW7IXxVx4WV2OCQxkCbmYK69otJb/ypx4WVXBJABYNg95bOvrIs0r/+z1NuIiWujM2el8xtxK/djFdRAzwk80A8Stw+Dp5SeOPhJOdmW1DXYY41IrAdre5z+F+A0mvX/1b0iguhEVxMzOJ4ZAUawLJFWXD6orVzypRIz+MEIontBaptxcHJXPayBejYDV3XoO156PVGzqteBxDUyvsWk4U5FcRcG7ODK2X1sXdBfaTw4pOyf9lF8+t12dkPbr/UD0mqbeCUDn+wwB/vGyF/lUSK9gLbKZk6bIBzGzyLN7QaofXLUd1+iYWBglMZw+wuzyH+CRDSynuq/UeQfwmZfj/Wjfx1dzz05epUT5WYyw5CgIg3MZQP7+iTaiwg2FiRx5cL79G8tPt9D/g8hMvL1OHPO3QIC1uCMQNAYlm+ZLSDIHRCS7ByW+Z+XM3rZQumddX2ujAsOmOPtvVb9/2BXHtqsl0asEFKx3J6klJPWuvEK//m9AmUZMqguC3fCAEIbqWIGNKxF/Y0HmaqG67u6qAcYEERFBaNEUyMMDgyZ8C2X3V6wXAxaT0VNmvBMr1YxgLoRz+sSe0ZXkQy2MPGryvCx3xUWaKP0Sxf+mI36yGsk76KI4/TLiYZVjuyw4zhA57Qp658aNk8L4SlzUJ7m8xWaamwl8dFaKBab3L2E5GqdRhdT9zy2tvFNMwxHVvl4Pg28l2wZ6TE2GlIMLX6lM8vXi71lMVGoPy3lgqrnIhFMOTT0/gToAToojQTx9qkhR30fWpO1c5KyprXQUmLEkc6wtTvEKN6phLZtOm/KcDm8zsazqWmFfFJZGBN88CkTmDVy3/JzSx5hsf5dYq1utS3wFBE1sYcf8piih5wsQzQc9caHV8+VAY5AQinz2tqIt4dlMmOeCXGJUbtxL99BDJTIbIweie5zBZQ71mR1pSGzo6JP/Ff7VMItjn49r6ZmwmEG021GUG7zlUKvI7HeUfi1QHCq77FDF55pnc/Y3Jxd+2AysxPapJneJzgEybZTtfSTjWd9n6lIda/GfjUFqfe2/HDt0E73/aeyMrldyaMrSkj661Et/SKXpv+jvqANA2+cj7V3m2QzsilFVhgaYvO9PfKRw+rRvUEtwuH8ka2+vtvMK/VI73YwPqYiqNDKFsErR+TpA62v+vmNowZGjAyDsm2thtUbCsW6NPqqRghjC+ZR+C4RM6uDDrHWyiyClOiDHCDocOxuUDXpWsnPR6KO4vGKib7y7No0zP03VzDI+eRs6zMj0yjTAcc0uCcYD6OFPQa3SUyJyzcFcNuTvVCVQ+irL1IbV85Uh/ZYOtLZGvbAYFWCist16tacw5f4a85Gr2OvIU4pGz0+ixk7HpePLLvZHxJiP2wjHJIJOTM6LAYQTaMR4gWvaHBDL4QcClBQ7Tv3kqJn9xU6oB8bo2bpGrXf0hVydUt9TeHEfLNeDShdMSn76BRdJZ7TLp1thSTOVURsiQVXA/GPwHKcOYl0+t12sgrXw2e7oBCgW+Ixe2I92BJpIvbL/5ox/yHUsALSbFzXztWpEP0hp48tQFCMNT6gYh/9fDZ9ZTmD9aUJhQSgbhYK36ilDS1p4T0uDKeF0aonu6XfUL0hTS1My5LHGaL1sQ6oguDeKiTk8ljB1BLbLDN/+cBJ/ran2pEKI8tj8ZoNq1MgPdOvhbnJL9EhrngJyWAULX/9T9s1zsrY45MAH5LS9hXOBRwmACzZxvwOXyBbQixs6BPNgEgPgJbtL+sgcsquwkt2O1cZliXSUTmAAAAAA=', '9', 6000, 'Minuman', '2025-11-11', '2025-11-10 07:59:01', '2025-11-10 07:59:01'),
(58, 'C3', 'https://th.bing.com/th/id/OIP.ydOiO29gqlue2YNe7juY7gHaHa?w=182&h=182&c=7&r=0&o=7&cb=ucfimg2&pid=1.7&rm=3&ucfimg=1', '84', 4000, 'Minuman', '2025-11-11', '2025-11-10 08:01:25', '2025-11-10 08:01:25'),
(59, 'D1', 'https://th.bing.com/th/id/OIP.4X5GInzkvLsEKeQw_LiB9gHaHa?w=182&h=182&c=7&r=0&o=7&cb=ucfimg2&pid=1.7&rm=3&ucfimg=1', '85', 4000, 'Minuman', '2025-11-11', '2025-11-10 08:03:17', '2025-11-10 08:03:17'),
(60, 'D2', 'data:image/webp;base64,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', '86', 8000, 'Makanan', '2025-11-19', '2025-11-10 09:17:23', '2025-11-10 09:17:23'),
(61, 'D3', 'https://th.bing.com/th/id/OIP.1NueZcc95taoY-ukKyYqrQHaHa?w=191&h=191&c=7&r=0&o=7&cb=ucfimg2&pid=1.7&rm=3&ucfimg=1', '87', 8000, 'Makanan', '2025-11-11', '2025-11-10 09:18:18', '2025-11-10 09:18:18');

-- --------------------------------------------------------

--
-- Struktur dari tabel `setting_mesin_produk`
--

CREATE TABLE `setting_mesin_produk` (
  `id` int(11) NOT NULL,
  `gudang_id` int(11) NOT NULL,
  `mesin_id` int(11) NOT NULL,
  `produk_id` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `setting_mesin_produk`
--

INSERT INTO `setting_mesin_produk` (`id`, `gudang_id`, `mesin_id`, `produk_id`, `stock`, `created_at`, `updated_at`) VALUES
(69, 0, 0, 0, 1000, '2025-11-07 13:09:53', '2025-11-07 13:09:53'),
(91, 0, 3, 50, 150, '2025-11-10 09:37:32', '2025-11-10 10:16:45'),
(92, 0, 3, 56, 50, '2025-11-10 09:37:46', '2025-11-10 09:38:50'),
(93, 0, 4, 59, 50, '2025-11-10 09:39:08', '2025-11-10 09:39:08'),
(94, 0, 3, 60, 50, '2025-11-10 09:39:22', '2025-11-10 09:39:22'),
(95, 0, 5, 57, 150, '2025-11-10 10:13:45', '2025-11-10 10:21:02'),
(96, 0, 22, 52, 100, '2025-11-10 10:13:56', '2025-11-10 10:13:56'),
(97, 0, 3, 54, 50, '2025-11-10 10:19:28', '2025-11-10 10:19:28'),
(98, 0, 4, 61, 150, '2025-11-10 10:19:45', '2025-11-10 10:19:45'),
(99, 0, 4, 52, 50, '2025-11-10 10:20:08', '2025-11-10 10:20:08'),
(100, 0, 4, 58, 50, '2025-11-10 10:20:21', '2025-11-10 10:20:21'),
(101, 0, 5, 61, 150, '2025-11-10 10:21:15', '2025-11-10 10:21:15'),
(102, 0, 6, 50, 10, '2025-11-10 10:21:31', '2025-11-10 10:21:31'),
(103, 0, 6, 51, 10, '2025-11-10 10:21:42', '2025-11-10 10:21:42'),
(104, 0, 6, 52, 10, '2025-11-10 10:21:53', '2025-11-10 10:21:53'),
(105, 0, 6, 53, 10, '2025-11-10 10:22:04', '2025-11-10 10:22:04'),
(106, 0, 6, 54, 10, '2025-11-10 10:22:26', '2025-11-10 10:22:26'),
(107, 0, 6, 55, 10, '2025-11-10 10:22:38', '2025-11-10 10:22:38'),
(108, 0, 6, 56, 10, '2025-11-10 10:22:51', '2025-11-10 10:22:51'),
(109, 0, 6, 57, 10, '2025-11-10 10:23:05', '2025-11-10 10:23:05'),
(110, 0, 6, 58, 10, '2025-11-10 10:23:19', '2025-11-10 10:23:19'),
(111, 0, 6, 59, 10, '2025-11-10 10:23:32', '2025-11-10 10:23:32'),
(112, 0, 6, 60, 20, '2025-11-10 10:23:45', '2025-11-10 10:23:45'),
(113, 0, 6, 61, 10, '2025-11-10 10:24:12', '2025-11-10 10:24:12');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int(11) NOT NULL,
  `gudang_id` int(11) NOT NULL,
  `mesin_id` int(11) NOT NULL,
  `produk_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `total_harga` int(11) NOT NULL,
  `status` varchar(25) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `transaksi`
--

INSERT INTO `transaksi` (`id`, `gudang_id`, `mesin_id`, `produk_id`, `qty`, `total_harga`, `status`, `created_at`, `updated_at`) VALUES
(115, 2, 3, 44, 1, 1000000000, 'Sukses', '2025-11-07 15:07:11', '2025-11-07 15:07:11'),
(116, 2, 3, 44, 1, 1000000000, 'Sukses', '2025-11-07 15:08:24', '2025-11-07 15:08:24'),
(117, 2, 3, 44, 1, 1000000000, 'Gagal: Produk Habis', '2025-11-07 15:08:28', '2025-11-07 15:08:28'),
(118, 8, 4, 48, 1, 1000, 'Sukses', '2025-11-07 15:08:59', '2025-11-07 15:08:59'),
(119, 8, 4, 48, 1, 1000, 'Sukses', '2025-11-07 16:05:05', '2025-11-07 16:05:05'),
(120, 8, 4, 48, 1, 1000, 'Sukses', '2025-11-07 16:05:07', '2025-11-07 16:05:07'),
(121, 8, 4, 48, 1, 1000, 'Sukses', '2025-11-07 16:05:08', '2025-11-07 16:05:08'),
(122, 8, 4, 48, 1, 1000, 'Sukses', '2025-11-07 16:05:09', '2025-11-07 16:05:09'),
(123, 8, 4, 48, 1, 1000, 'Sukses', '2025-11-07 16:05:09', '2025-11-07 16:05:09'),
(124, 8, 4, 48, 1, 1000, 'Sukses', '2025-11-07 16:05:10', '2025-11-07 16:05:10'),
(125, 8, 4, 48, 1, 1000, 'Sukses', '2025-11-07 16:06:08', '2025-11-07 16:06:08'),
(126, 2, 3, 44, 1, 1000000000, 'Sukses', '2025-11-08 11:38:27', '2025-11-08 11:38:27'),
(127, 8, 22, 48, 1, 1000, 'Sukses', '2025-11-08 11:40:56', '2025-11-08 11:40:56'),
(128, 8, 22, 48, 1, 1000, 'Sukses', '2025-11-08 11:41:01', '2025-11-08 11:41:01'),
(129, 8, 22, 48, 1, 1000, 'Sukses', '2025-11-08 11:41:01', '2025-11-08 11:41:01'),
(130, 8, 22, 48, 1, 1000, 'Sukses', '2025-11-08 11:41:02', '2025-11-08 11:41:02'),
(131, 8, 22, 48, 1, 1000, 'Sukses', '2025-11-08 11:41:02', '2025-11-08 11:41:02'),
(132, 8, 22, 48, 1, 1000, 'Gagal: Produk Habis', '2025-11-08 11:41:02', '2025-11-08 11:41:02'),
(133, 8, 22, 48, 1, 1000, 'Gagal: Produk Habis', '2025-11-08 11:41:02', '2025-11-08 11:41:02'),
(134, 8, 22, 48, 1, 1000, 'Gagal: Produk Habis', '2025-11-08 11:41:03', '2025-11-08 11:41:03'),
(135, 8, 22, 48, 1, 1000, 'Gagal: Produk Habis', '2025-11-08 11:41:03', '2025-11-08 11:41:03'),
(136, 8, 22, 48, 1, 1000, 'Gagal: Produk Habis', '2025-11-08 11:41:04', '2025-11-08 11:41:04'),
(137, 8, 22, 48, 1, 1000, 'Gagal: Produk Habis', '2025-11-08 11:41:04', '2025-11-08 11:41:04'),
(138, 8, 22, 48, 1, 1000, 'Gagal: Produk Habis', '2025-11-08 11:41:04', '2025-11-08 11:41:04'),
(139, 2, 7, 44, 1, 1000000000, 'Sukses', '2025-11-08 11:44:07', '2025-11-08 11:44:07'),
(140, 2, 7, 44, 1, 1000000000, 'Sukses', '2025-11-08 11:44:10', '2025-11-08 11:44:10'),
(141, 2, 7, 44, 1, 1000000000, 'Sukses', '2025-11-08 11:44:10', '2025-11-08 11:44:10'),
(142, 2, 7, 44, 1, 1000000000, 'Sukses', '2025-11-08 11:44:11', '2025-11-08 11:44:11'),
(143, 2, 7, 44, 1, 1000000000, 'Gagal: Produk Habis', '2025-11-08 11:44:12', '2025-11-08 11:44:12'),
(144, 2, 7, 44, 1, 1000000000, 'Gagal: Produk Habis', '2025-11-08 11:44:13', '2025-11-08 11:44:13'),
(145, 2, 7, 44, 1, 1000000000, 'Gagal: Produk Habis', '2025-11-08 11:44:13', '2025-11-08 11:44:13'),
(146, 2, 7, 44, 1, 1000000000, 'Gagal: Produk Habis', '2025-11-08 11:44:14', '2025-11-08 11:44:14'),
(147, 2, 7, 44, 1, 1000000000, 'Gagal: Produk Habis', '2025-11-08 11:44:15', '2025-11-08 11:44:15'),
(148, 2, 7, 44, 1, 1000000000, 'Gagal: Produk Habis', '2025-11-08 11:44:15', '2025-11-08 11:44:15'),
(149, 2, 7, 44, 1, 1000000000, 'Gagal: Produk Habis', '2025-11-08 11:44:16', '2025-11-08 11:44:16'),
(150, 2, 7, 44, 1, 1000000000, 'Gagal: Produk Habis', '2025-11-08 11:44:19', '2025-11-08 11:44:19'),
(151, 8, 4, 48, 1, 1000, 'Sukses', '2025-11-08 12:22:20', '2025-11-08 12:22:20'),
(152, 8, 4, 48, 1, 1000, 'Sukses', '2025-11-08 12:22:22', '2025-11-08 12:22:22'),
(153, 8, 4, 48, 1, 1000, 'Sukses', '2025-11-08 12:22:22', '2025-11-08 12:22:22'),
(154, 8, 4, 48, 1, 1000, 'Sukses', '2025-11-08 12:22:23', '2025-11-08 12:22:23'),
(155, 8, 4, 48, 1, 1000, 'Sukses', '2025-11-08 12:22:23', '2025-11-08 12:22:23'),
(156, 8, 4, 48, 1, 1000, 'Sukses', '2025-11-08 12:22:23', '2025-11-08 12:22:23'),
(157, 8, 4, 48, 1, 1000, 'Sukses', '2025-11-08 12:22:23', '2025-11-08 12:22:23'),
(158, 8, 4, 48, 1, 1000, 'Sukses', '2025-11-08 12:22:24', '2025-11-08 12:22:24'),
(159, 8, 4, 48, 1, 1000, 'Sukses', '2025-11-08 12:22:24', '2025-11-08 12:22:24'),
(160, 8, 4, 48, 1, 1000, 'Sukses', '2025-11-08 12:22:25', '2025-11-08 12:22:25'),
(161, 8, 4, 48, 1, 1000, 'Sukses', '2025-11-08 12:22:25', '2025-11-08 12:22:25'),
(162, 8, 4, 48, 1, 1000, 'Sukses', '2025-11-08 12:22:26', '2025-11-08 12:22:26'),
(163, 8, 4, 48, 1, 1000, 'Sukses', '2025-11-08 12:22:26', '2025-11-08 12:22:26'),
(164, 8, 4, 48, 1, 1000, 'Sukses', '2025-11-08 12:22:26', '2025-11-08 12:22:26'),
(165, 8, 4, 48, 1, 1000, 'Sukses', '2025-11-08 12:22:26', '2025-11-08 12:22:26'),
(166, 8, 4, 48, 1, 1000, 'Sukses', '2025-11-08 12:22:26', '2025-11-08 12:22:26'),
(167, 8, 4, 48, 1, 1000, 'Sukses', '2025-11-08 12:22:27', '2025-11-08 12:22:27'),
(168, 8, 4, 48, 1, 1000, 'Sukses', '2025-11-08 12:22:28', '2025-11-08 12:22:28'),
(169, 8, 4, 48, 1, 1000, 'Sukses', '2025-11-08 12:22:28', '2025-11-08 12:22:28'),
(170, 8, 4, 48, 1, 1000, 'Sukses', '2025-11-08 12:22:29', '2025-11-08 12:22:29'),
(171, 8, 4, 48, 1, 1000, 'Sukses', '2025-11-08 12:22:29', '2025-11-08 12:22:29'),
(172, 8, 4, 48, 1, 1000, 'Sukses', '2025-11-08 12:22:30', '2025-11-08 12:22:30'),
(173, 8, 4, 48, 1, 1000, 'Sukses', '2025-11-08 12:22:30', '2025-11-08 12:22:30'),
(174, 8, 4, 48, 1, 1000, 'Sukses', '2025-11-08 12:22:30', '2025-11-08 12:22:30'),
(175, 8, 4, 48, 1, 1000, 'Sukses', '2025-11-08 12:22:30', '2025-11-08 12:22:30'),
(176, 8, 4, 48, 1, 1000, 'Sukses', '2025-11-08 12:22:30', '2025-11-08 12:22:30'),
(177, 8, 4, 48, 1, 1000, 'Sukses', '2025-11-08 12:22:31', '2025-11-08 12:22:31'),
(178, 8, 4, 48, 1, 1000, 'Sukses', '2025-11-08 12:22:32', '2025-11-08 12:22:32'),
(179, 8, 4, 48, 1, 1000, 'Sukses', '2025-11-08 12:22:32', '2025-11-08 12:22:32'),
(180, 8, 4, 48, 1, 1000, 'Sukses', '2025-11-08 12:22:32', '2025-11-08 12:22:32'),
(181, 8, 4, 48, 1, 1000, 'Sukses', '2025-11-08 12:22:33', '2025-11-08 12:22:33'),
(182, 8, 4, 48, 1, 1000, 'Sukses', '2025-11-08 12:22:33', '2025-11-08 12:22:33'),
(183, 8, 4, 48, 1, 1000, 'Sukses', '2025-11-08 12:22:33', '2025-11-08 12:22:33'),
(184, 8, 4, 48, 1, 1000, 'Sukses', '2025-11-08 12:22:35', '2025-11-08 12:22:35'),
(185, 8, 22, 48, 1, 1000, 'Gagal: Produk Habis', '2025-11-10 01:15:55', '2025-11-10 01:15:55'),
(186, 8, 22, 48, 1, 1000, 'Gagal: Produk Habis', '2025-11-10 01:16:02', '2025-11-10 01:16:02'),
(187, 2, 3, 44, 1, 1000000000, 'Sukses', '2025-11-10 01:16:09', '2025-11-10 01:16:09'),
(188, 2, 3, 44, 1, 1000000000, 'Sukses', '2025-11-10 01:16:13', '2025-11-10 01:16:13'),
(189, 7, 3, 47, 1, 20000000, 'Sukses', '2025-11-10 01:16:20', '2025-11-10 01:16:20'),
(190, 2, 3, 44, 1, 1000000000, 'Sukses', '2025-11-10 01:17:25', '2025-11-10 01:17:25'),
(191, 7, 3, 47, 1, 20000000, 'Sukses', '2025-11-10 01:17:35', '2025-11-10 01:17:35'),
(192, 7, 3, 47, 1, 20000000, 'Sukses', '2025-11-10 01:17:37', '2025-11-10 01:17:37'),
(193, 7, 3, 47, 1, 20000000, 'Gagal: Produk Habis', '2025-11-10 01:17:38', '2025-11-10 01:17:38'),
(194, 7, 3, 47, 1, 20000000, 'Gagal: Produk Habis', '2025-11-10 01:17:39', '2025-11-10 01:17:39'),
(195, 7, 3, 47, 1, 20000000, 'Gagal: Produk Habis', '2025-11-10 01:17:41', '2025-11-10 01:17:41'),
(196, 5, 3, 50, 1, 4000, 'Sukses', '2025-11-10 10:16:00', '2025-11-10 10:16:00');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `gudang`
--
ALTER TABLE `gudang`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `mesin`
--
ALTER TABLE `mesin`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama_produk_id` (`gudang_id`);

--
-- Indeks untuk tabel `setting_mesin_produk`
--
ALTER TABLE `setting_mesin_produk`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT untuk tabel `gudang`
--
ALTER TABLE `gudang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT untuk tabel `mesin`
--
ALTER TABLE `mesin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `produk`
--
ALTER TABLE `produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT untuk tabel `setting_mesin_produk`
--
ALTER TABLE `setting_mesin_produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=197;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
