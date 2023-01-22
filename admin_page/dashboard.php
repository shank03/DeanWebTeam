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
    </style>
</head>

<body>

    <!-- <h1>Welcome, Professor !</h1> -->
    <?php
            // $regno = $_SESSION['std_regno'];
            // $student = get_student_detail($regno);
            ?>

    <h1>Welcome, <?php echo ($student != null) ? $student['first_name'] : '' ?> !</h1>
    <p>You have successfully logged in to the student portal.</p>
    <form method="post">
        <div class="options">
            <button href="transcript.php" class="nav_btn">Get my transcript</button>
            <button href="performance.php" class="nav_btn">Previous semester performance</button>
            <button href="courses.php" class="nav_btn">Get courses of current semester</button>
            <button type="submit" name="logout" class="nav_btn">Logout</button>
        </div>
    </form>
</body>

</html>