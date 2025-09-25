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
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if the user exists
    $sql = "SELECT id, full_name, password FROM users WHERE email = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $email);

        if ($stmt->execute()) {
            $stmt->store_result();

            // Check if email exists, then verify the password
            if ($stmt->num_rows == 1) {
                $stmt->bind_result($id, $full_name, $hashed_password);
                $stmt->fetch();

                if (password_verify($password, $hashed_password)) {
                    // Password is correct, start a session
                    session_start();
                    $_SESSION['user_id'] = $id;
                    $_SESSION['user_name'] = $full_name;
                    echo "Login successful!";
                    header("Location: index.html");
                } else {
                    echo "Invalid password.";
                }
            } else {
                echo "No account found with that email.";
            }
        } else {
            echo "Error: " . $conn->error;
        }

        $stmt->close();
    }

    $conn->close();
}
?>
