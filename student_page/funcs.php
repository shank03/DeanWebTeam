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
                <td>" . $course['course_name'] . "</td>
                <td>" . $course['credits'] . "</td>
                </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Error retrieving courses</p>";
    }
}

function get_transcript($student, $sem)
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
    $query->bindParam(':sem', $sem);
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

function get_spi_cpi_sem($student, $sem)
{
    $db = new PDO('mysql:host=localhost;dbname=dean', 'root', '');
    $query = $db->prepare('SELECT * FROM semester_marks WHERE student_registration_number = :reg AND semester = :sem');
    $query->bindParam(':reg', $student['registration_number']);
    $query->bindParam(':sem', $sem);
    $query->execute();

    if ($query->rowCount() <= 0) {
        return null;
    }
    return $query->fetch(PDO::FETCH_ASSOC);
}

function get_spi_cpi($student)
{
    $db = new PDO('mysql:host=localhost;dbname=dean', 'root', '');
    $query = $db->prepare('SELECT * FROM semester_marks WHERE student_registration_number = :reg');
    $query->bindParam(':reg', $student['registration_number']);
    $query->execute();

    if ($query->rowCount() <= 0) {
        return null;
    }
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

function get_grade($course)
{
    $points = [
        10 => 'A+',
        9 => 'A',
        8 => 'B+',
        7 => 'B',
        6 => 'C',
        4 => 'D',
        2 => 'E',
        0 => 'F'
    ];
    return $points[$course['points']];
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

function get_result($student)
{
    $result = get_spi_cpi_sem($student, $student['semester']);
    if ($result == null) {
        echo "<p>Result not available</p>";
        return;
    }

    $transcript = get_transcript($student, $student['semester']);
    if ($transcript != null) {
        echo "<table>
            <tr>
                <th>Course Code</th>
                <th>Course Name</th>
                <th>Credits</th>
                <th>Grade</th>
            </tr>";
        foreach ($transcript as $course) {
            $grade = get_grade($course);
            echo "<tr>
                <td>" . $course['course_code'] . "</td>
                <td>" . $course['course_name'] . "</td>
                <td>" . $course['credits'] . "</td>
                <td>" . $grade . "</td>
                </tr>";
        }
        echo "<tr>
                <td>" . "</td>
                <td>" . "</td>
                <td>SPI</td>
                <td>" . number_format((float)($result['spi']), 2, '.', '') . "</td>
                </tr>";
        echo "</table>";
    } else {
        echo "<p>Result not available for current semester</p>";
    }
    echo "<h3>CPI : " . number_format((float)($result['cpi']), 2, '.', '') . "</h3>";
}

function get_ui_transcript($student)
{
    $cpi = 0;
    $last_sem = intval($student['semester']);

    for ($i = 1; $i <= $last_sem; ++$i) {
        echo "<h3>Semester : " . $i . "</h3>";

        $transcript = get_transcript($student, $i);
        $result = get_spi_cpi_sem($student, $i);
        if ($transcript != null && $result != null) {
            echo "<table>
            <tr>
                <th>Course Code</th>
                <th>Course Name</th>
                <th>Credits</th>
                <th>Grade</th>
            </tr>";
            foreach ($transcript as $course) {
                $grade = get_grade($course);
                echo "<tr>
                <td>" . $course['course_code'] . "</td>
                <td>" . $course['course_name'] . "</td>
                <td>" . $course['credits'] . "</td>
                <td>" . $grade . "</td>
                </tr>";
            }
            echo "<tr>
                <td>" . "</td>
                <td>" . "</td>
                <td>SPI</td>
                <td>" . number_format((float)($result['spi']), 2, '.', '') . "</td>
                </tr>";
            echo "</table>";
            $cpi = $result['cpi'];
        } else {
            echo "<p>Transcript not available for semester : " . $i . "</p>";
        }
        echo "<hr class='dotted'>";
    }
    echo "<h3>CPI : " . number_format((float)($cpi), 2, '.', '') . "</h3>";
}

function get_prev_sem_pref($student)
{
    $last_sem = intval($student['semester']);
    for ($i = 1; $i <= $last_sem; ++$i) {
        echo "<h3>Semester : " . $i . "</h3>";
        $transcript = get_transcript($student, $i);
        $result = get_spi_cpi_sem($student, $i);
        if ($transcript != null && $result != null) {
            echo "<h4>SPI : " . number_format((float)($result['spi']), 2, '.', '') .
                "&nbsp&nbsp&nbsp&nbspCPI : " . number_format((float)($result['cpi']), 2, '.', '') . "</h4>";
        } else {
            echo "<p>SPI not available for semester : " . $i . "</p>";
        }
        echo "<hr class='dotted'>";
    }
}
