<?php
include 'teacher_page/funcs.php';

if (isset($_POST['emp_submit'])) {
    $empno = $_POST['employeeNumber'];
    $password = $_POST['password'];

    if (strlen($empno) != 4) {
        echo "<script>alert(\"Employee number should be 4 digits\"); window.location.href='teacher'</script>";
        return;
    }
    if (strlen($password) < 6) {
        echo "<script>alert(\"Password length should be more than 6\"); window.location.href='teacher'</script>";
        return;
    }

    $session_val = login_teacher($empno, $password);
    if ($session_val == "") {
        header('Location: teacher');
        exit;
    } else {
        echo "<script>alert(\"{$session_val}\"); window.location.href='teacher'</script>";
    }
}

if (isset($_POST['emp_logout'])) {
    logout_teacher();
    header('Location: teacher');
    exit;
}

if (isset($_SESSION['emp_login']) && $_SESSION['emp_login'] == true) {
    require 'teacher_page/dashboard.php';
} else {
    require 'teacher_page/login_form.php';
}
