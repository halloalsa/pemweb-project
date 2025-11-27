<?php
require "../components/session_protected.php";
require "../config/koneksi.php";

if (isset($_POST['simpan'])) {

    $no_kk              = $_POST['no_kk'];
    $nama               = $_POST['nama'];
    $jalan              = $_POST['jalan'];
    $usia               = $_POST['usia'];
    $jenis_kelamin      = $_POST['jenis_kelamin'];
    $status_hidup       = $_POST['status_hidup'];
    $status_pernikahan  = $_POST['status_pernikahan'];
    $pekerjaan          = $_POST['pekerjaan'];
    $pendidikan         = $_POST['pendidikan_terakhir'];
    $tahun_lahir        = $_POST['tahun_lahir'];
    $tahun_meninggal    = $_POST['tahun_meninggal'] === '' ? 'NULL' : $_POST['tahun_meninggal'];

    $query = "
        INSERT INTO penduduk
        (no_kk, nama, jalan, usia, jenis_kelamin, status_pernikahan, pekerjaan,
         pendidikan_terakhir, tahun_lahir, status_hidup, tahun_meninggal)
        VALUES (
            '$no_kk',
            '$nama',
            '$jalan',
            '$usia',
            '$jenis_kelamin',
            '$status_pernikahan',
            '$pekerjaan',
            '$pendidikan',
            '$tahun_lahir',
            '$status_hidup',
            $tahun_meninggal
        )
    ";

    $result = mysqli_query($koneksi, $query);

    if ($result) {
        header("Location: ../pages/admin_penduduk.php?status=tambah_sukses");
    } else {
        header("Location: ../pages/admin_penduduk.php?status=tambah_gagal");
    }
    exit;
} else {
    header("Location: ../pages/admin_penduduk.php");
    exit;
}
