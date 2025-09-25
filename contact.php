<<?php

$server = "localhost";
$username = "root";
$password = "Rcmk@1234";
$dbname = "contact_form_db";

// Create connection
$con = mysqli_connect($server, $username, $password, $dbname);

// Check connection
if(!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];

// Correct SQL query with proper interpolation
$sql = "INSERT INTO messages(name,email,message) VALUES('$name', '$email', '$message')";

// Execute the query
$result = mysqli_query($con, $sql);

// Check if the query was successful
if($result) {
    echo "Message sent successfully";
} else {
    echo "Message not sent: " . mysqli_error($con);
}

// Close the connection
mysqli_close($con);

?>
