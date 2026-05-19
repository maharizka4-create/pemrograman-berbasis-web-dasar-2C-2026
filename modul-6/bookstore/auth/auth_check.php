<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function cekLogin() {

    if (!isset($_SESSION['username'])) {

        header("Location: /bookstore/modules/public/login.php");
        exit();

    }

}

function cekAdmin() {

    cekLogin();

    if ($_SESSION['role'] !== 'admin') {

        die("Akses ditolak!");

    }

}

function cekUser() {

    cekLogin();

    if ($_SESSION['role'] !== 'user') {

        die("Akses ditolak!");

    }

}