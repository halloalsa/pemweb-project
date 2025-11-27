<?php
require "../components/session_protected.php";
require "../config/koneksi.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "DELETE FROM penduduk WHERE id = '$id'";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        header("Location: ../pages/admin_penduduk.php?status=hapus_sukses");
    } else {
        header("Location: ../pages/admin_penduduk.php?status=hapus_gagal");
    }
    exit;
} else {
    header("/ocation: ../pages/admin_penduduk.php");
    exit;
}
