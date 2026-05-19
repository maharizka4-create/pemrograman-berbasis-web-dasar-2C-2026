<?php
session_start();

// hapus session semua
$_SESSION = [];

session_unset();
session_destroy();

// redirect ke login
header("Location: /bookstore/modules/public/login.php");
exit();
?>