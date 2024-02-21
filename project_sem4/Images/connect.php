<?php
// Validate input data
$errors = [];
$firstName = validateInput($_POST['firstName']);
$lastName = validateInput($_POST['lastName']);
$gender = validateInput($_POST['gender']);
$email = validateInput($_POST['email']);
$password = validateInput($_POST['password']);
$number = validateInput($_POST['number']);

// Function to validate input data
function validateInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Check for any empty fields
if (empty($firstName) || empty($lastName) || empty($gender) || empty($email) || empty($password) || empty($number)) {
    $errors[] = "All fields are required.";
}

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Invalid email format.";
}

// Database connection
if (empty($errors)) {
    $conn = new mysqli('localhost', 'root', '', 'test');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {
        $stmt = $conn->prepare("INSERT INTO registration (firstName, lastName, gender, email, password, number) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssi", $firstName, $lastName, $gender, $email, $password, $number);
        $stmt->execute();
        $stmt->close();
        $conn->close();
        echo "Registration successful.";
    }
} else {
    // Generate JavaScript code to display alert message
    echo "<script>alert('";
    foreach ($errors as $error) {
        echo $error . "\\n"; // Use \\n for new line in JavaScript alert
    }
    echo "');</script>";
}
?>
