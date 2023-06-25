<?php

if (!isset($_COOKIE['userID'])) {
    require ('includes/login_functions.inc.php');
    redirect_user();
} else {
    setcookie ('userID', '', time()-3600, '/', '', 0, 0);
    setcookie ('admin', '', time()-3600, '/', '', 0, 0);
}

$page_title = 'Logged Out';
include ('includes/header.html');

echo "<h1>Logged Out</h1>
    <p>You have been logged out, {$_COOKIE['firstName']}.</p>
    <button><a href='login.php'>Login</a></button>";

include ('includes/footer.html');

?>