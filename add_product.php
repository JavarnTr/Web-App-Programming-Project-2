<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
</head>

<body>

<?php
require('includes/dbconnect.php');

//Check product name
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = array();
    
    if (!empty($_POST['product_name'])) {
        $pn = trim($_POST['product_name']);
    } else {
        $errors[] = 'Please enter a name for this product.';
    }
        

    //Check price
    if (is_numeric($_POST['price']) && ($_POST['price'] > 0)) {
        $p = (float) $_POST['price'];
    } else {
        $errors[] = 'Please enter a price for this product.';
    }

    //Check inventory number
    if (is_numeric($_POST['inventory'])) {
        $i = (float) $_POST['inventory'];
    } else {
        $errors[] = 'Please enter the number of products available in inventory.';
    }

    // Move image to directory and save name to database.
    if (is_uploaded_file($_FILES['image']['tmp_name'])) {

        $temp = 'includes/images/' . md5($_FILES['image']['name']);

        if (move_uploaded_file($_FILES['image']['tmp_name'], $temp)) {
            echo '<p>File uploaded.</p>';
            $img = $_FILES['image']['name'];

        } else { 
            $errors[] = 'The file could not be moved.';
            $temp = $_FILES['image']['tmp_name'];
        }
    } else { 
        $errors[] = 'Please upload a file.';
        $temp = NULL;
    }

    if (empty($errors)) {
        $query = 'insert into products (productName, price, inventory, image) values (?, ?, ?, ?)';
        $stmt = mysqli_prepare($dbc, $query);
        mysqli_stmt_bind_param($stmt, 'siis', $pn, $p, $i, $img);
        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_affected_rows($stmt) == 1) {
            echo '<p>Product added.</p>';
            $id = mysqli_stmt_insert_id($stmt);
            rename ($temp, "includes/images/$id");

            $_POST = array();
        } else {
            echo '<p>The product was not added. Please try again.</p>';
        }
        mysqli_stmt_close($stmt);
    }
    if (isset($temp) && file_exists($temp) && is_file($temp)) {
        unlink($temp);
    }
}

if (!empty($errors) && is_array($errors)) {
    echo '<h1>Error</h1> <p>These errors have occured:<br>';
    foreach ($errors as $msg) {
        echo " - $msg<br />\n";
    }
}
?>

<!-- HTML Form -->
<h1>Add a new product: </h1>
<form action="add_product.php" method="POST" enctype="multipart/form-data">

    <label for="product_name">Product Name:</label>
    <input type="text" name="product_name">

    <label for="image">Image:</label>
    <input type="file" name="image">

    <label for="price">Price:</label>
    <input type="number" name="price">

    <label for="inventory">Inventory:</label>
    <input type="number" name="inventory">

    <input type="submit" name="submit" value="Submit">


</form>
</body>


</html>