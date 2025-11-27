<?php
require "../components/session_protected.php";
require "../components/components.php";
require "../config/koneksi.php";

$username = isset($_SESSION['username_admin']) ? $_SESSION['username_admin'] : 'Admin';

$editMode = false;
$editData = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id      = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $judul   = $_POST['judul'];
    $foto    = $_POST['foto']; // path atau URL
    $tanggal = $_POST['tanggal'];

    if ($id > 0) {
        $stmt = $koneksi->prepare("UPDATE galeri_desa SET judul=?, foto=?, tanggal=? WHERE id=?");
        $stmt->bind_param("sssi", $judul, $foto, $tanggal, $id);
        $stmt->execute();
    } else {
        $stmt = $koneksi->prepare("INSERT INTO galeri_desa (judul, foto, tanggal) VALUES (?,?,?)");
        $stmt->bind_param("sss", $judul, $foto, $tanggal);
        $stmt->execute();
    }

    header("Location: admin_galeri.php");
    exit;
}

if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    $koneksi->query("DELETE FROM galeri_desa WHERE id=$id");
    header("Location: admin_galeri.php");
    exit;
}

if (isset($_GET['edit'])) {
    $editMode = true;
    $id = (int)$_GET['edit'];
    $res = $koneksi->query("SELECT * FROM galeri_desa WHERE id=$id");
    $editData = $res->fetch_assoc();
}

$items = $koneksi->query("SELECT * FROM galeri_desa ORDER BY tanggal DESC, id DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <?= head('Kelola Galeri Desa') ?>
    <link rel="stylesheet" href="../style/dashboardAdmin.css">
    <link rel="stylesheet" href="../style/admin_crud.css">
</head>
<body>
<nav class="navbar-admin">
    <div class="logo-area">
        <img src="../assets/logo.svg" alt="Logo Desa">
        <div class="brand">
            <h3>Desa Panghuripan</h3>
            <p>Kabupaten Sleman</p>
        </div>
    </div>

    <div class="admin-info">
        <span>Hello, <?= htmlspecialchars($username) ?> !</span>
        <a href="../logic/logout.php" class="logout-btn">Logout</a>
    </div>
</nav>


<div class="admin-page-bg">
    <div class="container">
        <div class="mb-4 text-white">
            <h1 class="admin-section-title">Galeri Desa</h1>
            <p class="admin-section-subtitle">
                Upload atau edit foto-foto kegiatan dan panorama desa.
            </p>
        </div>

        <div class="row g-4">
            <div class="col-lg-4">
                <div class="admin-card">
                    <h3><?= $editMode ? "Edit Foto" : "Tambah Foto" ?></h3>
                    <p class="subtext">Gunakan path lokal (../assets/..) atau URL penuh.</p>

                    <form method="POST">
                        <input type="hidden" name="id" value="<?= $editMode ? $editData['id'] : '' ?>">

                        <div class="mb-2">
                            <label class="form-label">Judul</label>
                            <input type="text" name="judul" class="form-control"
                                   value="<?= $editMode ? htmlspecialchars($editData['judul']) : '' ?>">
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Tanggal</label>
                            <input type="date" name="tanggal" class="form-control"
                                   value="<?= $editMode ? $editData['tanggal'] : date('Y-m-d') ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Link Foto</label>
                            <input type="text" name="foto" class="form-control"
                                value="<?= $editMode ? htmlspecialchars($editData['foto']) : '' ?>">
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-green btn-pill">
                                <?= $editMode ? "Perbarui" : "Simpan" ?>
                            </button>
                            <?php if ($editMode): ?>
                                <a href="admin_galeri.php" class="btn btn-outline-green btn-pill">Batal</a>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="admin-card">
                    <h3>Album Foto</h3>
                    <p class="subtext">Foto terbaru tampil paling atas.</p>

                    <div class="row g-3">
                        <?php while ($row = $items->fetch_assoc()): ?>
                            <div class="col-md-6">
                                <div class="card border-0 shadow-sm" style="border-radius:24px; overflow:hidden;">
                                    <img src="<?= htmlspecialchars($row['foto']) ?>" class="card-img-top" alt="">
                                    <div class="card-body">
                                        <h5 class="card-title mb-1"><?= htmlspecialchars($row['judul']) ?></h5>
                                        <small class="text-muted mb-2 d-block">
                                            <?= $row['tanggal'] ? date('d M Y', strtotime($row['tanggal'])) : '' ?>
                                        </small>
                                        <div class="d-flex gap-1">
                                            <a href="?edit=<?= $row['id'] ?>" class="btn btn-outline-green btn-sm btn-pill">Edit</a>
                                            <a href="?hapus=<?= $row['id'] ?>"
                                               onclick="return confirm('Yakin hapus foto ini?')"
                                               class="btn btn-danger btn-sm btn-danger-pill">Hapus</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>

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
