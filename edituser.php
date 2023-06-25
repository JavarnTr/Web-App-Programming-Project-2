<?php
include('includes/adminHeader.html');
require('includes/dbconnect.php');

if (isset($_POST['submit'])) {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $userID = $_POST['userID'];

    // Run the SQL query to edit the user
    $editQuery = "UPDATE users SET firstName = '$firstName', lastName = '$lastName', email = '$email', password = '$password' WHERE userID = '$userID'";
    mysqli_query($dbc, $editQuery);
    echo '<p>User edited.</p>';
    header("Location: users.php");
}

if (isset($_POST['edit_user'])) {
    $userID = $_POST['userID'];

    // Run the SQL query to retrieve the user data
    $editQuery = "SELECT * FROM users WHERE userID = '$userID'";
    $r = mysqli_query($dbc, $editQuery);
    $row = mysqli_fetch_array($r, MYSQLI_ASSOC);
    $firstName = $row['firstName'];
    $lastName = $row['lastName'];
    $email = $row['email'];
    $password = $row['password'];
    $userID = $row['userID'];

    echo '<h1>Edit User</h1>';
    echo '<form method="post">
    <p>First Name: <input type="text" name="firstName" size="15" maxlength="20" value="' . $firstName . '" required></p>
    <p>Last Name: <input type="text" name="lastName" size="15" maxlength="40" value="' . $lastName . '" required></p>
    <p>Email Address: <input type="email" name="email" size="20" maxlength="60" value="' . $email . '" required></p>
    <p>Password: <input type="text" name="password" size="10" maxlength="20" value="' . $password . '" required></p>
    <input type="hidden" name="userID" value="' . $userID . '">
    <p><input type="submit" name="submit" value="Edit User"></p>
    </form>';
}

include('includes/footer.html');
?>