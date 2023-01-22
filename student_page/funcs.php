<?php
session_start();

function login_student($regno, $password)
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

function get_courses($sem, $branch, $stream)
{
    $db = new PDO('mysql:host=localhost;dbname=dean', 'root', '');
    $query = $db->prepare('SELECT * FROM course WHERE semester = :sem AND branch = :branch AND stream = :stream');
    $query->bindParam(':sem', $sem);
    $query->bindParam(':branch', $branch);
    $query->bindParam(':stream', $stream);
    $query->execute();

    if ($query->rowCount() <= 0) {
        return null;
    }
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

function display_courses($student)
{
    if ($student == null) {
        logout_student();
        echo "<script>alert(\"ERROR: Student is NULL\"); window.location.href='student'</script>";
        return;
    }
    $courses = get_courses($student['semester'], $student['branch'], $student['stream']);
    if ($courses != null) {
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
