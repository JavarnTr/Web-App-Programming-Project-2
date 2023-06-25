<?php
include 'includes/header.html';
require('includes/dbconnect.php');

// Get the categories from the database.
$sql = "SELECT * FROM categories";
$r = mysqli_query($dbc, $sql);

// Display all items regardless of category by default.
$categoryOptions = '<option value="">All Categories</option>';

// Loop through the query results, creating an option for each category.
while ($categoryRow = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
    $categoryID = $categoryRow['categoryID'];
    $categoryName = $categoryRow['categoryName'];
    $categoryOptions .= "<option value=\"$categoryID\">$categoryName</option>";
}

// Create the query to retrieve the products where the categoryID matches.
if (isset($_POST['categoryID']) && $_POST['categoryID'] !== '') {
    $selectedCategoryID = $_POST['categoryID'];
    $query = "SELECT * FROM products WHERE categoryID = $selectedCategoryID";
} else {
    $query = "SELECT * FROM products";
}

// If the user is an admin, display the Add Product link.
if (isset($_COOKIE['admin']) && $_COOKIE['admin'] == 1) {
    echo '<p><a href="add_product.php">Add Product</a></p>';
}

// If the user has submitted the form to delete a product, run the query to delete the product. This is only available to admins.
if (isset($_POST['delete_product'])) {
    $productID = $_POST['productID'];
    
    // Run the SQL query to delete the product
    $deleteQuery = "DELETE FROM products WHERE productID = '$productID'";
    mysqli_query($dbc, $deleteQuery);
}

// Create the form to filter the products by category.
echo '<form method="post" action="">
    <label for="categoryID">Select a category:</label>
    <select name="categoryID" id="categoryID">
        ' . $categoryOptions . '
    </select>
    <input type="submit" value="Filter">
</form>';

// Create the table to display the products.
echo '<table border="0" width="90%" cellspacing="3" cellpadding="3" align="center">
    <tr>
    <td align="left" width="30%"><b>Product Name</b></td>
    <td align="left" width="30%"><b>Description</b></td>
    <td align="left" width="30%"><b>Price</b></td>';   

    // If the user is an admin, display the Admin column.
if (isset($_COOKIE["admin"]) && $_COOKIE["admin"] == 1) {
    echo '<td align="left" width="20%"><b>Admin</b></td>';
}    
echo '</tr>';

// Run the query to retrieve the products.
$r = mysqli_query($dbc, $query);

// Loop through the query results, displaying each product.
while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
    echo "\t<tr>
    <td align=\"left\"><a href=\"view_product.php?id={$row['productID']}\">{$row['productName']}</td>  
    <td align=\"left\">{$row['description']}</td>
    <td align=\"left\">\${$row['price']}</td>   
    <td align=\"left\">";

    if (isset($_COOKIE["admin"]) && $_COOKIE["admin"] == 1) {
        echo "<form method=\"post\">
        <input type=\"hidden\" name=\"productID\" value=\"{$row['productID']}\">
        <input type=\"submit\" name=\"delete_product\" value=\"Delete Product\">
        </form>";
    }
    echo "</td>
    </tr>\n";
}

echo '</table>';
mysqli_close($dbc);

include 'includes/footer.html';
?>
