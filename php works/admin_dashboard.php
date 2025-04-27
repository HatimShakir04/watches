<?php
require 'auth_check.php';

if ($_SESSION['user_role'] !== 'admin') {
    echo "Access denied!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin Panel - Dashboard</title>
    <link rel="stylesheet" href="shstyles.css" />
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background-color: #f4f4f4;
        }
        header {
            background-color: #333;
            color: white;
            padding: 1rem;
            text-align: center;
        }
        nav {
            background-color: #222;
            width: 200px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            padding-top: 2rem;
        }
        nav a {
            display: block;
            color: white;
            padding: 1rem;
            text-decoration: none;
            font-weight: bold;
        }
        nav a:hover {
            background-color: #444;
        }
        main {
            margin-left: 210px;
            padding: 2rem;
        }
        .stats {
            display: flex;
            gap: 2rem;
            margin-bottom: 2rem;
        }
        .stat-box {
            background: white;
            padding: 1rem 2rem;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            flex: 1;
            text-align: center;
        }
        .stat-box h2 {
            margin: 0;
            font-size: 2rem;
            color: #333;
        }
        .stat-box p {
            margin: 0;
            font-size: 1rem;
            color: #666;
        }
    </style>
</head>
<body>
    <nav>
        <a href="admin_dashboard.php">Dashboard</a>
        <a href="manage-products.php">Manage Products</a>
        <a href="php works/api/get-users.php">Manage Users</a>
        <a href="catfile/category.php">Manage Categories</a>
        <a href="logout.php">Logout</a>
    </nav>
    <header>
        <h1>Welcome Admin, <?= htmlspecialchars($_SESSION['user_name']) ?></h1>
    </header>
    <main>
        <div class="stats">
            <div class="stat-box">
                <h2 id="totalUsers">0</h2>
                <p>Total Users</p>
            </div>
            <div class="stat-box">
                <h2 id="totalProducts">0</h2>
                <p>Total Products</p>
            </div>
            <div class="stat-box">
                <h2 id="salesToday">0</h2>
                <p>Sales Today</p>
            </div>
        </div>
        <section>
            <p>Use the navigation menu to manage products, users, and categories.</p>
        </section>
    </main>
    <script>
        async function fetchDashboardStats() {
            try {
                const response = await fetch('php works/api/get-dashboard-stats.php');
                const data = await response.json();
                document.getElementById('totalUsers').textContent = data.totalUsers || 0;
                document.getElementById('totalProducts').textContent = data.totalProducts || 0;
                document.getElementById('salesToday').textContent = data.salesToday || 0;
            } catch (error) {
                console.error('Error fetching dashboard stats:', error);
            }
        }
        fetchDashboardStats();
    </script>
</body>
</html>

