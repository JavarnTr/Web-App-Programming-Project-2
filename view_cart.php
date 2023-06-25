<?php
session_start();
include('includes/header.html');

// Check if the form has been submitted (to update the cart):
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Change any quantities:
    foreach ($_POST['qty'] as $k => $v) {

        // Must be integers!
        $id = (int)$k;
        $qty = (int)$v;

        if ($qty == 0) { // Delete.
            unset($_SESSION['cart'][$id]);
        } elseif ($qty > 0) { // Change quantity.
            $_SESSION['cart'][$id]['quantity'] = $qty;
        }
    }
}

if (!empty($_SESSION['cart'])) {
    require('includes/dbconnect.php');
    $q = "SELECT * FROM products WHERE productID IN (";
    foreach ($_SESSION['cart'] as $id => $value) {
        $q .= $id . ',';
    }
    $q = substr($q, 0, -1) . ') ORDER BY productName ASC';
    $r = mysqli_query($dbc, $q);

    echo '<form action="view_cart.php" method="post">
        <table border="0" width="90%" cellspacing="3" cellpadding="3" align="center">
            <tr>
                <td align="left" width="30%"><b>Product</b></td>
                <td align="left" width="30%"><b>Price</b></td>
                <td align="center" width="10%"><b>Qty</b></td>
                <td align="right" width="10%"><b>Total Price</b></td>
            </tr>
            <tr><td colspan="4"><hr></td></tr>';

    $total = 0; // Total cost of the order.
    while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
        $subtotal = $_SESSION['cart'][$row['productID']]['quantity'] * $_SESSION['cart'][$row['productID']]['price'];
        $total += $subtotal;
        echo '<tr>
        <td align="left">' . $row['productName'] . '</td>
        <td align="left">$' . $row['price'] . '</td>
        <td align="center"><input type="text" size="3" name="qty[' . $row['productID'] . ']" value="' . $_SESSION['cart'][$row['productID']]['quantity'] . '" /></td>
        <td align="right">$' . number_format($subtotal, 2) . '</td>
        </tr>';
    }

    echo '<tr>
        <td colspan="3" align="right"><b>Total:</b></td>
        <td align="right">$' . number_format($total, 2) . '</td>
        </tr>
        </table>
        <div align="center"><input type="submit" name="submit" value="Update My Cart" /></div>
        </form>
        <p align="center">Enter a quantity of 0 to remove an item.<br /><br /><a href="checkout.php">Checkout</a></p>';
     
    $_SESSION['total'] = $total;

    mysqli_close($dbc); // Close the database connection.
} else {
    echo '<p>Your cart is currently empty.</p>';
}

include('includes/footer.html');
?>
