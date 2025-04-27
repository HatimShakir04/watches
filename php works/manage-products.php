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
    <title>Manage Products</title>
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
            background: white;
            border-radius: 5px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 0.75rem;
            text-align: left;
        }
        table th {
            background-color: #f4f4f4;
        }
        .delete-btn {
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 0.3rem 0.6rem;
            cursor: pointer;
            border-radius: 3px;
        }
        .delete-btn:hover {
            background-color: #c0392b;
        }
        form {
            background: white;
            padding: 1rem;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            max-width: 400px;
        }
        form label {
            display: block;
            margin: 0.5rem 0 0.2rem;
        }
        form input, form button {
            width: 100%;
            padding: 0.5rem;
            margin-bottom: 1rem;
            box-sizing: border-box;
        }
        form button {
            background-color: #333;
            color: white;
            border: none;
            cursor: pointer;
            font-weight: bold;
        }
        form button:hover {
            background-color: #555;
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
        <h1>Manage Products</h1>
    </header>
    <main>
        <section id="product-list">
            <h2>Product List</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="product-table-body">
                    <!-- Product rows will be populated here -->
                </tbody>
            </table>
        </section>
        <section id="add-product">
            <h2>Add New Product</h2>
            <form id="product-form" enctype="multipart/form-data">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required />
                <label for="description">Description:</label>
                <input type="text" id="description" name="description" required />
                <label for="price">Price:</label>
                <input type="number" id="price" name="price" step="0.01" required />
                <label for="image">Image:</label>
                <input type="file" id="image" name="image" accept="image/*" required />
                <button type="submit">Add Product</button>
            </form>
        </section>
    </main>
    <script>
        async function fetchProducts() {
            try {
                const response = await fetch('php works/api/get-products.php');
                const products = await response.json();
                const tbody = document.getElementById('product-table-body');
                tbody.innerHTML = '';
                products.forEach(product => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>${product.id}</td>
                        <td>${product.name}</td>
                        <td>${product.description}</td>
                        <td>${product.price}</td>
                        <td><img src="images/${product.image}" alt="${product.name}" width="50" /></td>
                        <td><button class="delete-btn" data-id="${product.id}">Delete</button></td>
                    `;
                    tbody.appendChild(tr);
                });
                addDeleteEventListeners();
            } catch (error) {
                console.error('Error fetching products:', error);
            }
        }

        function addDeleteEventListeners() {
            const deleteButtons = document.querySelectorAll('.delete-btn');
            deleteButtons.forEach(button => {
                button.addEventListener('click', async () => {
                    const id = button.getAttribute('data-id');
                    if (confirm('Are you sure you want to delete this product?')) {
                        try {
                            const response = await fetch('php works/api/delete-product.php', {
                                method: 'DELETE',
                                headers: { 'Content-Type': 'application/json' },
                                body: JSON.stringify({ id })
                            });
                            const result = await response.json();
                            if (result.success) {
                                fetchProducts();
                            } else {
                                alert('Failed to delete product');
                            }
                        } catch (error) {
                            console.error('Error deleting product:', error);
                        }
                    }
                });
            });
        }

        document.getElementById('product-form').addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(e.target);
            try {
                const response = await fetch('php works/save-product.php', {
                    method: 'POST',
                    body: formData
                });
                const resultText = await response.text();
                alert(resultText);
                fetchProducts();
                e.target.reset();
            } catch (error) {
                console.error('Error adding product:', error);
            }
        });

        fetchProducts();
    </script>
</body>
</html>
