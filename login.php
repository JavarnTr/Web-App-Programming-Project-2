<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require ('includes/login_functions.inc.php');
    require ('includes/dbconnect.php');

    list ($check, $data) = check_login($dbc, $_POST['email'], $_POST['pass']);

    if ($check) {
        setcookie ('userID', $data['userID'], time()+3600, '/', '', 0, 0);
        setcookie ('firstName', $data['firstName'], time()+3600, '/', '', 0, 0);
        redirect_user('account.php');
    } else {
        $errors = $data;
    }
    mysqli_close($dbc);
}

include ('includes/login_page.inc.php');

?>