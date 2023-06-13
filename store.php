<?php
include 'includes/header.html';

require('includes/dbconnect.php');

$query = "select * from products";

echo '<table border="0" width="90%" cellspacing="3" cellpadding="3" align="center">
    <tr>
        <td align="left" width="20%"><b>Product Name</b></td>
        <td align="left" width="20%"><b>Description</b></td>
        <td align="left" width="20%"><b>Price</b></td>      
    </tr>';

$r = mysqli_query ($dbc, $query);

while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
    echo "\t<tr>
    <td align=\"left\"><a href=\"view_product.php?id={$row['productID']}\">{$row['productName']}</td>  
    <td align=\"left\">{$row['description']}</td>
    <td align=\"left\">\${$row['price']}</td>    
   </tr>\n";
}

echo '</table>';
mysqli_close($dbc);

include 'includes/footer.html';
?>