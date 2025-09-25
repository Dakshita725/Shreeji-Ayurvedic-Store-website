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

// Retrieve search query from the form
$query = isset($_GET['query']) ? $_GET['query'] : '';

if ($query) {
    // Corrected SQL query
    $sql = "SELECT * FROM oil WHERE name LIKE ?"; 

    // Prepare statement to prevent SQL injection
    $stmt = $conn->prepare($sql);
    $searchTerm = '%' . $query . '%';
    $stmt->bind_param("s", $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();

    echo "<h2>Search Results for: " . htmlspecialchars($query) . "</h2>";

    if ($result->num_rows > 0) {
        // Output the search results as links
        echo "<div class='search-results'>";
        while ($row = $result->fetch_assoc()) {
            // Link to product_detail.php with the product ID as a query parameter
            echo "<div class='product-item'>";
            echo "<a href='product_detail.php?id=" . htmlspecialchars($row['id']) . "'>";
            echo "<h3>" . htmlspecialchars($row['name']) . "</h3>";
            echo "</a>";
            
            // Safely access the image_url key
            if (isset($row['image_url'])) {
                echo "<img src='" . htmlspecialchars($row['image_url']) . "' alt='" . htmlspecialchars($row['name']) . "'>";
            } else {
                // Placeholder or alternative action if 'image_url' is not available
                echo "<img src='img/default.jpg' alt='No image available'>";
            }

            // Check for description column availability
            if (isset($row['description'])) {
                echo "<p>" . htmlspecialchars($row['description']) . "</p>";
            }
            
            // Display price
            echo "<p>₹" . htmlspecialchars($row['price']) . "</p>";
            echo "</div>";
        }
        echo "</div>";
    } else {
        echo "<p>No results found.</p>";
    }
    $stmt->close();
}

$conn->close();
?>
