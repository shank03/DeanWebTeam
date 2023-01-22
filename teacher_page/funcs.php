<?php
session_start();

function login_teacher($empno, $password)
{
    $result = get_teacher_detail($empno);
    if ($result == null) {
        return "Teacher doesn't exists";
    }
    if (password_verify($password, $result['password_hash'])) {
        $_SESSION['emp_login'] = true;
        $_SESSION['emp_no'] = $empno;
        return "";
    } else {
        return "Incorrect password";
    }
}

function logout_teacher()
{
    unset($_POST);
    session_start();
    session_unset();
    session_destroy();
}

function get_teacher_detail($empno)
{
    $db = new PDO('mysql:host=localhost;dbname=dean', 'root', '');
    $query = $db->prepare('SELECT * FROM professor WHERE employee_id = :emp');
    $query->bindParam(':emp', $empno);
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

function get_courses_t($empno)
{
    $db = new PDO('mysql:host=localhost;dbname=dean', 'root', '');
    $query = $db->prepare('SELECT * FROM course, 
        (SELECT professor_allotment.course_code, professor_allotment.semester FROM professor_allotment
        WHERE professor_allotment.employee_id = :emp 
        ORDER BY professor_allotment.d_year DESC, professor_allotment.semester DESC LIMIT 1) AS pa 
        WHERE course.course_code = pa.course_code AND course.semester = pa.semester');

    $query->bindParam(':emp', $empno);
    $query->execute();

    if ($query->rowCount() <= 0) {
        return null;
    }
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

function display_courses_t($teacher)
{
    if ($teacher == null) {
        logout_teacher();
        echo "<script>alert(\"ERROR: Teacher is NULL\"); window.location.href='student'</script>";
        return;
    }
    $courses = get_courses_t($teacher['employee_id']);
    if ($courses != null) {
        echo "<p>You are currently teaching " . $courses[0]['stream'] . ", " . $courses[0]['branch'] . ", semester : " . $courses[0]['semester'] . "</p>";
        echo "<table>
            <tr>
                <th>Course Code</th>
                <th>Course Name</th>
                <th>Credits</th>
            </tr>";
        foreach ($courses as $course) {
            echo "<tr>
                <td>" . $course['course_code'] . "</td>
                <td>" . $course['name'] . "</td>
                <td>" . $course['credits'] . "</td>
                </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Error retrieving courses</p>";
    }
}

function hash_password($password)
{
    $r_salt = file_get_contents('salt.txt');
    $option = ['cost' => intval($r_salt)];
    return password_hash($password, PASSWORD_BCRYPT, $option);
}
