<?php
include 'includes/header.html';

//Display a welcome message if the user is logged in.
if (isset($_COOKIE['userID'])) {
    echo "<p>You are now logged in as {$_COOKIE['firstName']}.</p>";
} else {
    echo "<p>You are not currently logged in.</p>";
}

//Allow the user to register if they are not logged in.
if ((!isset($_COOKIE['userID'])) && (basename($_SERVER['PHP_SELF']) != 'register.php')) {
    echo '<button><a href="register.php">Register</a></button>';
} 


//Perform these actions only if the user is logged in.
if ((isset($_COOKIE['userID'])) && (basename($_SERVER['PHP_SELF']) != 'logout.php')) {
    //Update the users password if they have submitted the form.
    if (isset($_POST['changePassword'])) {
        include 'includes/dbconnect.php';
        
        $newPassword = sha1($_POST['password']);

        $query = "UPDATE users SET password = '$newPassword' WHERE userID = '{$_COOKIE['userID']}'";
        $result = $dbc->query($query);

        if($result) {
            echo '<p>Your password has been updated.</p>';
        } else {
            echo '<p>There was an error updating your password.</p>';
        }
    }

    //Form for the user to update their password.
    echo '<form method="post">
    <label for="password">New Password:</label>    
    <input type="password" name="password" required>
    <input type="submit" name="changePassword" value="Update Password">           
    </form>'; 

    if ($_COOKIE['admin'] == 1) {
        echo '<button><a href="users.php">Admin Dashboard</a></button>';
    }

    echo '<button><a href="logout.php">Logout</a></button>';
} else {
    echo '<button><a href="login.php">Login</a></button>';
}

include 'includes/footer.html';
?>