<?php
// Include the database configuration file
$servername = "localhost";
$username = "root"; // Your database username
$password = "Rcmk@1234"; // Your database password
$dbname = "shreeji_ayurvedic_store";

// Create a new connection to the MySQL database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];

    // Check if passwords match
    if ($password !== $confirm_password) {
        echo "Passwords do not match.";
        exit;
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert user into the database
    $sql = "INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sss", $name, $email, $hashed_password);

        if ($stmt->execute()) {
            echo "Registration successful!";
            header("Location: login.php");
        } else {
            echo "Error: " . $conn->error;
        }

        $stmt->close();
    }

    $conn->close();
}
?>
