<?php
include ('includes/adminHeader.html');
require ('includes/dbconnect.php');

//Retrieve the post and thread data from the database.
$query = "select * from posts inner join users on posts.userID = users.userID inner join threads on posts.threadID = threads.threadID";

//Create a table to display the data.
echo '<table border="0" width="90%" cellspacing="3" cellpadding="3" align="center">
    <tr>
    <td align="left" width="20%"><b>Post ID</b></td>
    <td align="left" width="20%"><b>Subject</b></td>
    <td align="left" width="20%"><b>Message</b></td>
    <td align="left" width="20%"><b>Date Posted</b></td>
    <td align="left" width="10%"><b>Posted By</b></td>
</tr>';

//Run the query.
$r = mysqli_query ($dbc, $query);

//If the delete button has been clicked, delete the post.
if (isset($_POST['delete_post'])) {
    $postID = $_POST['postID'];
    
    // Run the SQL query to delete the product
    $deleteQuery = "DELETE FROM posts WHERE postID = '$postID'";
    mysqli_query($dbc, $deleteQuery);
    echo '<p>Post deleted.</p>';
    header("Location: ".$_SERVER['PHP_SELF']);
}

//Display the retrieved data.
while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
    echo "\t<tr>
    <td align=\"left\">{$row['postID']}</td>
    <td align=\"left\">{$row['subject']}</td>  
    <td align=\"left\">{$row['message']}</td>
    <td align=\"left\">{$row['posted_on']}</td>
    <td align=\"left\">{$row['firstName']} {$row['lastName']}</td>
    <td align=\"left\">
    <form method=\"post\" action='editpost.php'>
    <input type=\"hidden\" name=\"postID\" value=\"{$row['postID']}\">
    <input type=\"submit\" name=\"edit_post\" value=\"Edit post\">
    </form></td>
    
    
    <td align=\"left\">
    <form method=\"post\">
    <input type=\"hidden\" name=\"postID\" value=\"{$row['postID']}\">
    <input type=\"submit\" name=\"delete_post\" value=\"Delete post\">
    </form></td>
    </tr>\n";
}
echo '</table>';
//Close the database connection.
mysqli_close($dbc);

include ('includes/footer.html');

?>