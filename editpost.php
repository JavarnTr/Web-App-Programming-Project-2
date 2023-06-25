<?php
include('includes/adminHeader.html');
require('includes/dbconnect.php');

if (isset($_POST['submit'])) {
    $message = $_POST['message'];
    $postID = $_POST['postID'];

    // Run the SQL query to edit the post
    $editQuery = "UPDATE posts SET message = '$message', posted_on = UTC_TIMESTAMP() WHERE postID = '$postID'";
    mysqli_query($dbc, $editQuery);
    echo '<p>post edited.</p>';
    header("Location: adminposts.php");
}

if (isset($_POST['edit_post'])) {
    $postID = $_POST['postID'];

    // Run the SQL query to retrieve the post data
    $editQuery = "SELECT * FROM posts WHERE postID = '$postID'";
    $r = mysqli_query($dbc, $editQuery);
    $row = mysqli_fetch_array($r, MYSQLI_ASSOC);
    $message = $row['message'];
    $posted_on = $row['posted_on'];
    $postID = $row['postID'];

    echo '<h1>Edit post</h1>';
    echo '<form method="post">
    <p>Message: <input type="textarea" name="message" size="60" value="' . $message . '" required></p>
    <input type="hidden" name="postID" value="' . $postID . '">
    <p><input type="submit" name="submit" value="Edit post"></p>
    </form>';
}

include('includes/footer.html');
?>
