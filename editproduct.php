<?php
include('includes/adminHeader.html');
require('includes/dbconnect.php');

if (isset($_POST['submit'])) {
    $productName = $_POST['productName'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $inventory = $_POST['inventory'];
    $productID = $_POST['productID'];
    $category = $_POST['category'];

    // Run the SQL query to edit the product
    $editQuery = "UPDATE products SET productName = '$productName', price = '$price', description = '$description', inventory = '$inventory', categoryID = '$category' WHERE productID = '$productID'";
    mysqli_query($dbc, $editQuery);
    echo '<p>Product edited.</p>';
    header("Location: products.php");
}

if (isset($_POST['edit_product'])) {
    $productID = $_POST['productID'];

    // Run the SQL query to retrieve the product data
    $editQuery = "SELECT * FROM products WHERE productID = '$productID'";
    $r = mysqli_query($dbc, $editQuery);
    $row = mysqli_fetch_array($r, MYSQLI_ASSOC);
    $productName = $row['productName'];
    $price = $row['price'];
    $description = $row['description'];
    $inventory = $row['inventory'];
    $productID = $row['productID'];

    echo '<h1>Edit product</h1>';
    echo '<form method="post">
    <p>Product Name: <input type="text" name="productName" size="15" maxlength="20" value="' . $productName . '" required></p>
    <p>Price: <input type="text" name="price" size="15" maxlength="40" value="' . $price . '" required></p>
    <p>Description: <input type="text" name="description" size="20" maxlength="60" value="' . $description . '" required></p>
    <p>Inventory: <input type="text" name="inventory" size="10" maxlength="20" value="' . $inventory . '" required></p>
    <input type="hidden" name="productID" value="' . $productID . '">';

    $query = 'SELECT * FROM categories';
    $result = mysqli_query($dbc, $query);
    while ($categoryRow = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $categoryID = $categoryRow['categoryID'];
        $categoryName = $categoryRow['categoryName'];
        $checked = ($categoryID == $row['categoryID']) ? 'checked' : '';
        echo '<input type="radio" name="category" value="' . $categoryID . '" ' . $checked . ' required> ' . $categoryName . '<br>';
    }

    echo '<p><input type="submit" name="submit" value="Edit product"></p>
    </form>';
}

include('includes/footer.html');
?>
