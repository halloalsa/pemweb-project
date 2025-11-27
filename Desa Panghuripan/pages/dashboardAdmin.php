<?php
    require "../components/session_protected.php";
    require "../components/components.php";  
    require "../config/koneksi.php";

    $username = isset($_SESSION['username_admin']) ? $_SESSION['username_admin'] : 'Admin';

    function hitungPenduduk($koneksi, $where = '1') {
        $sql   = "SELECT COUNT(*) AS jumlah FROM penduduk WHERE $where";
        $query = mysqli_query($koneksi, $sql);
        $data  = mysqli_fetch_assoc($query);
        return (int) $data['jumlah'];
    }

        $jumlahPenduduk = hitungPenduduk($koneksi);
        $lakiLaki       = hitungPenduduk($koneksi, "jenis_kelamin = 'L'");
        $perempuan      = hitungPenduduk($koneksi, "jenis_kelamin = 'P'");
        $menikah        = hitungPenduduk($koneksi, "status_pernikahan = 'Menikah'");
        $belumMenikah   = hitungPenduduk($koneksi, "status_pernikahan = 'Belum Menikah'");
        $kematian       = hitungPenduduk($koneksi, "status_hidup = 'Meninggal'");
        // kelahiran: pakai tahun_lahir = tahun sekarang (kolommu tipe tahun/int)
        $kelahiran      = hitungPenduduk($koneksi, "tahun_lahir = YEAR(CURDATE())");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <?= head('Dashboard Admin') ?>
    <link rel="stylesheet" href="../style/dashboardAdmin.css">
</head>

<body>
    <!-- navbar -->
    <nav class="navbar-admin">
        <div class="logo-area">
            <img src="../assets/admin/logo.svg" alt="Logo Desa">
            <div class="brand">
                <h3>Desa Panghuripan</h3>
                <p>Kabupaten Sleman</p>
            </div>
        </div>

        <div class="admin-info">
            <span>Hello, <?= htmlspecialchars($username) ?> !</span>
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>
    </nav>

    <div class="dashboard-bg">
        <div class="container py-5">

            <h1 class="dashboard-title">Dashboard Admin</h1>
            <p class="dashboard-subtitle">
                Kelola semua data terkait sensus kependudukan, berita dan pengumuman, serta semua konten Desa Panghuripan.
            </p>

            <!-- KARTU STATISTIK ATAS -->
            <div class="row g-4 mt-2">
                <div class="col-md-3">
                    <div class="stat-card">
                        <p class="stat-label">Jumlah Penduduk</p>
                        <p class="stat-value"><?= $jumlahPenduduk ?> jiwa</p>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="stat-card">
                        <p class="stat-label">Laki – Laki</p>
                        <p class="stat-value"><?= $lakiLaki ?> jiwa</p>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="stat-card">
                        <p class="stat-label">Perempuan</p>
                        <p class="stat-value"><?= $perempuan ?> jiwa</p>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="stat-card">
                        <p class="stat-label">Kelahiran</p>
                        <p class="stat-value"><?= $kelahiran ?> jiwa</p>
                    </div>
                </div>
            </div>

            <div class="row g-4 mt-1">
                <div class="col-md-3">
                    <div class="stat-card">
                        <p class="stat-label">Menikah</p>
                        <p class="stat-value"><?= $menikah ?> jiwa</p>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="stat-card">
                        <p class="stat-label">Belum Menikah</p>
                        <p class="stat-value"><?= $belumMenikah ?> jiwa</p>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="stat-card">
                        <p class="stat-label">Kematian</p>
                        <p class="stat-value"><?= $kematian ?> jiwa</p>
                    </div>
                </div>

                <!-- kolom ke-4 sengaja dikosongin biar layout rapi -->
                <div class="col-md-3"> </div>
            </div>

            <div class="row g-4 mt-5">
                <div class="col-md-6">
                    <div class="menu-card">
                        <h3>Data dan Statistik</h3>
                        <p>Lihat dan kelola semua data penduduk.</p>
                        <a href="admin_penduduk.php" class="menu-btn">Kelola</a>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="menu-card">
                        <h3>Berita dan Pengumuman</h3>
                        <p>Atur konten berita dan pengumuman desa.</p>
                        <a href="admin_berita.php" class="menu-btn">Kelola</a>
                    </div>
                </div>
            </div>

            <div class="row g-4 mt-3 mb-4">
                <div class="col-md-6">
                    <div class="menu-card">
                        <h3>Galeri Desa</h3>
                        <p>Upload atau edit gambar di album.</p>
                        <a href="admin_galeri.php" class="menu-btn">Kelola</a>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="menu-card">
                        <h3>Struktur Desa</h3>
                        <p>Kelola struktur kepengurusan desa.</p>
                        <a href="admin_struktur.php" class="menu-btn">Kelola</a>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"> </script>
</body>
</html>
