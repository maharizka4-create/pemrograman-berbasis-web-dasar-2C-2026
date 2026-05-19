<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user') {

    header("Location: /bookstore/modules/public/login.php");
    exit();

}

require_once __DIR__ . '/../config/koneksi.php';

// buat session keranjang
if (!isset($_SESSION['keranjang'])) {
    $_SESSION['keranjang'] = [];
}

// proses tambah keranjang
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $judul       = $_POST['judul_buku'];
    $nama        = $_POST['nama'];
    $jumlah      = (int) $_POST['jumlah'];
    $pembayaran  = $_POST['pembayaran'];

    // cek data buku
    $cek = $conn->prepare("SELECT * FROM buku WHERE judul_buku = ?");
    $cek->bind_param("s", $judul);
    $cek->execute();

    $result = $cek->get_result();
    $buku = $result->fetch_assoc();

    // stok habis
    if ($buku['stok'] <= 0) {

        $_SESSION['error'] = "Maaf stok buku sudah habis!";

        header("Location: dashboard_user.php");
        exit();

    }

    // jumlah melebihi stok
    if ($jumlah > $buku['stok']) {

        $_SESSION['error'] = "Jumlah pembelian melebihi stok!";

        header("Location: dashboard_user.php");
        exit();

    }

    // kurangi stok
    $stokBaru = $buku['stok'] - $jumlah;

    $update = $conn->prepare("UPDATE buku SET stok=? WHERE id=?");
    $update->bind_param("ii", $stokBaru, $buku['id']);
    $update->execute();

    // simpan ke keranjang
    $data = [

        'judul' => $judul,
        'nama' => $nama,
        'jumlah' => $jumlah,
        'pembayaran' => $pembayaran

    ];

    $_SESSION['keranjang'][] = $data;

    $_SESSION['success'] = "Buku berhasil ditambahkan ke keranjang!";

    header("Location: keranjang.php");
    exit();
}

// ambil data keranjang
$keranjang = $_SESSION['keranjang'];
?>

<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Keranjang</title>

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
               class="text-gray-600 hover:text-pink-500 transition font-semibold">
               Katalog Buku
            </a>

            <a href="keranjang.php"
               class="text-orange-500 font-bold border-b-2 border-orange-500 pb-1">
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

<div class="p-10">

    <?php if(isset($_SESSION['success'])) { ?>

        <div class="bg-green-100 border border-green-200
                    text-green-600 p-4 rounded-2xl mb-6">

            <?= $_SESSION['success']; ?>

        </div>

    <?php unset($_SESSION['success']); } ?>


    <?php if(isset($_SESSION['error'])) { ?>

        <div class="bg-red-100 border border-red-200
                    text-red-600 p-4 rounded-2xl mb-6">

            <?= $_SESSION['error']; ?>

        </div>

    <?php unset($_SESSION['error']); } ?>


    <div class="mb-10">

        <h1 class="text-6xl font-extrabold text-gray-800 mb-3">
            Keranjang 🛒
        </h1>

        <p class="text-gray-500 text-lg">
            Daftar buku yang sudah kamu pesan
        </p>

    </div>

    <?php if(empty($keranjang)) { ?>

        <div class="bg-white/80 backdrop-blur-lg
                    rounded-[35px] shadow-2xl
                    p-20 text-center border border-pink-100">

            <div class="text-8xl mb-6">
                🛒
            </div>

            <h2 class="text-4xl font-extrabold text-gray-800 mb-4">
                Keranjang Masih Kosong
            </h2>

            <p class="text-gray-500 text-lg mb-10">
                Yuk beli buku favorit kamu sekarang juga 📚
            </p>

            <a href="katalog.php"
               class="bg-gradient-to-r from-orange-500 to-pink-500
                      hover:scale-105 transition
                      text-white px-10 py-4 rounded-2xl
                      font-bold shadow-lg text-lg">
                Belanja Buku
            </a>

        </div>

    <?php } else { ?>

        <div class="grid gap-8">

            <?php foreach($keranjang as $item) { ?>

                <div class="bg-white/80 backdrop-blur-lg
                            rounded-[35px] shadow-2xl
                            p-8 border border-pink-100
                            hover:scale-[1.01] transition">

                    <div class="flex items-center justify-between">

                        <div>

                            <div class="flex items-center gap-4 mb-5">

                                <div class="w-16 h-16 rounded-2xl
                                            bg-gradient-to-r
                                            from-orange-500 to-pink-500
                                            flex items-center justify-center
                                            text-white text-3xl shadow-lg">

                                    📚

                                </div>

                                <div>

                                    <h2 class="text-3xl font-extrabold text-gray-800">
                                        <?= $item['judul'] ?>
                                    </h2>

                                    <p class="text-gray-500">
                                        Pesanan Buku
                                    </p>

                                </div>

                            </div>

                            <div class="space-y-3">

                                <div class="flex items-center gap-3">

                                    <span class="bg-orange-100 text-orange-600
                                                 px-4 py-2 rounded-xl
                                                 font-semibold text-sm">

                                        Pemesan

                                    </span>

                                    <p class="text-gray-700 font-semibold">
                                        <?= $item['nama'] ?>
                                    </p>

                                </div>


                                <div class="flex items-center gap-3">

                                    <span class="bg-pink-100 text-pink-600
                                                 px-4 py-2 rounded-xl
                                                 font-semibold text-sm">

                                        Jumlah

                                    </span>

                                    <p class="text-gray-700 font-semibold">
                                        <?= $item['jumlah'] ?> Buku
                                    </p>

                                </div>


                                <div class="flex items-center gap-3">

                                    <span class="bg-purple-100 text-purple-600
                                                 px-4 py-2 rounded-xl
                                                 font-semibold text-sm">

                                        Pembayaran

                                    </span>

                                    <p class="text-gray-700 font-semibold">
                                        <?= $item['pembayaran'] ?>
                                    </p>

                                </div>

                            </div>

                        </div>

                        <div class="hidden md:flex">

                            <div class="w-32 h-32 rounded-full
                                        bg-gradient-to-r
                                        from-orange-200 to-pink-200
                                        flex items-center justify-center
                                        text-6xl shadow-inner">

                                📖

                            </div>

                        </div>

                    </div>

                </div>

            <?php } ?>

        </div>

    <?php } ?>

</div>

</body>
</html>