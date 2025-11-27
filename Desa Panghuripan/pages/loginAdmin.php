<?php
    session_start(); 
    require "../components/components.php";
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <?= head('Login Admin') ?>
    <link rel="stylesheet" href="../style/admin.css">
</head>

<body>

    <div class="login-bg d-flex align-items-center min-vh-100">
        <div class="container position-relative">

        <?php if(isset($_GET['status'])){ ?>
            <?= listAlert($_GET['status']) ?>
        <?php } ?>

            <!-- Tombol kembali -->
            <button class="btn back-btn" type="button" onclick="history.back()">Kembali</button>

            <h1 class="brand-title text-center">Desa Panghuripan</h1>

            <!-- Card utama -->
            <div class="card login-card shadow-lg mx-auto border-0">
                <div class="row g-0">

                    <!-- Bagian kiri -->
                    <div class="col-md-6 login-left">
                        <h1 class="title-hi">Hi,<br> welcome !</h1>
                    </div>

                    <!-- Bagian kanan -->
                    <div class="col-md-6 login-right">
                        <h2>Login</h2>
                        <p>Silahkan isi form berikut terlebih dahulu</p>

                        <form action="../logic/auth.php" method="POST">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control input-box" id="username" name="username">
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control input-box" id="password" name="password">
                            </div>

                            <button type="submit" name="login" class="btn btn-login">Log In</button>
                        </form>

                        <div class="text-muted small mt-3 text-center">
                            © 2025 Desa Panghuripan. All Right Reserved
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-pFjFNkXgGhfmLmikUhRHqW3U8tHqvjdDYgQ4C2uBLl3UxIPa6onh3VgCGO8t8ZB8"
            crossorigin="anonymous"> </script>
</body>

</html>
