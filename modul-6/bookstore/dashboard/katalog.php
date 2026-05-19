<?php
session_start();
require_once __DIR__ . '/../config/koneksi.php';

// cek login user
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user') {

    header("Location: /bookstore/modules/public/login.php");
    exit();

}

// ambil data buku
$data = mysqli_query($conn, "SELECT * FROM buku ORDER BY id DESC");

$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Katalog Buku</title>

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

            <a href="dashboard_user.php"
               class="text-gray-600 hover:text-pink-500 transition font-semibold">
               Dashboard
            </a>

            <a href="katalog.php"
               class="text-orange-500 font-bold border-b-2 border-orange-500 pb-1">
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

<main class="p-8">

    <div class="mb-10">

        <h1 class="text-6xl font-extrabold text-gray-800 mb-3">
            Katalog Buku 📚
        </h1>

        <p class="text-gray-600 text-lg">
            Temukan buku favorit kamu sekarang juga
        </p>

    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

        <?php while($row = mysqli_fetch_assoc($data)) { ?>

            <div class="bg-white/80 backdrop-blur-lg
                        rounded-3xl shadow-2xl
                        overflow-hidden border border-pink-100
                        hover:scale-[1.02] transition duration-300">

                <div class="h-44 bg-gradient-to-r
                            from-orange-300 to-pink-300
                            flex items-center justify-center">

                    <span class="text-7xl">
                        📖
                    </span>

                </div>

                <div class="p-6">

                    <h2 class="text-4xl font-extrabold text-gray-800 mb-2">
                        <?= $row['judul_buku'] ?>
                    </h2>

                    <p class="text-gray-500 mb-3">
                        <?= $row['penulis'] ?>
                    </p>

                    <div class="flex items-center gap-3 mb-4">

                        <span class="bg-orange-100 text-orange-600
                                     px-4 py-2 rounded-xl
                                     text-sm font-semibold">

                            <?= $row['kategori'] ?>

                        </span>

                        <?php if($row['stok'] > 0) { ?>

                            <span class="bg-green-100 text-green-600
                                         px-4 py-2 rounded-xl
                                         text-sm font-semibold">

                                Stok: <?= $row['stok'] ?>

                            </span>

                        <?php } else { ?>

                            <span class="bg-red-100 text-red-600
                                         px-4 py-2 rounded-xl
                                         text-sm font-semibold">

                                Stok Habis

                            </span>

                        <?php } ?>

                    </div>

                    <div class="flex items-center justify-between">

                        <div>

                            <p class="text-gray-400 text-sm">
                                Harga
                            </p>

                            <h3 class="text-4xl font-extrabold text-pink-500">
                                Rp<?= number_format($row['harga']) ?>
                            </h3>

                        </div>

                        <?php if($row['stok'] > 0) { ?>

                            <button
                                onclick="openModal(
                                    '<?= $row['judul_buku'] ?>',
                                    '<?= $row['harga'] ?>',
                                    '<?= $row['stok'] ?>'
                                )"

                                class="bg-gradient-to-r from-orange-500 to-pink-500
                                       hover:scale-105 transition
                                       text-white px-6 py-3 rounded-2xl
                                       font-semibold shadow-lg">

                                Pesan

                            </button>

                        <?php } else { ?>

                            <button
                                disabled
                                class="bg-gray-300
                                       text-white px-6 py-3 rounded-2xl
                                       font-semibold cursor-not-allowed">

                                Habis

                            </button>

                        <?php } ?>

                    </div>

                </div>

            </div>

        <?php } ?>

    </div>

</main>

<div id="modalPesan"
     class="fixed inset-0 bg-black/40 hidden
            items-center justify-center z-50 px-4">

    <div class="bg-white rounded-[30px]
                shadow-2xl border border-pink-100
                w-full max-w-md
                p-6 relative">

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

                <input type="text"
                       id="stokTampil"
                       readonly
                       class="w-full border border-green-200
                              rounded-xl px-4 py-3
                              bg-green-50 text-sm outline-none">

            </div>

            <div>

                <label class="block mb-1 text-sm font-semibold text-gray-600">
                    Nama Pemesan
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
                    Jumlah Buku
                </label>

                <input type="number"
                       id="jumlah"
                       name="jumlah"
                       required
                       min="1"
                       placeholder="Jumlah buku..."
                       oninput="cekStok()"
                       class="w-full border border-gray-200
                              rounded-xl px-4 py-3 text-sm
                              focus:border-orange-400 outline-none">

                <p id="notifStok"
                   class="text-red-500 text-sm mt-2 hidden">

                    Jumlah melebihi stok tersedia!

                </p>

            </div>

            <div>

                <label class="block mb-1 text-sm font-semibold text-gray-600">
                    Metode Pembayaran
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

    document.getElementById('stokAsli').value = stok;
    document.getElementById('stokTampil').value = stok + ' Buku';

}

function closeModal(){

    document.getElementById('modalPesan').classList.remove('flex');
    document.getElementById('modalPesan').classList.add('hidden');

}

function cekStok(){

    let stok = parseInt(document.getElementById('stokAsli').value);
    let jumlah = parseInt(document.getElementById('jumlah').value);

    let notif = document.getElementById('notifStok');
    let tombol = document.getElementById('btnBayar');

    if(jumlah > stok){

        notif.classList.remove('hidden');

        tombol.disabled = true;
        tombol.classList.remove('from-orange-500','to-pink-500');
        tombol.classList.add('bg-gray-400','cursor-not-allowed');

    } else {

        notif.classList.add('hidden');

        tombol.disabled = false;
        tombol.classList.remove('bg-gray-400','cursor-not-allowed');
        tombol.classList.add('from-orange-500','to-pink-500');

    }

}

</script>

</body>
</html>