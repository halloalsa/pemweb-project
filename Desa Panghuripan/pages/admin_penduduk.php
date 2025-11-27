<?php
require "../components/session_protected.php";
require "../components/components.php";
require "../config/koneksi.php";

$username = $_SESSION['username_admin'] ?? 'Admin';

$keyword = "";
if (isset($_GET['cari'])) {
    $keyword = trim($_GET['cari']);
}

$sql = "SELECT * FROM penduduk";
if ($keyword !== "") {
    $sql .= " WHERE id = '$keyword' OR nama LIKE '%$keyword%'";
}
$sql .= " ORDER BY id ASC";

$penduduk = mysqli_query($koneksi, $sql);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <?= head('Data dan Statistik') ?>
    <link rel="stylesheet" href="../style/dashboardAdmin.css">
    <link rel="stylesheet" href="../style/adm_penduduk.css">
</head>

<body>
    <!-- NAVBAR -->
    <nav class="navbar-admin navbar-admin-shadow">
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

    <div class="penduduk-bg">
        <div class="penduduk-wrapper">
            <div class="penduduk-header">
                <h1 class="penduduk-page-title">DATA DAN STATISTIK</h1>
                <p class="penduduk-page-subtitle">
                    Lihat dan kelola semua data penduduk Desa Panghuripan.
                </p>
            </div>

            <div class="penduduk-top-actions">
                <a href="tambah_penduduk.php" class="btn btn-tambah-penduduk">
                    Tambah Penduduk
                </a>
            </div>

            <div class="penduduk-card">
                <div class="penduduk-card-header">
                    <h2 class="penduduk-card-title">Daftar Penduduk</h2>

                    <form method="GET" class="search-form">
                        <input
                            type="text"
                            name="cari"
                            class="search-input"
                            placeholder="Cari berdasarkan ID atau Nama..."
                            value="<?= htmlspecialchars($keyword) ?>"
                        >
                        <button type="submit" class="search-btn">Cari</button>
                    </form>
                </div>

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
                        <?php if (mysqli_num_rows($penduduk) > 0): ?>
                            <?php $i = 0; ?>
                            <?php while ($row = mysqli_fetch_assoc($penduduk)): ?>
                                <?php $i++; ?>
                                <tr class="<?= $i % 2 == 0 ? 'row-hijau' : 'row-krem' ?>">
                                    <td><?= $row['id'] ?></td>
                                    <td><?= htmlspecialchars($row['nama']) ?></td>
                                    <td>
                                        <strong><?= htmlspecialchars($row['no_kk']) ?></strong><br>
                                        <?= htmlspecialchars($row['jalan']) ?>
                                    </td>
                                    <td><?= $row['usia'] ?></td>
                                    <td><?= htmlspecialchars($row['jenis_kelamin']) ?></td>
                                    <td>
                                        <?= htmlspecialchars($row['status_pernikahan']) ?>
                                        |
                                        <?= htmlspecialchars($row['status_hidup']) ?>
                                    </td>
                                    <td class="aksi-col">
                                        <a href="edit_penduduk.php?id=<?= $row['id'] ?>" class="btn-aksi btn-edit">Edit</a>
                                        <a
                                            href="../logic/hapus_data.php?id=<?= $row['id'] ?>"
                                            class="btn-aksi btn-hapus"
                                            onclick="return confirm('Yakin ingin menghapus data ini?');"
                                        >
                                            Hapus
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center">
                                    Data tidak ditemukan.
                                </td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

</body>
</html>
