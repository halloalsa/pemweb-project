<?php
session_start();
session_unset();
session_destroy();

header("location:../pages/dashboardAdmin.php?status=berhasil_logout");
exit;