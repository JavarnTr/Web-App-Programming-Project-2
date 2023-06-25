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

    $check_email = "SELECT * FROM users WHERE email = '$e'";
    $checked_email = mysqli_query($dbc, $check_email);

    if (mysqli_num_rows($checked_email) > 0) {
        echo '<br>Email already registered.';
    } else  {
        $admin = isset($_POST['admin']) ? 1 : 0;

        $q = "insert into users (firstName, lastName, email, password, registration_date, admin) VALUES ('$fn', '$ln', '$e', SHA1('$p'), NOW(), $admin)";
        $r = @mysqli_query ($dbc, $q);
        
        if($r) {
            echo '<p>Account registered.</p>';
        } else {
            echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $q . '</p>';
        }
    
        mysqli_close($dbc);
    }    
} 
?>

<h1>Register a new account</h1>
<form action="register.php" method="post">
    <p>First Name: <input type="text" name="firstName" size="15" maxlength="20" value="<?php if(isset($_POST['firstName'])) echo $_POST['firstName']; ?>" required /></p>
    <p>Last Name: <input type="text" name="lastName" size="15" maxlength="20" value="<?php if(isset($_POST['lastName'])) echo $_POST['lastName']; ?>" required /></p>
    <p>Email: <input type="text" name="email" size="15" maxlength="20" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>" required /></p>
    <p>Password: <input type="password" name="pass1" size="15" maxlength="20" value="<?php if(isset($_POST['pass1'])) echo $_POST['pass1']; ?>" required /></p>
    <p>Confirm Password: <input type="password" name="pass2" size="15" maxlength="20" value="<?php if(isset($_POST['pass2'])) echo $_POST['pass2']; ?>" required /></p>
    <p>Admin: <input type="checkbox" name="admin" <?php if(isset($_POST['admin'])) echo 'checked'; ?> /></p>
    <p><input type="submit" name="submit" value="Register" /></p>
</form>
<?php include ('includes/footer.html'); ?>
