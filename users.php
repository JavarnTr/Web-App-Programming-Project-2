<?php
include ('includes/adminHeader.html');
require ('includes/dbconnect.php');

//Retrieve all the users from the database
$query = "select * from users where admin = 0";

//Create a table for the users to be displayed in
echo '<table border="0" width="90%" cellspacing="3" cellpadding="3" align="center">
    <tr>
    <td align="left" width="20%"><b>First Name</b></td>
    <td align="left" width="20%"><b>Last Name</b></td>
    <td align="left" width="20%"><b>Email</b></td>
    <td align="left" width="20%"><b>Password</b></td>
    <td align="left" width="5%"><b>Edit</b></td>
    <td align="left" width="5%"><b>Delete</b></td>
</tr>';

//Run the query
$r = mysqli_query ($dbc, $query);

//Delete the user from the database when the delete button is clicked
if (isset($_POST['delete_user'])) {
    $userID = $_POST['userID'];
    
    // Run the SQL query to delete the product
    $deleteQuery = "DELETE FROM users WHERE userID = '$userID' and admin = 0";
    mysqli_query($dbc, $deleteQuery);
    echo '<p>User deleted.</p>';
    header("Location: ".$_SERVER['PHP_SELF']);
}

//Display the retrieved users in the table, including a form for deletion and editing.
while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
    echo "\t<tr>
    <td align=\"left\">{$row['firstName']}</td>  
    <td align=\"left\">{$row['lastName']}</td>
    <td align=\"left\">{$row['email']}</td>
    <td align=\"left\">{$row['password']}</td>   
    <td align=\"left\">
    <form method=\"post\" action='edituser.php'>
    <input type=\"hidden\" name=\"userID\" value=\"{$row['userID']}\">
    <input type=\"submit\" name=\"edit_user\" value=\"Edit User\">
    </form></td>
    
    
    <td align=\"left\">
    <form method=\"post\">
    <input type=\"hidden\" name=\"userID\" value=\"{$row['userID']}\">
    <input type=\"submit\" name=\"delete_user\" value=\"Delete User\">
    </form></td>
    </tr>\n";
}
echo '</table>';
mysqli_close($dbc);

include ('includes/footer.html');

?>