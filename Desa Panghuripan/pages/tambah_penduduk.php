<?php
require "../components/session_protected.php";
require "../components/components.php";
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <?= head('Tambah Penduduk') ?>
    <link rel="stylesheet" href="../style/adm_penduduk.css">
</head>

<body>
    <!-- NAVBAR ADMIN SAMA -->
    <nav class="navbar-admin">
        <div class="logo-area">
            <img src="../assets/admin/logo.svg" alt="Logo Desa">
            <div class="brand">
                <h3>Desa Panghuripan</h3>
                <p>Kabupaten Sleman</p>
            </div>
        </div>

        <div class="admin-info">
            <span>Hello, <?= htmlspecialchars($_SESSION['username_admin']) ?> !</span>
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>
    </nav>

    <div class="admin-list-bg">
        <div class="admin-form-wrapper">

            <div class="penduduk-form-card">
                <div class="form-title-row">
                    <h1 class="admin-page-title">Tambah Penduduk</h1>
                    <p class="admin-page-subtitle">
                        Isi form berikut untuk menambahkan data penduduk baru.
                    </p>
                </div>

                <form action="../logic/create_data.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label">No. KK</label>
                        <input type="text" name="no_kk" class="form-control form-control-round" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" name="nama" class="form-control form-control-round" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jalan / Dusun</label>
                        <input type="text" name="jalan" class="form-control form-control-round" required>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Usia</label>
                            <input type="number" name="usia" min="0" class="form-control form-control-round" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-select form-control-round" required>
                                <option value="">Pilih</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Status Hidup</label>
                            <select name="status_hidup" class="form-select form-control-round" required>
                                <option value="Hidup">Hidup</option>
                                <option value="Meninggal">Meninggal</option>
                            </select>
                        </div>
                    </div>

                    <div class="row g-3 mt-2">
                        <div class="col-md-6">
                            <label class="form-label">Status Pernikahan</label>
                            <select name="status_pernikahan" class="form-select form-control-round" required>
                                <option value="Belum Menikah">Belum Menikah</option>
                                <option value="Menikah">Menikah</option>
                                <option value="Cerai">Cerai</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Pekerjaan</label>
                            <input type="text" name="pekerjaan" class="form-control form-control-round">
                        </div>
                    </div>

                    <div class="row g-3 mt-2">
                        <div class="col-md-6">
                            <label class="form-label">Pendidikan Terakhir</label>
                            <input type="text" name="pendidikan_terakhir" class="form-control form-control-round">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Tahun Lahir</label>
                            <input type="number" name="tahun_lahir" min="1900" max="2100"
                                   class="form-control form-control-round">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Tahun Meninggal</label>
                            <input type="number" name="tahun_meninggal" min="1900" max="2100"
                                   class="form-control form-control-round">
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="admin_penduduk.php" class="btn-pill btn-secondary-back">
                            Kembali
                        </a>
                        <button type="submit" name="simpan" class="btn-pill btn-pill-primary">
                            Simpan Data
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
            crossorigin="anonymous"></script>
</body>
</html>
