<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Category</title>
</head>
<body>
    <form action="catsave.php" method="POST">
        <table border="1" align="center">
            <tr>
                <td>Category Name</td>
                <td><input type="text" name="catname" required></td>
            </tr>
            <tr>
                <td>Category Description</td>
                <td><input type="text" name="catdes" required></td>
            </tr>
            <tr>
                <td colspan="2" align="center"><input type="submit" value="Save"></td>
            </tr>
        </table>
    </form>
</body>
</html>