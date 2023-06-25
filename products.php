<?php
include ('includes/adminHeader.html');
require ('includes/dbconnect.php');

$query = "select * from products";


echo '<button><a href="add_product.php">Add Product</a></button>';

echo '<table border="0" width="90%" cellspacing="3" cellpadding="3" align="center">
    <tr>
    <td align="left" width="20%"><b>Product Name</b></td>
    <td align="left" width="20%"><b>Price</b></td>
    <td align="left" width="20%"><b>Inventory</b></td>
    <td align="left" width="20%"><b>Description</b></td>
    <td align="left" width="20%"><b>Image</b></td>
</tr>';

$r = mysqli_query ($dbc, $query);

if (isset($_POST['delete_product'])) {
    $productID = $_POST['productID'];
    
    // Run the SQL query to delete the product
    $deleteQuery = "DELETE FROM products WHERE productID = '$productID'";
    mysqli_query($dbc, $deleteQuery);
    echo '<p>Product deleted.</p>';
    header("Location: ".$_SERVER['PHP_SELF']);
}

while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
    echo "\t<tr>
    <td align=\"left\">{$row['productName']}</td>
    <td align=\"left\">{$row['price']}</td>
    <td align=\"left\">{$row['inventory']}</td> 
    <td align=\"left\">{$row['description']}</td>  
    <td align=\"left\">{$row['image']}</td>   
    
    <td align=\"left\">
    <form method=\"post\" action='editproduct.php'>
    <input type=\"hidden\" name=\"productID\" value=\"{$row['productID']}\">
    <input type=\"submit\" name=\"edit_product\" value=\"Edit Product\">
    </form></td>
    
    <td align=\"left\">
    <form method=\"post\">
    <input type=\"hidden\" name=\"productID\" value=\"{$row['productID']}\">
    <input type=\"submit\" name=\"delete_product\" value=\"Delete Product\">
    </form></td>
    </tr>\n";
}
echo '</table>';
mysqli_close($dbc);

include ('includes/footer.html');

?>