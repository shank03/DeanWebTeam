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

function get_semester()
{
    $db = new PDO('mysql:host=localhost;dbname=dean', 'root', '');
    $query = $db->prepare('SELECT * FROM admin');
    $query->execute();
    return $query->fetch(PDO::FETCH_ASSOC)['semester'];
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

function get_prev_student_marks($student)
{
    $db = new PDO('mysql:host=localhost;dbname=dean', 'root', '');
    $query = $db->prepare('SELECT * FROM semester_marks WHERE student_registration_number = :reg');
    $query->bindParam(':reg', $student['registration_number']);
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

function get_student_details($student, $semester)
{
    $db = new PDO('mysql:host=localhost;dbname=dean', 'root', '');
    $query = $db->prepare('SELECT * FROM marks INNER JOIN course ON marks.course_code = course.course_code AND marks.semester = course.semester
                            WHERE marks.student_registration_number = :reg 
                            AND marks.semester = :sem
                            AND course.branch = :br
                            AND course.stream = :str');
    $query->bindParam(':reg', $student['registration_number']);
    $query->bindParam(':br', $student['branch']);
    $query->bindParam(':str', $student['stream']);
    $query->bindParam(':sem', $semester);
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

function insert_student_marks($reg, $semester, $yr, $spi, $cpi)
{
    $db = new PDO('mysql:host=localhost;dbname=dean', 'root', '');
    $query = $db->prepare('INSERT INTO semester_marks (student_registration_number, semester, d_year, spi, cpi)
                            VALUES (:reg, :sem, :yr, :spi, :cpi)');
    $query->bindParam(':reg', $reg);
    $query->bindParam(':sem', $semester);
    $query->bindParam(':yr', $yr);
    $query->bindParam(':spi', $spi);
    $query->bindParam(':cpi', $cpi);
    $query->execute();
}

function toggle_grade_entry(bool $val)
{
    $db = new PDO('mysql:host=localhost;dbname=dean', 'root', '');
    $query = $db->prepare('UPDATE admin SET grade_entry = :v');
    $query->bindParam(':v', $val);
    $query->execute();

    if ($val) {
        return;
    }

    $semester = get_semester();
    $query = $db->prepare('SELECT * FROM student WHERE semester = :sem');
    $query->bindParam(':sem', $semester);
    $query->execute();
    $students = $query->fetchAll(PDO::FETCH_ASSOC);

    foreach ($students as $std) {
        $marks = get_prev_student_marks($std);
        $cpi = 0;
        foreach ($marks as $mark) {
            $cpi += $mark['spi'];
        }
        $transcript = get_student_details($std, $semester);
        $spi = 0;
        $yr = '';
        if ($transcript != null) {
            $total_marks = 0;
            $total_credits = 0;
            foreach ($transcript as $course) {
                $total_marks += (intval($course['points']) * intval($course['credits']));
                $total_credits += intval($course['credits']);
                $yr = $course['d_year'];
            }
            $spi = $total_marks / $total_credits;
            $cpi += $spi;
        }
        $cpi /= intval($semester);
        insert_student_marks($std['registration_number'], $semester, $yr, $spi, $cpi);
    }
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
