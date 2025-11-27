<?php
    session_start();

    if (!isset($_SESSION['id_adm'])) {
        header("location:../pages/loginAdmin.php?status=login_dulu");
        exit;
    }
