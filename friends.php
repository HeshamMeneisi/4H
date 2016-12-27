<!-- display all requests if $_GET['r'] and display all friends if $_GET['l'] -->
<?php
include_once 'db.php';
include_once 'user.php';

if (is_logged()) {
    if (isset($_GET['r'])) {
        $uid = get_user()['uid'];
        // display all friend requests
    }
}

if (isset($_GET['l'])) {
    if (isset($_GET['uid'])) {
        $uid = $_GET['uid'];
    } elseif (is_logged()) {
        $uid = get_user()['uid'];
    } else {
        echo 'Invalid request.';
        die();
    }
    // display friend list of $uid
}
