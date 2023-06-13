<?php

function redirect_user ($page = 'index.php') {
    $url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
    
    $url = rtrim($url, '/\\');
    
    $url .= '/' . $page;

    header("Location: $url");
    exit();
}

function check_login($dbc, $email = '', $pass = '') {
    $errors = array();

    if (empty($email)) {
        $errors[] = 'Email address not entered.';
    } else {
        $e = mysqli_real_escape_string($dbc, trim($email));
    }

    if (empty($pass)) {
        $errors[] = 'Password not entered.';
    } else {
        $p = mysqli_real_escape_string($dbc, trim($pass));
    }

    if (empty($errors)) {
        $q = "select userID, firstName from users where email = '$e' and password=SHA1('$p')";
        $r = @mysqli_query ($dbc, $q); 

        if (mysqli_num_rows($r) == 1) {
            $row = mysqli_fetch_array ($r, MYSQLI_ASSOC);
            return array(true, $row);
        } else {
            $errors[] = 'Account not found.';
        }
    }
    return array(false, $errors);
}

?>