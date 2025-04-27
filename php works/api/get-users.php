<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "watches_website";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["error" => "Database connection failed"]));
}

// Fetch user details from the 'users' table
$result = $conn->query("SELECT user_id, name, email FROM users");
$users = [];

while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}

// Return the user data as JSON
echo json_encode($users);

$conn->close();
?>
