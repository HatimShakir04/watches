<?php
include 'db_connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop - ZenChrono</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
<header>
    <div class="logo">ZenChrono</div>
    <nav>
        <ul>
            <li><a href="../landing-page.html">Home</a></li>
            <li><a href="shop.php">Shop</a></li>
            <li><a href="../about.html">About</a></li>
            <li><a href="../contact.html">Contact</a></li>
            <li><a href="../cart.html"><i class="cart-icon">🛒</i> Cart</a></li>
            <li><a href="../user.html">Login</a></li>
        </ul>
    </nav>
</header>

<section class="shop">
    <h2>Available Watches</h2>
    <div class="product-grid">
        <?php
        // Fetch products from the database
        $sql = "SELECT * FROM watches";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="product">';
                echo '<img src="images/' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['name']) . '">';
                echo '<h3>' . htmlspecialchars($row['name']) . '</h3>';
                echo '<p>' . htmlspecialchars($row['description']) . '</p>';
                echo '<p>$' . htmlspecialchars($row['price']) . '</p>';
                echo '<button onclick="addToCart(\'' . htmlspecialchars($row['name']) . '\', ' . htmlspecialchars($row['price']) . ', 1)">Add to Cart</button>';
                echo '</div>';
            }
        } else {
            echo '<p>No products found.</p>';
        }
        ?>
    </div>
</section>

<footer>
    <p>&copy; 2025 ZenChrono. All Rights Reserved.</p>
</footer>

<script>
    function addToCart(productName, price, quantity) {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        cart.push({ productName, price, quantity });
        localStorage.setItem('cart', JSON.stringify(cart));
        alert(`Added ${quantity} item(s) of ${productName} to cart at $${price} each.`);
    }
</script>
</body>
</html>
