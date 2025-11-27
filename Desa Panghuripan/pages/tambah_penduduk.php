<?php
require "../components/session_protected.php";
require "../components/components.php";
require "../config/koneksi.php";

$username = $_SESSION['username_admin'] ?? 'Admin';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <?= head('Tambah Penduduk') ?>
    <link rel="stylesheet" href="../style/dashboardAdmin.css">
    <link rel="stylesheet" href="../style/adm_penduduk.css">
</head>

<body>
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
        <div class="penduduk-form-wrapper">
            <h1 class="penduduk-page-title">TAMBAH PENDUDUK</h1>
            <p class="penduduk-page-subtitle">
                Isi form berikut untuk menambahkan data penduduk baru.
            </p>

            <div class="form-card-penduduk">
                <form action="../logic/create_data.php" method="POST" class="form-penduduk">

                    <div class="mb-3">
                        <label for="no_kk" class="form-label">No. KK</label>
                        <input type="text" id="no_kk" name="no_kk" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" id="nama" name="nama" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="jalan" class="form-label">Jalan / Dusun</label>
                        <input type="text" id="jalan" name="jalan" class="form-control" required>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-3">
                            <label for="usia" class="form-label">Usia</label>
                            <input type="number" id="usia" name="usia" class="form-control" min="0" required>
                        </div>
                        <div class="col-md-3">
                            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                            <select id="jenis_kelamin" name="jenis_kelamin" class="form-select" required>
                                <option value="">Pilih</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="status_hidup" class="form-label">Status Hidup</label>
                            <select id="status_hidup" name="status_hidup" class="form-select" required>
                                <option value="Hidup">Hidup</option>
                                <option value="Meninggal">Meninggal</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="status_pernikahan" class="form-label">Status Pernikahan</label>
                            <select id="status_pernikahan" name="status_pernikahan" class="form-select" required>
                                <option value="Belum Menikah">Belum Menikah</option>
                                <option value="Menikah">Menikah</option>
                                <option value="Cerai">Cerai</option>
                            </select>
                        </div>
                    </div>

                    <div class="row g-3 mt-1">
                        <div class="col-md-4">
                            <label for="profesi" class="form-label">Profesi</label>
                            <input type="text" id="profesi" name="profesi" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label for="pendidikan" class="form-label">Pendidikan</label>
                            <input type="text" id="pendidikan" name="pendidikan" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <label for="tahun_lahir" class="form-label">Tahun Lahir</label>
                            <input type="number" id="tahun_lahir" name="tahun_lahir" class="form-control" min="1900" max="<?= date('Y') ?>" required>
                        </div>
                        <div class="col-md-2">
                            <label for="tahun_meninggal" class="form-label">Tahun Meninggal (opsional)</label>
                            <input type="number" id="tahun_meninggal" name="tahun_meninggal" class="form-control" min="1900" max="<?= date('Y') ?>">
                        </div>
                    </div>

                    <div class="mt-4 d-flex justify-content-between">
                        <a href="admin_penduduk.php" class="btn btn-kembali-penduduk">Kembali</a>
                        <button type="submit" name="simpan" class="btn btn-simpan-penduduk">Simpan</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

</body>
</html>
