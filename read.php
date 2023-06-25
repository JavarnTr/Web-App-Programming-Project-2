<?php
include('includes/header.html');
include('includes/dbconnect.php');
$tid = FALSE;

//Check for a thread ID so that the correct posts will be retrieved from the database
if (isset($_GET['tid']) && filter_var($_GET['tid'], FILTER_VALIDATE_INT, array('min_range' => 1))) {
    $tid = $_GET['tid'];

    if (isset($_SESSION['user_tz'])) {
        $posted = "CONVERT_TZ(p.posted_on, 'UTC', '{$_SESSION['user_tz']}')";
    } else {
        $posted = 'p.posted_on';
    }

    $q = "SELECT t.subject, p.message, firstName, DATE_FORMAT($posted, '%e-%b-%y %l:%i %p') AS posted, p.userID, p.postID FROM threads AS t INNER JOIN posts AS p USING (threadID) INNER JOIN users AS u ON p.userID = u.userID WHERE t.threadID = $tid ORDER BY p.posted_on ASC";
    $r = mysqli_query($dbc, $q);

    if (!(mysqli_num_rows($r) > 0)) {
        $tid = FALSE;
    }
}

//When the delete button is clicked, the post will be deleted from the database
if (isset($_POST['delete'])) {
    $postID = $_POST['postID'];
    $query = "DELETE FROM posts WHERE postID = $postID";
    $result = mysqli_query($dbc, $query);

    if (mysqli_affected_rows($dbc) == 1) {
        header("Location: read.php?tid=$tid");
    } else {
        echo '<p>Your post could not be deleted due to a system error.</p>';
    }
}

//If the thread ID exists, the posts will be displayed
if ($tid) {
    $printed = FALSE;

    while ($messages = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
        if (!$printed) {
            echo "<h2>{$messages['subject']}</h2>\n";
            $printed = TRUE;
        }

        echo "<p>{$messages['firstName']} ({$messages['posted']})<br>{$messages['message']}";

        // Check if the current message belongs to the logged in user
        if (isset($_COOKIE['userID'])) {
            if ($messages['userID'] == $_COOKIE['userID']) {
                echo '<form action="" method="post">
                          <input type="hidden" name="postID" value="' . $messages['postID'] . '">
                          <input type="submit" name="delete" value="Delete">
                      </form>';
            }
            echo "</p><br>\n";
        }
            
        
        

        
    }
    
    include('includes/post_form.php');
} else {
    echo '<p>An error was encountered.</p>';
}

include('includes/footer.html');
?>
