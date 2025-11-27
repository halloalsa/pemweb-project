<?php
require "../components/session_protected.php";
require "../config/koneksi.php";

if (isset($_POST['update'])) {

    $id                 = $_POST['id'];
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
        UPDATE penduduk SET
            no_kk = '$no_kk',
            nama = '$nama',
            jalan = '$jalan',
            usia = '$usia',
            jenis_kelamin = '$jenis_kelamin',
            status_pernikahan = '$status_pernikahan',
            pekerjaan = '$pekerjaan',
            pendidikan_terakhir = '$pendidikan',
            tahun_lahir = '$tahun_lahir',
            status_hidup = '$status_hidup',
            tahun_meninggal = $tahun_meninggal
        WHERE id = '$id'
    ";

    $result = mysqli_query($koneksi, $query);

    if ($result) {
        header("Location: ../pages/admin_penduduk.php?status=update_sukses");
    } else {
        header("Location: ../pages/admin_penduduk.php?status=update_gagal");
    }
    exit;
} else {
    header("Location: ../pages/admin_penduduk.php");
    exit;
}
