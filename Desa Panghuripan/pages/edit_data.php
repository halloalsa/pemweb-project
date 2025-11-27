<?php
require "../components/session_protected.php";
require "../components/components.php";
require "../config/koneksi.php";

$id = $_GET['id'];

$query = "SELECT * FROM penduduk WHERE id = '$id'";
$result = mysqli_query($koneksi, $query);
$data   = mysqli_fetch_assoc($result);

if (!$data) {
    header("Location: admin_penduduk.php?status=tidak_ditemukan");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <?= head('Edit Data Penduduk') ?>
    <link rel="stylesheet" href="../style/dashboardAdmin.css">
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
            <span>Hello, <?= htmlspecialchars($_SESSION['username_admin']) ?> !</span>
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>
    </nav>

    <div class="admin-inner-bg">
        <div class="admin-inner-wrapper">

            <h1 class="admin-page-title">Edit Data Penduduk</h1>
            <p class="admin-page-subtitle">
                Perbarui informasi penduduk berikut kemudian simpan perubahan.
            </p>

            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="admin-card">
                        <h2><?= $data['nama']; ?></h2>
                        <p class="card-subtitle">ID Penduduk: <?= $data['id']; ?></p>

                        <form action="../logic/update_data.php" method="POST">
                            <input type="hidden" name="id" value="<?= $data['id']; ?>">

                            <div class="mb-3">
                                <label class="form-label">No. KK</label>
                                <input type="text" name="no_kk" class="form-control form-control-round"
                                       value="<?= $data['no_kk']; ?>">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Nama</label>
                                <input type="text" name="nama" class="form-control form-control-round"
                                       value="<?= $data['nama']; ?>">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Jalan / Dusun</label>
                                <input type="text" name="jalan" class="form-control form-control-round"
                                       value="<?= $data['jalan']; ?>">
                            </div>

                            <div class="row g-2">
                                <div class="col-4">
                                    <label class="form-label">Usia</label>
                                    <input type="number" name="usia" class="form-control form-control-round"
                                           value="<?= $data['usia']; ?>">
                                </div>
                                <div class="col-4">
                                    <label class="form-label">Jenis Kelamin</label>
                                    <select name="jenis_kelamin" class="form-select form-control-round">
                                        <option value="L" <?= $data['jenis_kelamin']=='L'?'selected':''; ?>>L</option>
                                        <option value="P" <?= $data['jenis_kelamin']=='P'?'selected':''; ?>>P</option>
                                    </select>
                                </div>
                                <div class="col-4">
                                    <label class="form-label">Status Hidup</label>
                                    <select name="status_hidup" class="form-select form-control-round">
                                        <option value="Hidup" <?= $data['status_hidup']=='Hidup'?'selected':''; ?>>Hidup</option>
                                        <option value="Meninggal" <?= $data['status_hidup']=='Meninggal'?'selected':''; ?>>Meninggal</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3 mt-2">
                                <label class="form-label">Status Pernikahan</label>
                                <select name="status_pernikahan" class="form-select form-control-round">
                                    <option value="Belum Menikah" <?= $data['status_pernikahan']=='Belum Menikah'?'selected':''; ?>>Belum Menikah</option>
                                    <option value="Menikah" <?= $data['status_pernikahan']=='Menikah'?'selected':''; ?>>Menikah</option>
                                    <option value="Cerai" <?= $data['status_pernikahan']=='Cerai'?'selected':''; ?>>Cerai</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Pekerjaan</label>
                                <input type="text" name="pekerjaan" class="form-control form-control-round"
                                       value="<?= $data['pekerjaan']; ?>">
                            </div>

                            <div class="row g-2">
                                <div class="col-6">
                                    <label class="form-label">Pendidikan Terakhir</label>
                                    <input type="text" name="pendidikan_terakhir"
                                           class="form-control form-control-round"
                                           value="<?= $data['pendidikan_terakhir']; ?>">
                                </div>
                                <div class="col-6">
                                    <label class="form-label">Tahun Lahir</label>
                                    <input type="number" name="tahun_lahir" class="form-control form-control-round"
                                           value="<?= $data['tahun_lahir']; ?>">
                                </div>
                            </div>

                            <div class="mb-3 mt-2">
                                <label class="form-label">Tahun Meninggal (opsional)</label>
                                <input type="number" name="tahun_meninggal" class="form-control form-control-round"
                                       value="<?= $data['tahun_meninggal']; ?>">
                            </div>

                            <div class="d-flex justify-content-between mt-3">
                                <a href="admin_penduduk.php" class="btn-pill btn-pill-outline">
                                    Batal
                                </a>
                                <button type="submit" name="update" class="btn-pill btn-pill-primary">
                                    Simpan Perubahan
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>

</body>
</html>
