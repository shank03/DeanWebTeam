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
                            (SELECT * 
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
                <th>Type</th>
            </tr>";
        foreach ($courses as $course) {
            echo "<tr>
                <td>" . $course['course_code'] . "</td>
                <td>" . $course['course_name'] . "</td>
                <td>" . $course['credits'] . "</td>
                <td>" . $course['semester'] . "</td>
                <td>" . ucfirst($course['course_type']) . "</td>
                </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>You not teaching currently</p>";
    }
}

function check_course_sem($course_code, $sem)
{
    $db = new PDO('mysql:host=localhost;dbname=dean', 'root', '');
    $q_course = $db->prepare('SELECT * FROM course WHERE course_code = :cc AND semester = :sem');
    $q_course->bindParam(':cc', $course_code);
    $q_course->bindParam(':sem', $sem);
    $q_course->execute();

    if ($q_course->rowCount() <= 0) {
        return null;
    }
    return $q_course->fetch(PDO::FETCH_ASSOC);
}

function set_th_sem_course_entry(
    $course_data,
    $mid_sem,
    $end_sem,
    $ta_sem,
    $teacher
) {
    if ($teacher == null) {
        logout_teacher();
        echo "<script>alert(\"ERROR: Teacher is NULL\"); window.location.href='teacher'</script>";
        return "";
    }

    $curr_year = date('Y');
    $db = new PDO('mysql:host=localhost;dbname=dean', 'root', '');
    $q_dist = $db->prepare('INSERT INTO marks_dist_theory (course_code, mid_semester_exam, end_semester_exam, teacher_assessment, semester, dist_year)
                            VALUES (:cc, :mse, :ese, :ta, :sem, :yr)');
    $q_dist->bindParam(':cc', $course_data['course_code']);
    $q_dist->bindParam(':mse', $mid_sem);
    $q_dist->bindParam(':ese', $end_sem);
    $q_dist->bindParam(':ta', $ta_sem);
    $q_dist->bindParam(':sem', $course_data['semester']);
    $q_dist->bindParam(':yr', $curr_year);
    $result = $q_dist->execute();

    $q_allot = $db->prepare('INSERT INTO professor_allotment (employee_id, course_code, semester, d_year, branch)
                            VALUES (:emp, :cc, :sem, :dy, :br)');
    $q_allot->bindParam(':cc', $course_data['course_code']);
    $q_allot->bindParam(':sem', $course_data['semester']);
    $q_allot->bindParam(':emp', $teacher['employee_id']);
    $q_allot->bindParam(':dy', $curr_year);
    $q_allot->bindParam(':br', $course_data['branch']);
    if ($q_allot->execute() && $result) {
        return "";
    } else {
        return "Error setting course: " . $q_allot->errorInfo()[2];
    }
}

function set_pr_sem_course_entry(
    $course_data,
    $end_sem,
    $ta_sem,
    $teacher
) {
    if ($teacher == null) {
        logout_teacher();
        echo "<script>alert(\"ERROR: Teacher is NULL\"); window.location.href='teacher'</script>";
        return "";
    }

    $curr_year = date('Y');
    $db = new PDO('mysql:host=localhost;dbname=dean', 'root', '');
    $q_dist = $db->prepare('INSERT INTO marks_dist_practical (course_code, end_semester_exam, teacher_assessment, semester, dist_year)
                            VALUES (:cc, :ese, :ta, :sem, :yr)');
    $q_dist->bindParam(':cc', $course_data['course_code']);
    $q_dist->bindParam(':ese', $end_sem);
    $q_dist->bindParam(':ta', $ta_sem);
    $q_dist->bindParam(':sem', $course_data['semester']);
    $q_dist->bindParam(':yr', $curr_year);
    $result = $q_dist->execute();

    $q_allot = $db->prepare('INSERT INTO professor_allotment (employee_id, course_code, semester, d_year, branch)
                            VALUES (:emp, :cc, :sem, :dy, :br)');
    $q_allot->bindParam(':cc', $course_data['course_code']);
    $q_allot->bindParam(':sem', $course_data['semester']);
    $q_allot->bindParam(':emp', $teacher['employee_id']);
    $q_allot->bindParam(':dy', $curr_year);
    $q_allot->bindParam(':br', $course_data['branch']);
    if ($q_allot->execute() && $result) {
        return "";
    } else {
        return "Error setting course: " . $q_allot->errorInfo()[2];
    }
}

function get_students_with_course($course_list)
{
    $db = new PDO('mysql:host=localhost;dbname=dean', 'root', '');
    $q_std = $db->prepare('SELECT * FROM student WHERE student.registration_number
                            NOT IN (SELECT marks.student_registration_number FROM marks WHERE marks.course_code = :cc AND marks.semester = :sem AND marks.d_year = :yr)
                            AND student.semester = :sem');
    $q_std->bindParam(':cc', $course_list['course_code']);
    $q_std->bindParam(':sem', $course_list['semester']);
    $q_std->bindParam(':yr', $course_list['d_year']);
    $q_std->execute();
    if ($q_std->rowCount() <= 0) {
        return null;
    }
    return $q_std->fetchAll(PDO::FETCH_ASSOC);
}

function get_marks_distribution($course)
{
    $db = new PDO('mysql:host=localhost;dbname=dean', 'root', '');
    $q_dist = null;
    if ($course['course_type'] == 'theory') {
        $q_dist = $db->prepare('SELECT * FROM marks_dist_theory WHERE course_code = :cc AND semester = :sem AND dist_year = :yr');
    } else {
        $q_dist = $db->prepare('SELECT * FROM marks_dist_practical WHERE course_code = :cc AND semester = :sem AND dist_year = :yr');
    }
    $q_dist->bindParam(':cc', $course['course_code']);
    $q_dist->bindParam(':sem', $course['semester']);
    $q_dist->bindParam(':yr', $course['d_year']);
    $q_dist->execute();
    return $q_dist->fetch(PDO::FETCH_ASSOC);
}

function insert_std_th_marks(
    $course,
    $regno,
    $mid_sem,
    $end_sem,
    $ta_sem,
    $sem,
    $d_year
) {
    $db = new PDO('mysql:host=localhost;dbname=dean', 'root', '');
    $q = $db->prepare('INSERT INTO marks (course_code, student_registration_number, 
                        mid_semester_exam, end_semester_exam, teacher_assessment, 
                        practical, viva, lab_file, semester, d_year)
                        VALUES (:cc, :reg, :mse, :ese, :ta, 0, 0, 0, :sem, :yr)');
    $q->bindParam(':cc', $course['course_code']);
    $q->bindParam(':reg', $regno);
    $q->bindParam(':mse', $mid_sem);
    $q->bindParam(':ese', $end_sem);
    $q->bindParam(':ta', $ta_sem);
    $q->bindParam(':sem', $sem);
    $q->bindParam(':yr', $d_year);
    return $q->execute();
}

function insert_std_pr_marks(
    $course,
    $regno,
    $end_sem,
    $ta_sem,
    $sem,
    $d_year
) {
    $db = new PDO('mysql:host=localhost;dbname=dean', 'root', '');
    $q = $db->prepare('INSERT INTO marks (course_code, student_registration_number, 
                        mid_semester_exam, end_semester_exam, teacher_assessment, semester, d_year)
                        VALUES (:cc, :reg, 0, :ese, :ta, :sem, :yr)');
    $q->bindParam(':cc', $course['course_code']);
    $q->bindParam(':reg', $regno);
    $q->bindParam(':ese', $end_sem);
    $q->bindParam(':ta', $ta_sem);
    $q->bindParam(':sem', $sem);
    $q->bindParam(':yr', $d_year);
    return $q->execute();
}
