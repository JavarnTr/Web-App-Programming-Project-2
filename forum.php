<?php

include('includes/header.html');

if (isset($_SESSION['user_tz'])) {
    $first = "CONVERT_TZ(p.posted_on, 'UTC', '{$_SESSION['user_tz']}')";
    $last = "CONVERT_TZ(p.posted_on, 'UTC', '{$_SESSION['user_tz']}')";
} else {
    $first = 'p.posted_on';
    $last = 'p.posted_on';
}

include('includes/dbconnect.php');
$query = "SELECT t.threadID, t.subject, firstName, COUNT(postID) - 1 AS responses, MAX(DATE_FORMAT($last, '%e-%b-%y %l:%i %p')) AS last, MIN(DATE_FORMAT($first, '%e-%b-%y %l:%i %p')) AS first FROM threads AS t INNER JOIN posts AS p USING (threadID) INNER JOIN users AS u ON t.userID = u.userID GROUP BY (p.threadID) ORDER BY last DESC";
$r = mysqli_query($dbc, $query);

if (mysqli_num_rows($r) > 0) {
    echo '<table width="100%" border="0" cellspacing="2" cellpadding="2" align="center">
        <tr>
            <td align="left" width="50%"><em>Subject:</em></td>
            <td align="left" width="20%"><em>Posted By:</em></td>
            <td align="center" width="10%"><em>Date Posted On:</em></td>
            <td align="center" width="10%"><em>Replies:</em></td>
            <td align="center" width="10%"><em>Latest Reply:</em></td>
        </tr>';
        
    while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
        echo '<tr>
            <td align="left"><a href="read.php?tid=' . $row['threadID'] . '">' . $row['subject'] . '</a></td>
            <td align="left">' . $row['firstName'] . '</td>
            <td align="center">' . $row['first'] . '</td>
            <td align="center">' . $row['responses'] . '</td>
            <td align="center">' . $row['last'] . '</td>
        </tr>';
    }
    echo '</table>';
}  else {
    echo '<p>There are currently no messages in this forum.</p>';
}

include('includes/footer.html')

?>