<?php
session_start();
require_once __DIR__ . '/../config/koneksi.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: /bookstore/modules/public/login.php");
    exit();
}

// total user
$user = mysqli_query($conn, "SELECT COUNT(*) as total FROM users");
$totalUser = mysqli_fetch_assoc($user)['total'];

// total buku
$buku = mysqli_query($conn, "SELECT COUNT(*) as total FROM buku");
$totalBuku = mysqli_fetch_assoc($buku)['total'];

// data buku
$data = mysqli_query($conn, "SELECT * FROM buku ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Dashboard Admin</title>

<script src="https://cdn.tailwindcss.com"></script>

<style>
body{
    font-family: 'Poppins', sans-serif;
}
</style>

</head>

<body class="bg-gradient-to-br from-orange-100 via-pink-100 to-rose-100 min-h-screen">

<header class="bg-white shadow-xl rounded-3xl mx-6 mt-6 px-8 py-5">

    <div class="flex items-center justify-between">

        <!-- LOGO -->
        <div class="flex items-center gap-4">

            <div class="w-14 h-14 rounded-2xl 
                        bg-gradient-to-r from-orange-500 to-pink-500
                        flex items-center justify-center 
                        text-white font-bold text-xl shadow-lg">
                BS
            </div>

            <h1 class="text-4xl font-extrabold 
                       bg-gradient-to-r from-orange-500 to-pink-500 
                       bg-clip-text text-transparent">
                Book Store
            </h1>

        </div>

<nav class="hidden md:flex items-center gap-10">

    <a href="dashboard.php"
       class="text-orange-500 font-bold border-b-2 border-orange-500 pb-1">
       Dashboard
    </a>

    <a href="data_user.php"
       class="text-gray-600 hover:text-pink-500 transition font-semibold">
       Data User
    </a>

    <a href="data_buku.php"
       class="text-gray-600 hover:text-pink-500 transition font-semibold">
       Data Buku
    </a>

</nav>

<a href="../modules/public/logout.php"
   class="bg-gradient-to-r from-orange-500 to-pink-500 
          hover:scale-105 transition 
          text-white px-7 py-3 rounded-2xl 
          font-semibold shadow-lg">

    Logout

</a>

    </div>

</header>

<main class="p-10">

    <div class="mb-10">

        <h1 class="text-6xl font-extrabold text-gray-800 mb-3">
            Dashboard Admin
        </h1>

        <p class="text-gray-600 text-lg">
            Kelola seluruh data toko buku dengan mudah 📚
        </p>

    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">

        <div class="bg-white/80 backdrop-blur-lg rounded-3xl 
                    shadow-xl p-8 border border-orange-100 
                    hover:scale-[1.02] transition">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-gray-500 text-xl mb-3">
                        Total User
                    </p>

                    <h2 class="text-6xl font-extrabold text-orange-500">
                        <?= $totalUser ?>
                    </h2>

                </div>

                <div class="w-20 h-20 rounded-full bg-orange-100 
                            flex items-center justify-center text-4xl">
                    👤
                </div>

            </div>

        </div>

        <div class="bg-white/80 backdrop-blur-lg rounded-3xl 
                    shadow-xl p-8 border border-pink-100 
                    hover:scale-[1.02] transition">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-gray-500 text-xl mb-3">
                        Total Buku
                    </p>

                    <h2 class="text-6xl font-extrabold text-pink-500">
                        <?= $totalBuku ?>
                    </h2>

                </div>

                <div class="w-20 h-20 rounded-full bg-pink-100 
                            flex items-center justify-center text-4xl">
                    📚
                </div>

            </div>

        </div>

    </div>

    <div class="bg-white/80 backdrop-blur-lg rounded-3xl 
                shadow-2xl p-8 border border-pink-100">

        <div class="flex items-center justify-between mb-8">

            <h2 class="text-4xl font-bold text-gray-800">
                Semua Data Buku
            </h2>

            <a href="../../bookstore/modules/public/tambah_buku.php"
               class="bg-gradient-to-r from-orange-500 to-pink-500 
                      text-white px-6 py-3 rounded-2xl 
                      font-semibold shadow-lg hover:scale-105 transition">
                + Tambah Buku
            </a>

        </div>

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead>

                    <tr class="text-left text-gray-600 border-b-2 border-pink-100">

                        <th class="py-5">No</th>
                        <th>Judul Buku</th>
                        <th>Penulis</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th class="text-center">Aksi</th>

                    </tr>

                </thead>

                <tbody>

                <?php $no=1; while($row=mysqli_fetch_assoc($data)) { ?>

                    <tr class="border-b border-pink-50 hover:bg-pink-50/50 transition">

                        <td class="py-5 font-semibold text-gray-700">
                            <?= $no++ ?>
                        </td>

                        <!-- FIX ERROR -->
                        <td class="font-semibold text-gray-800">
                            <?= $row['judul_buku'] ?>
                        </td>

                        <td class="text-gray-600">
                            <?= $row['penulis'] ?>
                        </td>

                        <td>
                            <span class="bg-orange-100 text-orange-600 
                                         px-4 py-2 rounded-xl 
                                         text-sm font-semibold">
                                <?= $row['kategori'] ?>
                            </span>
                        </td>

                        <td class="font-semibold text-orange-500">
                            Rp<?= number_format($row['harga']) ?>
                        </td>

                        <td>
                            <span class="bg-pink-100 text-pink-600 
                                         px-4 py-2 rounded-xl 
                                         text-sm font-semibold">
                                <?= $row['stok'] ?>
                            </span>
                        </td>

                        <td class="text-center space-x-2">

                            <a href="../../bookstore/modules/public/edit_buku.php?id=<?= $row['id'] ?>"
                               class="inline-block bg-yellow-400 
                                      hover:bg-yellow-500 
                                      text-white px-5 py-2 
                                      rounded-xl font-semibold transition">
                                Edit
                            </a>

                            <a href="../../bookstore/modules/public/hapus_buku.php?id=<?= $row['id'] ?>"
                               onclick="return confirm('Yakin hapus buku ini?')"
                               class="inline-block bg-red-500 
                                      hover:bg-red-600 
                                      text-white px-5 py-2 
                                      rounded-xl font-semibold transition">
                                Hapus
                            </a>

                        </td>

                    </tr>

                <?php } ?>

                </tbody>

            </table>

        </div>

    </div>

</main>

</body>
</html>