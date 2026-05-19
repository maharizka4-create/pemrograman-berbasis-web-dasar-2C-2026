<?php
session_start();
require_once __DIR__ . '/../config/koneksi.php';

// proteksi login user
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user') {

    header("Location: /bookstore/modules/public/login.php");
    exit();

}

$username = $_SESSION['username'];

// total buku
$buku = mysqli_query($conn, "SELECT COUNT(*) as total FROM buku");
$totalBuku = mysqli_fetch_assoc($buku)['total'];

// buku terbaru
$data = mysqli_query($conn, "SELECT * FROM buku ORDER BY id DESC LIMIT 5");
?>

<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Dashboard User</title>

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

            <a href="#"
               class="text-orange-500 font-bold border-b-2 border-orange-500 pb-1">

               Dashboard

            </a>

            <a href="katalog.php"
               class="text-gray-600 hover:text-pink-500 transition font-semibold">

               Katalog Buku

            </a>

            <a href="keranjang.php"
               class="text-gray-600 hover:text-pink-500 transition font-semibold">

               Keranjang

            </a>

        </nav>

        <a href="/bookstore/modules/public/logout.php"
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
            Welcome To Book Store
        </h1>

        <p class="text-gray-600 text-lg">

            Selamat datang,

            <span class="font-bold text-pink-500">
                <?= $username ?>
            </span> 👋

        </p>

    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">

        <div class="bg-white/80 backdrop-blur-lg rounded-3xl
                    shadow-xl p-8 border border-orange-100
                    hover:scale-[1.02] transition">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-gray-500 text-xl mb-3">
                        Total Buku
                    </p>

                    <h2 class="text-6xl font-extrabold text-orange-500">
                        <?= $totalBuku ?>
                    </h2>

                </div>

                <div class="w-20 h-20 rounded-full bg-orange-100
                            flex items-center justify-center text-4xl">

                    📚

                </div>

            </div>

        </div>

        <div class="bg-white/80 backdrop-blur-lg rounded-3xl
                    shadow-xl p-8 border border-pink-100
                    hover:scale-[1.02] transition">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-gray-500 text-xl mb-3">
                        Status Akun
                    </p>

                    <h2 class="text-4xl font-extrabold text-pink-500">
                        USER
                    </h2>

                </div>

                <div class="w-20 h-20 rounded-full bg-pink-100
                            flex items-center justify-center text-4xl">

                    👤

                </div>

            </div>

        </div>

    </div>

    <div class="bg-white/80 backdrop-blur-lg rounded-3xl
                shadow-2xl p-8 border border-pink-100">

        <div class="flex items-center justify-between mb-8">

            <h2 class="text-4xl font-bold text-gray-800">
                Buku Terbaru
            </h2>

            <a href="katalog.php"
               class="bg-gradient-to-r from-orange-500 to-pink-500
                      text-white px-6 py-3 rounded-2xl
                      font-semibold shadow-lg hover:scale-105 transition">

                Lihat Semua Buku

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
                        <th>Aksi</th>

                    </tr>

                </thead>

                <tbody>

                <?php $no=1; while($row=mysqli_fetch_assoc($data)) { ?>

                    <tr class="border-b border-pink-50 hover:bg-pink-50/50 transition">

                        <td class="py-5 font-semibold text-gray-700">
                            <?= $no++ ?>
                        </td>

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

                            <?php if($row['stok'] > 0) { ?>

                                <span class="bg-green-100 text-green-600
                                             px-4 py-2 rounded-xl
                                             text-sm font-semibold">

                                    <?= $row['stok'] ?> Buku

                                </span>

                            <?php } else { ?>

                                <span class="bg-red-100 text-red-600
                                             px-4 py-2 rounded-xl
                                             text-sm font-semibold">

                                    Stok Habis

                                </span>

                            <?php } ?>

                        </td>

                        <td>

                            <?php if($row['stok'] > 0) { ?>

                            <button
                                onclick="openModal(
                                    '<?= $row['judul_buku'] ?>',
                                    '<?= $row['harga'] ?>',
                                    '<?= $row['stok'] ?>'
                                )"
                                class="bg-gradient-to-r from-orange-500 to-pink-500
                                       hover:scale-105 transition
                                       text-white px-5 py-2 rounded-xl
                                       text-sm font-semibold shadow-lg">

                                Pesan

                            </button>

                            <?php } else { ?>

                            <button
                                disabled
                                class="bg-gray-300 cursor-not-allowed
                                       text-white px-5 py-2 rounded-xl
                                       text-sm font-semibold">

                                Habis

                            </button>

                            <?php } ?>

                        </td>

                    </tr>

                <?php } ?>

                </tbody>

            </table>

        </div>

    </div>

</main>

<!-- MODAL -->
<div id="modalPesan"
     class="fixed inset-0 bg-black/40 hidden
            items-center justify-center z-50 px-4">

    <div class="bg-white rounded-[30px]
                shadow-2xl border border-pink-100
                w-full max-w-md p-6 relative">

        <button onclick="closeModal()"
                class="absolute top-4 right-4
                       text-gray-400 hover:text-red-500
                       text-xl transition">

            ✕

        </button>

        <div class="mb-5">

            <h2 class="text-3xl font-extrabold text-gray-800">
                Form Pemesanan
            </h2>

            <p class="text-gray-500 text-sm mt-1">
                Isi data pemesanan buku 📚
            </p>

        </div>

        <form action="keranjang.php" method="POST" class="space-y-4">

            <input type="hidden" id="stokAsli">

            <div>

                <label class="block mb-1 text-sm font-semibold text-gray-600">
                    Judul Buku
                </label>

                <input type="text"
                       id="judulBuku"
                       name="judul_buku"
                       readonly
                       class="w-full border border-pink-200
                              rounded-xl px-4 py-3
                              bg-pink-50 text-sm outline-none">

            </div>

            <div>

                <label class="block mb-1 text-sm font-semibold text-gray-600">
                    Harga
                </label>

                <input type="text"
                       id="hargaBuku"
                       readonly
                       class="w-full border border-orange-200
                              rounded-xl px-4 py-3
                              bg-orange-50 text-sm outline-none">

            </div>

            <div>

                <label class="block mb-1 text-sm font-semibold text-gray-600">
                    Stok Tersedia
                </label>

                <div class="bg-green-100 text-green-700
                            px-4 py-3 rounded-xl text-sm font-bold">

                    <span id="stokBuku"></span> Buku

                </div>

            </div>

            <div>

                <label class="block mb-1 text-sm font-semibold text-gray-600">
                    Nama
                </label>

                <input type="text"
                       name="nama"
                       required
                       placeholder="Masukkan nama..."
                       class="w-full border border-gray-200
                              rounded-xl px-4 py-3 text-sm
                              focus:border-pink-400 outline-none">

            </div>

            <div>

                <label class="block mb-1 text-sm font-semibold text-gray-600">
                    Jumlah
                </label>

                <input type="number"
                       id="jumlahInput"
                       name="jumlah"
                       required
                       min="1"
                       onkeyup="cekStok()"
                       onchange="cekStok()"
                       placeholder="Jumlah buku..."
                       class="w-full border border-gray-200
                              rounded-xl px-4 py-3 text-sm
                              focus:border-orange-400 outline-none">

            </div>

            <div id="notifStok"
                 class="hidden bg-red-100 text-red-600
                        px-4 py-3 rounded-xl text-sm font-semibold">

                Maaf, jumlah pembelian melebihi stok buku!

            </div>

            <div>

                <label class="block mb-1 text-sm font-semibold text-gray-600">
                    Pembayaran
                </label>

                <select
                    name="pembayaran"
                    class="w-full border border-gray-200
                           rounded-xl px-4 py-3 text-sm
                           focus:border-pink-400 outline-none">

                    <option>DANA</option>
                    <option>OVO</option>
                    <option>GoPay</option>
                    <option>Transfer Bank</option>

                </select>

            </div>

            <button type="submit"
                    id="btnBayar"
                    class="w-full bg-gradient-to-r
                           from-orange-500 to-pink-500
                           text-white py-3 rounded-xl
                           font-bold shadow-lg
                           hover:scale-[1.02] transition">

                Bayar Sekarang

            </button>

        </form>

    </div>

</div>

<script>

function openModal(judul, harga, stok){

    document.getElementById('modalPesan').classList.remove('hidden');
    document.getElementById('modalPesan').classList.add('flex');

    document.getElementById('judulBuku').value = judul;
    document.getElementById('hargaBuku').value = 'Rp' + Number(harga).toLocaleString();

    document.getElementById('stokBuku').innerText = stok;

    document.getElementById('stokAsli').value = stok;

    document.getElementById('jumlahInput').value = "";

    document.getElementById('notifStok').classList.add('hidden');

    document.getElementById('btnBayar').disabled = false;

    document.getElementById('btnBayar')
    .classList.remove('opacity-50','cursor-not-allowed');

}

function closeModal(){

    document.getElementById('modalPesan').classList.remove('flex');
    document.getElementById('modalPesan').classList.add('hidden');

}

function cekStok(){

    let stok = parseInt(document.getElementById('stokAsli').value);
    let jumlah = parseInt(document.getElementById('jumlahInput').value);

    let notif = document.getElementById('notifStok');
    let tombol = document.getElementById('btnBayar');

    if(isNaN(jumlah)){

        notif.classList.add('hidden');

        tombol.disabled = false;

        tombol.classList.remove(
            'opacity-50',
            'cursor-not-allowed'
        );

        return;

    }

    if(jumlah > stok){

        notif.classList.remove('hidden');

        tombol.disabled = true;

        tombol.classList.add(
            'opacity-50',
            'cursor-not-allowed'
        );

    } else {

        notif.classList.add('hidden');

        tombol.disabled = false;

        tombol.classList.remove(
            'opacity-50',
            'cursor-not-allowed'
        );

    }

}

</script>

</body>
</html>