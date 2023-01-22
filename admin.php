<?php
include 'admin_page/funcs.php';

if (isset($_POST['admin_submit'])) {
    // $regno = $_POST['registrationNumber'];
    // $password = $_POST['password'];

    // if (strlen($regno) != 8) {
    //     echo "<script>alert(\"Registration number should be 8 digits\"); window.location.href='student'</script>";
    //     return;
    // }
    // if (strlen($password) < 6) {
    //     echo "<script>alert(\"Password length should be more than 6\"); window.location.href='student'</script>";
    //     return;
    // }

    // $session_val = login_student($regno, $password);
    // if ($session_val == "") {
    //     header('Location: student');
    //     exit;
    // } else {
    //     echo "<script>alert(\"{$session_val}\"); window.location.href='student'</script>";
    // }
}

if (isset($_POST['admin_logout'])) {
    logout_student();
    header('Location: student');
    exit;
}

if (isset($_SESSION['admin_login']) && $_SESSION['admin_login'] == true) {
    require 'admin_page/dashboard.php';
} else {
    require 'admin_page/login_form.php';
}
