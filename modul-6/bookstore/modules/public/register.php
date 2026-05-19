<?php
session_start();
require_once __DIR__ . '/../../config/koneksi.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username  = trim($_POST['username']);
    $email     = trim($_POST['email']);
    $password  = trim($_POST['password']);
    $konfirmasi = trim($_POST['konfirmasi']);

    if ($username == "" || $email == "" || $password == "" || $konfirmasi == "") {

        $error = "Semua field wajib diisi!";

    } elseif ($password != $konfirmasi) {

        $error = "Konfirmasi password tidak cocok!";

    } else {

        $cek = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $cek->bind_param("s", $username);
        $cek->execute();
        $cek->store_result();

        if ($cek->num_rows > 0) {

            $error = "Username sudah digunakan!";

        } else {

            $hash = password_hash($password, PASSWORD_DEFAULT);
            $role = "user";

            $stmt = $conn->prepare("
                INSERT INTO users(username,email,password,role)
                VALUES(?,?,?,?)
            ");

            $stmt->bind_param("ssss", $username, $email, $hash, $role);

            if ($stmt->execute()) {

                header("Location: login.php?registered=1");
                exit();

            } else {

                $error = "Registrasi gagal!";

            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Register</title>

<script src="https://cdn.tailwindcss.com"></script>

<style>
body{
    font-family: 'Poppins', sans-serif;
}
</style>

</head>

<body class="bg-gradient-to-br from-orange-100 via-pink-100 to-rose-100 min-h-screen flex items-center justify-center p-6">


<div class="bg-white/80 backdrop-blur-lg
            shadow-2xl rounded-[35px]
            w-full max-w-lg p-10 border border-pink-100">

    <div class="text-center mb-8">

        <div class="w-24 h-24 mx-auto rounded-full
                    bg-gradient-to-r from-orange-500 to-pink-500
                    flex items-center justify-center
                    text-white text-4xl shadow-xl mb-5">

            ✨

        </div>

        <h1 class="text-5xl font-extrabold
                   bg-gradient-to-r from-orange-500 to-pink-500
                   bg-clip-text text-transparent mb-2">

            Create Account

        </h1>

        <p class="text-gray-500">
            Daftar akun baru sekarang 🚀
        </p>

    </div>


    <?php if($error): ?>

    <div class="bg-red-100 text-red-600 p-4 rounded-2xl mb-5 text-sm">
        <?= $error ?>
    </div>

    <?php endif; ?>

    <form method="POST">

        <div class="mb-4">

            <label class="block mb-2 font-semibold text-gray-600">
                Username
            </label>

            <input type="text"
                   name="username"
                   class="w-full border border-pink-200
                          rounded-2xl px-5 py-4
                          focus:border-pink-400 outline-none"
                   required>

        </div>


        <div class="mb-4">

            <label class="block mb-2 font-semibold text-gray-600">
                Email
            </label>

            <input type="email"
                   name="email"
                   class="w-full border border-orange-200
                          rounded-2xl px-5 py-4
                          focus:border-orange-400 outline-none"
                   required>

        </div>


        <div class="mb-4">

            <label class="block mb-2 font-semibold text-gray-600">
                Password
            </label>

            <input type="password"
                   name="password"
                   class="w-full border border-pink-200
                          rounded-2xl px-5 py-4
                          focus:border-pink-400 outline-none"
                   required>

        </div>


        <div class="mb-6">

            <label class="block mb-2 font-semibold text-gray-600">
                Konfirmasi Password
            </label>

            <input type="password"
                   name="konfirmasi"
                   class="w-full border border-orange-200
                          rounded-2xl px-5 py-4
                          focus:border-orange-400 outline-none"
                   required>

        </div>


        <button type="submit"
                class="w-full bg-gradient-to-r
                       from-orange-500 to-pink-500
                       text-white py-4 rounded-2xl
                       font-bold shadow-xl
                       hover:scale-[1.02] transition">

            Daftar Sekarang

        </button>

    </form>

    <p class="text-center mt-7 text-gray-600">

        Sudah punya akun?

        <a href="login.php"
           class="text-pink-500 font-bold hover:underline">

            Login

        </a>

    </p>

</div>

</body>
</html>