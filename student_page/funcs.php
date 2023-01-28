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
                            WHERE marks.student_registration_number = :reg AND marks.semester = :sem');
    $query->bindParam(':reg', $student['registration_number']);
    $query->bindParam(':sem', $sem);
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

function get_grade($course)
{
    $marks = intval($course['end_semester_exam']) + intval($course['teacher_assessment']);
    if ($course['course_type'] == 'theory') {
        $marks += intval($course['mid_semester_exam']);
    }
    if ($marks >= 85) {
        return ['grade' => 'A+', 'points' => 10];
    } else if ($marks >= 75 && $marks <= 84) {
        return ['grade' => 'A', 'points' => 9];
    } else if ($marks >= 65 && $marks <= 74) {
        return ['grade' => 'B+', 'points' => 8];
    } else if ($marks >= 55 && $marks <= 64) {
        return ['grade' => 'B', 'points' => 7];
    } else if ($marks >= 45 && $marks <= 44) {
        return ['grade' => 'C', 'points' => 6];
    } else if ($marks >= 30 && $marks <= 44) {
        return ['grade' => 'D', 'points' => 4];
    } else if ($marks >= 15 && $marks <= 29) {
        return ['grade' => 'E', 'points' => 2];
    } else {
        return ['grade' => 'F', 'points' => 0];
    }
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
    $cpi = 0;
    $entry_stat = get_entry_status();

    if ($entry_stat[0] || $entry_stat[1]) {
        echo "<p>Result not available</p>";
        return;
    }

    for ($i = 1; $i <= intval($student['semester']); ++$i) {
        $transcript = get_transcript($student, $i);
        if ($transcript != null) {
            $total_marks = 0;
            $total_credits = 0;
            foreach ($transcript as $course) {
                $grade = get_grade($course);
                $total_marks += (intval($grade['points']) * intval($course['credits']));
                $total_credits += intval($course['credits']);
            }
            $spi = $total_marks / $total_credits;
            $cpi += $spi;
        }
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
        $total_marks = 0;
        $total_credits = 0;
        foreach ($transcript as $course) {
            $grade = get_grade($course);
            echo "<tr>
                <td>" . $course['course_code'] . "</td>
                <td>" . $course['course_name'] . "</td>
                <td>" . $course['credits'] . "</td>
                <td>" . $grade['grade'] . "</td>
                </tr>";
            $total_marks += (intval($grade['points']) * intval($course['credits']));
            $total_credits += intval($course['credits']);
        }
        $spi = $total_marks / $total_credits;
        echo "<tr>
                <td>" . "</td>
                <td>" . "</td>
                <td>SPI</td>
                <td>" . number_format((float)($spi), 2, '.', '') . "</td>
                </tr>";
        echo "</table>";
    } else {
        echo "<p>Result not available for current semester</p>";
    }
    echo "<h3>CPI : " . number_format((float)($cpi / intval($student['semester'])), 2, '.', '') . "</h3>";
}

function get_ui_transcript($student)
{
    $cpi = 0;
    $entry_stat = get_entry_status();

    $last_sem = intval($student['semester']);
    if ($entry_stat[0] || $entry_stat[1]) {
        $last_sem -= 1;
    }

    for ($i = 1; $i <= $last_sem; ++$i) {
        echo "<h3>Semester : " . $i . "</h3>";
        $transcript = get_transcript($student, $i);
        if ($transcript != null) {
            echo "<table>
            <tr>
                <th>Course Code</th>
                <th>Course Name</th>
                <th>Credits</th>
                <th>Grade</th>
            </tr>";
            $total_marks = 0;
            $total_credits = 0;
            foreach ($transcript as $course) {
                $grade = get_grade($course);
                echo "<tr>
                <td>" . $course['course_code'] . "</td>
                <td>" . $course['course_name'] . "</td>
                <td>" . $course['credits'] . "</td>
                <td>" . $grade['grade'] . "</td>
                </tr>";
                $total_marks += (intval($grade['points']) * intval($course['credits']));
                $total_credits += intval($course['credits']);
            }
            $spi = $total_marks / $total_credits;
            echo "<tr>
                <td>" . "</td>
                <td>" . "</td>
                <td>SPI</td>
                <td>" . number_format((float)($spi), 2, '.', '') . "</td>
                </tr>";
            echo "</table>";

            $cpi += $spi;
        } else {
            echo "<p>Transcript not available for semester : " . $i . "</p>";
        }
        echo "<hr class='dotted'>";
    }
    echo "<h3>CPI : " . number_format((float)($cpi / intval($student['semester'])), 2, '.', '') . "</h3>";
}

function get_prev_sem_pref($student)
{
    $cpi = 0;
    $entry_stat = get_entry_status();

    $last_sem = intval($student['semester']);
    if ($entry_stat[0] || $entry_stat[1]) {
        $last_sem -= 1;
    }

    for ($i = 1; $i <= $last_sem; ++$i) {
        echo "<h3>Semester : " . $i . "</h3>";
        $transcript = get_transcript($student, $i);
        if ($transcript != null) {
            $total_marks = 0;
            $total_credits = 0;
            foreach ($transcript as $course) {
                $grade = get_grade($course);
                $total_marks += (intval($grade['points']) * intval($course['credits']));
                $total_credits += intval($course['credits']);
            }
            $spi = $total_marks / $total_credits;
            $cpi += $spi;
            echo "<h4>SPI : " . number_format((float)($spi), 2, '.', '') .
                "&nbsp&nbsp&nbsp&nbspCPI : " . number_format((float)($cpi / $i), 2, '.', '') . "</h4>";
        } else {
            echo "<p>SPI not available for semester : " . $i . "</p>";
        }
        echo "<hr class='dotted'>";
    }
}
