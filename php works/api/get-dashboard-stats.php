<?php
header('Content-Type: application/json');

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "watches_website";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["error" => "Database connection failed"]));
}

// Fetch stats
$totalUsers = $conn->query("SELECT COUNT(*) AS count FROM users")->fetch_assoc()['count'];
$totalProducts = $conn->query("SELECT COUNT(*) AS count FROM products")->fetch_assoc()['count'];
$salesToday = $conn->query("SELECT SUM(amount) AS total FROM sales WHERE DATE(sale_date) = CURDATE()")->fetch_assoc()['total'] ?? 0;

echo json_encode([
    "totalUsers" => $totalUsers,
    "totalProducts" => $totalProducts,
    "salesToday" => $salesToday
]);

$conn->close();
?>
