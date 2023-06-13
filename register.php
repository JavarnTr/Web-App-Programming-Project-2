<?php
$page_title = 'Register';
include ('includes/header.html');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = array();
}

if (empty($_POST['firstName'])) {
    $errors[] = 'First name not entered.';
} else {
    $fn = trim($_POST['firstName']);
}

if (empty($_POST['lastName'])) {
    $errors[] = 'Last name not entered.';
} else {
    $ln = trim($_POST['lastName']);
}

if (empty($_POST['email'])) {
    $errors[] = 'Email address not entered.';
} else {
    $e = trim($_POST['email']);
}

if (!empty($_POST['pass1'])) {
    if ($_POST['pass1'] != $_POST['pass2']) {
        $errors[] = 'Password is incorrect.';
    } else {
        $p = trim($_POST['pass1']);
    }
} else {
    $errors[] = 'Please enter your password';
}

if (empty($errors)) {
    require ('includes/dbconnect.php');

    $q = "insert into users (firstName, lastName, email, password, registration_date) VALUES ('$fn', '$ln', '$e', SHA1('$p'), NOW() )";
    $r = @mysqli_query ($dbc, $q);
    
    if($r) {
        echo '<p>Account registered.</p>';
    } else {
        echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $q . '</p>';
    }

    mysqli_close($dbc);
    include ('includes/footer.html');
} else {
    echo '<h1>Error!</h1>
            <p class="error">The following error(s) occurred:<br />';
            foreach ($errors as $msg) {
                echo " - $msg<br />\n";
            }
            echo '</p><p>Please try again.</p><p><br /></p>';
}
?>

<h1>Register a new account</h1>
<form action="register.php" method="post">
    <p>First Name: <input type="text" name="firstName" size="15" maxlength="20" value="<?php if(isset($_POST['firstName'])) echo $_POST['firstName']; ?>" required /></p>
    <p>Last Name: <input type="text" name="lastName" size="15" maxlength="20" value="<?php if(isset($_POST['lastName'])) echo $_POST['lastName']; ?>" required /></p>
    <p>Email: <input type="text" name="email" size="15" maxlength="20" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>" required /></p>
    <p>Password: <input type="password" name="pass1" size="15" maxlength="20" value="<?php if(isset($_POST['pass1'])) echo $_POST['pass1']; ?>" required /></p>
    <p>Confirm Password: <input type="password" name="pass2" size="15" maxlength="20" value="<?php if(isset($_POST['pass2'])) echo $_POST['pass2']; ?>" required /></p>
    <p><input type="submit" name="submit" value="Register" /></p>
</form>
<?php include ('includes/footer.html'); ?>
