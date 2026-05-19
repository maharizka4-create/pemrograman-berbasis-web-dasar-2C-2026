<?php
session_start();
require_once __DIR__ . '/../../config/koneksi.php';

$error = "";
$sukses = "";

// notif after register
if (isset($_GET['registered'])) {
    $sukses = "Registrasi berhasil, silakan login!";
}

// proses loginnya
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);


    if ($username === 'admin' && $password === '123') {

        $_SESSION['user_id']  = 0;
        $_SESSION['username'] = 'admin';
        $_SESSION['role']     = 'admin';

        header("Location: /bookstore/dashboard/dashboard.php");
        exit();
    }

    // login user database
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND ROLE = 'user'");
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {

        $user = $result->fetch_assoc();

        if (password_verify($password, $user['PASSWORD'])) {

            $_SESSION['user_id']  = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role']     = 'user';

            header("Location: /bookstore/dashboard/dashboard_user.php");
            exit();

        } else {

            $error = "Password salah!";

        }

    } else {

        $error = "Username tidak ditemukan!";

    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Login</title>

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
            w-full max-w-md p-10 border border-pink-100">

    <div class="text-center mb-8">

        <div class="w-24 h-24 mx-auto rounded-full
                    bg-gradient-to-r from-orange-500 to-pink-500
                    flex items-center justify-center
                    text-white text-4xl shadow-xl mb-5">

            📚

        </div>

        <h1 class="text-5xl font-extrabold
                   bg-gradient-to-r from-orange-500 to-pink-500
                   bg-clip-text text-transparent mb-2">

            Book Store

        </h1>

        <p class="text-gray-500 text-lg">
            Login ke akun kamu ✨
        </p>

    </div>

    <?php if($error): ?>
        <div class="bg-red-100 border border-red-200
                    text-red-600 p-4 rounded-2xl mb-5 text-sm">

            <?= $error ?>

        </div>
    <?php endif; ?>

    <?php if($sukses): ?>
        <div class="bg-green-100 border border-green-200
                    text-green-600 p-4 rounded-2xl mb-5 text-sm">

            <?= $sukses ?>

        </div>
    <?php endif; ?>

    <form method="POST">

        <div class="mb-5">

            <label class="block mb-2 font-semibold text-gray-700">
                Username
            </label>

            <input
                type="text"
                name="username"
                placeholder="Masukkan username..."
                class="w-full border border-pink-200
                       rounded-2xl px-5 py-4
                       focus:border-pink-400
                       focus:ring-4 focus:ring-pink-100
                       outline-none transition"
                required
            >

        </div>

        <div class="mb-7">

            <label class="block mb-2 font-semibold text-gray-700">
                Password
            </label>

            <input
                type="password"
                name="password"
                placeholder="Masukkan password..."
                class="w-full border border-orange-200
                       rounded-2xl px-5 py-4
                       focus:border-orange-400
                       focus:ring-4 focus:ring-orange-100
                       outline-none transition"
                required
            >

        </div>

        <button
            type="submit"
            class="w-full bg-gradient-to-r
                   from-orange-500 to-pink-500
                   text-white py-4 rounded-2xl
                   font-bold text-lg shadow-xl
                   hover:scale-[1.02] transition"
        >

            Login

        </button>

    </form>

    <p class="text-center mt-7 text-gray-600">

        Belum punya akun?

        <a href="register.php"
           class="text-pink-500 font-bold hover:underline">

            Sign Up

        </a>

    </p>

</div>

</body>
</html>