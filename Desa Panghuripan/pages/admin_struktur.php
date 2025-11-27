<?php
require "../components/session_protected.php";
require "../components/components.php";
require "../config/koneksi.php";

$username = isset($_SESSION['username_admin']) ? $_SESSION['username_admin'] : 'Admin';

$editMode = false;
$editData = [];

// Ambil penduduk untuk dropdown (sebagian saja biar tidak berat; mis. 200 pertama)
$pendudukOptions = $koneksi->query("SELECT id, nama FROM penduduk ORDER BY nama LIMIT 300");

// SIMPAN / UPDATE
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id          = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $jabatan     = $_POST['jabatan'];
    $foto        = $_POST['foto'];
    $penduduk_id = $_POST['penduduk_id'] !== '' ? (int)$_POST['penduduk_id'] : null;
    $urutan      = (int)$_POST['urutan'];

    if ($id > 0) {
        $stmt = $koneksi->prepare("UPDATE struktur_perangkat_desa SET foto=?, jabatan=?, penduduk_id=?, urutan=? WHERE id=?");
        $stmt->bind_param("ssiii", $foto, $jabatan, $penduduk_id, $urutan, $id);
        $stmt->execute();
    } else {
        $stmt = $koneksi->prepare("INSERT INTO struktur_perangkat_desa (foto, jabatan, penduduk_id, urutan) VALUES (?,?,?,?)");
        $stmt->bind_param("ssii", $foto, $jabatan, $penduduk_id, $urutan);
        $stmt->execute();
    }

    header("Location: admin_struktur.php");
    exit;
}

if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    $koneksi->query("DELETE FROM struktur_perangkat_desa WHERE id=$id");
    header("Location: admin_struktur.php");
    exit;
}

if (isset($_GET['edit'])) {
    $editMode = true;
    $id = (int)$_GET['edit'];
    $res = $koneksi->query("SELECT * FROM struktur_perangkat_desa WHERE id=$id");
    $editData = $res->fetch_assoc();
}

// daftar struktur (join ke penduduk)
$list = $koneksi->query("SELECT s.*, p.nama AS nama_penduduk
                         FROM struktur_perangkat_desa s
                         LEFT JOIN penduduk p ON p.id = s.penduduk_id
                         ORDER BY s.urutan ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <?= head('Kelola Struktur Desa') ?>
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
            <h1 class="admin-section-title">Struktur Desa</h1>
            <p class="admin-section-subtitle">
                Atur susunan perangkat desa dan hubungkan dengan data penduduk.
            </p>
        </div>

        <div class="row g-4">
            <div class="col-lg-4">
                <div class="admin-card">
                    <h3><?= $editMode ? "Edit Jabatan" : "Tambah Jabatan" ?></h3>
                    <p class="subtext">Set posisi, urutan tampilan, dan foto.</p>

                    <form method="POST">
                        <input type="hidden" name="id" value="<?= $editMode ? $editData['id'] : '' ?>">

                        <div class="mb-2">
                            <label class="form-label">Jabatan</label>
                            <input type="text" name="jabatan" class="form-control"
                                value="<?= $editMode ? htmlspecialchars($editData['jabatan']) : '' ?>">
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Penduduk (opsional)</label>
                            <select name="penduduk_id" class="form-select">
                                <option value="">Belum dihubungkan</option>
                                <?php
                                mysqli_data_seek($pendudukOptions, 0);
                                while ($p = $pendudukOptions->fetch_assoc()):
                                    $selected = $editMode && $editData['penduduk_id']==$p['id'] ? 'selected' : '';
                                ?>
                                    <option value="<?= $p['id'] ?>" <?= $selected ?>>
                                        <?= htmlspecialchars($p['nama']) ?> (ID: <?= $p['id'] ?>)
                                    </option>
                                <?php endwhile; ?>
                            </select>
                            <small class="text-muted">Pastikan ID penduduk sudah benar.</small>
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Urutan Tampilan</label>
                            <input type="number" name="urutan" class="form-control"
                                value="<?= $editMode ? $editData['urutan'] : '' ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Link Foto</label>
                            <input type="text" name="foto" class="form-control"
                                   value="<?= $editMode ? htmlspecialchars($editData['foto']) : '' ?>">
                            <small class="text-muted">Boleh kosong, nanti tampil placeholder.</small>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-green btn-pill">
                                <?= $editMode ? "Perbarui" : "Simpan" ?>
                            </button>
                            <?php if ($editMode): ?>
                                <a href="admin_struktur.php" class="btn btn-outline-green btn-pill">Batal</a>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="admin-card">
                    <h3>Daftar Perangkat Desa</h3>
                    <p class="subtext">Urutan menentukan posisi pada tampilan struktur di halaman publik.</p>

                    <div class="table-responsive table-rounded mt-2">
                        <table class="table mb-0 align-middle">
                            <thead>
                            <tr>
                                <th>Urutan</th>
                                <th>Foto</th>
                                <th>Jabatan</th>
                                <th>Nama Penduduk</th>
                                <th>Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php while ($row = $list->fetch_assoc()): ?>
                                <tr>
                                    <td><?= $row['urutan'] ?></td>
                                    <td>
                                        <?php if ($row['foto']): ?>
                                            <img src="<?= htmlspecialchars($row['foto']) ?>" class="thumb-sm" alt="">
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= htmlspecialchars($row['jabatan']) ?></td>
                                    <td><?= $row['nama_penduduk'] ? htmlspecialchars($row['nama_penduduk']) : '<span class="text-muted">Belum dihubungkan</span>' ?></td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <a href="?edit=<?= $row['id'] ?>" class="btn btn-outline-green btn-sm btn-pill">Edit</a>
                                            <a href="?hapus=<?= $row['id'] ?>"
                                               onclick="return confirm('Yakin hapus jabatan ini?')"
                                               class="btn btn-danger btn-sm btn-danger-pill">Hapus</a>
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
