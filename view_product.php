<?php
 
$row = FALSE;

//When you click on a product on the previous page, the ID is set. This code retrieves this ID so that it knows which product to display.
if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT, array('min_range' => 1))) {
    $id = $_GET['id'];

    //Create the database connection and run a query to retrieve product records.
    require('includes/dbconnect.php');
    $query = "select * from products where productID = $id";
    $r = mysqli_query($dbc, $query);

    if (mysqli_num_rows($r) == 1) {
        $row = mysqli_fetch_array($r, MYSQLI_ASSOC);
        $page_title = $row['productName'];
        include ('includes/header.html');

        echo "<div align=\"center\"><b>{$row['productName']}</b><br />";
        echo "<br />\${$row['price']} <a href=\"add_cart.php?id=$id\">Add to Cart</a></div><br />";

        if ($image = @getimagesize("includes/images/$id")) {
            echo "<div align=\"center\"><img src=\"display_image.php?image=$id&name=" . urlencode($row['image']) . "\" $image[3] alt=\"{$row['productName']}\" /></div>\n";
        } else {
            echo "<div align=\"center\">Image not available.</div>\n";
        }

        echo '<p align="center">' . ((is_null($row['description'])) ? '(No description available)' : $row['description']) . '</p>';
    }
    //Close the database connection.
    mysqli_close($dbc);
}

if (!$row) {
    $page_title = "Error";
    include ('includes/header.html');
    echo '<div align="center">The product could not be found</div>';
}

include ('includes/footer.html');
?>