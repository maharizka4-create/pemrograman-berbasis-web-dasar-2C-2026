<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {

    header("Location: /bookstore/modules/public/login.php");
    exit();

}

require_once __DIR__ . '/../config/koneksi.php';

$data = mysqli_query($conn, "
    SELECT 
        id,
        username,
        email,
        ROLE as role
    FROM users
    ORDER BY id DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Data User</title>

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
                        text-white font-bold text-xl">

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
               class="text-gray-600 hover:text-pink-500 transition font-semibold">
               Dashboard
            </a>

            <a href="data_user.php"
               class="text-orange-500 font-bold border-b-2 border-orange-500 pb-1">
               Data User
            </a>

            <a href="data_buku.php"
               class="text-gray-600 hover:text-pink-500 transition font-semibold">
               Data Buku
            </a>

        </nav>


        <a href="../modules/public/logout.php"
           class="bg-gradient-to-r from-orange-500 to-pink-500
                  text-white px-6 py-3 rounded-2xl font-bold shadow-lg">

            Logout

        </a>

    </div>

</header>

<div class="p-10">

    <div class="bg-white/80 backdrop-blur-lg
                rounded-3xl shadow-2xl p-8">

        <h1 class="text-5xl font-extrabold text-gray-800 mb-8">
            Data User 👤
        </h1>


        <div class="overflow-x-auto">

            <table class="w-full">

                <thead>

                    <tr class="border-b-2 border-pink-100 text-left text-gray-500">

                        <th class="py-5">No</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>

                    </tr>

                </thead>

                <tbody>

                <?php $no=1; while($row=mysqli_fetch_assoc($data)) { ?>

                    <tr class="border-b hover:bg-pink-50 transition">

                        <td class="py-5">
                            <?= $no++ ?>
                        </td>

                        <td class="font-semibold text-gray-800">
                            <?= $row['username'] ?>
                        </td>

                        <td>
                            <?= $row['email'] ?>
                        </td>

                        <td>

                            <span class="bg-orange-100 text-orange-600
                                         px-4 py-2 rounded-xl
                                         text-sm font-semibold">

                                <?= $row['role'] ?>

                            </span>

                        </td>

                    </tr>

                <?php } ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

</body>
</html>