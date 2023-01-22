<!DOCTYPE html>
<html>

<head>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <style>
        /* Dark theme */
        body {
            background-color: #242424;
            color: #f5f5f5;
        }

        /* Title styles */
        .title {
            text-align: center;
            font-size: 2em;
            margin: 30px 0 0 0;
            font-family: 'Montserrat', sans-serif;
        }

        /* Minimalist design for form container */
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
    $regno = isset($_GET['regno']) ? $_GET['regno'] : '';
    $regno = strlen($regno) == 8 ? $regno : '';
    ?>

    <h1 class="title">Student Login Portal</h1>
    <div class="form-container">
        <form method="post">
            <label for="registrationNumber">Registration Number</label>
            <input type="number" name="registrationNumber" id="registrationNumber" max="99999999" value="<?php echo $regno ?>">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" minlength="6">
            <button type="submit" name="submit">Login</button>
        </form>
    </div>
</body>

</html>