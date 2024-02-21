<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    $servername = "localhost"; // Change this to your database server
    $username = "root"; // Change this to your database username
    $password = ""; // Change this to your database password
    $dbname = "customer"; // Change this to your database name

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("INSERT INTO customers (name, email, date_of_birth, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $date_of_birth, $password);

    // Set parameters and execute
    $name = $_POST['Name'];
    $email = $_POST['Email'];
    $date_of_birth = $_POST['Date'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password for security

    if ($stmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>
