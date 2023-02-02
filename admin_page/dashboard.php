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
    $detail = get_admin_detail();
    $entry_stat = [intval($detail['course_entry']), intval($detail['grade_entry'])];

    if (isset($_POST['admin_grade_entry'])) {
        if (!$entry_stat[1] && intval($detail['grade_entered'])) {
            echo "<script>alert(\"Grade entry closed for this semester.\"); window.location.href='admin'</script>";
            return;
        }
        toggle_grade_entry(!$entry_stat[1]);
        header('Location: admin');
        exit;
    }
    if (isset($_POST['admin_course_entry'])) {
        if (!$entry_stat[0] && intval($detail['course_entered'])) {
            echo "<script>alert(\"Course entry closed for this semester.\"); window.location.href='admin'</script>";
            return;
        }

        toggle_course_entry(!$entry_stat[0]);
        header('Location: admin');
        exit;
    }
    if (isset($_POST['admin_change_sem'])) {
        change_semester();
        header('Location: admin');
        exit;
    }
    ?>
    <h1>Welcome, Admin</h1>
    <form method="post">
        <h3>Current Semester : <?php echo $detail['semester'] ?></h3>
        <div class="form-options">
            <button type="submit" name="admin_change_sem" class="nav_btn">Change Semester</button>
            <button type="submit" name="admin_course_entry" class="nav_btn"><?php echo $entry_stat[0] ? "Stop Course Entry" : "Start Course Entry" ?></button>
            <button type="submit" name="admin_grade_entry" class="nav_btn"><?php echo $entry_stat[1] ? "Stop Grade Entry" : "Start Grade Entry" ?></button>
            <button type="submit" name="admin_logout" class="nav_btn">Logout</button>
        </div>
    </form>
</body>

</html>