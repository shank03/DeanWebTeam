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
                echo "<button class=\"nav_btn\">Enter the courses of current semester</button>";
            }
            if ($entry_stat[1] == true) {
                echo "<button class=\"nav_btn\">Enter marks of each student</button>";
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
    ?>
</body>

</html>