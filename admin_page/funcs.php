<?php
session_start();

function login_admin($regno, $password)
{
    $result = get_student_detail($regno);
    if ($result == null) {
        return "Student doesn't exists";
    }
    if (password_verify($password, $result['password_hash'])) {
        $_SESSION['std_login'] = true;
        $_SESSION['std_regno'] = $regno;
        return "";
    } else {
        return "Incorrect password";
    }
}

function logout_student()
{
    unset($_POST);
    session_start();
    session_unset();
    session_destroy();
}

function get_student_detail($regno)
{
    $db = new PDO('mysql:host=localhost;dbname=dean', 'root', '');
    $query = $db->prepare('SELECT * FROM student WHERE registration_number = :reg');
    $query->bindParam(':reg', $regno);
    $query->execute();

    if ($query->rowCount() <= 0) {
        return null;
    }
    return $query->fetch(PDO::FETCH_ASSOC);
}

function hash_password($password)
{
    $r_salt = file_get_contents('salt.txt');
    $option = ['cost' => intval($r_salt)];
    return password_hash($password, PASSWORD_BCRYPT, $option);
}
