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

        hr {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 50%;
        }
    </style>
</head>

<body>
    <?php
    $regno = $_SESSION['std_regno'];
    $student = get_student_detail($regno);
    ?>

    <br>
    <h1>Welcome, <?php echo ($student != null) ? $student['first_name'] : '' ?> !</h1>
    <h2>Current semester : &nbsp;&nbsp;&nbsp;&nbsp; <?php echo ($student != null) ? $student['semester'] : '' ?></h2>
    <br>
    <p>You have successfully logged in to the student portal.</p>
    <form method="post">
        <div class="options">
            <button type="submit" name="get_result" class="nav_btn">This semester result</button>
            <button type="submit" name="get_transcript" class="nav_btn">Get my transcript</button>
            <button type="submit" name="prev_sem_perf" class="nav_btn">Previous semester performance</button>
            <button type="submit" name="std_get_courses" class="nav_btn">Get courses of current semester</button>
            <button type="submit" name="logout" class="nav_btn">Logout</button>
        </div>
    </form>

    <?php
    if (isset($_POST['std_get_courses'])) {
        display_courses($student);
    }
    if (isset($_POST['get_result'])) {
        get_result($student);
    }
    if (isset($_POST['get_transcript'])) {
        get_ui_transcript($student);
    }
    if (isset($_POST['prev_sem_perf'])) {
        get_prev_sem_pref($student);
    }
    ?>

</body>

</html>