<?php
// config koneksi.php
$host = 'localhost';
$dbname = 'bookstore';
$username = 'root';
$password = '123456';   

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error . "<br><br><b>Password yang kamu masukkan salah.</b>");
}

$conn->set_charset("utf8mb4");
?>