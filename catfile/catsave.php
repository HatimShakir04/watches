<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "watches_website";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $catname = $_POST['catname'];
    $catdes = $_POST['catdes'];

    // Use prepared statement for security
    $stmt = $conn->prepare("INSERT INTO categories (category_name, category_description) VALUES (?, ?)");
    $stmt->bind_param("ss", $catname, $catdes);

    if ($stmt->execute()) {
        echo "Category added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

$conn->close();
?>
