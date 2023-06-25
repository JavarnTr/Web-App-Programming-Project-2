<?php

if (isset($_COOKIE['userID'])) {
    echo '<form action="post.php" method="post" accept-charset="utf-8">';

    if (isset($tid) && $tid) {
        echo '<h3>Post a reply</h3>';
        echo '<input name="tid" type="hidden" value="' . $tid . '">';
    } else {
        
        echo '<h3>New Thread</h3>';
        echo '<label for="subject">Subject</label><br>';
        echo '<input name="subject" type="text" size="60" maxlength="100" value="';
        if (isset($subject)) {
            echo "value=\"$subject\"";
        }
        echo '"/><br>';
    }
    echo '<br><label for="body"><em>Body</em></label><br>
        <textarea name="body" rows="10" cols="60">';

    if (isset($body)) {
        echo $body;
    }

    echo '</textarea></p>';

    echo '<input name="submit" type="submit" value="Submit"></form>';
} else {
    echo '<p>You must be logged in to post messages.</p>';
}


?>