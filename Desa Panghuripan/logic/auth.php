<?php
session_start();
require "../config/koneksi.php";

// Untuk Login
if(isset($_POST['login'])){
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    if($username === '' || $password === ''){
        header("location:../pages/loginAdmin.php?status=login_dulu");
        exit;
    }

    $username_esc = mysqli_real_escape_string($koneksi, $username);
    $query = "SELECT * FROM admin WHERE username = '$username_esc'";
    $result = mysqli_query($koneksi, $query);

    if(mysqli_num_rows($result) > 0){
        $data = mysqli_fetch_assoc($result);

        if($data['password'] === $password){
            $_SESSION['id_adm'] = $data['id_adm'];
            $_SESSION['username'] = $data['username'];

            header("location:../pages/dashboardAdmin.php");
            exit;
        } else {
            // Username ada tapi password salah
            header("location:../pages/loginAdmin.php?status=password_tidak_sama");
            exit;
        }
    } else {
        // Username tidak ditemukan
        header("location:../pages/loginAdmin.php?status=gagal_login");
        exit;
    }
}
