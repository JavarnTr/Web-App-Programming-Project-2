<?php
include 'includes/header.html'; 

if (isset($_COOKIE['userID'])) {
    echo "<p>You are now logged in as {$_COOKIE['firstName']}.</p>";
} else {
    echo "<p>You are not currently logged in.</p>";
}

if ((!isset($_COOKIE['userID'])) && (basename($_SERVER['PHP_SELF']) != 'register.php')) {
    echo '<button><a href="register.php">Register</a></button>';
} 

if ((isset($_COOKIE['userID'])) && (basename($_SERVER['PHP_SELF']) != 'logout.php')) {
    echo '<button><a href="logout.php">Logout</a></button>';
} else {
    echo '<button><a href="login.php">Login</a></button>';
}


include 'includes/footer.html';
?>