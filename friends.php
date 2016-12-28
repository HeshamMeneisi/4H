<!-- display all requests if $_GET['r'] and display all friends if $_GET['l'] -->
<?php
if (!isset($_GET['aj'])):
 ?>
 <script src="js/friends.js"></script>
 <container id='friends'>
<?php
endif;
include_once 'db.php';
include_once 'user.php';
include_once 'hud.php';
if (is_logged()) {
    $list_friends = isset($_GET['l']);
    if (isset($_GET['r'])) {
        $uid = get_user()['uid'];
        // display all friend requests
        $requests = fetch_sent_requests($pdo);
        if ($requests) {
            echo '<br/><br/><hr><h3 style="margin-bottom:-10px;">Friend requests</h3>';
            echo '<br/><br/>Your pending requests.';
            foreach ($requests as $request) {
                $_GET['person'] = $request;
                include 'person.php';
                echo "<button id='cancelReq' onclick='cancel_freq({$request['uid']},{$list_friends})'>Cancel</button>";
            }
        }
        $requests = fetch_friend_requests($pdo);
        if ($requests) {
            echo '<br/><br/>Those people want to be your friend!';
            foreach ($requests as $request) {
                $_GET['person'] = $request;
                include 'person.php';
                echo "<button id='accReq' onclick='accept_freq({$request['uid']},{$list_friends})'>Accept</button>";
                echo "<button id='rejReq' onclick='reject_freq({$request['uid']},{$list_friends})'>Reject</button>";
            }
        } else {
            //No friends
            echo '<center><h3>Oops! You have no friends,yet!</h3></center>';
        }
    } else {
        echo 'Error retrieving requests.';
    }
}

if ($list_friends) {
    if (isset($_GET['uid'])) {
        $uid = $_GET['uid'];
    } elseif (is_logged()) {
        $uid = get_user()['uid'];
    } else {
        echo 'Invalid request.';
        die();
    }
    // display friend list of $uid
    $friends = fetch_friends($uid, $pdo);
    if ($friends) {
        echo '<br/><br/><hr><h3 style="margin-bottom:-10px;">Friends</h3>';
        foreach ($friends as $friend) {
            $_GET['person'] = $friend;
            include 'person.php';
        }
    }
}

if (!isset($_GET['aj'])) {
    echo '</container>';
}
