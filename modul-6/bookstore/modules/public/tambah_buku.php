<?php
session_start();
require_once __DIR__ . '/../../config/koneksi.php';

/*
|--------------------------------------------------------------------------
| PROTEKSI ADMIN
|--------------------------------------------------------------------------
*/
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {

    header("Location: /bookstore/modules/public/login.php");
    exit();

}

/*
|--------------------------------------------------------------------------
| PROSES TAMBAH BUKU
|--------------------------------------------------------------------------
*/
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $judul     = trim($_POST['judul_buku']);
    $penulis   = trim($_POST['penulis']);
    $kategori  = $_POST['kategori'];
    $harga     = $_POST['harga'];
    $stok      = $_POST['stok'];
    $tanggal   = $_POST['tanggal_masuk'];

    $stmt = $conn->prepare("
        INSERT INTO buku
        (judul_buku, penulis, kategori, harga, stok, tanggal_masuk)
        VALUES (?, ?, ?, ?, ?, ?)
    ");

    $stmt->bind_param(
        "sssdis",
        $judul,
        $penulis,
        $kategori,
        $harga,
        $stok,
        $tanggal
    );

    if ($stmt->execute()) {

        header("Location: ../../dashboard/dashboard.php");
        exit();

    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Tambah Buku</title>

<script src="https://cdn.tailwindcss.com"></script>

<style>
body{
    font-family: 'Poppins', sans-serif;
}
</style>

</head>

<body class="bg-gradient-to-br from-orange-100 via-pink-100 to-rose-100 min-h-screen">

<a href="/bookstore/dashboard/dashboard.php"
   class="fixed top-6 left-6
          w-12 h-12
          bg-white shadow-xl
          rounded-full
          flex items-center justify-center
          text-2xl font-bold text-gray-600
          hover:text-red-500
          hover:scale-110
          transition z-50">

    ✕

</a>

<div class="max-w-3xl mx-auto py-10 px-5">

    <div class="bg-white/80 backdrop-blur-lg
                rounded-[35px] shadow-2xl
                border border-pink-100
                p-10">

        <div class="mb-10 text-center">

            <h1 class="text-5xl font-extrabold
                       bg-gradient-to-r from-orange-500 to-pink-500
                       bg-clip-text text-transparent mb-3">

                Tambah Buku 📚

            </h1>

            <p class="text-gray-500">
                Tambahkan buku baru ke dalam katalog
            </p>

        </div>

        <form method="POST" class="space-y-6">

            <div>

                <label class="block mb-2 font-semibold text-gray-700">
                    Judul Buku
                </label>

                <input type="text"
                       name="judul_buku"
                       required
                       class="w-full border border-pink-200
                              rounded-2xl px-5 py-4
                              focus:outline-none
                              focus:border-pink-500">

            </div>

            <div>

                <label class="block mb-2 font-semibold text-gray-700">
                    Penulis
                </label>

                <input type="text"
                       name="penulis"
                       required
                       class="w-full border border-orange-200
                              rounded-2xl px-5 py-4
                              focus:outline-none
                              focus:border-orange-500">

            </div>

            <div class="grid md:grid-cols-2 gap-6">

                <div>

                    <label class="block mb-2 font-semibold text-gray-700">
                        Kategori
                    </label>

                    <select name="kategori"
                            class="w-full border border-pink-200
                                   rounded-2xl px-5 py-4
                                   focus:outline-none
                                   focus:border-pink-500">

                        <option value="Novel">Novel</option>
                        <option value="Komik">Komik</option>
                        <option value="Pelajaran">Pelajaran</option>
                        <option value="Agama">Agama</option>
                        <option value="Bisnis">Bisnis</option>
                        <option value="Lainnya">Lainnya</option>

                    </select>

                </div>

                <div>

                    <label class="block mb-2 font-semibold text-gray-700">
                        Harga
                    </label>

                    <input type="number"
                           name="harga"
                           required
                           class="w-full border border-orange-200
                                  rounded-2xl px-5 py-4
                                  focus:outline-none
                                  focus:border-orange-500">

                </div>

            </div>

            <div class="grid md:grid-cols-2 gap-6">

                <div>

                    <label class="block mb-2 font-semibold text-gray-700">
                        Stok
                    </label>

                    <input type="number"
                           name="stok"
                           required
                           class="w-full border border-pink-200
                                  rounded-2xl px-5 py-4
                                  focus:outline-none
                                  focus:border-pink-500">

                </div>

                <div>

                    <label class="block mb-2 font-semibold text-gray-700">
                        Tanggal Masuk
                    </label>

                    <input type="date"
                           name="tanggal_masuk"
                           required
                           class="w-full border border-orange-200
                                  rounded-2xl px-5 py-4
                                  focus:outline-none
                                  focus:border-orange-500">

                </div>

            </div>

            <button type="submit"
                    class="w-full bg-gradient-to-r
                           from-orange-500 to-pink-500
                           hover:scale-[1.02] transition
                           text-white py-4 rounded-2xl
                           font-bold shadow-lg">

                Simpan Buku

            </button>

        </form>

    </div>

</div>

</body>
</html>