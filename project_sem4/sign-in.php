<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'test');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute SQL query to check if the user exists
    $stmt = $conn->prepare("SELECT * FROM registration WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        // User exists, redirect to index.html
        header("Location: C:\Users\Pratik kulkarni\.vscode\project_sem4\page (1).html");
        exit();
    } else {
        // User does not exist, show alert message
        echo "<script>alert('Invalid email or password. Please try again.');</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
