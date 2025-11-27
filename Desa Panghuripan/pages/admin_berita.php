<?php
require "../components/session_protected.php";
require "../components/components.php";
require "../config/koneksi.php";

$username = isset($_SESSION['username_admin']) ? $_SESSION['username_admin'] : 'Admin';

$editMode = false;
$editData = [];

// CREATE / UPDATE
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id      = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $tipe    = $_POST['tipe']; // berita / pengumuman
    $judul   = $_POST['judul'];
    $isi     = $_POST['isi'];
    $gambar  = $_POST['gambar'];
    $tanggal = $_POST['tanggal'];

    if ($id > 0) {
        $stmt = $koneksi->prepare("UPDATE berita_pengumuman SET tipe=?, judul=?, isi=?, gambar=?, tanggal=? WHERE id=?");
        $stmt->bind_param("sssssi", $tipe, $judul, $isi, $gambar, $tanggal, $id);
        $stmt->execute();
    } else {
        $stmt = $koneksi->prepare("INSERT INTO berita_pengumuman (tipe, judul, isi, gambar, tanggal) VALUES (?,?,?,?,?)");
        $stmt->bind_param("sssss", $tipe, $judul, $isi, $gambar, $tanggal);
        $stmt->execute();
    }

    header("Location: admin_berita.php");
    exit;
}

// DELETE
if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    $koneksi->query("DELETE FROM berita_pengumuman WHERE id=$id");
    header("Location: admin_berita.php");
    exit;
}

// EDIT
if (isset($_GET['edit'])) {
    $editMode = true;
    $id = (int)$_GET['edit'];
    $res = $koneksi->query("SELECT * FROM berita_pengumuman WHERE id=$id");
    $editData = $res->fetch_assoc();
}

$items = $koneksi->query("SELECT * FROM berita_pengumuman ORDER BY tanggal DESC, id DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <?= head('Kelola Berita & Pengumuman') ?>
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
            <h1 class="admin-section-title">Berita dan Pengumuman</h1>
            <p class="admin-section-subtitle">
                Atur konten informasi terbaru untuk warga desa.
            </p>
        </div>

        <div class="row g-4">
            <!-- FORM -->
            <div class="col-lg-4">
                <div class="admin-card">
                    <h3><?= $editMode ? "Edit Konten" : "Tambah Konten Baru" ?></h3>
                    <p class="subtext">Isi judul, isi berita/pengumuman, dan link gambar.</p>

                    <form method="POST">
                        <input type="hidden" name="id" value="<?= $editMode ? $editData['id'] : '' ?>">

                        <div class="mb-2">
                            <label class="form-label">Tipe</label>
                            <div class="d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="tipe" value="berita"
                                           <?= !$editMode || $editData['tipe']=='berita' ? 'checked' : '' ?>>
                                    <label class="form-check-label">Berita</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="tipe" value="pengumuman"
                                           <?= $editMode && $editData['tipe']=='pengumuman' ? 'checked' : '' ?>>
                                    <label class="form-check-label">Pengumuman</label>
                                </div>
                            </div>
                        </div>

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

                        <div class="mb-2">
                            <label class="form-label">Link Gambar (URL atau path)</label>
                            <input type="text" name="gambar" class="form-control"
                                   value="<?= $editMode ? htmlspecialchars($editData['gambar']) : '' ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Isi</label>
                            <textarea name="isi" rows="5" class="form-control"><?= $editMode ? htmlspecialchars($editData['isi']) : '' ?></textarea>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-green btn-pill">
                                <?= $editMode ? "Perbarui" : "Simpan" ?>
                            </button>
                            <?php if ($editMode): ?>
                                <a href="admin_berita.php" class="btn btn-outline-green btn-pill">Batal</a>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>

            <!-- DAFTAR KONTEN -->
            <div class="col-lg-8">
                <div class="admin-card">
                    <h3>Daftar Berita & Pengumuman</h3>
                    <p class="subtext">Konten terbaru berada di urutan paling atas.</p>

                    <div class="table-responsive table-rounded mt-2">
                        <table class="table mb-0 align-middle">
                            <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Judul</th>
                                <th>Tipe</th>
                                <th>Gambar</th>
                                <th>Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php while ($row = $items->fetch_assoc()): ?>
                                <tr>
                                    <td><?= date('d/m/Y', strtotime($row['tanggal'])) ?></td>
                                    <td>
                                        <div class="fw-semibold"><?= htmlspecialchars($row['judul']) ?></div>
                                        <small class="text-muted">
                                            <?= substr(strip_tags($row['isi']), 0, 70) ?>...
                                        </small>
                                    </td>
                                    <td>
                                        <?php if ($row['tipe'] == 'berita'): ?>
                                            <span class="badge-soft badge-berita">Berita</span>
                                        <?php else: ?>
                                            <span class="badge-soft badge-pengumuman">Pengumuman</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($row['gambar']): ?>
                                            <img src="<?= htmlspecialchars($row['gambar']) ?>" class="thumb-sm" alt="">
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <a href="?edit=<?= $row['id'] ?>" class="btn btn-outline-green btn-sm btn-pill">Edit</a>
                                            <a href="?hapus=<?= $row['id'] ?>"
                                               onclick="return confirm('Yakin hapus konten ini?')"
                                               class="btn btn-danger btn-danger-pill">Hapus</a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                            </tbody>
                        </table>
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
