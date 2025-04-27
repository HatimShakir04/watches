<?php
include 'db_connect.php'; // Include the database connection

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image = $_FILES['image']['name'];

    // Sanitize the filename
    $image = preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $image);

    // Move the uploaded image to the "images" folder
    $target_dir = "C:/xampp/htdocs/watches_website/images/";
    $target_file = $target_dir . basename($image);

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
        // Insert the product into the database using prepared statement
        $stmt = $conn->prepare("INSERT INTO watches (name, description, price, image) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssds", $name, $description, $price, $image);

        if ($stmt->execute()) {
            echo "Product added successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error uploading the image.";
    }

    $conn->close();
} else {
    echo "Invalid request.";
}
