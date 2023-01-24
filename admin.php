<?php
include 'admin_page/funcs.php';

if (isset($_POST['admin_submit'])) {
    $password = $_POST['password'];

    if (strlen($password) < 6) {
        echo "<script>alert(\"Password length should be more than 6\"); window.location.href='admin'</script>";
        return;
    }

    $session_val = login_admin($password);
    if ($session_val == "") {
        header('Location: admin');
        exit;
    } else {
        echo "<script>alert(\"{$session_val}\"); window.location.href='admin'</script>";
    }
}

if (isset($_POST['admin_logout'])) {
    logout_admin();
    header('Location: admin');
    exit;
}

if (isset($_SESSION['admin_login']) && $_SESSION['admin_login'] == true) {
    require 'admin_page/dashboard.php';
} else {
    require 'admin_page/login_form.php';
}
