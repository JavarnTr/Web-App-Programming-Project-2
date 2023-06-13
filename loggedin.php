<?php
if (!isset($_COOKIE['userID'])) {
    require ('includes/login_functions.inc.php');
    redirect_user();
}

$page_title = 'Logged In';
include ('includes/header.html');

echo "<h1>Logged In</h1>
    <p>You are now logged in as {$_COOKIE['firstName']}.</p>
    <p><a href=\"logout.php\">Logout</a></p>";

include ('includes/footer.html');
?>