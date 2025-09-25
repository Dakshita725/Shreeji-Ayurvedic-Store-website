<?php
// Database connection (adjust the parameters as per your database)
$servername = "localhost";
$username = "root";
$password = "Rcmk@1234";
$dbname = "products";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the product ID from the URL
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($product_id > 0) {
    // Fetch product details from the database
    $sql = "SELECT * FROM oil WHERE id = $product_id";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        echo "<h1>" . htmlspecialchars($row['name']) . "</h1>";
        echo "<p><strong>Description:</strong> " . htmlspecialchars($row['description']) . "</p>";
        echo "<p><strong>Price:</strong> $" . htmlspecialchars($row['price']) . "</p>";
        // Add more fields as needed
    } else {
        echo "<p>Product not found.</p>";
    }
} else {
    echo "<p>Invalid product ID.</p>";
}

$conn->close();
?>
