<?php
session_start();
include('includes/header.html');

//Get the id of the product that needs to be added to the cart
if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT, array('min_range' => 1))) {
    $id = $_GET['id'];

    //Check if the cart already contains the product
    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['quantity']++;
        echo '<p>Product has been added to your shopping cart.</p>';
    } else {
        require('includes/dbconnect.php');
        $query = "SELECT price FROM products WHERE productID = $id";
        $r = mysqli_query($dbc, $query);
        if (mysqli_num_rows($r) == 1) {
            list($price) = mysqli_fetch_array($r, MYSQLI_NUM);

            $_SESSION['cart'][$id] = array('quantity' => 1, 'price' => $price);
            echo '<p>This product has been added to your shopping cart.</p>';
        } else {
            echo '<div align="center">This product could not be found.</div>';
        }
        mysqli_close($dbc);
    }
} else {
    echo '<div align="center">This product could not be found.</div>';
}

include('includes/footer.html');
?>
