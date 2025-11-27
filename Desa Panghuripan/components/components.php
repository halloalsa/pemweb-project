<?php
function head($title){ ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <!-- CSS Boostrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <!-- CSS Custom -->
    <link rel="stylesheet" href="../style/components.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Marcellus+SC&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
<?php } ?>

<?php
function listAlert($status)
{
  $status = trim((string)$status);
  $msg = '';

  switch ($status) {
    case 'gagal_login':
      $msg = 'Error : Gagal login ! Silahkan coba lagi.';
      break;
    case 'password_tidak_sama':
      $msg = 'Error : Password tidak sama dengan data di database.';
      break;
    case 'gagal_input':
      $msg = 'Error : Data belum lengkap. Pastikan semua field wajib terisi.';
      break;
    case 'berhasil_simpan':
      $msg = 'Success : Data berhasil disimpan.';
      break;
    case 'berhasil_logout':
      $msg = 'Success : Berhasil logout.';
      break;
    case 'login_dulu':
      $msg = 'Error : Login terlebih dahulu';
      break;
    default:
      return '';
  }

  $js_msg = json_encode($msg);
  return '<script>window.addEventListener("DOMContentLoaded", function(){ alert(' . $js_msg . '); });</script>';
}
?>

<?php
function footer(){ ?>
    <div class="footer">
        <div class="isiFooter">

        </div>
        <div class="copyright"></div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
<?php
}
?>


<?php
function navbar(){ ?>
    <nav>
        <a href="../pages/landingPage.php" class="logo">
            <img src="../assets/navbar/logo.svg" alt="Ikon Desa">
            <div>
                <h3>Desa Panghuripan</h3>
                <p>Kabupaten Sleman</p>
            </div>
        </a>
        <div class="menuNav">
            <div>
                <div class="menu">
                    <a href="../pages/landingPage.php">Beranda</a>
                    <a href="../pages/dataStatistik.php">Data dan Statistik</a>
                    <a href="../pages/beritaPengumuman.php">Berita</a>               
                </div>
                <div class="pilihMenu"></div>
            </div>
            <div class="layananWarga" >
                <ahref="../pages/layananWarga.php">Layanan Warga</ahref=> 
            </div>
            
        </div>
    </nav>
<?php } ?>

