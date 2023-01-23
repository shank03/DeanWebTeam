<!DOCTYPE html>
<html>

<head>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #242424;
            color: #f5f5f5;
            text-align: center;
            font-family: 'Montserrat', sans-serif;
        }

        .title {
            text-align: center;
            font-size: 2em;
            margin: 30px 0 0 0;
        }

        .options {
            padding: 20px;
            text-align: center;
        }

        .title {
            padding: 20px;
            text-align: center;
        }

        button {
            font-family: 'Montserrat', sans-serif;
            margin: 10px 0;
            font-size: 16px;
            border: none;
            border-radius: 20px;
            background-color: #3f51b5;
            color: #f5f5f5;
        }

        button:focus {
            border: 2px solid #3f51b5;
            outline: none;
        }

        button:hover {
            background-color: #5f5f5f;
        }

        .options {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .nav_btn {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 12px 24px;
            margin: 12px;
            text-decoration: none;
            color: #f5f5f5;
            background-color: #3f51b5;
            border-radius: 20px;
            font-size: 16px;
            font-weight: bold;
        }

        .nav_btn:hover {
            background-color: #5f5f5f;
        }

        table {
            display: flex;
            justify-content: center;
            align-items: center;
            border-collapse: collapse;
            font-family: 'Montserrat', sans-serif;
            color: #f5f5f5;
            text-align: center;
        }

        th,
        td {
            border: 1px solid #3f51b5;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #3f51b5;
            color: #f5f5f5;
        }

        /* Add hover effect to table rows */
        tr:hover {
            background-color: #f5f5f5;
            color: #3f51b5;
        }

        .form-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin: 56px 0 30px 0;
        }

        /* Minimalist design for form elements */
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        label,
        button,
        h1 {
            font-family: 'Montserrat', sans-serif;
        }

        label,
        input,
        button {
            margin: 10px 0;
            font-size: 16px;
        }

        input,
        button {
            padding: 12px;
            border: none;
            border-radius: 4px;
            background-color: #424242;
            color: #f5f5f5;
        }

        /* Increase border width and change color on focus */
        input:focus,
        button:focus {
            border: 2px solid #3f51b5;
            outline: none;
        }

        /* Rounded corners for form container */
        .form-container {
            border-radius: 20px;
            overflow: hidden;
        }

        /* Rounded corners for inputs and button */
        input,
        button {
            border-radius: 20px;
        }

        /* Colorful button */
        button {
            background-color: #3f51b5;
            color: #f5f5f5;
        }

        /* Change button color on hover */
        button:hover {
            background-color: #5f5f5f;
        }
    </style>
</head>

<body>
    <?php
    $empno = $_SESSION['emp_no'];
    $teacher = get_teacher_detail($empno);

    $first_name = "";
    $last_name = "";
    if ($teacher != null) {
        $first_name = $teacher['first_name'];
        $last_name = $teacher['last_name'];
    }
    ?>
    <h1>Welcome, <?php echo $first_name . " " . $last_name ?></h1>
    <form method="post">
        <div class="options">
            <?php
            $entry_stat = get_entry_status();
            if ($entry_stat[0] == true) {
                echo "<button type=\"submit\" name=\"emp_set_course_form\" class=\"nav_btn\">Enter the courses of current semester</button>";
            }
            if ($entry_stat[1] == true) {
                echo "<button type=\"submit\" class=\"nav_btn\">Enter marks of each student</button>";
            }
            ?>
            <button type="submit" name="emp_courses" class="nav_btn">Get courses of current semester</button>
            <button type="submit" name="emp_logout" class="nav_btn">Logout</button>
        </div>
    </form>

    <?php
    if (isset($_POST['emp_courses'])) {
        display_courses_t($teacher);
    }
    if (isset($_POST['emp_set_course_form'])) {
        require 'course.php';
    }
    if (isset($_POST['emp_enter_course'])) {
        $course_code = $_POST['course_code'];
        $semester = $_POST['semester'];

        $course_data = check_course_sem($course_code, $semester);
        if ($course_data != null) {
            $_SESSION['course'] = $course_data;
            if ($course_data['course_type'] == 'theory') {
                require 'theory_marks.php';
            } else if ($course_data['course_type'] == 'practical') {
                require 'practical_marks.php';
            }
        } else {
            echo "<script>alert(\"ERROR: Course {$course_code} doesn't exists in {$semester} semester\"); window.location.href='teacher'</script>";
        }
    }

    if (isset($_POST['emp_dist_th_course'])) {
        $course_data = $_SESSION['course'];
        $_SESSION['course'] = ['' => ''];

        $mid_sem_marks = $_POST['mid_sem'];
        $end_sem_marks = $_POST['end_sem'];
        $ta_sem_marks = $_POST['ta_sem'];

        $total = intval($mid_sem_marks) + intval($end_sem_marks) + intval($ta_sem_marks);
        if ($total != 100) {
            echo "<script>alert(\"ERROR: Total doesn't add upto 100\"); window.location.href='teacher'</script>";
            return;
        }

        $course_entry_res = set_sem_course_entry($course_data, $mid_sem_marks, $end_sem_marks, $ta_sem_marks, $teacher);
        if ($course_entry_res == "") {
            echo "<script>alert(\"Course {$course_data['course_code']} entered successfully\"); window.location.href='teacher'</script>";
            exit;
        } else {
            echo "<script>alert(\"ERROR: {$course_entry_res}\"); window.location.href='teacher'</script>";
            return;
        }
    }
    ?>
</body>

</html>