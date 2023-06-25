<?php

include('includes/header.html');

session_start();

$uid = $_COOKIE['userID'];
$total = $_SESSION['total'];

require('includes/dbconnect.php');
mysqli_autocommit($dbc, FALSE);

$query = "INSERT INTO orders (userID, total) VALUES ($uid, $total)";
$r = mysqli_query($dbc, $query);

if (mysqli_affected_rows($dbc) == 1) {
    $oid = mysqli_insert_id($dbc);

    $query = "INSERT INTO order_details (orderID, productID, quantity, price) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($dbc, $query);
    mysqli_stmt_bind_param($stmt, 'iiid', $oid, $pid, $qty, $price);
    $affected = 0;

    foreach ($_SESSION['cart'] as $pid => $item) {
        $qty = $item['quantity'];
        $price = $item['price'];
        mysqli_stmt_execute($stmt);
        $affected += mysqli_stmt_affected_rows($stmt);
    }
    mysqli_stmt_close($stmt);

    if ($affected == count($_SESSION['cart'])) {
        mysqli_commit($dbc);
        unset($_SESSION['cart']);
        echo '<p>Thank you for your order. You will be notified when the items ship.</p>';
    } else {
        mysqli_rollback($dbc);
        echo '<p>Your order could not be processed due to a system error. You will be contacted in order to have the problem fixed. We apologize for the inconvenience.</p>';
    }
} else {
    echo '<p>Your order could not be processed due to a system error. You will be contacted in order to have the problem fixed. We apologize for the inconvenience.</p>';
}

mysqli_close($dbc);
include('includes/footer.html');

?>

