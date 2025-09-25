<?php
header('Content-Type: application/json');

// Include the database configuration file
$servername = "localhost";
$username = "root"; // Your database username
$password = "Rcmk@1234"; // Your database password
$dbname = "shreeji_ayurvedic_store";

// Create a new connection to the MySQL database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $user_name = $_POST['user_name'];
    $rating = $_POST['rating'];
    $feedback = $_POST['feedback'];

    // Insert the rating into the database
    $sql = "INSERT INTO ratings (user_name, rating, feedback) VALUES (?, ?, ?)";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sis", $user_name, $rating, $feedback);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Thank you for your rating!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error: ' . $conn->error]);
        }

        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Error preparing statement.']);
    }

    $conn->close();
}
?>
