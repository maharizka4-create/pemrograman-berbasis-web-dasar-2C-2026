<?php
session_start();
require_once __DIR__ . '/../../config/koneksi.php';

// cek id
if (!isset($_GET['id'])) {

    header("Location: ../../dashboard/dashboard.php");
    exit();

}

$id = $_GET['id'];


// HAPUS DATA
$stmt = $conn->prepare("DELETE FROM buku WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {

    header("Location: ../../dashboard/dashboard.php");
    exit();

} else {

    echo "Gagal menghapus buku.";

}
?>