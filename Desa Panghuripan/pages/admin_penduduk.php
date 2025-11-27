<?php
require "../components/session_protected.php";
require "../components/components.php";
require "../config/koneksi.php";

// ambil username admin yang login
$username = isset($_SESSION['username_admin']) ? $_SESSION['username_admin'] : 'Admin';

// ambil keyword pencarian (jika ada)
$keyword = isset($_GET['cari']) ? trim($_GET['cari']) : "";

// query data penduduk
if ($keyword !== "") {
    // cari berdasarkan id atau nama
    $sql = "SELECT * FROM penduduk 
            WHERE id = '$keyword' 
               OR nama LIKE '%$keyword%'
            ORDER BY id ASC";
} else {
    $sql = "SELECT * FROM penduduk ORDER BY id ASC";
}

$result = mysqli_query($koneksi, $sql);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <?= head('Data dan Statistik') ?>
    <link rel="stylesheet" href="../style/dashboardAdmin.css"><!-- untuk navbar -->
    <link rel="stylesheet" href="../style/adm_penduduk.css"><!-- khusus halaman ini -->
</head>

<body>
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

    <!-- BACKGROUND GRADIENT + KONTEN -->
    <div class="penduduk-bg">
        <div class="penduduk-header">
            <div>
                <h1 class="penduduk-page-title">Data dan Statistik</h1>
                <p class="penduduk-page-subtitle">
                    Lihat dan kelola semua data penduduk Desa Panghuripan.
                </p>
            </div>

            <a href="tambah_penduduk.php" class="btn-tambah-penduduk">
                Tambah Penduduk
            </a>
        </div>

        <!-- KARTU TABEL PENDUDUK -->
        <div class="penduduk-card">
            <div class="penduduk-card-top">
                <h2 class="penduduk-card-title">Daftar Penduduk</h2>

                <!-- FORM SEARCH -->
                <form method="get" class="penduduk-search-form">
                    <input
                        type="text"
                        name="cari"
                        class="penduduk-search-input"
                        placeholder="Cari berdasarkan ID atau Nama..."
                        value="<?= htmlspecialchars($keyword) ?>"
                    >
                    <button type="submit" class="penduduk-search-btn">Cari</button>
                </form>
            </div>

            <!-- TABEL -->
            <div class="penduduk-table-wrapper">
                <table class="penduduk-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>KK / Alamat</th>
                            <th>Usia</th>
                            <th>JK</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($result) > 0): ?>
                            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                <tr>
                                    <td><?= $row['id'] ?></td>
                                    <td><?= htmlspecialchars($row['nama']) ?></td>
                                    <td>
                                        <div class="kk-text"><?= htmlspecialchars($row['no_kk']) ?></div>
                                        <div class="alamat-text"><?= htmlspecialchars($row['jalan']) ?></div>
                                    </td>
                                    <td><?= $row['usia'] ?></td>
                                    <td><?= $row['jenis_kelamin'] ?></td>
                                    <td>
                                        <?= htmlspecialchars($row['status_pernikahan']) ?>
                                        | <?= htmlspecialchars($row['status_hidup']) ?>
                                    </td>
                                    <td>
                                        <a href="edit_penduduk.php?id=<?= $row['id'] ?>" class="btn-edit">Edit</a>
                                        <a href="hapus_penduduk.php?id=<?= $row['id'] ?>"
                                           class="btn-delete"
                                           onclick="return confirm('Yakin ingin menghapus data ini?')">
                                            Hapus
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center-empty">
                                    Data tidak ditemukan. Coba kata kunci lain.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
            crossorigin="anonymous"></script>
</body>
</html>
