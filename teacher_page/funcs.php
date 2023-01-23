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
    $query = $db->prepare('SELECT *
                            FROM course,
                            (SELECT professor_allotment.course_code, professor_allotment.semester 
                            FROM professor_allotment
                            WHERE professor_allotment.employee_id = :emp
                            AND professor_allotment.d_year = (SELECT MAX(professor_allotment.d_year) FROM professor_allotment WHERE professor_allotment.employee_id = :emp)) AS pa
                            WHERE course.course_code = pa.course_code and course.semester = pa.semester');

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
        echo "<script>alert(\"ERROR: Teacher is NULL\"); window.location.href='teacher'</script>";
        return;
    }
    $courses = get_courses_t($teacher['employee_id']);
    if ($courses != null) {
        echo "<p><strong>You are currently teaching in:</strong></p>";
        foreach ($courses as $course) {
            echo "<p>" . $course['stream'] . ", " . $course['branch'] . ", Semester : " . $course['semester'] . "</p>";
        }
        echo "<br><table>
            <tr>
                <th>Course Code</th>
                <th>Course Name</th>
                <th>Credits</th>
                <th>Semester</th>
            </tr>";
        foreach ($courses as $course) {
            echo "<tr>
                <td>" . $course['course_code'] . "</td>
                <td>" . $course['name'] . "</td>
                <td>" . $course['credits'] . "</td>
                <td>" . $course['semester'] . "</td>
                </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Error retrieving courses</p>";
    }
}

function set_course_sem($course_code, $sem, $teacher)
{
    if ($teacher == null) {
        logout_teacher();
        echo "<script>alert(\"ERROR: Teacher is NULL\"); window.location.href='student'</script>";
        return;
    }

    $db = new PDO('mysql:host=localhost;dbname=dean', 'root', '');
    $q_course = $db->prepare('SELECT * FROM course WHERE course_code = :cc AND semester = :sem');
    $q_course->bindParam(':cc', $course_code);
    $q_course->bindParam(':sem', $sem);
    $q_course->execute();

    if ($q_course->rowCount() <= 0) {
        return "Course {$course_code} doesn't exists in {$sem} semester";
    }
    $course = $q_course->fetch(PDO::FETCH_ASSOC);

    $q_allot = $db->prepare('INSERT INTO professor_allotment (employee_id, course_code, semester, d_year, branch)
                            VALUES (:emp, :cc, :sem, :dy, :br)');
    $q_allot->bindParam(':cc', $course_code);
    $q_allot->bindParam(':sem', $sem);
    $q_allot->bindParam(':emp', $teacher['employee_id']);
    $q_allot->bindParam(':dy', date('Y'));
    $q_allot->bindParam(':br', $course['branch']);
    if ($q_allot->execute()) {
        return "";
    } else {
        return "Error setting course: " . $q_allot->errorInfo()[2];
    }
}

function hash_password($password)
{
    $r_salt = file_get_contents('salt.txt');
    $option = ['cost' => intval($r_salt)];
    return password_hash($password, PASSWORD_BCRYPT, $option);
}
