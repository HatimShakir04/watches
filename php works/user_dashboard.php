<?php
require 'auth_check.php';

if ($_SESSION['user_role'] !== 'user') {
    echo "Access denied!";
    exit;
}
?>

<h1>Welcome User, <?= $_SESSION['user_name'] ?></h1>
<a href="logout.php">Logout</a>
