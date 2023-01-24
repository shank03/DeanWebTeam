<?php
session_start();

function login_admin($password)
{
    $result = get_admin_detail();
    if ($result == null) {
        return "Admin doesn't exists";
    }
    if (password_verify($password, $result['password_hash'])) {
        $_SESSION['admin_login'] = true;
        return "";
    } else {
        return "Incorrect password";
    }
}

function logout_admin()
{
    unset($_POST);
    session_start();
    session_unset();
    session_destroy();
}

function get_admin_detail()
{
    $db = new PDO('mysql:host=localhost;dbname=dean', 'root', '');
    $query = $db->prepare('SELECT * FROM admin LIMIT 1');
    $query->execute();

    if ($query->rowCount() <= 0) {
        return null;
    }
    return $query->fetch(PDO::FETCH_ASSOC);
}

function get_entry_status()
{
    $db = new PDO('mysql:host=localhost;dbname=dean', 'root', '');
    $query = $db->prepare('SELECT * FROM admin');
    $query->execute();

    if ($query->rowCount() <= 0) {
        return [false, false];
    }
    $result = $query->fetch(PDO::FETCH_ASSOC);
    return [boolval($result['course_entry']), boolval($result['grade_entry'])];
}

function toggle_grade_entry($val)
{
    $db = new PDO('mysql:host=localhost;dbname=dean', 'root', '');
    $query = $db->prepare('UPDATE admin SET grade_entry = :v');
    $query->bindParam(':v', $val);
    $query->execute();
}

function toggle_course_entry($val)
{
    $db = new PDO('mysql:host=localhost;dbname=dean', 'root', '');
    $query = $db->prepare('UPDATE admin SET course_entry = :v');
    $query->bindParam(':v', $val);
    $query->execute();
}

function change_semester()
{
    // TODO: Change semester
}
