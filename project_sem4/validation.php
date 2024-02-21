<?php
session_start();
include 'connect.php';

if (isset($_POST['submit'])) {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $number = $_POST['number'];

    if (empty($firstName) || empty($lastName) || empty($gender) || empty($email) || empty($password) || empty($number)) {
        $_SESSION['error'] = "All fields are required";
        header("Location: register.php");
        exit();
    } else {
        $sql = "INSERT INTO users (firstName, lastName, gender, email, password, number) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssss", $firstName, $lastName, $gender, $email, $password, $number);
        if ($stmt->execute()) {
            $_SESSION['success'] = "Registration successful";
            header("Location: login.php");
            exit();
        } else {
            $_SESSION['error'] = "Error in registration";
            header("Location: register.php");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Registration Page</title>
    <link rel="stylesheet" type="text/css" href="bootstrap.css" />
    <style>
        body {
            background-image: url('wallpaper.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
            margin: 0;
            padding: 0;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#email').blur(function() {
                var email = $(this).val();
                $.ajax({
                    url: 'check_email.php',
                    method: 'POST',
                    data: { email: email },
                    success: function(response) {
                        if (response == 'taken') {
                            $('#emailError').text('Email already taken');
                        } else {
                            $('#emailError').text('');
                        }
                    }
                });
            });
        });
    </script>
</head>

<body>
    <br><!-- -->
    <br><!-- comment -->
    <br>
    <div class="container">
        <div class="row col-md-6 col-md-offset-3">
            <div class="panel panel-primary">
                <div class="panel-heading text-center">
                    <h1>Registration Form</h1>
                </div>
                <div class="panel-body">
                    <?php if (isset($_SESSION['error'])) { ?>
                        <div class="alert alert-danger">
                            <strong><?php echo $_SESSION['error']; ?></strong>
                        </div>
                    <?php unset($_SESSION['error']);
                    } ?>
                    <?php if (isset($_SESSION['success'])) { ?>
                        <div class="alert alert-success">
                            <strong><?php echo $_SESSION['success']; ?></strong>
                        </div>
                    <?php unset($_SESSION['success']);
                    } ?>
                    <form action="register.php" method="post">
                        <div class="form-group">
                            <label for="firstName">First Name</label>
                            <input type="text" class="form-control" id="firstName" name="firstName" required />
                        </div>
                        <div class="form-group">
                            <label for="lastName">Last Name</label>
                            <input type="text" class="form-control" id="lastName" name="lastName" required />
                       